<?php

namespace App\Controllers\Login;

use App\Controllers\BaseController;
use App\Models\UsersOperateurModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PrefixeModel;
use App\Models\ComptesModel;

class LoginController extends BaseController
{
     private UsersOperateurModel $usersOperateurModel;

    public function __construct()
    {
        $this->usersOperateurModel = new UsersOperateurModel();
    }

    public function index()
    {
        helper('url');
        // si session existe, redirection vers la page d'accueil appropriée
        if (session()->has('user_type')) {
            if (session('user_type') === 'admin') {
                return redirect()->to('/operator/dashboard');
            } else {
                return view('client/tableauBord');
            }
        }
        return view('login/login');
    }

    public function login()
    {
        helper('url');
        $data = $this->request->getJSON();
        $numero = $data->numero ?? null;
        $password = $data->password ?? null;
        $userType = $data->userType ?? 'client';

        // Validation selon le type d'utilisateur
        if ($userType === 'client') {
            // Vérification du numéro
            if (!$numero || !preg_match('/^\d{10}$/', $numero)) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON(['message' => 'Le numero mobile doit contenir exactement 10 chiffres.']);
            }

            // Vérification du préfixe
            $prefixes = $this->getPrefixes();
            $prefixOk = false;
            foreach ($prefixes as $prefix) {
                if (strpos($numero, $prefix) === 0) {
                    $prefixOk = true;
                    break;
                }
            }

            if (!$prefixOk) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON(['message' => 'Le numero mobile est invalide (prefixe incorrect).']);
            }

            // vérifier si existe dans la base de données
            $comptes = $this->getAllNumero();
            if (!in_array($numero, $comptes)) {
                // enregistrer le numero dans la base de données
            }
            // Si tout est ok, on crée la session
            session()->set('numero', $numero);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Connexion réussie',
                'redirect_url' => base_url('/')
            ]);

        } elseif ($userType === 'admin') {
            // Validation pour admin
            if (!$numero || !$password) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON(['message' => 'Identifiant et mot de passe requis.']);
            }

            // Validation contre les utilisateurs opérateur (via UsersOperateurModel)
            $user = $this->usersOperateurModel->validateLogin($numero, $password);

            if (!$user) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)
                    ->setJSON(['message' => 'Identifiant ou mot de passe incorrect.']);
            }

            // Créer la session admin
            session()->set('admin_id', $user['id']);
            session()->set('admin_username', $user['username']);
            session()->set('admin_nom', $user['nom']);
            session()->set('admin_prenom', $user['prenom']);
            session()->set('admin_role', $user['role']);
            session()->set('user_type', 'admin');

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Connexion admin réussie',
                'redirect_url' => base_url('/operator/dashboard')
            ]);
        }
    }

    function getAllNumero()
    {
        $model = new ComptesModel();
        $numeros = $model->findAll();
        return array_column($numeros, 'numero');
    }

    function getPrefixes()
    {
        $model = new PrefixeModel();
        $prefixes = $model->findAll();
        return !empty($prefixes) ? array_column($prefixes, 'codes') : [];
    }
}
