<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration des Préfixes</title>
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
                        <a class="nav-link active" href="<?= base_url('/operator/prefixes') ?>">
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
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-hash"></i> Configuration des Préfixes
                        </h4>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPrefixModal">
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
                                        <th>Description</th>
                                        <th>Opérateur Associé</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($prefixes as $prefix): ?>
                                    <tr>
                                        <td><?= $prefix['id'] ?></td>
                                        <td><span class="badge bg-primary"><?= $prefix['codes'] ?></span></td>
                                        <td><?= $prefix['descriptions'] ?></td>
                                        <td>
                                            <?php if(isset($prefix['operateur_nom'])): ?>
                                                <?php if($prefix['est_interne'] == 1): ?>
                                                    <span class="badge bg-success"><?= $prefix['operateur_nom'] ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning"><?= $prefix['operateur_nom'] ?></span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Non assigné</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-primary" onclick="editPrefix(<?= htmlspecialchars(json_encode($prefix)) ?>)">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deletePrefix(<?= $prefix['id'] ?>)">
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

    <!-- Add Prefix Modal -->
    <div class="modal fade" id="addPrefixModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un Préfixe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addPrefixForm">
                        <div class="mb-3">
                            <label for="prefixCode" class="form-label">Code du préfixe</label>
                            <input type="text" class="form-control" id="prefixCode" name="codes" placeholder="Ex: 034" required>
                        </div>
                        <div class="mb-3">
                            <label for="prefixDesc" class="form-label">Description</label>
                            <input type="text" class="form-control" id="prefixDesc" name="descriptions" placeholder="Ex: Airtel" required>
                        </div>
                        <div class="mb-3">
                            <label for="prefixOperateur" class="form-label">Opérateur Associé</label>
                            <select class="form-select" id="prefixOperateur" name="id_operateur" required>
                                <option value="">Sélectionner un opérateur</option>
                                <?php if(isset($operateurs)): ?>
                                    <?php foreach($operateurs as $operateur): ?>
                                        <option value="<?= $operateur['id'] ?>">
                                            <?= $operateur['nom'] ?> (<?= $operateur['est_interne'] == 1 ? 'Interne' : 'Externe' ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="addPrefix()">Ajouter</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Prefix Modal -->
    <div class="modal fade" id="editPrefixModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier le Préfixe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editPrefixForm">
                        <input type="hidden" id="editId" name="id">
                        <div class="mb-3">
                            <label for="editCode" class="form-label">Code du préfixe</label>
                            <input type="text" class="form-control" id="editCode" name="codes" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDesc" class="form-label">Description</label>
                            <input type="text" class="form-control" id="editDesc" name="descriptions" required>
                        </div>
                        <div class="mb-3">
                            <label for="editOperateur" class="form-label">Opérateur Associé</label>
                            <select class="form-select" id="editOperateur" name="id_operateur" required>
                                <option value="">Sélectionner un opérateur</option>
                                <?php if(isset($operateurs)): ?>
                                    <?php foreach($operateurs as $operateur): ?>
                                        <option value="<?= $operateur['id'] ?>">
                                            <?= $operateur['nom'] ?> (<?= $operateur['est_interne'] == 1 ? 'Interne' : 'Externe' ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="updatePrefix()">Modifier</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script>
        function addPrefix() {
            const form = document.getElementById('addPrefixForm');
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            
            if (!data.codes || !data.descriptions || !data.id_operateur) {
                alert('Veuillez remplir tous les champs');
                return;
            }

            fetch('<?= base_url('/operator/prefixes/create') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Préfixe ajouté avec succès');
                    location.reload();
                } else {
                    alert('Erreur: ' + data.message);
                }
            });
        }

        function editPrefix(prefix) {
            document.getElementById('editId').value = prefix.id;
            document.getElementById('editCode').value = prefix.codes;
            document.getElementById('editDesc').value = prefix.descriptions;
            document.getElementById('editOperateur').value = prefix.id_operateur || '';
            
            new bootstrap.Modal(document.getElementById('editPrefixModal')).show();
        }

        function updatePrefix() {
            const form = document.getElementById('editPrefixForm');
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            
            if (!data.codes || !data.descriptions || !data.id_operateur) {
                alert('Veuillez remplir tous les champs');
                return;
            }

            fetch('<?= base_url('/operator/prefixes/update') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Préfixe modifié avec succès');
                    location.reload();
                } else {
                    alert('Erreur: ' + data.message);
                }
            });
        }

        function deletePrefix(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce préfixe?')) {
                fetch('<?= base_url('/operator/prefixes/delete') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Préfixe supprimé avec succès');
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
