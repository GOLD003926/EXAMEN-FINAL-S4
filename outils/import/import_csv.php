<?php
// Import CSV - Sans dépendance externe

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csvFile'])) {
    $targetTable = $_POST['targetTable'] ?? 'students';
    $file = $_FILES['csvFile'];
    
    // Vérifier le fichier
    if ($file['error'] !== UPLOAD_ERR_OK) {
        header('Location: /index.php#import?error=' . urlencode('Erreur lors du téléchargement du fichier'));
        exit;
    }
    
    // Lire le fichier CSV
    $handle = fopen($file['tmp_name'], 'r');
    if ($handle === false) {
        header('Location: /index.php#import?error=' . urlencode('Impossible d\'ouvrir le fichier'));
        exit;
    }
    
    // Lire l'en-tête
    $headers = fgetcsv($handle);
    if ($headers === false) {
        fclose($handle);
        header('Location: /index.php#import?error=' . urlencode('Fichier CSV vide ou invalide'));
        exit;
    }
    
    // Lire les données
    $importedCount = 0;
    while (($row = fgetcsv($handle)) !== false) {
        // Créer un tableau associatif
        $record = array_combine($headers, $row);
        
        // Ici, vous inséreriez normalement dans votre base de données
        // Pour la démo, nous simulons l'import
        $importedCount++;
        
        // Exemple d'insertion en base de données:
        // $stmt = $pdo->prepare("INSERT INTO $targetTable (" . implode(',', $headers) . ") VALUES (" . str_repeat('?,', count($headers) - 1) . "?)");
        // $stmt->execute(array_values($record));
    }
    
    fclose($handle);
    
    // Rediriger avec succès
    header('Location: /index.php#import?imported=' . $importedCount);
    exit;
}

header('Location: /index.php#import?error=' . urlencode('Méthode non autorisée'));
exit;
