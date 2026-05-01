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

<section class="py-15 mt-20 overflow-hidden" id="stories">
    <div class="max-w-7xl mx-auto px-6 mb-2 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h2 class="text-4xl font-black text-sterna-blue uppercase tracking-tighter border-l-8 border-sterna-orange pl-6">
                Récits de <span class="text-sterna-orange">Solidarité</span>
            </h2>
            
        </div>
        
        <div class="hidden md:flex gap-4">
            <button onclick="document.querySelector('.testimonial-scroll-area').scrollBy({left: -350, behavior: 'smooth'})" class="nav-btn">
                <i class="fi fi-rr-arrow-small-left"></i>
            </button>
            <button onclick="document.querySelector('.testimonial-scroll-area').scrollBy({left: 350, behavior: 'smooth'})" class="nav-btn">
                <i class="fi fi-rr-arrow-small-right"></i>
            </button>
        </div>
    </div>

    <div class="testimonial-scroll-area">
        <div class="testimonial-track">
            <?php foreach ($temoignages as $temoignage): ?>
                <?php
                $photoPath = "../assets/img/avatar-default.jpg";
                if (!empty($temoignage['is_volontaire']) && !empty($temoignage['volontaire_avatar'])) {
                    $fileName = basename(trim($temoignage['volontaire_avatar']));
                    $photoPath = "https://monespacevolontaire.sternaafrica.org/uploads/" . $fileName;
                } elseif (!empty($temoignage['photo'])) {
                    $photoPath = "../uploads/" . basename(trim($temoignage['photo']));
                }
                ?>

                <div class="testimonial-card group" onclick="window.location.href='../temoignage/<?= $temoignage['id']; ?>'">
                    <div class="card-inner">
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex items-center gap-4">
                                <div class="avatar-wrapper">
                                    <img src="<?= $photoPath; ?>" alt="Avatar" class="avatar-img">
                                </div>
                                <div>
                                    <h4 class="text-[15px] font-black text-sterna-blue uppercase leading-none mb-1">
                                        <?= htmlspecialchars($temoignage['nom']); ?>
                                    </h4>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                        <?= time_elapsed_string($temoignage['date_submis']); ?>
                                    </span>
                                </div>
                            </div>
                            <i class="fi fi-rr-quote-right text-3xl text-gray-100 group-hover:text-urunani-rose/20 transition-colors"></i>
                        </div>

                        <div class="testimonial-content">
                            <p class="text-gray-600 text-md leading-relaxed italic mb-4">
                                <?php
                                if (!empty($temoignage['reponse'])) {
                                    echo '"' . htmlspecialchars(substr($temoignage['reponse'], 0, 130)) . '..."';
                                } else {
                                    echo "Un moment de solidarité inoubliable avec Sterna Africa, riche en émotions et en partages.";
                                }
                                ?>
                            </p>
                        </div>

                        <div class="pt-2 border-t border-slate-200 flex items-center justify-between">
                            <span class="text-[11px] font-black text-urunani-orange uppercase tracking-wider group-hover:translate-x-2 transition-transform duration-300">
                                Lire le récit <i class="fi fi-rr-arrow-small-right ml-1"></i>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
    /* Navigation boutons */
    .nav-btn {
        width: 45px;
        height: 45px;
        border-radius: 15px;
        background: white;
        color: #0f277e;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    .nav-btn:hover {
        background: #ea7d0fff;
        color: white;
        border-color: #ea7d0fff;
        transform: translateY(-2px);
    }

    /* Scroll Area */
    .testimonial-scroll-area {
        overflow-x: auto;
        padding: 20px 6% 60px 6%;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* IE/Edge */
    }
    .testimonial-scroll-area::-webkit-scrollbar {
        display: none; /* Chrome/Safari */
    }

    .testimonial-track {
        display: flex;
        gap: 30px;
        width: max-content;
    }

    /* La Carte */
    .testimonial-card {
        flex: 0 0 auto;
        width: 340px;
        background: white;
        border-radius: 20px;
        padding: 15px;
        cursor: pointer;
        position: relative;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .testimonial-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 30px 60px rgba(15, 39, 126, 0.1);
        border-color: #ea7d0fff;
    }

    /* Avatar Design */
    .avatar-wrapper {
        position: relative;
        width: 55px;
        height: 55px;
    }
    .avatar-img {
        width: 100%;
        height: 100%;
        border-radius: 10px;
        object-fit: cover;
        
    }

    /* Content */
    .testimonial-content p {
        position: relative;
        z-index: 2;
    }

    @media (max-width: 768px) {
        .testimonial-card {
            width: 290px;
            padding: 20px;
        }
    }
</style>