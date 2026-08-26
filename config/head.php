<?php
$page_title = isset($page_title) ? $page_title : "Sterna Africa - Association d'Éducation à la Citoyenneté et à la Solidarité Internationale (ECSI)";
$page_desc = isset($page_desc) ? $page_desc : "Sterna Africa : Association d'Éducation à la Citoyenneté et à la Solidarité Internationale (ECSI), engagée sur le continent africain et au-delà. Implantée au Bénin, en Côte d’Ivoire, au Burkina Faso et au Togo, elle a étendu son rayon d’action en ouvrant une antenne à Lyon (France) en 2024.";
$page_image = isset($page_image) ? $page_image : "https://sternaafrica.org/images/garde.jpg";
$page_url = isset($page_url) ? $page_url : "https://sternaafrica.org" . $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page_desc); ?>">
    <meta name="keywords" content="Sterna Africa, ECSI, solidarité internationale, éducation citoyenneté, Bénin, Côte d'Ivoire, Togo, Burkina Faso, Lyon">
    <link rel="canonical" href="<?php echo htmlspecialchars($page_url); ?>">

    <meta property="og:type" content="article">
    <meta property="og:url" content="<?php echo htmlspecialchars($page_url); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($page_desc); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($page_image); ?>">
    <meta property="og:site_name" content="sternaafrica">
    <meta property="og:locale" content="fr_FR">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo htmlspecialchars($page_url); ?>">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($page_desc); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($page_image); ?>">

    <link href="/assets/img/external/84e554fe99_sternaofficiel-2.png" rel="icon">
    <link href="/assets/img/external/84e554fe99_sternaofficiel-2.png" rel="apple-touch-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cabin+Sketch:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Flaticon Uicons -->
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.1.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.1.0/uicons-brands/css/uicons-brands.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./assets/styles.css">

    <style>
        /* Application globale de la police Cabin Sketch pour tous les titres */
        h1, h2, h3, h4, h5, h6, .cabin-sketch-regular, .elementor-heading-title {
            font-family: "Cabin Sketch", sans-serif !important;
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sterna-blue': '#034890',
                        'sterna-yellow': '#e4a60aff',
                        'sterna-green': '#eaf0edff',
                    },
                    fontFamily: {
                        'sans': ['Quicksand', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>