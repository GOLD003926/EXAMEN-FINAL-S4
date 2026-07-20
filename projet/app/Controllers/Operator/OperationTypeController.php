<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Services\FakeDataService;

class OperationTypeController extends BaseController
{
    private $fakeDataService;

    public function __construct()
    {
        $this->fakeDataService = new FakeDataService();
    }

    public function index()
    {
        $operations = $this->fakeDataService->getTypeOperations();
        return view('operator/operationType', ['operations' => $operations]);
    }

    public function create()
    {
        $data = $this->request->getJSON();
        
        if (!isset($data->codes) || empty($data->codes) || !isset($data->libelle) || empty($data->libelle)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Le code et le libellé sont requis']);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Type d\'opération ajouté avec succès']);
    }

    public function update()
    {
        $data = $this->request->getJSON();
        
        if (!isset($data->id) || !isset($data->codes) || !isset($data->libelle)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Données invalides']);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Type d\'opération mis à jour avec succès']);
    }

    public function delete()
    {
        $data = $this->request->getJSON();
        
        if (!isset($data->id)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'ID requis']);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Type d\'opération supprimé avec succès']);
    }

    public function getFees($operationId)
    {
        $allFees = $this->fakeDataService->getFraisOperations();
        $fees = array_filter($allFees, function($fee) use ($operationId) {
            return $fee['id_type_operation'] == $operationId;
        });
        
        return $this->response->setJSON(['fees' => array_values($fees)]);
    }

    public function updateFee()
    {
        $data = $this->request->getJSON();
        
        if (!isset($data->id) || !isset($data->frais)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Données invalides']);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Frais mis à jour avec succès']);
    }
}
