<?php $currentPage = 'operations'; ?>
<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Types d'Opérations - Mobile Money</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=block" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=JetBrains+Mono:wght@500&amp;family=Lexend:wght@500;600;700&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="<?= base_url('tailwind/common.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('css/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/operations.css') ?>">
</head>
<body class="bg-background text-on-background min-h-screen pb-[80px] md:pb-0 pt-[64px] md:pt-[80px]">
<?php include 'navbar.php'; ?>
<!-- Main Content -->
<main class="max-w-[1280px] mx-auto px-container-margin py-lg">
<!-- Page Header & Action -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-lg gap-md">
<div>
<h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-xs">
                    Types d'Opérations
                </h1>
<p class="font-body-md text-body-md text-on-surface-variant">
                    Gérez les différents types de transactions disponibles dans le système.
                </p>
</div>
<button id="addOperationBtn" class="bg-primary-container text-on-primary font-label-md text-label-md px-lg py-md rounded-lg flex items-center gap-sm hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 transition-all">
<span class="material-symbols-outlined" data-icon="add">add</span>
                Ajouter
            </button>
</div>
<!-- Data Table Container (Level 1 Card) -->
<div class="layer-1 rounded-xl shadow-[0px_4px_20px_rgba(0,168,150,0.05)] border border-outline-variant/30 overflow-hidden">
<div class="overflow-x-auto w-full">
<table class="w-full text-left border-collapse">
<thead class="bg-surface-container/50 border-b border-outline-variant/30">
<tr>
<th class="py-md px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                                ID
                            </th>
<th class="py-md px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                                Code
                            </th>
<th class="py-md px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                                Libellé
                            </th>
<th class="py-md px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                                Description
                            </th>
<th class="py-md px-lg font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider text-right">
                                Actions
                            </th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/20">
                                    <?php foreach($operations as $operation): ?>
<tr class="hover:bg-surface-container-lowest transition-colors group">
<td class="py-md px-lg font-mono-data text-mono-data text-on-surface whitespace-nowrap">
<?= $operation['id'] ?>
</td>
<td class="py-md px-lg">
<span class="bg-primary-container/10 text-primary font-label-sm text-label-sm px-sm py-xs rounded-full border border-primary/20">
<?= $operation['codes'] ?>
</span>
</td>
<td class="py-md px-lg font-label-md text-label-md text-on-surface whitespace-nowrap">
<?= $operation['libelle'] ?>
</td>
<td class="py-md px-lg font-body-sm text-body-sm text-on-surface-variant">
<?= $operation['descriptions'] ?>
</td>
<td class="py-md px-lg text-right whitespace-nowrap">
<button class="view-fees-btn text-on-surface-variant hover:text-primary transition-colors p-xs rounded-full" data-id="<?= $operation['id'] ?>">
<span class="material-symbols-outlined text-[20px]" data-icon="payments">payments</span>
</button>
<button class="edit-btn text-on-surface-variant hover:text-primary transition-colors p-xs rounded-full" data-id="<?= $operation['id'] ?>">
<span class="material-symbols-outlined text-[20px]" data-icon="edit">edit</span>
</button>
<button class="delete-btn text-on-surface-variant hover:text-error transition-colors p-xs rounded-full" data-id="<?= $operation['id'] ?>">
<span class="material-symbols-outlined text-[20px]" data-icon="delete">delete</span>
</button>
</td>
</tr>
                                    <?php endforeach; ?>
</tbody>
</table>
</div>
<!-- Table Footer / Pagination -->
<div class="border-t border-outline-variant/30 py-sm px-lg flex justify-between items-center bg-surface-container-lowest">
<span class="font-body-sm text-body-sm text-on-surface-variant">
                    Affichage de <?= count($operations) ?> éléments
                </span>
</div>
</div>
</main>

<!-- Add Operation Modal -->
<div id="addOperationModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
<div class="layer-2 rounded-xl max-w-md w-full mx-4 overflow-hidden">
<div class="bg-surface-container px-lg py-md border-b border-outline-variant/30 flex justify-between items-center">
<h3 class="font-headline-md text-headline-md text-on-surface">Ajouter un Type d'Opération</h3>
<button id="closeAddModal" class="text-on-surface-variant hover:text-on-surface transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div class="p-lg">
<form id="addOperationForm">
<div class="mb-md">
<label for="opCode" class="block font-label-md text-label-md text-on-surface mb-sm">Code</label>
<input type="text" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="opCode" placeholder="Ex: DEP" required>
</div>
<div class="mb-md">
<label for="opLibelle" class="block font-label-md text-label-md text-on-surface mb-sm">Libellé</label>
<input type="text" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="opLibelle" placeholder="Ex: Dépôt" required>
</div>
<div class="mb-md">
<label for="opDesc" class="block font-label-md text-label-md text-on-surface mb-sm">Description</label>
<textarea class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="opDesc" rows="2" required></textarea>
</div>
</form>
</div>
<div class="px-lg py-md bg-surface-container-low border-t border-outline-variant/30 flex justify-end gap-sm">
<button id="cancelAdd" class="px-lg py-md text-on-surface-variant hover:text-on-surface transition-colors">Annuler</button>
<button id="submitAdd" class="px-lg py-md bg-primary-container text-on-primary rounded-lg hover:shadow-lg transition-all">Ajouter</button>
</div>
</div>
</div>

