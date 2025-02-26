<?php
session_start();

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['users_id'])) {
    header("Location: dashboard.php");
    exit;
}

// Vérifier si le formulaire de connexion a été soumis
if (isset($_POST['submit'])) {
    // Connexion à la base de données
    $conn = new mysqli('localhost', 'u694220522_sterna_africa', '@sterna_Africa225', 'u694220522_africa_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Valider et sécuriser les données
    $email = mysqli_real_escape_string($conn, $email);

    // Vérifier si l'utilisateur existe dans la base de données
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Vérifier le mot de passe
        if (password_verify($password, $row['password'])) {
            // Mot de passe correct, connectez l'utilisateur en créant une session
            $_SESSION['users_id'] = $row['id'];
            // Message de succès
            $success_message = "";
            // Redirection automatique après 5 secondes
            echo "<meta http-equiv='refresh' content='1;url=./volunteer_signup.php?id='>";
        } else {
            $error = "Mot de passe incorrect";
        }
    } else {
        $error = '<p class="comic-neue-regular" style="color: red">Identifiants incorrects</p>';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="auto">
<head>
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
    <?php include_once ('../config/navbar.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">

                <h1 class="comic-neue-bold">Connexion</h1>
                <p class="comic-neue-regular">
                    Veuillez vous connecter ou créer un compte pour rejoindre notre équipe de bénévole.
                </p>
                <?php if (isset($success_message)): ?>
                    <p><?php echo $success_message; ?></p>
                <?php elseif (isset($error)): ?>
                    <p><?php echo $error; ?></p>
                <?php endif; ?>
                <form action="" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label comic-neue-regular">Email</label>
                    <input type="email" class="form-control comic-neue-regular" id="email" name="email" required>
                </div>

                <div class="mb-2">
                    <label for="password" class="form-label comic-neue-regular">Mot de passe</label>
                    <input class="comic-neue-regular form-control" type="password" id="password" name="password" required>
                </div>
                    <input type="submit" class="bout comic-neue-regular" name="submit" value="Se connecter">
                </form>
                <p class="comic-neue-regular"><a class="comic-neue-regular" href="forgot_password.php">Mot de passe oublié ?</a></p>
                <p class="comic-neue-regular">Vous n'avez pas de compte ? <a class="comic-neue-regular" href="inscription_benevoles.php">Créez-en un</a></p>

            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
    


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    
    <?php include_once('../config/footer_2.php'); ?>
</body>
</html>
