<div id="newsletter-modal" class="newsletter-overlay">
    <div class="newsletter-content">
        <span class="close-popup" id="close-newsletter">&times;</span>

        <div class="newsletter-container">
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
        background: rgba(0, 0, 0, 0.85);
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
        background: #1a1a1a;
        color: #ffffff;
        padding: 40px 30px;
        border-radius: 20px;
        position: relative;
        width: 90%;
        max-width: 400px;
        text-align: center;
        border: 1px solid #333;
        transform: translateY(30px);
        transition: transform 0.5s ease;
    }

    .newsletter-overlay.active .newsletter-content {
        transform: translateY(0);
    }

    /* Textes */
    .newsletter-content h4 {
        font-size: 22px;
        margin: 0 0 10px 0;
    }

    .newsletter-content .description {
        color: #bbb;
        font-size: 14px;
        margin-bottom: 25px;
    }

    /* Input personnalisé (Remplace form-control) */
    .custom-input {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 15px;
        background: #2a2a2a;
        border: 1px solid #444;
        color: #fff;
        border-radius: 8px;
        box-sizing: border-box;
        /* Pour que le padding ne dépasse pas */
        font-size: 15px;
    }

    .custom-input:focus {
        outline: none;
        border-color: #ffc107;
        /* Jaune Sterna */
    }

    /* Bouton personnalisé (Remplace btn-primary) */
    .custom-button {
        width: 100%;
        padding: 12px;
        background: #ffc107;
        /* Jaune Sterna */
        border: none;
        color: #000;
        font-weight: bold;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.3s;
    }

    .custom-button:hover {
        background: #e5ad06;
    }

    /* Bouton Fermer */
    .close-popup {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 25px;
        cursor: pointer;
        color: #777;
    }

    .close-popup:hover {
        color: #fff;
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
    // 1. Apparition progressive après 6 secondes
    window.addEventListener('load', function() {
        setTimeout(function() {
            if (!sessionStorage.getItem('newsletter_closed')) {
                const modal = document.getElementById('newsletter-modal');
                modal.classList.add('active'); // On ajoute la classe pour lancer la transition CSS
            }
        }, 6000);
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

        fetch('https://sternaafrica.org/actualite/inscription_newsletter.php', {
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