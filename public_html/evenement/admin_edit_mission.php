<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../admin_login.php');
    exit();
}

$conn = new mysqli('localhost', 'u694220522_sterna_africa', '@sterna_Africa225', 'u694220522_africa_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM missions WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $mission = $result->fetch_assoc();
    } else {
        echo "Mission non trouvée.";
        exit();
    }
} else {
    echo "ID non fourni.";
    exit();
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $lieu = $_POST['lieu'];
    $image = $mission['image']; // Conserve l'image actuelle par défaut

    // Vérifier si un nouveau fichier d'image est téléchargé
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "../images/" . basename($image);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            echo "Erreur lors du téléchargement de l'image.";
            exit();
        }
    }

    $video = $_POST['video']; // Lien vidéo

    // Mettre à jour la mission avec les nouvelles données
    $sql = "UPDATE missions SET title=?, description=?, start_date=?, end_date=?, lieu=?, image=?, video=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssssi', $title, $description, $start_date, $end_date, $lieu, $image, $video, $id);

    if ($stmt->execute()) {
        header('Location: ../admin/admin_dashboard.php?message=Mission%20mise%20%C3%A0%20jour%20avec%20succ%C3%A8s');
    } else {
        echo "Erreur: " . $stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="../assets/js/color-modes.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Éditer une Mission</title>
    <link href="../assets/img/logos/sternaofficiel-2.png" rel="icon">
    <link href="../assets/img/logos/sternaofficiel-2.png" rel="apple-touch-icon">
    <!-- <link rel="stylesheet" href="../assets/styles.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Inclure Summernote CSS et JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</head>
<body>
<?php include_once ('../inclusion/mode_theme.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h2 class="comic-neue-bold mb-4">Éditer une Mission</h2>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="title" class="form-label comic-neue-regular">Titre :</label>
                                <input type="text" class="form-control comic-neue-regular" id="title" name="title" value="<?php echo htmlspecialchars($mission['title']); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="start_date" class="form-label comic-neue-regular">Date de début :</label>
                                <input type="date" class="form-control comic-neue-regular" id="start_date" name="start_date" value="<?php echo htmlspecialchars($mission['start_date']); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="end_date" class="form-label comic-neue-regular">Date de fin :</label>
                                <input type="date" class="form-control comic-neue-regular" id="end_date" name="end_date" value="<?php echo htmlspecialchars($mission['end_date']); ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="lieu" class="form-label comic-neue-regular">Lieu :</label>
                                <input type="text" class="form-control comic-neue-regular" id="lieu" name="lieu" value="<?php echo htmlspecialchars($mission['lieu']); ?>" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="image" class="form-label comic-neue-regular">Image :</label>
                                <input type="file" class="form-control comic-neue-regular" id="image" name="image">
                                <img src="../images/<?php echo htmlspecialchars($mission['image']); ?>" alt="Image actuelle" width="100" class="mt-2">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="video" class="form-label comic-neue-regular">Lien vidéo :</label>
                                <input type="text" class="form-control comic-neue-regular" id="video" name="video" value="<?php echo htmlspecialchars($mission['video']); ?>">
                                
                                <?php if (!empty($mission['video'])): ?>
                                <!-- Affichage de la vidéo si un lien existe -->
                                <div class="mt-2 ratio ratio-16x9">
                                    <iframe src="https://www.youtube.com/embed/<?php echo htmlspecialchars($mission['video']); ?>" allowfullscreen></iframe>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label comic-neue-regular">Description :</label>
                        <textarea class="form-control comic-neue-regular" id="description" name="description" required><?php echo htmlspecialchars($mission['description']); ?></textarea>
                    </div>

                    <div class="text-start mb-4">
                        <input type="submit" class="btn btn-success comic-neue-regular" name="submit" value="Mettre à jour">
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
            placeholder: '✍️ Votre contenu ici...',
            tabsize: 2,
            height: 300,
            toolbar: [
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link']],
                ['misc', ['undo', 'redo']],
                ['alignment', ['alignleft', 'aligncenter', 'alignright', 'justify']], // Alignement du texte
                ['highlight', ['highlight']] // Surlignage du texte (si disponible dans les plugins)
            ]
        });
    });
</script>

<?php require_once('../config/footer_2.php'); ?>   
</body>
</html>