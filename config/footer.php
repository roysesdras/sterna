<?php
// Logique PHP conservée pour le formulaire de volontariat
$messageStatus = ''; 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['your-name'])) {
  $name = htmlspecialchars(trim($_POST['your-name']));
  $email = htmlspecialchars(trim($_POST['your-email']));
  $message = htmlspecialchars(trim($_POST['your-message']));
  $to = 'sternaafrica@gmail.com';
  $subject = $name . ' souhaite devenir volontaire Sterna.';
  $body = "Nom: $name\nEmail: $email\nMessage:\n$message\n";
  $headers = "From: $name <$email>\r\nReply-To: $email\r\n";
  $messageStatus = mail($to, $subject, $body, $headers) ? "Message envoyé avec succès." : "Échec de l'envoi.";
}
?>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v22.0"></script>

<?php include 'impact.php'; ?>

<?php include 'temoignage.php'; ?>

<?php include 'partenaire.php'; ?>

<footer class="relative overflow-hidden pt-16 md:pt-24 pb-10" style="background: #034890;">

<!-- SVG de séparation en haut de la section -->
    <div class="absolute -top-0 md:top-0 left-0 w-full overflow-hidden leading-none">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-12 md:h-20 text-gray-100 fill-current">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 lg:gap-8">
            
            <div class="space-y-2 relative">
                <img src="/assets/img/external/84e554fe99_sternaofficiel-2.png" alt="Sterna Logo" class="h-32 w-auto relative z-10">
                <!-- <img src="/assets/img/external/baf0f05e37_mascotte2.png" alt="Mascotte Sterna" class="absolute bottom-4 left-32 w-16 h-16 object-contain rotate-12 drop-shadow-md opacity-90 animate-pulse"> -->
                <p class="text-sm font-black text-white/80 tracking-[0.3em] uppercase relative z-10">Wherever Needed</p>
            </div>

            <div class="space-y-6">
                <h4 class="text-sm font-black text-white uppercase tracking-widest border-b-2 border-sterna-yellow w-fit pb-1">Liens Utiles</h4>
                <ul class="space-y-3">
                    <li><a href="/a-propos/" class="text-sm font-bold text-white/80 hover:text-sterna-yellow transition-colors flex items-center gap-2"><i class="fi fi-rr-angle-small-right"></i> Qui sommes-nous ?</a></li>
                    <li><a href="/old/pages/missions.php" class="text-sm font-bold text-white/80 hover:text-sterna-yellow transition-colors flex items-center gap-2"><i class="fi fi-rr-angle-small-right"></i> Nos Missions</a></li>
                    <li><a href="/projets/" class="text-sm font-bold text-white/80 hover:text-sterna-yellow transition-colors flex items-center gap-2"><i class="fi fi-rr-angle-small-right"></i> Nos Projets</a></li>
                    <li><a href="/old/pages/documents.php" class="text-sm font-bold text-white/80 hover:text-sterna-yellow transition-colors flex items-center gap-2"><i class="fi fi-rr-angle-small-right"></i> Nos Documents</a></li>
                    <li><a href="/recit_volontaire.php" class="text-sm font-bold text-white/80 hover:text-sterna-yellow transition-colors flex items-center gap-2"><i class="fi fi-rr-angle-small-right"></i> Récit Volontaire</a></li>
                    <li><a href="/contact/" class="text-sm font-bold text-white/80 hover:text-sterna-yellow transition-colors flex items-center gap-2"><i class="fi fi-rr-angle-small-right"></i> Contactez-nous</a></li>
                </ul>
            </div>

            <div id="contact" class="space-y-6">
                <h4 class="text-sm font-black text-white uppercase tracking-widest border-b-2 border-sterna-yellow w-fit pb-1">Nous contacter</h4>
                <ul class="space-y-4">
                    <li class="flex items-center gap-3">
                        <i class="fi fi-rr-envelope text-white"></i>
                        <a href="mailto:sternaafrica@gmail.com" class="text-sm font-bold transition-colors" style="color: white;">sternaafrica@gmail.com</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fi fi-rr-phone-call text-white"></i>
                        <a href="tel:+2250556779012" class="text-sm text-white font-bold transition-colors" style="color: white;">+225 05 56 77 90 12</a>
                    </li>
                     <li class="flex items-center gap-3">
                        <i class="fi fi-rr-marker mt-1" style="color: white;"></i>
                        <a href="" class="text-sm text-white font-bold transition-colors" style="color: white;">Bordeaux, France</a>
                    </li>
                </ul>
                <div class="flex gap-3 pt-4">
                    <a href="https://twitter.com/AfricaSterna" class="footer-social-btn" style="color: white;"><i class="fi fi-brands-twitter-alt"></i></a>
                    <a href="https://www.instagram.com/associationsterna/" class="footer-social-btn" style="color: white;"><i class="fi fi-brands-instagram"></i></a>
                    <a href="https://www.youtube.com/channel/UCekpxdwSoamybXcXT2rtJww" class="footer-social-btn" style="color: white;"><i class="fi fi-brands-youtube"></i></a>
                    <a href="https://www.linkedin.com" class="footer-social-btn" style="color: white;"><i class="fi fi-brands-linkedin"></i></a>
                </div>
            </div>

            <div class="space-y-6">
                <h4 class="text-sm font-black text-white uppercase tracking-widest border-b-2 border-sterna-yellow w-fit pb-1">Soutenir l'action</h4>
                <div class="bg-white/5 backdrop-blur-sm p-2 rounded-2xl border border-white/10">
                    <p class="text-[11px] font-black text-white/90 uppercase mb-3">RIB Sterna Africa</p>
                    <div class="bg-black/20 p-2 rounded-xl border border-white/5 mb-3">
                        <span class="text-[10px] text-white/40 font-bold uppercase block mb-1">IBAN</span>
                        <code class="text-[10px] md:text-xs font-mono text-white/90 break-all">FR76 1027 8060 4900 0210 0810 117</code>
                    </div>
                    <p class="text-[10px] text-white/40 font-bold uppercase">BIC : <span class="text-white/90">CMCIFR2A</span></p>
                </div>
            </div>

            <div id="newsletter" class="space-y-6">
                <h4 class="text-sm font-black text-white uppercase tracking-widest border-b-2 border-sterna-yellow w-fit pb-1">Newsletter</h4>
                <p class="text-sm text-white/90 font-medium leading-relaxed">Rejoignez l'aventure et recevez nos actualités directement.</p>
                <div class="newsletter-dark-custom">
                    <?php if(file_exists('config/newsletter.php')) { include('config/newsletter.php'); } ?>
                </div>
            </div>

        </div>
    </div>
