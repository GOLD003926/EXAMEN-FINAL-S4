<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ComptesModel;
use App\Models\TransactionsModel;
use App\Models\FraisOperationsModel;
use App\Models\TypeOperationsModel;
use App\Controllers\Operator\PrefixController;
use App\Models\OperateursModel;

class TransferController extends BaseController
{
    private ComptesModel $comptesModel;
    private TransactionsModel $transactionsModel;
    private FraisOperationsModel $fraisOperationsModel;
    private TypeOperationsModel $typeOperationsModel;
    private PrefixController $prefixController;
    private OperateursModel $operateursModel;

    public function __construct()
    {
        $this->comptesModel = new ComptesModel();
        $this->transactionsModel = new TransactionsModel();
        $this->fraisOperationsModel = new FraisOperationsModel();
        $this->typeOperationsModel = new TypeOperationsModel();
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
        $inclureFraisRetrait = $data->inclure_frais_retrait ?? false;

        if (!preg_match('/^\d{10}$/', $destinataire)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Le numéro du destinataire doit contenir 10 chiffres']);
        }
        if ($destinataire === $numero) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Vous ne pouvez pas transférer à votre propre numéro']);
        }

        // Récupérer les comptes source et destinataire
        $compteSource = $this->comptesModel->where('numero', $numero)->first();
        $compteDest   = $this->comptesModel->where('numero', $destinataire)->first();

