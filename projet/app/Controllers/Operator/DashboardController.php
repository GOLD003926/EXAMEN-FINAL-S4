<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Services\FakeDataService;

class DashboardController extends BaseController
{
    private $fakeDataService;

    public function __construct()
    {
        $this->fakeDataService = new FakeDataService();
    }

    public function index()
    {
        // Check if user is logged in as admin
        if (!session()->has('user_type') || session('user_type') !== 'admin') {
            return redirect()->to('/');
        }

        // Get statistics
        $totalGain = $this->fakeDataService->getTotalGain();
        $comptes = $this->fakeDataService->getComptes();
        $transactions = $this->fakeDataService->getTransactions();
        $prefixes = $this->fakeDataService->getPrefixes();
        $operations = $this->fakeDataService->getTypeOperations();

        // Calculate additional stats
        $totalClients = count($comptes);
        $totalTransactions = count($transactions);
        $activeClients = count(array_filter($comptes, function($c) { return $c['id_etat'] == 1; }));
        $totalSolde = array_sum(array_column($comptes, 'solde'));

        return view('operator/dashboard', [
            'admin_nom' => session('admin_nom'),
            'admin_prenom' => session('admin_prenom'),
            'admin_role' => session('admin_role'),
            'totalGain' => $totalGain,
            'totalClients' => $totalClients,
            'activeClients' => $activeClients,
            'totalTransactions' => $totalTransactions,
            'totalSolde' => $totalSolde,
            'recentTransactions' => array_slice($transactions, 0, 5)
        ]);
    }
}
