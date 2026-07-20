// Données d'exemple
const students = [
    { nom: "Dupont", prenom: "Jean", classe: "L1", moyenne: 14.5, statut: "Admis" },
    { nom: "Martin", prenom: "Marie", classe: "L2", moyenne: 16.2, statut: "Admis" },
    { nom: "Bernard", prenom: "Pierre", classe: "L1", moyenne: 9.5, statut: "Ajourné" },
    { nom: "Petit", prenom: "Sophie", classe: "L3", moyenne: 17.8, statut: "Admis" },
    { nom: "Robert", prenom: "Luc", classe: "L2", moyenne: 11.3, statut: "Admis" },
    { nom: "Richard", prenom: "Emma", classe: "L1", moyenne: 8.9, statut: "Ajourné" },
    { nom: "Durand", prenom: "Thomas", classe: "L3", moyenne: 15.7, statut: "Admis" },
    { nom: "Lefebvre", prenom: "Chloe", classe: "L2", moyenne: 12.4, statut: "Admis" },
    { nom: "Moreau", prenom: "Hugo", classe: "L1", moyenne: 10.1, statut: "Admis" },
    { nom: "Simon", prenom: "Léa", classe: "L3", moyenne: 18.5, statut: "Admis" }
];

const products = [
    { nom: "iPhone 15", categorie: "electronique", prix: 999, stock: 25 },
    { nom: "MacBook Pro", categorie: "electronique", prix: 2499, stock: 10 },
    { nom: "T-shirt Nike", categorie: "vetements", prix: 35, stock: 150 },
    { nom: "Jean Levi's", categorie: "vetements", prix: 89, stock: 75 },
    { nom: "Pommes", categorie: "alimentaire", prix: 3.5, stock: 200 },
    { nom: "Lait", categorie: "alimentaire", prix: 1.2, stock: 500 },
    { nom: "Lampe LED", categorie: "maison", prix: 29, stock: 80 },
    { nom: "Canapé", categorie: "maison", prix: 599, stock: 5 },
    { nom: "Samsung Galaxy", categorie: "electronique", prix: 799, stock: 30 },
    { nom: "Robe", categorie: "vetements", prix: 65, stock: 45 }
];

const employees = [
    { nom: "Alice", prenom: "Design", departement: "design", statut: "active", role: "UI Designer" },
    { nom: "Bob", prenom: "Dev", departement: "dev", statut: "active", role: "Développeur Front" },
    { nom: "Charlie", prenom: "Market", departement: "marketing", statut: "active", role: "CM" },
    { nom: "Diana", prenom: "HR", departement: "rh", statut: "inactive", role: "RH Manager" },
    { nom: "Eve", prenom: "Back", departement: "dev", statut: "active", role: "Développeur Back" },
    { nom: "Frank", prenom: "UX", departement: "design", statut: "active", role: "UX Designer" },
    { nom: "Grace", prenom: "SEO", departement: "marketing", statut: "inactive", role: "SEO Expert" },
    { nom: "Henry", prenom: "Recrut", departement: "rh", statut: "active", role: "Recruteur" }
];

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
    renderStudents(students);
    renderProducts(products);
    renderEmployees(employees);
    
    // Event listeners pour les filtres
    document.getElementById('searchStudent').addEventListener('input', filterStudents);
    document.getElementById('filterClass').addEventListener('change', filterStudents);
    document.getElementById('filterGrade').addEventListener('change', filterStudents);
    
    document.getElementById('searchProduct').addEventListener('input', filterProducts);
    document.getElementById('filterCategory').addEventListener('change', filterProducts);
    document.getElementById('filterPrice').addEventListener('change', filterProducts);
    
    document.getElementById('searchEmployee').addEventListener('input', filterEmployees);
    document.getElementById('filterDepartment').addEventListener('change', filterEmployees);
    document.getElementById('filterStatus').addEventListener('change', filterEmployees);
});

