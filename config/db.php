<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Informations de connexion à la base de données
$host = 'db';
$username = 'root';
$password = 'SoftiP24';
$dbname = 'africa_db';

// Établir une connexion sécurisée à la base de données
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Configurer la connexion pour utiliser des requêtes préparées
$conn->set_charset('utf8mb4'); // Utiliser le charset UTF-8 pour éviter les injections basées sur l'encodage

// Vérifier si la fonction sanitize_input est déjà déclarée
if (!function_exists('sanitize_input')) {
    // Fonction pour nettoyer les données d'entrée
    function sanitize_input($data, $conn)
    {
        return htmlspecialchars($conn->real_escape_string($data));
    }
}

// Exemple d'utilisation :
// $safe_data = sanitize_input($_POST['input_data'], $conn);