</footer>

<!-- Bouton Back to Top avec la Mascotte -->
<button id="backToTopBtn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-6 right-6 md:bottom-8 md:right-8 z-50 flex items-center justify-center transition-all duration-500 opacity-0 pointer-events-none translate-y-12 group focus:outline-none" aria-label="Retour en haut">
    <img src="/assets/img/external/478a9bc9cc_mascort1.png" alt="Remonter" class="w-16 h-16 md:w-20 md:h-20 object-contain drop-shadow-[0_8px_15px_rgba(0,0,0,0.2)] group-hover:-translate-y-4 group-hover:scale-110 transition-all duration-300 animate-[bounce_3s_infinite]">
</button>

<script>
    // Logique Back to Top
    document.addEventListener("DOMContentLoaded", () => {
        const backToTopBtn = document.getElementById('backToTopBtn');
        if (backToTopBtn) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    backToTopBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-12');
                    backToTopBtn.classList.add('opacity-100', 'translate-y-0');
                } else {
                    backToTopBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-12');
                    backToTopBtn.classList.remove('opacity-100', 'translate-y-0');
                }
            });
        }
    });
</script>

<!-- Popup Cookies avec Mascotte -->
<div id="cookiePopup" class="fixed bottom-4 left-4 right-4 md:bottom-24 md:right-6 md:left-auto z-40 bg-white shadow-2xl rounded-3xl p-6 max-w-sm transform translate-y-full opacity-0 pointer-events-none transition-all duration-700 hidden border border-gray-100">
    <div class="flex items-start gap-4">
        <div class="shrink-0">
            <img src="/assets/img/external/baf0f05e37_mascotte2.png" alt="Mascotte Cookies" class="w-16 h-16 object-contain">
        </div>
        <div>
            <h4 class="font-bold text-gray-900 mb-2">Respect de votre vie privée</h4>
            <p class="text-xs text-gray-500 leading-relaxed font-medium mb-4">
                Nous utilisons des cookies pour améliorer votre expérience sur notre site. 
                En continuant, vous acceptez notre utilisation des cookies.
            </p>
            <div class="flex gap-2">
                <button onclick="acceptCookies()" class="bg-sterna-blue text-white text-xs font-bold py-2 px-6 rounded-full hover:bg-sterna-yellow hover:shadow-lg transition-all w-full md:w-auto">Accepter</button>
            </div>
        </div>
    </div>
</div>

<style>
    .footer-social-btn {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: white;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }
    .footer-social-btn:hover {
        background: #fcb900; /* Jaune Sterna */
        border-color: #fcb900;
        transform: translateY(-3px);
    }
    /* Pour forcer les textes de la newsletter à être blancs s'ils sont injectés */
    .newsletter-dark-custom input {
        background: rgba(255,255,255,0.05) !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        color: white !important;
        border-radius: 12px !important;
        font-size: 13px !important;
    }
    .newsletter-dark-custom button {
        background: #ea750fff !important;
        color: white !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        border-radius: 12px !important;
    }
</style>