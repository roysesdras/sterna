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

<footer class="footer-section">
    <div class="container-fluid">
        <div class="row">
          
          <!-- Logo and Address -->
          <div class="col-lg-4 col-md-6 footer-column comic-neue-regular">
            <img src="https://sternaafrica.org/assets/img/logos/sternaofficiel-2.png" alt="Sterna Africa Logo" class="footer-logo">

            <p>
              Solidarité internationale, <br>
              éducation pour tous.
            </p>

            <p>
              Adiaké, Côte d'Ivoire <br>
              Afrique
            </p>
          </div>

          <!-- Contact & Useful Links -->
          <div class="col-lg-4 col-md-6 footer-column comic-neue-regular">
            <h4>Contact & Liens utiles</h4>
            <ul class="footer-links">
              <li><a href="https://sternaafrica.org/pages/about.php" class="comic-neue-bold">Qui sommes-nous ?</a></li>
              <li><a href="https://sternaafrica.org/ils_parlent.php" class="comic-neue-bold">Ils parlent de nous</a></li>
              <li><a href="https://sternaafrica.org/rapport/annee_2023" class="comic-neue-bold">Rapports annuels</a></li>
            </ul>
            <p>Email: <a href="mailto:sternaafrica@gmail.com">sternaafrica@gmail.com</a></p>
            <p>Contact: +225 05 56 77 90 12</p>
          </div>

          <!-- Contact Form -->
          <!-- <div class="col-lg-3 col-md-6 footer-column comic-neue-regular">
            <h4 class="">Devenir Sterne</h4>
            <form method="post" action="" class="contact-form">
              <input type="text" name="your-name" placeholder="Votre nom" required>
              <input type="email" name="your-email" placeholder="Votre email" required>
              <textarea name="your-message" placeholder="Votre message" required></textarea>
              <button type="submit">Rejoindre</button>
            </form>
            <?php if ($messageStatus): ?>
                <div class="alert alert-info mt-3"><?php echo $messageStatus; ?></div>
            <?php endif; ?>
          </div> -->

          <!-- Bank Details -->
          <div class="col-lg-4 col-md-6 footer-column comic-neue-regular">
            <h4 class="">Nos Coordonnées Bancaires</h4>
            <p><strong>Banque :</strong> UBA Côte d'Ivoire</p>
            <p><strong>Intitulé du compte :</strong> Association Sterna Africa International</p>
            <p><strong>N° de compte :</strong> 109100000238</p>
            <p><strong>IBAN :</strong> CI93CI1500100910910000023884</p>
            <p><strong>SWIFT :</strong> UNAFCIAB</p>
          </div>

        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

<style>
  @import url(https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Playwrite+DE+Grund:wght@100..400&family=Playwrite+NG+Modern:wght@100..400&display=swap);.footer-column,.footer-links li{margin-bottom:10px}.footer-links a:hover,h4{color:#305196}.comic-neue-bold,.comic-neue-regular{font-family:"Comic Neue",cursive;font-style:normal}.footer-section{background-color:#141421fd;color:#e3deded1;box-shadow:0 0 20px rgba(0,0,0,.3)}.row{display:flex;flex-wrap:wrap}.footer-column{padding:20px}.footer-logo,h4{margin-bottom:20px}h4{font-size:18px;font-weight:600}.footer-logo{width:120px}.footer-links{list-style:none;padding:0}.footer-links a{color:#e3deded1;text-decoration:none;transition:color .3s}.contact-form input,.contact-form textarea{width:100%;padding:10px;margin-bottom:15px;border:1px solid;border-radius:5px;background-color:#141421fd;c5border-color:#333;}.contact-form input:focus,.contact-form textarea:focus{outline:0;box-shadow:0 0 5px rgba(61, 83, 209, 0.7); background-color:#141421fd;}.contact-form button{background-color:#305196;color:#e3deded1;padding:5px;border:none;border-radius:5px;cursor:pointer;transition:background-color .3s}.footer-column p{color:#e3deded1;line-height:1.2}@media (max-width:768px){.footer-column{flex:0 0 100%}}
</style>
