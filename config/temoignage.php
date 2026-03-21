<?php
// temoignage.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. Connexion à la base africa_db (via ton fichier central)
require_once('db.php');

// On s'assure que $pdoAfrica pointe vers ta connexion MySQLi (souvent nommée $conn dans db.php)
if (isset($conn) && !isset($pdoAfrica)) {
    $pdoAfrica = $conn;
}

// 2. Connexion à la base monespace (en PDO comme tu l'as défini)
try {
    $pdoMonespace = new PDO('mysql:host=db;dbname=monespace', 'root', 'SoftiP4');
    $pdoMonespace->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // On ne bloque pas tout le site si monespace a un souci
    error_log("Erreur de connexion monespace : " . $e->getMessage());
}

// 3. Récupération des témoignages (Version MySQLi)
$sql = "SELECT t.id, t.nom, t.photo, t.date_submis, t.is_volontaire, t.volontaire_id,
               (SELECT r.reponse 
                FROM reponses r 
                WHERE r.temoignage_id = t.id 
                ORDER BY r.question_id ASC 
                LIMIT 1) AS reponse
        FROM temoignages t
        ORDER BY t.id DESC";

$result = $pdoAfrica->query($sql);
$temoignages = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $temoignages[] = $row;
    }
}

// 4. Récupérer les infos utilisateur volontaire (Version PDO)
if (isset($pdoMonespace)) {
    foreach ($temoignages as &$temoin) {
        if (!empty($temoin['is_volontaire']) && !empty($temoin['volontaire_id'])) {
            try {
                $stmtUser = $pdoMonespace->prepare("SELECT nom, avatar FROM users WHERE id = ?");
                $stmtUser->execute([$temoin['volontaire_id']]);
                $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    $fullName = trim($user['nom']);
                    $prenom = explode(' ', $fullName)[0];
                    $temoin['volontaire_nom'] = $prenom;
                    $temoin['volontaire_avatar'] = $user['avatar'];
                }
            } catch (Exception $e) {
                // On ignore l'erreur pour ce témoin précis
            }
        }
    }
}

// Fonction pour la date
if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        // Au lieu de créer $diff->w, on calcule les semaines séparément
        $weeks = floor($diff->d / 7);
        $days = $diff->d - ($weeks * 7);

        $string = [
            'y' => 'an',
            'm' => 'mois',
            'w' => 'semaine',
            'd' => 'jour',
            'h' => 'heure',
            'i' => 'minute',
            's' => 'seconde',
        ];

        // On prépare les valeurs pour la boucle
        $values = [
            'y' => $diff->y,
            'm' => $diff->m,
            'w' => $weeks,
            'd' => $days,
            'h' => $diff->h,
            'i' => $diff->i,
            's' => $diff->s,
        ];

        foreach ($string as $k => &$v) {
            if ($values[$k]) {
                $v = $values[$k] . ' ' . $v . ($values[$k] > 1 ? ($k === 'm' ? '' : 's') : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? 'il y a ' . implode(', ', $string) : 'à l’instant';
    }
}
?>

<style>
    .temoignages-container {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        padding-bottom: 10px;
        scrollbar-width: thin;
    }

    .temoignages-container .card {
        min-width: 280px;
        max-width: 280px;
        margin-right: 20px;
        transition: all 0.3s ease;
    }

    .temoignages-container .card:hover {
        transform: translateY(-10px);
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
    }

    .temoignages-container::-webkit-scrollbar {
        height: 8px;
    }

    .temoignages-container::-webkit-scrollbar-thumb {
        background-color: #333;
        border-radius: 10px;
    }

    .card-img-top {
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
    }
</style>

<div class="container-fluid testimonial-scroll-area">
    <div class="testimonial-track">
        <?php foreach ($temoignages as $temoignage): ?>
            <?php
            // Gestion de l'image (Ta logique actuelle)
            $photoPath = "../assets/img/avatar-default.jpg";
            if (!empty($temoignage['is_volontaire']) && !empty($temoignage['volontaire_avatar'])) {
                $fileName = basename(trim($temoignage['volontaire_avatar']));
                $photoPath = "https://monespacevolontaire.sternaafrica.org/uploads/" . $fileName;
            } elseif (!empty($temoignage['photo'])) {
                $photoPath = "../uploads/" . basename(trim($temoignage['photo']));
            }
            ?>

            <div class="testimonial-bubble" onclick="window.location.href='../temoignage/<?= $temoignage['id']; ?>'">
                <div class="bubble-header">
                    <div class="user-info">
                        <img src="<?= $photoPath; ?>" class="user-avatar" alt="Avatar">
                        <div class="user-meta">
                            <span class="user-name"><?= htmlspecialchars($temoignage['nom']); ?></span>
                            <small class="time-ago"><?= time_elapsed_string($temoignage['date_submis']); ?></small>
                        </div>
                    </div>
                    <i class="fi fi-rr-quote-right quote-icon"></i>
                </div>

                <div class="bubble-content">
                    <p class="comic-neue-regular">
                        <?php
                        if (!empty($temoignage['reponse'])) {
                            echo '"' . htmlspecialchars(substr($temoignage['reponse'], 0, 110)) . '..."';
                        } else {
                            echo "Un moment de solidarité inoubliable avec Sterna Africa.";
                        }
                        ?>
                    </p>
                    <span class="read-more-btn">Lire le récit <i class="fi fi-rr-arrow-small-right"></i></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    /* Container de défilement */
    .testimonial-scroll-area {
        overflow-x: auto;
        scrollbar-width: none;
        padding: 40px 15px;
    }

    .testimonial-scroll-area::-webkit-scrollbar {
        display: none;
    }

    .testimonial-track {
        display: flex;
        gap: 25px;
        width: max-content;
    }

    /* La Bulle de Témoignage */
    .testimonial-bubble {
        flex: 0 0 auto;
        width: 320px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 30px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        backdrop-filter: blur(12px);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .testimonial-bubble:hover {
        transform: translateY(-12px) scale(1.02);
        background: rgba(255, 255, 255, 0.08);
        border-color: #f5b904;
        /* Jaune Sterna au survol */
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    }

    /* Header de la bulle */
    .bubble-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #305196;
        /* Bleu Sterna */
    }

    .user-name {
        display: block;
        font-weight: 800;
        color: #fff;
        font-size: 15px;
    }

    .time-ago {
        color: #94a3b8;
        font-size: 11px;
    }

    .quote-icon {
        color: rgba(245, 185, 4, 0.3);
        font-size: 24px;
    }

    /* Contenu */
    .bubble-content p {
        color: #cbd5e1;
        font-style: italic;
        line-height: 1.5;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .read-more-btn {
        font-size: 12px;
        color: #f5b904;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .testimonial-bubble:hover .read-more-btn {
        gap: 10px;
    }
</style>