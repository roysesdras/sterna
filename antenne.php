<?php
ob_start();
session_start();
require_once __DIR__ . '/config/db.php';

// 1. Récupération du slug depuis l'URL
if (!isset($_GET['nom']) || empty($_GET['nom'])) {
    header("Location: /");
    exit();
}
$antenne_slug = $_GET['nom'];

// 2. Recherche du nom réel dans la DB
$stmt = $conn->prepare("
    SELECT id, nom FROM antennes 
    WHERE 
        LOWER(nom) = ? 
        OR REPLACE(REPLACE(LOWER(nom), ' ', '-'), '\'', '') LIKE ?
");

$search_term = str_replace('-', '%', $antenne_slug); 

$stmt->bind_param("ss", $antenne_slug, $search_term);
$stmt->execute();
$antenne = $stmt->get_result()->fetch_assoc();

if (!$antenne) {
    $stmt = $conn->prepare("SELECT id, nom FROM antennes WHERE nom LIKE ? LIMIT 1");
    $term = "%" . $antenne_slug . "%";
    $stmt->bind_param("s", $term);
    $stmt->execute();
    $antenne = $stmt->get_result()->fetch_assoc();
}

if (!$antenne) {
    header("Location: /");
    exit();
}

$nom_antenne_db = $antenne['nom'];
$antenne_id = $antenne['id'];

// --- DONNÉES DE L'ANTENNE ---
$contenu_pays = [
    "Ivoire" => [
        "texte" => "La Côte d'Ivoire, carrefour d'Afrique de l'Ouest, combine une diversité géographique, entre forêt tropicale au sud et savane au nord, et une économie agricole forte, portée notamment par le cacao. Face aux défis environnementaux et sociaux, Sterna Africa y est pleinement présente et active. Sur le terrain, l'organisation s'engage concrètement pour un développement durable et inclusif en phase avec les ODD.",
        "image" => "/images/antennes/map_ci_accurate_1786357337647.jpg"
    ],
    "Bénin" => [
        "texte" => "Le Bénin, terre d'Afrique de l'Ouest, allie une richesse historique et culturelle unique, des palais d'Abomey à la côte de Ouidah, à une diversité géographique qui s'étend des savanes de l'Atacora au nord jusqu'aux lagunes du sud. Ancrée sur ce territoire, Sterna Africa y agit activement au cœur des communautés, en renforçant l'éducation, la santé, l'autonomisation par le volontariat et la valorisation locale pour bâtir un avenir solidaire et durable.",
        "image" => "/images/antennes/map_benin_1786355531904.jpg"
    ],
    "France" => [
        "texte" => "La France, cœur dynamique de l’Europe, se distingue par sa diversité géographique, des côtes atlantiques aux sommets alpins, et son héritage culturel riche, porté par des villes vibrantes comme Paris, Lyon et Marseille. Forte de son rôle international, elle est un carrefour d’échanges, de savoirs et de solidarité. Dans ce contexte, l’antenne française de Sterna Africa, créée en 2024, agit comme un pont entre l’Europe et l’Afrique.",
        "image" => "/images/antennes/map_france_1786355566818.jpg"
    ],
    "Burkina" => [
        "texte" => "Le Burkina Faso, pays des hommes intègres au cœur du Sahel, possède une richesse culturelle immense, une forte résilience et une jeunesse particulièrement dynamique et créative. Malgré les défis climatiques et les contraintes économiques, le pays avance avec force grâce à la solidarité locale, au travail de la terre et à l'ingéniosité de ses habitants. Sterna Africa agit aux côtés des communautés locales pour soutenir le développement communautaire.",
        "image" => "/images/antennes/map_burkina_accurate_1786357329682.jpg"
    ],
    "Togo" => [
        "texte" => "Le Togo, pays d'Afrique de l'Ouest, se distingue par une belle diversité géographique, allant du sud côtier et dynamique jusqu'au nord rural et authentique où l'agriculture joue un rôle clé. Ancrée sur ce territoire, Sterna Africa agit directement pour soutenir les populations à travers des actions alignées sur les Objectifs de Développement Durable : sécurité alimentaire, sensibilisation sanitaire, accès à l'éducation et autonomisation des femmes, afin de bâtir un avenir équitable, inclusif et durable.",
        "image" => "/images/antennes/map_togo_accurate_1786357321450.jpg"
    ]
];

$contenu_actu = [
    "texte" => "Découvrez nos antennes et nos actions à travers le monde. Sterna Africa s'engage pour le développement durable en mobilisant les communautés locales.",
    "image" => "/images/antennes/map_benin_1786355531904.jpg" // Default fallback
];

foreach ($contenu_pays as $pays => $data) {
    if (stripos($nom_antenne_db, $pays) !== false) {
        $contenu_actu = $data;
        break;
    }
}

// 3. Récupération des actualités
$stmt = $conn->prepare("SELECT * FROM actualites WHERE antenne_id = ? ORDER BY start_date DESC");
$stmt->bind_param("i", $antenne_id);
$stmt->execute();
$actualites = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$page_title = "Antenne de " . htmlspecialchars($nom_antenne_db) . " - Sterna Africa";
?>

<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>

    <link href="/assets/img/external/84e554fe99_sternaofficiel-2.png" rel="icon">
    <link href="/assets/img/external/84e554fe99_sternaofficiel-2.png" rel="apple-touch-icon">

    <!-- Open Graph / Réseaux Sociaux -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://sternaafrica.org/antenne.php?nom=<?= urlencode($nom_antenne_db) ?>">
    <meta property="og:title" content="<?= $page_title ?>">
    <meta property="og:description" content="<?= htmlspecialchars(mb_substr($contenu_actu['texte'], 0, 160)) ?>...">
    <meta property="og:image" content="https://sternaafrica.org<?= $contenu_actu['image'] ?>">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://sternaafrica.org/antenne.php?nom=<?= urlencode($nom_antenne_db) ?>">
    <meta property="twitter:title" content="<?= $page_title ?>">
    <meta property="twitter:description" content="<?= htmlspecialchars(mb_substr($contenu_actu['texte'], 0, 160)) ?>...">
    <meta property="twitter:image" content="https://sternaafrica.org<?= $contenu_actu['image'] ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        'sterna-blue': '#034890',
                        'sterna-yellow': '#fcb900',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 antialiased selection:bg-sterna-yellow selection:text-sterna-blue overflow-x-hidden">

    <?php include __DIR__ . '/config/nav.php'; ?>

    <main>
        <!-- HERO SECTION -->
        <section class="relative h-[60vh] md:h-[70vh] w-full flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img src="<?= $contenu_actu['image'] ?>" alt="<?= htmlspecialchars($nom_antenne_db) ?>" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-sterna-blue/70 mix-blend-multiply"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-gray-50 via-transparent to-transparent opacity-90"></div>
            </div>

            <div class="relative z-10 text-center px-4 max-w-4xl mx-auto mt-20">
                <span class="inline-block px-4 py-1 rounded-full bg-sterna-yellow text-sterna-blue font-bold text-sm tracking-widest uppercase mb-6 shadow-lg transform -translate-y-4 animate-[fade-in-up_0.8s_ease-out_forwards]">
                    Nos Antennes
                </span>
                <h1 class="text-5xl md:text-7xl font-black text-white mb-6 uppercase tracking-tight leading-none drop-shadow-xl">
                    <span class="block text-3xl md:text-5xl font-semibold mb-2">Antenne</span>
                    <?= htmlspecialchars($nom_antenne_db) ?>
                </h1>
                <div class="w-24 h-2 bg-sterna-yellow mx-auto mb-8 rounded-full"></div>
            </div>
        </section>

        <!-- DESCRIPTION SECTION -->
        <section class="py-16 bg-gray-100 relative -mt-20 z-20 px-4">
            <div class="max-w-4xl mx-auto bg-gray-100 rounded-3xl shadow-xl p-4 md:p-8">
                <i class="fi fi-rr-quote-right text-4xl text-sterna-yellow/30 absolute top-12 left-8 md:left-12"></i>
                <p class="text-lg md:text-xl text-gray-700 leading-relaxed font-medium relative z-10 pt-4">
                    <?= nl2br(htmlspecialchars($contenu_actu['texte'])) ?>
                </p>
            </div>
        </section>

        <!-- ACTUALITÉS SECTION -->
        <section class="py-10 px-4 max-w-7xl mx-auto">
            <div class="flex items-center gap-4 mb-12">
                <h2 class="text-4xl font-black text-sterna-blue uppercase tracking-tight">
                    Actualités & <span class="text-sterna-yellow">Événements</span>
                </h2>
                <div class="h-1 flex-1 bg-gray-200 rounded-full"></div>
            </div>

            <?php if (count($actualites) > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($actualites as $actu): 
                        $actualite_link = "/actualite/" . $actu['id'];
                        $title = strip_tags(html_entity_decode($actu['title']));
                        $short_title = (mb_strlen($title) > 60) ? mb_substr($title, 0, 60) . '...' : $title;
                        
                        // Default image if missing
                        $img_src = !empty($actu['image']) ? "/images/" . htmlspecialchars($actu['image']) : "https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop";
                    ?>
                        <article class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 group cursor-pointer flex flex-col h-full border" onclick="window.location.href='<?= $actualite_link ?>'">
                            <!-- Image -->
                            <div class="h-56 relative overflow-hidden shrink-0">
                                <img src="<?= $img_src ?>" alt="<?= htmlspecialchars($title) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop';">
                                <div class="absolute inset-0 bg-sterna-blue/0 group-hover:bg-sterna-blue/20 transition-colors duration-300"></div>
                                <div class="absolute top-4 left-4">
                                    <span class="bg-sterna-yellow/90 backdrop-blur-sm text-sterna-blue text-[10px] font-black px-3 py-1.5 rounded-full shadow-md uppercase tracking-widest">
                                        <?= date('d M Y', strtotime($actu['end_date'])) ?>
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-6 flex flex-col flex-1">
                                <span class="text-sterna-yellow font-bold text-[11px] uppercase tracking-widest mb-3 flex items-center gap-2">
                                    <i class="fi fi-rr-marker"></i> <?= htmlspecialchars($actu['lieu']) ?>
                                </span>
                                <h3 class="text-xl font-bold text-gray-900 mb-4 leading-tight group-hover:text-sterna-blue transition-colors">
                                    <?= $short_title ?>
                                </h3>
                                <p class="text-gray-500 text-sm line-clamp-3 mb-6 flex-1">
                                    <?php 
                                        $desc_text = strip_tags(html_entity_decode($actu['description'] ?? ''));
                                        if (mb_strlen($desc_text) > 150) {
                                            echo mb_substr($desc_text, 0, 150) . '...';
                                        } else if (!empty($desc_text)) {
                                            echo $desc_text;
                                        } else {
                                            echo "Découvrez les détails de notre action à " . htmlspecialchars($actu['lieu']) . ".";
                                        }
                                    ?>
                                </p>
                                
                                <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between items-center text-sm font-bold text-sterna-blue">
                                    <span>Lire la suite</span>
                                    <i class="fi fi-rr-arrow-right transform group-hover:translate-x-2 transition-transform"></i>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="bg-gray-100 rounded-2xl p-12 text-center border border-gray-200">
                    <i class="fi fi-rr-info text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">Aucune actualité</h3>
                    <p class="text-gray-500">Il n'y a pas encore d'actualités publiées pour cette antenne.</p>
                </div>
            <?php endif; ?>
        </section>

    </main>

    <?php include __DIR__ . '/config/footer_2.php'; ?>

</body>
</html>
