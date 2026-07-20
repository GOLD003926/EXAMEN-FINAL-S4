<?php

namespace App\Controllers\Login;

use App\Controllers\BaseController;
use App\Services\FakeDataService;
use CodeIgniter\HTTP\ResponseInterface;

class LoginController extends BaseController
{
    private $fakeDataService;

    public function __construct()
    {
        $this->fakeDataService = new FakeDataService();
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
            $utilisateurs = [
                '0331234567',
                '0377654321',
            ];
            if (!in_array($numero, $utilisateurs)) {
                // enregistrer le numero dans la base de données
            }

            // Si tout est ok, on crée la session client
            session()->set('numero', $numero);
            session()->set('user_type', 'client');
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

            // Validation contre les utilisateurs opérateur
            $user = $this->fakeDataService->validateOperatorLogin($numero, $password);

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

        return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
            ->setJSON(['message' => 'Type d\'utilisateur invalide.']);
    }

    function getPrefixes()
    {
        // tableau des préfixes
        return ['033', '037'];
    }
}
