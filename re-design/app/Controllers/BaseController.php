<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController fournit un emplacement pratique pour charger des composants
 * et effectuer des fonctions nécessaires pour tous les contrôleurs.
 *
 * Étendez cette classe dans tous les nouveaux contrôleurs:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * Pour la sécurité, déclarez toutes les nouvelles méthodes comme protégées ou privées.
 */
abstract class BaseController extends Controller
{
    /**
     * Assurez-vous de déclarer les propriétés pour toute propriété que vous initialisez.
     * La création de propriétés dynamiques est déconseillée en PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Chargez ici tous les helpers que vous souhaitez rendre disponibles dans les contrôleurs qui étendent BaseController.
        // Attention: Ne placez pas le code ci-dessous après l'appel parent::initController().
        // $this->helpers = ['form', 'url'];

        // Attention: Ne modifiez pas cette ligne.
        parent::initController($request, $response, $logger);

        // Préchargez ici tous les modèles, bibliothèques, etc.
        // $this->session = service('session');
    }
}
