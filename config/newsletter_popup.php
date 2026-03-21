<!-- Popup Newsletter HTML -->
<div id="popup-newsletter" class="popup-overlay">
    <div class="popup">
        <button class="close-btn" onclick="closePopup()">×</button>
        <h1 class="popup-title" style="color:#000;">Restez Informé !</h1>
        <form id="newsletter-form" class="flex-form">
            <input class="email-input" type="email" id="email" name="email" placeholder="Votre adresse e-mail" required>
            <button type="submit" class="subscribe-button">S'abonner</button>
        </form>
        <p class="popup-description pt-1">Ne manquez plus rien, soyez les premiers informés de nos exclusivités !</p>
        <!-- Affichage des messages -->
        <div id="response-message" class="message" style="display: none;"></div>
    </div>
</div>

<!-- Styles pour la popup -->
<style>
    /* Fond assombri */
   .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.715);/* Assombrissement plus intense */
        display: none; /* Masqué par défaut */
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    /* Désactiver le scroll en arrière-plan */
    body.no-scroll {
        overflow: hidden;
    }

    /* Style de la popup */
    .popup {
        background: #ebebeb;
        padding: 40px;
        border-radius: 20px;
        width: 100%;
        max-width: 45%;
        box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.6); /* Ombre plus profonde */
        position: relative;
        animation: popupFadeIn 0.5s ease;
    }

    .popup-description {
        font-size: 1rem;
        color: #555;
        margin-bottom: 20px;
    }

    /* Animation de la popup */
    @keyframes popupFadeIn {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Bouton de fermeture */
    .close-btn {
        position: absolute;
        top: -1px;
        right: 10px;
        background: transparent;
        border: none;
        font-size: 2em;
        cursor: pointer;
        color: #888;
        transition: color 0.3s ease;
    }

    .close-btn:hover {
        color: #333;
    }

    .email-input {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .subscribe-button {
        width: 100%;
        padding: 10px;
        background-color: #305196;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Message de succès ou d'erreur */
    .message {
        margin-top: 15px;
        padding: 10px;
        border-radius: 5px;
        text-align: left;
        font-size: 0.9rem;
    }

    .success {
        background-color: #d4edda;
        color: #155724;
    }

    .error {
        background-color: #f8d7da;
        color: #721c24;
    }

     /* Media Queries */
     @media (max-width: 600px) {
        .popup {
            max-width: 90%;
            padding: 30px;
        }
    }
</style>

<!-- JavaScript pour la gestion de la popup et de l'AJAX -->
<script>
    function showPopup() {
        document.getElementById('popup-newsletter').style.display = 'flex';
        document.body.classList.add('no-scroll');
    }

    function closePopup() {
        document.getElementById('popup-newsletter').style.display = 'none';
        document.body.classList.remove('no-scroll');
    }

    setTimeout(showPopup, 15000); // Affiche la popup après 5 secondes

    // Gestion de la soumission du formulaire via AJAX
    document.getElementById('newsletter-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Empêche le rechargement de la page

        // Récupère les données du formulaire
        const formData = new FormData(this);
        const messageElement = document.getElementById('response-message');

        fetch('inscription_newsletter.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                messageElement.textContent = data.message;
                messageElement.className = 'message success';
            } else {
                messageElement.textContent = data.message;
                messageElement.className = 'message error';
            }
            messageElement.style.display = 'block'; // Affiche le message
        })
        .catch(error => {
            messageElement.textContent = 'Une erreur est survenue.';
            messageElement.className = 'message error';
            messageElement.style.display = 'block';
        });
    });
</script>
