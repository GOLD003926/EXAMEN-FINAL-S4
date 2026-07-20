<div class="code-container">
    <h3>📝 Code pour les filtres multi-critères</h3>

    <!-- Section Étudiants -->
    <div class="filter-type-section">
        <h4>📚 Exemple 1: Filtrer des étudiants (Tableau)</h4>
        
        <div class="code-instruction">
            <strong>📁 Fichier à créer:</strong> <code>js/filtres.js</code>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>// Données d'exemple
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

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
    renderStudents(students);
    
    // Event listeners pour les filtres
    document.getElementById('searchStudent').addEventListener('input', filterStudents);
    document.getElementById('filterClass').addEventListener('change', filterStudents);
    document.getElementById('filterGrade').addEventListener('change', filterStudents);
});

// Fonction de rendu
function renderStudents(data) {
    const tbody = document.getElementById('studentsBody');
    tbody.innerHTML = '';
    
    if (data.length === 0) {
        tbody.innerHTML = '&lt;tr&gt;&lt;td colspan="5" class="no-results"&gt;Aucun résultat trouvé&lt;/td&gt;&lt;/tr&gt;';
        return;
    }
    
    data.forEach(student => {
        const row = document.createElement('tr');
        row.innerHTML = `
            &lt;td&gt;${student.nom}&lt;/td&gt;
            &lt;td&gt;${student.prenom}&lt;/td&gt;
            &lt;td&gt;&lt;span class="badge"&gt;${student.classe}&lt;/span&gt;&lt;/td&gt;
            &lt;td&gt;${student.moyenne}/20&lt;/td&gt;
            &lt;td&gt;&lt;span class="badge" style="background: ${student.moyenne >= 10 ? '#10b981' : '#ef4444'}"&gt;${student.statut}&lt;/span&gt;&lt;/td&gt;
        `;
        tbody.appendChild(row);
    });
}

// Fonction de filtrage
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

// Fonction de réinitialisation
function resetStudentFilters() {
    document.getElementById('searchStudent').value = '';
    document.getElementById('filterClass').value = '';
    document.getElementById('filterGrade').value = '';
    renderStudents(students);
}</pre>
        </div>

        <div class="code-instruction">
            <strong>📁 HTML:</strong>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>&lt;!-- Contrôles de filtrage --&gt;
&lt;div class="filter-controls"&gt;
    &lt;input type="text" id="searchStudent" class="filter-input" placeholder="Rechercher par nom..."&gt;
    &lt;select id="filterClass" class="filter-select"&gt;
        &lt;option value=""&gt;Toutes les classes&lt;/option&gt;
        &lt;option value="L1"&gt;L1&lt;/option&gt;
        &lt;option value="L2"&gt;L2&lt;/option&gt;
        &lt;option value="L3"&gt;L3&lt;/option&gt;
    &lt;/select&gt;
    &lt;select id="filterGrade" class="filter-select"&gt;
        &lt;option value=""&gt;Toutes les moyennes&lt;/option&gt;
        &lt;option value="excellent"&gt;Excellent (≥16)&lt;/option&gt;
        &lt;option value="good"&gt;Bon (12-15)&lt;/option&gt;
        &lt;option value="average"&gt;Moyen (10-11)&lt;/option&gt;
        &lt;option value="fail"&gt;Insuffisant (&lt;10)&lt;/option&gt;
    &lt;/select&gt;
    &lt;button class="filter-btn reset" onclick="resetStudentFilters()"&gt;Réinitialiser&lt;/button&gt;
&lt;/div&gt;

&lt;!-- Tableau --&gt;
&lt;table id="studentsTable"&gt;
    &lt;thead&gt;
        &lt;tr&gt;
            &lt;th&gt;Nom&lt;/th&gt;
            &lt;th&gt;Prénom&lt;/th&gt;
            &lt;th&gt;Classe&lt;/th&gt;
            &lt;th&gt;Moyenne&lt;/th&gt;
            &lt;th&gt;Statut&lt;/th&gt;
        &lt;/tr&gt;
    &lt;/thead&gt;
    &lt;tbody id="studentsBody"&gt;
        &lt;!-- Rempli par JavaScript --&gt;
    &lt;/tbody&gt;
&lt;/table&gt;

