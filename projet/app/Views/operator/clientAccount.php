<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comptes Clients</title>
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
                        <a class="nav-link active" href="<?= base_url('/operator/comptes') ?>">
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
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">
                            <i class="bi bi-people"></i> Situation des Comptes Clients
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Numéro</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Solde (Ar)</th>
                                        <th>État</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($comptes as $compte): ?>
                                    <tr>
                                        <td><?= $compte['id'] ?></td>
                                        <td><strong><?= $compte['numero'] ?></strong></td>
                                        <td><?= $compte['nom'] ?></td>
                                        <td><?= $compte['prenom'] ?></td>
                                        <td><?= number_format($compte['solde'], 0, ',', ' ') ?></td>
                                        <td>
                                            <?php 
                                            $badgeClass = 'bg-success';
                                            if($compte['etat_libelle'] == 'Bloqué') $badgeClass = 'bg-danger';
                                            elseif($compte['etat_libelle'] == 'Suspendu') $badgeClass = 'bg-warning';
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= $compte['etat_libelle'] ?></span>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-info" onclick="viewAccount('<?= $compte['numero'] ?>')">
                                                <i class="bi bi-eye"></i> Voir
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning" onclick="changeState('<?= $compte['numero'] ?>')">
                                                <i class="bi bi-gear"></i> État
                                            </button>
                                        </td>
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

    <!-- Change State Modal -->
    <div class="modal fade" id="changeStateModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Changer l'état du compte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="changeStateForm">
                        <input type="hidden" id="accountNumber">
                        <div class="mb-3">
                            <label for="newState" class="form-label">Nouvel état</label>
                            <select class="form-select" id="newState">
                                <?php foreach($etats as $etat): ?>
                                <option value="<?= $etat['id'] ?>"><?= $etat['libelle'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="submitStateChange()">Changer</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script>
        function viewAccount(numero) {
            window.location.href = '<?= base_url('/operator/comptes/view/') ?>' + numero;
        }

        function changeState(numero) {
            document.getElementById('accountNumber').value = numero;
            new bootstrap.Modal(document.getElementById('changeStateModal')).show();
        }

        function submitStateChange() {
            const numero = document.getElementById('accountNumber').value;
            const etat = document.getElementById('newState').value;

            fetch('<?= base_url('/operator/comptes/update-state') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ numero: numero, id_etat: etat })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('État du compte mis à jour avec succès');
                    location.reload();
                } else {
                    alert('Erreur: ' + data.message);
                }
            });
        }
    </script>
</body>
</html>
