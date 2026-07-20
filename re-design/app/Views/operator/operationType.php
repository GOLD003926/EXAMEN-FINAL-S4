<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Types d'Opérations</title>
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
                        <a class="nav-link active" href="<?= base_url('/operator/operations') ?>">
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
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-list-check"></i> Types d'Opérations
                        </h4>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOperationModal">
                            <i class="bi bi-plus-lg"></i> Ajouter
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Code</th>
                                        <th>Libellé</th>
                                        <th>Description</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($operations as $operation): ?>
                                    <tr>
                                        <td><?= $operation['id'] ?></td>
                                        <td><span class="badge bg-secondary"><?= $operation['codes'] ?></span></td>
                                        <td><strong><?= $operation['libelle'] ?></strong></td>
                                        <td><?= $operation['descriptions'] ?></td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-info" onclick="viewFees(<?= $operation['id'] ?>)">
                                                <i class="bi bi-cash"></i> Frais
                                            </button>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editOperation(<?= $operation['id'] ?>)">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteOperation(<?= $operation['id'] ?>)">
                                                <i class="bi bi-trash"></i>
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

    <!-- Add Operation Modal -->
    <div class="modal fade" id="addOperationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un Type d'Opération</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addOperationForm">
                        <div class="mb-3">
                            <label for="opCode" class="form-label">Code</label>
                            <input type="text" class="form-control" id="opCode" placeholder="Ex: DEP" required>
                        </div>
                        <div class="mb-3">
                            <label for="opLibelle" class="form-label">Libellé</label>
                            <input type="text" class="form-control" id="opLibelle" placeholder="Ex: Dépôt" required>
                        </div>
                        <div class="mb-3">
                            <label for="opDesc" class="form-label">Description</label>
                            <textarea class="form-control" id="opDesc" rows="2" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="addOperation()">Ajouter</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fees Modal -->
    <div class="modal fade" id="feesModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Grille des Frais</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="feesContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script>
        function addOperation() {
            const code = document.getElementById('opCode').value;
            const libelle = document.getElementById('opLibelle').value;
            const desc = document.getElementById('opDesc').value;
            
            if (!code || !libelle || !desc) {
                alert('Veuillez remplir tous les champs');
                return;
            }

            fetch('<?= base_url('/operator/operations/create') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ codes: code, libelle: libelle, descriptions: desc })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Type d\'opération ajouté avec succès');
                    location.reload();
                } else {
                    alert('Erreur: ' + data.message);
                }
            });
        }

        function viewFees(operationId) {
            fetch('<?= base_url('/operator/operations/fees/') ?>' + operationId)
                .then(response => response.json())
                .then(data => {
                    let html = '<table class="table table-striped"><thead><tr><th>Min (Ar)</th><th>Max (Ar)</th><th>Frais (Ar)</th><th>Description</th></tr></thead><tbody>';
                    data.fees.forEach(fee => {
                        html += `<tr><td>${fee.somme_min.toLocaleString('fr-FR')}</td><td>${fee.somme_max.toLocaleString('fr-FR')}</td><td>${fee.frais}</td><td>${fee.descriptions}</td></tr>`;
                    });
                    html += '</tbody></table>';
                    document.getElementById('feesContent').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('feesModal')).show();
                });
        }

        function editOperation(id) {
            alert('Fonctionnalité de modification (ID: ' + id + ')');
        }

        function deleteOperation(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce type d\'opération?')) {
                fetch('<?= base_url('/operator/operations/delete') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Type d\'opération supprimé avec succès');
                        location.reload();
                    } else {
                        alert('Erreur: ' + data.message);
                    }
                });
            }
        }
    </script>
</body>
</html>
