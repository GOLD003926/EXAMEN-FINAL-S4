console.log("Operateurs JS loaded");

// Modal elements
const addOperateurBtn = document.getElementById('addOperateurBtn');
const addOperateurModal = document.getElementById('addOperateurModal');
const closeAddModal = document.getElementById('closeAddModal');
const cancelAdd = document.getElementById('cancelAdd');
const submitAdd = document.getElementById('submitAdd');

const editOperateurModal = document.getElementById('editOperateurModal');
const closeEditModal = document.getElementById('closeEditModal');
const cancelEdit = document.getElementById('cancelEdit');
const submitEdit = document.getElementById('submitEdit');

// Open add modal
if (addOperateurBtn) {
    addOperateurBtn.addEventListener('click', function() {
        addOperateurModal.classList.remove('hidden');
        addOperateurModal.classList.add('flex');
        addOperateurModal.querySelector('.layer-2').classList.add('modal-enter');
    });
}

// Close add modal
function closeAddModalFn() {
    addOperateurModal.classList.add('hidden');
    addOperateurModal.classList.remove('flex');
    document.getElementById('addOperateurForm').reset();
}

closeAddModal.addEventListener('click', closeAddModalFn);
cancelAdd.addEventListener('click', closeAddModalFn);

addOperateurModal.addEventListener('click', (e) => {
    if (e.target === addOperateurModal) {
        closeAddModalFn();
    }
});

// Close edit modal
function closeEditModalFn() {
    editOperateurModal.classList.add('hidden');
    editOperateurModal.classList.remove('flex');
}

closeEditModal.addEventListener('click', closeEditModalFn);
cancelEdit.addEventListener('click', closeEditModalFn);

editOperateurModal.addEventListener('click', (e) => {
    if (e.target === editOperateurModal) {
        closeEditModalFn();
    }
});

// Create operateur
if (submitAdd) {
    submitAdd.addEventListener('click', async function() {
        const form = document.getElementById('addOperateurForm');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        try {
            const response = await fetch(window.API_URLS.create, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.success) {
                closeAddModalFn();
                location.reload();
            } else {
                alert('Erreur: ' + result.message);
            }
        } catch (error) {
            alert('Erreur lors de la création');
        }
    });
}

// Edit operateur
window.editOperateur = function(operateur) {
    document.getElementById('editId').value = operateur.id;
    document.getElementById('editNom').value = operateur.nom;
    document.getElementById('editCode').value = operateur.code;
    document.getElementById('editEstInterne').value = operateur.est_interne;
    document.getElementById('editTauxCommission').value = operateur.taux_commission;
    document.getElementById('editDescriptions').value = operateur.descriptions || '';
    
    editOperateurModal.classList.remove('hidden');
    editOperateurModal.classList.add('flex');
    editOperateurModal.querySelector('.layer-2').classList.add('modal-enter');
};

// Update operateur
if (submitEdit) {
    submitEdit.addEventListener('click', async function() {
        const form = document.getElementById('editOperateurForm');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        try {
            const response = await fetch(window.API_URLS.update, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.success) {
                closeEditModalFn();
                location.reload();
            } else {
                alert('Erreur: ' + result.message);
            }
        } catch (error) {
            alert('Erreur lors de la modification');
        }
    });
}

// Delete operateur
window.deleteOperateur = async function(id) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer cet opérateur ?')) return;
    
    try {
        const response = await fetch(window.API_URLS.delete, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });
        
        const result = await response.json();
        
        if (result.success) {
            location.reload();
        } else {
            alert('Erreur: ' + result.message);
        }
    } catch (error) {
        alert('Erreur lors de la suppression');
    }
};
