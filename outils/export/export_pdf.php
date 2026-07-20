<?php
// Export PDF - Nécessite TCPDF
// Installation: composer require tecnickcom/tcpdf

require __DIR__ . '/../vendor/autoload.php';

use TCPDF;

$table = $_GET['table'] ?? 'employees';
$data = include __DIR__ . '/../data.php';

if (!isset($data[$table])) {
    die("Table non trouvée");
}

$records = $data[$table];

// Créer un nouveau document PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Définir les métadonnées
$pdf->SetCreator('Aide-Mémoire Dev');
$pdf->SetAuthor('Export System');
$pdf->SetTitle('Export ' . ucfirst($table));

// Ajouter une page
$pdf->AddPage();

// Titre
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Export: ' . ucfirst($table), 0, 1, 'C');
$pdf->Ln(10);

// Créer le tableau HTML
$html = '<table border="1" cellpadding="5" cellspacing="0" style="width:100%;">';

// En-têtes du tableau
if (!empty($records)) {
    $html .= '<tr style="background-color:#6366f1;color:white;">';
    foreach (array_keys($records[0]) as $header) {
        $html .= '<th style="text-align:center;">' . ucfirst($header) . '</th>';
    }
    $html .= '</tr>';
}

// Données du tableau
foreach ($records as $record) {
    $html .= '<tr>';
    foreach ($record as $value) {
        $html .= '<td style="text-align:center;">' . htmlspecialchars($value) . '</td>';
    }
    $html .= '</tr>';
}

$html .= '</table>';

// Écrire le HTML dans le PDF
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTML($html, true, false, true, false, '');

// Définir les headers pour le téléchargement
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $table . '_export.pdf"');
header('Cache-Control: max-age=0');

// Générer et envoyer le PDF
$pdf->Output($table . '_export.pdf', 'D');
exit;
