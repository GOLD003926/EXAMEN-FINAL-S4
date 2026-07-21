<?php $currentPage = 'historique'; ?>
<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Historique des Transactions - Mobile Money</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=block" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=JetBrains+Mono:wght@500&amp;family=Lexend:wght@500;600;700&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="<?= base_url('tailwind/common.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('css/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/history.css') ?>">
</head>
<body class="bg-background text-on-background min-h-screen pb-[80px] md:pb-0 pt-[64px] md:pt-[80px]">
<?php include 'navbar.php'; ?>
<!-- Main Content -->
<main class="max-w-[1280px] mx-auto px-container-margin py-lg flex flex-col gap-lg">
<!-- Page Header -->
<section class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-md">
<div>
<h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Historique des Transactions</h1>
<p class="font-body-md text-body-md text-on-surface-variant mt-xs">Consultez toutes vos transactions précédentes.</p>
</div>
<button id="refreshBtn" class="px-lg py-md bg-surface-container text-on-surface rounded-lg hover:bg-surface-container-high transition-all font-label-md text-label-sm flex items-center gap-sm border border-outline-variant/30">
<span class="material-symbols-outlined text-[18px]">refresh</span>
                Actualiser
            </button>
</section>
<!-- Transactions Table -->
<section class="layer-1 rounded-xl shadow-[0px_4px_20px_rgba(0,168,150,0.05)] border border-outline-variant/30 flex flex-col overflow-hidden">
<div class="overflow-x-auto w-full">
<table class="w-full text-left border-collapse min-w-[800px]">
<thead class="bg-surface-container-lowest border-b border-outline-variant/30">
<tr>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">Date</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">Type</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">Numéro Source</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">Numéro Destinataire</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold text-right">Montant (Ar)</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold text-right">Gain (Ar)</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold text-center">Commission (Ar)</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold text-center">Détails</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/20" id="transactionsTable">
                    <?php if(empty($transactions)): ?>
<tr>
<td colspan="8" class="py-lg text-center">
<div class="flex flex-col items-center gap-sm text-on-surface-variant">
<span class="material-symbols-outlined text-[32px]">inbox</span>
<p class="font-body-md">Aucune transaction trouvée.</p>
</div>
</td>
</tr>
                    <?php else: ?>
                        <?php foreach($transactions as $transaction): ?>
                        <?php 
                        $badgeClass = 'bg-surface-container text-on-surface-variant border-outline-variant/30';
                        $icon = 'sync_alt';
                        
                        if(isset($transaction['type']) && $transaction['type'] == 'multiple') {
                            $badgeClass = 'bg-[#0d6efd]/10 text-[#0d6efd] border-[#0d6efd]/30';
                            $icon = 'groups';
                        } elseif(isset($transaction['operation_codes'])) {
                            if($transaction['operation_codes'] == 'DEP') {
                                $badgeClass = 'bg-primary-container/10 text-primary border-primary/20';
                                $icon = 'add_circle';
                            } elseif($transaction['operation_codes'] == 'RET') {
                                $badgeClass = 'bg-error-container/30 text-error border-error/20';
                                $icon = 'remove_circle';
                            } elseif($transaction['operation_codes'] == 'TRF') {
                                $badgeClass = 'bg-warning-container/20 text-warning border-warning/30';
                                $icon = 'send';
                            }
                        }
                        ?>
                        <?php if(isset($transaction['type']) && $transaction['type'] == 'multiple'): ?>
<!-- Envoi multiple groupé -->
<tr class="bg-surface-container-lowest/50">
<td class="py-md px-lg font-body-sm text-body-sm text-on-surface-variant"><?= $transaction['date'] ?></td>
<td class="py-md px-lg">
<span class="inline-flex items-center px-2.5 py-1 rounded-full <?= $badgeClass ?> font-label-sm text-label-sm border">
<span class="material-symbols-outlined text-[16px] mr-1"><?= $icon ?></span>
<?= $transaction['operation_libelle'] ?> (Multiple)
</span>
</td>
<td colspan="3">
<strong class="font-body-md text-body-md text-on-surface"><?= count($transaction['transactions']) ?> destinataires</strong>
<br>
<span class="font-body-sm text-body-sm text-on-surface-variant">Total: <?= number_format($transaction['montant_total'], 0, ',', ' ') ?> Ar</span>
</td>
<td class="py-md px-lg text-right font-mono-data text-mono-data"><?= number_format($transaction['frais_total'], 0, ',', ' ') ?></td>
<td class="py-md px-lg text-center">-</td>
<td class="py-md px-lg text-center">
<button class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors" onclick="toggleBatch('<?= $transaction['batch_id'] ?>')">
<span class="material-symbols-outlined text-[20px]">expand_more</span>
</button>
</td>
</tr>
<!-- Transactions du batch (cachées par défaut) -->
<tr id="batch-<?= $transaction['batch_id'] ?>" class="hidden">
<td colspan="8">
<div class="bg-surface-container-low p-md rounded-lg">
<table class="w-full text-left">
<thead>
<tr>
<th class="py-sm px-md font-label-sm text-label-sm text-on-surface-variant">Destinataire</th>
<th class="py-sm px-md font-label-sm text-label-sm text-on-surface-variant text-right">Montant</th>
<th class="py-sm px-md font-label-sm text-label-sm text-on-surface-variant text-right">Frais</th>
</tr>
</thead>
<tbody>
                            <?php foreach($transaction['transactions'] as $subTrans): ?>
<tr class="border-b border-outline-variant/20 last:border-0">
<td class="py-sm px-md font-mono-data text-mono-data"><?= $subTrans['numero_destinataire'] ?></td>
<td class="py-sm px-md text-right font-mono-data text-mono-data"><?= number_format($subTrans['somme'], 0, ',', ' ') ?></td>
<td class="py-sm px-md text-right font-mono-data text-mono-data"><?= number_format($subTrans['gain'], 0, ',', ' ') ?></td>
</tr>
                            <?php endforeach; ?>
</tbody>
</table>
</div>
</td>
</tr>
                        <?php else: ?>
<!-- Transaction simple -->
<tr class="hover:bg-surface-container-lowest/60 transition-colors">
<td class="py-md px-lg font-body-sm text-body-sm text-on-surface-variant"><?= $transaction['created_at'] ?></td>
<td class="py-md px-lg">
<span class="inline-flex items-center px-2.5 py-1 rounded-full <?= $badgeClass ?> font-label-sm text-label-sm border">
<span class="material-symbols-outlined text-[16px] mr-1"><?= $icon ?></span>
<?= $transaction['operation_libelle'] ?>
</span>
                            <?php if(isset($transaction['inclure_frais_retrait']) && $transaction['inclure_frais_retrait'] == 1): ?>
<span class="inline-flex items-center px-2 py-0.5 rounded-full bg-[#0d6efd]/10 text-[#0d6efd] font-label-sm text-label-sm border border-[#0d6efd]/30 ml-1">
+ Frais retrait
</span>
                            <?php endif; ?>
</td>
<td class="py-md px-lg font-mono-data text-mono-data"><?= $transaction['numero_source'] ?></td>
<td class="py-md px-lg font-mono-data text-mono-data"><?= $transaction['numero_destinataire'] ?? '-' ?></td>
<td class="py-md px-lg text-right font-mono-data text-mono-data font-semibold"><?= number_format($transaction['somme'], 0, ',', ' ') ?></td>
<td class="py-md px-lg text-right font-mono-data text-mono-data"><?= $transaction['gain'] > 0 ? number_format($transaction['gain'], 0, ',', ' ') : '-' ?></td>
<td class="py-md px-lg text-center">
                            <?php if(isset($transaction['commission']) && $transaction['commission'] > 0): ?>
<span class="inline-block px-2 py-1 bg-warning-container/20 text-warning rounded text-xs font-bold font-label-sm border border-warning/30">
<?= number_format($transaction['commission'], 0, ',', ' ') ?>
</span>
                            <?php else: ?>
-
                            <?php endif; ?>
</td>
<td class="py-md px-lg text-center text-on-surface-variant">-</td>
</tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
</tbody>
</table>
</div>
</section>
</main>
<script>
window.API_URLS = {
    get: '<?= base_url('/client/historique/get') ?>'
};
</script>
<script src="<?= base_url('js/history.js') ?>"></script>
</body>
</html>
