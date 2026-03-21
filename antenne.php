<?php
ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// 1. Récupération du slug depuis l'URL
if (!isset($_GET['nom']) || empty($_GET['nom'])) {
    die("Antenne non spécifiée.");
}
$antenne_slug = $_GET['nom'];

// 2. Recherche du nom réel dans la DB (Version compatible avec les slugs)
// On nettoie la recherche pour ignorer les accents et les apostrophes au niveau SQL
$stmt = $conn->prepare("
    SELECT id, nom FROM antennes 
    WHERE 
        LOWER(nom) = ? 
        OR REPLACE(REPLACE(LOWER(nom), ' ', '-'), '\'', '') LIKE ?
");

// On prépare une version "propre" de la recherche (ex: on transforme cote-ivoire en cote%ivoire)
$search_term = str_replace('-', '%', $antenne_slug); 

$stmt->bind_param("ss", $antenne_slug, $search_term);
$stmt->execute();
$antenne = $stmt->get_result()->fetch_assoc();

if (!$antenne) {
    // Si vraiment on ne trouve rien, on essaie une recherche ultra-large
    $stmt = $conn->prepare("SELECT id, nom FROM antennes WHERE nom LIKE ? LIMIT 1");
    $term = "%" . $antenne_slug . "%";
    $stmt->bind_param("s", $term);
    $stmt->execute();
    $antenne = $stmt->get_result()->fetch_assoc();
}

if (!$antenne) {
    die("Antenne introuvable : " . htmlspecialchars($antenne_slug));
}

// --- LOGIQUE POUR LE TEXTE DESCRIPTIF (Le tableau manuel) ---

$contenu_pays = [
    "Côte Ivoire" => [
        "texte" => "La Côte d’Ivoire est un pays d’Afrique de l’Ouest bordé par l’océan Atlantique, caractérisé par une grande diversité géographique et climatique : un sud équatorial humide dominé par la forêt tropicale et un nord tropical plus sec marqué par la savane. Cette diversité influence fortement l’agriculture, avec le cacao, le café et les fruits tropicaux au sud, et les cultures vivrières comme le riz, le mil et l’arachide au nord. Premier producteur mondial de cacao, le pays joue un rôle économique majeur, tout en faisant face à des défis environnementaux liés à la déforestation. Parallèlement, la Côte d’Ivoire s’engage activement dans la réalisation des Objectifs de Développement Durable, notamment la lutte contre la pauvreté, l’amélioration de la santé, l’accès à l’éducation et la promotion de l’égalité des sexes, afin de construire un développement plus inclusif et durable.",
        "image" => "/assets/img/antenne/cotedivoire.gif"
    ],
    "Bénin" => [
        "texte" => "Le Bénin est un pays d’Afrique de l’Ouest reconnu pour sa diversité géographique, culturelle et historique, allant des savanes et montagnes de l’Atacora au nord aux lagunes et zones côtières du sud. Berceau du Vodun et riche d’un patrimoine majeur comme les palais royaux d’Abomey et la route de l’esclavage à Ouidah, il incarne une forte identité culturelle où traditions et modernité coexistent. À travers des actions de développement communautaire, notamment celles menées par Sterna Africa, le pays renforce l’éducation, la santé, l’agriculture durable et l’autonomisation des jeunes, en s’appuyant sur le volontariat, la formation et la valorisation de l’artisanat local pour bâtir un avenir plus solidaire et durable.",
        "image" => "/assets/img/antenne/benin.jpg"
    ],
    "France" => [
        "texte" => "La France est un pays majeur de l’Union européenne, reconnu pour sa diversité géographique, culturelle et son influence internationale, avec des territoires allant des Alpes aux littoraux méditerranéens et atlantiques. Forte d’une population multiculturelle et de villes dynamiques comme Paris, Lyon ou Marseille, elle joue un rôle central dans les domaines culturel, économique et politique. Dans ce contexte stratégique, l’antenne française de STERNA AFRICA, créée en 2024, renforce l’action de l’organisation en Europe en soutenant les Objectifs de Développement Durable, notamment l’éducation, la santé, la lutte contre la pauvreté et la protection de l’environnement. À travers des partenariats, des formations, des campagnes de sensibilisation et des actions de solidarité, cette antenne contribue à renforcer la coopération entre la France et les pays africains, au service d’un développement durable et inclusif.",
        "image" => "/assets/img/antenne/France.gif"
    ],
    "Burkina-Faso" => [
        "texte" => "Le Burkina Faso est un pays enclavé d’Afrique de l’Ouest au climat sahélien, fortement dépendant de l’agriculture et confronté à des défis majeurs tels que la sécheresse, la pauvreté, l’accès limité à l’éducation, à la santé et aux ressources naturelles. Sa population, très jeune et en forte croissance, fait de l’éducation, de l’emploi et de l’égalité des sexes des enjeux prioritaires, notamment en milieu rural. L’économie repose principalement sur les cultures vivrières, le coton, le secteur informel et l’exploitation de l’or, mais reste fragile face aux contraintes environnementales. Dans ce contexte, nos actions s’inscrivent dans la mise en œuvre des Objectifs de Développement Durable, en agissant sur la lutte contre la pauvreté, l’amélioration de la santé, l’accès à une éducation inclusive, l’autonomisation des femmes et la sensibilisation au changement climatique, afin de renforcer la résilience des communautés et soutenir un développement durable et équitable.",
        "image" => "/assets/img/antenne/burkina.jpg"
    ],
    "Togo" => [
        "texte" => "
            Le Togo est un pays d’Afrique de l’Ouest marqué par une forte diversité géographique et climatique, avec un sud côtier plus urbanisé autour de Lomé et un nord majoritairement rural, où l’agriculture demeure centrale. Malgré un potentiel agricole et économique réel, le pays fait face à des inégalités de développement, à des défis persistants en matière de santé, d’éducation et d’égalité des sexes, particulièrement dans les zones rurales. Dans ce contexte, STERNA AFRICA intervient pour soutenir les communautés vulnérables à travers des actions alignées sur les Objectifs de Développement Durable, notamment la lutte contre la pauvreté, la sécurité alimentaire, la sensibilisation sanitaire, l’accès à l’éducation et l’autonomisation des femmes, afin de favoriser un développement inclusif, équitable et durable.",
        "image" => "/assets/img/antenne/togo.gif"
    ]
];

$contenu_defaut = [
    "texte" => "Découvrez nos antennes et nos actions à travers le monde.",
    "image" => "/assets/img/antenne/default.jpg"
];

// On cherche le texte correspondant au NOM récupéré dans la DB
$nom_antenne_db = $antenne['nom']; // ex: "Bénin"
$contenu_actu = $contenu_defaut;

foreach ($contenu_pays as $pays => $data) {
    // On compare le nom de la DB avec les clés du tableau
    if (stripos($nom_antenne_db, $pays) !== false) {
        $contenu_actu = $data;
        break;
    }
}

// 3. Récupération des actualités (pour la suite de la page)
$antenne_id = $antenne['id'];
$stmt = $conn->prepare("SELECT * FROM actualites WHERE antenne_id = ? ORDER BY start_date DESC");
$stmt->bind_param("i", $antenne_id);
$stmt->execute();
$actualites = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<html lang="fr" data-bs-theme="auto">

<head>
    <!-- <script src="https://sternaafrica.org/assets/js/color-modes.js"></script> -->
    <meta charset="UTF-8">
    <!-- meta for SEO -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index">
    <meta name="robots" content="follow">

    <title>Antenne - <?= htmlspecialchars($antenne['nom']) ?> : Sternaafrica</title>

    <meta name="description" content=" Actualités - <?= htmlspecialchars($antenne['nom']) ?>" />
    <meta property="og:description" content="Découvrez les actions et actualités de l'antenne <?= htmlspecialchars($antenne['nom']) ?> de Sterna Africa, engagée dans l'Éducation à la Citoyenneté et à la Solidarité Internationale'">

    <!-- meta for og.graph -->
    <meta property="og:title" content="Antenne - <?= htmlspecialchars($antenne['nom']) ?>" />
    <meta property="og:description" content="Découvrez les actions et actualités de l'antenne <?= htmlspecialchars($antenne['nom']) ?> de Sterna Africa, engagée dans l'Éducation à la Citoyenneté et à la Solidarité Internationale'">
    <meta property="og:image" content="https://sternaafrica.org/images/<?= strtolower($antenne['nom']) ?>.jpg" />
    <meta property="og:url" content="https://sternaafrica.org/antenne/<?= urlencode($antenne_slug) ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="Sternaafrica" />

    <!-- Favicons -->
    <link href="https://sternaafrica.org/assets/img/logos/sternaofficiel-2.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/logos/sternaofficiel-2.png" rel="apple-touch-icon">

    <link rel="canonical" href="https://sternaafrica.org/antenne/<?= urlencode($antenne_slug) ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/assets/styles.css">

    <!-- Start cookieyes banner -->
    <script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/495fc865e66d221c0516bda6/script.js"></script> <!-- End cookieyes banner -->

</head>

<body>
    <?php
    require_once('config/navbar.php');
    ?>

    <div class="container-fluid custom-padding-top mb-2">
        <h3 class="custom-title">
            Antenne : <?= !empty($antenne['nom']) ? htmlspecialchars($antenne['nom']) : "Antenne inconnue"; ?>
        </h3>
    </div>

    <div class="container">

        <?php
        // Définition des couleurs de fond par pays
        $classes = [
            "Côte Ivoire" => "bg-custom-yellow",
            "Bénin" => "bg-custom-blue", // Correction ici
            "France" => "bg-custom-blue",
            "Burkina-Faso" => "bg-custom-yellow",
            "Togo" => "bg-custom-yellow"
        ];

        ?>

        <style>
            .bg-custom-blue {
                background-color: #305196 !important;
                color: #fff !important;
                /* Assure que le texte est bien blanc */
            }

            .bg-custom-yellow {
                background-color: #f5b904 !important;
                color: #000 !important;
                /* Assure que le texte est bien noir */
            }

            .text-white {
                color: #fff !important;
            }

            .custom-padding-top {
                padding-top: 70px;
                /* par défaut */
            }

            /* Pour les écrans de smartphone */
            @media (max-width: 767px) {
                .custom-padding-top {
                    padding-top: 75px;
                    /* ou une valeur qui te convient */
                }
            }
        </style>

        <div class="row">
            <?php if (count($actualites) > 0) : ?>
                <?php foreach ($actualites as $actu) : ?>
                    <?php
                    $lieu = htmlspecialchars($actu['lieu']);
                    $classe_bg = "bg-gray-500"; // Couleur par défaut

                    // Vérifier si un pays est contenu dans le lieu
                    foreach ($classes as $pays => $couleur) {
                        if (stripos($lieu, $pays) !== false) {
                            $classe_bg = $couleur;
                            break;
                        }
                    }

                    // Vérifier et générer le chemin de l'image
                    $image_path = !empty($actu['image']) ? "/images/" . htmlspecialchars($actu['image']) : "/images/default.png";
                    ?>

                    <!-- Affichage en 3 colonnes Bootstrap -->
                    <div class="col-md-3 mb-3">
                        <a href="../actualite/<?php echo $actu['id']; ?>" class="text-decoration-none text-dark">

                            <div class="card" style="box-shadow: rgba(6, 24, 44, 0.4) 0px 0px 0px 2px, rgba(6, 24, 44, 0.65) 0px 4px 6px -1px, rgba(255, 255, 255, 0.08) 0px 1px 0px inset;">
                                <img src="<?= $image_path ?>" alt="<?= htmlspecialchars($actu['title']) ?>" class="card-img-top w-100" style="height: 150px; object-fit: cover;">
                                <div class="card-body">
                                    <small class="text-muted comic-neue-regular">Publié le <?= date('d M Y', strtotime($actu['start_date'])) ?></small>

                                    <span class="badge <?= $classe_bg; ?> text-dark px-2 py-1">
                                        <?= $lieu; ?>
                                    </span>

                                    <div class="card-title comic-neue-regular"><?= htmlspecialchars($actu['title']) ?></div>

                                    <!-- <p class="card-text"> 
                                        <?= htmlspecialchars(substr(strip_tags($actu['description']), 0, 60)); ?>...
                                    </p> -->

                                </div>

                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-12">
                    <p>Aucune actualité disponible pour cette antenne.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Texte et image dynamiques selon le pays -->
    <div class="container-fluid mb-4">
        <div class="row mt-3">
            <div class="col-md-8">
                <p class="comic-neue-regular"><?= $contenu_actu['texte']; ?></p>
            </div>

            <div class="col-md-4">
                <img src="<?= $contenu_actu['image']; ?>" alt="Illustration" class="w-100 rounded mb-2" style="object-fit: cover;">
            </div>

        </div>
    </div>


    <?php require_once('./config/footer_2.php'); ?>
</body>

</html>