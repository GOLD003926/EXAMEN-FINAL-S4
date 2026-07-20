<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrait</title>
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
                        <a class="nav-link active" href="<?= base_url('/client/retrait') ?>">
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

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">
                            <i class="bi bi-dash-circle text-danger"></i> Effectuer un Retrait
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-4">
                            <i class="bi bi-wallet"></i> Solde actuel: <strong><?= number_format($solde, 0, ',', ' ') ?> Ar</strong>
                        </div>
                        <form id="withdrawalForm">
                            <div class="mb-4">
                                <label for="montant" class="form-label">Montant à retirer (Ar)</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text">Ar</span>
                                    <input type="number" class="form-control" id="montant" placeholder="Ex: 50000" min="100" required>
                                </div>
                                <div class="form-text">Montant minimum: 100 Ar</div>
                            </div>
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> Des frais seront appliqués selon le montant.
                            </div>
                            <button type="submit" class="btn btn-danger w-100 btn-lg">
                                <i class="bi bi-dash-circle"></i> Effectuer le Retrait
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-check-circle"></i> Retrait Réussi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                    </div>
                    <p id="successMessage" class="fs-5"></p>
                    <p class="text-muted">Nouveau solde: <strong id="newSolde"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <a href="<?= base_url('/client/solde') ?>" class="btn btn-success">Voir Solde</a>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script>
        document.getElementById('withdrawalForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const montant = document.getElementById('montant').value;
            
            if (!montant || montant < 100) {
                alert('Le montant minimum est de 100 Ar');
                return;
            }

            try {
                const response = await fetch('<?= base_url('/client/retrait/create') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ montant: parseFloat(montant) })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('successMessage').textContent = data.message;
                    document.getElementById('newSolde').textContent = data.nouveau_solde.toLocaleString('fr-FR') + ' Ar';
                    new bootstrap.Modal(document.getElementById('successModal')).show();
                    document.getElementById('withdrawalForm').reset();
                } else {
                    alert('Erreur: ' + data.message);
                }
            } catch (error) {
                alert('Une erreur est survenue. Veuillez réessayer.');
            }
        });
    </script>
</body>
</html>
