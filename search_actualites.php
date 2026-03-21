<?php

header('Content-Type: application/json'); // Réponse en JSON

try {
    // Connexion à la base de données avec gestion des erreurs
    $pdo = new PDO('mysql:host=localhost;dbname=u694220522_africa_db', 'u694220522_sterna_africa', '@sterna_Africa225', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Récupération du paramètre de recherche
$query = $_GET['query'] ?? '';

// Construire la requête SQL
if (!empty($query)) {
    // Si une recherche est effectuée
    $sql = "SELECT id, title, SUBSTRING_INDEX(image, '/', -1) AS image, description 
                FROM actualites 
                WHERE title LIKE :query OR description LIKE :query";
    $stmt = $pdo->prepare($sql);
    $searchQuery = "%$query%";
    $stmt->execute(['query' => $searchQuery]);
} else {
    // Si aucun mot-clé, on récupère tout
    $sql = "SELECT id, title, SUBSTRING_INDEX(image, '/', -1) AS image, description FROM actualites";
    $stmt = $pdo->query($sql);
}

// Récupérer les résultats
$results = $stmt->fetchAll();

// Retourner les données en JSON
echo json_encode($results);
