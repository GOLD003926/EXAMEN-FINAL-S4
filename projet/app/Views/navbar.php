<?php 
$currentPage = $currentPage ?? 'accueil';
$navItems = [
    'accueil' => ['label' => 'Accueil', 'icon' => 'home', 'url' => '/'],
    'transfert' => ['label' => 'Transfert', 'icon' => 'send', 'url' => '/client/transfert'],
    'historique' => ['label' => 'Historique', 'icon' => 'history', 'url' => '/client/historique'],
    'epargne' => ['label' => 'Epargne', 'icon' => 'history', 'url' => '/epargne']
];
?>
<!-- Client Navbar -->
<header class="bg-surface-container-lowest shadow-[0px_4px_20px_rgba(0,0,0,0.05)] fixed top-0 left-0 right-0 z-50 w-full">
<div class="flex justify-between items-center w-full px-container-margin py-md max-w-7xl mx-auto">
<div class="flex items-center gap-sm cursor-pointer">
<span class="material-symbols-outlined text-primary-container" style="font-variation-settings: 'FILL' 1;">account_balance_wallet</span>
<h1 class="text-headline-md font-headline-md font-bold text-primary dark:text-primary-fixed">Mobile Money</h1>
</div>
<!-- Desktop Nav Links (Hidden on mobile) -->
<nav class="hidden md:flex items-center gap-lg">
                <?php foreach($navItems as $key => $item): ?>
                    <?php $isActive = $currentPage === $key; ?>
<a class="<?= $isActive ? 'text-primary font-bold border-b-2 border-primary' : 'text-on-surface-variant hover:bg-surface-container-low' ?> transition-colors duration-200 px-3 py-2 rounded-lg font-label-md" href="<?= base_url($item['url']) ?>">
<span class="material-symbols-outlined text-[18px]"><?= $item['icon'] ?></span>
<span class="hidden lg:inline ml-1"><?= $item['label'] ?></span>
</a>
                <?php endforeach; ?>
</nav>
<div class="flex items-center gap-sm">
<span class="hidden md:inline font-label-sm text-on-surface-variant"><?= session('numero') ?></span>
<a href="<?= base_url('/logout') ?>" class="flex items-center gap-xs text-on-surface-variant hover:bg-surface-container-low transition-colors duration-200 p-2 rounded-lg cursor-pointer active:opacity-80 transition-all">
<span class="material-symbols-outlined">logout</span>
<span class="hidden md:inline font-label-sm">Déconnexion</span>
</a>
</div>
</div>
</header>
