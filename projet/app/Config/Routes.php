<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Login\LoginController::index');
// recuperation des prefixes depuis le serveur
$routes->get('/get-prefixes', 'Utils\UtilsController::getPrefixes');
$routes->post('/login', 'Login\LoginController::login');

// Logout
$routes->get('/logout', 'LogoutController::index');

// Client routes
$routes->get('/client/solde', 'Client\BalanceController::index');
$routes->get('/client/solde/get', 'Client\BalanceController::getBalance');
$routes->get('/client/depot', 'Client\DepositController::index');
$routes->post('/client/depot/create', 'Client\DepositController::create');
$routes->get('/client/retrait', 'Client\WithdrawalController::index');
$routes->post('/client/retrait/create', 'Client\WithdrawalController::create');
$routes->get('/client/transfert', 'Client\TransferController::index');
$routes->post('/client/transfert/create', 'Client\TransferController::create');
$routes->get('/client/historique', 'Client\HistoryController::index');
$routes->get('/client/historique/get', 'Client\HistoryController::getTransactions');

// Operator routes
$routes->get('/operator/dashboard', 'Operator\DashboardController::index');
$routes->get('/operator/prefixes', 'Operator\PrefixController::index');
$routes->post('/operator/prefixes/create', 'Operator\PrefixController::create');
$routes->post('/operator/prefixes/update', 'Operator\PrefixController::update');
$routes->post('/operator/prefixes/delete', 'Operator\PrefixController::delete');
$routes->get('/operator/operations', 'Operator\OperationTypeController::index');
$routes->post('/operator/operations/create', 'Operator\OperationTypeController::create');
$routes->post('/operator/operations/update', 'Operator\OperationTypeController::update');
$routes->post('/operator/operations/delete', 'Operator\OperationTypeController::delete');
$routes->get('/operator/operations/fees/(:num)', 'Operator\OperationTypeController::getFees/$1');
$routes->post('/operator/operations/fee/update', 'Operator\OperationTypeController::updateFee');
$routes->get('/operator/gains', 'Operator\GainController::index');
$routes->get('/operator/gains/stats', 'Operator\GainController::getGainStats');
$routes->get('/operator/comptes', 'Operator\ClientAccountController::index');
$routes->get('/operator/comptes/view/(:segment)', 'Operator\ClientAccountController::view/$1');
$routes->post('/operator/comptes/update-state', 'Operator\ClientAccountController::updateState');