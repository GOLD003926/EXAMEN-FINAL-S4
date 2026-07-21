console.log("Prefixes JS loaded");

// Modal elements
const addPrefixModal = document.getElementById('addPrefixModal');
const editPrefixModal = document.getElementById('editPrefixModal');
const addPrefixBtn = document.getElementById('addPrefixBtn');
const closeAddModal = document.getElementById('closeAddModal');
const cancelAdd = document.getElementById('cancelAdd');
const submitAdd = document.getElementById('submitAdd');
const closeEditModal = document.getElementById('closeEditModal');
const cancelEdit = document.getElementById('cancelEdit');
const submitEdit = document.getElementById('submitEdit');

// Open add modal
addPrefixBtn.addEventListener('click', () => {
    addPrefixModal.classList.remove('hidden');
    addPrefixModal.classList.add('flex');
    addPrefixModal.querySelector('.layer-2').classList.add('modal-enter');
});

// Close add modal
function closeAddPrefixModal() {
    addPrefixModal.classList.add('hidden');
    addPrefixModal.classList.remove('flex');
    document.getElementById('addPrefixForm').reset();
}

closeAddModal.addEventListener('click', closeAddPrefixModal);
cancelAdd.addEventListener('click', closeAddPrefixModal);

addPrefixModal.addEventListener('click', (e) => {
    if (e.target === addPrefixModal) {
        closeAddPrefixModal();
    }
});

// Submit add prefix
submitAdd.addEventListener('click', async () => {
    const form = document.getElementById('addPrefixForm');
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    
    if (!data.codes || !data.descriptions || !data.id_operateur) {
        alert('Veuillez remplir tous les champs');
        return;
    }

    try {
        const response = await fetch(window.API_URLS.create, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        
        if (result.success) {
            alert('Préfixe ajouté avec succès');
            location.reload();
        } else {
            alert('Erreur: ' + result.message);
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Une erreur est survenue');
    }
});

// Edit prefix
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const prefix = JSON.parse(this.getAttribute('data-prefix'));
        
        document.getElementById('editId').value = prefix.id;
        document.getElementById('editCode').value = prefix.codes;
        document.getElementById('editDesc').value = prefix.descriptions;
        document.getElementById('editOperateur').value = prefix.id_operateur || '';
        
        editPrefixModal.classList.remove('hidden');
        editPrefixModal.classList.add('flex');
        editPrefixModal.querySelector('.layer-2').classList.add('modal-enter');
    });
});

// Close edit modal
function closeEditPrefixModal() {
    editPrefixModal.classList.add('hidden');
    editPrefixModal.classList.remove('flex');
}

closeEditModal.addEventListener('click', closeEditPrefixModal);
cancelEdit.addEventListener('click', closeEditPrefixModal);

editPrefixModal.addEventListener('click', (e) => {
    if (e.target === editPrefixModal) {
        closeEditPrefixModal();
    }
});

// Submit edit prefix
submitEdit.addEventListener('click', async () => {
    const form = document.getElementById('editPrefixForm');
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    
    if (!data.codes || !data.descriptions || !data.id_operateur) {
        alert('Veuillez remplir tous les champs');
        return;
    }

    try {
        const response = await fetch(window.API_URLS.update, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        
        if (result.success) {
            alert('Préfixe modifié avec succès');
            location.reload();
        } else {
            alert('Erreur: ' + result.message);
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Une erreur est survenue');
    }
});

// Delete prefix
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', async function() {
        const id = this.getAttribute('data-id');
        
        if (confirm('Êtes-vous sûr de vouloir supprimer ce préfixe?')) {
            try {
                const response = await fetch(window.API_URLS.delete, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id })
                });
                const result = await response.json();
                
                if (result.success) {
                    alert('Préfixe supprimé avec succès');
                    location.reload();
                } else {
                    alert('Erreur: ' + result.message);
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Une erreur est survenue');
            }
        }
    });
});
