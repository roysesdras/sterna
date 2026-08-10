<?php
session_start();

// Vérifie si l'utilisateur est un administrateur
if (!isset($_SESSION['admin'])) {
    header('Location: ../admin/admin_login.php');
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <script src="../assets/js/color-modes.js"></script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../assets/img/logos/sternaofficiel-2.png" rel="icon">

  <title>Publier | Nouvelle Activité</title>
  <link rel="canonical" href="https://sternaafrica.org/">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
  <link rel="stylesheet" href="../assets/styles.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Inclure Summernote CSS et JS -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

  <style>
    /* Summernote personnalisé pour le mode sombre */
    .note-editor.note-frame {
      border-radius: 8px;
    }

    .note-editable {
      background-color: #282727ff;
      color: #d1d1d1 !important;
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
  <div class="container py-4">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <h2 class="comic-neue-bold mb-4">Publier une nouvelle activité (Mission)</h2>
        <form action="traitement_insert_mission.php" method="post" enctype="multipart/form-data">
          <div class="row">

            <div class="col-md-12 mb-3">
              <label for="title" class="form-label comic-neue-regular">Titre de l'activité :</label>
              <input type="text" class="form-control comic-neue-regular" id="title" name="title" required>
            </div>
            
            <div class="col-md-6 mb-3">
              <label for="image" class="form-label comic-neue-regular">Image de couverture :</label>
              <input type="file" class="form-control comic-neue-regular" id="image" name="image" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="video" class="form-label comic-neue-regular">Lien Vidéo (Optionnel) :</label>
              <input type="text" class="form-control comic-neue-regular" id="video" name="video" placeholder="ex: https://youtube.com/...">
            </div>

            <div class="col-md-4 mb-3">
              <label for="lieu" class="form-label comic-neue-regular">Lieu :</label>
              <input type="text" class="form-control comic-neue-regular" id="lieu" name="lieu" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="start_date" class="form-label comic-neue-regular">Date de début :</label>
              <input type="date" class="form-control comic-neue-regular" id="start_date" name="start_date" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="end_date" class="form-label comic-neue-regular">Date de fin :</label>
              <input type="date" class="form-control comic-neue-regular" id="end_date" name="end_date" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label comic-neue-regular">Description détaillée :</label>
            <textarea class="form-control comic-neue-regular" id="description" name="description" required></textarea>
          </div>

          <div class="text-start mb-4 pt-3">
            <input type="submit" class="btn btn-success comic-neue-regular" name="submit" value="Créer l'activité">
            <a href="../admin/admin_dashboard.php" class="btn btn-secondary comic-neue-regular ms-2">Annuler</a>
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
        placeholder: '✍️ Décrivez votre mission/activité ici...',
        tabsize: 2,
        height: 400,
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
          onChange: function(contents, $editable) {
            $editable.find('img').each(function() {
              $(this).addClass('styled-summernote-img');
            });
          }
        }
      });
    });
  </script>
</body>
</html>
