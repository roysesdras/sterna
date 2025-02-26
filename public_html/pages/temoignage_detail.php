<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=u694220522_africa_db', 'u694220522_sterna_africa', '@sterna_Africa225');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération de l'ID du témoignage
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Vérification si l'ID est valide
if ($id <= 0) {
    echo "ID invalide.";
    exit;
}

// Récupération du témoignage correspondant
$sql = "SELECT nom, photo, question1, question2, question3, question4, question5, question6, question7, question8, question9, date_submis FROM temoignages WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$temoignage = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérification si le témoignage existe
if (!$temoignage) {
    echo "Témoignage introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<script src="../assets/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link rel="stylesheet" href="../assets/styles.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Start cookieyes banner --> <script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/495fc865e66d221c0516bda6/script.js"></script> <!-- End cookieyes banner -->
    <title><?php echo htmlspecialchars($temoignage['nom']); ?> - Témoignage</title>
    <style>
        .img-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .img-container img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .tem {
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<?php require_once ('../config/navbar.php'); ?>

<div class="container">

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10 tem mb-4">
        <br>
            <h3 class="comic-neue-bold mb-1"><?php echo htmlspecialchars($temoignage['nom']); ?>, participant.e de la MSI au Bénin 2024 - Projet Sel Avlo, témoigne</h3>
            <p class="comic-neue-regular text-small">
                le 
                <?php 
                // Convertit la date en timestamp et formatez-la
                echo date("d M Y", strtotime($temoignage['date_submis'])); 
                ?> 
            </p>

    
            <div class="img-container">
                <!-- Si l'image existe, l'afficher -->
                <?php if (!empty($temoignage['photo'])): ?>
                    <img src="../uploads/<?php echo htmlspecialchars($temoignage['photo']); ?>" alt="Photo de <?php echo htmlspecialchars($temoignage['nom']); ?>">
                <?php else: ?>
                    <p>Aucune photo disponible.</p>
                <?php endif; ?>
            </div>
            

            <!-- Si l'image existe, l'afficher -->
            <div class="temoignage">
                    <p class="comic-neue-regular" style="color:#305196;"> 
                        <i class="fa-solid fa-quote-left"></i>
                            <?php echo htmlspecialchars(substr($temoignage['question5'], 0, 200)); ?>
                    </p>

                    
                    <h3 class="comic-neue-bold">Quelles étaient vos principales motivations pour participer à cette mission ?</h3>
                    <p class="comic-neue-regular">
                        <?php echo nl2br(htmlspecialchars($temoignage['question1'])); ?>
                    </p>

                    <h3 class="comic-neue-bold">Quelles étaient vos attentes avant la mission ? Ont-elles été atteintes ?</h3>
                    <p class="comic-neue-regular">
                        <?php echo nl2br(htmlspecialchars($temoignage['question2'])); ?>
                    </p>

                    <h3 class="comic-neue-bold">Comment évaluez-vous l'organisation et la préparation en amont de la mission ?</h3>
                    <p class="comic-neue-regular">
                        <?php echo nl2br(htmlspecialchars($temoignage['question3'])); ?>
                    </p>

                    <h3 class="comic-neue-bold">Comment décririez-vous vos interactions avec les habitants du village ?</h3>
                    <p class="comic-neue-regular">
                        <?php echo nl2br(htmlspecialchars($temoignage['question4'])); ?>
                    </p>

                    <h3 class="comic-neue-bold">Comment s'est déroulée la vie sur place durant cette mission ?</h3>
                    <p class="comic-neue-regular">
                        <?php echo nl2br(htmlspecialchars($temoignage['question5'])); ?>
                    </p>

                    <h3 class="comic-neue-bold">Quelles activités ou tâches avez-vous réalisées pendant la mission ?</h3>
                    <p class="comic-neue-regular">
                        <?php echo nl2br(htmlspecialchars($temoignage['question6'])); ?>
                    </p>

                    <h3 class="comic-neue-bold">Quelles difficultés avez-vous rencontrées durant la mission et quelles suggestions proposeriez-vous pour les prochaines missions ?</h3>
                    <p class="comic-neue-regular">
                        <?php echo nl2br(htmlspecialchars($temoignage['question7'])); ?>
                    </p>

                    <h3 class="comic-neue-bold">En tant que participant, Comment cette mission a-t-elle influencé votre perception de la solidarité internationale ?</h3>
                    <p class="comic-neue-regular">
                        <?php echo nl2br(htmlspecialchars($temoignage['question8'])); ?>
                    </p>

                    <h3 class="comic-neue-bold">Partagez-nous un souvenir marquant ou un moment qui vous a particulierement touché lors de cette mission ?</h3>
                    <p class="comic-neue-regular">
                        <?php echo nl2br(htmlspecialchars($temoignage['question9'])); ?>
                    </p>
            </div>
        </div>
        <div class="col-md-1"></div>
        
    </div>
</div>

    <?php require_once ('../config/mode_theme.php'); ?>
    <?php  require_once('../config/footer_2.php'); ?>
</body>
</html>
