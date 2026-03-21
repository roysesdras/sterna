<?php
session_start();
require '../inclusion/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['formateur_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Accès refusé.']);
    exit;
}

$formateur_id = $_SESSION['formateur_id'];
$titre = trim($_POST['titre']);
$contenu = trim($_POST['contenu']);

if ($titre === '' || $contenu === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Tous les champs sont requis.']);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO messages_globaux (formateur_id, titre, contenu) VALUES (?, ?, ?)");
$stmt->execute([$formateur_id, $titre, $contenu]);

echo json_encode(['success' => true]);
