<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ComptesModel;

class DashboardController extends BaseController
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
        
        return view('client/tableauBord', [
            'solde' => $solde
        ]);
    }
}
