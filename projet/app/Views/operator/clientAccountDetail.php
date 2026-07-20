<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du Compte</title>
    <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('bootstrap/icons/bootstrap-icons.min.css') ?>">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url('/operator/dashboard') ?>">
                <i class="bi bi-gear-fill"></i> Opérateur
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
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
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/logout') ?>">
                            <i class="bi bi-box-arrow-right"></i> Déconnexion
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Back Button -->
        <div class="row mb-3">
            <div class="col-12">
                <a href="<?= base_url('/operator/comptes') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
            </div>
        </div>

        <!-- Account Info Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">
                            <i class="bi bi-person-circle"></i> Informations du Compte
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Numéro:</strong> <?= $compte['numero'] ?></p>
                                <p><strong>Nom:</strong> <?= $compte['nom'] ?></p>
                                <p><strong>Prénom:</strong> <?= $compte['prenom'] ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Solde:</strong> <span class="badge bg-success fs-6"><?= number_format($compte['solde'], 0, ',', ' ') ?> Ar</span></p>
                                <p><strong>État:</strong> <span class="badge bg-secondary"><?= $compte['etat_libelle'] ?></span></p>
                                <p><strong>Dernière mise à jour:</strong> <?= $compte['update_at'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">
                            <i class="bi bi-clock-history"></i> Historique des Transactions
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php if(empty($transactions)): ?>
                        <div class="alert alert-info">Aucune transaction pour ce compte.</div>
                        <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Type</th>
                                        <th>Numéro Source</th>
                                        <th>Numéro Destinataire</th>
                                        <th>Montant (Ar)</th>
                                        <th>Gain (Ar)</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($transactions as $transaction): ?>
                                    <tr>
                                        <td><?= $transaction['id'] ?></td>
                                        <td>
                                            <?php 
                                            $typeLabels = [1 => 'Dépôt', 2 => 'Retrait', 3 => 'Transfert'];
                                            $typeColors = [1 => 'success', 2 => 'danger', 3 => 'warning'];
                                            ?>
                                            <span class="badge bg-<?= $typeColors[$transaction['id_type_operation']] ?>">
                                                <?= $typeLabels[$transaction['id_type_operation']] ?>
                                            </span>
                                        </td>
                                        <td><?= $transaction['numero_source'] ?></td>
                                        <td><?= $transaction['numero_destinataire'] ?? '-' ?></td>
                                        <td><?= number_format($transaction['somme'], 0, ',', ' ') ?></td>
                                        <td><?= number_format($transaction['gain'], 0, ',', ' ') ?></td>
                                        <td><?= $transaction['created_at'] ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
