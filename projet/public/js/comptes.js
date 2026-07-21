console.log("Comptes JS loaded");

// Modal elements
const changeStateModal = document.getElementById('changeStateModal');
const closeStateModal = document.getElementById('closeStateModal');
const cancelState = document.getElementById('cancelState');
const submitState = document.getElementById('submitState');

// View account
document.querySelectorAll('.view-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const numero = this.getAttribute('data-numero');
        window.location.href = window.API_URLS.view + numero;
    });
});

// Change state
document.querySelectorAll('.state-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const numero = this.getAttribute('data-numero');
        document.getElementById('accountNumber').value = numero;
        
        changeStateModal.classList.remove('hidden');
        changeStateModal.classList.add('flex');
        changeStateModal.querySelector('.layer-2').classList.add('modal-enter');
    });
});

// Close state modal
function closeStateModalFn() {
    changeStateModal.classList.add('hidden');
    changeStateModal.classList.remove('flex');
}

closeStateModal.addEventListener('click', closeStateModalFn);
cancelState.addEventListener('click', closeStateModalFn);

changeStateModal.addEventListener('click', (e) => {
    if (e.target === changeStateModal) {
        closeStateModalFn();
    }
});

// Submit state change
submitState.addEventListener('click', async () => {
    const numero = document.getElementById('accountNumber').value;
    const etat = document.getElementById('newState').value;

    try {
        const response = await fetch(window.API_URLS.updateState, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ numero: numero, id_etat: etat })
        });
        const data = await response.json();
        
        if (data.success) {
            alert('État du compte mis à jour avec succès');
            location.reload();
        } else {
            alert('Erreur: ' + data.message);
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Une erreur est survenue');
    }
});
