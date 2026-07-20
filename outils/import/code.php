<div class="code-container">
    <h3>📝 Code pour l'import de données</h3>

    <!-- Section Import CSV -->
    <div class="import-type-section">
        <h4>📄 Import CSV (Sans dépendance)</h4>
        
        <div class="code-instruction">
            <strong>📁 Fichier à créer:</strong> <code>import/import_csv.php</code>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>&lt;?php
// Import CSV - Sans dépendance externe

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csvFile'])) {
    $targetTable = $_POST['targetTable'] ?? 'students';
    $file = $_FILES['csvFile'];
    
    // Vérifier le fichier
    if ($file['error'] !== UPLOAD_ERR_OK) {
        header('Location: ../index.php#import?error=' . urlencode('Erreur lors du téléchargement'));
        exit;
    }
    
    // Lire le fichier CSV
    $handle = fopen($file['tmp_name'], 'r');
    if ($handle === false) {
        header('Location: ../index.php#import?error=' . urlencode('Impossible d\'ouvrir le fichier'));
        exit;
    }
    
    // Lire l'en-tête
    $headers = fgetcsv($handle);
    if ($headers === false) {
        fclose($handle);
        header('Location: ../index.php#import?error=' . urlencode('Fichier CSV vide ou invalide'));
        exit;
    }
    
    // Lire les données
    $importedCount = 0;
    while (($row = fgetcsv($handle)) !== false) {
        // Créer un tableau associatif
        $record = array_combine($headers, $row);
        
        // Insérer dans la base de données
        // Exemple avec PDO:
        $stmt = $pdo->prepare("INSERT INTO $targetTable (" . implode(',', $headers) . ") VALUES (" . str_repeat('?,', count($headers) - 1) . "?)");
        $stmt->execute(array_values($record));
        
        $importedCount++;
    }
    
    fclose($handle);
    
    // Rediriger avec succès
    header('Location: ../index.php#import?imported=' . $importedCount);
    exit;
}

header('Location: ../index.php#import?error=' . urlencode('Méthode non autorisée'));
exit;</pre>
        </div>

        <div class="code-instruction">
            <strong>📁 HTML pour le formulaire:</strong>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>&lt;form action="import/import_csv.php" method="POST" enctype="multipart/form-data"&gt;
    &lt;div class="form-group"&gt;
        &lt;label for="csvFile"&gt;Sélectionner un fichier CSV:&lt;/label&gt;
        &lt;input type="file" id="csvFile" name="csvFile" accept=".csv" required&gt;
    &lt;/div&gt;
    &lt;div class="form-group"&gt;
        &lt;label for="targetTable"&gt;Table cible:&lt;/label&gt;
        &lt;select id="targetTable" name="targetTable"&gt;
            &lt;option value="students"&gt;students&lt;/option&gt;
            &lt;option value="products"&gt;products&lt;/option&gt;
            &lt;option value="employees"&gt;employees&lt;/option&gt;
        &lt;/select&gt;
    &lt;/div&gt;
    &lt;button type="submit" class="btn"&gt;📄 Importer CSV&lt;/button&gt;
&lt;/form&gt;</pre>
        </div>
    </div>

    <!-- Section Import XLSX -->
    <div class="import-type-section">
        <h4>📊 Import XLSX (Avec PhpSpreadsheet)</h4>
        
        <div class="note">
            <strong>⚠️ Installation requise:</strong> <code>composer require phpoffice/phpspreadsheet</code>
        </div>
        
        <div class="code-instruction">
            <strong>📁 Fichier à créer:</strong> <code>import/import_xlsx.php</code>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>&lt;?php
