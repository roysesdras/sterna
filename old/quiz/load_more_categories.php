<?php
require_once __DIR__ . '/../config/db.php';
header('Content-Type: application/json');

// Récupérer toutes les catégories sauf les 3 premières
$sql = "SELECT id, nom, description FROM categorie_quiz ORDER BY id DESC LIMIT 100 OFFSET 3";
$result = $conn->query($sql);

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

echo json_encode($categories);