        if (!$compteSource) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Compte source non trouvé']);
        }
        if (!$compteDest) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Le destinataire n\'existe pas']);
        }

        $soldeActuel = $compteSource['solde'];

        // Détermination de l'opérateur du destinataire
        $operateurDestinataire = $this->prefixController->resolveOperateur($destinataire);
        
        if (!$operateurDestinataire) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Préfixe du destinataire non reconnu']);
        }

        $estInterne = ($operateurDestinataire['est_interne'] == 1);
        $commission = 0;
        $fraisRetraitAnticipe = 0;

        // Calcul des frais et commissions
        $fraisTransfert = $this->fraisOperationsModel->calculerFrais($montant, TypeOperationsModel::TYPE_TRANSFERT);
        
        if ($estInterne) {
            // Transfert interne
            if ($inclureFraisRetrait) {
                // Ajouter les frais de retrait anticipé (même montant que les frais de transfert)
                $fraisRetraitAnticipe = $fraisTransfert;
            }
            $totalADebiter = $montant + $fraisTransfert + $fraisRetraitAnticipe;
            $gain = $fraisTransfert; // Le gain correspond aux frais de transfert
        } else {
            // Transfert externe
            // Calculer la commission selon le taux de l'opérateur externe
            $commission = $montant * ($operateurDestinataire['taux_commission'] / 100);
            $totalADebiter = $montant + $fraisTransfert + $commission;
            $gain = $fraisTransfert + $commission; // Le gain correspond aux frais plus la commission
        }

        // Vérification du solde disponible
        if ($totalADebiter > $soldeActuel) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Solde insuffisant (Total: ' . number_format($totalADebiter, 0, ',', ' ') . ' Ar)']);
        }

        // Mise à jour des comptes
        $this->comptesModel->update($compteSource['id'], [
            'solde' => $soldeActuel - $totalADebiter,
            'update_at' => date('Y-m-d H:i:s'),
        ]);
        
        // Pour les transferts internes, le destinataire reçoit le montant
        // Pour les transferts externes, le solde du destinataire n'est pas mis à jour (sera géré par l'autre opérateur)
        if ($estInterne) {
            $this->comptesModel->update($compteDest['id'], [
                'solde' => $compteDest['solde'] + $montant,
                'update_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // Création de la transaction
        $transactionData = [
            'id_compte' => $compteSource['id'],
            'id_type_operation' => TypeOperationsModel::TYPE_TRANSFERT,
            'numero_source' => $numero,
            'numero_destinataire' => $destinataire,
            'somme' => $montant,
            'gain' => $gain,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Ajouter les champs spécifiques pour la version 2
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

    // Envoi multiple (destinataires internes et externes acceptés)
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

        // Générer un identifiant de batch pour regrouper ces transactions
        $batchId = uniqid('batch_');

        // Valider les destinataires et identifier les opérateurs
        $destinatairesInfo = [];
        foreach ($destinataires as $destinataire) {
            if (!preg_match('/^\d{10}$/', $destinataire)) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Le numéro ' . $destinataire . ' est invalide']);
            }
            if ($destinataire === $numero) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Vous ne pouvez pas vous inclure dans les destinataires']);
            }

            $operateur = $this->prefixController->resolveOperateur($destinataire);
            if (!$operateur) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Préfixe du numéro ' . $destinataire . ' non reconnu']);
            }

            $destinatairesInfo[] = [
                'numero' => $destinataire,
                'operateur' => $operateur,
                'est_interne' => ($operateur['est_interne'] == 1)
            ];
        }

        $compteSource = $this->comptesModel->where('numero', $numero)->first();
        if (!$compteSource) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Compte source non trouvé']);
        }

        $soldeActuel = $compteSource['solde'];
        $nombreDestinataires = count($destinataires);
        $montantParDestinataire = $montantTotal / $nombreDestinataires;

        // Calculer les frais totaux et commissions
        $totalFraisTransfert = 0;
        $totalCommission = 0;
        $totalFraisRetraitAnticipe = 0;

        foreach ($destinatairesInfo as $destInfo) {
            $fraisTransfert = $this->fraisOperationsModel->calculerFrais($montantParDestinataire, TypeOperationsModel::TYPE_TRANSFERT);
            $totalFraisTransfert += $fraisTransfert;

            if (!$destInfo['est_interne']) {
                // Transfert externe : ajouter la commission
                $commission = $montantParDestinataire * ($destInfo['operateur']['taux_commission'] / 100);
                $totalCommission += $commission;
            }

            if ($inclureFraisRetrait && $destInfo['est_interne']) {
                // Frais de retrait anticipé uniquement pour les destinataires internes
                $totalFraisRetraitAnticipe += $fraisTransfert;
            }
        }

        $totalADebiter = $montantTotal + $totalFraisTransfert + $totalCommission + $totalFraisRetraitAnticipe;

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
        foreach ($destinatairesInfo as $destInfo) {
            $destinataire = $destInfo['numero'];
            $estInterne = $destInfo['est_interne'];
            $operateur = $destInfo['operateur'];

            // Calculer les frais pour ce destinataire
            $fraisTransfert = $this->fraisOperationsModel->calculerFrais($montantParDestinataire, TypeOperationsModel::TYPE_TRANSFERT);
            $commission = 0;
            $gain = $fraisTransfert;

            if (!$estInterne) {
                // Transfert externe : calculer la commission
                $commission = $montantParDestinataire * ($operateur['taux_commission'] / 100);
                $gain = $fraisTransfert + $commission;
            }

            $fraisRetraitAnticipe = ($inclureFraisRetrait && $estInterne) ? $fraisTransfert : 0;

            // Créer les données de transaction
            $transactionData = [
                'id_compte' => $compteSource['id'],
                'id_type_operation' => TypeOperationsModel::TYPE_TRANSFERT,
                'numero_source' => $numero,
                'numero_destinataire' => $destinataire,
                'somme' => $montantParDestinataire,
                'gain' => $gain,
                'batch_id' => $batchId,
                'inclure_frais_retrait' => $inclureFraisRetrait ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            if (!$estInterne) {
                // Ajouter les champs spécifiques aux transferts externes
                $transactionData['id_operateur_destinataire'] = $operateur['id'];
                $transactionData['commission'] = $commission;
            }

            $transactionId = $this->transactionsModel->insert($transactionData);

            if ($estInterne) {
                // Créditer le compte destinataire interne
                $compteDest = $this->comptesModel->where('numero', $destinataire)->first();
                if ($compteDest) {
                    $this->comptesModel->update($compteDest['id'], [
                        'solde' => $compteDest['solde'] + $montantParDestinataire,
                        'update_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }

            $transactionsCrees[] = [
                'id' => $transactionId,
                'destinataire' => $destinataire,
                'montant' => $montantParDestinataire,
                'est_interne' => $estInterne,
                'operateur' => $operateur['nom']
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Envoi multiple effectué avec succès (' . $nombreDestinataires . ' destinataires)',
            'batch_id' => $batchId,
            'nombre_destinataires' => $nombreDestinataires,
            'montant_par_destinataire' => $montantParDestinataire,
            'total_frais' => $totalFraisTransfert,
            'total_commission' => $totalCommission,
            'total_frais_retrait' => $totalFraisRetraitAnticipe,
            'total_debite' => $totalADebiter,
            'nouveau_solde' => $soldeActuel - $totalADebiter,
            'transactions' => $transactionsCrees
        ]);
    }
}