<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ComptesModel;
use App\Models\FraisOperationsModel;
use App\Models\TransactionsModel;
use App\Models\TypeOperationsModel;

class WithdrawalController extends BaseController
{
    private $comptesModel;
    private $fraisOperationsModel;
    private $transactionsModel;

    public function __construct()
    {
        $this->comptesModel = new ComptesModel();
        $this->fraisOperationsModel = new FraisOperationsModel();
        $this->transactionsModel = new TransactionsModel();
    }

    public function index()
    {
        $numero = session('numero');
        $solde = $this->comptesModel->getSolde($numero);

        return view('client/withdrawal', [
            'numero' => $numero,
            'solde' => $solde
        ]);
    }

    public function create()
    {
        $data   = $this->request->getJSON();
        $numero = session('numero');

        if (!isset($data->montant) || !is_numeric($data->montant) || $data->montant <= 0) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Le montant doit être un nombre positif']);
        }

        $montant = floatval($data->montant);
        $compte  = $this->comptesModel->where('numero', $numero)->first();

        if (!$compte) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Compte non trouvé']);
        }

        $soldeActuel = $compte['solde'];

        if ($montant > $soldeActuel) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Solde insuffisant']);
        }

        $frais = $this->fraisOperationsModel->calculerFrais($montant, TypeOperationsModel::TYPE_RETRAIT);
        $total = $montant + $frais;

        if ($total > $soldeActuel) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Solde insuffisant (incluant les frais de ' . $frais . ' Ar)']);
        }

        $nouveauSolde = $soldeActuel - $total;

        // Mise à jour du solde du compte
        $this->comptesModel->update($compte['id'], [
            'solde'     => $nouveauSolde,
            'update_at' => date('Y-m-d H:i:s'),
        ]);

        // Enregistrement de la transaction (le gain correspond aux frais collectés)
        $this->transactionsModel->insert([
            'id_compte'           => $compte['id'],
            'id_type_operation'   => TypeOperationsModel::TYPE_RETRAIT,
            'numero_source'       => $numero,
            'numero_destinataire' => null,
            'somme'               => $montant,
            'gain'                => $frais,
            'created_at'          => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON([
            'success'       => true,
            'message'       => 'Retrait de ' . number_format($montant, 0, ',', ' ') . ' Ar effectué avec succès (Frais: ' . $frais . ' Ar)',
            'montant'       => $montant,
            'frais'         => $frais,
            'nouveau_solde' => $nouveauSolde
        ]);
    }
}
