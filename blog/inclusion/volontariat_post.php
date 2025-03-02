
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connexion à la base de données
$host = 'localhost';
$db = 'u694220522_blog_sterna';
$user = 'u694220522_sterna';
$pass = '@sterna_Africa225';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour récupérer l'article le plus récent de la catégorie "Volunteering"
    $stmt = $pdo->prepare("
        SELECT a.*, c.name AS categorie_name 
        FROM articles a
        JOIN categories c ON a.categorie = c.id
        WHERE c.name = :categorie AND a.status = 'publié'
        ORDER BY a.date_publication DESC
        LIMIT 1
    ");
    $stmt->execute(['categorie' => 'Engagement Associatif']);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($article) {
        // Affichage de l'article
        echo '<article class="blog-post">';
        echo '<h3 class="display-5 link-body-emphasis mb-1">' . htmlspecialchars($article['titre']) . '</h3>';
        echo '<p class="blog-post-meta">' . date('F j, Y', strtotime($article['date_publication'])) . ' by <a href="#">' . htmlspecialchars($article['auteur']) . '</a></p>';
        
        // Affichage de l'image
        echo '<img src="' . htmlspecialchars($article['image_upload']) . '" alt="Image de l\'article" class="img-fluid" style="border-radius:5px;"/>';
        
        // Récupération et affichage du contenu par morceaux
        $contenu = $article['contenu'];  // Enlever les balises HTML
        echo $contenu;
       
        echo '</article>';

        // Affichage des commentaires
        $stmt = $pdo->prepare("SELECT * FROM commentaires WHERE article_id = :article_id ORDER BY created_at DESC");
        $stmt->execute(['article_id' => $article['id']]); // Utilisez l'ID de l'article récupéré
        $commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($commentaires) {
            echo '<h4>Comments :</h4>';
            foreach ($commentaires as $commentaire) {
                echo '<div class="comment p-2 mb-4" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; border-radius: 8px;">';
                echo '<h5 class="text-info">' . htmlspecialchars($commentaire['nom']) . '</h5>';
                echo '<p>' . nl2br(strip_tags($commentaire['commentaire'])) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>Aucun commentaire pour cet article.</p>';
        }

        // Formulaire de commentaire
        echo '<div class="comment-section pt-3">';
        echo '<form method="POST" action="traiter_commentaire.php">';
        echo '<input type="hidden" name="article_id" value="' . htmlspecialchars($article['id']) . '">';
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
        
    } else {
        echo '<p>Aucun article trouvé dans la catégorie "Volunteering".</p>';
    }
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>
