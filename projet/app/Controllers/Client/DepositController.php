<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Services\FakeDataService;

class DepositController extends BaseController
{
    private $fakeDataService;

    public function __construct()
    {
        $this->fakeDataService = new FakeDataService();
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
        $data = $this->request->getJSON();
        $numero = session('numero');
        
        // Validation
        if (!isset($data->montant) || !is_numeric($data->montant) || $data->montant <= 0) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Le montant doit être un nombre positif']);
        }

        $montant = floatval($data->montant);
        
        // In a real application, we would process the deposit
        // For now, just return success
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Dépôt de ' . number_format($montant, 0, ',', ' ') . ' Ar effectué avec succès',
            'nouveau_solde' => $this->fakeDataService->getSolde($numero) + $montant
        ]);
    }
}
