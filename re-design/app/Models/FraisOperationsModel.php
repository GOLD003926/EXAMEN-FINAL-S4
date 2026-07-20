<?php

namespace App\Models;

use CodeIgniter\Model;

class FraisOperationsModel extends Model
{
    protected $table            = 'frais_operations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['id_type_operation', 'somme_min', 'somme_max', 'frais', 'descriptions'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Calculate fee based on amount and operation type
    public function calculerFrais($amount, $typeOperationId)
    {
        $frais = $this->findAll();
        foreach ($frais as $fra) {
            if ($fra['id_type_operation'] == $typeOperationId && 
                $amount >= $fra['somme_min'] && 
                $amount <= $fra['somme_max']) {
                return $fra['frais'];
            }
        }
        return 0;
    }
}
