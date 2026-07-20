<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Situation des Gains</title>
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
                        <a class="nav-link" href="<?= base_url('/operator/dashboard') ?>">
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
                        <a class="nav-link active" href="<?= base_url('/operator/gains') ?>">
                            <i class="bi bi-graph-up"></i> Gains
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/operator/comptes') ?>">
                            <i class="bi bi-people"></i> Comptes Clients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/operator/operateurs') ?>">
                            <i class="bi bi-building"></i> Opérateurs
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
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-cash-stack fs-1"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title mb-1">Total des Gains</h6>
                                <h3 class="mb-0"><?= number_format($totalGain, 0, ',', ' ') ?> Ar</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-arrow-down-circle fs-1"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title mb-1">Gains Retraits</h6>
                                <h3 class="mb-0"><?= number_format($gainRetrait, 0, ',', ' ') ?> Ar</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-arrow-right-circle fs-1"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title mb-1">Transferts Internes</h6>
                                <h3 class="mb-0"><?= number_format($gainTransfertInterne, 0, ',', ' ') ?> Ar</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 bg-warning text-dark">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-arrow-right-circle fs-1"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="card-title mb-1">Transferts Externes</h6>
                                <h3 class="mb-0"><?= number_format($gainTransfertExterne, 0, ',', ' ') ?> Ar</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Montants à envoyer par opérateur -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="bi bi-send"></i> Situation des Montants à Envoyer par Opérateur
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if(isset($montantsParOperateur) && !empty($montantsParOperateur)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Opérateur</th>
                                        <th>Montant à Envoyer (Ar)</th>
                                        <th>Commission (Ar)</th>
                                        <th>Total (Ar)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($montantsParOperateur as $montant): ?>
                                    <?php 
                                    $operateur = isset($operateursMap[$montant['id_operateur_destinataire']]) 
                                        ? $operateursMap[$montant['id_operateur_destinataire']] 
                                        : ['nom' => 'Inconnu', 'est_interne' => 0];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php if($operateur['est_interne'] == 1): ?>
                                                <span class="badge bg-success"><?= $operateur['nom'] ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-warning"><?= $operateur['nom'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= number_format($montant['montant_total'], 0, ',', ' ') ?></td>
                                        <td><?= number_format($montant['commission_total'], 0, ',', ' ') ?></td>
                                        <td><strong><?= number_format($montant['montant_total'] + $montant['commission_total'], 0, ',', ' ') ?></strong></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Aucun montant à envoyer pour le moment
                        </div>
                        <?php endif; ?>
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
                            <i class="bi bi-clock-history"></i> Dernières Transactions avec Gains
                        </h4>
                    </div>
                    <div class="card-body">
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
                                        <?php if(isset($transaction['commission'])): ?>
                                        <th>Commission (Ar)</th>
                                        <?php endif; ?>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($transactions as $transaction): ?>
                                    <?php 
                                    $opName = '';
                                    foreach($operations as $op) {
                                        if($transaction['id_type_operation'] == $op['id']) {
                                            $opName = $op['libelle'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $transaction['id'] ?></td>
                                        <td><span class="badge bg-secondary"><?= $opName ?></span></td>
                                        <td><?= $transaction['numero_source'] ?></td>
                                        <td><?= $transaction['numero_destinataire'] ?? '-' ?></td>
                                        <td><?= number_format($transaction['somme'], 0, ',', ' ') ?></td>
                                        <td><span class="badge bg-success"><?= number_format($transaction['gain'], 0, ',', ' ') ?></span></td>
                                        <?php if(isset($transaction['commission'])): ?>
                                        <td><span class="badge bg-info"><?= number_format($transaction['commission'], 0, ',', ' ') ?></span></td>
                                        <?php endif; ?>
                                        <td><?= $transaction['created_at'] ?></td>
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
