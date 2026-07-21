console.log("Filtre Client JS loaded");

// Search functionality
const searchInput = document.getElementById('searchInput');
const tableRows = document.querySelectorAll('tbody tr');
let currentFilters = {
    searchTerm: '',
    filterType: '',
    minSolde: null,
    maxSolde: null,
    aroundSolde: null,
    lessSolde: null,
    greaterSolde: null,
    status: ''
};

if (searchInput) {
    searchInput.addEventListener('input', function() {
        currentFilters.searchTerm = this.value.toLowerCase();
        applyFilters();
    });
}

// Filter modal
const filterModal = document.getElementById('filterModal');
const filterBtn = document.getElementById('filterBtn');
const closeFilterModal = document.getElementById('closeFilterModal');
const cancelFilter = document.getElementById('cancelFilter');
const applyFiltersBtn = document.getElementById('applyFilters');
const resetFiltersBtn = document.getElementById('resetFilters');
const filterType = document.getElementById('filterType');
const filterValues = document.getElementById('filterValues');

// Open filter modal
if (filterBtn) {
    filterBtn.addEventListener('click', function() {
        filterModal.classList.remove('hidden');
        filterModal.classList.add('flex');
        filterModal.querySelector('.layer-2').classList.add('modal-enter');
    });
}

// Close filter modal
function closeFilterModalFn() {
    filterModal.classList.add('hidden');
    filterModal.classList.remove('flex');
}

closeFilterModal.addEventListener('click', closeFilterModalFn);
cancelFilter.addEventListener('click', closeFilterModalFn);

filterModal.addEventListener('click', (e) => {
    if (e.target === filterModal) {
        closeFilterModalFn();
    }
});

// Show/hide filter inputs based on type
if (filterType) {
    filterType.addEventListener('change', function() {
        const type = this.value;
        
        // Hide all input divs
        document.getElementById('betweenInputs').classList.add('hidden');
        document.getElementById('aroundInput').classList.add('hidden');
        document.getElementById('lessInput').classList.add('hidden');
        document.getElementById('greaterInput').classList.add('hidden');
        
        if (type) {
            filterValues.classList.remove('hidden');
            document.getElementById(type + 'Inputs').classList.remove('hidden');
        } else {
            filterValues.classList.add('hidden');
        }
    });
}

// Apply filters
if (applyFiltersBtn) {
    applyFiltersBtn.addEventListener('click', function() {
        currentFilters.filterType = filterType.value;
        currentFilters.minSolde = parseFloat(document.getElementById('minSolde').value) || null;
        currentFilters.maxSolde = parseFloat(document.getElementById('maxSolde').value) || null;
        currentFilters.aroundSolde = parseFloat(document.getElementById('aroundSolde').value) || null;
        currentFilters.lessSolde = parseFloat(document.getElementById('lessSolde').value) || null;
        currentFilters.greaterSolde = parseFloat(document.getElementById('greaterSolde').value) || null;
        currentFilters.status = document.getElementById('filterStatus').value;
        
        applyFilters();
        closeFilterModalFn();
    });
}

// Reset filters
if (resetFiltersBtn) {
    resetFiltersBtn.addEventListener('click', function() {
        filterType.value = '';
        document.getElementById('minSolde').value = '';
        document.getElementById('maxSolde').value = '';
        document.getElementById('aroundSolde').value = '';
        document.getElementById('lessSolde').value = '';
        document.getElementById('greaterSolde').value = '';
        document.getElementById('filterStatus').value = '';
        
        filterValues.classList.add('hidden');
        document.getElementById('betweenInputs').classList.add('hidden');
        document.getElementById('aroundInput').classList.add('hidden');
        document.getElementById('lessInput').classList.add('hidden');
        document.getElementById('greaterInput').classList.add('hidden');
        
        currentFilters = {
            searchTerm: '',
            filterType: '',
            minSolde: null,
            maxSolde: null,
            aroundSolde: null,
            lessSolde: null,
            greaterSolde: null,
            status: ''
        };
        
        applyFilters();
    });
}

// Apply all filters
function applyFilters() {
    tableRows.forEach(row => {
        let matches = true;
        
        // Search filter
        if (currentFilters.searchTerm) {
            const id = row.cells[0].textContent.toLowerCase();
            const accountCell = row.cells[1].cloneNode(true);
            const iconSpan = accountCell.querySelector('.material-symbols-outlined');
            if (iconSpan) iconSpan.remove();
            const accountNumber = accountCell.textContent.trim().toLowerCase();
            const clientName = row.cells[2].textContent.toLowerCase();
            
            const searchMatch = id.includes(currentFilters.searchTerm) || 
                               accountNumber.includes(currentFilters.searchTerm) || 
                               clientName.includes(currentFilters.searchTerm);
            
            if (!searchMatch) matches = false;
        }
        
        // Balance filters
        if (matches && currentFilters.filterType) {
            const balanceText = row.cells[3].textContent.trim().replace(/[^0-9]/g, '');
            const balance = parseFloat(balanceText);
            
            if (currentFilters.filterType === 'between') {
                if (currentFilters.minSolde !== null && balance < currentFilters.minSolde) matches = false;
                if (currentFilters.maxSolde !== null && balance > currentFilters.maxSolde) matches = false;
            } else if (currentFilters.filterType === 'around') {
                if (currentFilters.aroundSolde !== null) {
                    const min = currentFilters.aroundSolde * 0.9;
                    const max = currentFilters.aroundSolde * 1.1;
                    if (balance < min || balance > max) matches = false;
                }
            } else if (currentFilters.filterType === 'less') {
                if (currentFilters.lessSolde !== null && balance >= currentFilters.lessSolde) matches = false;
            } else if (currentFilters.filterType === 'greater') {
                if (currentFilters.greaterSolde !== null && balance <= currentFilters.greaterSolde) matches = false;
            }
        }
        
        // Status filter
        if (matches && currentFilters.status) {
            const statusCell = row.cells[4].textContent.trim();
            if (statusCell !== currentFilters.status) matches = false;
        }
        
        row.style.display = matches ? '' : 'none';
    });
}

// Sort button
const sortBtn = document.getElementById('sortBtn');
let currentSort = 'recent';
if (sortBtn) {
    sortBtn.addEventListener('click', function() {
        currentSort = currentSort === 'recent' ? 'old' : 'recent';
        this.innerHTML = `<span class="material-symbols-outlined text-[18px]">sort</span> Trier par: ${currentSort === 'recent' ? 'Récents' : 'Anciens'}`;
        
        const tbody = document.querySelector('tbody');
        const rows = Array.from(tableRows);
        
        rows.reverse();
        rows.forEach(row => tbody.appendChild(row));
    });
}
