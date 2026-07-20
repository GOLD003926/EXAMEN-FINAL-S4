<?php $currentPage = 'prefixes'; ?>
<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Configuration des Préfixes - Mobile Money</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=block" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Lexend:wght@500;600&amp;family=JetBrains+Mono:wght@500&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="<?= base_url('tailwind/common.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('css/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/prefixes.css') ?>">
</head>
<body class="bg-background text-on-background min-h-screen pb-[80px] md:pb-0 pt-[64px] md:pt-[80px]">
<?php include 'navbar.php'; ?>
<!-- Main Content -->
<main class="max-w-[1280px] mx-auto px-container-margin py-lg">
<!-- Page Header -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-md mb-lg">
<div>
<h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-xs">
                    Configuration des Préfixes
                </h1>
<p class="font-body-md text-body-md text-on-surface-variant">
                    Gérez les préfixes opérateurs pour les transactions.
                </p>
</div>
<button id="addPrefixBtn" class="bg-primary-container text-on-primary font-label-md text-label-md px-lg py-sm rounded-full shadow-[0px_4px_20px_rgba(0,168,150,0.08)] hover:opacity-90 active:scale-95 transition-all flex items-center gap-xs">
<span class="material-symbols-outlined text-[18px]">add</span>
                Ajouter
            </button>
</div>
<!-- Data Table Card -->
<div class="layer-1 rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-outline-variant/30 overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low border-b border-outline-variant/30">
<th class="font-label-md text-label-md text-on-surface-variant py-md px-md whitespace-nowrap">ID</th>
<th class="font-label-md text-label-md text-on-surface-variant py-md px-md whitespace-nowrap">Code</th>
<th class="font-label-md text-label-md text-on-surface-variant py-md px-md whitespace-nowrap">Description</th>
<th class="font-label-md text-label-md text-on-surface-variant py-md px-md whitespace-nowrap">Opérateur Associé</th>
<th class="font-label-md text-label-md text-on-surface-variant py-md px-md whitespace-nowrap text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/20">
                                    <?php foreach($prefixes as $prefix): ?>
<tr class="hover:bg-surface-container-low/50 transition-colors group">
<td class="py-md px-md font-mono-data text-mono-data text-on-surface-variant"><?= $prefix['id'] ?></td>
<td class="py-md px-md">
<span class="bg-primary-container/10 text-primary font-label-sm text-label-sm px-sm py-xs rounded-full border border-primary/20">
<?= $prefix['codes'] ?>
</span>
</td>
<td class="py-md px-md font-body-md text-body-md text-on-surface"><?= $prefix['descriptions'] ?></td>
<td class="py-md px-md">
                                            <?php if(isset($prefix['operateur_nom'])): ?>
                                                <?php if($prefix['est_interne'] == 1): ?>
<span class="inline-flex items-center px-2 py-1 rounded-full text-label-sm font-label-sm bg-primary-container/10 text-primary-container">
<?= $prefix['operateur_nom'] ?> (Interne)
</span>
                                                <?php else: ?>
<span class="inline-flex items-center px-2 py-1 rounded-full text-label-sm font-label-sm bg-warning-container/20 text-warning border border-warning/30">
<?= $prefix['operateur_nom'] ?> (Externe)
</span>
                                                <?php endif; ?>
                                            <?php else: ?>
<span class="inline-flex items-center px-2 py-1 rounded-full text-label-sm font-label-sm bg-surface-container text-on-surface-variant">
Non assigné
</span>
                                            <?php endif; ?>
</td>
<td class="py-md px-md text-right">
<div class="flex justify-end gap-xs">
<button class="edit-btn text-on-surface-variant hover:text-primary-container p-xs rounded-full transition-colors" data-prefix="<?= htmlspecialchars(json_encode($prefix)) ?>">
<span class="material-symbols-outlined text-[20px]">edit</span>
</button>
<button class="delete-btn text-on-surface-variant hover:text-error p-xs rounded-full transition-colors" data-id="<?= $prefix['id'] ?>">
<span class="material-symbols-outlined text-[20px]">delete</span>
</button>
</div>
</td>
</tr>
                                    <?php endforeach; ?>
</tbody>
</table>
</div>
<!-- Pagination / Footer -->
<div class="px-md py-sm border-t border-outline-variant/30 bg-surface-container-lowest flex items-center justify-between">
<span class="font-body-sm text-body-sm text-on-surface-variant">Affichage <?= count($prefixes) ?> éléments</span>
</div>
</div>
</main>

<!-- Add Prefix Modal -->
<div id="addPrefixModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
<div class="layer-2 rounded-xl max-w-md w-full mx-4 overflow-hidden">
<div class="bg-surface-container px-lg py-md border-b border-outline-variant/30 flex justify-between items-center">
<h3 class="font-headline-md text-headline-md text-on-surface">Ajouter un Préfixe</h3>
<button id="closeAddModal" class="text-on-surface-variant hover:text-on-surface transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div class="p-lg">
<form id="addPrefixForm">
<div class="mb-md">
<label for="prefixCode" class="block font-label-md text-label-md text-on-surface mb-sm">Code du préfixe</label>
<input type="text" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="prefixCode" name="codes" placeholder="Ex: 034" required>
</div>
<div class="mb-md">
<label for="prefixDesc" class="block font-label-md text-label-md text-on-surface mb-sm">Description</label>
<input type="text" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="prefixDesc" name="descriptions" placeholder="Ex: Airtel" required>
</div>
<div class="mb-md">
<label for="prefixOperateur" class="block font-label-md text-label-md text-on-surface mb-sm">Opérateur Associé</label>
<select class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="prefixOperateur" name="id_operateur" required>
<option value="">Sélectionner un opérateur</option>
                                            <?php if(isset($operateurs)): ?>
                                                <?php foreach($operateurs as $operateur): ?>
<option value="<?= $operateur['id'] ?>">
<?= $operateur['nom'] ?> (<?= $operateur['est_interne'] == 1 ? 'Interne' : 'Externe' ?>)
</option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
</select>
</div>
</form>
</div>
<div class="px-lg py-md bg-surface-container-low border-t border-outline-variant/30 flex justify-end gap-sm">
<button id="cancelAdd" class="px-lg py-md text-on-surface-variant hover:text-on-surface transition-colors">Annuler</button>
<button id="submitAdd" class="px-lg py-md bg-primary-container text-on-primary rounded-lg hover:shadow-lg transition-all">Ajouter</button>
</div>
</div>
</div>

<!-- Edit Prefix Modal -->
<div id="editPrefixModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
<div class="layer-2 rounded-xl max-w-md w-full mx-4 overflow-hidden">
<div class="bg-surface-container px-lg py-md border-b border-outline-variant/30 flex justify-between items-center">
<h3 class="font-headline-md text-headline-md text-on-surface">Modifier le Préfixe</h3>
<button id="closeEditModal" class="text-on-surface-variant hover:text-on-surface transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div class="p-lg">
<form id="editPrefixForm">
<input type="hidden" id="editId" name="id">
<div class="mb-md">
<label for="editCode" class="block font-label-md text-label-md text-on-surface mb-sm">Code du préfixe</label>
<input type="text" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="editCode" name="codes" required>
</div>
<div class="mb-md">
<label for="editDesc" class="block font-label-md text-label-md text-on-surface mb-sm">Description</label>
<input type="text" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="editDesc" name="descriptions" required>
</div>
<div class="mb-md">
<label for="editOperateur" class="block font-label-md text-label-md text-on-surface mb-sm">Opérateur Associé</label>
<select class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="editOperateur" name="id_operateur" required>
<option value="">Sélectionner un opérateur</option>
                                            <?php if(isset($operateurs)): ?>
                                                <?php foreach($operateurs as $operateur): ?>
<option value="<?= $operateur['id'] ?>">
<?= $operateur['nom'] ?> (<?= $operateur['est_interne'] == 1 ? 'Interne' : 'Externe' ?>)
</option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
</select>
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
    create: '<?= base_url('/operator/prefixes/create') ?>',
    update: '<?= base_url('/operator/prefixes/update') ?>',
    delete: '<?= base_url('/operator/prefixes/delete') ?>'
};
</script>
<script src="<?= base_url('js/prefixes.js') ?>"></script>
</body>
</html>
