<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Opérateur</title>
    <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('bootstrap/icons/bootstrap-icons.min.css') ?>">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url('/operator/dashboard') ?>">
                <i class="bi bi-gear-fill"></i> Panel Opérateur
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('/operator/dashboard') ?>">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/operator/prefixes') ?>">
                            <i class="bi bi-hash"></i> Préfixes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/operator/operations') ?>">
                            <i class="bi bi-list-check"></i> Types d'Opérations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/operator/gains') ?>">
                            <i class="bi bi-graph-up"></i> Gains
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/operator/comptes') ?>">
                            <i class="bi bi-people"></i> Comptes Clients
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> <?= $admin_nom ?> <?= $admin_prenom ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><span class="dropdown-item-text"><small class="text-muted">Rôle: <?= ucfirst($admin_role) ?></small></span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= base_url('/logout') ?>">
                                <i class="bi bi-box-arrow-right"></i> Déconnexion
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-primary" role="alert">
                    <h4 class="alert-heading">
                        <i class="bi bi-person-badge"></i> Bienvenue, <?= $admin_prenom ?>!
                    </h4>
                    <p class="mb-0">Vous êtes connecté en tant que <strong><?= ucfirst($admin_role) ?></strong></p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100 border-0" style="border-top: 4px solid #198754 !important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-cash-stack text-success fs-1"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-subtitle mb-1 text-muted">Total des Gains</h6>
                                <h3 class="card-title mb-0"><?= number_format($totalGain, 0, ',', ' ') ?> Ar</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100 border-0" style="border-top: 4px solid #0d6efd !important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-people text-primary fs-1"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-subtitle mb-1 text-muted">Total Clients</h6>
                                <h3 class="card-title mb-0"><?= $totalClients ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100 border-0" style="border-top: 4px solid #ffc107 !important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-person-check text-warning fs-1"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-subtitle mb-1 text-muted">Clients Actifs</h6>
                                <h3 class="card-title mb-0"><?= $activeClients ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100 border-0" style="border-top: 4px solid #dc3545 !important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-arrow-left-right text-danger fs-1"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-subtitle mb-1 text-muted">Transactions</h6>
                                <h3 class="card-title mb-0"><?= $totalTransactions ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access Cards -->
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="mb-3">Accès Rapide</h5>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-hash text-primary" style="font-size: 2.5rem;"></i>
                        </div>
                        <h5 class="card-title">Gérer les Préfixes</h5>
                        <p class="card-text text-muted">Configurer les préfixes opérateurs</p>
                        <a href="<?= base_url('/operator/prefixes') ?>" class="btn btn-primary w-100">
                            <i class="bi bi-gear"></i> Gérer
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-list-check text-success" style="font-size: 2.5rem;"></i>
                        </div>
                        <h5 class="card-title">Types d'Opérations</h5>
                        <p class="card-text text-muted">Définir les types et frais d'opérations</p>
                        <a href="<?= base_url('/operator/operations') ?>" class="btn btn-success w-100">
                            <i class="bi bi-gear"></i> Gérer
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-graph-up text-info" style="font-size: 2.5rem;"></i>
                        </div>
                        <h5 class="card-title">Voir les Gains</h5>
                        <p class="card-text text-muted">Analyser les gains générés</p>
                        <a href="<?= base_url('/operator/gains') ?>" class="btn btn-info w-100">
                            <i class="bi bi-eye"></i> Voir
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-people text-warning" style="font-size: 2.5rem;"></i>
                        </div>
                        <h5 class="card-title">Comptes Clients</h5>
                        <p class="card-text text-muted">Gérer les comptes et états</p>
                        <a href="<?= base_url('/operator/comptes') ?>" class="btn btn-warning w-100">
                            <i class="bi bi-gear"></i> Gérer
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-clock-history"></i> Transactions Récentes
                        </h5>
                        <a href="<?= base_url('/operator/gains') ?>" class="btn btn-sm btn-outline-primary">
                            Voir tout
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Numéro Source</th>
                                        <th>Numéro Destinataire</th>
                                        <th>Montant (Ar)</th>
                                        <th>Gain (Ar)</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($recentTransactions as $transaction): ?>
                                    <tr>
                                        <td><?= $transaction['id'] ?></td>
                                        <td><?= $transaction['numero_source'] ?></td>
                                        <td><?= $transaction['numero_destinataire'] ?? '-' ?></td>
                                        <td><?= number_format($transaction['somme'], 0, ',', ' ') ?></td>
                                        <td><span class="badge bg-success"><?= number_format($transaction['gain'], 0, ',', ' ') ?></span></td>
                                        <td><small class="text-muted"><?= $transaction['created_at'] ?></small></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
