<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Services\FakeDataService;

class HistoryController extends BaseController
{
    private $fakeDataService;

    public function __construct()
    {
        $this->fakeDataService = new FakeDataService();
    }

    public function index()
    {
        $numero = session('numero');
        $transactions = $this->fakeDataService->getTransactions($numero);
        $operations = $this->fakeDataService->getTypeOperations();
        
        // Add operation label to each transaction
        foreach ($transactions as &$transaction) {
            foreach ($operations as $operation) {
                if ($transaction['id_type_operation'] == $operation['id']) {
                    $transaction['operation_libelle'] = $operation['libelle'];
                    $transaction['operation_codes'] = $operation['codes'];
                    break;
                }
            }
        }

        return view('client/history', [
            'numero' => $numero,
            'transactions' => array_values($transactions)
        ]);
    }

    public function getTransactions()
    {
        $numero = session('numero');
        $transactions = $this->fakeDataService->getTransactions($numero);
        $operations = $this->fakeDataService->getTypeOperations();
        
        foreach ($transactions as &$transaction) {
            foreach ($operations as $operation) {
                if ($transaction['id_type_operation'] == $operation['id']) {
                    $transaction['operation_libelle'] = $operation['libelle'];
                    break;
                }
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'transactions' => array_values($transactions)
        ]);
    }
}
