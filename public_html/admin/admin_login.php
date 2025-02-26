<?php
session_start();
require_once ('../config/db.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['username']; // Stocker le nom de l'administrateur
            header('Location: admin_dashboard.php');
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Nom d'utilisateur incorrect.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Meta tags and other head content -->
    <script src="../assets/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <title>admin login</title>
    <!-- all css -->
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include_once ('../config/mode_theme.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h1 class="comic-neue-bold">Connexion Admin</h1>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label comic-neue-regular">Nom d'utilisateur :</label>
                        <input type="text" class="form-control comic-neue-regular" id="username" name="username" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label comic-neue-regular">Mot de passe :</label>
                        <input type="password" class="form-control comic-neue-regular" id="password" name="password" required>
                    </div>
                    
                    <input class="bout comic-neue-regular" type="submit" name="submit" value="Connexion">
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>

    <?php include_once('../config/footer_2.php'); ?>
</body>
</html>
