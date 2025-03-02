<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connexion à la base de données
$host = 'localhost';
$db = 'u694220522_blog_sterna';
$user = 'u694220522_sterna';
$pass = '@sterna_Africa225';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer toutes les catégories de la base de données
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Découvrez un monde d'articles captivants sur le volontariat, la culture et l'éducation. Rejoignez notre communauté pour explorer des histoires inspirantes, des conseils pratiques et des réflexions profondes qui enrichissent votre expérience de vie. Explorez, apprenez et partagez avec nous!" />

    <meta name="robots" content="index">
    <meta name="robots" content="follow">

    <!-- Favicons -->
    <link href="https://sternaafrica.org/assets/img/favicon1.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/apple-touch-icon1.png" rel="apple-touch-icon">

    <!-- meta for og.graph -->
    <meta property="og:image" content="https://blogsspreadspot.com/wp-content/uploads/2021/11/blog.jpg" />
    <meta property="og:url" content="https://blog.sternaafrica.org/" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="blog" />

    <title>Blog sterna africa</title>
    <link rel="canonical" href="https://blog.sternaafrica.org/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="blog.css">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .bd-mode-toggle {
        z-index: 1500;
      }

      .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
      }

      .nav-item.nav-link:hover {
          color: #0dcaf0;  /* Utilise la couleur info de Bootstrap */
          text-decoration: underline; /* Facultatif : ajoute une sous-ligne au survol */
      }
      
    </style>

</head>
<body data-bs-theme="dark">
  <div class="container">
    <header class="border-bottom lh-1 py-3">
      <div class="row flex-nowrap justify-content-between align-items-center">
        <div class="col-6 text-left">
          <!-- <a class="blog-header-logo text-body-emphasis text-decoration-none" href="#" translate="no">Blog sterna</a> -->
        </div>
        <div class="col-6 d-flex justify-content-end align-items-center">
          <!-- <a class="link-secondary" href="#" aria-label="Search">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"/><path d="M21 21l-5.2-5.2"/></svg>
          </a> -->
          <a class="btn btn-sm btn-outline-secondary" href="./users/login.php">Login</a>
        </div>
      </div>
    </header>

    <div class="nav-scroller py-1 mb-3 border-bottom">
      <!-- Menu de navigation dynamique -->
      <nav class="nav nav-underline justify-content-between">
          <?php foreach ($categories as $category): ?>
              <a class="nav-item nav-link link-body-emphasis" href="./pages/category.php?id=<?php echo $category['id']; ?>">
                  <?php echo htmlspecialchars($category['name']); ?>
              </a>
          <?php endforeach; ?>
      </nav>
    </div>

    <?php include_once ('inclusion/recent_post.php'); ?>
    <?php include_once ('inclusion/all_post.php'); ?>

    <div class="row">
      <div class="col-md-8">
        <h3 class="pb-4 pt-4 mb-4 fst-italic border-bottom">
          Articles to read
        </h3>
        <?php include_once ('inclusion/volontariat_post.php'); ?>
      </div>

      <div class="col-md-4">
        <div class="position-sticky" style="top: 2rem;">
          <?php include_once ('inclusion/other_post.php'); ?>
          <?php include_once ('inclusion/archives_post.php'); ?>
        </div>
      </div>

    </div>

  </div>


    <footer class="py-2 text-center mt-4 text-body-secondary bg-body-tertiary">
      <p>Blog for <a href="https://sternaafrica.org/">Association Sterna Africa</a> directed by <a href="mailto:roys.esdras@outlook.com">RoysEsdras</a>.</p>
    </footer>

    <script src="./assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>