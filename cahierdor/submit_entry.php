<?php
// Debug temporaire
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_errors.log');


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

// Vérifier la présence de contenu (texte et image obligatoires)
$has_text = false;
if (!empty($_POST['content']) && is_array($_POST['content'])) {
    foreach ($_POST['content'] as $text) {
        if (trim($text) !== '') {
            $has_text = true;
            break;
        }
    }
}

$has_image = false;
if (!empty($_FILES['image']['name']) && is_array($_FILES['image']['name'])) {
    foreach ($_FILES['image']['name'] as $img_name) {
        if (!empty($img_name)) {
            $has_image = true;
            break;
        }
    }
}

if (!$has_text || !$has_image) {
    $_SESSION['error'] = "Ton récit doit obligatoirement contenir du texte ET une photo 📸📝";
    header("Location: raconte-ta-journee");
    exit();
}

// Migration automatique pour s'assurer que la colonne 'mood' existe dans la table 'entries'
try {
    $pdo->exec("ALTER TABLE entries ADD COLUMN mood VARCHAR(50) NULL");
} catch (Exception $e) {
    // La colonne existe déjà probablement, on ignore
}

// Créer l’entrée principale
$project_id = $_POST['project_id'] ?? null;
$mood = trim($_POST['mood'] ?? '');
$stmt = $pdo->prepare("INSERT INTO entries (project_id, user_id, entry_date, mood) VALUES (?, ?, ?, ?)");
$stmt->execute([$project_id, $user_id, $date_today, $mood]);
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

    if (!empty($_FILES['image']['name'][$index]) && $_FILES['image']['error'][$index] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image']['tmp_name'][$index];
        $ext = strtolower(pathinfo($_FILES['image']['name'][$index], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed_extensions)) {
            // Vérification de sécurité supplémentaire (vérifie les en-têtes réels de l'image)
            $check_image = getimagesize($tmp_name);
            if ($check_image !== false) {
                // On force le format JPG pour une meilleure compression WhatsApp
                $new_name = uniqid('block_', true) . '.jpg';
                $destination = $upload_dir . $new_name;

                // Fonction de compression (max 1200px largeur, 75% qualité)
                $mime = $check_image['mime'];
                $image = false;
                if ($mime == 'image/jpeg') $image = @imagecreatefromjpeg($tmp_name);
                elseif ($mime == 'image/png') $image = @imagecreatefrompng($tmp_name);
                elseif ($mime == 'image/gif') $image = @imagecreatefromgif($tmp_name);

                if ($image) {
                    $width = imagesx($image);
                    $height = imagesy($image);
                    $maxWidth = 1200;
                    
                    $newWidth = $width;
                    $newHeight = $height;
                    if ($width > $maxWidth) {
                        $newWidth = $maxWidth;
                        $newHeight = floor($height * ($maxWidth / $width));
                    }
                    
                    $tmp = imagecreatetruecolor($newWidth, $newHeight);
                    // Remplir le fond en blanc (au cas où PNG transparent)
                    $white = imagecolorallocate($tmp, 255, 255, 255);
                    imagefill($tmp, 0, 0, $white);
                    imagecopyresampled($tmp, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                    
                    if (imagejpeg($tmp, $destination, 75)) {
                        $image_path = $new_name;
                    }
                    imagedestroy($image);
                    imagedestroy($tmp);
                } else {
                    // Fallback si la librairie GD échoue
                    if (move_uploaded_file($tmp_name, $destination)) {
                        $image_path = $new_name;
                    }
                }
            }
        }
    }

    if ($text || $image_path) {
        $stmt = $pdo->prepare("INSERT INTO entry_blocks (entry_id, text, image) VALUES (?, ?, ?)");
        $stmt->execute([$entry_id, $text, $image_path]);
    }
}

// Envoyer une notification par e-mail aux abonnés
try {
    $stmtSubscribers = $pdo->query("SELECT email FROM newsletter_subscribers");
    $subscribers = $stmtSubscribers->fetchAll(PDO::FETCH_COLUMN);

    if (!empty($subscribers)) {
        $author_name = $_SESSION['name'] ?? 'Un bénévole';
        $subject = "Nouveau récit publié sur le Livre d'Or de Sterna Africa 🌟";
        
        $message = "Bonjour,\n\n$author_name vient de publier un nouveau récit sur le Livre d'Or du chantier CSI de Sterna Africa !\n\n";
        $message .= "Découvrez son témoignage et ses photos en cliquant ici :\n";
        $message .= "https://cahierdor.sternaafrica.org/\n\n";
        $message .= "Merci de nous suivre,\nL'équipe Sterna Africa";
        
        $headers = "From: Sterna Africa <sternaafrica@gmail.com>\r\n";
        $headers .= "Reply-To: sternaafrica@gmail.com\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        // Envoyer en BCC pour protéger la vie privée des abonnés et envoyer en un seul mail
        $bcc_list = implode(', ', $subscribers);
        $headers .= "Bcc: $bcc_list\r\n";
        
        @mail("sternaafrica@gmail.com", $subject, $message, $headers);
    }
} catch (Exception $e) {
    // Éviter de bloquer l'utilisateur si l'envoi d'e-mail échoue
    error_log("Erreur envoi notifications e-mail : " . $e->getMessage());
}

// Envoyer les notifications push aux abonnés Google Firebase
try {
    require_once 'send_notification.php';
    $author_name = $_SESSION['name'] ?? 'Un bénévole';
    sendPushNotification(
        "Nouveau récit publié ! 🌟",
        "$author_name vient de publier sa journée du CSI. Cliquez pour lire !"
    );
} catch (Exception $e) {
    error_log("Erreur envoi notifications push : " . $e->getMessage());
}

$_SESSION['success'] = "Ton récit du jour est publié 🎉";
header("Location: raconte-ta-journee");
exit();
