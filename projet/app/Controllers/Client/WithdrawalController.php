<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Services\FakeDataService;

class WithdrawalController extends BaseController
{
    private $fakeDataService;

    public function __construct()
    {
        $this->fakeDataService = new FakeDataService();
    }

    public function index()
    {
        $numero = session('numero');
        $solde = $this->fakeDataService->getSolde($numero);
        
        return view('client/withdrawal', [
            'numero' => $numero,
            'solde' => $solde
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
        $soldeActuel = $this->fakeDataService->getSolde($numero);
        
        // Check if sufficient balance
        if ($montant > $soldeActuel) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Solde insuffisant']);
        }

        // Calculate fee
        $frais = $this->fakeDataService->calculateFee($montant, 2); // Type 2 = Retrait
        $total = $montant + $frais;
        
        if ($total > $soldeActuel) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Solde insuffisant (incluant les frais de ' . $frais . ' Ar)']);
        }

        // In a real application, we would process the withdrawal
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Retrait de ' . number_format($montant, 0, ',', ' ') . ' Ar effectué avec succès (Frais: ' . $frais . ' Ar)',
            'montant' => $montant,
            'frais' => $frais,
            'nouveau_solde' => $soldeActuel - $total
        ]);
    }
}
