<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\TypeOperationsModel;
use App\Models\FraisOperationsModel;

class OperationTypeController extends BaseController
{
    public function index()
    {
        $model = new TypeOperationsModel();
        $operations = $model->findAll();
        return view('operator/operations', ['operations' => $operations]);
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
        $model = new FraisOperationsModel();
        $allFees = $model->findAll();
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
