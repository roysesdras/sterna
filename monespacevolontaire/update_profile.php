<?php
session_start();
require_once 'inclusion/db.php';

// Redirection avec message d’erreur
function redirectWithError($message) {
    $_SESSION['error_message'] = $message;
    header("Location: update_profile.php");
    exit;
}

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Récupère l’ancien avatar
$stmt = $pdo->prepare("SELECT avatar FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    die("Utilisateur introuvable.");
}

// Variables du formulaire
$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$date_naissance = $_POST['date_naissance'] ?? '';
$telephone = $_POST['telephone'] ?? '';
$ville = $_POST['ville'] ?? '';
$profession = $_POST['profession'] ?? '';
$competences = $_POST['competences'] ?? '';
$disponibilite = $_POST['disponibilite'] ?? '';
$motivation = $_POST['motivation'] ?? '';

// Gestion de l’avatar
$avatar = $user['avatar']; // Par défaut on garde l'ancien

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['avatar']['tmp_name'];
    $fileName = $_FILES['avatar']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];

    // Vérification du type MIME
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $fileTmpPath);
    finfo_close($finfo);

    if (!in_array($mime, $allowedMimes)) {
        redirectWithError("Le type de fichier est invalide.");
    }

    // Taille maximale
    if ($_FILES['avatar']['size'] > 2000000) {
        redirectWithError("Le fichier est trop volumineux (max 2 Mo).");
    }

    if (in_array($fileExtension, $allowedExtensions)) {
        $newFileName = uniqid('avatar_') . '.' . $fileExtension;
        $uploadDir = 'uploads/';
        $destPath = $uploadDir . $newFileName;

        // Crée le dossier s’il n’existe pas
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Déplacement du fichier
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $avatar = $destPath;

            // Supprimer l’ancien avatar s’il existe et qu’il est différent
            if (!empty($user['avatar']) && file_exists($user['avatar']) && $user['avatar'] !== $avatar) {
                unlink($user['avatar']);
            }
        } else {
            redirectWithError("Erreur lors de l’envoi du fichier.");
        }
    } else {
        redirectWithError("Extension non autorisée. (jpg, jpeg, png, webp)");
    }
}

// Mise à jour en base de données
$sql = "UPDATE users SET 
        nom = ?, 
        prenom = ?, 
        date_naissance = ?, 
        telephone = ?, 
        ville = ?, 
        profession = ?, 
        competences = ?, 
        disponibilite = ?, 
        motivation = ?, 
        avatar = ?
        WHERE id = ?";

$stmt = $pdo->prepare($sql);
$success = $stmt->execute([
    $nom, $prenom, $date_naissance, $telephone, $ville,
    $profession, $competences, $disponibilite, $motivation,
    $avatar, $user_id
]);

if ($success) {
    $_SESSION['success_message'] = "Profil mis à jour avec succès.";
} else {
    $_SESSION['error_message'] = "Une erreur est survenue lors de la mise à jour.";
}

header("Location: /");  // Redirige vers la page d’accueil ou profil
exit;
