<?php
// Démarrage de la session
session_start();

// Connexion à la base de données
$conn = new mysqli('localhost', 'u694220522_sterna_africa', '@sterna_Africa225', 'u694220522_africa_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Traitement du formulaire d'inscription
if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Valider et sécuriser les données
    $first_name = mysqli_real_escape_string($conn, $first_name);
    $last_name = mysqli_real_escape_string($conn, $last_name);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Hasher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insérer les données dans la base de données
    $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$hashed_password')";
    if ($conn->query($sql) === TRUE) {
        // Rediriger vers la page de connexion
        header('Location: login.php');
        exit();
    } else {
        echo "Erreur: " . $conn->error;
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
    <title>bénévole-inscription: sternaafrica</title>
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
        <h1 class="comic-neue-bold">Créer un compte bénévole</h1>
        <p class="comic-neue-regular">Complétez le formulaire ci-dessous pour devenir bénévole et rejoindre notre activité !</p>
            <form action="" method="post">

                <div class="mb-3">
                    <label for="first_name" class="form-label comic-neue-regular">Prénom :</label>
                    <input type="text" class="form-control comic-neue-regular" id="first_name" name="first_name" required>
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label comic-neue-regular">Nom :</label>
                    <input type="text" class="form-control comic-neue-regular" id="last_name" name="last_name" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label comic-neue-regular">Email :</label>
                    <input type="email" class="form-control comic-neue-regular" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label comic-neue-regular">Mot de passe :</label>
                    <input type="password" class="form-control comic-neue-regular" id="password" name="password" required>
                </div>

                <input class="bout comic-neue-regular mb-4" type="submit" name="submit" value="S'inscrire">
            </form>
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
