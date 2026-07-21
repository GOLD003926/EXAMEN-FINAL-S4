<?php $currentPage = 'comptes'; ?>
<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Détail du Compte - Mobile Money</title>
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
<!-- Back Button -->
<section>
<a href="<?= base_url('/operator/comptes') ?>" class="inline-flex items-center gap-sm text-on-surface-variant hover:text-primary transition-colors font-label-md">
<span class="material-symbols-outlined">arrow_back</span>
                    Retour aux comptes
                </a>
</section>
<!-- Account Info Card -->
<section class="layer-1 rounded-xl shadow-[0px_4px_20px_rgba(0,168,150,0.05)] border border-outline-variant/30 overflow-hidden">
<div class="border-b border-outline-variant/30 px-lg py-md bg-surface-container-low flex items-center gap-sm">
<span class="material-symbols-outlined text-on-surface-variant text-[20px]">person</span>
<h2 class="font-headline-md text-lg text-on-surface">Informations du Compte</h2>
</div>
<div class="p-lg">
<div class="grid grid-cols-1 md:grid-cols-2 gap-lg">
<div class="space-y-md">
<div class="flex items-center gap-sm">
<span class="material-symbols-outlined text-on-surface-variant">account_balance_wallet</span>
<div>
<span class="font-label-sm text-label-sm text-on-surface-variant">Numéro</span>
<p class="font-mono-data text-mono-data text-primary font-semibold"><?= $compte['numero'] ?></p>
</div>
</div>
<div class="flex items-center gap-sm">
<span class="material-symbols-outlined text-on-surface-variant">badge</span>
<div>
<span class="font-label-sm text-label-sm text-on-surface-variant">Nom</span>
<p class="font-body-md text-body-md text-on-surface"><?= $compte['nom'] ?></p>
</div>
</div>
<div class="flex items-center gap-sm">
<span class="material-symbols-outlined text-on-surface-variant">badge</span>
<div>
<span class="font-label-sm text-label-sm text-on-surface-variant">Prénom</span>
<p class="font-body-md text-body-md text-on-surface"><?= $compte['prenom'] ?></p>
</div>
</div>
</div>
<div class="space-y-md">
<div class="flex items-center gap-sm">
<span class="material-symbols-outlined text-on-surface-variant">payments</span>
<div>
<span class="font-label-sm text-label-sm text-on-surface-variant">Solde</span>
<p class="font-mono-data text-mono-data text-primary font-semibold"><?= number_format($compte['solde'], 0, ',', ' ') ?> Ar</p>
</div>
</div>
<div class="flex items-center gap-sm">
<span class="material-symbols-outlined text-on-surface-variant">verified</span>
<div>
<span class="font-label-sm text-label-sm text-on-surface-variant">État</span>
                                            <?php 
                                            $badgeClass = 'bg-primary-container/10 text-primary border-primary/20';
                                            if($compte['etat_libelle'] == 'Bloqué') {
                                                $badgeClass = 'bg-error-container/30 text-error border-error/20';
                                            } elseif($compte['etat_libelle'] == 'Suspendu') {
                                                $badgeClass = 'bg-secondary-container/30 text-secondary border-secondary/20';
                                            }
                                            ?>
<span class="inline-flex items-center px-2.5 py-1 rounded-full <?= $badgeClass ?> font-label-sm text-label-sm border">
<?= $compte['etat_libelle'] ?>
</span>
</div>
</div>
<div class="flex items-center gap-sm">
<span class="material-symbols-outlined text-on-surface-variant">schedule</span>
<div>
<span class="font-label-sm text-label-sm text-on-surface-variant">Dernière mise à jour</span>
<p class="font-body-sm text-body-sm text-on-surface-variant"><?= $compte['update_at'] ?></p>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- Transactions Table -->
<section class="layer-1 rounded-xl shadow-[0px_4px_20px_rgba(0,168,150,0.05)] border border-outline-variant/30 overflow-hidden flex-grow flex flex-col">
<div class="border-b border-outline-variant/30 px-lg py-md bg-surface-container-low flex items-center gap-sm">
<span class="material-symbols-outlined text-on-surface-variant text-[20px]">history</span>
<h2 class="font-headline-md text-lg text-on-surface">Historique des Transactions</h2>
</div>
<div class="p-lg">
                    <?php if(empty($transactions)): ?>
<div class="bg-surface-container-highest border border-outline-variant/50 rounded-lg p-md flex items-center gap-sm text-on-surface-variant">
<span class="material-symbols-outlined text-primary">info</span>
<p class="font-body-md">Aucune transaction pour ce compte.</p>
</div>
                    <?php else: ?>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead class="bg-surface-container-lowest border-b border-outline-variant/30">
<tr>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">ID</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">Type</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">Numéro Source</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">Numéro Destinataire</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold text-right">Montant (Ar)</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold text-right">Gain (Ar)</th>
<th class="py-md px-lg font-label-md text-label-md text-on-surface-variant font-semibold">Date</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/20">
                                <?php foreach($transactions as $transaction): ?>
                                <?php 
                                $typeLabels = [1 => 'Dépôt', 2 => 'Retrait', 3 => 'Transfert'];
                                $typeColors = [1 => 'bg-primary-container/10 text-primary border-primary/20', 2 => 'bg-error-container/30 text-error border-error/20', 3 => 'bg-warning-container/20 text-warning border-warning/30'];
                                ?>
<tr class="hover:bg-surface-container-lowest/60 transition-colors">
<td class="py-md px-lg font-mono-data text-mono-data"><?= $transaction['id'] ?></td>
<td class="py-md px-lg">
<span class="inline-block px-2 py-1 rounded <?= $typeColors[$transaction['id_type_operation']] ?> text-xs font-medium font-label-sm border">
<?= $typeLabels[$transaction['id_type_operation']] ?>
</span>
</td>
<td class="py-md px-lg font-mono-data text-mono-data"><?= $transaction['numero_source'] ?></td>
<td class="py-md px-lg font-mono-data text-mono-data"><?= $transaction['numero_destinataire'] ?? '-' ?></td>
<td class="py-md px-lg text-right font-mono-data text-mono-data"><?= number_format($transaction['somme'], 0, ',', ' ') ?></td>
<td class="py-md px-lg text-right font-mono-data text-mono-data"><?= number_format($transaction['gain'], 0, ',', ' ') ?></td>
<td class="py-md px-lg text-on-surface-variant font-body-sm"><?= $transaction['created_at'] ?></td>
</tr>
                                <?php endforeach; ?>
</tbody>
</table>
</div>
                    <?php endif; ?>
</div>
</section>
</main>
</body>
</html>
