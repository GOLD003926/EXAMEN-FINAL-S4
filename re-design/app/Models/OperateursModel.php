<?php

namespace App\Models;

use CodeIgniter\Model;

class OperateursModel extends Model
{
    protected $table            = 'operateurs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nom', 'code', 'est_interne', 'taux_commission', 'descriptions'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [
        'nom'             => 'required|min_length[2]',
        'code'            => 'required|alpha_dash',
        'taux_commission' => 'permit_empty|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

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
     * Liste uniquement les opérateurs externes (pour config commission)
     */
    public function getOperateursExternes(): array
    {
        return $this->where('est_interne', 0)->findAll();
    }

    /**
     * Met à jour le taux de commission d'un opérateur
     */
    public function updateTauxCommission(int $id, float $taux): bool
    {
        return $this->update($id, ['taux_commission' => $taux]);
    }
}