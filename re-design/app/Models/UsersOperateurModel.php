<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersOperateurModel extends Model
{
    protected $table            = 'users_operateurs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'password', 'nom', 'prenom', 'role'];

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
     * Valide les identifiants d'un utilisateur opérateur
     * Mot de passe en clair pour l'instant (todo: hash à ajouter plus tard)
     */
    public function validateLogin(string $username, string $password): ?array
    {
        $user = $this->where('username', $username)->first();
        log_message('debug', '[USERSOPERATEURMODEL] Login Admin --> Username : ' . $username . ' et mot de passe: ' . $user['password']);

        if ($user && $user['password'] === $password) {
            return $user;
        }

        return null;
    }
}
