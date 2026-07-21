console.log("History JS loaded");

// Toggle batch visibility
window.toggleBatch = function(batchId) {
    const row = document.getElementById('batch-' + batchId);
    if (row.classList.contains('hidden')) {
        row.classList.remove('hidden');
    } else {
        row.classList.add('hidden');
    }
};

// Refresh history
const refreshBtn = document.getElementById('refreshBtn');
if (refreshBtn) {
    refreshBtn.addEventListener('click', async function() {
        try {
            const response = await fetch(window.API_URLS.get);
            const data = await response.json();
            
            if (data.success) {
                location.reload();
            } else {
                alert('Erreur lors du rafraîchissement');
            }
        } catch (error) {
            alert('Erreur lors du rafraîchissement');
        }
    });
}
