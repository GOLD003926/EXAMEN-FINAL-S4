<!DOCTYPE html>
<html class="light" lang="fr" style="">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>MOBILE MONEY | Connexion Sécurisée</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;family=JetBrains+Mono:wght@500&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/login.css') ?>">
    <script src="<?= base_url('tailwind/login.js') ?>"></script>
</head>

<body class="bg-background text-on-surface font-body-md min-h-screen flex flex-col relative overflow-x-hidden">
    <!-- Dynamic Background from User Data -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="w-full h-full bg-cover bg-center opacity-80" style="background-image: url(&quot;https://lh3.googleusercontent.com/aida-public/AB6AXuAQhJaK20flfgYSZz7-eAA1fnurOzHjXe1veUKOz6OvR_KAYxwXw853yZl6qLvoJ6bqEKJEvSIQoK44gaREh94zGP7ZptEwENsDeB_22vhU-ZgUDr27i5xqISRJfRaS-fNuMwK3N3XkzKoEqujpN4snqabL8ZRrBxkiqqMRPREvLXOD1EYDprC0ih-vsQc3W8bkDnpVSXB6BsWzQyPlQWeVUmwmpFY7cLXUKCIVX4q1C7RV95VRGeNw0g&quot;);"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-surface/40 via-transparent to-surface/40"></div>
    </div>

    <!-- Main Content: Login de OUF -->
    <main class="flex-grow flex items-center justify-center px-gutter py-xl relative z-10 h-full">
        <div class="w-full max-w-[440px] glass-panel rounded-3xl p-md md:p-xl shadow-[0px_20px_50px_rgba(0,168,150,0.12)]" id="login-container">
            <!-- Security Badge -->
            <div class="flex justify-center mb-lg">
                <div class="flex items-center gap-2 px-md py-1.5 bg-primary/10 rounded-full border border-primary/20">
                    <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                    <span class="text-primary font-label-sm uppercase tracking-wider">Connexion Sécurisée</span>
                </div>
            </div>
            <div class="text-center mb-xl">
                <h1 class="font-display text-headline-lg text-on-surface mb-2" id="view-title">Bienvenue</h1>
                <p class="text-on-surface-variant font-body-md" id="view-subtitle">Saisissez vos identifiants pour continuer</p>
            </div>
            <!-- Client Login View (Default) -->
            <div class="transition-view opacity-100 scale-100" id="client-view">
                <form class="space-y-lg" onsubmit="event.preventDefault();">
                    <div class="space-y-sm">
                        <label class="font-label-md text-on-surface-variant block ml-1" for="phone">Numéro de Mobile</label>
                        <div class="relative group">

                            <input value="0381234567" class="w-full px-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="phone" placeholder="037 00 000 00" type="text">
                        </div>
                        <p class="text-error text-sm mt-1 hidden" id="phone-error"></p>
                    </div>
                    <button class="w-full py-md bg-primary-container text-white font-label-md rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all">
                        Continuer
                    </button>
                </form>
            </div>
            <!-- Admin Login View (Hidden Initially) -->
            <div class="hidden transition-view opacity-0 scale-95" id="admin-view">
                <form class="space-y-lg" onsubmit="event.preventDefault();">
                    <div class="space-y-sm">
                        <label class="font-label-md text-on-surface-variant block ml-1" for="email">Email Professionnel</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-on-surface-variant">mail</span>
                            <input class="w-full pl-12 pr-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="email" placeholder="nom@m-flow.pro" type="email" value="a@a.com">
                        </div>
                        <p class="text-error text-sm mt-1 hidden" id="email-error"></p>
                    </div>
                    <div class="space-y-sm">
                        <div class="flex justify-between items-center px-1">
                            <label class="font-label-md text-on-surface-variant block" for="password">Mot de passe</label>
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-on-surface-variant">lock</span>
                            <input class="w-full pl-12 pr-md py-md bg-surface-container-low border border-transparent focus:border-primary focus:bg-white focus:ring-0 rounded-xl font-body-md transition-all outline-none" id="password" placeholder="••••••••" type="password" value="admin123">
                        </div>
                        <p class="text-error text-sm mt-1 hidden" id="password-error"></p>
                    </div>
                    <button class="w-full py-md bg-primary-container text-white font-label-md rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all">
                        Se connecter au Dashboard
                    </button>
                </form>
            </div>
            <!-- View Toggle -->
            <div class="mt-xl pt-lg border-t border-outline-variant/30 text-center relative overflow-hidden">
                <div class="scan-animation absolute inset-0 opacity-20 pointer-events-none"></div>
                <button class="text-primary font-label-md hover:underline decoration-2 underline-offset-4 transition-all" id="toggle-view">
                    Accès Opérateur
                </button>
            </div>
        </div>
    </main>
    <script>
        const toggleBtn = document.getElementById('toggle-view');
        const clientView = document.getElementById('client-view');
        const adminView = document.getElementById('admin-view');
        const viewTitle = document.getElementById('view-title');
        const viewSubtitle = document.getElementById('view-subtitle');

        let isAdmin = false;

        toggleBtn.addEventListener('click', () => {
            isAdmin = !isAdmin;

            // Fade out
            const currentView = isAdmin ? clientView : adminView;
            const nextView = isAdmin ? adminView : clientView;

            currentView.classList.add('opacity-0', 'scale-95');

            setTimeout(() => {
                currentView.classList.add('hidden');
                nextView.classList.remove('hidden');

                // Force a reflow for the transition
                void nextView.offsetWidth;

                // Fade in
                nextView.classList.remove('opacity-0', 'scale-95');
                nextView.classList.add('opacity-100', 'scale-100');

                // Update text
                if (isAdmin) {
                    viewTitle.innerText = "Espace Staff";
                    viewSubtitle.innerText = "Administration Mobile Money";
                    toggleBtn.innerText = "Accès Client Standard";
                } else {
                    viewTitle.innerText = "Bienvenue";
                    viewSubtitle.innerText = "Saisissez vos identifiants pour continuer";
                    toggleBtn.innerText = "Accès Opérateur";
                }
            }, 200);
        });

        // Focus state visual micro-interactions
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.classList.add('ring-2', 'ring-primary/10');
            });
            input.addEventListener('blur', () => {
                input.parentElement.classList.remove('ring-2', 'ring-primary/10');
            });
        });
    </script>
    <script>
        // Définir les URLs pour le JS
        window.API_URLS = {
            getPrefixes: '<?= base_url('/get-prefixes') ?>',
            login: '<?= base_url('/login') ?>'
        };
    </script>
    <script src="<?= base_url('js/login.js') ?>"></script>


</body>

</html>