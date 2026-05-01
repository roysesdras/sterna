<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
session_cache_limiter('public');
session_start();

require_once('../config/db.php');

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    // On récupère les jours totaux pour calculer les semaines
    $days = $diff->d;
    $weeks = floor($days / 7);
    $remaining_days = $days % 7;

    $string = [
        'y' => ['val' => $diff->y, 'label' => 'an'],
        'm' => ['val' => $diff->m, 'label' => 'mois'],
        'w' => ['val' => $weeks,   'label' => 'semaine'],
        'd' => ['val' => $remaining_days, 'label' => 'jour'],
        'h' => ['val' => $diff->h, 'label' => 'heure'],
        'i' => ['val' => $diff->i, 'label' => 'minute'],
        's' => ['val' => $diff->s, 'label' => 'seconde'],
    ];

    $result = [];
    foreach ($string as $k => $info) {
        if ($info['val'] > 0) {
            // Gestion du pluriel : 'mois' est invariable, les autres prennent un 's'
            $plural = ($info['val'] > 1 && $k !== 'm') ? 's' : '';
            $result[] = $info['val'] . ' ' . $info['label'] . $plural;
        }
    }

    if (!$full) {
        $result = array_slice($result, 0, 1);
    }

    return $result ? 'il y a ' . implode(', ', $result) : 'à l’instant';
}

// Vérifie si l'identifiant de l'actualité est passé dans l'URL
if (!isset($_GET['id'])) {
    header('Location: admin_actualites.php'); // Redirige si l'identifiant n'est pas spécifié
    exit();
}

