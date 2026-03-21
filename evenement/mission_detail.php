<?php
// Connexion à la base de données
require_once('../config/db.php');

// Récupérer l'ID de la mission depuis l'URL
$mission_id = $_GET['id'];

// Récupérer les détails de la mission
$sql = "SELECT * FROM missions WHERE id=$mission_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
// On prépare les données de la mission
$start = strtotime($row['start_date']);
$end   = strtotime($row['end_date']);
$today = strtotime(date('Y-m-d'));

if ($end < $today) {
    $status = 'cloture';
    $statusLabel = 'Mission Clôturée';
    $color = '#305196'; // Bleu
} elseif ($start <= $today && $end >= $today) {
    $status = 'en_cours';
    $statusLabel = 'Mission en cours';
    $color = '#EF9B0F'; // Orange
} else {
    $status = 'a_venir';
    $statusLabel = 'Mission à venir';
    $color = '#28A745'; // Vert
}
?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="auto">

<head>
    <!-- <script src="../assets/js/color-modes.js"></script> -->
    <meta charset="UTF-8">
    <!-- meta for SEO -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index>
    <meta name=" robots" content="follow">
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
    <title><?php echo ($row['title']); ?> | sternaafrica</title>

    <!-- all css -->
    <link rel="canonical" href="https://sternaafrica.org/evenement/mission_detail.php?id=<?php echo htmlspecialchars($mission['id']); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Start cookieyes banner -->
    <!-- <script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/495fc865e66d221c0516bda6/script.js"></script> End cookieyes banner -->

    <style>
        /* Effet de fondu sur l'image hero */
        .mission-hero {
            min-height: 400px;
            display: flex;
            align-items: center;
            border-radius: 0 0 50px 50px;
            /* Courbe douce en bas */
        }

        .status-pill {
            display: inline-block;
            padding: 6px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Décalage de la carte sur le Hero Header */
        .mt-n5 {
            margin-top: -80px !important;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: #f0f7ff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .mission-description p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
            color: #4a5568;
        }

        /* Animation au survol du bouton postuler */
        .btn-warning {
            background-color: #f5b904;
            border: none;
            transition: all 0.3s;
        }

        .btn-warning:hover {
            transform: scale(1.02);
            background-color: #305196;
            color: white;
        }

        /* Adaptabilité mobile */
        @media (max-width: 991px) {
            .mt-n5 {
                margin-top: -30px !important;
            }

            .mission-hero {
                border-radius: 0 0 20px 20px;
                min-height: 300px;
            }

            .mission-hero h1 {
                font-size: 2rem;
            }
        }
    </style>

</head>

<body>
    <?php //require_once ('../config/navbar.php'); 
    ?>
    <div class="mission-detail-wrapper mb-5">
        <div class="mission-hero py-5" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('../images/<?php echo $row['image']; ?>') center/cover;">
            <div class="container text-white text-center py-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-3">
                        <li class="breadcrumb-item"><a href="javascript:history.back()" class="text-white-50 text-decoration-none">Événements</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Détails</li>
                    </ol>
                </nav>
                <h1 class="comic-neue-bold display-4 mb-3"><?php echo htmlspecialchars($row['title']); ?></h1>
                <div class="status-pill" style="background-color: <?php echo $color; ?>;">
                    <?php echo $statusLabel; ?>
                </div>
            </div>
        </div>

        <div class="container mt-n5">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4">
                        <?php if (!empty($row['video'])): ?>
                            <div class="ratio ratio-16x9 mb-4 rounded-4 overflow-hidden shadow">
                                <iframe src="https://www.youtube.com/embed/<?php echo htmlspecialchars($row['video']); ?>" allowfullscreen></iframe>
                            </div>
                        <?php endif; ?>

                        <div class="mission-description comic-neue-regular fs-5">
                            <?php echo $row['description']; ?>
                        </div>

                        <hr class="my-5 opacity-10">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="javascript:history.back()" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="bi bi-arrow-left me-2"></i>Retour
                            </a>
                            <div class="share-buttons">
                                <span class="small text-muted me-2">Partager :</span>
                                <a href="#" class="text-primary fs-4 me-2"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="text-info fs-4"><i class="bi bi-twitter-x"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                            <div class="p-4" style="border-top: 5px solid <?php echo $color; ?>;">
                                <h5 class="comic-neue-bold mb-4 text-dark">Informations clés</h5>

                                <div class="info-item d-flex mb-3">
                                    <div class="info-icon me-3 text-primary"><i class="bi bi-calendar-event"></i></div>
                                    <div>
                                        <small class="text-muted d-block">Dates de la mission</small>
                                        <span class="fw-bold">Du <?= date('d M', $start) ?> au <?= date('d M Y', $end) ?></span>
                                    </div>
                                </div>

                                <div class="info-item d-flex mb-4">
                                    <div class="info-icon me-3 text-primary"><i class="bi bi-geo-alt"></i></div>
                                    <div>
                                        <small class="text-muted d-block">Lieu d'intervention</small>
                                        <span class="fw-bold"><?php echo htmlspecialchars($row['lieu']); ?></span>
                                    </div>
                                </div>

                                <?php if ($status !== 'cloture'): ?>
                                    <a href="../volunteer/volunteer_signup.php?mission_id=<?php echo $row['id']; ?>" class="btn btn-warning w-100 py-3 rounded-pill fw-bold shadow-sm">
                                        POSTULER À CETTE MISSION
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-secondary w-100 py-3 rounded-pill fw-bold" disabled>
                                        MISSION TERMINÉE
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="card bg-primary text-white border-0 rounded-4 p-4 shadow">
                            <h6 class="fw-bold"><i class="bi bi-info-circle me-2"></i>Besoin d'aide ?</h6>
                            <p class="small mb-0">Contactez Sterna Africa pour toute question relative à cette mission humanitaire.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('../config/footer_2.php'); ?>
</body>

</html>
<?php
$conn->close();
?>