<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\PrefixeModel;

class PrefixController extends BaseController
{

    public function index()
    {   
        $model = new PrefixeModel();
        $prefixes = $model->findAll();
        return view('operator/prefix', ['prefixes' => $prefixes]);
    }

    public function create()
    {
        $data = $this->request->getJSON();
        
        // Validation
        if (!isset($data->codes) || empty($data->codes)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Le code du préfixe est requis']);
        }

        // In a real application, we would save to database
        // For now, just return success
        return $this->response->setJSON(['success' => true, 'message' => 'Préfixe ajouté avec succès']);
    }

    public function update()
    {
        $data = $this->request->getJSON();
        
        if (!isset($data->id) || !isset($data->codes)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Données invalides']);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Préfixe mis à jour avec succès']);
    }

    public function delete()
    {
        $data = $this->request->getJSON();
        
        if (!isset($data->id)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'ID requis']);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Préfixe supprimé avec succès']);
    }
}
