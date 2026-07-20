<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfert</title>
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
                        <a class="nav-link active" href="<?= base_url('/client/transfert') ?>">
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
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <ul class="nav nav-tabs card-header-tabs" id="transferTabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="single-tab" data-bs-toggle="tab" data-bs-target="#single" type="button">
                                    <i class="bi bi-person"></i> Transfert Simple
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="multiple-tab" data-bs-toggle="tab" data-bs-target="#multiple" type="button">
                                    <i class="bi bi-people"></i> Envoi Multiple
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-4">
                            <i class="bi bi-wallet"></i> Solde actuel: <strong><?= number_format($solde, 0, ',', ' ') ?> Ar</strong>
                        </div>
                        
                        <div class="tab-content">
                            <!-- Transfert Simple -->
                            <div class="tab-pane fade show active" id="single">
                                <form id="transferForm">
                                    <div class="mb-3">
                                        <label for="destinataire" class="form-label">Numéro du destinataire</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control" id="destinataire" placeholder="033..." pattern="\d{10}" required>
                                        </div>
                                        <div class="form-text">10 chiffres requis</div>
                                        <div id="operateurInfo" class="form-text mt-1"></div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="montant" class="form-label">Montant à transférer (Ar)</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text">Ar</span>
                                            <input type="number" class="form-control" id="montant" placeholder="Ex: 50000" min="100" required>
                                        </div>
                                        <div class="form-text">Montant minimum: 100 Ar</div>
                                    </div>
                                    <div class="mb-3" id="inclureFraisRetraitDiv" style="display: none;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="inclureFraisRetrait">
                                            <label class="form-check-label" for="inclureFraisRetrait">
                                                <i class="bi bi-info-circle"></i> Inclure les frais de retrait anticipés
                                            </label>
                                        </div>
                                        <div class="form-text text-muted">
                                            Le destinataire pourra retirer l'argent sans frais supplémentaires
                                        </div>
                                    </div>
                                    <div class="alert alert-warning" id="fraisInfo">
                                        <i class="bi bi-exclamation-triangle"></i> Des frais seront appliqués selon le montant.
                                    </div>
                                    <button type="submit" class="btn btn-warning w-100 btn-lg">
                                        <i class="bi bi-arrow-right-circle"></i> Effectuer le Transfert
                                    </button>
                                </form>
                            </div>
                            
                            <!-- Envoi Multiple -->
                            <div class="tab-pane fade" id="multiple">
                                <form id="multipleTransferForm">
                                    <div class="mb-3">
                                        <label for="montantTotal" class="form-label">Montant total à envoyer (Ar)</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text">Ar</span>
                                            <input type="number" class="form-control" id="montantTotal" placeholder="Ex: 150000" min="100" required>
                                        </div>
                                        <div class="form-text">Ce montant sera divisé équitablement entre tous les destinataires</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Destinataires (internes uniquement)</label>
                                        <div id="destinatairesContainer">
                                            <div class="input-group mb-2 destinataire-row">
                                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                <input type="text" class="form-control destinataire-input" placeholder="033..." pattern="\d{10}" required>
                                                <button type="button" class="btn btn-outline-danger remove-destinataire" style="display: none;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addDestinataireBtn">
                                            <i class="bi bi-plus"></i> Ajouter un destinataire
                                        </button>
                                        <div class="form-text mt-2">Minimum 2 destinataires pour l'envoi multiple</div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="inclureFraisRetraitMultiple">
                                            <label class="form-check-label" for="inclureFraisRetraitMultiple">
                                                <i class="bi bi-info-circle"></i> Inclure les frais de retrait anticipés pour tous
                                            </label>
                                        </div>
                                    </div>
                                    <div class="alert alert-warning">
                                        <i class="bi bi-exclamation-triangle"></i> L'envoi multiple n'est disponible que pour les destinataires du même opérateur (interne).
                                    </div>
                                    <button type="submit" class="btn btn-warning w-100 btn-lg">
                                        <i class="bi bi-people"></i> Envoyer à Plusieurs
                                    </button>
                                </form>
                            </div>
                        </div>
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
                        <i class="bi bi-check-circle"></i> Transfert Réussi
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
        // Détection de l'opérateur du destinataire
        document.getElementById('destinataire').addEventListener('blur', async function() {
            const destinataire = this.value;
            const operateurInfo = document.getElementById('operateurInfo');
            const inclureFraisRetraitDiv = document.getElementById('inclureFraisRetraitDiv');
            const fraisInfo = document.getElementById('fraisInfo');
            
            if (destinataire.length === 3) {
                // Récupérer l'opérateur via le préfixe
                try {
                    const response = await fetch('<?= base_url('/operator/prefixes/get-operateur') ?>/' + destinataire);
                    const data = await response.json();
                    
                    if (data.operateur) {
                        if (data.operateur.est_interne == 1) {
                            operateurInfo.innerHTML = '<span class="badge bg-success">' + data.operateur.nom + ' (Interne)</span>';
                            inclureFraisRetraitDiv.style.display = 'block';
                            fraisInfo.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Des frais seront appliqués selon le montant. Optionnel : inclure frais de retrait anticipés.';
                        } else {
                            operateurInfo.innerHTML = '<span class="badge bg-warning">' + data.operateur.nom + ' (Externe)</span>';
                            inclureFraisRetraitDiv.style.display = 'none';
                            fraisInfo.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Commission supplémentaire de ' + data.operateur.taux_commission + '% sera appliquée.';
                        }
                    } else {
                        operateurInfo.innerHTML = '<span class="badge bg-danger">Préfixe non reconnu</span>';
                        inclureFraisRetraitDiv.style.display = 'none';
                    }
                } catch (error) {
                    // En cas d'erreur, on suppose que c'est interne par défaut
                    operateurInfo.innerHTML = '';
                    inclureFraisRetraitDiv.style.display = 'block';
                }
            } else {
                operateurInfo.innerHTML = '';
                inclureFraisRetraitDiv.style.display = 'none';
            }
        });

        // Transfert simple
        document.getElementById('transferForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const destinataire = document.getElementById('destinataire').value;
            const montant = document.getElementById('montant').value;
            const inclureFraisRetrait = document.getElementById('inclureFraisRetrait').checked;
            
            if (!destinataire || !/^\d{10}$/.test(destinataire)) {
                alert('Le numéro du destinataire doit contenir 10 chiffres');
                return;
            }

            if (!montant || montant < 100) {
                alert('Le montant minimum est de 100 Ar');
                return;
            }

            try {
                const response = await fetch('<?= base_url('/client/transfert/create') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ 
                        destinataire: destinataire,
                        montant: parseFloat(montant),
                        inclure_frais_retrait: inclureFraisRetrait
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    let message = data.message;
                    if (data.commission > 0) {
                        message += ' (Commission: ' + data.commission.toLocaleString('fr-FR') + ' Ar)';
                    }
                    if (data.frais_retrait_anticipé > 0) {
                        message += ' (Frais retrait anticipé: ' + data.frais_retrait_anticipé.toLocaleString('fr-FR') + ' Ar)';
                    }
                    
                    document.getElementById('successMessage').textContent = message;
                    document.getElementById('newSolde').textContent = data.nouveau_solde.toLocaleString('fr-FR') + ' Ar';
                    new bootstrap.Modal(document.getElementById('successModal')).show();
                    document.getElementById('transferForm').reset();
                    document.getElementById('operateurInfo').innerHTML = '';
                    document.getElementById('inclureFraisRetraitDiv').style.display = 'none';
                } else {
                    alert('Erreur: ' + data.message);
                }
            } catch (error) {
                alert('Une erreur est survenue. Veuillez réessayer.');
            }
        });

        // Gestion des destinataires multiples
        document.getElementById('addDestinataireBtn').addEventListener('click', function() {
            const container = document.getElementById('destinatairesContainer');
            const newRow = document.createElement('div');
            newRow.className = 'input-group mb-2 destinataire-row';
            newRow.innerHTML = `
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control destinataire-input" placeholder="033..." pattern="\d{10}" required>
                <button type="button" class="btn btn-outline-danger remove-destinataire">
                    <i class="bi bi-trash"></i>
                </button>
            `;
            container.appendChild(newRow);
            updateRemoveButtons();
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-destinataire')) {
                e.target.closest('.destinataire-row').remove();
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.destinataire-row');
            rows.forEach(row => {
                const btn = row.querySelector('.remove-destinataire');
                btn.style.display = rows.length > 1 ? 'block' : 'none';
            });
        }

        // Envoi multiple
        document.getElementById('multipleTransferForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const montantTotal = document.getElementById('montantTotal').value;
            const inclureFraisRetrait = document.getElementById('inclureFraisRetraitMultiple').checked;
            
            const destinataires = [];
            document.querySelectorAll('.destinataire-input').forEach(input => {
                if (input.value && /^\d{10}$/.test(input.value)) {
                    destinataires.push(input.value);
                }
            });

            if (destinataires.length < 2) {
                alert('Minimum 2 destinataires requis pour l\'envoi multiple');
                return;
            }

            if (!montantTotal || montantTotal < 100) {
                alert('Le montant minimum est de 100 Ar');
                return;
            }

            try {
                const response = await fetch('<?= base_url('/client/transfert/createMultiple') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ 
                        montant_total: parseFloat(montantTotal),
                        destinataires: destinataires,
                        inclure_frais_retrait: inclureFraisRetrait
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('successMessage').textContent = data.message;
                    document.getElementById('newSolde').textContent = data.nouveau_solde.toLocaleString('fr-FR') + ' Ar';
                    new bootstrap.Modal(document.getElementById('successModal')).show();
                    document.getElementById('multipleTransferForm').reset();
                    // Réinitialiser les champs de destinataires
                    const container = document.getElementById('destinatairesContainer');
                    container.innerHTML = `
                        <div class="input-group mb-2 destinataire-row">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control destinataire-input" placeholder="033..." pattern="\d{10}" required>
                            <button type="button" class="btn btn-outline-danger remove-destinataire" style="display: none;">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;
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
