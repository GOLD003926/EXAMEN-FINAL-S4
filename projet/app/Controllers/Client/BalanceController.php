<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Services\FakeDataService;

class BalanceController extends BaseController
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
        
        return view('client/balance', [
            'numero' => $numero,
            'solde' => $solde
        ]);
    }

    public function getBalance()
    {
        $numero = session('numero');
        $solde = $this->fakeDataService->getSolde($numero);
        
        return $this->response->setJSON([
            'success' => true,
            'solde' => $solde
        ]);
    }
}
