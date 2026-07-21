<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeOperationsModel extends Model
{
    protected $table            = 'type_operations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['codes', 'libelle', 'descriptions'];

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

    // Constantes pour les types d'opération
    public const TYPE_DEPOT = 1;
    public const TYPE_RETRAIT = 2;
    public const TYPE_TRANSFERT = 3;

    /**
     * Récupère l'ID d'un type d'opération par son code
     */
    public function getIdByCode(string $code): ?int
    {
        $operation = $this->where('codes', $code)->first();
        return $operation ? $operation['id'] : null;
    }

    /**
     * Récupère le code d'un type d'opération par son ID
     */
    public function getCodeById(int $id): ?string
    {
        $operation = $this->find($id);
        return $operation ? $operation['codes'] : null;
    }
}
