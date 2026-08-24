<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../admin_login.php');
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

if (isset($_POST['submit'])) {
    // Filtrage et validation des données entrées par l'utilisateur
    $title = htmlspecialchars($_POST['title']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $end_date = htmlspecialchars($_POST['end_date']);
    $lieu = htmlspecialchars($_POST['lieu']);
    $description = $_POST['description']; // Ne pas filtrer TinyMCE ici

    // Vérifier si une antenne a été sélectionnée
    $antenne_id = isset($_POST['antenne']) && !empty($_POST['antenne']) ? intval($_POST['antenne']) : NULL;
    $projet_id = isset($_POST['projet']) && !empty($_POST['projet']) ? intval($_POST['projet']) : NULL;

    // Gestion sécurisée du fichier image téléchargé
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $image = $_FILES['image']['name'];
        $target = "../../images/" . basename($image);

        // Vérifier le type et la taille du fichier
        $imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');

        // NOUVELLE LIMITE : 800 Ko
        $maxFileSize = 800 * 1024;

        if (in_array($imageFileType, $allowedTypes) && $_FILES['image']['size'] <= $maxFileSize) {
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                die("Erreur lors du téléchargement de l'image.");
            }
        } else {
            // Message d'erreur plus précis pour l'utilisateur
            if ($_FILES['image']['size'] > $maxFileSize) {
                die("Fichier trop lourd (Maximum 800 Ko).");
            } else {
                die("Type de fichier non pris en charge.");
            }
        }
    } else {
        $image = NULL;
    }

    // Préparer et exécuter l'insertion dans la base de données avec antenne_id et projet_id
    $stmt = $conn->prepare("INSERT INTO actualites (title, start_date, end_date, image, lieu, description, antenne_id, projet_id) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssii", $title, $start_date, $end_date, $image, $lieu, $description, $antenne_id, $projet_id);

    // Après avoir inséré l'actualité avec succès
    if ($stmt->execute()) {
        $actualite_id = $conn->insert_id; // Récupérer l'ID de l'actualité nouvellement insérée

        // Vérification des témoignages sélectionnés
        if (!empty($_POST['temoignages']) && is_array($_POST['temoignages'])) {
            foreach ($_POST['temoignages'] as $temoignage_id) { // Correction du nom de la variable
                $temoignage_id = intval($temoignage_id); // Sécuriser l'ID du témoignage
                $stmt_temoignage = $conn->prepare("INSERT INTO actualites_temoignages (id_actualite, id_temoignage) VALUES (?, ?)");
                $stmt_temoignage->bind_param("ii", $actualite_id, $temoignage_id);
                $stmt_temoignage->execute();
            }
        }

        // --- ENVOI DE LA NEWSLETTER ---
        require_once $_SERVER['DOCUMENT_ROOT'] . '/config/mailer_helper.php';
        $subject = "Nouvelle Actualité : " . $title;
        $body = "<h2>Une nouvelle actualité est en ligne !</h2>";
        $body .= "<p><strong>" . htmlspecialchars($title) . "</strong></p>";
        $body .= "<p>Découvrez nos dernières actions et toutes les nouveautés directement sur notre site.</p>";
        $body .= "<p style='margin-top:20px;'><a href='https://sternaafrica.org/old/actualite/actualite_detail.php?id=" . $actualite_id . "' style='display:inline-block; padding:12px 25px; background:#fcb900; color:#034890; text-decoration:none; font-weight:bold; border-radius:8px;'>Lire la suite</a></p>";
        send_newsletter_notification($conn, $subject, $body);
        // ------------------------------

        header('Location: admin_actualites.php?message=Actualité%20ajoutée%20avec%20succès');
        exit();
    } else {
        echo "Erreur: " . $stmt->error;
    }
}

// Script de traitement pour l'ajout d'une antenne
if (isset($_POST['nom_antenne'])) {
    $nom_antenne = htmlspecialchars($_POST['nom_antenne']);
    $stmt = $conn->prepare("INSERT INTO antennes (nom) VALUES (?)");
    $stmt->bind_param("s", $nom_antenne);
    if ($stmt->execute()) {
        header('Location: admin_antennes.php?message=Antenne ajoutée avec succès');
        exit();
    } else {
        echo "Erreur: " . $stmt->error;
    }
}
