<?php $currentPage = 'prefixes'; ?>
<!DOCTYPE html>
<html class="light" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Configuration EPARGNE - Mobile Money</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=block" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=JetBrains+Mono:wght@500&amp;family=Lexend:wght@500;600;700&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="<?= base_url('tailwind/common.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('css/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/prefixes.css') ?>">
</head>

<body class="bg-background text-on-background min-h-screen pb-[80px] md:pb-0 pt-[64px] md:pt-[80px]">
    <?php include 'navbar.php'; ?>
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
        <p class="font-body-md text-body-md text-on-surface-variant mt-xs">Taux d'épargne actuelle 0.0%</p>

        <form action="/epargner" method="post">
            <p class="font-body-md text-body-md text-on-surface-variant mt-xs">Nouvelle taux epargne</p>

            <input type="number" name="taux">
            <button type="submit" class="">Mettre à jour</button>
        </form>
    </main>
</body>

</html>