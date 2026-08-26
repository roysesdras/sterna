<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type_document = $conn->real_escape_string($_POST['type_document']);
    $annee = (int)$_POST['annee'];
    $trimestre = isset($_POST['trimestre']) ? $conn->real_escape_string($_POST['trimestre']) : null;
    
    if ($type_document === 'rapport_annuel') {
        $titre = "Rapport Annuel - " . $annee;
        $trimestre = null; // Ensure null for rapport_annuel
    } else {
        $titre = "Bulletin " . $trimestre . " - " . $annee;
    }
    
    // Directory for uploads
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/rapports/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $pdf_link = "";
    $cover_image = null;

    // Handle PDF Upload
    if (isset($_FILES["pdf_file"]) && $_FILES["pdf_file"]["error"] == 0) {
        $pdf_name = time() . "_" . basename($_FILES["pdf_file"]["name"]);
        $pdf_name = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $pdf_name); // Clean filename
        $target_pdf = $target_dir . $pdf_name;
        
        if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_pdf)) {
            $pdf_link = "/uploads/rapports/" . $pdf_name;
        } else {
            die("Erreur lors du téléchargement du PDF.");
        }
    } else {
        die("Le fichier PDF est requis.");
    }

    // Handle Image Upload
    if (isset($_FILES["cover_file"]) && $_FILES["cover_file"]["error"] == 0) {
        $img_name = time() . "_img_" . basename($_FILES["cover_file"]["name"]);
        $img_name = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $img_name); // Clean filename
        $target_img = $target_dir . $img_name;
        
        if (move_uploaded_file($_FILES["cover_file"]["tmp_name"], $target_img)) {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/config/image_helper.php';
            compress_uploaded_image($target_img);
            $cover_image = "/uploads/rapports/" . $img_name;
        }
    }

    $sql = "INSERT INTO rapports (type_document, annee, trimestre, titre, pdf_link, cover_image) VALUES ('$type_document', $annee, " . ($trimestre ? "'$trimestre'" : "NULL") . ", '$titre', '$pdf_link', " . ($cover_image ? "'$cover_image'" : "NULL") . ")";
    
    if ($conn->query($sql) === TRUE) {
        // --- ENVOI DE LA NEWSLETTER ---
        require_once $_SERVER['DOCUMENT_ROOT'] . '/config/mailer_helper.php';
        $type_str = ($type_document === 'bulletin') ? "Un nouveau Bulletin Trimestriel" : "Un nouveau Rapport Annuel";
        $subject = "Nouveau document disponible : " . $titre;
        $body = "<h2>" . $type_str . " est en ligne !</h2>";
        $body .= "<p><strong>" . htmlspecialchars($titre) . "</strong></p>";
        $body .= "<p>Notre dernier document est maintenant disponible en téléchargement libre.</p>";
        $body .= "<p style='margin-top:20px;'><a href='https://sternaafrica.org/old/pages/documents.php' style='display:inline-block; padding:12px 25px; background:#fcb900; color:#034890; text-decoration:none; font-weight:bold; border-radius:8px;'>Consulter les documents</a></p>";
        send_newsletter_notification($conn, $subject, $body);
        // ------------------------------

        header("Location: admin_rapports.php?message=Rapport importé avec succès");
        exit();
    } else {
        die("Erreur : " . $conn->error);
    }
}
