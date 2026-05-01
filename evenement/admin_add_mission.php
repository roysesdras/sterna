<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../admin/admin_login.php');
    exit();
}

// Définir la fonction getYouTubeVideoId avant son utilisation
function getYouTubeVideoId($url)
{
    $video_id = '';
    // Patterns possibles pour les URL de vidéo YouTube
    $patterns = [
        '/youtube\.com\/watch\?v=([^\&\?\/]+)/',
        '/youtube\.com\/embed\/([^\&\?\/]+)/',
        '/youtube\.com\/v\/([^\&\?\/]+)/',
        '/youtu\.be\/([^\&\?\/]+)/'
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $url, $matches)) {
            $video_id = $matches[1];
            break;
        }
    }

    return $video_id;
}

if (isset($_POST['submit'])) {
    $conn = new mysqli('db', 'root', 'SoftiP24', 'africa_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $lieu = $_POST['lieu'];
    $image = $_FILES['image']['name'];
    $video_url = $_POST['video'];
    $video = getYouTubeVideoId($video_url);  // Utilise la fonction pour obtenir l'ID de la vidéo

    if (!empty($image)) {
        $target = "../images/" . basename($image);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            echo "Erreur lors du téléchargement de l'image.";
            exit();
        }
    }

    $stmt = $conn->prepare("INSERT INTO missions (title, description, start_date, end_date, lieu, image, video) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $title, $description, $start_date, $end_date, $lieu, $image, $video);

    if ($stmt->execute()) {
        header('Location: ../admin/admin_dashboard.php?message=Mission%20ajout%C3%A9e%20avec%20succ%C3%A8s');
    } else {
        echo "Erreur: " . $stmt->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <script src="../assets/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout nouvelle activité</title>
    <link href="../assets/img/logos/sternaofficiel-2.png" rel="icon">
    <link href="../assets/img/logos/sternaofficiel-2.png" rel="apple-touch-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Inclure Summernote CSS et JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</head>

<body>
   
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h2 class="comic-neue-bold mb-4">Ajouter une Nouvelle Activité</h2>
                <form action="" method="post" enctype="multipart/form-data">

                    <div class="row mb-3">

                        <div class="col-md-4">
                            <label for="title" class="form-label comic-neue-regular">Titre :</label>
                            <input type="text" class="form-control comic-neue-regular" id="title" name="title" required>
                        </div>
                        <div class="col-md-4">
                            <label for="start_date" class="form-label comic-neue-regular">Date de début :</label>
                            <input type="date" class="form-control comic-neue-regular" id="start_date" name="start_date">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label comic-neue-regular">Date de fin :</label>
                            <input type="date" class="form-control comic-neue-regular" id="end_date" name="end_date">
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label comic-neue-regular">Description :</label>
                        <textarea class="form-control comic-neue-regular" id="description" name="description" required></textarea>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="lieu" class="form-label comic-neue-regular">Lieu :</label>
                            <input type="text" class="form-control comic-neue-regular" id="lieu" name="lieu">
                        </div>
                        <div class="col-md-4">
                            <label for="image" class="form-label comic-neue-regular">Image :</label>
                            <input type="file" class="form-control comic-neue-regular" id="image" name="image">
                        </div>
                        <div class="col-md-4">
                            <label for="video" class="form-label comic-neue-regular">Vidéo (URL) :</label>
                            <input type="url" class="form-control comic-neue-regular" id="video" name="video">
                        </div>
                    </div>

                    <div class="text-start mb-4">
                        <input type="submit" class="btn btn-success comic-neue-regular" name="submit" value="Ajouter">
                    </div>
                </form>

            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: '✍️ Rédigez votre annonce ici...',
                tabsize: 2,
                height: 450,
                // Configuration de la barre d'outils
                toolbar: [
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['link']],
                    ['alignment', ['alignleft', 'aligncenter', 'alignright', 'justify']],
                    ['highlight', ['highlight']],
                    ['misc', ['undo', 'redo']]
                ],
                // Callbacks pour gérer proprement le contenu envoyé par l'IA ou collé
                callbacks: {
                    onPaste: function(e) {
                        const clipboardData = e.originalEvent.clipboardData || window.clipboardData;
                        const pastedData = clipboardData.getData('Text');
                        // Nettoie le texte pour éviter les scripts malveillants tout en gardant le texte brut
                        const clean = pastedData.replace(/<script[^>]*>([\S\s]*?)<\/script>/gim, '');
                        document.execCommand('insertText', false, clean);
                        e.preventDefault();
                    }
                }
            });
        });

    </script>

    <?php require_once('../config/footer_2.php'); ?>
</body>
</body>

</html>