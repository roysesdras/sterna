<?php
session_start();
require 'inclusion/db.php';

if (!isset($_SESSION['google_id']) || !isset($_SESSION['user_id'])) {
    header("Location: connect");
    exit();
}

$volontaire_id = $_SESSION['user_id'];

if (!isset($_POST['reponses']) || !is_array($_POST['reponses'])) {
    die("Aucune réponse reçue.");
}

$verif_stmt = $pdo->prepare("SELECT COUNT(*) FROM examens WHERE id = :id");
$check_existing = $pdo->prepare("SELECT COUNT(*) FROM reponses_examens WHERE volontaire_id = :vid AND examen_id = :eid");
$insert_stmt = $pdo->prepare("
    INSERT INTO reponses_examens (volontaire_id, examen_id, reponse, note, commentaire, date_reponse)
    VALUES (:volontaire_id, :examen_id, :reponse, NULL, NULL, NOW())
");

foreach ($_POST['reponses'] as $examen_id => $reponse) {
    $reponse = trim($reponse);
    if ($reponse === '') continue;

    // Vérifie que l'examen existe
    $verif_stmt->execute(['id' => $examen_id]);
    if ($verif_stmt->fetchColumn() == 0) continue;

    // Vérifie si déjà répondu
    $check_existing->execute(['vid' => $volontaire_id, 'eid' => $examen_id]);
    if ($check_existing->fetchColumn() > 0) continue;

    // Enregistre la réponse
    $insert_stmt->execute([
        'volontaire_id' => $volontaire_id,
        'examen_id'     => $examen_id,
        'reponse'       => htmlspecialchars($reponse)
    ]);
}

header("Location: examen_valide.php");
exit();