&lt;script src="js/filtres.js"&gt;&lt;/script&gt;</pre>
        </div>
    </div>

    <!-- Section Produits -->
    <div class="filter-type-section">
        <h4>🛒 Exemple 2: Filtrer des produits (Tableau)</h4>
        
        <div class="code-instruction">
            <strong>📁 Fichier à créer:</strong> <code>js/filtres.js</code>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>const products = [
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

document.addEventListener('DOMContentLoaded', () => {
    renderProducts(products);
    
    document.getElementById('searchProduct').addEventListener('input', filterProducts);
    document.getElementById('filterCategory').addEventListener('change', filterProducts);
    document.getElementById('filterPrice').addEventListener('change', filterProducts);
});

function renderProducts(data) {
    const tbody = document.getElementById('productsBody');
    tbody.innerHTML = '';
    
    if (data.length === 0) {
        tbody.innerHTML = '&lt;tr&gt;&lt;td colspan="4" class="no-results"&gt;Aucun résultat trouvé&lt;/td&gt;&lt;/tr&gt;';
        return;
    }
    
    data.forEach(product => {
        const row = document.createElement('tr');
        const stockColor = product.stock < 20 ? '#ef4444' : '#10b981';
        row.innerHTML = `
            &lt;td&gt;${product.nom}&lt;/td&gt;
            &lt;td&gt;&lt;span class="badge"&gt;${product.categorie}&lt;/span&gt;&lt;/td&gt;
            &lt;td&gt;${product.prix.toFixed(2)}€&lt;/td&gt;
            &lt;td&gt;&lt;span class="badge" style="background: ${stockColor}"&gt;${product.stock} unités&lt;/span&gt;&lt;/td&gt;
        `;
        tbody.appendChild(row);
    });
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

function resetProductFilters() {
    document.getElementById('searchProduct').value = '';
    document.getElementById('filterCategory').value = '';
    document.getElementById('filterPrice').value = '';
    renderProducts(products);
}</pre>
        </div>

        <div class="code-instruction">
            <strong>📁 HTML:</strong>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>&lt;div class="filter-controls"&gt;
    &lt;input type="text" id="searchProduct" class="filter-input" placeholder="Rechercher un produit..."&gt;
    &lt;select id="filterCategory" class="filter-select"&gt;
        &lt;option value=""&gt;Toutes les catégories&lt;/option&gt;
        &lt;option value="electronique"&gt;Électronique&lt;/option&gt;
        &lt;option value="vetements"&gt;Vêtements&lt;/option&gt;
        &lt;option value="alimentaire"&gt;Alimentaire&lt;/option&gt;
        &lt;option value="maison"&gt;Maison&lt;/option&gt;
    &lt;/select&gt;
    &lt;select id="filterPrice" class="filter-select"&gt;
        &lt;option value=""&gt;Tous les prix&lt;/option&gt;
        &lt;option value="low"&gt;Moins de 50€&lt;/option&gt;
        &lt;option value="medium"&gt;50€ - 100€&lt;/option&gt;
        &lt;option value="high"&gt;Plus de 100€&lt;/option&gt;
    &lt;/select&gt;
    &lt;button class="filter-btn reset" onclick="resetProductFilters()"&gt;Réinitialiser&lt;/button&gt;
&lt;/div&gt;

&lt;table id="productsTable"&gt;
    &lt;thead&gt;
        &lt;tr&gt;
            &lt;th&gt;Produit&lt;/th&gt;
            &lt;th&gt;Catégorie&lt;/th&gt;
            &lt;th&gt;Prix&lt;/th&gt;
            &lt;th&gt;Stock&lt;/th&gt;
        &lt;/tr&gt;
    &lt;/thead&gt;
    &lt;tbody id="productsBody"&gt;
        &lt;!-- Rempli par JavaScript --&gt;
    &lt;/tbody&gt;
&lt;/table&gt;</pre>
        </div>
    </div>

    <!-- Section Employés -->
    <div class="filter-type-section">
        <h4>👥 Exemple 3: Filtrer des employés (Cartes)</h4>
        
        <div class="code-instruction">
            <strong>📁 Fichier à créer:</strong> <code>js/filtres.js</code>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>const employees = [
    { nom: "Alice", prenom: "Design", departement: "design", statut: "active", role: "UI Designer" },
    { nom: "Bob", prenom: "Dev", departement: "dev", statut: "active", role: "Développeur Front" },
    { nom: "Charlie", prenom: "Market", departement: "marketing", statut: "active", role: "CM" },
    { nom: "Diana", prenom: "HR", departement: "rh", statut: "inactive", role: "RH Manager" },
    { nom: "Eve", prenom: "Back", departement: "dev", statut: "active", role: "Développeur Back" },
    { nom: "Frank", prenom: "UX", departement: "design", statut: "active", role: "UX Designer" },
    { nom: "Grace", prenom: "SEO", departement: "marketing", statut: "inactive", role: "SEO Expert" },
    { nom: "Henry", prenom: "Recrut", departement: "rh", statut: "active", role: "Recruteur" }
];

document.addEventListener('DOMContentLoaded', () => {
    renderEmployees(employees);
    
    document.getElementById('searchEmployee').addEventListener('input', filterEmployees);
    document.getElementById('filterDepartment').addEventListener('change', filterEmployees);
    document.getElementById('filterStatus').addEventListener('change', filterEmployees);
});

function renderEmployees(data) {
    const container = document.getElementById('employeesList');
    container.innerHTML = '';
    
    if (data.length === 0) {
        container.innerHTML = '&lt;p class="no-results"&gt;Aucun résultat trouvé&lt;/p&gt;';
        return;
    }
    
    data.forEach(employee => {
        const card = document.createElement('div');
        card.className = 'card';
        const statusColor = employee.statut === 'active' ? '#10b981' : '#ef4444';
        card.innerHTML = `
            &lt;h4&gt;${employee.prenom} ${employee.nom}&lt;/h4&gt;
            &lt;p&gt;&lt;strong&gt;Rôle:&lt;/strong&gt; ${employee.role}&lt;/p&gt;
            &lt;p&gt;&lt;span class="badge"&gt;${employee.departement}&lt;/span&gt;&lt;/p&gt;
            &lt;p&gt;&lt;span class="badge" style="background: ${statusColor}"&gt;${employee.statut === 'active' ? 'Actif' : 'Inactif'}&lt;/span&gt;&lt;/p&gt;
        `;
        container.appendChild(card);
    });
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

function resetEmployeeFilters() {
    document.getElementById('searchEmployee').value = '';
    document.getElementById('filterDepartment').value = '';
    document.getElementById('filterStatus').value = '';
    renderEmployees(employees);
}</pre>
        </div>

        <div class="code-instruction">
            <strong>📁 HTML:</strong>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>&lt;div class="filter-controls"&gt;
    &lt;input type="text" id="searchEmployee" class="filter-input" placeholder="Rechercher un employé..."&gt;
    &lt;select id="filterDepartment" class="filter-select"&gt;
        &lt;option value=""&gt;Tous les départements&lt;/option&gt;
        &lt;option value="dev"&gt;Développement&lt;/option&gt;
        &lt;option value="design"&gt;Design&lt;/option&gt;
        &lt;option value="marketing"&gt;Marketing&lt;/option&gt;
        &lt;option value="rh"&gt;RH&lt;/option&gt;
    &lt;/select&gt;
    &lt;select id="filterStatus" class="filter-select"&gt;
        &lt;option value=""&gt;Tous les statuts&lt;/option&gt;
        &lt;option value="active"&gt;Actif&lt;/option&gt;
        &lt;option value="inactive"&gt;Inactif&lt;/option&gt;
    &lt;/select&gt;
    &lt;button class="filter-btn reset" onclick="resetEmployeeFilters()"&gt;Réinitialiser&lt;/button&gt;
&lt;/div&gt;

&lt;div id="employeesList" class="card-list"&gt;
    &lt;!-- Rempli par JavaScript --&gt;
&lt;/div&gt;</pre>
        </div>
    </div>

    <!-- Section CSS commun -->
    <div class="filter-type-section">
        <h4>🎨 CSS commun pour tous les exemples</h4>
        
        <div class="code-instruction">
            <strong>📁 Fichier CSS:</strong> À ajouter dans votre fichier CSS
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>.filter-controls {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1rem;
}

.filter-input {
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    min-width: 200px;
}

.filter-input:focus {
    outline: none;
    border-color: #6366f1;
}

.filter-select {
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    min-width: 150px;
}

.filter-select:focus {
    outline: none;
    border-color: #6366f1;
}

.filter-btn {
    padding: 0.75rem 1.5rem;
    background: #6366f1;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}

.filter-btn.reset {
    background: #64748b;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 12px;
    overflow: hidden;
}

table th, table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
}

table th {
    background: #6366f1;
    color: white;
    font-weight: 600;
}

.badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    background: #10b981;
    color: white;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.no-results {
    text-align: center;
    padding: 2rem;
    color: #64748b;
    font-style: italic;
}

.card-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
}

.card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.card h4 {
    color: #6366f1;
    margin-bottom: 0.5rem;
}</pre>
        </div>
    </div>
</div>
