<div id="newsletter-modal" class="newsletter-overlay">
    <div class="newsletter-content">
        <span class="close-popup" id="close-newsletter">&times;</span>

        <div class="newsletter-container">
            <div style="display: flex; justify-content: center; margin-top: -30px; margin-bottom: 10px;">
                <img src="https://i.postimg.cc/fL7z8sKy/Whats-App-Image-2026-08-15-at-5-15-13-PM-removebg-preview.png" alt="Mascotte" style="height: 120px; object-fit: contain; z-index: 10; position: relative;">
            </div>
            <h4>Newsletter Exclusive</h4>
            <p class="description">Restez informé avant tout le monde ! Nos exclusivités, directement dans votre boîte mail.</p>

            <form id="newsletter-form">
                <input type="email" id="email" name="email" placeholder="votre@email.com" required class="custom-input">
                <button type="submit" class="custom-button">S'abonner maintenant</button>
            </form>

            <div id="response-message" class="message"></div>
        </div>
    </div>
</div>

<style>
    /* Arrière-plan (Overlay) */
    .newsletter-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 39, 126, 0.6); /* Sterna blue overlay */
        backdrop-filter: blur(4px);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.5s ease;
    }

    /* État actif */
    .newsletter-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    /* La Boîte de dialogue */
    .newsletter-content {
        background: #ffffff;
        color: #0f277e;
        padding: 40px 30px;
        border-radius: 24px;
        position: relative;
        width: 90%;
        max-width: 400px;
        text-align: center;
        border: 1px solid #e5e7eb;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        transform: translateY(30px);
        transition: transform 0.5s ease;
    }

    .newsletter-overlay.active .newsletter-content {
        transform: translateY(0);
    }

    /* Textes */
    .newsletter-content h4 {
        font-size: 24px;
        font-weight: 900;
        margin: 0 0 10px 0;
    }

    .newsletter-content .description {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 25px;
    }

    /* Input personnalisé (Remplace form-control) */
    .custom-input {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 15px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        color: #111827;
        border-radius: 12px;
        box-sizing: border-box;
        font-size: 15px;
        transition: all 0.3s;
    }

    .custom-input:focus {
        outline: none;
        border-color: #0f277e;
        box-shadow: 0 0 0 3px rgba(15, 39, 126, 0.1);
    }

    /* Bouton personnalisé (Remplace btn-primary) */
    .custom-button {
        width: 100%;
        padding: 14px;
        background: #0f277e;
        border: none;
        color: #ffffff;
        font-weight: 900;
        border-radius: 12px;
        cursor: pointer;
        font-size: 16px;
        text-transform: uppercase;
        transition: all 0.3s;
    }

    .custom-button:hover {
        background: #fcb900;
        color: #0f277e;
        box-shadow: 0 10px 15px -3px rgba(252, 185, 0, 0.3);
    }

    /* Bouton Fermer */
    .close-popup {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 25px;
        font-weight: bold;
        cursor: pointer;
        color: #9ca3af;
        transition: color 0.3s;
    }

    .close-popup:hover {
        color: #0f277e;
    }

    /* Messages */
    .message {
        margin-top: 15px;
        font-size: 14px;
        display: none;
    }

    .message.success {
        color: #2ecc71;
        display: block;
    }

    .message.error {
        color: #e74c3c;
        display: block;
    }
</style>

<script>
    // 1. Apparition progressive
    window.addEventListener('load', function() {
        setTimeout(function() {
            // On vérifie le sessionStorage pour ne pas l'afficher à chaque fois
            if (!sessionStorage.getItem('newsletter_closed')) {
                const modal = document.getElementById('newsletter-modal');
                if (modal) modal.classList.add('active'); // On ajoute la classe pour lancer la transition CSS
            }
        }, 10000); // Remis à 10 secondes pour un vrai usage
    });

    // 2. Fermeture du popup avec retrait de la classe active
    document.getElementById('close-newsletter').addEventListener('click', function() {
        const modal = document.getElementById('newsletter-modal');
        modal.classList.remove('active');
        sessionStorage.setItem('newsletter_closed', 'true');
    });

    // 3. Envoi du formulaire (AJAX)
    document.getElementById('newsletter-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('/old/actualite/inscription_newsletter.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const messageElement = document.getElementById('response-message');
                messageElement.className = 'message';

                if (data.status === 'success') {
                    messageElement.classList.add('success');
                    messageElement.textContent = "Parfait ! Vous êtes inscrit. 😊";
                    // Fermeture automatique après succès
                    setTimeout(() => {
                        document.getElementById('newsletter-modal').classList.remove('active');
                    }, 2500);
                } else {
                    messageElement.classList.add('error');
                    messageElement.textContent = data.message;
                }
                messageElement.style.display = 'block';
            })
            .catch(error => {
                const messageElement = document.getElementById('response-message');
                messageElement.className = 'message error';
                messageElement.textContent = "Une erreur est survenue.";
                messageElement.style.display = 'block';
            });
    });
</script>