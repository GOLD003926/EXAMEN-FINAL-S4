<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\ComptesModel;
use App\Models\TransactionsModel;
use App\Models\PrefixeModel;
use App\Models\TypeOperationsModel;

class DashboardController extends BaseController
{
    private ComptesModel $comptesModel;
    private TransactionsModel $transactionsModel;
    private PrefixeModel $prefixeModel;
    private TypeOperationsModel $typeOperationsModel;

    public function __construct()
    {
        $this->comptesModel        = new ComptesModel();
        $this->transactionsModel   = new TransactionsModel();
        $this->prefixeModel        = new PrefixeModel();
        $this->typeOperationsModel = new TypeOperationsModel();
    }

    public function index()
    {
        // Vérifier si l'utilisateur est connecté en tant qu'administrateur
        if (!session()->has('user_type') || session('user_type') !== 'admin') {
            return redirect()->to('/');
        }

        $totalGain          = $this->transactionsModel->getTotalGain();
        $totalClients       = $this->comptesModel->countTotal();
        $activeClients      = $this->comptesModel->countActifs();
        $totalTransactions  = $this->transactionsModel->countTotal();
        $totalSolde         = $this->comptesModel->getSommeSoldes();
        $recentTransactions = $this->transactionsModel->getRecentTransactions(5);

        return view('operator/dashboard', [
            'admin_nom'          => session('admin_nom'),
            'admin_prenom'       => session('admin_prenom'),
            'admin_role'         => session('admin_role'),
            'totalGain'          => $totalGain,
            'totalClients'       => $totalClients,
            'activeClients'      => $activeClients,
            'totalTransactions'  => $totalTransactions,
            'totalSolde'         => $totalSolde,
            'recentTransactions' => $recentTransactions,
        ]);
    }
}