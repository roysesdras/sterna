<?php
// session_start();
// if (!isset($_SESSION['admin'])) {
//     header('Location: ../admin_login.php');
//     exit();
// }

$conn = new mysqli('localhost', 'u694220522_sterna_africa', '@sterna_Africa225', 'u694220522_africa_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Modifier la requête pour trier les actualités par date de début, les plus récentes en premier
$sql = "SELECT * FROM actualites ORDER BY start_date DESC";
$result_actualites = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
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
    <!-- meta for og.graph -->
    <meta property="og:image" content="https://i.ibb.co/68B537S/garde.jpg" />
    <meta property="og:url" content="https://sternaafrica.org/" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="sternaafrica" />
    <title>toutes les actualités : sternaafrica</title>
    <!-- all css -->
    <link rel="canonical" href="https://sternaafrica.org/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/styles.css">
</head>

<body>
<?php include_once ('../config/mode_theme.php'); ?>
<?php include_once ('../config/navbar.php'); ?>
<div class="container">
<div class="row">
    <h3 class="comic-neue-bold pt-2">toute les actualités Sterna Africa</h3>
        <?php if ($result_actualites->num_rows > 0): ?>
            <?php while ($row = $result_actualites->fetch_assoc()): ?>
                <div class="col-md-3 col-6 ">
                    <div class="mb-6">
                        <img class="w-100" src="../images/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>">
                        <div class="card-body">
                            <h5 class="card-title comic-neue-regular"><?php echo $row['title']; ?></h5>
                            <!-- <p class="mb-1 text-body-secondary comic-neue-regular">Du <?php //echo $row['start_date']; ?> au <?php //echo $row['end_date']; ?></p> -->
                            <a href="./actualite_detail.php?id=<?php echo $row['id']; ?>" class="icon-link gap-1 icon-link-hover comic-neue-regular">
                                En savoir +
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-md-12">
                <p>Aucune actualité disponible pour le moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
    

    <?php include_once('../config/footer_2.php'); ?>

</body>
</html>

<?php
$conn->close();
?>
