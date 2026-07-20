<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Services\FakeDataService;

class TransferController extends BaseController
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
        
        return view('client/transfer', [
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

        if (!isset($data->destinataire) || empty($data->destinataire)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Le numéro du destinataire est requis']);
        }

        $montant = floatval($data->montant);
        $destinataire = $data->destinataire;
        $soldeActuel = $this->fakeDataService->getSolde($numero);
        
        // Validate destinataire format
        if (!preg_match('/^\d{10}$/', $destinataire)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Le numéro du destinataire doit contenir 10 chiffres']);
        }

        // Check if transferring to self
        if ($destinataire === $numero) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Vous ne pouvez pas transférer à votre propre numéro']);
        }

        // Check if sufficient balance
        if ($montant > $soldeActuel) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Solde insuffisant']);
        }

        // Calculate fee
        $frais = $this->fakeDataService->calculateFee($montant, 3); // Type 3 = Transfert
        $total = $montant + $frais;
        
        if ($total > $soldeActuel) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Solde insuffisant (incluant les frais de ' . $frais . ' Ar)']);
        }

        // In a real application, we would process the transfer
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