// Import XLSX - Nécessite PhpSpreadsheet
// Installation: composer require phpoffice/phpspreadsheet

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['xlsxFile'])) {
    $targetTable = $_POST['targetTable'] ?? 'products';
    $file = $_FILES['xlsxFile'];
    
    // Vérifier le fichier
    if ($file['error'] !== UPLOAD_ERR_OK) {
        header('Location: ../index.php#import?error=' . urlencode('Erreur lors du téléchargement'));
        exit;
    }
    
    try {
        // Charger le fichier Excel
        $spreadsheet = IOFactory::load($file['tmp_name']);
        $worksheet = $spreadsheet->getActiveSheet();
        
        // Obtenir les données
        $rows = $worksheet->toArray();
        
        if (empty($rows)) {
            header('Location: ../index.php#import?error=' . urlencode('Fichier Excel vide'));
            exit;
        }
        
        // La première ligne contient les en-têtes
        $headers = array_shift($rows);
        
        $importedCount = 0;
        foreach ($rows as $row) {
            // Créer un tableau associatif
            $record = array_combine($headers, $row);
            
            // Insérer dans la base de données
            // Exemple avec PDO:
            $stmt = $pdo->prepare("INSERT INTO $targetTable (" . implode(',', $headers) . ") VALUES (" . str_repeat('?,', count($headers) - 1) . "?)");
            $stmt->execute(array_values($record));
            
            $importedCount++;
        }
        
        // Rediriger avec succès
        header('Location: ../index.php#import?imported=' . $importedCount);
        exit;
        
    } catch (Exception $e) {
        header('Location: ../index.php#import?error=' . urlencode('Erreur: ' . $e->getMessage()));
        exit;
    }
}

header('Location: ../index.php#import?error=' . urlencode('Méthode non autorisée'));
exit;</pre>
        </div>

        <div class="code-instruction">
            <strong>📁 HTML pour le formulaire:</strong>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>&lt;form action="import/import_xlsx.php" method="POST" enctype="multipart/form-data"&gt;
    &lt;div class="form-group"&gt;
        &lt;label for="xlsxFile"&gt;Sélectionner un fichier XLSX:&lt;/label&gt;
        &lt;input type="file" id="xlsxFile" name="xlsxFile" accept=".xlsx" required&gt;
    &lt;/div&gt;
    &lt;div class="form-group"&gt;
        &lt;label for="targetTable"&gt;Table cible:&lt;/label&gt;
        &lt;select id="targetTable" name="targetTable"&gt;
            &lt;option value="students"&gt;students&lt;/option&gt;
            &lt;option value="products" selected&gt;products&lt;/option&gt;
            &lt;option value="employees"&gt;employees&lt;/option&gt;
        &lt;/select&gt;
    &lt;/div&gt;
    &lt;button type="submit" class="btn"&gt;📊 Importer XLSX&lt;/button&gt;
&lt;/form&gt;</pre>
        </div>
    </div>

    <!-- Section Exemple CSV -->
    <div class="import-type-section">
        <h4>📁 Exemple de fichier CSV</h4>
        
        <div class="code-instruction">
            <strong>Format CSV attendu:</strong>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>id,nom,prenom,classe,moyenne,statut
11,Dupont,Jean,L1,14.5,Admis
12,Martin,Marie,L2,16.2,Admis
13,Bernard,Pierre,L1,9.5,Ajourné</pre>
        </div>
    </div>

    <!-- Section Configuration Base de données -->
    <div class="import-type-section">
        <h4>🗄️ Configuration de la base de données (PDO)</h4>
        
        <div class="code-instruction">
            <strong>📁 Fichier de connexion:</strong> <code>config/database.php</code>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>&lt;?php
// Configuration de la base de données avec PDO

$host = 'localhost';
$dbname = 'votre_base';
$username = 'votre_user';
$password = 'votre_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}</pre>
        </div>

        <div class="code-instruction">
            <strong>📁 À inclure dans vos fichiers d'import:</strong>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>&lt;?php
require '../config/database.php';

// Utiliser $pdo pour vos requêtes
$stmt = $pdo->prepare("INSERT INTO ...");
$stmt->execute([...]);</pre>
        </div>
    </div>
</div>

<style>
.import-type-section {
    background: var(--light);
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.import-type-section h4 {
    color: var(--primary);
    margin-bottom: 1rem;
    font-size: 1.3rem;
}

.note {
    background: #fef3c7;
    border-left: 4px solid #f59e0b;
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 0 8px 8px 0;
}

.note code {
    background: rgba(0,0,0,0.1);
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
    font-family: monospace;
}
</style>
