<?php
$messageStatus = ''; // Variable pour stocker le message de statut

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Récupération des données du formulaire
  $name = htmlspecialchars(trim($_POST['your-name']));
  $email = htmlspecialchars(trim($_POST['your-email']));
  $message = htmlspecialchars(trim($_POST['your-message']));

  // Destinataire
  $to = 'sternaafrica@gmail.com';

  // Sujet de l'email
  $subject = $name . ' souhaite devenir volontaire Sterne.';

  // Corps de l'email
  $body = "Nom: $name\n";
  $body .= "Email: $email\n";
  $body .= "Message:\n$message\n";

  // En-têtes de l'email
  $headers = "From: $name <$email>\r\n";
  $headers .= "Reply-To: $email\r\n";

  // Envoi de l'email
  if (mail($to, $subject, $body, $headers)) {
    $messageStatus = "Message envoyé avec succès.";
  } else {
    $messageStatus = "Échec de l'envoi du message.";
  }
}
?>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v22.0"></script>

<footer class="sterna-footer-dark pt-5 pb-3">
  <div class="container-fluid px-lg-5">
    <div class="row gy-4">

      <div class="col-lg-3 col-md-6">
        <img src="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" alt="Sterna Logo" class="footer-logo-main mb-3">
        <p class="footer-tagline">Wherever Needed</p>
        <div class="address-box">
          <i class="fi fi-rr-marker text-accent"></i>
          <span>Adiaké, Côte d'Ivoire<br>Afrique de l'Ouest</span>
        </div>
      </div>

      <div class="col-lg-3 col-md-6" id="contact">
        <h4 class="footer-title">Connectez-vous</h4>
        <ul class="list-unstyled contact-links">
          <li><i class="fi fi-rr-envelope"></i> <a href="mailto:sternaafrica@gmail.com">sternaafrica@gmail.com</a></li>
          <li><i class="fi fi-rr-phone-call"></i> <a href="tel:+2250556779012">+225 05 56 77 90 12</a></li>
        </ul>
        <div class="footer-social-grid mt-4">
          <a href="https://twitter.com/AfricaSterna?t=LQyImKIWRq9a9zfv2PlFew&s=09" class="s-icon twit"><i class="fi fi-brands-twitter-alt"></i></a>
          <a href="https://www.instagram.com/associationsterna/" class="s-icon insta"><i class="fab fa-instagram"></i></a>
          <a href="https://www.youtube.com/channel/UCekpxdwSoamybXcXT2rtJww" class="s-icon yt"><i class="fab fa-youtube"></i></a>
          <a href="https://www.linkedin.com/feed/?trk=seo-authwall-base_google-one-tap-submit" class="s-icon linke"><i class="fab fa-linkedin"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <h4 class="footer-title">Soutenir l'action</h4>
        <div class="bank-card-dark">
          <p><strong>RIB Sterna Africa</strong></p>
          <div class="iban-box">
            <small style="color: #e2e8f0;">IBAN</small>
            <code>FR76 1027 8060 4900 0210 0810 117</code>
          </div>
          <p class="mt-2 mb-0"><small>BIC : CMCIFR2A</small></p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6" id="newsletter">
        <h4 class="footer-title">Rejoindre l'aventure</h4>
        <?php require_once('config/newsletter.php'); ?>
      </div>

    </div>

    <hr class="footer-divider mt-5 mb-4">

    <div class="row align-items-center">
      <div class="col-md-6">
        <p class="copyright-text">© 2026 Sterna Africa. Made with ❤️ for a better world.</p>
      </div>
      <div class="col-md-6 text-md-end">
        <div class="fb-like" data-href="https://www.facebook.com/sternaafrica" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="true"></div>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

<style>
  .sterna-footer-dark {
    background-color: #050709;
    /* Plus sombre que le site pour "ancrer" le design */
    color: #e2e8f0;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
  }

  .footer-logo-main {
    height: 60px;
    filter: drop-shadow(0 0 10px rgba(48, 81, 150, 0.3));
  }

  .footer-title {
    /* font-family: "Comic Neue", cursive; */
    font-weight: 700;
    color: #f5b904;
    margin-bottom: 25px;
    font-size: 1.2rem;
    letter-spacing: 1px;
  }

  .footer-tagline {
    font-weight: 800;
    color: #305196;
    letter-spacing: 2px;
    text-transform: uppercase;
    font-size: 0.8rem;
  }

  /* Liens de contact */
  .contact-links li {
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .contact-links a {
    color: #94a3b8;
    text-decoration: none;
    transition: 0.3s;
  }

  .contact-links a:hover {
    color: #fff;
  }

  /* Réseaux Sociaux */
  .footer-social-grid {
    display: flex;
    gap: 15px;
  }

  .s-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.03);
    color: #fff;
    text-decoration: none;
    transition: 0.3s;
    border: 1px solid rgba(255, 255, 255, 0.05);
  }

  .s-icon:hover {
    background: var(--hover-color, #305196);
    transform: translateY(-5px);
    color: white;
  }

  .twit:hover {
    --hover-color: #000;
  }

  .insta:hover {
    --hover-color: #E4405F;
  }

  .yt:hover {
    --hover-color: #FF0000;
  }

  .linke:hover {
    --hover-color: #0077B5;
  }

  /* Bloc Banque */
  .bank-card-dark {
    background: rgba(48, 81, 150, 0.1);
    border: 1px dashed rgba(48, 81, 150, 0.3);
    padding: 15px;
    border-radius: 15px;
  }

  .iban-box code {
    display: block;
    background: #000;
    padding: 8px;
    border-radius: 5px;
    color: #f5b904;
    font-size: 0.85rem;
    margin-top: 5px;
  }

  .footer-divider {
    border-color: rgba(255, 255, 255, 0.05);
  }

  .copyright-text {
    font-size: 0.85rem;
    color: #64748b;
  }
</style>