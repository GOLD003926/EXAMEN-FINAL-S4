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

        $model = new TypeOperationsModel();
        $operationData = [
            'codes' => $data->codes,
            'libelle' => $data->libelle,
            'descriptions' => $data->descriptions ?? null
        ];

        $id = $model->insert($operationData);

        if ($id) {
            return $this->response->setJSON(['success' => true, 'message' => 'Type d\'opération ajouté avec succès']);
        }

        return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Erreur lors de l\'ajout']);
    }

    public function update()
    {
        $data = $this->request->getJSON();
        
        if (!isset($data->id) || !isset($data->codes) || !isset($data->libelle)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Données invalides']);
        }

        $model = new TypeOperationsModel();
        $operationData = [
            'codes' => $data->codes,
            'libelle' => $data->libelle,
            'descriptions' => $data->descriptions ?? null
        ];

        $updated = $model->update($data->id, $operationData);

        if ($updated) {
            return $this->response->setJSON(['success' => true, 'message' => 'Type d\'opération mis à jour avec succès']);
        }

        return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
    }

    public function delete()
    {
        $data = $this->request->getJSON();
        
        if (!isset($data->id)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'ID requis']);
        }

        $model = new TypeOperationsModel();
        $feesModel = new FraisOperationsModel();
        
        // Supprimer d'abord les frais associés à ce type d'opération
        $feesModel->where('id_type_operation', $data->id)->delete();
        
        // Puis supprimer le type d'opération
        $deleted = $model->delete($data->id);

        if ($deleted) {
            return $this->response->setJSON(['success' => true, 'message' => 'Type d\'opération supprimé avec succès']);
        }

        return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Erreur lors de la suppression']);
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

        $model = new FraisOperationsModel();
        $feeData = [
            'frais' => $data->frais,
            'somme_min' => $data->somme_min ?? null,
            'somme_max' => $data->somme_max ?? null,
            'descriptions' => $data->descriptions ?? null
        ];

        $updated = $model->update($data->id, $feeData);

        if ($updated) {
            return $this->response->setJSON(['success' => true, 'message' => 'Frais mis à jour avec succès']);
        }

        return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
    }

    public function createFee()
    {
        $data = $this->request->getJSON();
        
        if (!isset($data->id_type_operation) || !isset($data->somme_min) || !isset($data->somme_max) || !isset($data->frais)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Données invalides']);
        }

        $model = new FraisOperationsModel();
        $feeData = [
            'id_type_operation' => $data->id_type_operation,
            'somme_min' => $data->somme_min,
            'somme_max' => $data->somme_max,
            'frais' => $data->frais,
            'descriptions' => $data->descriptions ?? null
        ];

        $id = $model->insert($feeData);

        if ($id) {
            return $this->response->setJSON(['success' => true, 'message' => 'Frais ajouté avec succès']);
        }

        return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Erreur lors de l\'ajout']);
    }

    public function deleteFee()
    {
        $data = $this->request->getJSON();
        
        if (!isset($data->id)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'ID requis']);
        }

        $model = new FraisOperationsModel();
        $deleted = $model->delete($data->id);

        if ($deleted) {
            return $this->response->setJSON(['success' => true, 'message' => 'Frais supprimé avec succès']);
        }

        return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Erreur lors de la suppression']);
    }
}
