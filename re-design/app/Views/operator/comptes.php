<?php $currentPage = 'comptes'; ?>
<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Comptes Clients - Mobile Money</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=block" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=JetBrains+Mono:wght@500&amp;family=Lexend:wght@500;600;700&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="<?= base_url('tailwind/common.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('css/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/comptes.css') ?>">
</head>
<body class="bg-background text-on-background min-h-screen pb-[80px] md:pb-0 pt-[64px] md:pt-[80px]">
<?php include 'navbar.php'; ?>
<!-- Main Content -->
<main class="max-w-[1280px] mx-auto px-container-margin py-lg flex flex-col gap-lg">
<!-- Page Header Section -->
<section class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-md">
<div>
<h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Comptes Clients</h1>
<p class="font-body-md text-body-md text-on-surface-variant mt-xs">Gestion, suivi et administration des portefeuilles utilisateurs.</p>
</div>
</section>
<!-- Controls (Search & Filters) -->
<section class="layer-1 rounded-xl shadow-[0px_4px_20px_rgba(0,168,150,0.05)] border border-outline-variant/30 p-md flex flex-col lg:flex-row justify-between items-center gap-md">
<!-- Search Bar -->
<div class="relative w-full lg:max-w-md">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
<input id="searchInput" class="w-full bg-background border border-outline-variant rounded-lg py-2 pl-10 pr-4 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant/70 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all" placeholder="Rechercher par ID, Nom ou N° Compte..." type="text"/>
</div>
<!-- Filter & Action Buttons -->
<div class="flex items-center gap-sm w-full lg:w-auto overflow-x-auto pb-2 lg:pb-0 hide-scrollbar">
<button id="filterBtn" class="flex items-center gap-sm px-4 py-2 border border-outline-variant rounded-lg font-label-sm text-label-sm text-on-surface hover:bg-surface-container-low hover:border-outline transition-colors whitespace-nowrap">
<span class="material-symbols-outlined text-[18px]">filter_list</span>
                    Filtres Avancés
                </button>
<button id="sortBtn" class="flex items-center gap-sm px-4 py-2 border border-outline-variant rounded-lg font-label-sm text-label-sm text-on-surface hover:bg-surface-container-low hover:border-outline transition-colors whitespace-nowrap">
<span class="material-symbols-outlined text-[18px]">sort</span>
                    Trier par: Récents
                </button>
<div class="w-px h-6 bg-outline-variant mx-1 hidden sm:block"></div>
<button id="exportBtn" class="flex items-center gap-sm px-4 py-2 bg-secondary/10 text-secondary border border-transparent rounded-lg font-label-sm text-label-sm hover:bg-secondary/20 transition-colors whitespace-nowrap">
<span class="material-symbols-outlined text-[18px]">download</span>
                    Exporter
                </button>
</div>
</section>
<!-- Data Table -->
<section class="layer-1 rounded-xl shadow-[0px_4px_20px_rgba(0,168,150,0.05)] border border-outline-variant/30 flex flex-col overflow-hidden">
<div class="overflow-x-auto w-full">
<table class="w-full text-left border-collapse min-w-[800px]">
<thead class="bg-surface-container-lowest border-b border-outline-variant/30">
<tr>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold w-24" scope="col">ID</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold" scope="col">N° Compte</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold" scope="col">Nom du Client</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold text-right" scope="col">Solde</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold text-center w-32" scope="col">Statut</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold text-right w-20" scope="col">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/20">
                                    <?php foreach($comptes as $compte): ?>
<tr class="hover:bg-surface-container-lowest/60 transition-colors group">
<td class="py-4 px-lg font-mono-data text-mono-data text-on-surface-variant"><?= $compte['id'] ?></td>
<td class="py-4 px-lg font-mono-data text-mono-data text-primary font-semibold">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-[16px] text-primary/70">account_balance_wallet</span>
<?= $compte['numero'] ?>
</div>
</td>
<td class="py-4 px-lg font-body-md text-body-md text-on-surface font-medium"><?= $compte['nom'] ?> <?= $compte['prenom'] ?></td>
<td class="py-4 px-lg font-mono-data text-mono-data text-on-surface text-right"><?= number_format($compte['solde'], 0, ',', ' ') ?> Ar</td>
<td class="py-4 px-lg text-center">
                                            <?php 
                                            $badgeClass = 'bg-primary-container/10 text-primary border-primary/20';
                                            $dotClass = 'bg-primary';
                                            if($compte['etat_libelle'] == 'Bloqué') {
                                                $badgeClass = 'bg-error-container/30 text-error border-error/20';
                                                $dotClass = 'bg-error';
                                            } elseif($compte['etat_libelle'] == 'Suspendu') {
                                                $badgeClass = 'bg-secondary-container/30 text-secondary border-secondary/20';
                                                $dotClass = 'bg-secondary';
                                            }
                                            ?>
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full <?= $badgeClass ?> font-label-sm text-label-sm border">
<span class="w-1.5 h-1.5 rounded-full <?= $dotClass ?> <?= $compte['etat_libelle'] == 'Actif' ? 'animate-pulse' : '' ?>"></span>
<?= $compte['etat_libelle'] ?>
</span>
</td>
<td class="py-4 px-lg text-right">
<div class="flex justify-end gap-xs">
<button class="view-btn text-on-surface-variant hover:text-primary hover:bg-surface-container-low rounded-full p-1.5 transition-colors focus:outline-none focus:ring-2 focus:ring-primary" data-numero="<?= $compte['numero'] ?>">
<span class="material-symbols-outlined text-[20px] block">visibility</span>
</button>
<button class="state-btn text-on-surface-variant hover:text-warning hover:bg-surface-container-low rounded-full p-1.5 transition-colors focus:outline-none focus:ring-2 focus:ring-primary" data-numero="<?= $compte['numero'] ?>">
<span class="material-symbols-outlined text-[20px] block">settings</span>
</button>
</div>
</td>
</tr>
                                    <?php endforeach; ?>
</tbody>
</table>
</div>
<!-- Pagination Footer -->
<div class="border-t border-outline-variant/30 px-lg py-sm flex flex-col sm:flex-row items-center justify-between gap-md bg-surface-container-lowest/50">
<div class="font-body-sm text-body-sm text-on-surface-variant">
                    Affichage de <span class="font-medium text-on-surface"><?= count($comptes) ?></span> résultats
                </div>
</div>
</section>
</main>

<!-- Change State Modal -->
<div id="changeStateModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
<div class="layer-2 rounded-xl max-w-md w-full mx-4 overflow-hidden">
<div class="bg-surface-container px-lg py-md border-b border-outline-variant/30 flex justify-between items-center">
<h3 class="font-headline-md text-headline-md text-on-surface">Changer l'état du compte</h3>
<button id="closeStateModal" class="text-on-surface-variant hover:text-on-surface transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div class="p-lg">
<form id="changeStateForm">
<input type="hidden" id="accountNumber">
<div class="mb-md">
<label for="newState" class="block font-label-md text-label-md text-on-surface mb-sm">Nouvel état</label>
<select class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="newState">
                                    <?php foreach($etats as $etat): ?>
<option value="<?= $etat['id'] ?>"><?= $etat['libelle'] ?></option>
                                    <?php endforeach; ?>
</select>
</div>
</form>
</div>
<div class="px-lg py-md bg-surface-container-low border-t border-outline-variant/30 flex justify-end gap-sm">
<button id="cancelState" class="px-lg py-md text-on-surface-variant hover:text-on-surface transition-colors">Annuler</button>
<button id="submitState" class="px-lg py-md bg-primary-container text-on-primary rounded-lg hover:shadow-lg transition-all">Changer</button>
</div>
</div>
</div>

<!-- Advanced Filters Modal -->
<div id="filterModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
<div class="layer-2 rounded-xl max-w-lg w-full mx-4 overflow-hidden">
<div class="bg-surface-container px-lg py-md border-b border-outline-variant/30 flex justify-between items-center">
<h3 class="font-headline-md text-headline-md text-on-surface">Filtres Avancés</h3>
<button id="closeFilterModal" class="text-on-surface-variant hover:text-on-surface transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div class="p-lg">
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Type de filtre solde</label>
<select id="filterType" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none">
<option value="">Aucun filtre de solde</option>
<option value="between">Entre deux valeurs</option>
<option value="around">Autour de (±10%)</option>
<option value="less">Inférieur à</option>
<option value="greater">Supérieur à</option>
</select>
</div>
<div id="filterValues" class="hidden">
<div id="betweenInputs" class="hidden mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Solde entre (Ar)</label>
<div class="flex gap-sm">
<input type="number" id="minSolde" class="w-1/2 px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" placeholder="Min">
<input type="number" id="maxSolde" class="w-1/2 px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" placeholder="Max">
</div>
</div>
<div id="aroundInput" class="hidden mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Solde autour de (Ar)</label>
<input type="number" id="aroundSolde" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" placeholder="Ex: 500000">
</div>
<div id="lessInput" class="hidden mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Solde inférieur à (Ar)</label>
<input type="number" id="lessSolde" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" placeholder="Ex: 1000000">
</div>
<div id="greaterInput" class="hidden mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Solde supérieur à (Ar)</label>
<input type="number" id="greaterSolde" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" placeholder="Ex: 100000">
</div>
</div>
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Statut</label>
<select id="filterStatus" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none">
<option value="">Tous les statuts</option>
<option value="Actif">Actif</option>
<option value="Bloqué">Bloqué</option>
<option value="Suspendu">Suspendu</option>
</select>
</div>
</div>
<div class="px-lg py-md bg-surface-container-low border-t border-outline-variant/30 flex justify-between gap-sm">
<button id="resetFilters" class="px-lg py-md text-on-surface-variant hover:text-on-surface transition-colors">Réinitialiser</button>
<div class="flex gap-sm">
<button id="cancelFilter" class="px-lg py-md text-on-surface-variant hover:text-on-surface transition-colors">Annuler</button>
<button id="applyFilters" class="px-lg py-md bg-primary-container text-on-primary rounded-lg hover:shadow-lg transition-all">Appliquer</button>
</div>
</div>
</div>
</div>

<script>
// Définir les URLs pour le JS
window.API_URLS = {
    view: '<?= base_url('/operator/comptes/view/') ?>',
    updateState: '<?= base_url('/operator/comptes/update-state') ?>'
};
</script>
<script src="<?= base_url('js/comptes.js') ?>"></script>
<script src="<?= base_url('js/filtreClient.js') ?>"></script>
<script src="<?= base_url('js/exportListClient.js') ?>"></script>
</body>
</html>
