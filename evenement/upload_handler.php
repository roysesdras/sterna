<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $target_dir = "../uploads/";
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif']; // Extensions autorisées
    $max_file_size = 2 * 1024 * 1024; // Taille maximale : 2 Mo

    // Vérifiez si le répertoire existe, sinon créez-le
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $file = $_FILES['file'];
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Vérifie l'extension du fichier
    if (!in_array($file_extension, $allowed_extensions)) {
        http_response_code(400);
        echo json_encode(['error' => 'Type de fichier non autorisé. Seules les images JPG, PNG et GIF sont acceptées.']);
        exit;
    }

    // Vérifie la taille du fichier
    if ($file['size'] > $max_file_size) {
        http_response_code(400);
        echo json_encode(['error' => 'Le fichier dépasse la taille maximale autorisée de 2 Mo.']);
        exit;
    }

    // Génère un nom unique pour le fichier
    $target_file = $target_dir . uniqid('img_', true) . '.' . $file_extension;

    // Déplace le fichier téléchargé
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        // Retourne l'URL complète du fichier
        $file_url = '/' . ltrim($target_file, '/'); // Ajustez selon votre structure d'URL
        echo json_encode(['url' => $file_url]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Échec du téléchargement.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Requête invalide.']);
}
?>