// Fonctions de rendu
function renderStudents(data) {
    const tbody = document.getElementById('studentsBody');
    tbody.innerHTML = '';
    
    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="no-results">Aucun résultat trouvé</td></tr>';
        return;
    }
    
    data.forEach(student => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${student.nom}</td>
            <td>${student.prenom}</td>
            <td><span class="badge">${student.classe}</span></td>
            <td>${student.moyenne}/20</td>
            <td><span class="badge" style="background: ${student.moyenne >= 10 ? '#10b981' : '#ef4444'}">${student.statut}</span></td>
        `;
        tbody.appendChild(row);
    });
}

function renderProducts(data) {
    const tbody = document.getElementById('productsBody');
    tbody.innerHTML = '';
    
    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="no-results">Aucun résultat trouvé</td></tr>';
        return;
    }
    
    data.forEach(product => {
        const row = document.createElement('tr');
        const stockColor = product.stock < 20 ? '#ef4444' : '#10b981';
        row.innerHTML = `
            <td>${product.nom}</td>
            <td><span class="badge">${product.categorie}</span></td>
            <td>${product.prix.toFixed(2)}€</td>
            <td><span class="badge" style="background: ${stockColor}">${product.stock} unités</span></td>
        `;
        tbody.appendChild(row);
    });
}

function renderEmployees(data) {
    const container = document.getElementById('employeesList');
    container.innerHTML = '';
    
    if (data.length === 0) {
        container.innerHTML = '<p class="no-results">Aucun résultat trouvé</p>';
        return;
    }
    
    data.forEach(employee => {
        const card = document.createElement('div');
        card.className = 'card';
        const statusColor = employee.statut === 'active' ? '#10b981' : '#ef4444';
        card.innerHTML = `
            <h4>${employee.prenom} ${employee.nom}</h4>
            <p><strong>Rôle:</strong> ${employee.role}</p>
            <p><span class="badge">${employee.departement}</span></p>
            <p><span class="badge" style="background: ${statusColor}">${employee.statut === 'active' ? 'Actif' : 'Inactif'}</span></p>
        `;
        container.appendChild(card);
    });
}

// Fonctions de filtrage
function filterStudents() {
    const search = document.getElementById('searchStudent').value.toLowerCase();
    const classe = document.getElementById('filterClass').value;
    const grade = document.getElementById('filterGrade').value;
    
    const filtered = students.filter(student => {
        const matchSearch = student.nom.toLowerCase().includes(search) || 
                           student.prenom.toLowerCase().includes(search);
        const matchClass = !classe || student.classe === classe;
        
        let matchGrade = true;
        if (grade === 'excellent') matchGrade = student.moyenne >= 16;
        else if (grade === 'good') matchGrade = student.moyenne >= 12 && student.moyenne < 16;
        else if (grade === 'average') matchGrade = student.moyenne >= 10 && student.moyenne < 12;
        else if (grade === 'fail') matchGrade = student.moyenne < 10;
        
        return matchSearch && matchClass && matchGrade;
    });
    
    renderStudents(filtered);
}

function filterProducts() {
    const search = document.getElementById('searchProduct').value.toLowerCase();
    const category = document.getElementById('filterCategory').value;
    const price = document.getElementById('filterPrice').value;
    
    const filtered = products.filter(product => {
        const matchSearch = product.nom.toLowerCase().includes(search);
        const matchCategory = !category || product.categorie === category;
        
        let matchPrice = true;
        if (price === 'low') matchPrice = product.prix < 50;
        else if (price === 'medium') matchPrice = product.prix >= 50 && product.prix <= 100;
        else if (price === 'high') matchPrice = product.prix > 100;
        
        return matchSearch && matchCategory && matchPrice;
    });
    
    renderProducts(filtered);
}

function filterEmployees() {
    const search = document.getElementById('searchEmployee').value.toLowerCase();
    const department = document.getElementById('filterDepartment').value;
    const status = document.getElementById('filterStatus').value;
    
    const filtered = employees.filter(employee => {
        const matchSearch = employee.nom.toLowerCase().includes(search) || 
                           employee.prenom.toLowerCase().includes(search) ||
                           employee.role.toLowerCase().includes(search);
        const matchDepartment = !department || employee.departement === department;
        const matchStatus = !status || employee.statut === status;
        
        return matchSearch && matchDepartment && matchStatus;
    });
    
    renderEmployees(filtered);
}

// Fonctions de réinitialisation
function resetStudentFilters() {
    document.getElementById('searchStudent').value = '';
    document.getElementById('filterClass').value = '';
    document.getElementById('filterGrade').value = '';
    renderStudents(students);
}

function resetProductFilters() {
    document.getElementById('searchProduct').value = '';
    document.getElementById('filterCategory').value = '';
    document.getElementById('filterPrice').value = '';
    renderProducts(products);
}

function resetEmployeeFilters() {
    document.getElementById('searchEmployee').value = '';
    document.getElementById('filterDepartment').value = '';
    document.getElementById('filterStatus').value = '';
    renderEmployees(employees);
}
