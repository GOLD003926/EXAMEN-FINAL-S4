console.log("TableauBord JS loaded");

// Modal functions
window.openModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.querySelector('.layer-2').classList.add('modal-enter');
        
        // Refresh balance when opening withdrawal modal
        if (modalId === 'retraitModal') {
            refreshBalance();
        }
    }
};

window.closeModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
};

// Close modals on backdrop click
document.querySelectorAll('.fixed.inset-0').forEach(modal => {
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });
});

// Refresh balance
window.refreshBalance = async function() {
    try {
        const response = await fetch(window.API_URLS.getBalance);
        const data = await response.json();
        
        if (data.success) {
            const balanceText = data.solde.toLocaleString('fr-FR') + ' Ar';
            const balanceAmount = document.getElementById('balanceAmount');
            const withdrawalBalance = document.getElementById('withdrawalBalance');
            
            if (balanceAmount) balanceAmount.textContent = balanceText;
            if (withdrawalBalance) withdrawalBalance.textContent = balanceText;
        }
    } catch (error) {
        console.error('Error refreshing balance:', error);
    }
};

// Deposit form
const depositForm = document.getElementById('depositForm');
if (depositForm) {
    depositForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const montant = document.getElementById('depositMontant').value;
        
        if (!montant || montant < 100) {
            alert('Le montant minimum est de 100 Ar');
            return;
        }

        try {
            const response = await fetch(window.API_URLS.createDeposit, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ montant: parseFloat(montant) })
            });
            
            const data = await response.json();
            
            if (data.success) {
                document.getElementById('successMessage').textContent = data.message;
                document.getElementById('newSolde').textContent = data.nouveau_solde.toLocaleString('fr-FR') + ' Ar';
                closeModal('depotModal');
                openModal('successModal');
                depositForm.reset();
                refreshBalance();
            } else {
                alert('Erreur: ' + data.message);
            }
        } catch (error) {
            alert('Une erreur est survenue. Veuillez réessayer.');
        }
    });
}

// Withdrawal form
const withdrawalForm = document.getElementById('withdrawalForm');
if (withdrawalForm) {
    withdrawalForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const montant = document.getElementById('withdrawalMontant').value;
        
        if (!montant || montant < 100) {
            alert('Le montant minimum est de 100 Ar');
            return;
        }

        try {
            const response = await fetch(window.API_URLS.createWithdrawal, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ montant: parseFloat(montant) })
            });
            
            const data = await response.json();
            
            if (data.success) {
                document.getElementById('successMessage').textContent = data.message;
                document.getElementById('newSolde').textContent = data.nouveau_solde.toLocaleString('fr-FR') + ' Ar';
                closeModal('retraitModal');
                openModal('successModal');
                withdrawalForm.reset();
                refreshBalance();
            } else {
                alert('Erreur: ' + data.message);
            }
        } catch (error) {
            alert('Une erreur est survenue. Veuillez réessayer.');
        }
    });
}
