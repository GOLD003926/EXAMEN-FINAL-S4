<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Opérateurs</title>
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
                        <a class="nav-link" href="<?= base_url('/operator/gains') ?>">
                            <i class="bi bi-graph-up"></i> Gains
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/operator/comptes') ?>">
                            <i class="bi bi-people"></i> Comptes Clients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('/operator/operateurs') ?>">
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="bi bi-building"></i> Gestion des Opérateurs
            </h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOperateurModal">
                <i class="bi bi-plus-lg"></i> Ajouter un Opérateur
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Taux Commission</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($operateurs as $operateur): ?>
                            <tr>
                                <td><?= $operateur['id'] ?></td>
                                <td><?= $operateur['nom'] ?></td>
                                <td><span class="badge bg-secondary"><?= $operateur['code'] ?></span></td>
                                <td>
                                    <?php if($operateur['est_interne'] == 1): ?>
                                        <span class="badge bg-success">Interne (Nous)</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Externe</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= number_format($operateur['taux_commission'], 2, ',', ' ') ?>%</td>
                                <td><?= $operateur['descriptions'] ?? '-' ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" onclick="editOperateur(<?= htmlspecialchars(json_encode($operateur)) ?>)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <?php if($operateur['est_interne'] != 1): ?>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteOperateur(<?= $operateur['id'] ?>)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ajout Opérateur -->
    <div class="modal fade" id="addOperateurModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un Opérateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addOperateurForm">
                        <div class="mb-3">
                            <label class="form-label">Nom de l'opérateur</label>
                            <input type="text" class="form-control" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Code</label>
                            <input type="text" class="form-control" name="code" required placeholder="Ex: TEL, ORA">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="est_interne" required>
                                <option value="0">Externe</option>
                                <option value="1">Interne (Nous)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Taux de commission (%)</label>
                            <input type="number" step="0.01" class="form-control" name="taux_commission" required placeholder="Ex: 5.5">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="descriptions" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="createOperateur()">Ajouter</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Modification Opérateur -->
    <div class="modal fade" id="editOperateurModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier l'Opérateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editOperateurForm">
                        <input type="hidden" name="id" id="editId">
                        <div class="mb-3">
                            <label class="form-label">Nom de l'opérateur</label>
                            <input type="text" class="form-control" name="nom" id="editNom" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Code</label>
                            <input type="text" class="form-control" name="code" id="editCode" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="est_interne" id="editEstInterne" required>
                                <option value="0">Externe</option>
                                <option value="1">Interne (Nous)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Taux de commission (%)</label>
                            <input type="number" step="0.01" class="form-control" name="taux_commission" id="editTauxCommission" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="descriptions" id="editDescriptions" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="updateOperateur()">Modifier</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script>
        // Créer un opérateur
        async function createOperateur() {
            const form = document.getElementById('addOperateurForm');
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            
            try {
                const response = await fetch('<?= base_url('/operator/operateurs/create') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('Opérateur créé avec succès');
                    location.reload();
                } else {
                    alert('Erreur: ' + result.message);
                }
            } catch (error) {
                alert('Erreur lors de la création');
            }
        }

        // Modifier un opérateur
        function editOperateur(operateur) {
            document.getElementById('editId').value = operateur.id;
            document.getElementById('editNom').value = operateur.nom;
            document.getElementById('editCode').value = operateur.code;
            document.getElementById('editEstInterne').value = operateur.est_interne;
            document.getElementById('editTauxCommission').value = operateur.taux_commission;
            document.getElementById('editDescriptions').value = operateur.descriptions || '';
            
            new bootstrap.Modal(document.getElementById('editOperateurModal')).show();
        }

        async function updateOperateur() {
            const form = document.getElementById('editOperateurForm');
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            
            try {
                const response = await fetch('<?= base_url('/operator/operateurs/update') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('Opérateur mis à jour avec succès');
                    location.reload();
                } else {
                    alert('Erreur: ' + result.message);
                }
            } catch (error) {
                alert('Erreur lors de la modification');
            }
        }

        // Supprimer un opérateur
        async function deleteOperateur(id) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet opérateur ?')) return;
            
            try {
                const response = await fetch('<?= base_url('/operator/operateurs/delete') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('Opérateur supprimé avec succès');
                    location.reload();
                } else {
                    alert('Erreur: ' + result.message);
                }
            } catch (error) {
                alert('Erreur lors de la suppression');
            }
        }
    </script>
</body>
</html>
