<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Transactions</title>
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
                        <a class="nav-link active" href="<?= base_url('/client/historique') ?>">
                            <i class="bi bi-clock-history"></i> Historique
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link"><?= $numero ?></span>
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

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-clock-history"></i> Historique des Transactions
                        </h4>
                        <button class="btn btn-outline-success btn-sm" onclick="refreshHistory()">
                            <i class="bi bi-arrow-clockwise"></i> Actualiser
                        </button>
                    </div>
                    <div class="card-body">
                        <?php if(empty($transactions)): ?>
                        <div class="alert alert-info text-center">
                            <i class="bi bi-inbox"></i> Aucune transaction trouvée.
                        </div>
                        <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Numéro Source</th>
                                        <th>Numéro Destinataire</th>
                                        <th>Montant (Ar)</th>
                                        <th>Gain (Ar)</th>
                                    </tr>
                                </thead>
                                <tbody id="transactionsTable">
                                    <?php foreach($transactions as $transaction): ?>
                                    <?php 
                                    $badgeClass = 'bg-secondary';
                                    $icon = 'bi-arrow-left-right';
                                    if($transaction['operation_codes'] == 'DEP') {
                                        $badgeClass = 'bg-success';
                                        $icon = 'bi-plus-circle';
                                    } elseif($transaction['operation_codes'] == 'RET') {
                                        $badgeClass = 'bg-danger';
                                        $icon = 'bi-dash-circle';
                                    } elseif($transaction['operation_codes'] == 'TRF') {
                                        $badgeClass = 'bg-warning';
                                        $icon = 'bi-arrow-right-circle';
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <small class="text-muted"><?= $transaction['created_at'] ?></small>
                                        </td>
                                        <td>
                                            <span class="badge <?= $badgeClass ?>">
                                                <i class="bi <?= $icon ?>"></i> <?= $transaction['operation_libelle'] ?>
                                            </span>
                                        </td>
                                        <td><?= $transaction['numero_source'] ?></td>
                                        <td><?= $transaction['numero_destinataire'] ?? '-' ?></td>
                                        <td><strong><?= number_format($transaction['somme'], 0, ',', ' ') ?></strong></td>
                                        <td><?= $transaction['gain'] > 0 ? number_format($transaction['gain'], 0, ',', ' ') : '-' ?></td>
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
    <script>
        async function refreshHistory() {
            try {
                const response = await fetch('<?= base_url('/client/historique/get') ?>');
                const data = await response.json();
                
                if (data.success) {
                    const tbody = document.getElementById('transactionsTable');
                    tbody.innerHTML = '';
                    
                    if (data.transactions.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="6" class="text-center">Aucune transaction trouvée.</td></tr>';
                        return;
                    }
                    
                    data.transactions.forEach(transaction => {
                        let badgeClass = 'bg-secondary';
                        let icon = 'bi-arrow-left-right';
                        
                        if (transaction.operation_codes === 'DEP') {
                            badgeClass = 'bg-success';
                            icon = 'bi-plus-circle';
                        } else if (transaction.operation_codes === 'RET') {
                            badgeClass = 'bg-danger';
                            icon = 'bi-dash-circle';
                        } else if (transaction.operation_codes === 'TRF') {
                            badgeClass = 'bg-warning';
                            icon = 'bi-arrow-right-circle';
                        }
                        
                        const row = `
                            <tr>
                                <td><small class="text-muted">${transaction.created_at}</small></td>
                                <td><span class="badge ${badgeClass}"><i class="bi ${icon}"></i> ${transaction.operation_libelle}</span></td>
                                <td>${transaction.numero_source}</td>
                                <td>${transaction.numero_destinataire || '-'}</td>
                                <td><strong>${transaction.somme.toLocaleString('fr-FR')}</strong></td>
                                <td>${transaction.gain > 0 ? transaction.gain.toLocaleString('fr-FR') : '-'}</td>
                            </tr>
                        `;
                        tbody.innerHTML += row;
                    });
                }
            } catch (error) {
                alert('Erreur lors du rafraîchissement');
            }
        }
    </script>
</body>
</html>
