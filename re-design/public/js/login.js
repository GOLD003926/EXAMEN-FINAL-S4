console.log("JS login ok")

// Fonction helper pour afficher les erreurs
function showError(inputId, message) {
    const errorElement = document.getElementById(inputId + '-error');
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
    }
}

// Fonction helper pour masquer les erreurs
function hideError(inputId) {
    const errorElement = document.getElementById(inputId + '-error');
    if (errorElement) {
        errorElement.textContent = '';
        errorElement.classList.add('hidden');
    }
}

// Masquer les erreurs lors de la saisie
document.getElementById('phone').addEventListener('input', () => hideError('phone'));
document.getElementById('email').addEventListener('input', () => hideError('email'));
document.getElementById('password').addEventListener('input', () => hideError('password'));

// verification numero mobile au submit - Client view
const clientViewBtn = document.querySelector('#client-view button');
clientViewBtn.addEventListener('click', async function (event) {
    event.preventDefault();
    const phoneInput = document.getElementById('phone');
    const numero = phoneInput.value.trim();

    // Masquer l'erreur précédente
    hideError('phone');

    // conditions numero mobile valide
    // non vide
    if (numero === '') {
        showError('phone', 'Veuillez entrer votre identifiant.');
        return;
    }

    // 10 chiffres et uniquement des chiffres
    if (!/^\d{10}$/.test(numero)) {
        showError('phone', 'Le numero mobile doit contenir exactement 10 chiffres.');
        return;
    }

    // commence par 033 ou 037
    const prefixes = await recuperationPrefixes();
    const isValidPrefix = prefixes.some(prefix => numero.startsWith(prefix));

    if (!isValidPrefix) {
        showError('phone', 'Le numero mobile est invalide (prefixe incorrect). Prefixes valides: ' + prefixes.join(', '));
        return;
    }

    // Envoi des données pour vérification
    envoieLogin(numero, '', 'client');
});

// verification email/password au submit - Admin view
const adminViewBtn = document.querySelector('#admin-view button');
adminViewBtn.addEventListener('click', async function (event) {
    event.preventDefault();
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    const numero = emailInput.value.trim();
    const password = passwordInput ? passwordInput.value.trim() : '';

    // Masquer les erreurs précédentes
    hideError('email');
    hideError('password');

    // conditions email valide
    if (numero === '') {
        showError('email', 'Veuillez entrer votre email.');
        return;
    }

    // Admin: vérifier le mot de passe
    if (password === '') {
        showError('password', 'Veuillez entrer votre mot de passe.');
        return;
    }

    // Envoi des données pour vérification
    envoieLogin(numero, password, 'admin');
});

async function recuperationPrefixes() {
    // Récupération des préfixes depuis la base
    try {
        const response = await fetch(window.API_URLS.getPrefixes);
        const data = await response.json();
        console.log('Préfixes récupérés depuis la base :', data.prefixes.length);
        return data.prefixes;
    } catch (error) {
        console.error('Erreur lors de la récupération des préfixes :', error);
        // Valeurs par défaut en cas d'erreur
        return ['033', '037'];
    }
}

async function envoieLogin(numero, password, userType) {
    try {
        const response = await fetch(window.API_URLS.login, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ numero, password, userType })
        });

        const data = await response.json();

        if (response.ok && data.success) {
            console.log('Connexion réussie :', numero);
            // Redirection vers le tableau de bord approprié
            window.location.href = data.redirect_url;
        } else {
            // Afficher l'erreur sur le champ approprié
            if (userType === 'client') {
                showError('phone', data.message);
            } else {
                showError('password', data.message);
            }
        }
    } catch (error) {
        console.error('Erreur lors de l\'envoi des données :', error);
        if (userType === 'client') {
            showError('phone', 'Une erreur est survenue lors de la connexion. Veuillez réessayer.');
        } else {
            showError('password', 'Une erreur est survenue lors de la connexion. Veuillez réessayer.');
        }
    }
}