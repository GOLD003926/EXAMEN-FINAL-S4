<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Services\FakeDataService;

class ClientAccountController extends BaseController
{
    private $fakeDataService;

    public function __construct()
    {
        $this->fakeDataService = new FakeDataService();
    }

    public function index()
    {
        $comptes = $this->fakeDataService->getComptes();
        $etats = $this->fakeDataService->getEtatsCompte();

        // Add state label to each account
        foreach ($comptes as &$compte) {
            foreach ($etats as $etat) {
                if ($compte['id_etat'] == $etat['id']) {
                    $compte['etat_libelle'] = $etat['libelle'];
                    break;
                }
            }
        }

        return view('operator/clientAccount', ['comptes' => $comptes, 'etats' => $etats]);
    }

    public function view($numero)
    {
        $comptes = $this->fakeDataService->getComptes();
        $compte = null;
        foreach ($comptes as $c) {
            if ($c['numero'] === $numero) {
                $compte = $c;
                break;
            }
        }

        if (!$compte) {
            return redirect()->to('/operator/comptes')->with('error', 'Compte non trouvé');
        }

        $transactions = $this->fakeDataService->getTransactions($numero);
        $etats = $this->fakeDataService->getEtatsCompte();

        foreach ($etats as $etat) {
            if ($compte['id_etat'] == $etat['id']) {
                $compte['etat_libelle'] = $etat['libelle'];
                break;
            }
        }

        return view('operator/clientAccountDetail', [
            'compte' => $compte,
            'transactions' => $transactions
        ]);
    }

    public function updateState()
    {
        $data = $this->request->getJSON();
        
        if (!isset($data->numero) || !isset($data->id_etat)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Données invalides']);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'État du compte mis à jour avec succès']);
    }
}
