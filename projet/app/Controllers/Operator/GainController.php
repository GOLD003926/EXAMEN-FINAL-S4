<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Services\FakeDataService;

class GainController extends BaseController
{
    private $fakeDataService;

    public function __construct()
    {
        $this->fakeDataService = new FakeDataService();
    }

    public function index()
    {
        $totalGain = $this->fakeDataService->getTotalGain();
        $gainRetrait = $this->fakeDataService->getGainByType(2); // Type 2 = Retrait
        $gainTransfert = $this->fakeDataService->getGainByType(3); // Type 3 = Transfert
        $operations = $this->fakeDataService->getTypeOperations();
        $transactions = $this->fakeDataService->getTransactions();

        return view('operator/gain', [
            'totalGain' => $totalGain,
            'gainRetrait' => $gainRetrait,
            'gainTransfert' => $gainTransfert,
            'operations' => $operations,
            'transactions' => $transactions
        ]);
    }

    public function getGainStats()
    {
        $totalGain = $this->fakeDataService->getTotalGain();
        $gainByType = [
            'retrait' => $this->fakeDataService->getGainByType(2),
            'transfert' => $this->fakeDataService->getGainByType(3),
        ];

        return $this->response->setJSON([
            'totalGain' => $totalGain,
            'gainByType' => $gainByType
        ]);
    }
}
