<!-- formulaire_newsletter.php -->
<div class="newsletter-container">
    <h1 class="comic-neue-bold">Recevez nos dernières nouvelles !</h1>
    <form id="newsletter-form" class="flex-form">
        <input class="email-input" type="email" id="email" name="email" placeholder="Votre adresse e-mail" required>
        <input type="submit" class="subscribe-button" value="S'abonner">
    </form>
    <p class="description">Ne manquez plus rien, soyez les premiers informés de nos dernières nouvelles !</p>

    <!-- Affichage des messages -->
    <div id="response-message" class="message" style="display: none;"></div>
</div>

<style>
    .newsletter-container {
        position: relative;
        display: flex;
        flex-direction: column;
        padding: 40px;
        max-width: 100%;
        margin: 20px auto;
        border: 1px solid #ddd;
        border-radius: 2px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
        width: 100%;
    }
    
    h1 {
        margin-bottom: 20px;
        font-size: 1.8rem;
    }
    
    .flex-form {
        display: flex;
        width: 100%;
        flex-wrap: wrap;
    }
    
    .email-input {
        flex: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px 0 0 5px;
        font-size: 1rem;
        transition: border-color .3s;
        outline: 0;
    }
    
    .email-input:focus {
        border-color: #305196;
        box-shadow: 0 0 5px rgba(48, 81, 150, .3);
    }
    
    .subscribe-button {
        background: #305196;
        border: none;
        color: #fff;
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
        transition: background .3s;
        flex-shrink: 0;
    }
    
    .subscribe-button:hover {
        background: #253e7a;
    }
    
    .description {
        margin-top: 15px;
        font-size: .9rem;
    }
    
    .message {
        margin-top: 15px;
        padding: 5px;
        border-radius: 5px;
        width: 100%;
        text-align: left;
    }
    
    .success {
        background-color: #d4edda;
        color: #155724;
    }
    
    .error {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    @media (max-width: 600px) {
        .flex-form {
            flex-direction: column;
        }
        
        .email-input, .subscribe-button {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .subscribe-button {
            border-radius: 5px;
        }
    }
</style>

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
