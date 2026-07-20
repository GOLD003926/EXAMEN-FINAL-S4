<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ComptesModel;
use App\Models\TransactionsModel;
use App\Models\FraisOperationsModel;
use App\Controllers\Operator\PrefixController;
use App\Models\OperateursModel;

// SUPPOSITION: TransactionsModel a les nouveaux champs:
// - id_operateur_destinataire (FK vers operateurs)
// - commission (montant de la commission pour transferts externes)
// - inclure_frais_retrait (booléen pour inclure frais de retrait anticipé)
// - batch_id (pour regrouper les envois multiples)

class TransferController extends BaseController
{
    private ComptesModel $comptesModel;
    private TransactionsModel $transactionsModel;
    private FraisOperationsModel $fraisOperationsModel;
    private PrefixController $prefixController;
    private OperateursModel $operateursModel;

    public function __construct()
    {
        $this->comptesModel = new ComptesModel();
        $this->transactionsModel = new TransactionsModel();
        $this->fraisOperationsModel = new FraisOperationsModel();
        $this->prefixController = new PrefixController();
        $this->operateursModel = new OperateursModel();
    }

    public function index()
    {
        $numero = session('numero');
        $solde = $this->comptesModel->getSolde($numero);

        return view('client/transfer', ['numero' => $numero, 'solde' => $solde]);
    }

    public function create()
    {
        $data = $this->request->getJSON();
        $numero = session('numero');

        if (!isset($data->montant) || !is_numeric($data->montant) || $data->montant <= 0) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Le montant doit être un nombre positif']);
        }
        if (!isset($data->destinataire) || empty($data->destinataire)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Le numéro du destinataire est requis']);
        }

        $montant = floatval($data->montant);
        $destinataire = $data->destinataire;
        $inclureFraisRetrait = $data->inclure_frais_retrait ?? false; // SUPPOSITION: checkbox envoyée depuis le front

