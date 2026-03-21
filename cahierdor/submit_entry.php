<?php
// Debug temporaire (à désactiver en prod)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once 'includes/db.php';
require_once 'includes/auth.php';
require_login();

$user_id = $_SESSION['user_id'];
$date_today = date('Y-m-d');

// Vérifier s’il y a déjà une entrée pour aujourd’hui
$stmt = $pdo->prepare("SELECT id FROM entries WHERE entry_date = ? AND user_id = ?");
$stmt->execute([$date_today, $user_id]);
if ($stmt->fetch()) {
    $_SESSION['error'] = "Tu as déjà raconté ta journée aujourd’hui ✍️";
    header("Location: raconte-ta-journee");
    exit();
}

// Vérifier la présence de contenu
if (empty($_POST['content']) || !is_array($_POST['content'])) {
    $_SESSION['error'] = "Aucun contenu reçu.";
    header("Location: raconte-ta-journee");
    exit();
}

// Créer l’entrée principale
$project_id = $_POST['project_id'] ?? null;
$stmt = $pdo->prepare("INSERT INTO entries (project_id, user_id, entry_date) VALUES (?, ?, ?)");
$stmt->execute([$project_id, $user_id, $date_today]);
$entry_id = $pdo->lastInsertId();

// Préparer l’upload
$upload_dir = __DIR__ . '/uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Enregistrer les blocs (texte + image)
foreach ($_POST['content'] as $index => $text) {
    $text = trim($text);
    $image_path = null;

    if (!empty($_FILES['image']['name'][$index])) {
        $type = $_FILES['image']['type'][$index];
        if (in_array($type, ['image/jpeg', 'image/png', 'image/jpg'])) {
            $ext = pathinfo($_FILES['image']['name'][$index], PATHINFO_EXTENSION);
            $new_name = uniqid('block_', true) . '.' . $ext;
            $destination = $upload_dir . $new_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'][$index], $destination)) {
                $image_path = $new_name;
            }
        }
    }

    if ($text || $image_path) {
        $stmt = $pdo->prepare("INSERT INTO entry_blocks (entry_id, text, image) VALUES (?, ?, ?)");
        $stmt->execute([$entry_id, $text, $image_path]);
    }
}

$_SESSION['success'] = "Ton récit du jour est publié 🎉";
header("Location: raconte-ta-journee");
exit();
