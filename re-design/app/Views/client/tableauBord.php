<?php $currentPage = 'accueil'; ?>
<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Tableau de Bord - Mobile Money</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=block" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=JetBrains+Mono:wght@500&amp;family=Lexend:wght@500;600;700&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="<?= base_url('tailwind/common.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('css/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/tableauBord.css') ?>">
</head>
<body class="bg-background text-on-background min-h-screen pb-[80px] md:pb-0 pt-[64px] md:pt-[80px]">
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
<h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-2">Bienvenue!</h1>
<p class="font-body-md text-body-md text-on-surface-variant flex items-center gap-2">
<span class="material-symbols-outlined text-primary-container text-[18px]">verified</span>
                        Vous êtes connecté avec le numéro: <strong class="text-primary font-semibold"><?= session('numero') ?></strong>
                    </p>
</div>
<div class="mt-4 md:mt-0 z-10">
<span class="inline-flex items-center gap-1 bg-surface-container text-primary px-3 py-1.5 rounded-full font-label-sm text-label-sm">
<span class="w-2 h-2 rounded-full bg-primary-container animate-pulse"></span>
                        Compte Actif
                    </span>
</div>
</div>
</div>
<!-- Action Cards Grid -->
<div class="col-span-4 md:col-span-12 grid grid-cols-2 md:grid-cols-4 gap-gutter mb-lg">
<!-- Card 1: Voir Solde -->
<div class="layer-1 rounded-xl p-md flex flex-col relative overflow-hidden group">
<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-[64px] text-primary">account_balance_wallet</span>
</div>
<div class="flex justify-between items-start mb-4 relative z-10">
<div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-primary">
<span class="material-symbols-outlined icon-fill">visibility</span>
</div>
</div>
<div class="relative z-10 mt-auto">
<p class="font-body-sm text-body-sm text-on-surface-variant mb-1">Voir Solde</p>
<h3 class="font-headline-md text-headline-md text-on-surface font-semibold">Consultez votre solde</h3>
<button onclick="openModal('soldeModal')" class="mt-3 inline-flex items-center gap-1 text-primary font-label-sm text-label-sm hover:underline">
Voir <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
</button>
</div>
</div>
<!-- Card 2: Effectuer un Dépôt -->
<div class="layer-1 rounded-xl p-md flex flex-col relative overflow-hidden group">
<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-[64px] text-[#0d6efd]">add_circle</span>
</div>
<div class="flex justify-between items-start mb-4 relative z-10">
<div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-[#0d6efd]">
<span class="material-symbols-outlined icon-fill">add</span>
</div>
</div>
<div class="relative z-10 mt-auto">
<p class="font-body-sm text-body-sm text-on-surface-variant mb-1">Effectuer un Dépôt</p>
<h3 class="font-headline-md text-headline-md text-on-surface font-semibold">Ajouter de l'argent</h3>
<button onclick="openModal('depotModal')" class="mt-3 inline-flex items-center gap-1 text-[#0d6efd] font-label-sm text-label-sm hover:underline">
Dépôt <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
</button>
</div>
</div>
<!-- Card 3: Effectuer un Retrait -->
<div class="layer-1 rounded-xl p-md flex flex-col relative overflow-hidden group">
<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-[64px] text-[#dc3545]">remove_circle</span>
</div>
<div class="flex justify-between items-start mb-4 relative z-10">
<div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-[#dc3545]">
<span class="material-symbols-outlined icon-fill">remove</span>
</div>
</div>
<div class="relative z-10 mt-auto">
<p class="font-body-sm text-body-sm text-on-surface-variant mb-1">Effectuer un Retrait</p>
<h3 class="font-headline-md text-headline-md text-on-surface font-semibold">Retirer de l'argent</h3>
<button onclick="openModal('retraitModal')" class="mt-3 inline-flex items-center gap-1 text-[#dc3545] font-label-sm text-label-sm hover:underline">
Retrait <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
</button>
</div>
</div>
<!-- Card 4: Effectuer un Transfert -->
<div class="layer-1 rounded-xl p-md flex flex-col relative overflow-hidden group">
<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-[64px] text-[#ffc107]">send</span>
</div>
<div class="flex justify-between items-start mb-4 relative z-10">
<div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-[#ffc107]">
<span class="material-symbols-outlined icon-fill">send</span>
</div>
</div>
<div class="relative z-10 mt-auto">
<p class="font-body-sm text-body-sm text-on-surface-variant mb-1">Effectuer un Transfert</p>
<h3 class="font-headline-md text-headline-md text-on-surface font-semibold">Envoyer de l'argent</h3>
<a href="<?= base_url('/client/transfert') ?>" class="mt-3 inline-flex items-center gap-1 text-[#e6a700] font-label-sm text-label-sm hover:underline">
Transfert <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
</a>
</div>
</div>
</div>
<!-- History Card -->
<div class="col-span-4 md:col-span-12">
<div class="layer-1 rounded-xl p-lg relative overflow-hidden group">
<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-[64px] text-tertiary">history</span>
</div>
<div class="flex items-center gap-4 relative z-10">
<div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-tertiary">
<span class="material-symbols-outlined icon-fill text-[24px]">history</span>
</div>
<div class="flex-grow">
<h3 class="font-headline-md text-headline-md text-on-surface">Historique des Transactions</h3>
<p class="font-body-md text-body-md text-on-surface-variant">Consultez toutes vos transactions précédentes</p>
</div>
<a href="<?= base_url('/client/historique') ?>" class="px-lg py-md bg-surface-container text-on-surface rounded-lg hover:bg-surface-container-high transition-all font-label-md text-label-sm flex items-center gap-sm border border-outline-variant/30">
<span class="material-symbols-outlined text-[18px]">list</span>
                    Voir l'historique
                </a>
</div>
</div>
</div>
</main>
<!-- Modal Solde -->
<div id="soldeModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
<div class="layer-2 rounded-xl max-w-md w-full mx-4 overflow-hidden">
<div class="bg-primary-container px-lg py-md border-b border-outline-variant/30 flex justify-between items-center">
<h3 class="font-headline-md text-headline-md text-on-primary">Votre Solde</h3>
<button onclick="closeModal('soldeModal')" class="text-on-primary hover:opacity-80 transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div class="p-lg text-center">
<div class="mb-md">
<span class="material-symbols-outlined text-[64px] text-primary">account_balance_wallet</span>
</div>
<p class="font-body-sm text-body-sm text-on-surface-variant mb-sm">Solde actuel</p>
<h2 id="balanceAmount" class="font-headline-lg text-headline-lg text-primary font-semibold mb-sm"><?= number_format($solde ?? 0, 0, ',', ' ') ?> Ar</h2>
<p class="font-body-sm text-body-sm text-on-surface-variant">Numéro: <?= session('numero') ?></p>
<div class="mt-md">
<button onclick="refreshBalance()" class="px-lg py-md bg-surface-container text-on-surface rounded-lg hover:bg-surface-container-high transition-all font-label-md text-label-sm flex items-center gap-sm border border-outline-variant/30">
<span class="material-symbols-outlined text-[18px]">refresh</span>
Actualiser
</button>
</div>
</div>
</div>
</div>
<!-- Modal Dépôt -->
<div id="depotModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
<div class="layer-2 rounded-xl max-w-md w-full mx-4 overflow-hidden">
<div class="bg-[#0d6efd] px-lg py-md border-b border-outline-variant/30 flex justify-between items-center">
<h3 class="font-headline-md text-headline-md text-white">Effectuer un Dépôt</h3>
<button onclick="closeModal('depotModal')" class="text-white hover:opacity-80 transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div class="p-lg">
<form id="depositForm">
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Montant à déposer (Ar)</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">payments</span>
<input type="number" id="depositMontant" class="w-full px-md py-md pl-10 bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" placeholder="Ex: 50000" min="100" required>
</div>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Montant minimum: 100 Ar</p>
</div>
<div class="bg-primary-container/10 border border-primary/20 rounded-lg p-md flex items-start gap-sm mb-md">
<span class="material-symbols-outlined text-primary text-[20px]">info</span>
<p class="font-body-sm text-body-sm text-on-surface-variant">Le dépôt sera automatiquement crédité sur votre compte.</p>
</div>
<button type="submit" class="w-full px-lg py-md bg-[#0d6efd] text-white rounded-lg hover:shadow-lg transition-all font-label-md text-label-md flex items-center justify-center gap-sm">
<span class="material-symbols-outlined text-[18px]">add_circle</span>
Effectuer le Dépôt
</button>
</form>
</div>
</div>
</div>
<!-- Modal Retrait -->
<div id="retraitModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
<div class="layer-2 rounded-xl max-w-md w-full mx-4 overflow-hidden">
<div class="bg-[#dc3545] px-lg py-md border-b border-outline-variant/30 flex justify-between items-center">
<h3 class="font-headline-md text-headline-md text-white">Effectuer un Retrait</h3>
<button onclick="closeModal('retraitModal')" class="text-white hover:opacity-80 transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div class="p-lg">
<div class="bg-primary-container/10 border border-primary/20 rounded-lg p-md flex items-start gap-sm mb-md">
<span class="material-symbols-outlined text-primary text-[20px]">account_balance_wallet</span>
<p class="font-body-sm text-body-sm text-on-surface-variant">Solde actuel: <strong id="withdrawalBalance"><?= number_format($solde ?? 0, 0, ',', ' ') ?> Ar</strong></p>
</div>
<form id="withdrawalForm">
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Montant à retirer (Ar)</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">payments</span>
<input type="number" id="withdrawalMontant" class="w-full px-md py-md pl-10 bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" placeholder="Ex: 50000" min="100" required>
</div>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Montant minimum: 100 Ar</p>
</div>
<div class="bg-warning-container/10 border border-warning/30 rounded-lg p-md flex items-start gap-sm mb-md">
<span class="material-symbols-outlined text-warning text-[20px]">warning</span>
<p class="font-body-sm text-body-sm text-on-surface-variant">Des frais seront appliqués selon le montant.</p>
</div>
<button type="submit" class="w-full px-lg py-md bg-[#dc3545] text-white rounded-lg hover:shadow-lg transition-all font-label-md text-label-md flex items-center justify-center gap-sm">
<span class="material-symbols-outlined text-[18px]">remove_circle</span>
Effectuer le Retrait
</button>
</form>
</div>
</div>
</div>
<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
<div class="layer-2 rounded-xl max-w-md w-full mx-4 overflow-hidden">
<div class="bg-primary-container px-lg py-md border-b border-outline-variant/30 flex justify-between items-center">
<h3 class="font-headline-md text-headline-md text-on-primary">Opération Réussie</h3>
<button onclick="closeModal('successModal')" class="text-on-primary hover:opacity-80 transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div class="p-lg text-center">
<div class="mb-md">
<span class="material-symbols-outlined text-[64px] text-primary">check_circle</span>
</div>
<p id="successMessage" class="font-body-md text-body-md text-on-surface mb-sm"></p>
<p class="font-body-sm text-body-sm text-on-surface-variant">Nouveau solde: <strong id="newSolde" class="text-primary"></strong></p>
</div>
<div class="px-lg py-md bg-surface-container-low border-t border-outline-variant/30 flex justify-end">
<button onclick="closeModal('successModal')" class="px-lg py-md text-on-surface-variant hover:text-on-surface transition-colors">Fermer</button>
</div>
</div>
</div>
<script>
window.API_URLS = {
    getBalance: '<?= base_url('/client/solde/get') ?>',
    createDeposit: '<?= base_url('/client/depot/create') ?>',
    createWithdrawal: '<?= base_url('/client/retrait/create') ?>'
};
</script>
<script src="<?= base_url('js/tableauBord.js') ?>"></script>
</body>
</html>
