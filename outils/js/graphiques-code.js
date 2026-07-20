// Gestion des sélecteurs d'exemples pour la page de code des graphiques
document.querySelectorAll('.example-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const targetId = btn.dataset.target;
        
        // Trouver la section parente
        const section = btn.closest('.chart-type-section');
        
        // Désactiver tous les boutons et contenus de cette section
        section.querySelectorAll('.example-btn').forEach(b => b.classList.remove('active'));
        section.querySelectorAll('.example-content').forEach(c => c.classList.remove('active'));
        
        // Activer le bouton et le contenu sélectionnés
        btn.classList.add('active');
        section.querySelector('#' + targetId).classList.add('active');
    });
});
