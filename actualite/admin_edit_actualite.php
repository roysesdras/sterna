<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../admin_login.php');
    exit();
}

// Connexion à la base de données
$conn = new mysqli('db', 'root', 'SoftiP24', 'africa_db');
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

// Récupérer l'antenne associée à l'actualité
$sql_antenne = "SELECT antenne_id FROM actualites WHERE id = ?";
$stmt_antenne = $conn->prepare($sql_antenne);
$stmt_antenne->bind_param("i", $id);
$stmt_antenne->execute();
$result_antenne = $stmt_antenne->get_result();
$antenne_actuelle = $result_antenne->fetch_assoc()['antenne_id'];

// Récupérer toutes les antennes pour le sélecteur
$sql_all_antennes = "SELECT id, nom FROM antennes ORDER BY nom ASC";
$stmt_all_antennes = $conn->prepare($sql_all_antennes);
$stmt_all_antennes->execute();
$result_all_antennes = $stmt_all_antennes->get_result();
$antennes_options = '';
while ($antenne = $result_all_antennes->fetch_assoc()) {
    $selected = ($antenne['id'] == $antenne_actuelle) ? 'selected' : '';
    $antennes_options .= '<option value="' . $antenne['id'] . '" ' . $selected . '>' . htmlspecialchars($antenne['nom']) . '</option>';
}


