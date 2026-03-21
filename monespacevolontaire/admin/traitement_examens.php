<?php
//traitement_examens.php
session_start();
require_once '../inclusion/db.php';

// Vérifie que le formateur est connecté
if (!isset($_SESSION['formateur_id'])) {
    header("Location: login.php");
    exit;
}

// Chemin physique pour l'upload (côté serveur)
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/admin/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0775, true);
}

// Sécurisation et validation
$questions = $_POST['questions'] ?? [];
$types     = $_POST['types'] ?? [];
$options   = $_POST['options'] ?? [];

$total = count($questions);
$success = 0;

for ($i = 0; $i < $total; $i++) {
    $question_text = trim($questions[$i]);
    $type_question = $types[$i];
    $option_text   = ($type_question === 'qcm') ? trim($options[$i]) : null;

    // Gestion de l'image
    $imagePath = null;
    if (isset($_FILES['images']['name'][$i]) && $_FILES['images']['name'][$i] !== '') {
        $imageName = uniqid('exam_') . '_' . basename($_FILES['images']['name'][$i]);
        $targetFile = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $targetFile)) {
            $imagePath = $imageName; // et pas 'admin/uploads/' . $imageName
        }
    }

    // Insertion dans la base de données
    $stmt = $pdo->prepare("INSERT INTO examens (question_text, type_question, options, image, date_creation) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([
        $question_text,
        $type_question,
        $option_text,
        $imagePath
    ]);

    if ($stmt->rowCount()) $success++;
}

if ($success > 0) {
    $message = "$success examens ajoutée(s) avec succès.";
} else {
    $message = "Aucune question ajoutée.";
}

// Si la requête vient de fetch() (AJAX)
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    echo $message;
    exit; // ← ce exit est CRUCIAL
}


// Sinon, redirection classique (soumission normale)
$_SESSION['message'] = $message;
header("Location: https://monespacevolontaire.sternaafrica.org/admin/");
exit;

