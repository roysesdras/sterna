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

<footer class="relative overflow-hidden pt-10 pb-10" style="background: linear-gradient(135deg, #0f277e 0%, #071952 100%);">
    
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(white 1.5px, transparent 1.5px); background-size: 30px 30px;"></div>

    <div class="max-w-7xl mx-auto px-4 relative z-10">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">
            
            <div class="space-y-6">
                <img src="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" alt="Sterna Logo" class="h-32 w-auto brightness-0 invert">
                <p class="text-sm font-black text-white/80 tracking-[0.3em] uppercase">Wherever Needed</p>
                <div class="flex items-start gap-3 text-white/60">
                    <i class="fi fi-rr-marker text-urunani-orange mt-1"></i>
                    <p class="text-lg leading-relaxed font-medium">Adiaké, Côte d'Ivoire<br>Afrique de l'Ouest</p>
                </div>
            </div>

            <div id="contact" class="space-y-6">
                <h4 class="text-sm font-black text-white uppercase tracking-widest border-b-2 border-sterna-orange w-fit pb-1">Connectez-vous</h4>
                <ul class="space-y-4">
                    <li class="flex items-center gap-3">
                        <i class="fi fi-rr-envelope text-white/50"></i>
                        <a href="mailto:sternaafrica@gmail.com" class="text-sm text-white/80 hover:text-urunani-orange font-bold transition-colors">sternaafrica@gmail.com</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fi fi-rr-phone-call text-white/50"></i>
                        <a href="tel:+2250556779012" class="text-sm text-white/80 hover:text-urunani-orange font-bold transition-colors">+225 05 56 77 90 12</a>
                    </li>
                </ul>
                <div class="flex gap-3 pt-4">
                    <a href="https://twitter.com/AfricaSterna" class="footer-social-btn"><i class="fi fi-brands-twitter-alt"></i></a>
                    <a href="https://www.instagram.com/associationsterna/" class="footer-social-btn"><i class="fi fi-brands-instagram"></i></a>
                    <a href="https://www.youtube.com/channel/UCekpxdwSoamybXcXT2rtJww" class="footer-social-btn"><i class="fi fi-brands-youtube"></i></a>
                    <a href="https://www.linkedin.com" class="footer-social-btn"><i class="fi fi-brands-linkedin"></i></a>
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

<?php include 'partenaire.php'; ?>

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
        background: #ea750fff; /* Rose Urunani */
        border-color: #ea750fff;
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