// Traitement du formulaire d'édition
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $description = $_POST['description'];
    $lieu = $_POST['lieu'];
    $antenne_id = $_POST['antenne_id'];

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
        $sql_update = "UPDATE actualites SET title = ?, start_date = ?, end_date = ?, description = ?, lieu = ?, image = ?, antenne_id = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssssssii", $title, $start_date, $end_date, $description, $lieu, $image, $antenne_id, $id);
    } else {
        $sql_update = "UPDATE actualites SET title = ?, start_date = ?, end_date = ?, description = ?, lieu = ?, antenne_id = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssssssi", $title, $start_date, $end_date, $description, $lieu, $antenne_id, $id);
    }

    // Mise à jour des témoignages associés
    if (!empty($_POST['temoignages']) && is_array($_POST['temoignages'])) {
        // Supprimer les anciennes associations
        $stmt_delete = $conn->prepare("DELETE FROM actualites_temoignages WHERE id_actualite = ?");
        $stmt_delete->bind_param("i", $id);
        $stmt_delete->execute();

        // Insérer les nouvelles associations
        foreach ($_POST['temoignages'] as $participant_id) {
            $participant_id = intval($participant_id);
            $stmt_insert = $conn->prepare("INSERT INTO actualites_temoignages (id_actualite, id_temoignage) VALUES (?, ?)");
            $stmt_insert->bind_param("ii", $id, $participant_id);
            $stmt_insert->execute();
        }
    }


    if ($stmt_update->execute()) {
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

    <!-- Summernote CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
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

        .note-editor.note-frame {
            border-radius: 8px;
        }

        .note-editable {
            background-color: #fefefe;
            border-radius: 4px;
        }

        @media (max-width: 768px) {
            .note-toolbar {
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 mb-4">
                <h2 class="mb-4">Éditer une Actualité</h2>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="title" class="form-label">Titre :</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo $actualite['title']; ?>" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Début date:</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $actualite['start_date']; ?>" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Fin date :</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $actualite['end_date']; ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label for="image" class="form-label">Image :</label>
                                <input type="file" class="form-control" id="image" name="image">
                                <br>
                                <img src="../images/<?php echo $actualite['image']; ?>" class="thumbnail">
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="lieu" class="form-label">Lieu :</label>
                                    <input type="text" class="form-control" id="lieu" name="lieu" value="<?php echo $actualite['lieu']; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="antenne_id" class="form-label">Antenne :</label>
                                    <select class="form-select" id="antenne_id" name="antenne_id">
                                        <?php echo $antennes_options; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-secondary border-primary shadow-sm mb-3 mt-3">
                            <div class="d-flex align-items-center mb-2">
                                <span class="me-2">✨</span>
                                <h6 class="mb-0 text-primary fw-bold">Optimisation IA Sterna Africa</h6>
                            </div>
                            <p class="small text-muted mb-3">L'IA va analyser votre contenu actuel pour l'enrichir, corriger le style et renforcer l'aspect humanitaire.</p>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" id="btn-ia-edit-sterna" class="btn btn-sm btn-primary">
                                    🚀 Améliorer ce texte
                                </button>
                                <span id="ia-status-edit" class="small italic text-muted ms-2"></span>
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

    <!-- le script pour l'IA Sterna Africa (génération d'article à partir de notes) est dans le fichier ai_gateway.php pour centraliser les appels à Gemini et éviter les redondances. Voici le prompt utilisé pour l'édition : -->
    <script>
        document.getElementById('btn-ia-edit-sterna').addEventListener('click', async function() {
            const btn = this;
            const status = document.getElementById('ia-status-edit');
            const title = document.getElementById('title').value;
            const lieu = document.getElementById('lieu').value;

            // Récupérer le contenu actuel du Summernote
            const currentContent = $('#description').summernote('code');

            if ($('#description').summernote('isEmpty')) {
                alert("Le contenu est vide. Utilisez l'assistant sur la page d'ajout ou rédigez une base.");
                return;
            }

            status.innerText = "Analyse et optimisation en cours... ⏳";
            btn.disabled = true;

            const formData = new FormData();
            formData.append('action', 'generer_blog');

            // Prompt d'optimisation spécifique pour Sterna
            const promptEdit = `
        En tant qu'expert en communication humanitaire pour l'ONG Sterna Africa, améliore l'article suivant.
        TITRE actuel : "${title}"
        LIEU : ${lieu}
        CONTENU À OPTIMISER : ${currentContent}

        CONSIGNES :
        1. Corrige les fautes et améliore le style pour qu'il soit plus inspirant.
        2. Conserve les informations clés (participants, dates, lieux).
        3. Structure mieux le texte avec des balises HTML (h2, p, strong).
        4. Renforce le ton solidaire et l'impact positif de Sterna Africa.
    `;

            formData.append('sujet_article', promptEdit);

            try {
                const response = await fetch('https://rebonly.com/ai_gateway.php', {
                    method: 'POST',
                    body: formData
                });

                let data = await response.json();
                if (Array.isArray(data)) data = data[0];

                // On réinjecte le contenu amélioré dans Summernote
                const optimizedContent = data.contenu || data.description;
                if (optimizedContent) {
                    $('#description').summernote('code', optimizedContent);
                    status.innerText = "✅ Contenu optimisé !";
                }
            } catch (error) {
                console.error("Erreur IA Edit Sterna:", error);
                status.innerText = "❌ Erreur de connexion.";
            } finally {
                btn.disabled = false;
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: 'Description de l\'actualité...',
                tabsize: 2,
                height: 300,
                dialogsInBody: true,
                fontNames: ['Comic Sans MS', 'Arial', 'Courier New', 'Times'],
                fontSizes: ['8', '10', '12', '14', '16', '18', '24', '36', '48'],
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['codeview']],
                    ['misc', ['undo', 'redo']]
                ],
                callbacks: {
                    onPaste: function(e) {
                        const clipboardData = e.originalEvent.clipboardData || window.clipboardData;
                        const pastedData = clipboardData.getData('Text');
                        const clean = pastedData.replace(/<script[^>]*>([\S\s]*?)<\/script>/gim, '');
                        document.execCommand('insertText', false, clean);
                        e.preventDefault();
                    },
                    onImageUpload: function(files) {
                        alert('L’upload d’image n’est pas encore activé côté serveur.');
                    }
                }
            });
        });
    </script>

    <?php require_once('../config/footer_2.php'); ?>
</body>