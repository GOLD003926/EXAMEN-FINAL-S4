<!-- TopAppBar -->
<header class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-container-margin h-[64px] bg-surface/90 backdrop-blur-md shadow-[0px_4px_20px_rgba(0,168,150,0.05)] md:h-[80px]">
    <div class="flex items-center gap-4">
        <div class="font-display text-headline-md font-semibold text-primary">Mobile Money</div>
    </div>
    <!-- Desktop Nav -->
    <nav class="hidden md:flex gap-8">
        <a class="<?= $currentPage === 'dashboard' ? 'text-primary font-semibold' : 'text-on-surface-variant' ?> font-label-md flex items-center gap-2 relative <?= $currentPage === 'dashboard' ? 'after:content-[\'\'] after:absolute after:bottom-[-28px] after:left-0 after:w-full after:h-1 after:bg-primary after:rounded-t-full' : '' ?> hover:text-primary transition-colors" href="<?= base_url('/operator/dashboard') ?>">
            <span class="material-symbols-outlined <?= $currentPage === 'dashboard' ? 'icon-fill' : '' ?>">dashboard</span>
            Dashboard
        </a>

        <a class="<?= $currentPage === 'prefixes' ? 'text-primary font-semibold' : 'text-on-surface-variant' ?> font-label-md flex items-center gap-2 relative <?= $currentPage === 'prefixes' ? 'after:content-[\'\'] after:absolute after:bottom-[-28px] after:left-0 after:w-full after:h-1 after:bg-primary after:rounded-t-full' : '' ?> hover:text-primary transition-colors" href="<?= base_url('/operator/prefixes') ?>">
            <span class="material-symbols-outlined <?= $currentPage === 'prefixes' ? 'icon-fill' : '' ?>">numbers</span>
            Préfixes
        </a>

        <a class="<?= $currentPage === 'operations' ? 'text-primary font-semibold' : 'text-on-surface-variant' ?> font-label-md flex items-center gap-2 relative <?= $currentPage === 'operations' ? 'after:content-[\'\'] after:absolute after:bottom-[-28px] after:left-0 after:w-full after:h-1 after:bg-primary after:rounded-t-full' : '' ?> hover:text-primary transition-colors" href="<?= base_url('/operator/operations') ?>">
            <span class="material-symbols-outlined <?= $currentPage === 'operations' ? 'icon-fill' : '' ?>">account_tree</span>
            Opérations
        </a>

        <a class="<?= $currentPage === 'gains' ? 'text-primary font-semibold' : 'text-on-surface-variant' ?> font-label-md flex items-center gap-2 relative <?= $currentPage === 'gains' ? 'after:content-[\'\'] after:absolute after:bottom-[-28px] after:left-0 after:w-full after:h-1 after:bg-primary after:rounded-t-full' : '' ?> hover:text-primary transition-colors" href="<?= base_url('/operator/gains') ?>">
            <span class="material-symbols-outlined <?= $currentPage === 'gains' ? 'icon-fill' : '' ?>">monitoring</span>
            Gains
        </a>

        <a class="<?= $currentPage === 'comptes' ? 'text-primary font-semibold' : 'text-on-surface-variant' ?> font-label-md flex items-center gap-2 relative <?= $currentPage === 'comptes' ? 'after:content-[\'\'] after:absolute after:bottom-[-28px] after:left-0 after:w-full after:h-1 after:bg-primary after:rounded-t-full' : '' ?> hover:text-primary transition-colors" href="<?= base_url('/operator/comptes') ?>">
            <span class="material-symbols-outlined <?= $currentPage === 'comptes' ? 'icon-fill' : '' ?>">manage_accounts</span>
            Comptes
        </a>
    </nav>
    <div class="flex items-center gap-4">
        <a href="<?= base_url('/logout') ?>" class="p-2 text-primary hover:bg-surface-container-low transition-colors rounded-full主动:opacity-80">
            <span class="material-symbols-outlined" data-icon="logout">logout</span>
        </a>
    </div>
</header>
