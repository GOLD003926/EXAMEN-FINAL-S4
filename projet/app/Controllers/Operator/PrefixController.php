<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\PrefixeModel;
use App\Models\OperateursModel;

// SUPPOSITION: PrefixeModel a maintenant le champ id_operateur (FK vers operateurs)
// SUPPOSITION: OperateursModel existe avec les méthodes CRUD de base

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
        // SUPPOSITION: PrefixeModel peut faire un join avec operateurs pour récupérer le nom de l'opérateur
        $prefixes = $this->prefixeModel->select('prefixe.*, operateurs.nom as operateur_nom, operateurs.est_interne')
                                       ->join('operateurs', 'operateurs.id = prefixe.id_operateur', 'left')
                                       ->findAll();
        
        $operateurs = $this->operateursModel->findAll();
        
        return view('operator/prefix', [
            'prefixes' => $prefixes,
            'operateurs' => $operateurs
        ]);
    }

    public function create()
    {
        $data = $this->request->getJSON();
        
        // Validation
        if (!isset($data->codes) || empty($data->codes)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Le code du préfixe est requis']);
        }

        if (!isset($data->id_operateur)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'L\'opérateur associé est requis']);
        }

        // SUPPOSITION: PrefixeModel a le champ id_operateur dans allowedFields
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

    // SUPPOSITION: Méthode pour résoudre l'opérateur depuis un numéro de téléphone
    // Cette méthode sera utilisée par TransferController pour déterminer si un destinataire est interne ou externe
    // Retourne JSON pour être appelée via AJAX depuis le front
    public function getOperateurByNumero($prefixe)
    {
        // Chercher le préfixe dans la base
        $prefixeData = $this->prefixeModel->where('codes', $prefixe)->first();
        
        if ($prefixeData && isset($prefixeData['id_operateur'])) {
            // Récupérer les détails de l'opérateur
            $operateur = $this->operateursModel->find($prefixeData['id_operateur']);
            if ($operateur) {
                return $this->response->setJSON(['success' => true, 'operateur' => $operateur]);
            }
        }
        
        return $this->response->setJSON(['success' => false, 'operateur' => null]);
    }

    // Méthode interne pour résoudre l'opérateur depuis un numéro complet
    // Utilisée par TransferController (pas une route API)
    public function resolveOperateur($numero)
    {
        // Extraire le préfixe (3 premiers caractères)
        $prefixe = substr($numero, 0, 3);
        
        // Chercher le préfixe dans la base
        $prefixeData = $this->prefixeModel->where('codes', $prefixe)->first();
        
        if ($prefixeData && isset($prefixeData['id_operateur'])) {
            // Récupérer les détails de l'opérateur
            $operateur = $this->operateursModel->find($prefixeData['id_operateur']);
            return $operateur;
        }
        
        return null; // Préfixe non trouvé
    }
}
