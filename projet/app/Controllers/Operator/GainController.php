<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\TransactionsModel;
use App\Models\TypeOperationsModel;

class GainController extends BaseController
{
    private TransactionsModel $transactionsModel;
    private TypeOperationsModel $typeOperationsModel;

    public function __construct()
    {
        $this->transactionsModel   = new TransactionsModel();
        $this->typeOperationsModel = new TypeOperationsModel();
    }

    public function index()
    {
        $dateDebut = $this->request->getGet('date_debut');
        $dateFin   = $this->request->getGet('date_fin');

        $totalGain     = $this->transactionsModel->getTotalGain($dateDebut, $dateFin);
        $gainRetrait   = $this->transactionsModel->getGainByType(2, $dateDebut, $dateFin); // Type 2 = Retrait
        $gainTransfert = $this->transactionsModel->getGainByType(3, $dateDebut, $dateFin); // Type 3 = Transfert
        $operations    = $this->typeOperationsModel->findAll();
        $transactions  = $this->transactionsModel->getTransactionsFiltrees($dateDebut, $dateFin);

        return view('operator/gain', [
            'totalGain'     => $totalGain,
            'gainRetrait'   => $gainRetrait,
            'gainTransfert' => $gainTransfert,
            'operations'    => $operations,
            'transactions'  => $transactions,
            'dateDebut'     => $dateDebut,
            'dateFin'       => $dateFin,
        ]);
    }

    public function getGainStats()
    {
        $dateDebut = $this->request->getGet('date_debut');
        $dateFin   = $this->request->getGet('date_fin');

        $totalGain = $this->transactionsModel->getTotalGain($dateDebut, $dateFin);
        $gainByType = [
            'retrait'   => $this->transactionsModel->getGainByType(2, $dateDebut, $dateFin),
            'transfert' => $this->transactionsModel->getGainByType(3, $dateDebut, $dateFin),
        ];

        return $this->response->setJSON([
            'totalGain'  => $totalGain,
            'gainByType' => $gainByType,
        ]);
    }
}