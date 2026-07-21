console.log("Operations JS loaded");

// Modal elements
const addOperationModal = document.getElementById('addOperationModal');
const editOperationModal = document.getElementById('editOperationModal');
const feesModal = document.getElementById('feesModal');
const feeModal = document.getElementById('feeModal');
const addOperationBtn = document.getElementById('addOperationBtn');
const closeAddModal = document.getElementById('closeAddModal');
const cancelAdd = document.getElementById('cancelAdd');
const submitAdd = document.getElementById('submitAdd');
const closeEditModal = document.getElementById('closeEditModal');
const cancelEdit = document.getElementById('cancelEdit');
const submitEdit = document.getElementById('submitEdit');
const closeFeesModal = document.getElementById('closeFeesModal');
const closeFeesBtn = document.getElementById('closeFeesBtn');
const addFeeBtn = document.getElementById('addFeeBtn');
const closeFeeModal = document.getElementById('closeFeeModal');
const cancelFee = document.getElementById('cancelFee');
const submitFee = document.getElementById('submitFee');

let currentOperationId = null;

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
        currentOperationId = operationId;
        
        await loadFees(operationId);
        
        feesModal.classList.remove('hidden');
        feesModal.classList.add('flex');
        feesModal.querySelector('.layer-2').classList.add('modal-enter');
    });
});

async function loadFees(operationId) {
    try {
        const response = await fetch(window.API_URLS.fees + operationId);
        const data = await response.json();
        
        let html = '<table class="w-full text-left border-collapse"><thead class="bg-surface-container/50 border-b border-outline-variant/30"><tr><th class="py-md px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Min (Ar)</th><th class="py-md px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Max (Ar)</th><th class="py-md px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Frais (Ar)</th><th class="py-md px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Description</th><th class="py-md px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider text-right">Actions</th></tr></thead><tbody class="divide-y divide-outline-variant/20">';
        
        if (data.fees && data.fees.length > 0) {
            data.fees.forEach(fee => {
                html += `<tr class="hover:bg-surface-container-lowest transition-colors">
                    <td class="py-md px-lg font-mono-data text-mono-data text-on-surface">${fee.somme_min.toLocaleString('fr-FR')}</td>
                    <td class="py-md px-lg font-mono-data text-mono-data text-on-surface">${fee.somme_max.toLocaleString('fr-FR')}</td>
                    <td class="py-md px-lg font-mono-data text-mono-data text-on-surface">${fee.frais}</td>
                    <td class="py-md px-lg font-body-sm text-body-sm text-on-surface-variant">${fee.descriptions}</td>
                    <td class="py-md px-lg text-right whitespace-nowrap">
                        <button class="edit-fee-btn text-on-surface-variant hover:text-primary transition-colors p-xs rounded-full" data-id="${fee.id}" data-min="${fee.somme_min}" data-max="${fee.somme_max}" data-fee="${fee.frais}" data-desc="${fee.descriptions}">
                            <span class="material-symbols-outlined text-[18px]" data-icon="edit">edit</span>
                        </button>
                        <button class="delete-fee-btn text-on-surface-variant hover:text-error transition-colors p-xs rounded-full" data-id="${fee.id}">
                            <span class="material-symbols-outlined text-[18px]" data-icon="delete">delete</span>
                        </button>
                    </td>
                </tr>`;
            });
        } else {
            html += '<tr><td colspan="5" class="py-md px-lg text-center text-on-surface-variant">Aucune tranche de frais définie</td></tr>';
        }
        
        html += '</tbody></table>';
        document.getElementById('feesContent').innerHTML = html;

        // Attach event listeners to edit and delete buttons
        document.querySelectorAll('.edit-fee-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const min = this.getAttribute('data-min');
                const max = this.getAttribute('data-max');
                const fee = this.getAttribute('data-fee');
                const desc = this.getAttribute('data-desc');

                document.getElementById('feeId').value = id;
                document.getElementById('feeOperationId').value = currentOperationId;
                document.getElementById('feeMin').value = min;
                document.getElementById('feeMax').value = max;
                document.getElementById('feeAmount').value = fee;
                document.getElementById('feeDesc').value = desc;
                document.getElementById('feeModalTitle').textContent = 'Modifier la Tranche';

                feeModal.classList.remove('hidden');
                feeModal.classList.add('flex');
                feeModal.querySelector('.layer-2').classList.add('modal-enter');
            });
        });

        document.querySelectorAll('.delete-fee-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                const id = this.getAttribute('data-id');
                
                if (confirm('Êtes-vous sûr de vouloir supprimer cette tranche de frais?')) {
                    try {
                        const response = await fetch(window.API_URLS.deleteFee, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ id: id })
                        });
                        const data = await response.json();
                        
                        if (data.success) {
                            alert('Tranche supprimée avec succès');
                            loadFees(currentOperationId);
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
    } catch (error) {
        console.error('Erreur:', error);
        alert('Une erreur est survenue');
    }
}

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

