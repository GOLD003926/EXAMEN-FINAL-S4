<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\OperateursModel;
use CodeIgniter\HTTP\ResponseInterface;

class OperateurController extends BaseController
{
    private $operateursModel;

    public function __construct()
    {
        $this->operateursModel = new OperateursModel();
    }

    // Liste tous les opérateurs (internes et externes)
    public function index()
    {
        $operateurs = $this->operateursModel->findAll();
        
        return view('operator/operateurs', [
            'operateurs' => $operateurs
        ]);
    }

    // Crée un nouvel opérateur
    public function create()
    {
        $data = $this->request->getJSON();
        
        // Validation des données
        if (!isset($data->nom) || !isset($data->code) || !isset($data->taux_commission)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON(['message' => 'Données incomplètes']);
        }

        $operateurData = [
            'nom' => $data->nom,
            'code' => $data->code,
            'est_interne' => $data->est_interne ?? 0,
            'taux_commission' => $data->taux_commission,
            'descriptions' => $data->descriptions ?? null
        ];

        $id = $this->operateursModel->insert($operateurData);

        if ($id) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Opérateur créé avec succès',
                'id' => $id
            ]);
        }

        return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
            ->setJSON(['message' => 'Erreur lors de la création']);
    }

    // Met à jour un opérateur existant
    public function update()
    {
        $data = $this->request->getJSON();
        $id = $data->id ?? null;

        if (!$id) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON(['message' => 'ID manquant']);
        }

        $operateurData = [
            'nom' => $data->nom,
            'code' => $data->code,
            'est_interne' => $data->est_interne,
            'taux_commission' => $data->taux_commission,
            'descriptions' => $data->descriptions ?? null
        ];

        $updated = $this->operateursModel->update($id, $operateurData);

        if ($updated) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Opérateur mis à jour avec succès'
            ]);
        }

        return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
            ->setJSON(['message' => 'Erreur lors de la mise à jour']);
    }

    // Supprime un opérateur
    public function delete()
    {
        $data = $this->request->getJSON();
        $id = $data->id ?? null;

        if (!$id) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON(['message' => 'ID manquant']);
        }

        // Vérifier que ce n'est pas l'opérateur principal
        $operateur = $this->operateursModel->find($id);
        if ($operateur && $operateur['est_interne'] == 1) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON(['message' => 'Impossible de supprimer l\'opérateur principal']);
        }

        $deleted = $this->operateursModel->delete($id);

        if ($deleted) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Opérateur supprimé avec succès'
            ]);
        }

        return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
            ->setJSON(['message' => 'Erreur lors de la suppression']);
    }
}
