<div class="code-container">
    <h3>📝 Code pour l'export de données</h3>

    <!-- Section Export CSV -->
    <div class="export-type-section">
        <h4>📄 Export CSV (Sans dépendance)</h4>
        
        <div class="code-instruction">
            <strong>📁 Fichier à créer:</strong> <code>export/export_csv.php</code>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>&lt;?php
// Export CSV - Simple et sans dépendance externe

$table = $_GET['table'] ?? 'students';
$data = include '../data.php';

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
exit;</pre>
        </div>

        <div class="code-instruction">
            <strong>📁 HTML pour utiliser:</strong>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>&lt;a href="export/export_csv.php?table=students" class="btn"&gt;
    📄 Exporter en CSV
&lt;/a&gt;</pre>
        </div>
    </div>

    <!-- Section Export XLSX -->
    <div class="export-type-section">
        <h4>📊 Export XLSX (Avec PhpSpreadsheet)</h4>
        
        <div class="note">
            <strong>⚠️ Installation requise:</strong> <code>composer require phpoffice/phpspreadsheet</code>
        </div>
        
        <div class="code-instruction">
            <strong>📁 Fichier à créer:</strong> <code>export/export_xlsx.php</code>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>&lt;?php
// Export XLSX - Nécessite PhpSpreadsheet
// Installation: composer require phpoffice/phpspreadsheet

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$table = $_GET['table'] ?? 'products';
$data = include '../data.php';

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
exit;</pre>
        </div>

        <div class="code-instruction">
            <strong>📁 HTML pour utiliser:</strong>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>&lt;a href="export/export_xlsx.php?table=products" class="btn"&gt;
    📊 Exporter en XLSX
&lt;/a&gt;</pre>
        </div>
    </div>

    <!-- Section Export PDF -->
    <div class="export-type-section">
        <h4>📑 Export PDF (Avec TCPDF)</h4>
        
        <div class="note">
            <strong>⚠️ Installation requise:</strong> <code>composer require tecnickcom/tcpdf</code>
        </div>
        
        <div class="code-instruction">
            <strong>📁 Fichier à créer:</strong> <code>export/export_pdf.php</code>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>&lt;?php
// Export PDF - Nécessite TCPDF
// Installation: composer require tecnickcom/tcpdf

require '../vendor/autoload.php';

use TCPDF;

$table = $_GET['table'] ?? 'employees';
$data = include '../data.php';

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
$html = '&lt;table border="1" cellpadding="5" cellspacing="0" style="width:100%;"&gt;';

// En-têtes du tableau
if (!empty($records)) {
    $html .= '&lt;tr style="background-color:#6366f1;color:white;"&gt;';
    foreach (array_keys($records[0]) as $header) {
        $html .= '&lt;th style="text-align:center;"&gt;' . ucfirst($header) . '&lt;/th&gt;';
    }
    $html .= '&lt;/tr&gt;';
}

// Données du tableau
foreach ($records as $record) {
    $html .= '&lt;tr&gt;';
    foreach ($record as $value) {
        $html .= '&lt;td style="text-align:center;"&gt;' . htmlspecialchars($value) . '&lt;/td&gt;';
    }
    $html .= '&lt;/tr&gt;';
}

$html .= '&lt;/table&gt;';

// Écrire le HTML dans le PDF
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTML($html, true, false, true, false, '');

// Définir les headers pour le téléchargement
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $table . '_export.pdf"');
header('Cache-Control: max-age=0');

// Générer et envoyer le PDF
$pdf->Output($table . '_export.pdf', 'D');
exit;</pre>
        </div>

        <div class="code-instruction">
            <strong>📁 HTML pour utiliser:</strong>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>&lt;a href="export/export_pdf.php?table=employees" class="btn"&gt;
    📑 Exporter en PDF
&lt;/a&gt;</pre>
        </div>
    </div>

    <!-- Section Data PHP -->
    <div class="export-type-section">
        <h4>🗄️ Fichier data.php (Simulation de base de données)</h4>
        
        <div class="code-instruction">
            <strong>📁 Fichier à créer:</strong> <code>data.php</code>
        </div>
        
        <div class="code-block">
            <button class="copy-btn">Copier</button>
            <pre>&lt;?php
// Simulation d'une base de données avec des données d'exemple

return [
    'students' => [
        ['id' => 1, 'nom' => 'Dupont', 'prenom' => 'Jean', 'classe' => 'L1', 'moyenne' => 14.5, 'statut' => 'Admis'],
        ['id' => 2, 'nom' => 'Martin', 'prenom' => 'Marie', 'classe' => 'L2', 'moyenne' => 16.2, 'statut' => 'Admis'],
        // ... plus de données
    ],
    'products' => [
        ['id' => 1, 'nom' => 'iPhone 15', 'categorie' => 'electronique', 'prix' => 999, 'stock' => 25],
        // ... plus de données
    ],
    'employees' => [
        ['id' => 1, 'nom' => 'Alice', 'prenom' => 'Design', 'departement' => 'design', 'statut' => 'active', 'role' => 'UI Designer'],
        // ... plus de données
    ],
];</pre>
        </div>
    </div>
</div>

<style>
.export-type-section {
    background: var(--light);
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.export-type-section h4 {
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
