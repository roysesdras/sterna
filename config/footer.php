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

<footer class="relative overflow-hidden pb-10" style="background: #034890;">
    
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 lg:gap-8">
            
            <div class="space-y-2">
                <img src="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" alt="Sterna Logo" class="h-32 w-auto brightness-0 invert">
                <p class="text-sm font-black text-white/80 tracking-[0.3em] uppercase">Wherever Needed</p>
            </div>

            <div class="space-y-6">
                <h4 class="text-sm font-black text-white uppercase tracking-widest border-b-2 border-sterna-orange w-fit pb-1">Liens Utiles</h4>
                <ul class="space-y-3">
                    <li><a href="/a-propos/" class="text-sm font-bold text-white/80 hover:text-white transition-colors flex items-center gap-2"><i class="fi fi-rr-angle-small-right"></i> Qui sommes-nous ?</a></li>
                    <li><a href="/old/pages/missions.php" class="text-sm font-bold text-white/80 hover:text-white transition-colors flex items-center gap-2"><i class="fi fi-rr-angle-small-right"></i> Nos Missions</a></li>
                    <li><a href="/old/pages/documents.php" class="text-sm font-bold text-white/80 hover:text-white transition-colors flex items-center gap-2"><i class="fi fi-rr-angle-small-right"></i> Nos Documents</a></li>
                    <li><a href="/recit_volontaire.php" class="text-sm font-bold text-white/80 hover:text-white transition-colors flex items-center gap-2"><i class="fi fi-rr-angle-small-right"></i> Récit Volontaire</a></li>
                </ul>
            </div>

            <div id="contact" class="space-y-6">
                <h4 class="text-sm font-black text-white uppercase tracking-widest border-b-2 border-sterna-orange w-fit pb-1">Nous contacter</h4>
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
                <h4 class="text-sm font-black text-white uppercase tracking-widest border-b-2 border-sterna-orange w-fit pb-1">Soutenir l'action</h4>
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
                <h4 class="text-sm font-black text-white uppercase tracking-widest border-b-2 border-sterna-orange w-fit pb-1">Newsletter</h4>
                <p class="text-sm text-white/90 font-medium leading-relaxed">Rejoignez l'aventure et recevez nos actualités directement.</p>
                <div class="newsletter-dark-custom">
                    <?php if(file_exists('config/newsletter.php')) { include('config/newsletter.php'); } ?>
                </div>
            </div>

        </div>
    </div>
</footer>

<?php include 'impact.php'; ?>
<?php include 'temoignage.php'; ?>

<!-- Bouton Back to Top Design Moderne -->
<button id="backToTopBtn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-8 right-8 z-50 flex items-center justify-center w-12 h-12 rounded-full bg-sterna-blue/90 backdrop-blur-md text-white shadow-[0_0_20px_rgba(3,72,144,0.4)] hover:shadow-[0_0_30px_rgba(252,185,0,0.6)] hover:bg-sterna-yellow hover:text-sterna-blue transition-all duration-500 opacity-0 pointer-events-none translate-y-12 group overflow-hidden" aria-label="Retour en haut">
    <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out"></div>
    <i class="fi fi-rr-arrow-up text-xl relative z-10 group-hover:-translate-y-1 transition-transform duration-300"></i>
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