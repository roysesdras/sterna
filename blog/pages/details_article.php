<?php
// Connexion à la base de données
$host = 'localhost';
$db = 'u694220522_blog_sterna';
$user = 'u694220522_sterna';
$pass = '@sterna_Africa225';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération de l'article à afficher
if (!isset($_GET['id'])) {
    die('ID d\'article non spécifié.');
}

$article_id = $_GET['id'];
$stmt = $pdo->prepare("
    SELECT titre, contenu, date_publication, auteur, image_upload
    FROM articles
    WHERE id = ? AND status = 'publié'
");
$stmt->execute([$article_id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    die('Article introuvable ou non approuvé.');
}
?>

<!doctype html>
<html lang="fr" data-bs-theme="auto">
<head>
    <title><?php echo htmlspecialchars($article['titre']); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Découvrez un monde d'articles captivants sur le volontariat, la culture et l'éducation. Rejoignez notre communauté pour explorer des histoires inspirantes, des conseils pratiques et des réflexions profondes qui enrichissent votre expérience de vie. Explorez, apprenez et partagez avec nous!" />

    <meta name="robots" content="index">
    <meta name="robots" content="follow">

    <!-- Favicons -->
    <link href="https://sternaafrica.org/assets/img/favicon1.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/apple-touch-icon1.png" rel="apple-touch-icon">

    <!-- meta for og.graph -->
    <meta property="og:image" content="<?php echo htmlspecialchars($article['image_upload']); ?>" />
    <meta property="og:url" content="<?php echo htmlspecialchars('https://blog.sternaafrica.org/pages/details_article.php?id=' . $article['id']); ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="blog" />
    <link rel="canonical" href="<?php echo htmlspecialchars('https://blog.sternaafrica.org/pages/details_article.php?id=' . $article['id']); ?>" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../blog.css">
    <style>
        .article-header {
            text-align: left;
            margin-bottom: 20px;
            margin-top: 10px;
        }
        .article-image {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .article-content {
            line-height: 1.6;
        }
    </style>
</head>
<body data-bs-theme="dark"> 
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
            <div class="article-header">
                <!-- titre date et auteur -->
                <h2><?php echo htmlspecialchars($article['titre']); ?></h2>
                    <p class="meta-info" style="color:#555;">Publié le <?php echo date('d M Y à H:i', strtotime($article['date_publication'])); ?> par <span class="text-info"> <?php echo htmlspecialchars($article['auteur']); ?></span> </p>
                </div>

                <div class="article-content">
                    <!-- Affichage du contenu avec HTML autorisé -->
                    <?php echo $article['contenu']; ?>
                </div>


                <!-- image -->
                <?php if (!empty($article['image_upload'])): ?>
                    <img src="<?php echo '../' . htmlspecialchars($article['image_upload']); ?>" alt="Image de l'article" class="article-image">
                <?php endif; ?>

                <?php 
                    // Affichage des commentaires
                    $stmt = $pdo->prepare("SELECT * FROM commentaires WHERE article_id = :article_id ORDER BY created_at DESC");
                    $stmt->execute(['article_id' => $article_id]);
                    $commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($commentaires) {
                        echo '<h4 class="pt-4">Commentaires :</h4>';
                        foreach ($commentaires as $commentaire) {
                            echo '<div class="comment pt-2 p-2 mb-4" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; border-radius: 8px;">';
                            echo '<h5 class="text-info">' . htmlspecialchars($commentaire['nom']) . '</h5>';
                            echo '<p>' . nl2br(strip_tags($commentaire['commentaire'])) . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>Aucun commentaire pour cet article.</p>';
                    }

                    // Formulaire de commentaire
                    echo '<div class="comment-section pt-3">';
                    echo '<form method="POST" action="comments.php">';
                    echo '<input type="hidden" name="article_id" value="' . htmlspecialchars($article_id) . '">';
                    echo '<div class="mb-3">';
                    echo '<label for="nom" class="form-label"></label>';
                    echo '<input type="text" class="form-control" id="nom" name="nom" required placeholder="Pseudo">';
                    echo '</div>';
                    echo '<div class="mb-3">';
                    echo '<label for="commentaire" class="form-label"></label>';
                    echo '<textarea class="form-control" id="commentaire" name="commentaire" rows="3" required placeholder="votre commentaire ici..."></textarea>';
                    echo '</div>';
                    echo '<button type="submit" class="btn btn-info">Envoyer</button>';
                    echo '</form>';
                    echo '</div>';
                ?>

                <?php include_once ('../inclusion/all_footer_post.php'); ?>

            </div>

            <div class="col-md-2"></div>
        </div>

    </div>
    
<footer class="py-2 text-center mt-4 text-body-secondary bg-body-tertiary">
  <p>Blog for <a href="https://sternaafrica.org/">Association Sterna Africa</a> directed by <a href="mailto:roys.esdras@outlook.com">RoysEsdras</a>.</p>
</footer>

<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

