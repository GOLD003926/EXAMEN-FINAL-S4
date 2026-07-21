<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ComptesModel;

class BalanceController extends BaseController
{
    private $comptesModel;

    public function __construct()
    {
        $this->comptesModel = new ComptesModel();
    }

    public function index()
    {
        $numero = session('numero');
        $solde = $this->comptesModel->getSolde($numero);
        
        return view('client/balance', [
            'numero' => $numero,
            'solde' => $solde
        ]);
    }

    public function getBalance()
    {
        $numero = session('numero');
        $solde = $this->comptesModel->getSolde($numero);
        
        return $this->response->setJSON([
            'success' => true,
            'solde' => $solde
        ]);
    }
}
