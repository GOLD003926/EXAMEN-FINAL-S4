<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('bootstrap/icons/bootstrap-icons.min.css') ?>">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
            <h1 class="h4 text-center mb-4">Connexion</h1>
            <form>
                <div class="mb-3">
                    <label for="numero" class="form-label">Numero mobile / Identifiant</label>
                    <input type="text" class="form-control" id="numero" placeholder="033... ou admin">
                </div>
                <div class="mb-3">
                    <label class="form-label d-block">Type de compte</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="userType" id="clientType" value="client" checked>
                        <label class="form-check-label" for="clientType">
                            Client
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="userType" id="adminType" value="admin">
                        <label class="form-check-label" for="adminType">
                            Admin Opérateur
                        </label>
                    </div>
                </div>
                <div class="mb-3" id="passwordField" style="display: none;">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" placeholder="********">
                </div>
                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>
        </div>
    </div>

    <script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <script>
        // Show/hide password field based on user type
        const clientType = document.getElementById('clientType');
        const adminType = document.getElementById('adminType');
        const passwordField = document.getElementById('passwordField');

        clientType.addEventListener('change', function() {
            if (this.checked) {
                passwordField.style.display = 'none';
                document.getElementById('password').required = false;
            }
        });

        adminType.addEventListener('change', function() {
            if (this.checked) {
                passwordField.style.display = 'block';
                document.getElementById('password').required = true;
            }
        });

        // verification numero mobile au submit
        const btnSubmit = document.querySelector('button[type="submit"]');
        btnSubmit.addEventListener('click', async function(event) {
            event.preventDefault(); // Empêche le formulaire de se soumettre
            const numeroInput = document.getElementById('numero');
            const userType = document.querySelector('input[name="userType"]:checked').value;
            const passwordInput = document.getElementById('password');
            
            const numero = numeroInput.value.trim();
            const password = passwordInput ? passwordInput.value.trim() : '';
            
            // conditions numero mobile valide
            // non vide
            if (numero === '') {
                alert('Veuillez entrer votre identifiant.');
                return;
            }
            
            // Validation selon le type d'utilisateur
            if (userType === 'client') {
                // 10 chiffres et uniquement des chiffres
                if (!/^\d{10}$/.test(numero)) {
                    alert('Le numero mobile doit contenir exactement 10 chiffres.');
                    return;
                }
                
                // commence par 033 ou 037
                const prefixes = await recuperationPrefixes(); 
                const isValidPrefix = prefixes.some(prefix => numero.startsWith(prefix));
                
                if (!isValidPrefix) {
                    alert('Le numero mobile est invalide (prefixe incorrect). Prefixes valides: ' + prefixes.join(', '));
                    return;
                }
            } else {
                // Admin: vérifier le mot de passe
                if (password === '') {
                    alert('Veuillez entrer votre mot de passe.');
                    return;
                }
            }
            
            // Envoi des données pour vérification
            envoieLogin(numero, password, userType);
        });
        
        async function recuperationPrefixes() {
            // Récupération des préfixes depuis la base
            try {
                const response = await fetch('<?= base_url('/get-prefixes') ?>');
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
                const response = await fetch('<?= base_url('/login') ?>', {
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
                    alert('Erreur de connexion : ' + data.message);
                }
            } catch (error) {
                console.error('Erreur lors de l\'envoi des données :', error);
                alert('Une erreur est survenue lors de la connexion. Veuillez réessayer.');
            }
        }
    </script>
</body>

</html>