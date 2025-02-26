<?php
if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    // Connexion à la base de données
    $conn = new mysqli('localhost', 'u694220522_sterna_africa', '@sterna_Africa225', 'u694220522_africa_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Vérifier si l'email existe dans la base de données
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Générer un nouveau mot de passe
        $new_password = generateRandomString(8); // Fonction pour générer une chaîne aléatoire de 8 caractères
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Mettre à jour le mot de passe dans la base de données
        $update_sql = "UPDATE users SET password='$hashed_password' WHERE email='$email'";
        if ($conn->query($update_sql) === TRUE) {
            // Envoyer le nouveau mot de passe par email
            $to = $email;
            $subject = 'Réinitialisation du mot de passe';
            $message = "Votre nouveau mot de passe est : $new_password";
            $headers = 'From: contact@sternaafrica.org';

            mail($to, $subject, $message, $headers);

            $message = "Un nouveau mot de passe a été envoyé à votre adresse e-mail. Veuillez le vérifier et cliquer sur <a href=\"https://sternaafrica.org/volunteer/login.php\">Se connecter</a> pour accéder à votre compte.";
        } else {
            $message = "Erreur lors de la réinitialisation du mot de passe.";
        }
    } else {
        $message = "Aucun compte trouvé avec cet email.";
    }

    $conn->close();
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>


<!DOCTYPE html>
<html lang="fr">
<script src="../assets/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <!-- meta for SEO -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <title>login-bénévole: sternaafrica</title>
    <!-- all css -->
    <link rel="canonical" href="https://sternaafrica.org/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/styles.css">
    <style>
        .bout{
            background-color: #2E8B57;
            color: #fff;
            font-size: 18px;
            padding:10px;
            border: solid 1px #2E8B57;
            border-radius: 10px;
        }

        .bout:hover{
            background-color: transparent;
            color: #2E8B57;
            padding:10px;
            border: solid 1px #2E8B57;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <?php include_once ('../config/mode_theme.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
            <h1 class="comic-neue-bold pt-5">Mot de passe oublié</h1>
                <?php
                if (isset($message)) {
                    echo "<p>$message</p>";
                }
                ?>
                <form action="" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label comic-neue-regular">Email :</label>
                    <input type="email" class="form-control comic-neue-regular" id="email" name="email" required><br>
                </div>  
                    <input type="submit" class="bout comic-neue-regular" name="submit" value="Réinitialiser le mot de passe">
                </form>
                <p class="pt-4 comic-neue-regular"> Vous n'avez pas de compte ? : <a href="inscription_benevoles.php" class="mb-4 comic-neue-regular">Créer un compte</a></p>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
    

    <?php include_once('../config/footer_2.php'); ?>
</body>
</html>


