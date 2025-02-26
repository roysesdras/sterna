<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../admin_login.php');
    exit();
}

// Connexion à la base de données
$conn = new mysqli('localhost', 'u694220522_sterna_africa', '@sterna_Africa225', 'u694220522_africa_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérification de l'ID de l'actualité à éditer
if (!isset($_GET['id'])) {
    header('Location: ../admin_dashboard.php?error=ID%20d%27actualit%C3%A9%20non%20fourni');
    exit();
}
$id = $_GET['id'];

// Récupérer les détails de l'actualité à éditer
$sql = "SELECT * FROM actualites WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $actualite = $result->fetch_assoc();
} else {
    header('Location: ../admin_dashboard.php?error=Actualit%C3%A9%20introuvable');
    exit();
}

// Récupérer les témoignages associés à l'actualité
$sql_temoignages = "SELECT id_temoignage FROM actualites_temoignages WHERE id_actualite = ?";
$stmt_temoignages = $conn->prepare($sql_temoignages);
$stmt_temoignages->bind_param("i", $id);
$stmt_temoignages->execute();
$result_temoignages = $stmt_temoignages->get_result();
$temoignages = $result_temoignages->fetch_all(MYSQLI_ASSOC);

/// Récupérer tous les témoignages pour le sélecteur
$sql_all_temoignages = "SELECT id, nom FROM temoignages ORDER BY id DESC"; // Utilisation de la colonne "nom" à la place de "content"
$stmt_all_temoignages = $conn->prepare($sql_all_temoignages);
$stmt_all_temoignages->execute();
$result_all_temoignages = $stmt_all_temoignages->get_result();

$temoignages_options = ''; // Initialise la variable pour les options
while ($temoignage = $result_all_temoignages->fetch_assoc()) {
    $selected = in_array($temoignage['id'], array_column($temoignages, 'id_temoignage')) ? 'selected' : '';
    // Utilisation du nom du témoignage
    $temoignages_options .= '<option value="' . $temoignage['id'] . '" ' . $selected . '>' . htmlspecialchars($temoignage['nom']) . '</option>';
}

// Traitement du formulaire d'édition
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $description = $_POST['description']; // Récupération de la description depuis le formulaire

    // Gestion de l'image
    $image = $_FILES['image']['name'];
    $target = "../images/" . basename($image);
    $image_uploaded = false;

    if ($image) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_uploaded = true;
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }
    }

    // Mise à jour de l'actualité
    if ($image_uploaded) {
        $sql_update = "UPDATE actualites SET title = ?, start_date = ?, end_date = ?, description = ?, image = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssssi", $title, $start_date, $end_date, $description, $image, $id);
    } else {
        $sql_update = "UPDATE actualites SET title = ?, start_date = ?, end_date = ?, description = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssssi", $title, $start_date, $end_date, $description, $id);
    }

    if ($stmt_update->execute()) {
        // Suppression des anciens témoignages
        $sql_delete_temoignages = "DELETE FROM actualites_temoignages WHERE id_actualite = ?";
        $stmt_delete = $conn->prepare($sql_delete_temoignages);
        $stmt_delete->bind_param("i", $id);
        $stmt_delete->execute();

        // Ajout des nouveaux témoignages
        if (isset($_POST['temoignages'])) {
            foreach ($_POST['temoignages'] as $temoignage_id) {
                $sql_insert_temoignage = "INSERT INTO actualites_temoignages (id_actualite, id_temoignage) VALUES (?, ?)";
                $stmt_insert_temoignage = $conn->prepare($sql_insert_temoignage);
                $stmt_insert_temoignage->bind_param("ii", $id, $temoignage_id);
                $stmt_insert_temoignage->execute();
            }
        }

        header('Location: ./admin_actualites.php?message=Actualit%C3%A9%20modifi%C3%A9e%20avec%20succ%C3%A8s');
        exit();
    } else {
        echo "Erreur lors de la mise à jour de l'actualité : " . $stmt_update->error;
    }
}

// Fermeture de la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="FR_fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../assets/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <title>Éditer une Actualité</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    
    <!-- <link rel="stylesheet" href="../assets/styles.css"> -->

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    
    <style>
        .thumbnail {
            max-height: 100px;
            max-width: 150px;
            width: auto;
            height: auto;
        }

        .description img {
            max-height: 100px;
            max-width: 150px;
            width: auto;
            height: auto;
        }
    </style>
</head>
<body>
    <?php include_once ('../config/mode_theme.php'); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 mb-4">
                    <h2 class="mb-4">Éditer une Actualité</h2>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Titre :</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $actualite['title']; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Début date:</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $actualite['start_date']; ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">Fin date :</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $actualite['end_date']; ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="image" class="form-label">Image :</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                    <br>
                                <img src="../images/<?php echo $actualite['image']; ?>" class="thumbnail">                        
                                </div>
                            </div>

                            
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Contenu :</label>
                            <textarea class="form-control description" id="description" name="description" required><?php echo htmlspecialchars_decode($actualite['description']); ?></textarea>
                        </div>
                        
                        <div class="mb-4">
                        <label for="temoignage_id" class="form-label">Participants :</label>
                        <select class="form-select" style="height: 200px;" id="temoignage_id" name="temoignages[]" multiple>
                            <?php echo $temoignages_options; ?>
                        </select>

                        </div>
                        
                    </div>
                    
                    <div class="text-start">
                        <button type="submit" class="btn btn-success btn-sm" name="submit">Mettre à jour</button>
                        <a href="./admin_actualites.php" class="btn btn-outline-secondary btn-sm">Annuler</a>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
        
    </div>
    <script>
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: 'Description de l\'actualité...',
                tabsize: 2,
                height: 300
            });
        });
    </script>

    <?php require_once('../config/footer_2.php'); ?>
</body>
</html>