        if (!preg_match('/^\d{10}$/', $destinataire)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Le numéro du destinataire doit contenir 10 chiffres']);
        }
        if ($destinataire === $numero) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Vous ne pouvez pas transférer à votre propre numéro']);
        }

        // Récupérer les comptes
        $compteSource = $this->comptesModel->where('numero', $numero)->first();
        $compteDest   = $this->comptesModel->where('numero', $destinataire)->first();

        if (!$compteSource) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Compte source non trouvé']);
        }
        if (!$compteDest) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Le destinataire n\'existe pas']);
        }

        $soldeActuel = $compteSource['solde'];

        // RÉSOLUTION DE L'OPÉRATEUR DU DESTINATAIRE
        $operateurDestinataire = $this->prefixController->resolveOperateur($destinataire);
        
        if (!$operateurDestinataire) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Préfixe du destinataire non reconnu']);
        }

        $estInterne = ($operateurDestinataire['est_interne'] == 1);
        $commission = 0;
        $fraisRetraitAnticipe = 0;

        // CALCUL DES FRAIS ET COMMISSIONS
        $fraisTransfert = $this->fraisOperationsModel->calculerFrais($montant, 3); // Type 3 = Transfert
        
        if ($estInterne) {
            // TRANSFERT INTERNE
            if ($inclureFraisRetrait) {
                // Ajouter les frais de retrait anticipé (même montant que frais de transfert)
                $fraisRetraitAnticipe = $fraisTransfert;
            }
            $totalADebiter = $montant + $fraisTransfert + $fraisRetraitAnticipe;
            $gain = $fraisTransfert; // Gain = frais de transfert
        } else {
            // TRANSFERT EXTERNE
            // Calculer la commission selon le taux de l'opérateur externe
            $commission = $montant * ($operateurDestinataire['taux_commission'] / 100);
            $totalADebiter = $montant + $fraisTransfert + $commission;
            $gain = $fraisTransfert + $commission; // Gain = frais + commission
        }

        // Vérification du solde
        if ($totalADebiter > $soldeActuel) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Solde insuffisant (Total: ' . number_format($totalADebiter, 0, ',', ' ') . ' Ar)']);
        }

        // MISE À JOUR DES COMPTES
        $this->comptesModel->update($compteSource['id'], [
            'solde' => $soldeActuel - $totalADebiter,
            'update_at' => date('Y-m-d H:i:s'),
        ]);
        
        // Pour les transferts internes, le destinataire reçoit le montant
        // Pour les transferts externes, on ne met pas à jour le solde du destinataire (sera géré par l'autre opérateur)
        if ($estInterne) {
            $this->comptesModel->update($compteDest['id'], [
                'solde' => $compteDest['solde'] + $montant,
                'update_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // CRÉATION DE LA TRANSACTION
        $transactionData = [
            'id_compte' => $compteSource['id'],
            'id_type_operation' => 3, // Transfert
            'numero_source' => $numero,
            'numero_destinataire' => $destinataire,
            'somme' => $montant,
            'gain' => $gain,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Ajouter les champs spécifiques Version 2
        if (!$estInterne) {
            $transactionData['id_operateur_destinataire'] = $operateurDestinataire['id'];
            $transactionData['commission'] = $commission;
        }
        if ($estInterne && $inclureFraisRetrait) {
            $transactionData['inclure_frais_retrait'] = 1;
        }

        $this->transactionsModel->insert($transactionData);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Transfert de ' . number_format($montant, 0, ',', ' ') . ' Ar vers ' . $destinataire . ' effectué avec succès',
            'montant' => $montant,
            'destinataire' => $destinataire,
            'frais' => $fraisTransfert,
            'commission' => $commission,
            'frais_retrait_anticipé' => $fraisRetraitAnticipe,
            'total_debite' => $totalADebiter,
            'nouveau_solde' => $soldeActuel - $totalADebiter,
            'est_interne' => $estInterne
        ]);
    }

    // ENVOI MULTIPLE (uniquement pour destinataires internes)
    public function createMultiple()
    {
        $data = $this->request->getJSON();
        $numero = session('numero');

        if (!isset($data->montant_total) || !is_numeric($data->montant_total) || $data->montant_total <= 0) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Le montant total doit être un nombre positif']);
        }
        if (!isset($data->destinataires) || !is_array($data->destinataires) || empty($data->destinataires)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'La liste des destinataires est requise']);
        }

        $montantTotal = floatval($data->montant_total);
        $destinataires = $data->destinataires;
        $inclureFraisRetrait = $data->inclure_frais_retrait ?? false;

        // Générer un batch_id pour regrouper ces transactions
        $batchId = uniqid('batch_');

        // Vérifier que tous les destinataires sont internes
        foreach ($destinataires as $destinataire) {
            if (!preg_match('/^\d{10}$/', $destinataire)) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Le numéro ' . $destinataire . ' est invalide']);
            }
            if ($destinataire === $numero) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Vous ne pouvez pas vous inclure dans les destinataires']);
            }

            $operateur = $this->prefixController->resolveOperateur($destinataire);
            if (!$operateur || $operateur['est_interne'] != 1) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'L\'envoi multiple n\'est disponible que pour les destinataires internes. Le numéro ' . $destinataire . ' est externe']);
            }
        }

        $compteSource = $this->comptesModel->where('numero', $numero)->first();
        if (!$compteSource) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Compte source non trouvé']);
        }

        $soldeActuel = $compteSource['solde'];
        $nombreDestinataires = count($destinataires);
        $montantParDestinataire = $montantTotal / $nombreDestinataires;

        // Calculer les frais totaux
        $fraisTransfertParDestinataire = $this->fraisOperationsModel->calculerFrais($montantParDestinataire, 3);
        $totalFraisTransfert = $fraisTransfertParDestinataire * $nombreDestinataires;
        
        $totalFraisRetraitAnticipe = 0;
        if ($inclureFraisRetrait) {
            $totalFraisRetraitAnticipe = $fraisTransfertParDestinataire * $nombreDestinataires;
        }

        $totalADebiter = $montantTotal + $totalFraisTransfert + $totalFraisRetraitAnticipe;

        if ($totalADebiter > $soldeActuel) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Solde insuffisant (Total: ' . number_format($totalADebiter, 0, ',', ' ') . ' Ar)']);
        }

        // Débiter le compte source
        $this->comptesModel->update($compteSource['id'], [
            'solde' => $soldeActuel - $totalADebiter,
            'update_at' => date('Y-m-d H:i:s'),
        ]);

        // Créer les transactions pour chaque destinataire
        $transactionsCrees = [];
        foreach ($destinataires as $destinataire) {
            $compteDest = $this->comptesModel->where('numero', $destinataire)->first();
            if ($compteDest) {
                // Créditer le destinataire
                $this->comptesModel->update($compteDest['id'], [
                    'solde' => $compteDest['solde'] + $montantParDestinataire,
                    'update_at' => date('Y-m-d H:i:s'),
                ]);

                // Créer la transaction
                $transactionId = $this->transactionsModel->insert([
                    'id_compte' => $compteSource['id'],
                    'id_type_operation' => 3,
                    'numero_source' => $numero,
                    'numero_destinataire' => $destinataire,
                    'somme' => $montantParDestinataire,
                    'gain' => $fraisTransfertParDestinataire,
                    'batch_id' => $batchId,
                    'inclure_frais_retrait' => $inclureFraisRetrait ? 1 : 0,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                $transactionsCrees[] = [
                    'id' => $transactionId,
                    'destinataire' => $destinataire,
                    'montant' => $montantParDestinataire
                ];
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Envoi multiple effectué avec succès (' . $nombreDestinataires . ' destinataires)',
            'batch_id' => $batchId,
            'nombre_destinataires' => $nombreDestinataires,
            'montant_par_destinataire' => $montantParDestinataire,
            'total_frais' => $totalFraisTransfert,
            'total_debite' => $totalADebiter,
            'nouveau_solde' => $soldeActuel - $totalADebiter,
            'transactions' => $transactionsCrees
        ]);
    }
}