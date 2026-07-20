<?php

namespace App\Controllers\Login;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class LoginController extends BaseController
{
    public function index()
    {
        helper('url');
        // si session existe, redirection vers la page d'accueil
        if (session()->has('numero')) {
            return view('client/tableauBord');
        }
        return view('login/login');
    }
    public function login()
    {
        helper('url');
        $data = $this->request->getJSON();
        $numero = $data->numero ?? null;

        // Vérification du numéro
        if (!$numero || !preg_match('/^\d{10}$/', $numero)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON(['message' => 'Le numero mobile doit contenir exactement 10 chiffres.']);
        }
        // Vérification du préfixe 
        // Récupération des préfixes depuis la base
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

        // verifier si existe dans la base de données 
        $utilisateurs = [
            '0331234567',
            '0377654321',
        ];
        if (!in_array($numero, $utilisateurs)) {
            // enregistrer le numero dans la base de données
        }
        // Si tout est ok, on crée la session
        session()->set('numero', $numero);
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Connexion réussie',
            'redirect_url' => base_url('/')
        ]);
    }
    function getPrefixes()
    {
        // tableau des préfixes
        return ['033', '037'];
    }
}
