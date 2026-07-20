<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\PrefixeModel;
use App\Models\OperateursModel;

class PrefixController extends BaseController
{
    private $prefixeModel;
    private $operateursModel;

    public function __construct()
    {
        $this->prefixeModel = new PrefixeModel();
        $this->operateursModel = new OperateursModel();
    }

    public function index()
    {   
        $prefixes = $this->prefixeModel->select('prefixe.*, operateurs.nom as operateur_nom, operateurs.est_interne')
                                       ->join('operateurs', 'operateurs.id = prefixe.id_operateur', 'left')
                                       ->findAll();
        
        $operateurs = $this->operateursModel->findAll();
        
        return view('operator/prefixes', [
            'prefixes' => $prefixes,
            'operateurs' => $operateurs
        ]);
    }

    public function create()
    {
        $data = $this->request->getJSON();
        
        // Validation des données
        if (!isset($data->codes) || empty($data->codes)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Le code du préfixe est requis']);
        }

        if (!isset($data->id_operateur)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'L\'opérateur associé est requis']);
        }

        $prefixeData = [
            'codes' => $data->codes,
            'descriptions' => $data->descriptions ?? null,
            'id_operateur' => $data->id_operateur
        ];

        $id = $this->prefixeModel->insert($prefixeData);

        if ($id) {
            return $this->response->setJSON(['success' => true, 'message' => 'Préfixe ajouté avec succès']);
        }

        return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Erreur lors de l\'ajout']);
    }

    public function update()
    {
        $data = $this->request->getJSON();
        
        if (!isset($data->id) || !isset($data->codes)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Données invalides']);
        }

        $prefixeData = [
            'codes' => $data->codes,
            'descriptions' => $data->descriptions ?? null,
            'id_operateur' => $data->id_operateur
        ];

        $updated = $this->prefixeModel->update($data->id, $prefixeData);

        if ($updated) {
            return $this->response->setJSON(['success' => true, 'message' => 'Préfixe mis à jour avec succès']);
        }

        return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
    }

    public function delete()
    {
        $data = $this->request->getJSON();
        
        if (!isset($data->id)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'ID requis']);
        }

        $deleted = $this->prefixeModel->delete($data->id);

        if ($deleted) {
            return $this->response->setJSON(['success' => true, 'message' => 'Préfixe supprimé avec succès']);
        }

        return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Erreur lors de la suppression']);
    }

    // Méthode pour résoudre l'opérateur depuis un numéro de téléphone
    // Retourne JSON pour être appelée via AJAX depuis le front-end
    public function getOperateurByNumero($prefixe)
    {
        $prefixeData = $this->prefixeModel->where('codes', $prefixe)->first();
        
        if ($prefixeData && isset($prefixeData['id_operateur'])) {
            $operateur = $this->operateursModel->find($prefixeData['id_operateur']);
            if ($operateur) {
                return $this->response->setJSON(['success' => true, 'operateur' => $operateur]);
            }
        }
        
        return $this->response->setJSON(['success' => false, 'operateur' => null]);
    }

    // Méthode interne pour résoudre l'opérateur depuis un numéro complet
    // Utilisée par TransferController (pas une route API publique)
    public function resolveOperateur($numero)
    {
        $prefixe = substr($numero, 0, 3);
        $prefixeData = $this->prefixeModel->where('codes', $prefixe)->first();
        
        if ($prefixeData && isset($prefixeData['id_operateur'])) {
            $operateur = $this->operateursModel->find($prefixeData['id_operateur']);
            return $operateur;
        }
        
        return null;
    }
}
