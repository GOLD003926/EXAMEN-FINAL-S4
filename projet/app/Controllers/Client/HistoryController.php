<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\TransactionsModel;
use App\Models\TypeOperationsModel;

// SUPPOSITION: TransactionsModel a les nouveaux champs:
// - commission (montant de la commission pour transferts externes)
// - batch_id (pour regrouper les envois multiples)

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
            // S'assurer que les champs existent (pour compatibilité avec données existantes)
            if (!isset($transaction['commission'])) {
                $transaction['commission'] = 0;
            }
            if (!isset($transaction['batch_id'])) {
                $transaction['batch_id'] = null;
            }
            if (!isset($transaction['inclure_frais_retrait'])) {
                $transaction['inclure_frais_retrait'] = 0;
            }
        }
        return $transactions;
    }

    // Regroupe les transactions par batch_id pour les envois multiples
    private function regrouperParBatch($transactions): array
    {
        $grouped = [];
        $singles = [];

        foreach ($transactions as $transaction) {
            if (!empty($transaction['batch_id'])) {
                $batchId = $transaction['batch_id'];
                if (!isset($grouped[$batchId])) {
                    $grouped[$batchId] = [
                        'batch_id' => $batchId,
                        'type' => 'multiple',
                        'transactions' => [],
                        'montant_total' => 0,
                        'frais_total' => 0,
                        'gain_total' => 0,
                        'date' => $transaction['created_at'],
                        'operation_libelle' => $transaction['operation_libelle'],
                        'operation_codes' => $transaction['operation_codes']
                    ];
                }
                $grouped[$batchId]['transactions'][] = $transaction;
                $grouped[$batchId]['montant_total'] += $transaction['somme'];
                $grouped[$batchId]['frais_total'] += $transaction['gain'];
                $grouped[$batchId]['gain_total'] += $transaction['gain'];
            } else {
                $transaction['type'] = 'simple';
                $singles[] = $transaction;
            }
        }

        // Fusionner les singles et les grouped, triés par date décroissante
        $all = array_merge($grouped, $singles);
        usort($all, function($a, $b) {
            $dateA = isset($a['date']) ? $a['date'] : (isset($a['created_at']) ? $a['created_at'] : '');
            $dateB = isset($b['date']) ? $b['date'] : (isset($b['created_at']) ? $b['created_at'] : '');
            return strtotime($dateB) - strtotime($dateA);
        });

        return $all;
    }

    public function index()
    {
        $numero = session('numero');
        $transactions = $this->getTransactionsAvecLibelle($numero);
        $transactionsGrouped = $this->regrouperParBatch($transactions);

        return view('client/history', [
            'numero' => $numero,
            'transactions' => $transactionsGrouped
        ]);
    }

    public function getTransactions()
    {
        $numero = session('numero');
        $transactions = $this->getTransactionsAvecLibelle($numero);
        $transactionsGrouped = $this->regrouperParBatch($transactions);

        return $this->response->setJSON(['success' => true, 'transactions' => $transactionsGrouped]);
    }
}