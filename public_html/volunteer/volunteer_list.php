<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['users_id'])) {
    // Rediriger vers la page de connexion
    header("Location: login.php");
    exit;
}

// Informations de connexion à la base de données
$host = 'localhost';
$username = 'u694220522_sterna_africa';
$password = '@sterna_Africa225';
$database = 'u694220522_africa_db';

// Connexion à la base de données
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Récupérer l'ID de la mission depuis l'URL
$mission_id = $_GET['id'];

// Récupérer le titre de la mission
$sql_title = "SELECT title FROM missions WHERE id = ?";
$stmt_title = $conn->prepare($sql_title);
$stmt_title->bind_param("i", $mission_id);
$stmt_title->execute();
$stmt_title->bind_result($mission_title);
$stmt_title->fetch();
$stmt_title->close();

// Récupérer les bénévoles inscrits à cette mission
$sql = "SELECT first_name, last_name, email, phone, address FROM volunteers WHERE mission_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $mission_id);
$stmt->execute();
$result = $stmt->get_result();

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
    <title>bénévole-inscription: sternaafrica</title>
    <!-- all css -->
    <link rel="canonical" href="https://sternaafrica.org/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/styles.css">

    <style>
       .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch; /* Assure une défilement fluide sur les appareils mobiles */
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

    </style>
</head>

<body>
    <?php include_once ('../config/mode_theme.php'); ?>
    <?php include_once ('../config/navbar.php'); ?>
    <div class="container mb-4">
        <h2 class="comic-neue-bold text-center pt-4">Liste des Bénévoles inscrits pour l'activité <?php echo htmlspecialchars($mission_title); ?></h2>
        <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Adresse</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>


                <br>
    <a href="../index.php" class="comic-neue-regular">Quitter</a>
    </div>
    

   

    <?php require_once('../config/footer_2.php'); ?>
</body>
</html>

<?php
$stmt->close();
$conn->close();

?>
