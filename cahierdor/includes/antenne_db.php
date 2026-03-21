<?php
// Paramètres de connexion
$host = 'db';
$dbname = 'africa_db';
$username = 'root';
$password = 'SoftiP24';

// Connexion à la deuxième base pour récupérer les pays (antennes)
try {
    $antennesPdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $antennesPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $antennesPdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur connexion BDD antennes : " . $e->getMessage());
}
