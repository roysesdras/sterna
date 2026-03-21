docker exec -i sterna_site_final tee /var/www/html/desinscription.php << 'EOF'
    <?php
    require_once 'config/db.php';

    $message = "";
    $status = "info";

    if (isset($_GET['email'])) {
        $email = $conn->real_escape_string($_GET['email']);

        // On vérifie si l'abonné existe
        $check = $conn->query("SELECT id FROM abonnes WHERE email = '$email'");

        if ($check->num_rows > 0) {
            // On passe "confirmé" à 0
            $update = $conn->query("UPDATE abonnes SET confirmé = 0 WHERE email = '$email'");

            if ($update) {
                $message = "<h1>Désinscription réussie</h1><p>Vous ne recevrez plus la gazette à l'adresse <strong>$email</strong>.</p>";
                $status = "success";
            }
        } else {
            $message = "<h1>Erreur</h1><p>Cette adresse email est introuvable.</p>";
            $status = "error";
        }
    } else {
        $message = "<h1>Désinscription</h1><p>Lien invalide. Veuillez utiliser le lien présent en bas de votre e-mail.</p>";
    }
    ?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Désinscription - Sterna Africa</title>
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                text-align: center;
                padding: 50px;
                background: #f8f9fa;
                color: #333;
            }

            .card {
                background: white;
                padding: 40px;
                border-radius: 12px;
                display: inline-block;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                max-width: 400px;
            }

            h1 {
                color: #dc3545;
                margin-top: 0;
            }

            p {
                line-height: 1.6;
            }

            .btn {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 20px;
                background: #007bff;
                color: white;
                text-decoration: none;
                border-radius: 5px;
            }
        </style>
    </head>

    <body>
        <div class="card">
            <?php echo $message; ?>
            <a href="https://sternaafrica.org" class="btn">Retour au site</a>
        </div>
    </body>

    </html>
    EOF