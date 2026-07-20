<?php
// Export XLSX - Nécessite PhpSpreadsheet
// Installation: composer require phpoffice/phpspreadsheet

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$table = $_GET['table'] ?? 'products';
$data = include __DIR__ . '/../data.php';

if (!isset($data[$table])) {
    die("Table non trouvée");
}

$records = $data[$table];

// Créer un nouveau spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Écrire les en-têtes
if (!empty($records)) {
    $col = 1;
    foreach (array_keys($records[0]) as $header) {
        $sheet->setCellValueByColumnAndRow($col++, 1, ucfirst($header));
    }
}

// Écrire les données
$row = 2;
foreach ($records as $record) {
    $col = 1;
    foreach ($record as $value) {
        $sheet->setCellValueByColumnAndRow($col++, $row, $value);
    }
    $row++;
}

// Style des en-têtes
$sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
    'font' => ['bold' => true],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'color' => ['rgb' => '6366f1']
    ],
    'font' => ['color' => ['rgb' => 'FFFFFF']]
]);

// Ajuster la largeur des colonnes
foreach (range('A', $sheet->getHighestColumn()) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Définir les headers pour le téléchargement
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $table . '_export.xlsx"');
header('Cache-Control: max-age=0');

// Sauvegarder et envoyer le fichier
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
