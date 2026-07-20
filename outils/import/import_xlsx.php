<?php
// Import XLSX - Nécessite PhpSpreadsheet
// Installation: composer require phpoffice/phpspreadsheet

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['xlsxFile'])) {
    $targetTable = $_POST['targetTable'] ?? 'products';
    $file = $_FILES['xlsxFile'];
    
    // Vérifier le fichier
    if ($file['error'] !== UPLOAD_ERR_OK) {
        header('Location: /index.php#import?error=' . urlencode('Erreur lors du téléchargement du fichier'));
        exit;
    }
    
    try {
        // Charger le fichier Excel
        $spreadsheet = IOFactory::load($file['tmp_name']);
        $worksheet = $spreadsheet->getActiveSheet();
        
        // Obtenir les données
        $rows = $worksheet->toArray();
        
        if (empty($rows)) {
            header('Location: /index.php#import?error=' . urlencode('Fichier Excel vide'));
            exit;
        }
        
        // La première ligne contient les en-têtes
        $headers = array_shift($rows);
        
        $importedCount = 0;
        foreach ($rows as $row) {
            // Créer un tableau associatif
            $record = array_combine($headers, $row);
            
            // Ici, vous inséreriez normalement dans votre base de données
            // Pour la démo, nous simulons l'import
            $importedCount++;
            
            // Exemple d'insertion en base de données:
            // $stmt = $pdo->prepare("INSERT INTO $targetTable (" . implode(',', $headers) . ") VALUES (" . str_repeat('?,', count($headers) - 1) . "?)");
            // $stmt->execute(array_values($record));
        }
        
        // Rediriger avec succès
        header('Location: /index.php#import?imported=' . $importedCount);
        exit;
        
    } catch (Exception $e) {
        header('Location: /index.php#import?error=' . urlencode('Erreur lors de la lecture du fichier Excel: ' . $e->getMessage()));
        exit;
    }
}

header('Location: /index.php#import?error=' . urlencode('Méthode non autorisée'));
exit;
