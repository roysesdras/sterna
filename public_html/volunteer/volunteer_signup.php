<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['users_id'])) {
    // Rediriger vers la page de connexion
    header("Location: https://sternaafrica.org/volunteer/login.php");
    exit;
}

// Informations de connexion à la base de données (à remplacer par vos propres informations)
$host = 'localhost';
$username = 'u694220522_sterna_africa';
$password = '@sterna_Africa225';
$database = 'u694220522_africa_db';

// Connexion à la base de données
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $mission_id = $_POST['mission_id'];

    // Utilisation d'une requête préparée pour l'insertion
    $stmt = $conn->prepare("INSERT INTO volunteers (first_name, last_name, email, phone, address, mission_id) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sssssi", $first_name, $last_name, $email, $phone, $address, $mission_id);

        if ($stmt->execute()) {
            // Rediriger vers la page volunteer_list.php avec l'ID de la mission
            header('Location: https://sternaafrica.org/volunteer/volunteer_list.php?id=' . $mission_id);
            exit(); // Assure que le script s'arrête ici pour éviter toute exécution supplémentaire
        } else {
            echo "Erreur lors de l'insertion : " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête : " . $conn->error;
    }
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
    <meta name="description" content=" Sterna Africa: Association de solidarité internationale engagée dans le volontariat et le développement communautaire à l'échelle mondiale. Notre action s'étend sur plusieurs pays, œuvrant pour un impact positif et durable au service des communautés.">
    <meta property="og:title" content="Sternaafrica: solidarité internationale" />
    <meta property="og:description" content="Sterna Africa: Association de solidarité internationale engagée dans le volontariat et le développement communautaire à l'échelle mondiale." />
    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- meta for og.graph -->
    <meta property="og:image" content="https://i.ibb.co/68B537S/garde.jpg" />
    <meta property="og:url" content="https://sternaafrica.org/" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="sternaafrica" />
    <title>participe activité: sternaafrica</title>
    <!-- all css -->
    <link rel="canonical" href="https://sternaafrica.org/volunteer/volunteer_signup.php">
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
            <h3 class="comic-neue-bold pt-4">Inscription des Bénévoles</h3>
            <p class="comic-neue-regular">Merci de remplir le formulaire ci-dessous pour participer à l'activité.</p>
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
                    <label for="phone" class="form-label comic-neue-regular">Téléphone :</label>
                    <input type="tel" class="form-control comic-neue-regular" id="phone" name="phone"pattern="\+?[0-9\s\-\(\)]+" required>
                </div>
                
                <div class="mb-3">
                    <label for="address" class="form-label comic-neue-regular">Adresse :</label>
                    <input type="texte" class="form-control comic-neue-regular" id="address" name="address" required></input>
                </div>
                
                <div class="mb-3">
                    <label for="mission_id" class="form-label comic-neue-regular">Activité :</label>
                    <select class="form-control comic-neue-regular" id="mission_id" name="mission_id" required>
                        <?php
                        // Récupérer la liste des missions pour le dropdown
                        $sql = "SELECT id, title FROM missions";
                        $result = $conn->query($sql);
                        if ($result) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <input class="bout mb-4 comic-neue-regular" type="submit" name="submit" value="S'inscrire">

            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>

    
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <?php include_once('../config/footer_2.php'); ?>

    <script>
    // Sélectionne l'élément .back-to-top
    let backToTopButton = document.querySelector('.back-to-top');

    // Ajoute un écouteur d'événement au défilement de la fenêtre
    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
        backToTopButton.classList.add('active');
        } else {
        backToTopButton.classList.remove('active');
        }
    });

    // Ajoute un écouteur d'événement pour cliquer sur le bouton
    backToTopButton.addEventListener('click', (e) => {
        e.preventDefault();
        window.scrollTo({top: 0, behavior: 'smooth'});
    });
    </script>

    <?php require_once('../config/footer.php'); ?>
</body>
</html>

<?php
$conn->close();
?>
