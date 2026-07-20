<?php

namespace App\Models;

use CodeIgniter\Model;

class ComptesModel extends Model
{
    protected $table            = 'comptes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['numero', 'nom', 'prenom', 'id_etat', 'solde', 'update_at'];

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
     * Liste tous les comptes avec le libellé de leur état (jointure)
     */
    public function getComptesWithEtat(): array
    {
        return $this->select('comptes.*, etat_compte.libelle as etat_libelle')
            ->join('etat_compte', 'etat_compte.id = comptes.id_etat')
            ->orderBy('comptes.nom', 'ASC')
            ->findAll();
    }

    /**
     * Récupère un compte par numéro, avec le libellé de son état
     */
    public function getCompteByNumero(string $numero): ?array
    {
        $result = $this->select('comptes.*, etat_compte.libelle as etat_libelle')
            ->join('etat_compte', 'etat_compte.id = comptes.id_etat')
            ->where('comptes.numero', $numero)
            ->first();

        return $result ?: null;
    }

    /**
     * Nombre total de comptes
     */
    public function countTotal(): int
    {
        return $this->countAllResults();
    }

    /**
     * Nombre de comptes actifs (basé sur le code 'ACTIF', pas un id en dur)
     */
    public function countActifs(): int
    {
        return $this->join('etat_compte', 'etat_compte.id = comptes.id_etat')
            ->where('etat_compte.codes', 'ACTIF')
            ->countAllResults();
    }

    /**
     * Somme de tous les soldes
     */
    public function getSommeSoldes(): float
    {
        $result = $this->selectSum('solde')->get()->getRowArray();
        return (float) ($result['solde'] ?? 0);
    }

    /**
     * Récupère tous les comptes
     */
    public function getComptes()
    {
        return $this->findAll();
    }

    /**
     * Récupère le solde d'un compte par numéro
     */

    public function getSolde($numero)
    {
        $compte = $this->where('numero', $numero)->first();
        return $compte['solde'] ?? 0;
    }

    /**
     * Met à jour le solde d'un compte par numéro
     */
    public function updateSolde($numero, $nouveauSolde)
    {
        $this->where('numero', $numero)->set('solde', $nouveauSolde)->update();
    }
}
