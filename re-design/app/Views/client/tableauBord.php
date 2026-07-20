<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('bootstrap/icons/bootstrap-icons.min.css') ?>">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url('/') ?>">
                <i class="bi bi-wallet2"></i> Mobile Money
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('/') ?>">
                            <i class="bi bi-house"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/client/solde') ?>">
                            <i class="bi bi-wallet"></i> Solde
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/client/depot') ?>">
                            <i class="bi bi-plus-circle"></i> Dépôt
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/client/retrait') ?>">
                            <i class="bi bi-dash-circle"></i> Retrait
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/client/transfert') ?>">
                            <i class="bi bi-arrow-right-circle"></i> Transfert
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/client/historique') ?>">
                            <i class="bi bi-clock-history"></i> Historique
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link"><?= session('numero') ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/logout') ?>">
                            <i class="bi bi-box-arrow-right"></i> Déconnexion
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">
                        <i class="bi bi-person-circle"></i> Bienvenue!
                    </h4>
                    <p class="mb-0">Vous êtes connecté avec le numéro: <strong><?= session('numero') ?></strong></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100 border-0" style="border-top: 4px solid #198754 !important;">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-wallet text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">Voir Solde</h5>
                        <p class="card-text text-muted">Consultez votre solde actuel</p>
                        <a href="<?= base_url('/client/solde') ?>" class="btn btn-success w-100">
                            <i class="bi bi-eye"></i> Voir
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100 border-0" style="border-top: 4px solid #0d6efd !important;">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-plus-circle text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">Effectuer un Dépôt</h5>
                        <p class="card-text text-muted">Ajoutez de l'argent à votre compte</p>
                        <a href="<?= base_url('/client/depot') ?>" class="btn btn-primary w-100">
                            <i class="bi bi-plus-lg"></i> Dépôt
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100 border-0" style="border-top: 4px solid #dc3545 !important;">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-dash-circle text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">Effectuer un Retrait</h5>
                        <p class="card-text text-muted">Retirez de l'argent de votre compte</p>
                        <a href="<?= base_url('/client/retrait') ?>" class="btn btn-danger w-100">
                            <i class="bi bi-dash-lg"></i> Retrait
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100 border-0" style="border-top: 4px solid #ffc107 !important;">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-arrow-right-circle text-warning" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">Effectuer un Transfert</h5>
                        <p class="card-text text-muted">Envoyez de l'argent à un autre numéro</p>
                        <a href="<?= base_url('/client/transfert') ?>" class="btn btn-warning w-100">
                            <i class="bi bi-arrow-right"></i> Transfert
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-clock-history text-secondary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">Historique des Transactions</h5>
                        <p class="card-text text-muted">Consultez toutes vos transactions précédentes</p>
                        <a href="<?= base_url('/client/historique') ?>" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-list-ul"></i> Voir l'historique
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
