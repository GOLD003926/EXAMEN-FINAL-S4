<?php
// Export CSV - Simple et sans dépendance externe

$table = $_GET['table'] ?? 'students';
$data = include __DIR__ . '/../data.php';

if (!isset($data[$table])) {
    die("Table non trouvée");
}

$records = $data[$table];

// Définir les headers pour le téléchargement
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $table . '_export.csv"');
header('Pragma: no-cache');
header('Expires: 0');

// Ouvrir le flux de sortie
$output = fopen('php://output', 'w');

// Écrire l'en-tête CSV
if (!empty($records)) {
    fputcsv($output, array_keys($records[0]));
}

// Écrire les données
foreach ($records as $record) {
    fputcsv($output, $record);
}

// Fermer le flux
fclose($output);
exit;
