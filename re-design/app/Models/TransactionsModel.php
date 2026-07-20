<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionsModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_compte',
        'id_type_operation',
        'numero_source',
        'numero_destinataire',
        'somme',
        'gain',
        'commission',
        'id_operateur_destinataire',
        'inclure_frais_retrait',
        'batch_id',
        'created_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [];
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
     * Applique un filtre de date optionnel sur created_at
     */
    private function applyDateFilter($builder, ?string $dateDebut = null, ?string $dateFin = null)
    {
        if ($dateDebut) {
            $builder->where('created_at >=', $dateDebut . ' 00:00:00');
        }
        if ($dateFin) {
            $builder->where('created_at <=', $dateFin . ' 23:59:59');
        }
        return $builder;
    }

    /**
     * Gain total (tous types confondus), avec filtre de date optionnel
     */
    public function getTotalGain(?string $dateDebut = null, ?string $dateFin = null): float
    {
        $builder = $this->builder();
        $builder->selectSum('gain');
        $this->applyDateFilter($builder, $dateDebut, $dateFin);

        $result = $builder->get()->getRowArray();
        return (float) ($result['gain'] ?? 0);
    }

    /**
     * Gain par type d'opération, avec filtre de date optionnel
     */
    public function getGainByType(int $idTypeOperation, ?string $dateDebut = null, ?string $dateFin = null, ?int $estInterne = null): float
    {
        $builder = $this->builder();
        $builder->selectSum('gain');
        $builder->where('id_type_operation', $idTypeOperation);

        if ($estInterne !== null && $idTypeOperation === 3) {
            if ($estInterne === 1) {
                $builder->where('id_operateur_destinataire', null);
            } else {
                $builder->where('id_operateur_destinataire IS NOT', null, false);
            }
        }

        $this->applyDateFilter($builder, $dateDebut, $dateFin);

        $result = $builder->get()->getRowArray();
        return (float) ($result['gain'] ?? 0);
    }

    /**
     * Montants à envoyer groupés par opérateur destinataire
     */
    public function getMontantsParOperateur(?string $dateDebut = null, ?string $dateFin = null): array
    {
        $builder = $this->builder();
        $builder->select('id_operateur_destinataire, SUM(somme) AS montant_total, SUM(COALESCE(commission, 0)) AS commission_total');
        $builder->where('id_type_operation', 3);
        $builder->where('id_operateur_destinataire IS NOT', null, false);
        $this->applyDateFilter($builder, $dateDebut, $dateFin);
        $builder->groupBy('id_operateur_destinataire');
        $builder->orderBy('commission_total', 'DESC');

        return $builder->get()->getResultArray();
    }

    /**
     * Transactions avec filtre de date optionnel
     */
    public function getTransactionsFiltrees(?string $dateDebut = null, ?string $dateFin = null): array
    {
        $builder = $this->builder();
        $this->applyDateFilter($builder, $dateDebut, $dateFin);
        $builder->orderBy('created_at', 'DESC');

        return $builder->get()->getResultArray();
    }

    /**
     * Récupère toutes les transactions liées à un numéro (source ou destinataire)
     */
    public function getTransactionsByNumero(string $numero): array
    {
        return $this->groupStart()
            ->where('numero_source', $numero)
            ->orWhere('numero_destinataire', $numero)
            ->groupEnd()
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Nombre total de transactions
     */
    public function countTotal(): int
    {
        return $this->countAllResults();
    }

    /**
     * Les N transactions les plus récentes
     */
    public function getRecentTransactions(int $limit = 5): array
    {
        return $this->orderBy('created_at', 'DESC')
            ->findAll($limit);
    }
}
