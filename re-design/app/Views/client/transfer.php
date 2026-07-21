<?php $currentPage = 'transfert'; ?>
<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Transfert - Mobile Money</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=block" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=JetBrains+Mono:wght@500&amp;family=Lexend:wght@500;600;700&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="<?= base_url('tailwind/common.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('css/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/transfer.css') ?>">
</head>
<body class="bg-background text-on-background min-h-screen pb-[80px] md:pb-0 pt-[64px] md:pt-[80px]">
<?php include 'navbar.php'; ?>
<!-- Main Content -->
<main class="max-w-[1280px] mx-auto px-container-margin py-lg flex flex-col gap-lg">
<!-- Page Header -->
<section class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-md">
<div>
<h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Transfert</h1>
<p class="font-body-md text-body-md text-on-surface-variant mt-xs">Envoyez de l'argent à d'autres utilisateurs.</p>
</div>
</section>
<!-- Balance Card -->
<section class="layer-1 bg-primary-container/10 border border-primary/20 rounded-xl p-lg shadow-[0px_4px_20px_rgba(0,168,150,0.08)]">
<div class="flex items-center gap-md">
<div class="bg-primary/20 p-3 rounded-full flex-shrink-0">
<span class="material-symbols-outlined text-[32px] text-primary">account_balance_wallet</span>
</div>
<div>
<p class="font-body-sm text-body-sm text-on-surface-variant">Solde actuel</p>
<p class="font-headline-md text-headline-md text-primary font-semibold"><?= number_format($solde, 0, ',', ' ') ?> Ar</p>
</div>
</div>
</section>
<!-- Transfer Form Card -->
<section class="layer-1 rounded-xl shadow-[0px_4px_20px_rgba(0,168,150,0.05)] border border-outline-variant/30 overflow-hidden">
<!-- Tabs -->
<div class="border-b border-outline-variant/30 bg-surface-container-low">
<div class="flex">
<button id="singleTab" class="flex-1 px-lg py-md font-label-md text-label-sm text-primary border-b-2 border-primary transition-colors flex items-center justify-center gap-sm">
<span class="material-symbols-outlined text-[18px]">person</span>
                    Transfert Simple
                </button>
<button id="multipleTab" class="flex-1 px-lg py-md font-label-md text-label-sm text-on-surface-variant border-b-2 border-transparent hover:text-primary transition-colors flex items-center justify-center gap-sm">
<span class="material-symbols-outlined text-[18px]">groups</span>
                    Envoi Multiple
                </button>
</div>
</div>
<!-- Tab Content -->
<div class="p-lg">
<!-- Single Transfer -->
<div id="singleContent">
<form id="transferForm">
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Numéro du destinataire</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">person</span>
<input type="text" id="destinataire" class="w-full px-md py-md pl-10 bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" placeholder="033..." pattern="\d{10}" required>
</div>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">10 chiffres requis</p>
<div id="operateurInfo" class="mt-xs"></div>
</div>
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Montant à transférer (Ar)</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">payments</span>
<input type="number" id="montant" class="w-full px-md py-md pl-10 bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" placeholder="Ex: 50000" min="100" required>
</div>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Montant minimum: 100 Ar</p>
</div>
<div class="mb-md hidden" id="inclureFraisRetraitDiv">
<div class="flex items-center gap-sm">
<input type="checkbox" id="inclureFraisRetrait" class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary">
<label for="inclureFraisRetrait" class="font-body-md text-body-md text-on-surface flex items-center gap-sm">
<span class="material-symbols-outlined text-[18px] text-primary">info</span>
<span>Inclure les frais de retrait anticipés</span>
</label>
</div>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-xs ml-7">Le destinataire pourra retirer l'argent sans frais supplémentaires</p>
</div>
<div class="mb-md bg-warning-container/10 border border-warning/30 rounded-lg p-md flex items-start gap-sm">
<span class="material-symbols-outlined text-warning text-[20px]">warning</span>
<p class="font-body-sm text-body-sm text-on-surface-variant">Des frais seront appliqués selon le montant.</p>
</div>
<button type="submit" class="w-full px-lg py-md bg-[#ffc107] text-white rounded-lg hover:shadow-lg transition-all font-label-md text-label-md flex items-center justify-center gap-sm">
<span class="material-symbols-outlined text-[18px]">send</span>
                Effectuer le Transfert
            </button>
</form>
</div>
<!-- Multiple Transfer -->
<div id="multipleContent" class="hidden">
<form id="multipleTransferForm">
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Montant total à envoyer (Ar)</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">payments</span>
<input type="number" id="montantTotal" class="w-full px-md py-md pl-10 bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" placeholder="Ex: 150000" min="100" required>
</div>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Ce montant sera divisé équitablement entre tous les destinataires</p>
</div>
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Destinataires</label>
<div id="destinatairesContainer">
<div class="flex gap-sm mb-sm destinataire-row">
<span class="material-symbols-outlined text-on-surface-variant text-[20px]">person</span>
<input type="text" class="flex-1 px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none destinataire-input" placeholder="033..." pattern="\d{10}" required>
<button type="button" class="p-2 text-error hover:bg-error/10 rounded-lg transition-colors remove-destinataire hidden">
<span class="material-symbols-outlined text-[20px]">delete</span>
</button>
</div>
</div>
<button type="button" id="addDestinataireBtn" class="px-lg py-md border border-outline-variant text-on-surface rounded-lg hover:bg-surface-container-low transition-all font-label-md text-label-sm flex items-center gap-sm">
<span class="material-symbols-outlined text-[18px]">add</span>
                Ajouter un destinataire
            </button>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Minimum 2 destinataires pour l'envoi multiple. Internes et externes acceptés.</p>
</div>
<div class="mb-md">
<div class="flex items-center gap-sm">
<input type="checkbox" id="inclureFraisRetraitMultiple" class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary">
<label for="inclureFraisRetraitMultiple" class="font-body-md text-body-md text-on-surface flex items-center gap-sm">
<span class="material-symbols-outlined text-[18px] text-primary">info</span>
<span>Inclure les frais de retrait anticipés pour tous</span>
</label>
</div>
</div>
<div class="bg-primary-container/10 border border-primary/20 rounded-lg p-md flex items-start gap-sm mb-md">
<span class="material-symbols-outlined text-primary text-[20px]">info</span>
<p class="font-body-sm text-body-sm text-on-surface-variant">L'envoi multiple accepte les destinataires internes et externes. Les commissions seront appliquées pour les transferts externes.</p>
</div>
<button type="submit" class="w-full px-lg py-md bg-[#ffc107] text-white rounded-lg hover:shadow-lg transition-all font-label-md text-label-md flex items-center justify-center gap-sm">
<span class="material-symbols-outlined text-[18px]">groups</span>
                Envoyer à Plusieurs
            </button>
</form>
</div>
</div>
</section>
</main>
<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
<div class="layer-2 rounded-xl max-w-md w-full mx-4 overflow-hidden">
<div class="bg-primary-container px-lg py-md border-b border-outline-variant/30 flex justify-between items-center">
<h3 class="font-headline-md text-headline-md text-on-primary">Transfert Réussi</h3>
<button id="closeSuccessModal" class="text-on-primary hover:opacity-80 transition-colors">
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
<div class="px-lg py-md bg-surface-container-low border-t border-outline-variant/30 flex justify-end gap-sm">
<button id="closeModalBtn" class="px-lg py-md text-on-surface-variant hover:text-on-surface transition-colors">Fermer</button>
<a href="<?= base_url('/client/solde') ?>" class="px-lg py-md bg-primary-container text-on-primary rounded-lg hover:shadow-lg transition-all font-label-md text-label-sm">Voir Solde</a>
</div>
</div>
</div>
<script>
window.API_URLS = {
    create: '<?= base_url('/client/transfert/create') ?>',
    createMultiple: '<?= base_url('/client/transfert/createMultiple') ?>',
    getOperateur: '<?= base_url('/operator/prefixes/get-operateur') ?>'
};
</script>
<script src="<?= base_url('js/transfer.js') ?>"></script>
</body>
</html>
