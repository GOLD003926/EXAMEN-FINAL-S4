<div class="import-container">
    <h3>📥 Démo: Import de données</h3>
    <p>Importez des fichiers CSV ou XLSX dans votre base de données</p>

    <!-- Exemple 1: Import CSV -->
    <div class="import-section">
        <h4>📄 Exemple 1: Import CSV d'étudiants</h4>
        
        <div class="upload-area">
            <form action="import/import_csv.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="csvFile">Sélectionner un fichier CSV:</label>
                    <input type="file" id="csvFile" name="csvFile" accept=".csv" required>
                </div>
                <div class="form-group">
                    <label for="targetTable">Table cible:</label>
                    <select id="targetTable" name="targetTable">
                        <option value="students">students</option>
                        <option value="products">products</option>
                        <option value="employees">employees</option>
                    </select>
                </div>
                <button type="submit" class="import-btn csv-btn">
                    📄 Importer CSV
                </button>
            </form>
        </div>

        <div class="example-file">
            <p><strong>📁 Exemple de fichier CSV à importer:</strong></p>
            <pre>id,nom,prenom,classe,moyenne,statut
11,Dupont,Jean,L1,14.5,Admis
12,Martin,Marie,L2,16.2,Admis
13,Bernard,Pierre,L1,9.5,Ajourné</pre>
        </div>
    </div>

    <!-- Exemple 2: Import XLSX -->
    <div class="import-section">
        <h4>📊 Exemple 2: Import XLSX de produits</h4>
        
        <div class="upload-area">
            <form action="import/import_xlsx.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="xlsxFile">Sélectionner un fichier XLSX:</label>
                    <input type="file" id="xlsxFile" name="xlsxFile" accept=".xlsx" required>
                </div>
                <div class="form-group">
                    <label for="targetTable">Table cible:</label>
                    <select id="targetTable" name="targetTable">
                        <option value="students">students</option>
                        <option value="products" selected>products</option>
                        <option value="employees">employees</option>
                    </select>
                </div>
                <button type="submit" class="import-btn xlsx-btn">
                    📊 Importer XLSX
                </button>
            </form>
        </div>

        <div class="note">
            <strong>Note:</strong> Pour l'import XLSX, vous devez installer PhpSpreadsheet via Composer:
            <code>composer require phpoffice/phpspreadsheet</code>
        </div>
    </div>

    <!-- Résultat de l'import -->
    <?php if (isset($_GET['imported'])): ?>
        <div class="import-result success">
            <h4>✅ Import réussi!</h4>
            <p><?php echo htmlspecialchars($_GET['imported']); ?> enregistrement(s) importé(s) avec succès.</p>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="import-result error">
            <h4>❌ Erreur lors de l'import</h4>
            <p><?php echo htmlspecialchars($_GET['error']); ?></p>
        </div>
    <?php endif; ?>
</div>

<style>
.import-container {
    padding: 2rem;
}

.import-section {
    background: var(--light);
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.import-section h4 {
    color: var(--primary);
    margin-bottom: 1rem;
}

.upload-area {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--dark);
}

.form-group input[type="file"],
.form-group select {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid var(--border);
    border-radius: 8px;
    font-size: 1rem;
}

.import-btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
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

.example-file {
    background: white;
    padding: 1rem;
    border-radius: 8px;
    margin-top: 1rem;
}

.example-file pre {
    background: var(--dark);
    color: #e2e8f0;
    padding: 1rem;
    border-radius: 6px;
    overflow-x: auto;
    margin: 0.5rem 0;
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

.import-result {
    padding: 1rem;
    border-radius: 8px;
    margin-top: 1rem;
}

.import-result.success {
    background: #d1fae5;
    border-left: 4px solid #10b981;
}

.import-result.error {
    background: #fee2e2;
    border-left: 4px solid #ef4444;
}

.import-result h4 {
    margin: 0 0 0.5rem 0;
}
</style>
