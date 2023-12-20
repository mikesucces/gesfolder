    // Définir la durée d'inactivité en millisecondes (2 minutes dans cet exemple)
    var inactivityTimeout = 5 * 60 * 1000; // 2 minutes

    var timeout;

    function resetTimer() {
        clearTimeout(timeout);
        // Réinitialiser le minuteur lorsqu'une action utilisateur est détectée
        timeout = setTimeout(logout, inactivityTimeout);
    }

    function logout() {
        // Rediriger vers la page de déconnexion lorsque l'inactivité est détectée
        window.location.href = 'logout.php';
    }

    // Ajouter des écouteurs d'événements pour détecter les actions utilisateur
    document.addEventListener('mousemove', resetTimer);
    document.addEventListener('keypress', resetTimer);

    // Initialiser le minuteur au chargement de la page
    resetTimer();