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

<style>
    /* Container principal */
    .newsletter-container {
        max-width: 100%;
    }

    /* Le formulaire en ligne */
    #newsletter-form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    /* L'input email */
    .email-input.form-control {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 15px !important;
        padding: 12px 20px !important;
        color: white !important;
        font-size: 14px !important;
        transition: all 0.3s ease !important;
    }

    .email-input.form-control:focus {
        background: rgba(255, 255, 255, 0.1) !important;
        border-color: #ea750fff !important; /* Rose Urunani */
        box-shadow: 0 0 15px rgba(234, 15, 104, 0.2) !important;
        outline: none;
    }

    /* Le bouton S'abonner */
    #newsletter-form .btn-primary {
        background: #ea750fff; !important;
        border: none !important;
        border-radius: 15px !important;
        padding: 12px !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        font-size: 12px !important;
        transition: all 0.3s ease !important;
    }

    #newsletter-form .btn-primary:hover {
        background: #ea750fff !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(234, 15, 104, 0.4);
    }

    /* Description sous le formulaire */
    .newsletter-container .description {
        margin-top: 15px;
        font-size: 11px;
        color: rgba(255, 255, 255, 0.5);
        font-weight: 500;
        line-height: 1.4;
    }

    /* Messages de réponse (AJAX) */
    .message {
        margin-top: 15px;
        padding: 10px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        text-align: center;
    }

    .message.success {
        background: rgba(46, 204, 113, 0.15);
        color: #2ecc71;
        border: 1px solid rgba(46, 204, 113, 0.3);
    }

    .message.error {
        background: rgba(231, 76, 60, 0.15);
        color: #e74c3c;
        border: 1px solid rgba(231, 76, 60, 0.3);
    }
</style>