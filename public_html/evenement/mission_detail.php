<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'u694220522_sterna_africa', '@sterna_Africa225', 'u694220522_africa_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer l'ID de la mission depuis l'URL
$mission_id = $_GET['id'];

// Récupérer les détails de la mission
$sql = "SELECT * FROM missions WHERE id=$mission_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="auto">
<head>
    <script src="../assets/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <!-- meta for SEO -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index>
    <meta name="robots" content="follow">
    <meta name="description" content="<?php echo htmlspecialchars($row['description']); ?>">
    
    <!-- Favicons -->
    <link href="../assets/img/logos/sternaofficiel-2.png" rel="icon">
    <link href="../assets/img/logos/sternaofficiel-2.png" rel="apple-touch-icon">


    <!-- meta for og.graph -->
    <meta property="og:title" content="<?php echo ($row['title']); ?>" />
    <meta property="og:description" content="<?php echo htmlspecialchars($row['description']); ?>" />
    <meta property="og:image" content="https://sternaafrica.org/images/<?php echo ($row['image']); ?>" />
    <meta property="og:url" content="https://sternaafrica.org/evenement/mission_detail.php?id=<?php echo htmlspecialchars($mission['id']); ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="sternaafrica" />
    <title><?php echo ($row['title']); ?> : sternaafrica</title>

    <!-- all css -->
    <link rel="canonical" href="https://sternaafrica.org/evenement/mission_detail.php?id=<?php echo htmlspecialchars($mission['id']); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Start cookieyes banner --> <script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/495fc865e66d221c0516bda6/script.js"></script> <!-- End cookieyes banner -->

    <style>
        .social-icons{display:flex;flex-direction:column;align-items:left;list-style-type:none;padding:0}.social-icons a{text-decoration:none;color:#000;font-size:30px}@media (max-width:768px){.social-icons{flex-direction:row}.social-icons li{margin:0 10px}}.mad-items{display:flex;overflow-x:scroll}.mad{margin:auto auto auto .75rem;scroll-snap-align:start;box-shadow:rgba(17,17,26,.1) 0 4px 16px,rgba(17,17,26,.05) 0 8px 32px}.photo{width:100px;border-radius:5px 5px 0 0}::-webkit-scrollbar{height:6px;background-color:#f5f5f5}::-webkit-scrollbar-thumb{background-color:#a9a9a9;border-radius:2px}.jpo{box-shadow:rgba(149,157,165,.2) 0 8px 24px;border-radius:5px}
    </style>
</head>

<body>
    <?php require_once ('../config/mode_theme.php'); ?>
    <?php //require_once ('../config/navbar.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 mb-4">
                <?php if (!empty($row['video'])): ?>
                    <div class="ratio ratio-16x9">
                        <iframe class="w-100" src="https://www.youtube.com/embed/<?php echo htmlspecialchars($row['video']); ?>" allowfullscreen></iframe>
                    </div>
                <?php else: ?>
                    <img class="w-100" style="border-radius: 8px 8px 0 0" src="../images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                <?php endif; ?>
                <h2 class="comic-neue-bold"><?php echo htmlspecialchars($row['title']); ?></h2>
                <p class="comic-neue-regular">
                    <div class="comic-neue-regular"><?php echo $row['description']; ?></div>
                 
                    <a class="comic-neue-regular" href="../volunteer/volunteer_signup.php?mission_id=<?php echo htmlspecialchars($row['id']); ?>">Participer en tant que volontaire</a>
                </p>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>    

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>
    
    <?php include_once('../inclusion/footer_2.php'); ?>

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

<?php  require_once('../config/footer_2.php'); ?>
</body>
</html>
<?php
$conn->close();
?>
