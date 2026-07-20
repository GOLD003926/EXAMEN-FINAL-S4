<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aide-Mémoire Développement Web</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>🚀 Aide-Mémoire Développement Web</h1>
        <p>Code prêt à copier pour vos projets</p>
    </header>

    <nav>
        <ul>
            <li><a href="#filtres">🔍 Filtres Multi-Critères</a></li>
            <li><a href="#graphiques">📊 Graphiques</a></li>
            <li><a href="#export">📤 Export</a></li>
            <li><a href="#import">📥 Import</a></li>
        </ul>
    </nav>

    <main>
        <!-- Section Filtres -->
        <section id="filtres" class="section">
            <h2>🔍 Filtres Multi-Critères</h2>
            <p>Filtrer des données avec plusieurs critères en JavaScript pur</p>
            
            <div class="tabs">
                <button class="tab-btn active" data-tab="filtres-demo">Démo</button>
                <button class="tab-btn" data-tab="filtres-code">Code</button>
            </div>

            <div id="filtres-demo" class="tab-content active">
                <?php include 'filtres/demo.php'; ?>
            </div>

            <div id="filtres-code" class="tab-content">
                <?php include 'filtres/code.php'; ?>
            </div>
        </section>

        <!-- Section Graphiques -->
        <section id="graphiques" class="section">
            <h2>📊 Graphiques</h2>
            <p>Créer des graphiques interactifs avec Chart.js</p>
            
            <div class="tabs">
                <button class="tab-btn active" data-tab="graphiques-demo">Démo</button>
                <button class="tab-btn" data-tab="graphiques-code">Code</button>
            </div>

            <div id="graphiques-demo" class="tab-content active">
                <?php include 'graphiques/demo.php'; ?>
            </div>

            <div id="graphiques-code" class="tab-content">
                <?php include 'graphiques/code.php'; ?>
            </div>
        </section>

        <!-- Section Export -->
        <section id="export" class="section">
            <h2>📤 Export de Données</h2>
            <p>Exporter vos données en PDF, Excel, CSV</p>
            
            <div class="tabs">
                <button class="tab-btn active" data-tab="export-demo">Démo</button>
                <button class="tab-btn" data-tab="export-code">Code</button>
            </div>

            <div id="export-demo" class="tab-content active">
                <?php include 'export/demo.php'; ?>
            </div>

            <div id="export-code" class="tab-content">
                <?php include 'export/code.php'; ?>
            </div>
        </section>

        <!-- Section Import -->
        <section id="import" class="section">
            <h2>📥 Import de Données</h2>
            <p>Importer des fichiers Excel, CSV dans votre base de données</p>
            
            <div class="tabs">
                <button class="tab-btn active" data-tab="import-demo">Démo</button>
                <button class="tab-btn" data-tab="import-code">Code</button>
            </div>

            <div id="import-demo" class="tab-content active">
                <?php include 'import/demo.php'; ?>
            </div>

            <div id="import-code" class="tab-content">
                <?php include 'import/code.php'; ?>
            </div>
        </section>
    </main>

    <footer>
        <p>Site d'aide-mémoire - Code moderne et facile à intégrer</p>
    </footer>

    <script src="js/main.js"></script>
</body>
</html>
