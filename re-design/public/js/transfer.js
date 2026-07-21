console.log("Transfer JS loaded");

// Tab switching
const singleTab = document.getElementById('singleTab');
const multipleTab = document.getElementById('multipleTab');
const singleContent = document.getElementById('singleContent');
const multipleContent = document.getElementById('multipleContent');

if (singleTab && multipleTab) {
    singleTab.addEventListener('click', function() {
        singleTab.classList.add('text-primary', 'border-primary');
        singleTab.classList.remove('text-on-surface-variant', 'border-transparent');
        multipleTab.classList.remove('text-primary', 'border-primary');
        multipleTab.classList.add('text-on-surface-variant', 'border-transparent');
        singleContent.classList.remove('hidden');
        multipleContent.classList.add('hidden');
    });

    multipleTab.addEventListener('click', function() {
        multipleTab.classList.add('text-primary', 'border-primary');
        multipleTab.classList.remove('text-on-surface-variant', 'border-transparent');
        singleTab.classList.remove('text-primary', 'border-primary');
        singleTab.classList.add('text-on-surface-variant', 'border-transparent');
        multipleContent.classList.remove('hidden');
        singleContent.classList.add('hidden');
    });
}

// Operator detection
const destinataireInput = document.getElementById('destinataire');
if (destinataireInput) {
    destinataireInput.addEventListener('blur', async function() {
        const destinataire = this.value;
        const operateurInfo = document.getElementById('operateurInfo');
        const inclureFraisRetraitDiv = document.getElementById('inclureFraisRetraitDiv');
        const fraisInfo = document.querySelector('#inclureFraisRetraitDiv').nextElementSibling;
        
        if (destinataire.length === 3) {
            try {
                const response = await fetch(window.API_URLS.getOperateur + '/' + destinataire);
                const data = await response.json();
                
                if (data.operateur) {
                    if (data.operateur.est_interne == 1) {
                        operateurInfo.innerHTML = '<span class="inline-flex items-center px-2.5 py-1 rounded-full bg-primary-container/10 text-primary font-label-sm text-label-sm border border-primary/20">' + data.operateur.nom + ' (Interne)</span>';
                        inclureFraisRetraitDiv.classList.remove('hidden');
                        fraisInfo.innerHTML = '<span class="material-symbols-outlined text-warning text-[20px]">warning</span><p class="font-body-sm text-body-sm text-on-surface-variant">Des frais seront appliqués selon le montant. Optionnel : inclure frais de retrait anticipés.</p>';
                    } else {
                        operateurInfo.innerHTML = '<span class="inline-flex items-center px-2.5 py-1 rounded-full bg-warning-container/20 text-warning font-label-sm text-label-sm border border-warning/30">' + data.operateur.nom + ' (Externe)</span>';
                        inclureFraisRetraitDiv.classList.add('hidden');
                        fraisInfo.innerHTML = '<span class="material-symbols-outlined text-warning text-[20px]">warning</span><p class="font-body-sm text-body-sm text-on-surface-variant">Commission supplémentaire de ' + data.operateur.taux_commission + '% sera appliquée.</p>';
                    }
                } else {
                    operateurInfo.innerHTML = '<span class="inline-flex items-center px-2.5 py-1 rounded-full bg-error-container/30 text-error font-label-sm text-label-sm border border-error/20">Préfixe non reconnu</span>';
                    inclureFraisRetraitDiv.classList.add('hidden');
                }
            } catch (error) {
                operateurInfo.innerHTML = '';
                inclureFraisRetraitDiv.classList.remove('hidden');
            }
        } else {
            operateurInfo.innerHTML = '';
            inclureFraisRetraitDiv.classList.add('hidden');
        }
    });
}

// Single transfer form
const transferForm = document.getElementById('transferForm');
if (transferForm) {
    transferForm.addEventListener('submit', async function(e) {
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
            const response = await fetch(window.API_URLS.create, {
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
                showSuccessModal();
                transferForm.reset();
                document.getElementById('operateurInfo').innerHTML = '';
                document.getElementById('inclureFraisRetraitDiv').classList.add('hidden');
            } else {
                alert('Erreur: ' + data.message);
            }
        } catch (error) {
            alert('Une erreur est survenue. Veuillez réessayer.');
        }
    });
}

// Multiple transfer - add recipient
const addDestinataireBtn = document.getElementById('addDestinataireBtn');
if (addDestinataireBtn) {
    addDestinataireBtn.addEventListener('click', function() {
        const container = document.getElementById('destinatairesContainer');
        const newRow = document.createElement('div');
        newRow.className = 'flex gap-sm mb-sm destinataire-row';
        newRow.innerHTML = `
            <span class="material-symbols-outlined text-on-surface-variant text-[20px]">person</span>
            <input type="text" class="flex-1 px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none destinataire-input" placeholder="033..." required>
            <button type="button" class="p-2 text-error hover:bg-error/10 rounded-lg transition-colors remove-destinataire">
                <span class="material-symbols-outlined text-[20px]">delete</span>
            </button>
        `;
        container.appendChild(newRow);
        updateRemoveButtons();
    });
}

// Multiple transfer - remove recipient
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
        btn.classList.toggle('hidden', rows.length <= 1);
    });
}

// Multiple transfer form
const multipleTransferForm = document.getElementById('multipleTransferForm');
if (multipleTransferForm) {
    multipleTransferForm.addEventListener('submit', async function(e) {
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
            const response = await fetch(window.API_URLS.createMultiple, {
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
                let message = data.message;
                if (data.total_commission > 0) {
                    message += ' (Commission totale: ' + data.total_commission.toLocaleString('fr-FR') + ' Ar)';
                }
                if (data.total_frais_retrait > 0) {
                    message += ' (Frais retrait anticipé: ' + data.total_frais_retrait.toLocaleString('fr-FR') + ' Ar)';
                }
                
                document.getElementById('successMessage').textContent = message;
                document.getElementById('newSolde').textContent = data.nouveau_solde.toLocaleString('fr-FR') + ' Ar';
                showSuccessModal();
                multipleTransferForm.reset();
                const container = document.getElementById('destinatairesContainer');
                container.innerHTML = `
                    <div class="flex gap-sm mb-sm destinataire-row">
                        <span class="material-symbols-outlined text-on-surface-variant text-[20px]">person</span>
                        <input type="text" class="flex-1 px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none destinataire-input" placeholder="033..." pattern="\d{10}" required>
                        <button type="button" class="p-2 text-error hover:bg-error/10 rounded-lg transition-colors remove-destinataire hidden">
                            <span class="material-symbols-outlined text-[20px]">delete</span>
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
}

// Success modal
const successModal = document.getElementById('successModal');
const closeSuccessModal = document.getElementById('closeSuccessModal');
const closeModalBtn = document.getElementById('closeModalBtn');

function showSuccessModal() {
    successModal.classList.remove('hidden');
    successModal.classList.add('flex');
    successModal.querySelector('.layer-2').classList.add('modal-enter');
}

function hideSuccessModal() {
    successModal.classList.add('hidden');
    successModal.classList.remove('flex');
}

if (closeSuccessModal) closeSuccessModal.addEventListener('click', hideSuccessModal);
if (closeModalBtn) closeModalBtn.addEventListener('click', hideSuccessModal);

successModal.addEventListener('click', (e) => {
    if (e.target === successModal) {
        hideSuccessModal();
    }
});
