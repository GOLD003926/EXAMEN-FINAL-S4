<?php $currentPage = 'gains'; ?>
<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Gains - Mobile Money</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=block" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=JetBrains+Mono:wght@500&amp;family=Lexend:wght@500;600;700&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="<?= base_url('tailwind/common.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('css/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/gains.css') ?>">
</head>
<body class="bg-background text-on-background min-h-screen pb-[80px] md:pb-0 pt-[64px] md:pt-[80px]">
<?php include 'navbar.php'; ?>
<!-- Main Content -->
<main class="max-w-[1280px] mx-auto px-container-margin py-lg flex flex-col gap-lg">
<!-- Page Header Section -->
<section class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-md">
<div>
<h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Gains</h1>
<p class="font-body-md text-body-md text-on-surface-variant mt-xs">Suivi et analyse des revenus générés par les transactions.</p>
</div>
</section>
<!-- Summary Cards Grid -->
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-md">
<!-- Card 1: Total des Gains -->
<div class="layer-1 bg-primary-container/10 text-primary rounded-xl p-md shadow-[0px_4px_20px_rgba(0,168,150,0.08)] flex items-center gap-md border border-primary/20">
<div class="bg-primary/20 p-2 rounded-full flex-shrink-0">
<span class="material-symbols-outlined text-[32px]">payments</span>
</div>
<div class="flex flex-col">
<span class="font-label-sm opacity-90 uppercase tracking-wider">Total des Gains</span>
<span class="font-headline-md font-bold"><?= number_format($totalGain, 0, ',', ' ') ?> Ar</span>
</div>
</div>
<!-- Card 2: Gains Retraits -->
<div class="layer-1 bg-[#00b4d8]/10 text-[#00b4d8] rounded-xl p-md shadow-[0px_4px_20px_rgba(0,0,0,0.05)] flex items-center gap-md border border-[#00b4d8]/30">
<div class="bg-[#00b4d8]/20 p-2 rounded-full flex-shrink-0">
<span class="material-symbols-outlined text-[32px]">arrow_downward</span>
</div>
<div class="flex flex-col">
<span class="font-label-sm opacity-90 uppercase tracking-wider">Gains Retraits</span>
<span class="font-headline-md font-bold"><?= number_format($gainRetrait, 0, ',', ' ') ?> Ar</span>
</div>
</div>
<!-- Card 3: Transferts Internes -->
<div class="layer-1 bg-[#0077b6]/10 text-[#0077b6] rounded-xl p-md shadow-[0px_4px_20px_rgba(0,0,0,0.05)] flex items-center gap-md border border-[#0077b6]/30">
<div class="bg-[#0077b6]/20 p-2 rounded-full flex-shrink-0">
<span class="material-symbols-outlined text-[32px]">arrow_forward</span>
</div>
<div class="flex flex-col">
<span class="font-label-sm opacity-90 uppercase tracking-wider">Transferts Internes</span>
<span class="font-headline-md font-bold"><?= number_format($gainTransfertInterne, 0, ',', ' ') ?> Ar</span>
</div>
</div>
<!-- Card 4: Transferts Externes -->
<div class="layer-1 bg-[#ffb703]/10 text-[#ffb703] rounded-xl p-md shadow-[0px_4px_20px_rgba(0,0,0,0.05)] flex items-center gap-md border border-[#ffb703]/30">
<div class="bg-[#ffb703]/20 p-2 rounded-full flex-shrink-0">
<span class="material-symbols-outlined text-[32px]">trending_flat</span>
</div>
<div class="flex flex-col">
<span class="font-label-sm opacity-90 uppercase tracking-wider">Transferts Externes</span>
<span class="font-headline-md font-bold"><?= number_format($gainTransfertExterne, 0, ',', ' ') ?> Ar</span>
</div>
</div>
</section>
<!-- Situation des Montants à Envoyer par Opérateur -->
<section class="layer-1 rounded-xl shadow-[0px_4px_20px_rgba(0,168,150,0.05)] border border-outline-variant/30 overflow-hidden">
<div class="border-b border-outline-variant/30 px-lg py-md bg-surface-container-low flex items-center gap-sm">
<span class="material-symbols-outlined text-on-surface-variant text-[20px]">send</span>
<h2 class="font-headline-md text-lg text-on-surface">Situation des Montants à Envoyer par Opérateur</h2>
</div>
<div class="p-lg">
                            <?php if(isset($montantsParOperateur) && !empty($montantsParOperateur)): ?>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead class="bg-surface-container-lowest border-b border-outline-variant/30">
<tr>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">Opérateur</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold text-right">Montant à Envoyer (Ar)</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold text-right">Commission (Ar)</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold text-right">Total (Ar)</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/20">
                                        <?php foreach($montantsParOperateur as $montant): ?>
                                        <?php 
                                        $operateur = isset($operateursMap[$montant['id_operateur_destinataire']]) 
                                            ? $operateursMap[$montant['id_operateur_destinataire']] 
                                            : ['nom' => 'Inconnu', 'est_interne' => 0];
                                        ?>
<tr class="hover:bg-surface-container-lowest/60 transition-colors">
<td class="py-md px-lg">
                                            <?php if($operateur['est_interne'] == 1): ?>
<span class="inline-flex items-center px-2 py-1 rounded-full bg-primary-container/10 text-primary font-label-sm text-label-sm border border-primary/20">
<?= $operateur['nom'] ?> (Interne)
</span>
                                            <?php else: ?>
<span class="inline-flex items-center px-2 py-1 rounded-full bg-warning-container/20 text-warning font-label-sm text-label-sm border border-warning/30">
<?= $operateur['nom'] ?> (Externe)
</span>
                                            <?php endif; ?>
</td>
<td class="py-md px-lg text-right font-mono-data text-mono-data"><?= number_format($montant['montant_total'], 0, ',', ' ') ?></td>
<td class="py-md px-lg text-right font-mono-data text-mono-data"><?= number_format($montant['commission_total'], 0, ',', ' ') ?></td>
<td class="py-md px-lg text-right font-mono-data text-mono-data font-semibold"><?= number_format($montant['montant_total'] + $montant['commission_total'], 0, ',', ' ') ?></td>
</tr>
                                        <?php endforeach; ?>
</tbody>
</table>
</div>
                            <?php else: ?>
<div class="bg-surface-container-highest border border-outline-variant/50 rounded-lg p-md flex items-center gap-sm text-on-surface-variant">
<span class="material-symbols-outlined text-primary">info</span>
<p class="font-body-md">Aucun montant à envoyer pour le moment</p>
</div>
                            <?php endif; ?>
</div>
</section>
<!-- Dernières Transactions avec Gains -->
<section class="layer-1 rounded-xl shadow-[0px_4px_20px_rgba(0,168,150,0.05)] border border-outline-variant/30 overflow-hidden flex-grow flex flex-col">
<div class="border-b border-outline-variant/30 px-lg py-md bg-surface-container-low flex items-center gap-sm">
<span class="material-symbols-outlined text-on-surface-variant text-[20px]">history</span>
<h2 class="font-headline-md text-lg text-on-surface">Dernières Transactions avec Gains</h2>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead class="bg-surface-container-lowest border-b border-outline-variant/30">
<tr>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">ID</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">Type</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">Numéro Source</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">Numéro Destinataire</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold text-right">Montant (Ar)</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold text-center">Gain (Ar)</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold text-center">Commission (Ar)</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">Date</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/20">
                                    <?php foreach($transactions as $transaction): ?>
                                    <?php 
                                    $opName = '';
                                    foreach($operations as $op) {
                                        if($transaction['id_type_operation'] == $op['id']) {
                                            $opName = $op['libelle'];
                                            break;
                                        }
                                    }
                                    ?>
<tr class="hover:bg-surface-container-lowest/60 transition-colors">
<td class="py-md px-lg font-mono-data text-mono-data"><?= $transaction['id'] ?></td>
<td class="py-md px-lg">
<span class="inline-block px-2 py-1 bg-surface-container text-on-surface-variant rounded text-xs font-medium font-label-sm">
<?= $opName ?>
</span>
</td>
<td class="py-md px-lg font-mono-data text-mono-data"><?= $transaction['numero_source'] ?></td>
<td class="py-md px-lg font-mono-data text-mono-data"><?= $transaction['numero_destinataire'] ?? '-' ?></td>
<td class="py-md px-lg text-right font-mono-data text-mono-data"><?= number_format($transaction['somme'], 0, ',', ' ') ?></td>
<td class="py-md px-lg text-center">
<span class="inline-block px-2 py-1 bg-primary-container/10 text-primary rounded text-xs font-bold font-label-sm border border-primary/20">
<?= number_format($transaction['gain'], 0, ',', ' ') ?>
</span>
</td>
<td class="py-md px-lg text-center">
                                            <?php if(isset($transaction['commission'])): ?>
<span class="inline-block px-2 py-1 bg-[#00b4d8]/10 text-[#00b4d8] rounded text-xs font-bold font-label-sm border border-[#00b4d8]/30">
<?= number_format($transaction['commission'], 0, ',', ' ') ?>
</span>
                                            <?php else: ?>
-
                                            <?php endif; ?>
</td>
<td class="py-md px-lg text-on-surface-variant font-body-sm"><?= $transaction['created_at'] ?></td>
</tr>
                                    <?php endforeach; ?>
</tbody>
</table>
</div>
<div class="p-sm flex justify-center text-on-surface-variant text-sm">
<span>Affichage de <?= count($transactions) ?> entrées</span>
</div>
</section>
</main>
</body>
</html>
