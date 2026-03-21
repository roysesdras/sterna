 <!-- Popup -->
 <style>
     /* Conteneur principal */
     .popup {
         display: none;
         position: fixed;
         inset: 0;
         width: 100%;
         height: 100%;
         z-index: 2000;
         align-items: center;
         justify-content: center;
         opacity: 0;
         transition: opacity 0.4s ease;
     }

     .popup.show {
         display: flex;
         opacity: 1;
     }

     /* Fond flouté (Overlay) */
     .popup-overlay {
         position: absolute;
         inset: 0;
         background: rgba(15, 23, 42, 0.7);
         /* Bleu nuit profond */
         backdrop-filter: blur(8px);
         -webkit-backdrop-filter: blur(8px);
     }

     /* La Carte */
     .popup-content {
         position: relative;
         background: #fff;
         width: 90%;
         max-width: 450px;
         border-radius: 24px;
         overflow: hidden;
         box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
         transform: translateY(20px) scale(0.9);
         transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
         z-index: 2001;
     }

     .popup.show .popup-content {
         transform: translateY(0) scale(1);
     }

     /* Image avec effet de dégradé interne */
     .popup-image-container {
         position: relative;
         height: 220px;
         overflow: hidden;
     }

     .popup-image-container img {
         width: 100%;
         height: 100%;
         object-fit: cover;
     }

     /* Texte et contenu */
     .popup-body {
         padding: 30px;
         text-align: center;
     }

     .popup-title {
         font-size: 1.4rem;
         color: #1e293b;
         margin-bottom: 15px;
         line-height: 1.3;
     }

     .popup-text {
         font-size: 1rem;
         color: #64748b;
         margin-bottom: 25px;
         line-height: 1.6;
     }

     /* Bouton d'action (Style Sterna) */
     .popup-button {
         display: block;
         width: 100%;
         padding: 15px;
         font-size: 1.1rem;
         color: #fff;
         background: linear-gradient(135deg, #f4b505 0%, #e8a400 100%);
         text-decoration: none;
         border-radius: 12px;
         transition: all 0.3s ease;
         box-shadow: 0 10px 15px -3px rgba(244, 181, 5, 0.3);
     }

     .popup-button:hover {
         transform: translateY(-2px);
         box-shadow: 0 20px 25px -5px rgba(244, 181, 5, 0.4);
         color: #fff;
     }

     /* Bouton Fermer (Style épuré) */
     .close-circle {
         position: absolute;
         top: 15px;
         right: 15px;
         width: 35px;
         height: 35px;
         background: rgba(255, 255, 255, 0.9);
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         cursor: pointer;
         z-index: 2002;
         transition: all 0.2s;
         box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
     }

     .close-circle:hover {
         background: #fff;
         transform: rotate(90deg);
     }

     .close-circle i {
         font-size: 20px;
         color: #1e293b;
     }
 </style>

 <div id="popup" class="popup">
     <div class="popup-overlay"></div>

     <div class="popup-content">
         <div id="close-btn" class="close-circle">
             <i class="bi bi-x-lg"></i>
         </div>

         <div class="popup-image-container">
             <img src="https://cdn.helloasso.com/img/photos/collectes/croppedimage-7e984e422f10404a9b191929ae0b0380.png" alt="Bibliothèque Dadiékro">
         </div>

         <div class="popup-body comic-neue-regular">
             <h2 class="popup-title comic-neue-bold">Une bibliothèque pour Dadiékro 📚</h2>
             <p class="popup-text">
                 Soutenez la construction d'une bibliothèque en Côte d'Ivoire. Offrez aux enfants un lieu de culture et d'apprentissage.
                 <strong>Chaque euro est un pas vers demain.</strong>
             </p>
             <a href="https://www.helloasso.com/associations/sterna-africa/collectes/lecture-zoo-a-dadiekro"
                 target="_blank"
                 class="popup-button comic-neue-bold">
                 Je soutiens le projet
             </a>
         </div>
     </div>
 </div>

 <script>
     document.addEventListener("DOMContentLoaded", function() {
         const popup = document.getElementById("popup");
         const closeBtn = document.getElementById("close-btn");
         const overlay = document.querySelector(".popup-overlay");

         function openPopup() {
             popup.style.display = "flex"; // On prépare le flex
             setTimeout(() => {
                 popup.classList.add("show"); // On lance l'animation
             }, 10);
             document.body.style.overflow = "hidden";
         }

         function closePopup() {
             popup.classList.remove("show"); // On lance l'animation inverse
             setTimeout(() => {
                 popup.style.display = "none";
                 document.body.style.overflow = "auto";
             }, 400); // On attend la fin de la transition
         }

         // Apparition après 5 secondes
         setTimeout(openPopup, 5000);

         closeBtn.addEventListener("click", closePopup);
         overlay.addEventListener("click", closePopup);
     });
 </script>