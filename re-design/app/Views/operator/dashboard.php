<!DOCTYPE html><html class="light" lang="en"><head><meta charset="utf-8"><meta content="width=device-width, initial-scale=1.0" name="viewport"><link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=block" rel="stylesheet"><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=JetBrains+Mono:wght@500&amp;family=Lexend:wght@500;600&amp;display=swap" rel="stylesheet"><script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script src="<?= base_url('tailwind/common.js') ?>"></script>
<link rel="stylesheet" href="<?= base_url('css/common.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
</head>
<body class="bg-background text-on-background min-h-screen pb-[80px] md:pb-0 pt-[64px] md:pt-[80px]">
<?php $currentPage = 'dashboard'; ?>
<?php include 'navbar.php'; ?>
<!-- Main Content -->
<main class="max-w-[1280px] mx-auto px-container-margin py-lg grid grid-cols-4 md:grid-cols-12 gap-gutter">
<!-- Welcome Section -->
<div class="col-span-4 md:col-span-12 mb-md">
<div class="layer-1 rounded-xl p-lg flex flex-col md:flex-row justify-between items-start md:items-center relative overflow-hidden">
<!-- Decorative background elements -->
<div class="absolute -right-20 -top-20 w-64 h-64 bg-primary-container/10 rounded-full blur-3xl"></div>
<div class="absolute right-40 -bottom-20 w-48 h-48 bg-secondary-container/20 rounded-full blur-2xl"></div>
<div class="z-10">
<h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-2">Bienvenue, <?= $admin_prenom ?>!</h1>
<p class="font-body-md text-body-md text-on-surface-variant flex items-center gap-2">
<span class="material-symbols-outlined text-primary-container text-[18px]">verified</span>
                        Vous êtes connecté en tant que <?= ucfirst($admin_role) ?>
                    </p>
</div>
<div class="mt-4 md:mt-0 z-10">
<span class="inline-flex items-center gap-1 bg-surface-container text-primary px-3 py-1.5 rounded-full font-label-sm text-label-sm">
<span class="w-2 h-2 rounded-full bg-primary-container animate-pulse"></span>
                        Système Opérationnel
                    </span>
</div>
</div>
</div>
<!-- KPI Stats Bento Grid -->
<div class="col-span-4 md:col-span-12 grid grid-cols-2 md:grid-cols-4 gap-gutter mb-lg">
<!-- Total Gains -->
<div class="layer-1 rounded-xl p-md flex flex-col relative overflow-hidden group">
<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-[64px] text-primary">account_balance_wallet</span>
</div>
<div class="flex justify-between items-start mb-4 relative z-10">
<div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-primary">
<span class="material-symbols-outlined icon-fill">savings</span>
</div>
<span class="bg-secondary-container/30 text-primary px-2 py-0.5 rounded text-xs font-medium flex items-center gap-1">

