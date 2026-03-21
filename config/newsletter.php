<!-- formulaire_newsletter.php -->
<div class="newsletter-container">
    <form id="newsletter-form" class="flex-form">
        <input class="email-input form-control mb-2" type="email" id="email" name="email" placeholder="Entrez votre adresse e-mail" required>
        <input type="submit" class="btn btn-primary" value="S'abonner">
    </form>
    <p class="description">Restez informé avant tout le monde ! Nos exclusivités, directement dans votre boîte mail.</p>

    <!-- Affichage des messages -->
    <div id="response-message" class="message" style="display: none;"></div>
</div>

<script>
    document.getElementById('newsletter-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Empêche le rechargement de la page

        // Récupère les données du formulaire
        const formData = new FormData(this);

        // Envoi de la requête AJAX
        fetch('https://sternaafrica.org/actualite/inscription_newsletter.php', { // Laisse l'action vide pour utiliser le même fichier PHP
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur HTTP, statut = ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                // Gestion de la réponse du serveur
                const messageElement = document.getElementById('response-message');
                messageElement.className = 'message'; // Réinitialise la classe CSS

                if (data.status === 'success') {
                    messageElement.classList.add('success'); // Ajoute la classe de succès
                } else {
                    messageElement.classList.add('error'); // Ajoute la classe d'erreur
                }

                messageElement.textContent = data.message; // Affiche le message du serveur
                messageElement.style.display = 'block'; // Montre le message
            })
            .catch(error => {
                console.error('Erreur:', error);
                const messageElement = document.getElementById('response-message');
                messageElement.className = 'message error'; // Applique la classe d'erreur
                messageElement.textContent = "Une erreur est survenue lors de la soumission."; // Message d'erreur
                messageElement.style.display = 'block'; // Affiche le message
            });
    });
</script>