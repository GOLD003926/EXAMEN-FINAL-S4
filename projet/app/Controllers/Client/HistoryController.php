<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\TransactionsModel;
use App\Models\TypeOperationsModel;

class HistoryController extends BaseController
{
    private TransactionsModel $transactionsModel;
    private TypeOperationsModel $typeOperationsModel;

    public function __construct()
    {
        $this->transactionsModel = new TransactionsModel();
        $this->typeOperationsModel = new TypeOperationsModel();
    }

    private function getTransactionsAvecLibelle($numero): array
    {
        $transactions = $this->transactionsModel->getTransactionsByNumero($numero);
        $operations = $this->typeOperationsModel->findAll();

        foreach ($transactions as &$transaction) {
            foreach ($operations as $operation) {
                if ($transaction['id_type_operation'] == $operation['id']) {
                    $transaction['operation_libelle'] = $operation['libelle'];
                    $transaction['operation_codes'] = $operation['codes'];
                    break;
                }
            }
        }
        return $transactions;
    }

    public function index()
    {
        $numero = session('numero');
        $transactions = $this->getTransactionsAvecLibelle($numero);

        return view('client/history', ['numero' => $numero, 'transactions' => array_values($transactions)]);
    }

    public function getTransactions()
    {
        $numero = session('numero');
        $transactions = $this->getTransactionsAvecLibelle($numero);

        return $this->response->setJSON(['success' => true, 'transactions' => array_values($transactions)]);
    }
}