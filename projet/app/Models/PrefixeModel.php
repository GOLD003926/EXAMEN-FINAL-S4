<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixeModel extends Model
{
    protected $table            = 'prefixe';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['codes', 'descriptions', 'id_operateur'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Configuration des dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Configuration de la validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Configuration des callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Résout l'opérateur associé à un numéro de téléphone via son préfixe
     */
    public function getOperateurByNumero(string $numero): ?array
    {
        $prefixes = $this->select('prefixe.*, operateurs.nom as operateur_nom, operateurs.est_interne, operateurs.taux_commission')
            ->join('operateurs', 'operateurs.id = prefixe.id_operateur')
            ->findAll();

        foreach ($prefixes as $prefixe) {
            if (strpos($numero, $prefixe['codes']) === 0) {
                return $prefixe;
            }
        }

        return null;
    }

    /**
     * Retourne uniquement les codes de préfixes internes (notre opérateur)
     */
    public function getPrefixesInternes(): array
    {
        $result = $this->select('prefixe.codes')
            ->join('operateurs', 'operateurs.id = prefixe.id_operateur')
            ->where('operateurs.est_interne', 1)
            ->findAll();

        return array_column($result, 'codes');
    }
}
