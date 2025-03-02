<?php
try {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=u694220522_blog_sterna', 'u694220522_sterna', '@sterna_Africa225');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer tous les articles de manière aléatoire
    $sql = "
        SELECT 
        id AS article_id, 
        titre, 
        contenu, 
        date_publication, 
        auteur, 
        image_upload
    FROM 
        articles
    WHERE 
        status = 'publié'
    ORDER BY 
        RAND();  -- Récupère les articles de manière aléatoire
    ";

    // Préparer et exécuter la requête
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Récupérer tous les résultats
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>


<style>
    a{
        text-decoration: none;
    }
    .articles-container {
        display: flex;
        overflow-x: auto; /* Barre de défilement horizontal */
        gap: 15px; /* Espacement entre les articles */
        padding: 10px 0;
    }

    .article-card {
        gap: 5px; 
        display: flex; /* Flex pour aligner l'image et le texte */
        flex: 0 0 70%; /* Taille fixe pour chaque carte */
        border-radius: 8px; /* Coins arrondis */
        overflow: hidden; /* Coupe tout débordement */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Légère ombre */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .article-card:hover {
        transform: translateY(-5px); /* Légère élévation au survol */
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2); /* Ombre renforcée */
    }

    .article-card img {
        width: 135px; /* Largeur fixe pour l'image */
        height: 110px; /* Hauteur fixe pour l'image */
        object-fit: cover; /* Coupe et ajuste l'image */
        border-radius: 8px 0 0 8px; /* Coins arrondis pour l'image */
    }

    .article-contents {
        padding: 10px;
        color: ; /* Texte sombre */
        display: flex;
        flex-direction: column; /* Colonne pour le texte */
        justify-content: center; /* Centre le contenu verticalement */
        border-radius: 8px; /* Coins arrondis pour le contenu */
    }

    .article-title {
        font-size: 1rem; /* Taille du titre */
        margin: 0 0 5px; /* Espacement */
    }

    .article-excerpt {
        font-size: 0.875rem; /* Texte compact pour l'extrait */
        color: #555;
        margin: 0 0 5px; /* Espacement */
    }

    .article-date {
        font-size: 0.75rem; /* Texte petit pour la date */
        color: #888;
    }

    /* Barre de défilement personnalisée */
    .articles-container::-webkit-scrollbar {
        height: 8px;
    }

    .articles-container::-webkit-scrollbar-thumb {
        background: #5555;
        border-radius: 4px;
    }

    .articles-container::-webkit-scrollbar-track {
        background: transparent;
    }

    /* Médias queries pour les petits écrans */
    @media (max-width: 600px) {
        .article-card {
            gap: 5px; 
            display: flex; /* Flex pour aligner l'image et le texte */
            flex: 0 0 70%; /* Taille fixe pour chaque carte */
            border-radius: 8px; /* Coins arrondis */
            overflow: hidden; /* Coupe tout débordement */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Légère ombre */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .article-contents {
            padding: 10px;
            color: ; /* Texte sombre */
            display: flex;
            flex-direction: column; /* Colonne pour le texte */
            justify-content: center; /* Centre le contenu verticalement */
            border-radius: 8px; /* Coins arrondis pour le contenu */
        }

        .article-card img {
            width: 80px; /* Ajustement de la largeur de l'image sur mobile */
            height: 100%; /* Ajustement de la hauteur de l'image sur mobile */
        }

        .article-excerpt {
            font-size: 11px; /* Texte compact pour l'extrait */
            color: #555;
            margin: 0 0 2px; /* Espacement */
        }

        .article-title {
            font-size: 12px; /* Texte compact pour l'extrait */
            margin: 0; /* Supprime la marge par défaut */
        }

        .article-date {
                font-size: 0.75rem; /* Texte petit pour la date */
                color: #888;
            }

        .article-card {
            text-decoration : none;
            display: flex; /* Flex pour aligner l'image et le texte */
            flex: 0 0 80%;
            height: 90px; /* Taille fixe pour chaque carte */
            border-radius: 8px; /* Coins arrondis */
            overflow: hidden; /* Coupe tout débordement */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Légère ombre */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
    }
</style>


<div class="container">
    <h4 class="pt-5">Articles qui pourraient vous plaire...</h4>

    <div class="articles-container">
    <?php if ($articles): ?>
        <?php foreach ($articles as $article): ?>
            <a href="details_article.php?id=<?php echo htmlspecialchars($article['article_id']); ?>" class="article-card me-2">
                <img src="../<?php echo htmlspecialchars($article['image_upload']); ?>" alt="Image de l'article">
                <div class="article-contents">
                    <h6 class="article-title text-info"><?php echo htmlspecialchars(substr($article['titre'], 0, 100)); ?><?php echo (strlen($article['titre']) > 30 ? '...' : ''); ?></h6>
                    <p class="article-excerpt">
                        <?php echo htmlspecialchars(substr(strip_tags($article['contenu']), 0, 50)); ?>...
                    </p>
                    <small class="article-date">
                        <?php echo date('F d, Y', strtotime($article['date_publication'])); ?>
                    </small>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun article trouvé dans cette catégorie.</p>
    <?php endif; ?>
</div>

</div>
