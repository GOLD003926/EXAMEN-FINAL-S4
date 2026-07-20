<div class="filter-container">
    <!-- Exemple 1: Tableau d'étudiants -->
    <div class="filter-section">
        <h3>📚 Exemple 1: Filtrer des étudiants</h3>
        
        <div class="filter-controls">
            <input type="text" id="searchStudent" class="filter-input" placeholder="Rechercher par nom...">
            <select id="filterClass" class="filter-select">
                <option value="">Toutes les classes</option>
                <option value="L1">L1</option>
                <option value="L2">L2</option>
                <option value="L3">L3</option>
            </select>
            <select id="filterGrade" class="filter-select">
                <option value="">Toutes les moyennes</option>
                <option value="excellent">Excellent (≥16)</option>
                <option value="good">Bon (12-15)</option>
                <option value="average">Moyen (10-11)</option>
                <option value="fail">Insuffisant (<10)</option>
            </select>
            <button class="filter-btn reset" onclick="resetStudentFilters()">Réinitialiser</button>
        </div>
        
        <table id="studentsTable">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Classe</th>
                    <th>Moyenne</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody id="studentsBody">
                <!-- Rempli par JavaScript -->
            </tbody>
        </table>
    </div>

    <!-- Exemple 2: Tableau de produits -->
    <div class="filter-section">
        <h3>🛒 Exemple 2: Filtrer des produits</h3>
        
        <div class="filter-controls">
            <input type="text" id="searchProduct" class="filter-input" placeholder="Rechercher un produit...">
            <select id="filterCategory" class="filter-select">
                <option value="">Toutes les catégories</option>
                <option value="electronique">Électronique</option>
                <option value="vetements">Vêtements</option>
                <option value="alimentaire">Alimentaire</option>
                <option value="maison">Maison</option>
            </select>
            <select id="filterPrice" class="filter-select">
                <option value="">Tous les prix</option>
                <option value="low">Moins de 50€</option>
                <option value="medium">50€ - 100€</option>
                <option value="high">Plus de 100€</option>
            </select>
            <button class="filter-btn reset" onclick="resetProductFilters()">Réinitialiser</button>
        </div>
        
        <table id="productsTable">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody id="productsBody">
                <!-- Rempli par JavaScript -->
            </tbody>
        </table>
    </div>

    <!-- Exemple 3: Liste d'employés (cartes) -->
    <div class="filter-section">
        <h3>👥 Exemple 3: Filtrer des employés (Cartes)</h3>
        
        <div class="filter-controls">
            <input type="text" id="searchEmployee" class="filter-input" placeholder="Rechercher un employé...">
            <select id="filterDepartment" class="filter-select">
                <option value="">Tous les départements</option>
                <option value="dev">Développement</option>
                <option value="design">Design</option>
                <option value="marketing">Marketing</option>
                <option value="rh">RH</option>
            </select>
            <select id="filterStatus" class="filter-select">
                <option value="">Tous les statuts</option>
                <option value="active">Actif</option>
                <option value="inactive">Inactif</option>
            </select>
            <button class="filter-btn reset" onclick="resetEmployeeFilters()">Réinitialiser</button>
        </div>
        
        <div id="employeesList" class="card-list">
            <!-- Rempli par JavaScript -->
        </div>
    </div>
</div>

<script src="js/filtres.js"></script>
