<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\ComptesModel;
use App\Models\EtatCompteModel;
use App\Models\TransactionsModel;

class ClientAccountController extends BaseController
{
    private ComptesModel $comptesModel;
    private EtatCompteModel $etatCompteModel;
    private TransactionsModel $transactionsModel;

    public function __construct()
    {
        $this->comptesModel      = new ComptesModel();
        $this->etatCompteModel   = new EtatCompteModel();
        $this->transactionsModel = new TransactionsModel();
    }

    public function index()
    {
        $comptes = $this->comptesModel->getComptesWithEtat();
        $etats   = $this->etatCompteModel->findAll();

        return view('operator/clientAccount', [
            'comptes' => $comptes,
            'etats'   => $etats,
        ]);
    }

    public function view($numero)
    {
        $compte = $this->comptesModel->getCompteByNumero($numero);

        if (!$compte) {
            return redirect()->to('/operator/comptes')->with('error', 'Compte non trouvé');
        }

        $transactions = $this->transactionsModel->getTransactionsByNumero($numero);

        return view('operator/clientAccountDetail', [
            'compte'       => $compte,
            'transactions' => $transactions,
        ]);
    }

    public function updateState()
    {
        $data = $this->request->getJSON();

        if (!isset($data->numero) || !isset($data->id_etat)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Données invalides',
            ]);
        }

        $compte = $this->comptesModel->where('numero', $data->numero)->first();

        if (!$compte) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Compte non trouvé',
            ]);
        }

        $etat = $this->etatCompteModel->find($data->id_etat);
        if (!$etat) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'État de compte invalide',
            ]);
        }

        $updated = $this->comptesModel->update($compte['id'], [
            'id_etat'   => $data->id_etat,
            'update_at' => date('Y-m-d H:i:s'),
        ]);

        if (!$updated) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Échec de la mise à jour',
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'État du compte mis à jour avec succès',
        ]);
    }
}