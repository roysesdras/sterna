<?php
session_start();

// Sécurité : Seuls les admins peuvent uploader des images
if (!isset($_SESSION['admin'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Accès refusé']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    
    // Vérifier les erreurs d'upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['error' => 'Erreur lors du téléchargement. Code: ' . $file['error']]);
        exit;
    }
    
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowedTypes)) {
        http_response_code(400);
        echo json_encode(['error' => 'Type de fichier non autorisé.']);
        exit;
    }

    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/images/uploads/summernote/';
    
    // Créer le dossier s'il n'existe pas
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid('img_') . '.jpg'; // Forcer en JPG pour la compression
    $targetFile = $uploadDir . $filename;
    
    // Compression et redimensionnement avec GD
    list($width, $height, $type) = getimagesize($file['tmp_name']);
    $max_dim = 800; // Largeur ou hauteur maximale
    
    $new_width = $width;
    $new_height = $height;
    
    if ($width > $max_dim || $height > $max_dim) {
        $ratio = $width / $height;
        if ($width > $height) {
            $new_width = $max_dim;
            $new_height = $max_dim / $ratio;
        } else {
            $new_height = $max_dim;
            $new_width = $max_dim * $ratio;
        }
    }
    
    $src = null;
    if ($type == IMAGETYPE_JPEG) $src = imagecreatefromjpeg($file['tmp_name']);
    elseif ($type == IMAGETYPE_PNG) $src = imagecreatefrompng($file['tmp_name']);
    elseif ($type == IMAGETYPE_WEBP) $src = imagecreatefromwebp($file['tmp_name']);
    elseif ($type == IMAGETYPE_GIF) $src = imagecreatefromgif($file['tmp_name']);
    
    if ($src) {
        $dst = imagecreatetruecolor((int)$new_width, (int)$new_height);
        
        // Gérer la transparence (remplacer par du blanc pour le JPG)
        $bg = imagecolorallocate($dst, 255, 255, 255);
        imagefill($dst, 0, 0, $bg);
        
        imagecopyresampled($dst, $src, 0, 0, 0, 0, (int)$new_width, (int)$new_height, $width, $height);
        
        // Enregistrer en JPG avec une qualité de 70% pour compresser efficacement
        imagejpeg($dst, $targetFile, 70);
        
        imagedestroy($src);
        imagedestroy($dst);
        
        // Retourner l'URL de l'image
        $url = 'https://sternaafrica.org/images/uploads/summernote/' . $filename;
        echo $url;
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur lors du traitement de l\'image.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Aucun fichier reçu.']);
}
?>
