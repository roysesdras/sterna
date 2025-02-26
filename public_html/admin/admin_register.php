<?php
// Inclure le fichier de connexion à la base de données
require_once('../config/db.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO admins (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql) === TRUE) {
        header('Location: ./admin_login.php');
        exit();
    } else {
        echo "Erreur: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<script src="../assets/js/color-modes.js"></script>
<head>
    <meta charset="UTF-8">
    <title>Inscription Administrateur</title>
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>
<body>
<?php include_once ('../config/mode_theme.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
            <h1 class="comic-neue-bold pt-5">Inscription Administrateur</h1>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label comic-neue-regular">Nom d'utilisateur :</label>
                        <input type="text" class="form-control comic-neue-regular id="username" name="username" required><br>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label comic-neue-regular">Mot de passe :</label>
                        <input type="password" class="form-control comic-neue-regular id="password" name="password" required><br>
                    </div>
                    
                    <input type="submit" class="bout comic-neue-regular" name="submit" value="Inscription">
                </form>
            </div>
            <div class="col-md-4"></div>
            
        </div>
    </div>
    

    <?php require_once('../config/footer_2.php'); ?>
</body>
</html>

