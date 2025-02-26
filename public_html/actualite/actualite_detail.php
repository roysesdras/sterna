<?php
session_start();

// Vérifie si un utilisateur est connecté en tant qu'administrateur
// if (!isset($_SESSION['admin'])) {
//     header('Location: ../admin_login.php');
//     exit();
// }

// Vérifie si l'identifiant de l'actualité est passé dans l'URL
if (!isset($_GET['id'])) {
    header('Location: admin_actualites.php'); // Redirige si l'identifiant n'est pas spécifié
    exit();
}

// Connexion à la base de données
$conn = new mysqli('localhost', 'u694220522_sterna_africa', '@sterna_Africa225', 'u694220522_africa_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupère l'identifiant de l'actualité depuis l'URL (assure-toi de filtrer et de valider cette valeur)
$actualite_id = $_GET['id'];

// Requête SQL pour récupérer les détails de l'actualité
$sql = "SELECT * FROM actualites WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $actualite_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $title = htmlspecialchars($row['title']);
    $start_date = htmlspecialchars($row['start_date']);
    $end_date = htmlspecialchars($row['end_date']);
    $description = $row['description']; // La description peut contenir du HTML
    $image = htmlspecialchars($row['image']); // Nom du fichier image

    // Fonction pour extraire les images insérées via TinyMCE
    function extractImagesFromDescription($description) {
        preg_match_all('/<img[^>]+src="([^">]+)"/i', $description, $matches);
        return $matches[1];
    }

    // Extraction des images depuis la description
    $images = extractImagesFromDescription($description);

    // Filtrer les images à afficher horizontalement (ex. images avec une classe spécifique)
    $horizontalImages = [];
    foreach ($images as $img) {
        // Vérifie si l'image a une classe spécifique ou un autre attribut qui la distingue
        if (strpos($img, 'class="horizontal-image"') !== false) {
            $horizontalImages[] = $img;
        }
    }

    // Extraction de la description et limitation à 160 caractères
    $description_excerpt = substr(strip_tags($description), 0, 160) . '...';
    ?>


    <!DOCTYPE html>
    <html lang="fr" data-bs-theme="auto">
    <head>
        <script src="../assets/js/color-modes.js"></script>
        <meta charset="UTF-8">
        <title><?php echo $title; ?> - sternaafrica</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="index">
        <meta name="robots" content="follow">
        <meta name="description" content="<?php echo htmlspecialchars($description_excerpt); ?>">
        <!-- meta og -->
        <meta property="og:title" content="<?php echo $title; ?>" />
        <meta property="og:description" content="<?php echo htmlspecialchars($description_excerpt); ?>" />
        <meta property="og:url" content="https://sternaafrica.org/actualite/actualite_detail.php?id=<?php echo $actualite_id; ?>" />

        <meta property="og:type" content="article" />
        <meta property="og:image" content="https://sternaafrica.org/images/<?php echo $image; ?>" />

        <!-- Favicons -->
        <link href="../assets/img/logos/sternaofficiel-2.png" rel="icon">
        <link href="../assets/img/logos/sternaofficiel-2.png" rel="apple-touch-icon">
        <!-- Stylesheets -->
        <link rel="canonical" href="https://sternaafrica.org/actualite/actualite_detail.php?id=<?php echo $actualite_id; ?>">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link rel="stylesheet" href="../assets/styles.css">

        <!-- Start cookieyes banner --> <script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/495fc865e66d221c0516bda6/script.js"></script> <!-- End cookieyes banner -->

        <style>
        .image-container{display:flex;overflow-x:scroll;white-space:nowrap;margin:auto auto auto 0.20rem;scroll-snap-align:start}::-webkit-scrollbar{height:6px;background-color:#F5F5F5}::-webkit-scrollbar-thumb{background-color:#A9A9A9;border-radius:2px}.image-container img{width:250px;margin-right:10px}.jpo{box-shadow:rgba(149, 157, 165, 0.2) 0 8px 24px;border-radius:5px}.social-icons{display:flex;flex-direction:column;align-items:left;list-style-type:none;padding:0}.social-icons a{text-decoration:none;color:#000;font-size:30px}@media (max-width: 768px){.social-icons{flex-direction:row}.social-icons li{margin:0 10px}}.comment-section{padding-top:5px}.comment{border-bottom:1px solid #ddd}.btn{color:#fff;background-color:#305196;padding:5px;border-radius:5px;font-size:18px}.btn:hover{background-color:transparent;padding:5px;border:solid 1px #305196;border-radius:5px}
        </style>

    </head>
    <body>
        <?php // include_once ('../config/mode_theme.php'); ?>
        <?php // include_once ('../config/navbar.php'); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">  
                    <img src="../images/<?php echo $image; ?>" class="w-100" alt="<?php echo $title; ?>" style="border-radius: 8px 8px 0 0;">
                    <h4 class="comic-neue-bold"><?php echo $title; ?></h4>
                    <div class="comic-neue-regular"><?php echo $description; ?></div>

                    <!-- Affichage des images insérées via TinyMCE -->
                    <?php if (!empty($horizontalImages)): ?>
                        <div class="image-container">
                            <?php foreach ($horizontalImages as $img): ?>
                                <img src="<?php echo $img; ?>" alt="Image">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
                        <i class="bi bi-arrow-up-short"></i>
                    </a>
                </div>

                    <div class="col-md-2">
                        <div class="position-sticky" style="top: 1rem">
                            <ul class="social-icons">
                            <li>
                                <a href="javascript:void(0);" id="copyLinkButton">
                                    <i class="bi bi-link"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://api.whatsapp.com/send?text=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="shareFacebook">
                                    <i class="bi bi-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/intent/tweet?text=Check%20this%20out!&url=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank">
                                    <i class="bi bi-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank">
                                    <i class="bi bi-linkedin"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com" target="_blank">
                                    <i class="bi bi-instagram"></i>
                                </a>
                            </li>
                            </ul>                                   
                        </div>
                    </div>

                    <script>
                        document.getElementById('copyLinkButton').addEventListener('click', function() {
                            const link = window.location.href;
                            const tempInput = document.createElement('input');
                            tempInput.value = link;
                            document.body.appendChild(tempInput);
                            tempInput.select();
                            document.execCommand('copy');
                            document.body.removeChild(tempInput);
                            alert('Lien copié dans le presse-papiers!');
                        });

                        document.getElementById('shareFacebook').addEventListener('click', function(e) {
                            e.preventDefault();
                            let shareUrl = 'https://www.facebook.com/dialog/share';
                            shareUrl += '?app_id=' + encodeURIComponent('1442765269758693'); // Remplace avec ton ID d'application Facebook
                            shareUrl += '&display=popup';
                            shareUrl += '&href=' + encodeURIComponent(window.location.href);

                            // Ouvre une fenêtre popup pour le partage
                            window.open(shareUrl, '_blank', 'width=600,height=400');

                            // Pour les navigateurs qui bloquent les popups, redirige directement vers Facebook
                            window.location.href = shareUrl;
                        });
                    </script>

                    <div class="col-md-2"></div>
                    <div class="col-md-8">   
                    <h3 class="mb-3 mt-4 comic-neue-bold">Commentaires :</h3>
                            <div class="comments">
                            <script>
                                // Récupérer le fuseau horaire de l'utilisateur
                                const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

                                // Envoyer le fuseau horaire au serveur via AJAX ou dans un cookie
                                document.cookie = "timezone=" + userTimezone;
                            </script>

                            <?php
                                // Vérifier si le cookie du fuseau horaire est défini
                                if (isset($_COOKIE['timezone'])) {
                                    $userTimezone = $_COOKIE['timezone'];
                                } else {
                                    $userTimezone = 'UTC'; // Par défaut, on utilise UTC si aucun fuseau n'est détecté
                                }

                                // Fonction pour afficher la date relative avec le fuseau horaire de l'utilisateur
                                function timeAgo($datetime, $userTimezone = 'UTC') {
                                    $date = new DateTime($datetime, new DateTimeZone('UTC'));  // Date en UTC depuis la base de données
                                    $date->setTimezone(new DateTimeZone($userTimezone));  // Conversion en fuseau horaire de l'utilisateur
                                    $now = new DateTime('now', new DateTimeZone($userTimezone));  // Heure actuelle dans le fuseau horaire de l'utilisateur
                                    $interval = $now->diff($date);

                                    if ($interval->y > 0) {
                                        return 'il y a ' . $interval->y . ' an' . ($interval->y > 1 ? 's' : '');
                                    } elseif ($interval->m > 0) {
                                        return 'il y a ' . $interval->m . ' mois';
                                    } elseif ($interval->d > 0) {
                                        return 'il y a ' . $interval->d . ' jour' . ($interval->d > 1 ? 's' : '');
                                    } elseif ($interval->h > 0) {
                                        return 'il y a ' . $interval->h . ' heure' . ($interval->h > 1 ? 's' : '');
                                    } elseif ($interval->i > 0) {
                                        return 'il y a ' . $interval->i . ' minute' . ($interval->i > 1 ? 's' : '');
                                    } else {
                                        return 'à l\'instant';
                                    }
                                }

                                // Requête pour récupérer les commentaires pour cette actualité
                                $sql = "SELECT * FROM comments WHERE actualite_id = ? ORDER BY created_at DESC";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $actualite_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($comment = $result->fetch_assoc()) {
                                        // Formate la date en fonction du fuseau horaire de l'utilisateur
                                        $formattedDate = timeAgo($comment['created_at'], $userTimezone);

                                        echo '<div class="comment mb-3 comic-neue-regular">';
                                        echo '<strong>' . ($comment['user_name']) . '</strong>';
                                        echo ' : <small class="text-muted">' . $formattedDate . '</small>';
                                        echo '<p>' . nl2br(html_entity_decode($comment['comment'])) . '</p>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p>Laisse un commentaire, ça fait toujours plaisir!&#128522;</p>';
                                }
                            ?>

                            </div>

                            <div class="comment-section">
                                
                                <form action="commentaire.php" method="POST">
                                    <input type="hidden" name="actualite_id" value="<?php echo $actualite_id; ?>">
                                    <div class="mb-3">
                                        <label for="user_name" class="form-label"></label>
                                        <input type="text" class="form-control comic-neue-regular" id="user_name" name="user_name" placeholder="Pseudo" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="comment" class="form-label"></label>
                                        <textarea class="form-control comic-neue-regular" id="comment" name="comment" rows="5" placeholder="✍️ Ecrire ici....." required></textarea>
                                    </div>
                                    <button type="submit" class="btn mb-4 comic-neue-regular">Postez!🚀</button>
                                </form>

                            </div>
                            <?php // include_once('../config/newsletter_popup.php'); ?>
                        </div>

                        <div class="col-md-2"></div>
                
                </div>

                    <div class="col-md-12 mb-2" id="temoignage">
                        <h3 class="pt-4 fst-italic border-bottom comic-neue-bold">&nbsp;<i class="fas fa-quote-left"></i>&nbsp; Témoignages des Participants</h3>
                        <div class="temoignages-container">
                            <?php
                                // Requête SQL pour récupérer les témoignages liés à l'actualité via la table de liaison
                                $sql_temoignages = "
                                    SELECT t.* 
                                    FROM temoignages t
                                    JOIN actualites_temoignages at ON t.id = at.id_temoignage
                                    WHERE at.id_actualite = ?
                                ";
                                $stmt_temoignages = $conn->prepare($sql_temoignages);
                                $stmt_temoignages->bind_param("i", $actualite_id);
                                $stmt_temoignages->execute();
                                $result_temoignages = $stmt_temoignages->get_result();

                                if ($result_temoignages->num_rows > 0) {
                                    while ($temoignage = $result_temoignages->fetch_assoc()) {
                                        $question5_excerpt = htmlspecialchars(substr($temoignage['question5'], 0, 150)) . '.....lir la suite'; // Récupérer les 150 premiers caractères
                                        $nom = htmlspecialchars($temoignage['nom']);
                                        $photo = htmlspecialchars($temoignage['photo']);
                                        $lien_externe = "../temoignage/" . $temoignage['id']; // Remplacez par le lien externe souhaité

                                        // Affichage du témoignage avec style
                                        echo '<div class="temoignage" onclick="window.location=\'' . $lien_externe . '\'" style="cursor:pointer;">';
                                        echo '<img src="../uploads/' . $photo . '" alt="' . $nom . '" class="temoignage-img w-100">';
                                        echo '<p class="temoignage-excerpt comic-neue-regular"><i class="fas fa-quote-left"></i> ' . $question5_excerpt . '</p>';
                                        echo '<h5 class="temoignage-nom comic-neue-bold">' . $nom . '</h5>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p>Aucun témoignage trouvé pour cette actualité.</p>';
                                }
                            ?>
                        </div>
                    </div>

                    <style>
                        .temoignages-container {
                            display: flex;
                            flex-wrap: nowrap;
                            overflow-x: auto; /* Pour la barre de défilement horizontale */
                            padding: 20px 0; /* Espacement vertical */
                        }

                        .temoignage {
                            min-width: 300px;
                            max-width: 300px;
                            margin-right: 20px;
                        }

                        .temoignage-img {
                            border-radius: 5px; /* Coins arrondis de l'image */
                            height: auto;
                        }

                        .temoignage-excerpt {
                            margin: 10px 0; /* Espacement vertical */
                        }

                        .temoignage-nom {
                            font-weight: bold; /* Texte en gras */
                            color: #305196; /* Couleur du nom */
                        }

                    </style>
                
            </div>
            
        <?php include_once('../config/footer_2.php'); ?>

    </body>
    </html>
    <?php
} else {
    echo "<p>Aucune actualité trouvée avec cet identifiant.</p>";
}

// Fermeture de la connexion à la base de données
$stmt->close();
$conn->close();
?>
