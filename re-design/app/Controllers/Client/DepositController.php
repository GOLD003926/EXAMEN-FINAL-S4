<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ComptesModel;
use App\Models\TransactionsModel;
use App\Models\TypeOperationsModel;

class DepositController extends BaseController
{
    private ComptesModel $comptesModel;
    private TransactionsModel $transactionsModel;

    public function __construct()
    {
        $this->comptesModel      = new ComptesModel();
        $this->transactionsModel = new TransactionsModel();
    }

    public function index()
    {
        $numero = session('numero');

        return view('client/deposit', [
            'numero' => $numero
        ]);
    }

    public function create()
    {
        $data   = $this->request->getJSON();
        $numero = session('numero');

        if (!isset($data->montant) || !is_numeric($data->montant) || $data->montant <= 0) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Le montant doit être un nombre positif'
            ]);
        }

        $montant = floatval($data->montant);
        $compte  = $this->comptesModel->where('numero', $numero)->first();

        if (!$compte) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Compte non trouvé'
            ]);
        }

        $nouveauSolde = $compte['solde'] + $montant;

        // Mise à jour du solde du compte
        $this->comptesModel->update($compte['id'], [
            'solde'     => $nouveauSolde,
            'update_at' => date('Y-m-d H:i:s'),
        ]);

        // Enregistrement de la transaction (dépôt sans frais, gain nul)
        $this->transactionsModel->insert([
            'id_compte'           => $compte['id'],
            'id_type_operation'   => TypeOperationsModel::TYPE_DEPOT,
            'numero_source'       => $numero,
            'numero_destinataire' => null,
            'somme'               => $montant,
            'gain'                => 0,
            'created_at'          => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON([
            'success'       => true,
            'message'       => 'Dépôt de ' . number_format($montant, 0, ',', ' ') . ' Ar effectué avec succès',
            'nouveau_solde' => $nouveauSolde
        ]);
    }
}