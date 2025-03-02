<?php
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

// Récupération des 5 articles récents approuvés et publiés
$stmt = $pdo->prepare("
    SELECT id, titre, contenu, date_publication, auteur, image_upload
    FROM articles
    WHERE status = 'publié'
    ORDER BY date_publication DESC
    LIMIT 5
");
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if ($articles): ?>
<div id="carouselExampleSlidesOnly" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php foreach ($articles as $index => $article): ?>
            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                <div class="p-4 p-md-5 mb-4 text-body-emphasis"
                    style="position: relative; background-image: url('<?php echo htmlspecialchars($article['image_upload']); ?>'); 
                            background-size: cover; 
                            background-position: center; 
                            background-repeat: no-repeat; 
                            width: 100%; 
                            max-width: 100%; 
                            /* height: 100%; Vous pouvez ajuster la hauteur selon vos besoins */
                            color: white;
                            border-radius: 15px;
                            box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;">
                    
                    <!-- Couche sombre semi-transparente -->
                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.6); border-radius: 15px; z-index: 1;"></div>

                    <div class="col-lg-6 px-0" style="position: relative; z-index: 2;">
                        <h3 class="display-4" style="line-height: 1;">
                            <?php echo htmlspecialchars($article['titre']); ?>
                        </h3>
                        <p class="lead my-3">
                            <?php echo htmlspecialchars(substr(strip_tags($article['contenu']), 0, 150)); ?>...
                        </p>
                        <p class="lead mb-0">
                            <a href="./pages/details_article.php?id=<?php echo $article['id']; ?>" class="text-body-emphasis fw-bold">Continue reading...</a>
                        </p>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
