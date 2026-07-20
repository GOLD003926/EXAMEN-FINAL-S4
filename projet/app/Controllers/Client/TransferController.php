<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ComptesModel;
use App\Models\TransactionsModel;
use App\Models\FraisOperationsModel;

class TransferController extends BaseController
{
    private ComptesModel $comptesModel;
    private TransactionsModel $transactionsModel;
    private FraisOperationsModel $fraisOperationsModel;

    public function __construct()
    {
        $this->comptesModel = new ComptesModel();
        $this->transactionsModel = new TransactionsModel();
        $this->fraisOperationsModel = new FraisOperationsModel();
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

        if (!preg_match('/^\d{10}$/', $destinataire)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Le numéro du destinataire doit contenir 10 chiffres']);
        }
        if ($destinataire === $numero) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Vous ne pouvez pas transférer à votre propre numéro']);
        }

        $compteSource = $this->comptesModel->where('numero', $numero)->first();
        $compteDest   = $this->comptesModel->where('numero', $destinataire)->first();

        if (!$compteSource) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Compte source non trouvé']);
        }
        // Bug corrigé : le destinataire doit exister en base
        if (!$compteDest) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Le destinataire n\'existe pas']);
        }

        $soldeActuel = $compteSource['solde'];

        if ($montant > $soldeActuel) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Solde insuffisant']);
        }

        $frais = $this->fraisOperationsModel->calculerFrais($montant, 3); // Type 3 = Transfert
        $total = $montant + $frais;

        if ($total > $soldeActuel) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Solde insuffisant (incluant les frais de ' . $frais . ' Ar)']);
        }

        // Mise à jour des DEUX comptes
        $this->comptesModel->update($compteSource['id'], [
            'solde' => $soldeActuel - $total,
            'update_at' => date('Y-m-d H:i:s'),
        ]);
        $this->comptesModel->update($compteDest['id'], [
            'solde' => $compteDest['solde'] + $montant,
            'update_at' => date('Y-m-d H:i:s'),
        ]);

        // Transaction (gain = frais collecté par l'opérateur)
        $this->transactionsModel->insert([
            'id_compte' => $compteSource['id'],
            'id_type_operation' => 3, // Transfert
            'numero_source' => $numero,
            'numero_destinataire' => $destinataire,
            'somme' => $montant,
            'gain' => $frais,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Transfert de ' . number_format($montant, 0, ',', ' ') . ' Ar vers ' . $destinataire . ' effectué avec succès (Frais: ' . $frais . ' Ar)',
            'montant' => $montant,
            'destinataire' => $destinataire,
            'frais' => $frais,
            'nouveau_solde' => $soldeActuel - $total
        ]);
    }
}