<?php $currentPage = 'operateurs'; ?>
<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Gestion des Opérateurs - Mobile Money</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=block" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=JetBrains+Mono:wght@500&amp;family=Lexend:wght@500;600;700&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="<?= base_url('tailwind/common.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('css/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/operateurs.css') ?>">
</head>
<body class="bg-background text-on-background min-h-screen pb-[80px] md:pb-0 pt-[64px] md:pt-[80px]">
<?php include 'navbar.php'; ?>
<!-- Main Content -->
<main class="max-w-[1280px] mx-auto px-container-margin py-lg flex flex-col gap-lg">
<!-- Page Header -->
<section class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-md">
<div>
<h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Gestion des Opérateurs</h1>
<p class="font-body-md text-body-md text-on-surface-variant mt-xs">Configuration et gestion des opérateurs de téléphonie.</p>
</div>
<button id="addOperateurBtn" class="px-lg py-md bg-primary-container text-on-primary rounded-lg hover:shadow-lg transition-all font-label-md text-label-sm flex items-center gap-sm">
<span class="material-symbols-outlined text-[18px]">add</span>
                Ajouter un Opérateur
            </button>
</section>
<!-- Data Table -->
<section class="layer-1 rounded-xl shadow-[0px_4px_20px_rgba(0,168,150,0.05)] border border-outline-variant/30 flex flex-col overflow-hidden">
<div class="overflow-x-auto w-full">
<table class="w-full text-left border-collapse min-w-[800px]">
<thead class="bg-surface-container-lowest border-b border-outline-variant/30">
<tr>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold w-24">ID</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">Nom</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">Code</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">Type</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold text-right">Taux Commission</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">Description</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold text-right w-20">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/20">
                    <?php foreach($operateurs as $operateur): ?>
<tr class="hover:bg-surface-container-lowest/60 transition-colors group">
<td class="py-4 px-lg font-mono-data text-mono-data text-on-surface-variant"><?= $operateur['id'] ?></td>
<td class="py-4 px-lg font-body-md text-body-md text-on-surface font-semibold"><?= $operateur['nom'] ?></td>
<td class="py-4 px-lg">
<span class="inline-flex items-center px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant font-label-sm text-label-sm border border-outline-variant/30">
<?= $operateur['code'] ?>
</span>
</td>
<td class="py-4 px-lg">
                            <?php if($operateur['est_interne'] == 1): ?>
<span class="inline-flex items-center px-2.5 py-1 rounded-full bg-primary-container/10 text-primary font-label-sm text-label-sm border border-primary/20">
Interne (Nous)
</span>
                            <?php else: ?>
<span class="inline-flex items-center px-2.5 py-1 rounded-full bg-warning-container/20 text-warning font-label-sm text-label-sm border border-warning/30">
Externe
</span>
                            <?php endif; ?>
</td>
<td class="py-4 px-lg text-right font-mono-data text-mono-data"><?= number_format($operateur['taux_commission'], 2, ',', ' ') ?>%</td>
<td class="py-4 px-lg text-on-surface-variant font-body-sm"><?= $operateur['descriptions'] ?? '-' ?></td>
<td class="py-4 px-lg text-right">
<div class="flex items-center justify-end gap-sm">
<button class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors" onclick="editOperateur(<?= htmlspecialchars(json_encode($operateur)) ?>)">
<span class="material-symbols-outlined text-[20px]">edit</span>
</button>
                            <?php if($operateur['est_interne'] != 1): ?>
<button class="p-2 text-error hover:bg-error/10 rounded-lg transition-colors" onclick="deleteOperateur(<?= $operateur['id'] ?>)">
<span class="material-symbols-outlined text-[20px]">delete</span>
</button>
                            <?php endif; ?>
</div>
</td>
</tr>
                    <?php endforeach; ?>
</tbody>
</table>
</div>
</section>
</main>
<!-- Modal Ajout Opérateur -->
<div id="addOperateurModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
<div class="layer-2 rounded-xl max-w-lg w-full mx-4 overflow-hidden">
<div class="bg-surface-container px-lg py-md border-b border-outline-variant/30 flex justify-between items-center">
<h3 class="font-headline-md text-headline-md text-on-surface">Ajouter un Opérateur</h3>
<button id="closeAddModal" class="text-on-surface-variant hover:text-on-surface transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div class="p-lg">
<form id="addOperateurForm">
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Nom de l'opérateur</label>
<input type="text" name="nom" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" required placeholder="Ex: Orange Money">
</div>
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Code</label>
<input type="text" name="code" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" required placeholder="Ex: TEL, ORA">
</div>
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Type</label>
<select name="est_interne" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" required>
<option value="0">Externe</option>
<option value="1">Interne (Nous)</option>
</select>
</div>
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Taux de commission (%)</label>
<input type="number" step="0.01" name="taux_commission" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" required placeholder="Ex: 5.5">
</div>
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Description</label>
<textarea name="descriptions" rows="3" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none resize-none"></textarea>
</div>
</form>
</div>
<div class="px-lg py-md bg-surface-container-low border-t border-outline-variant/30 flex justify-end gap-sm">
<button id="cancelAdd" class="px-lg py-md text-on-surface-variant hover:text-on-surface transition-colors">Annuler</button>
<button id="submitAdd" class="px-lg py-md bg-primary-container text-on-primary rounded-lg hover:shadow-lg transition-all">Ajouter</button>
</div>
</div>
</div>
<!-- Modal Modification Opérateur -->
<div id="editOperateurModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
<div class="layer-2 rounded-xl max-w-lg w-full mx-4 overflow-hidden">
<div class="bg-surface-container px-lg py-md border-b border-outline-variant/30 flex justify-between items-center">
<h3 class="font-headline-md text-headline-md text-on-surface">Modifier l'Opérateur</h3>
<button id="closeEditModal" class="text-on-surface-variant hover:text-on-surface transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div class="p-lg">
<form id="editOperateurForm">
<input type="hidden" name="id" id="editId">
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Nom de l'opérateur</label>
<input type="text" name="nom" id="editNom" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" required>
</div>
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Code</label>
<input type="text" name="code" id="editCode" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" required>
</div>
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Type</label>
<select name="est_interne" id="editEstInterne" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" required>
<option value="0">Externe</option>
<option value="1">Interne (Nous)</option>
</select>
</div>
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Taux de commission (%)</label>
<input type="number" step="0.01" name="taux_commission" id="editTauxCommission" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" required>
</div>
<div class="mb-md">
<label class="block font-label-md text-label-md text-on-surface mb-sm">Description</label>
<textarea name="descriptions" id="editDescriptions" rows="3" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none resize-none"></textarea>
</div>
</form>
</div>
<div class="px-lg py-md bg-surface-container-low border-t border-outline-variant/30 flex justify-end gap-sm">
<button id="cancelEdit" class="px-lg py-md text-on-surface-variant hover:text-on-surface transition-colors">Annuler</button>
<button id="submitEdit" class="px-lg py-md bg-primary-container text-on-primary rounded-lg hover:shadow-lg transition-all">Modifier</button>
</div>
</div>
</div>
<script>
// Définir les URLs pour le JS
window.API_URLS = {
    create: '<?= base_url('/operator/operateurs/create') ?>',
    update: '<?= base_url('/operator/operateurs/update') ?>',
    delete: '<?= base_url('/operator/operateurs/delete') ?>'
};
</script>
<script src="<?= base_url('js/operateurs.js') ?>"></script>
</body>
</html>