// Add fee button
addFeeBtn.addEventListener('click', () => {
    document.getElementById('feeId').value = '';
    document.getElementById('feeOperationId').value = currentOperationId;
    document.getElementById('feeMin').value = '';
    document.getElementById('feeMax').value = '';
    document.getElementById('feeAmount').value = '';
    document.getElementById('feeDesc').value = '';
    document.getElementById('feeModalTitle').textContent = 'Ajouter une Tranche';

    feeModal.classList.remove('hidden');
    feeModal.classList.add('flex');
    feeModal.querySelector('.layer-2').classList.add('modal-enter');
});

// Close fee modal
function closeFeeModalFn() {
    feeModal.classList.add('hidden');
    feeModal.classList.remove('flex');
    document.getElementById('feeForm').reset();
}

closeFeeModal.addEventListener('click', closeFeeModalFn);
cancelFee.addEventListener('click', closeFeeModalFn);

feeModal.addEventListener('click', (e) => {
    if (e.target === feeModal) {
        closeFeeModalFn();
    }
});

// Submit fee form
submitFee.addEventListener('click', async () => {
    const id = document.getElementById('feeId').value;
    const operationId = document.getElementById('feeOperationId').value;
    const min = document.getElementById('feeMin').value;
    const max = document.getElementById('feeMax').value;
    const fee = document.getElementById('feeAmount').value;
    const desc = document.getElementById('feeDesc').value;
    
    if (!min || !max || !fee) {
        alert('Veuillez remplir tous les champs obligatoires');
        return;
    }

    try {
        const url = id ? window.API_URLS.updateFee : window.API_URLS.createFee;
        const body = id 
            ? { id: id, frais: fee, somme_min: min, somme_max: max, descriptions: desc }
            : { id_type_operation: operationId, somme_min: min, somme_max: max, frais: fee, descriptions: desc };

        const response = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(body)
        });
        const data = await response.json();
        
        if (data.success) {
            alert(id ? 'Tranche modifiée avec succès' : 'Tranche ajoutée avec succès');
            closeFeeModalFn();
            loadFees(currentOperationId);
        } else {
            alert('Erreur: ' + data.message);
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Une erreur est survenue');
    }
});

// Edit operation
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', async function() {
        const id = this.getAttribute('data-id');
        const row = this.closest('tr');
        const code = row.querySelector('td:nth-child(2)').textContent.trim();
        const libelle = row.querySelector('td:nth-child(3)').textContent.trim();
        const desc = row.querySelector('td:nth-child(4)').textContent.trim();

        document.getElementById('editOpId').value = id;
        document.getElementById('editOpCode').value = code;
        document.getElementById('editOpLibelle').value = libelle;
        document.getElementById('editOpDesc').value = desc;

        editOperationModal.classList.remove('hidden');
        editOperationModal.classList.add('flex');
        editOperationModal.querySelector('.layer-2').classList.add('modal-enter');
    });
});

// Close edit modal
function closeEditOperationModal() {
    editOperationModal.classList.add('hidden');
    editOperationModal.classList.remove('flex');
    document.getElementById('editOperationForm').reset();
}

closeEditModal.addEventListener('click', closeEditOperationModal);
cancelEdit.addEventListener('click', closeEditOperationModal);

editOperationModal.addEventListener('click', (e) => {
    if (e.target === editOperationModal) {
        closeEditOperationModal();
    }
});

// Submit edit operation
submitEdit.addEventListener('click', async () => {
    const id = document.getElementById('editOpId').value;
    const code = document.getElementById('editOpCode').value;
    const libelle = document.getElementById('editOpLibelle').value;
    const desc = document.getElementById('editOpDesc').value;
    
    if (!code || !libelle || !desc) {
        alert('Veuillez remplir tous les champs');
        return;
    }

    try {
        const response = await fetch(window.API_URLS.update, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id, codes: code, libelle: libelle, descriptions: desc })
        });
        const data = await response.json();
        
        if (data.success) {
            alert('Type d\'opération mis à jour avec succès');
            location.reload();
        } else {
            alert('Erreur: ' + data.message);
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Une erreur est survenue');
    }
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