</div>
<div class="relative z-10 mt-auto">
<p class="font-body-sm text-body-sm text-on-surface-variant mb-1">Total des Gains</p>
<h3 class="font-headline-md text-headline-md text-on-surface font-semibold"><?= number_format($totalGain, 0, ',', ' ') ?> <span class="text-lg text-on-surface-variant font-normal">Ar</span></h3>
</div>
</div>
<!-- Total Clients -->
<div class="layer-1 rounded-xl p-md flex flex-col relative overflow-hidden group">
<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-[64px] text-secondary">groups</span>
</div>
<div class="flex justify-between items-start mb-4 relative z-10">
<div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-secondary">
<span class="material-symbols-outlined icon-fill">group</span>
</div>
</div>
<div class="relative z-10 mt-auto">
<p class="font-body-sm text-body-sm text-on-surface-variant mb-1">Total Clients</p>
<h3 class="font-headline-md text-headline-md text-on-surface font-semibold"><?= $totalClients ?></h3>
</div>
</div>
<!-- Active Clients -->
<div class="layer-1 rounded-xl p-md flex flex-col relative overflow-hidden group">
<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-[64px] text-primary-container">person_check</span>
</div>
<div class="flex justify-between items-start mb-4 relative z-10">
<div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-primary-container">
<span class="material-symbols-outlined icon-fill">how_to_reg</span>
</div>
</div>
<div class="relative z-10 mt-auto">
<p class="font-body-sm text-body-sm text-on-surface-variant mb-1">Clients Actifs</p>
<h3 class="font-headline-md text-headline-md text-on-surface font-semibold"><?= $activeClients ?></h3>
</div>
</div>
<!-- Transactions -->
<div class="layer-1 rounded-xl p-md flex flex-col relative overflow-hidden group">
<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-[64px] text-tertiary">receipt_long</span>
</div>
<div class="flex justify-between items-start mb-4 relative z-10">
<div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-tertiary">
<span class="material-symbols-outlined icon-fill">receipt</span>
</div>
</div>
<div class="relative z-10 mt-auto">
<p class="font-body-sm text-body-sm text-on-surface-variant mb-1">Transactions</p>
<h3 class="font-headline-md text-headline-md text-on-surface font-semibold"><?= $totalTransactions ?></h3>
</div>
</div>
</div>
<!-- Quick Access Grid -->
<div class="col-span-4 md:col-span-4 mb-lg">
<h2 class="font-headline-md text-headline-md text-on-surface mb-md">Accès Rapide</h2>
<div class="grid grid-cols-1 gap-base">
<a href="<?= base_url('/operator/prefixes') ?>" class="layer-1 hover:layer-2 transition-all p-md rounded-lg flex items-center gap-4 text-left group border border-transparent hover:border-primary-container/20">
<div class="w-12 h-12 rounded-full bg-surface-container-high group-hover:bg-primary group-hover:text-on-primary transition-colors flex items-center justify-center text-primary">
<span class="material-symbols-outlined">numbers</span>
</div>
<div>
<h4 class="font-label-md text-label-md text-on-surface">Gérer les Préfixes</h4>
<p class="font-body-sm text-body-sm text-on-surface-variant">Configuration réseau</p>
</div>
<span class="material-symbols-outlined ml-auto text-outline-variant group-hover:text-primary transition-colors">chevron_right</span>
</a>
<a href="<?= base_url('/operator/operations') ?>" class="layer-1 hover:layer-2 transition-all p-md rounded-lg flex items-center gap-4 text-left group border border-transparent hover:border-primary-container/20">
<div class="w-12 h-12 rounded-full bg-surface-container-high group-hover:bg-primary group-hover:text-on-primary transition-colors flex items-center justify-center text-primary">
<span class="material-symbols-outlined">account_tree</span>
</div>
<div>
<h4 class="font-label-md text-label-md text-on-surface">Types d'Opérations</h4>
<p class="font-body-sm text-body-sm text-on-surface-variant">Règles de transaction</p>
</div>
<span class="material-symbols-outlined ml-auto text-outline-variant group-hover:text-primary transition-colors">chevron_right</span>
</a>
<a href="<?= base_url('/operator/gains') ?>" class="layer-1 hover:layer-2 transition-all p-md rounded-lg flex items-center gap-4 text-left group border border-transparent hover:border-primary-container/20">
<div class="w-12 h-12 rounded-full bg-surface-container-high group-hover:bg-primary group-hover:text-on-primary transition-colors flex items-center justify-center text-primary">
<span class="material-symbols-outlined">monitoring</span>
</div>
<div>
<h4 class="font-label-md text-label-md text-on-surface">Voir les Gains</h4>
<p class="font-body-sm text-body-sm text-on-surface-variant">Rapports détaillés</p>
</div>
<span class="material-symbols-outlined ml-auto text-outline-variant group-hover:text-primary transition-colors">chevron_right</span>
</a>
<a href="<?= base_url('/operator/comptes') ?>" class="layer-1 hover:layer-2 transition-all p-md rounded-lg flex items-center gap-4 text-left group border border-transparent hover:border-primary-container/20">
<div class="w-12 h-12 rounded-full bg-surface-container-high group-hover:bg-primary group-hover:text-on-primary transition-colors flex items-center justify-center text-primary">
<span class="material-symbols-outlined">manage_accounts</span>
</div>
<div>
<h4 class="font-label-md text-label-md text-on-surface">Comptes Clients</h4>
<p class="font-body-sm text-body-sm text-on-surface-variant">Gestion utilisateurs</p>
</div>
<span class="material-symbols-outlined ml-auto text-outline-variant group-hover:text-primary transition-colors">chevron_right</span>
</a>
</div>
</div>
<!-- Recent Transactions Table -->
<div class="col-span-4 md:col-span-8 mb-lg">
<div class="flex justify-between items-center mb-md">
<h2 class="font-headline-md text-headline-md text-on-surface">Transactions Récentes</h2>
<a href="<?= base_url('/operator/gains') ?>" class="text-primary font-label-md text-label-md hover:underline flex items-center gap-1">
                    Voir tout <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
