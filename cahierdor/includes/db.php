<?php
// Paramètres de connexion
$host = 'db';
$dbname = 'cahierdor';
$username = 'root'; // à adapter selon ton serveur
$password = 'SoftiP24';     // idem

try {
    // Création de la connexion PDO avec encodage UTF-8
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Options pour sécuriser et gérer les erreurs proprement
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Active les erreurs PDO
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Résultats en tableaux associatifs

} catch (PDOException $e) {
    // En cas d’erreur de connexion
    die("Connexion à la base de données échouée : " . $e->getMessage());
}