<!-- Fees Modal -->
<div id="feesModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
<div class="layer-2 rounded-xl max-w-3xl w-full mx-4 overflow-hidden">
<div class="bg-surface-container px-lg py-md border-b border-outline-variant/30 flex justify-between items-center">
<h3 class="font-headline-md text-headline-md text-on-surface">Grille des Frais</h3>
<button id="closeFeesModal" class="text-on-surface-variant hover:text-on-surface transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div class="p-lg">
<div class="flex justify-between items-center mb-md">
<p class="font-body-sm text-body-sm text-on-surface-variant">Gérez les barèmes de frais par tranche de montant</p>
<button id="addFeeBtn" class="bg-primary-container text-on-primary font-label-sm text-label-sm px-md py-sm rounded-lg flex items-center gap-sm hover:shadow-lg transition-all">
<span class="material-symbols-outlined text-[18px]">add</span>
Ajouter une tranche
</button>
</div>
<div id="feesContent" class="overflow-x-auto"></div>
</div>
<div class="px-lg py-md bg-surface-container-low border-t border-outline-variant/30 flex justify-end">
<button id="closeFeesBtn" class="px-lg py-md text-on-surface-variant hover:text-on-surface transition-colors">Fermer</button>
</div>
</div>
</div>

<!-- Edit Operation Modal -->
<div id="editOperationModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
<div class="layer-2 rounded-xl max-w-md w-full mx-4 overflow-hidden">
<div class="bg-surface-container px-lg py-md border-b border-outline-variant/30 flex justify-between items-center">
<h3 class="font-headline-md text-headline-md text-on-surface">Modifier le Type d'Opération</h3>
<button id="closeEditModal" class="text-on-surface-variant hover:text-on-surface transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div class="p-lg">
<form id="editOperationForm">
<input type="hidden" id="editOpId">
<div class="mb-md">
<label for="editOpCode" class="block font-label-md text-label-md text-on-surface mb-sm">Code</label>
<input type="text" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="editOpCode" required>
</div>
<div class="mb-md">
<label for="editOpLibelle" class="block font-label-md text-label-md text-on-surface mb-sm">Libellé</label>
<input type="text" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="editOpLibelle" required>
</div>
<div class="mb-md">
<label for="editOpDesc" class="block font-label-md text-label-md text-on-surface mb-sm">Description</label>
<textarea class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="editOpDesc" rows="2" required></textarea>
</div>
</form>
</div>
<div class="px-lg py-md bg-surface-container-low border-t border-outline-variant/30 flex justify-end gap-sm">
<button id="cancelEdit" class="px-lg py-md text-on-surface-variant hover:text-on-surface transition-colors">Annuler</button>
<button id="submitEdit" class="px-lg py-md bg-primary-container text-on-primary rounded-lg hover:shadow-lg transition-all">Modifier</button>
</div>
</div>
</div>

<!-- Add/Edit Fee Modal -->
<div id="feeModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
<div class="layer-2 rounded-xl max-w-md w-full mx-4 overflow-hidden">
<div class="bg-surface-container px-lg py-md border-b border-outline-variant/30 flex justify-between items-center">
<h3 class="font-headline-md text-headline-md text-on-surface" id="feeModalTitle">Ajouter une Tranche</h3>
<button id="closeFeeModal" class="text-on-surface-variant hover:text-on-surface transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div class="p-lg">
<form id="feeForm">
<input type="hidden" id="feeId">
<input type="hidden" id="feeOperationId">
<div class="mb-md">
<label for="feeMin" class="block font-label-md text-label-md text-on-surface mb-sm">Montant Min (Ar)</label>
<input type="number" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="feeMin" required>
</div>
<div class="mb-md">
<label for="feeMax" class="block font-label-md text-label-md text-on-surface mb-sm">Montant Max (Ar)</label>
<input type="number" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="feeMax" required>
</div>
<div class="mb-md">
<label for="feeAmount" class="block font-label-md text-label-md text-on-surface mb-sm">Frais (Ar)</label>
<input type="number" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="feeAmount" required>
</div>
<div class="mb-md">
<label for="feeDesc" class="block font-label-md text-label-md text-on-surface mb-sm">Description</label>
<textarea class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="feeDesc" rows="2"></textarea>
</div>
</form>
</div>
<div class="px-lg py-md bg-surface-container-low border-t border-outline-variant/30 flex justify-end gap-sm">
<button id="cancelFee" class="px-lg py-md text-on-surface-variant hover:text-on-surface transition-colors">Annuler</button>
<button id="submitFee" class="px-lg py-md bg-primary-container text-on-primary rounded-lg hover:shadow-lg transition-all">Enregistrer</button>
</div>
</div>
</div>

<script>
// Définir les URLs pour le JS
window.API_URLS = {
    create: '<?= base_url('/operator/operations/create') ?>',
    update: '<?= base_url('/operator/operations/update') ?>',
    delete: '<?= base_url('/operator/operations/delete') ?>',
    fees: '<?= base_url('/operator/operations/fees/') ?>',
    createFee: '<?= base_url('/operator/operations/createFee') ?>',
    updateFee: '<?= base_url('/operator/operations/updateFee') ?>',
    deleteFee: '<?= base_url('/operator/operations/deleteFee') ?>'
};
</script>
<script src="<?= base_url('js/operations.js') ?>"></script>
</body>
</html>
