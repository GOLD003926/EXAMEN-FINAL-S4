console.log("Operations JS loaded");

// Modal elements
const addOperationModal = document.getElementById('addOperationModal');
const feesModal = document.getElementById('feesModal');
const addOperationBtn = document.getElementById('addOperationBtn');
const closeAddModal = document.getElementById('closeAddModal');
const cancelAdd = document.getElementById('cancelAdd');
const submitAdd = document.getElementById('submitAdd');
const closeFeesModal = document.getElementById('closeFeesModal');
const closeFeesBtn = document.getElementById('closeFeesBtn');

// Open add modal
addOperationBtn.addEventListener('click', () => {
    addOperationModal.classList.remove('hidden');
    addOperationModal.classList.add('flex');
    addOperationModal.querySelector('.layer-2').classList.add('modal-enter');
});

// Close add modal
function closeAddOperationModal() {
    addOperationModal.classList.add('hidden');
    addOperationModal.classList.remove('flex');
    document.getElementById('addOperationForm').reset();
}

closeAddModal.addEventListener('click', closeAddOperationModal);
cancelAdd.addEventListener('click', closeAddOperationModal);

// Close modal on backdrop click
addOperationModal.addEventListener('click', (e) => {
    if (e.target === addOperationModal) {
        closeAddOperationModal();
    }
});

// Submit add operation
submitAdd.addEventListener('click', async () => {
    const code = document.getElementById('opCode').value;
    const libelle = document.getElementById('opLibelle').value;
    const desc = document.getElementById('opDesc').value;
    
    if (!code || !libelle || !desc) {
        alert('Veuillez remplir tous les champs');
        return;
    }

    try {
        const response = await fetch(window.API_URLS.create, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ codes: code, libelle: libelle, descriptions: desc })
        });
        const data = await response.json();
        
        if (data.success) {
            alert('Type d\'opération ajouté avec succès');
            location.reload();
        } else {
            alert('Erreur: ' + data.message);
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Une erreur est survenue');
    }
});

// View fees
document.querySelectorAll('.view-fees-btn').forEach(btn => {
    btn.addEventListener('click', async function() {
        const operationId = this.getAttribute('data-id');
        
        try {
            const response = await fetch(window.API_URLS.fees + operationId);
            const data = await response.json();
            
            let html = '<table class="w-full text-left border-collapse"><thead class="bg-surface-container/50 border-b border-outline-variant/30"><tr><th class="py-md px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Min (Ar)</th><th class="py-md px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Max (Ar)</th><th class="py-md px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Frais (Ar)</th><th class="py-md px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Description</th></tr></thead><tbody class="divide-y divide-outline-variant/20">';
            data.fees.forEach(fee => {
                html += `<tr class="hover:bg-surface-container-lowest transition-colors"><td class="py-md px-lg font-mono-data text-mono-data text-on-surface">${fee.somme_min.toLocaleString('fr-FR')}</td><td class="py-md px-lg font-mono-data text-mono-data text-on-surface">${fee.somme_max.toLocaleString('fr-FR')}</td><td class="py-md px-lg font-mono-data text-mono-data text-on-surface">${fee.frais}</td><td class="py-md px-lg font-body-sm text-body-sm text-on-surface-variant">${fee.descriptions}</td></tr>`;
            });
            html += '</tbody></table>';
            document.getElementById('feesContent').innerHTML = html;
            
            feesModal.classList.remove('hidden');
            feesModal.classList.add('flex');
            feesModal.querySelector('.layer-2').classList.add('modal-enter');
        } catch (error) {
            console.error('Erreur:', error);
            alert('Une erreur est survenue');
        }
    });
});

// Close fees modal
function closeFeesModalFn() {
    feesModal.classList.add('hidden');
    feesModal.classList.remove('flex');
}

closeFeesModal.addEventListener('click', closeFeesModalFn);
closeFeesBtn.addEventListener('click', closeFeesModalFn);

feesModal.addEventListener('click', (e) => {
    if (e.target === feesModal) {
        closeFeesModalFn();
    }
});

// Edit operation
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        alert('Fonctionnalité de modification (ID: ' + id + ')');
    });
});

// Delete operation
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', async function() {
        const id = this.getAttribute('data-id');
        
        if (confirm('Êtes-vous sûr de vouloir supprimer ce type d\'opération?')) {
            try {
                const response = await fetch(window.API_URLS.delete, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id })
                });
                const data = await response.json();
                
                if (data.success) {
                    alert('Type d\'opération supprimé avec succès');
                    location.reload();
                } else {
                    alert('Erreur: ' + data.message);
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Une erreur est survenue');
            }
        }
    });
});
