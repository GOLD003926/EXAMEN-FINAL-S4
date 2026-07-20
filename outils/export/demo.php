<div class="export-container">
    <h3>📤 Démo: Export de données</h3>
    <p>Exportez vos données dans différents formats</p>

    <!-- Exemple 1: Export CSV -->
    <div class="export-section">
        <h4>📄 Exemple 1: Export CSV des étudiants</h4>
        
        <div class="data-preview">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Classe</th>
                        <th>Moyenne</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = include __DIR__ . '/../data.php';
                    foreach ($data['students'] as $student) {
                        echo "<tr>";
                        echo "<td>{$student['id']}</td>";
                        echo "<td>{$student['nom']}</td>";
                        echo "<td>{$student['prenom']}</td>";
                        echo "<td>{$student['classe']}</td>";
                        echo "<td>{$student['moyenne']}</td>";
                        echo "<td>{$student['statut']}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="export-buttons">
            <a href="export/export_csv.php?table=students" class="export-btn csv-btn">
                📄 Exporter en CSV
            </a>
        </div>
    </div>

    <!-- Exemple 2: Export XLSX -->
    <div class="export-section">
        <h4>📊 Exemple 2: Export XLSX des produits</h4>
        
        <div class="data-preview">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produit</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data['products'] as $product) {
                        echo "<tr>";
                        echo "<td>{$product['id']}</td>";
                        echo "<td>{$product['nom']}</td>";
                        echo "<td>{$product['categorie']}</td>";
                        echo "<td>{$product['prix']}€</td>";
                        echo "<td>{$product['stock']}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="export-buttons">
            <a href="export/export_xlsx.php?table=products" class="export-btn xlsx-btn">
                📊 Exporter en XLSX
            </a>
        </div>

        <div class="note">
            <strong>Note:</strong> Pour l'export XLSX, vous devez installer PhpSpreadsheet via Composer:
            <code>composer require phpoffice/phpspreadsheet</code>
        </div>
    </div>

    <!-- Exemple 3: Export PDF -->
    <div class="export-section">
        <h4>📑 Exemple 3: Export PDF des employés</h4>
        
        <div class="data-preview">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Département</th>
                        <th>Rôle</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data['employees'] as $employee) {
                        echo "<tr>";
                        echo "<td>{$employee['id']}</td>";
                        echo "<td>{$employee['nom']}</td>";
                        echo "<td>{$employee['prenom']}</td>";
                        echo "<td>{$employee['departement']}</td>";
                        echo "<td>{$employee['role']}</td>";
                        echo "<td>{$employee['statut']}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="export-buttons">
            <a href="export/export_pdf.php?table=employees" class="export-btn pdf-btn">
                📑 Exporter en PDF
            </a>
        </div>

        <div class="note">
            <strong>Note:</strong> Pour l'export PDF, vous devez installer TCPDF via Composer:
            <code>composer require tecnickcom/tcpdf</code>
        </div>
    </div>
</div>

<style>
.export-container {
    padding: 2rem;
}

.export-section {
    background: var(--light);
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.export-section h4 {
    color: var(--primary);
    margin-bottom: 1rem;
}

.data-preview {
    background: white;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
    overflow-x: auto;
}

.export-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.export-btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    color: white;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.csv-btn {
    background: #10b981;
}

.csv-btn:hover {
    background: #059669;
}

.xlsx-btn {
    background: #217346;
}

.xlsx-btn:hover {
    background: #1a5c38;
}

.pdf-btn {
    background: #ef4444;
}

.pdf-btn:hover {
    background: #dc2626;
}

.note {
    background: #fef3c7;
    border-left: 4px solid #f59e0b;
    padding: 1rem;
    margin-top: 1rem;
    border-radius: 0 8px 8px 0;
}

.note code {
    background: rgba(0,0,0,0.1);
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
    font-family: monospace;
}
</style>