// Connexion à la base de données
$conn = new mysqli('db', 'root', 'SoftiP24', 'africa_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupère l'identifiant de l'actualité depuis l'URL (assure-toi de filtrer et de valider cette valeur)
$actualite_id = $_GET['id'];

// Requête SQL pour récupérer les détails de l'actualité
$sql = "SELECT id, title, DATE_FORMAT(start_date, '%Y-%m-%d') as start_date, end_date, description, image, views 
FROM actualites WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $actualite_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $title = htmlspecialchars(html_entity_decode($row['title']));
    $start_date = htmlspecialchars($row['start_date']);
    $end_date = htmlspecialchars($row['end_date']);
    $description = $row['description'];
    $image = htmlspecialchars($row['image']);
    $views = (int)$row['views'];  // Sécurisation

    // Empêche le comptage multiple de vues dans une même session
    $session_key = 'viewed_actualite_' . $actualite_id;

    if (!isset($_SESSION[$session_key])) {
        // Incrémente une seule fois
        $update_sql = "UPDATE actualites SET views = views + 1 WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $actualite_id);
        $update_stmt->execute();

        // Marque cette actualité comme "vue" dans la session
        $_SESSION[$session_key] = true;

        // Met à jour la valeur locale pour affichage
        $views++;
    }


    // Fonction pour extraire les images insérées via TinyMCE
    function extractImagesFromDescription($description)
    {
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
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <title><?php echo $title; ?> | sternaafrica</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="index, follow">
        <meta name="description" content="<?php echo htmlspecialchars($description_excerpt); ?>">

        <meta property="og:locale" content="fr_FR" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?php echo $title; ?>" />
        <meta property="og:description" content="<?php echo htmlspecialchars($description_excerpt); ?>" />
        <meta property="og:url" content="https://sternaafrica.org/actualite/<?php echo $actualite_id; ?>" />
        <meta property="og:site_name" content="Sterna Africa" />
        <meta property="og:image" content="https://sternaafrica.org/images/<?php echo $image; ?>" />
        <meta property="og:image:secure_url" content="https://sternaafrica.org/images/<?php echo $image; ?>" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />
        <meta property="og:image:type" content="image/jpeg" />

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@sternaafrica">
        <meta name="twitter:title" content="<?php echo $title; ?>">
        <meta name="twitter:description" content="<?php echo htmlspecialchars($description_excerpt); ?>">
        <meta name="twitter:url" content="https://sternaafrica.org/actualite/<?php echo $actualite_id; ?>">
        <meta name="twitter:image" content="https://sternaafrica.org/images/<?php echo $image; ?>">

        <link href="../assets/img/logos/sternaofficiel-2.png" rel="icon">
        <link href="../assets/img/logos/sternaofficiel-2.png" rel="apple-touch-icon">
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.tailwindcss.com?plugins=typography"></script>

        <script src="https://stats.digiroys.com/tracker.js" data-key="key_sterna_123"></script>

        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            sternaBlue: '#305196',
                            sternaYellow: '#f5b904',
                            darkBg: '#05070A',
                            darkCard: '#0F172A',
                        },
                        fontFamily: {
                            // comic: ['Comic Neue', 'cursive'],
                        }
                    }
                }
            }
        </script>

        <!-- <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&display=swap" rel="stylesheet"> -->

        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <!-- <link rel="stylesheet" href="../assets/styles.css"> -->

        <style type="text/tailwindcss">
            @layer base {
                body {
                    @apply bg-gray-200 text-gray-800 antialiased selection:bg-[#ea750fff]/30;
                }
            }
            @layer components {
                .glass-card {
                    @apply bg-white border border-gray-200 shadow-sm rounded-[2rem];
                }
            }
   
            img {
                    border-radius: 15px;  
                }     
                
                /* Cible les balises <br> qui sont les frères directs d'une image */
            .prose img + br {
                display: none !important;
            }

                /* Permet aux styles inline de Summernote (couleurs, polices) de s'afficher */
            .prose [style] {
                    color: revert !important;
                    background-color: revert !important;
                    font-size: revert !important;
                }  
                /*
                .prose img {
                    display: block;
                    margin-left: auto;
                    margin-right: auto;
                     Évite que le texte ne vienne se coller sur les côtés si non désiré 
                }
                */
    </style>
    </head>

    <script>
        document.getElementById('copyLinkButton').addEventListener('click', function() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                // Animation du bouton pour confirmer
                this.innerHTML = '<i class="fas fa-check text-green-500"></i>';
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-link"></i>';
                }, 2000);
            });
        });
    </script>

    <body class="bg-gray-200 text-gray-800 antialiased selection:bg-[#ea750fff]/30">
        <main class="container mx-auto px-4 pt-05 pb-12">
            <?php // require_once('../config/nav.php'); 
            ?>
            <div class="flex flex-col lg:flex-row gap-12 max-w-6xl mx-auto">

                <aside class="lg:w-16 order-2 lg:order-1">
                    <div class="lg:sticky lg:top-32 flex lg:flex-col justify-center gap-4 bg-white p-4 rounded-3xl border border-gray-100 shadow-sm">
                        <button id="copyLinkButton" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-500 hover:bg-[#ea750fff] hover:text-white transition-all" title="Copier le lien">
                            <i class="fas fa-link"></i>
                        </button>
                        <a href="https://api.whatsapp.com/send?text=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-green-600 hover:bg-green-600 hover:text-white transition-all">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=..." target="_blank" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-blue-500 hover:bg-blue-500 hover:text-white transition-all">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=..." target="_blank" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 text-blue-800 hover:bg-blue-800 hover:text-white transition-all">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </aside>

                <article class="flex-1 order-1 lg:order-2">
                    <header class="mb-8">
                        <h1 class="comic-neue text-3xl md:text-5xl font-extrabold text-[#0f277e] leading-tight mb-6">
                            <?php echo htmlspecialchars_decode($title); ?>
                        </h1>
                        <div class="flex items-center gap-4 text-gray-500 text-sm italic">
                            <span class="flex items-center gap-2"><i class="far fa-calendar-alt text-[#ea750fff]"></i> <?= date('d M Y', strtotime($end_date)); ?></span>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span class="flex items-center gap-2"><i class="far fa-eye"></i> <?= $views; ?> lectures</span>
                        </div>
                    </header>

                    <div class="rounded-[1rem] overflow-hidden shadow-xl mb-10 ring-1 ring-gray-200">
                        <img src="../images/<?php echo $image; ?>" class="w-full h-auto object-cover" alt="<?php echo $title; ?>">
                    </div>

                    <div class="prose max-w-none comic-neue text-lg leading-relaxed text-gray-800">
                        <?php echo html_entity_decode($description); ?>
                    </div>
                </article>
            </div>

            <div class="max-w-4xl mx-auto mt-10">
                <hr class="border-gray-300 mb-10">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-16">

                    <section>
                        <h3 class="font-comic text-2xl font-bold text-[#0f277e] mb-8 flex items-center gap-3">
                            <i class="bi bi-chat-dots text-[#ea750fff]"></i> Discussions
                        </h3>

                        <div class="space-y-6 mb-10 max-h-[600px] overflow-y-auto pr-4 custom-scrollbar">
                            <?php
                            // 1. Préparation de la requête
                            $sql = "SELECT * FROM comments WHERE actualite_id = ? ORDER BY created_at DESC";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $actualite_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // 2. Vérification s'il y a des commentaires
                            if ($result && $result->num_rows > 0):
                                while ($row_comment = $result->fetch_assoc()): // Utilisation de $row_comment pour éviter les conflits
                                    $user_name = htmlspecialchars($row_comment['user_name'] ?? 'Anonyme');
                                    // On décode d'abord les entités existantes, puis on ré-encode proprement pour la sécurité
                                    $comment_clean = htmlspecialchars_decode($row_comment['comment'] ?? '', ENT_QUOTES);
                                    $comment_text = nl2br(htmlspecialchars($comment_clean, ENT_QUOTES, 'UTF-8'));
                                    $date_comment = $row_comment['created_at'];
                            ?>
                                    <div class="bg-white p-5 rounded-2xl border border-gray-200 hover:border-[#ea750fff]/50 transition-colors shadow-sm">
                                        <div class="flex justify-between items-start mb-2">
                                            <span class="text-[#0f277e] font-bold text-sm">
                                                <i class="bi bi-person-circle me-1"></i> <?php echo $user_name; ?>
                                            </span>
                                            <small class="text-gray-400 text-xs">
                                                <?php echo time_elapsed_string($date_comment); ?>
                                            </small>
                                        </div>
                                        <p class="text-gray-600 text-sm leading-relaxed">
                                            <?php echo $comment_text; ?>
                                        </p>
                                    </div>
                                <?php
                                endwhile;
                            else:
                                ?>
                                <div class="text-center py-10 border-2 border-dashed border-gray-300 rounded-3xl bg-gray-50">
                                    <i class="bi bi-chat-square-text text-3xl text-gray-400 mb-3 block"></i>
                                    <p class="text-gray-500 text-sm">Aucun commentaire pour le moment.<br>Soyez le premier à réagir !</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <form action="commentaire.php" method="POST" class="bg-white p-6 rounded-[2rem] border border-gray-200 shadow-sm">
                            <input type="hidden" name="actualite_id" value="<?php echo $actualite_id; ?>">
                            <div class="space-y-4">
                                <input type="text" name="user_name"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-gray-800 placeholder:text-gray-400 focus:border-[#ea750fff] focus:ring-1 focus:ring-[#ea750fff] outline-none transition-all"
                                    placeholder="Votre Pseudo" required>

                                <textarea name="comment"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-gray-800 placeholder:text-gray-400 focus:border-[#ea750fff] focus:ring-1 focus:ring-[#ea750fff] outline-none transition-all"
                                    rows="3" placeholder="Votre message..." required></textarea>

                                <button type="submit"
                                    class="w-full bg-[#ea750fff] hover:bg-orange-600 text-white font-black py-3 rounded-xl transition-all transform active:scale-95 shadow-lg shadow-orange-900/20">
                                    PARTAGER MON AVIS
                                </button>
                            </div>
                        </form>
                    </section>

                    <section>
                        <h3 class="font-comic text-2xl font-bold text-[#0f277e] mb-8 flex items-center gap-3">
                            <i class="fi fi-rr-heart text-[#ea750fff]"></i> Échos du terrain
                        </h3>

                        <div class="flex flex-col gap-6">
                            <?php
                            // Requête SQL (Ta logique de jointure reste identique)
                            $sql_temoignages = "
                                    SELECT t.*, 
                                        (SELECT r.reponse 
                                            FROM reponses r 
                                            WHERE r.temoignage_id = t.id 
                                            ORDER BY r.question_id ASC 
                                            LIMIT 1) AS reponse
                                    FROM temoignages t
                                    JOIN actualites_temoignages at ON t.id = at.id_temoignage
                                    WHERE at.id_actualite = ?
                                    ORDER BY t.date_submis DESC
                                ";

                            $stmt_temoignages = $conn->prepare($sql_temoignages);
                            $stmt_temoignages->bind_param("i", $actualite_id);
                            $stmt_temoignages->execute();
                            $result_temoignages = $stmt_temoignages->get_result();

                            if ($result_temoignages->num_rows > 0):
                                while ($temoignage = $result_temoignages->fetch_assoc()):
                                    // Préparation des données
                                    $raw_reponse = $temoignage['reponse'] ?? '';
                                    $excerpt = (mb_strlen($raw_reponse) > 95) ? mb_substr($raw_reponse, 0, 95) . '...' : $raw_reponse;
                                    $nom = htmlspecialchars($temoignage['nom']);
                                    $is_volontaire = $temoignage['is_volontaire'];
                                    $photo_path = "../assets/img/avatar-default.jpg"; // Défaut

                                    // Logique de l'avatar (Inchangée mais propre)
                                    if ($is_volontaire) {
                                        try {
                                            $pdo_users = new PDO('mysql:host=db;dbname=monespace', 'root', 'SoftiP24', [
                                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                                            ]);
                                            $stmt_avatar = $pdo_users->prepare("SELECT avatar FROM users WHERE id = ?");
                                            $stmt_avatar->execute([$temoignage['volontaire_id']]);
                                            $res_av = $stmt_avatar->fetch(PDO::FETCH_ASSOC);

                                            if ($res_av && !empty($res_av['avatar'])) {
                                                $avatarPath = str_replace('/uploads/', '/', $res_av['avatar']);
                                                $photo_path = "https://monespacevolontaire.sternaafrica.org/" . $avatarPath;
                                            }
                                        } catch (Exception $e) { /* Fallback au défaut si db externe échoue */
                                        }
                                    } else if (!empty($temoignage['photo'])) {
                                        $photo = $temoignage['photo'];
                                        $photo_path = (strpos($photo, 'uploads/') === false) ? "../uploads/" . $photo : "../" . $photo;
                                    }

                                    $lien_externe = "../temoignage/" . $temoignage['id'];
                            ?>
                                    <div onclick="window.location='<?= $lien_externe ?>'"
                                        class="group bg-white border border-gray-200 p-6 rounded-[2rem] hover:shadow-lg hover:border-[#ea750fff]/30 transition-all duration-300 cursor-pointer relative overflow-hidden">

                                        <i class="fas fa-quote-right absolute top-4 right-6 text-gray-100 text-4xl transition-colors"></i>

                                        <p class="font-comic text-gray-600 italic mb-6 leading-relaxed relative z-10">
                                            "<?= htmlspecialchars($excerpt) ?>"
                                            <span class="text-[#0f277e] font-bold ml-1 hover:underline">Lire la suite</span>
                                        </p>

                                        <div class="flex items-center justify-between mt-auto relative z-10">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full border-2 border-gray-200 overflow-hidden shadow-sm">
                                                    <img src="<?= $photo_path ?>" alt="<?= $nom ?>" class="w-full h-full object-cover">
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="text-[#0f277e] font-bold text-sm leading-none"><?= $nom ?></span>
                                                    <span class="text-[10px] text-gray-500 font-black uppercase tracking-widest mt-1">Participant.e</span>
                                                </div>
                                            </div>

                                            <div class="bg-gray-100 p-2 rounded-lg group-hover:bg-[#ea750fff] group-hover:text-white transition-all text-gray-500">
                                                <i class="fas fa-arrow-right text-[10px]"></i>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                endwhile;
                            else:
                                ?>
                                <div class="p-8 text-center bg-gray-50 border border-dashed border-gray-300 rounded-[2rem]">
                                    <p class="text-gray-500 italic text-sm font-comic">Aucun témoignage trouvé pour cette mission.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </section>

                </div>
            </div>
            <div class="container-fluid autre_contenu mt-20">
                <?php include_once '../config/autres_actualites.php';
                ?>
            </div>
            <?php include 'formulaire_newsletter_popup.php'; ?>
        </main>
        <?php include_once('../config/footer_2.php'); ?>
        <script>
window.addEventListener('load', function () {
    if (typeof DigiStats === 'undefined') return;
 
    // ── Identification de l'article ───────────────────────────
    // Récupère le titre et l'URL de l'article courant
    var articleTitle = document.title || document.querySelector('h1')?.textContent?.trim() || 'Sans titre';
    var articleUrl   = window.location.pathname;
 
    // ── Jalons de lecture ─────────────────────────────────────
    // 60s  = lecture sérieuse
    // 180s = article lu jusqu'au bout (équivalent step_lus du funnel)
    // 300s = lecteur très engagé
 
    var jalonsLecture = [60, 180, 300];
    jalonsLecture.forEach(function (sec) {
        setTimeout(function () {
            DigiStats.track('article_read_jalon', {
                seconds:       sec,
                article_title: articleTitle,
                article_url:   articleUrl,
                label:         sec + 's de lecture'
            });
        }, sec * 1000);
    });
 
    // ── Article lu jusqu'au bout (scroll 80% de la page) ─────
    // Complète les jalons temps avec une vraie détection de scroll
    var articleFinLu = false;
    window.addEventListener('scroll', function () {
        if (articleFinLu) return;
        var scrolled = window.scrollY + window.innerHeight;
        var total    = document.body.scrollHeight;
        if (scrolled / total >= 0.80) {
            articleFinLu = true;
            DigiStats.track('article_read_complete', {
                article_title: articleTitle,
                article_url:   articleUrl
            });
        }
    });
 
    // ── Source de trafic (depuis lien partagé) ────────────────
    // Détecte si le visiteur vient d'un lien partagé (WhatsApp, FB, etc.)
    var ref = document.referrer || '';
    var source = 'direct';
    if (ref.includes('whatsapp'))   source = 'whatsapp';
    else if (ref.includes('facebook') || ref.includes('fb.')) source = 'facebook';
    else if (ref.includes('twitter') || ref.includes('t.co')) source = 'twitter';
    else if (ref.includes('linkedin'))  source = 'linkedin';
    else if (ref.includes('t.me') || ref.includes('telegram')) source = 'telegram';
    else if (ref !== '')                source = 'autre';
 
    // On enrichit le page_view avec la source
    // (envoyé séparément pour ne pas interférer avec le page_view auto)
    if (source !== 'direct') {
        DigiStats.track('article_from_share', {
            article_title: articleTitle,
            article_url:   articleUrl,
            source:        source,
            referrer:      ref.substring(0, 100)
        });
    }
});
</script>


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