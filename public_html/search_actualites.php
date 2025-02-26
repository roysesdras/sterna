<?php

    header('Content-Type: application/json'); // Spécifie que la réponse est en JSON

    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=u694220522_africa_db', 'u694220522_sterna_africa', '@sterna_Africa225');

    // Récupérer la requête de recherche
    $query = $_GET['query'] ?? ''; // Utilise une valeur par défaut pour éviter les erreurs si la requête est absente

    // Requête SQL pour rechercher des actualités correspondant à la requête
    $sql = "SELECT id, title, SUBSTRING_INDEX(image, '/', -1) AS image, description FROM actualites WHERE title LIKE :query OR description LIKE :query LIMIT 5";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['query' => "%$query%"]);

    // Récupérer les résultats sous forme de tableau
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Renvoyer les résultats sous forme de JSON
    echo json_encode($results);
?>