</a>
</div>
<div class="layer-1 rounded-xl overflow-hidden border border-outline-variant/30">
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low border-b border-outline-variant/30">
<th class="py-3 px-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">ID</th>
<th class="py-3 px-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Numéro Source</th>
<th class="py-3 px-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Destinataire</th>
<th class="py-3 px-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider text-right">Montant</th>
<th class="py-3 px-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider text-right">Gain</th>
<th class="py-3 px-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Date</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/20">
                                    <?php foreach($recentTransactions as $transaction): ?>
<tr class="hover:bg-surface-container-lowest transition-colors group cursor-pointer">
<td class="py-3 px-4 font-mono-data text-mono-data text-on-surface"><?= $transaction['id'] ?></td>
<td class="py-3 px-4 font-body-sm text-body-sm text-on-surface"><?= $transaction['numero_source'] ?></td>
<td class="py-3 px-4 font-body-sm text-body-sm text-on-surface"><?= $transaction['numero_destinataire'] ?? '-' ?></td>
<td class="py-3 px-4 font-mono-data text-mono-data text-on-surface text-right font-medium"><?= number_format($transaction['somme'], 0, ',', ' ') ?> Ar</td>
<td class="py-3 px-4 font-mono-data text-mono-data text-primary text-right">+<?= number_format($transaction['gain'], 0, ',', ' ') ?> Ar</td>
<td class="py-3 px-4 font-body-sm text-body-sm text-on-surface-variant"><?= $transaction['created_at'] ?></td>
</tr>
                                    <?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</div>
</main>
<!-- BottomNavBar (Mobile Only) -->
<nav class="fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 py-2 pb-safe bg-surface border-t border-outline-variant shadow-[0px_-4px_20px_rgba(0,0,0,0.05)] rounded-t-xl md:hidden">
<button class="flex flex-col items-center justify-center bg-secondary-container text-on-secondary-container rounded-full px-4 py-1 active:scale-95 transition-transform duration-200">
<span class="material-symbols-outlined icon-fill" data-icon="dashboard">dashboard</span>
<span class="font-label-sm text-label-sm mt-1">Dashboard</span>
</button>
<button class="flex flex-col items-center justify-center text-on-surface-variant hover:text-primary transition-colors active:scale-95 transition-transform duration-200">
<span class="material-symbols-outlined" data-icon="sync_alt">sync_alt</span>
<span class="font-label-sm text-label-sm mt-1">Transfers</span>
</button>
</nav>
<script>
// Définir les URLs pour le JS
window.API_URLS = {
    dashboard: '<?= base_url('/operator/dashboard') ?>',
    prefixes: '<?= base_url('/operator/prefixes') ?>',
    operations: '<?= base_url('/operator/operations') ?>',
    gains: '<?= base_url('/operator/gains') ?>',
    comptes: '<?= base_url('/operator/comptes') ?>',
    logout: '<?= base_url('/logout') ?>'
};
</script>
<script src="<?= base_url('js/dashboard.js') ?>"></script></body></html>