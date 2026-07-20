<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Login\LoginController::index');
// recuperation des prefixes depuis le serveur
$routes->get('/get-prefixes', 'Utils\UtilsController::getPrefixes');
$routes->post('/login', 'Login\LoginController::login');