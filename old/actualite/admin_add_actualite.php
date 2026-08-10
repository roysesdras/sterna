<!DOCTYPE html>
<html lang="fr">

<head>
  <script src="../assets/js/color-modes.js"></script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../assets/img/logos/sternaofficiel-2.png" rel="icon">

  <title>Publier | article</title>
  <link rel="canonical" href="https://sternaafrica.org/">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
  <link rel="stylesheet" href="../assets/styles.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Inclure Summernote CSS et JS -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <style>
    /* Fond du champ de sélection */
    .select2-container--default .select2-selection--multiple {
      background-color: #222323 !important;
      border: 1px solid #444 !important;
      color: #d1d1d1 !important;
    }

    /* Texte des éléments déjà sélectionnés (les petits badges) */
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
      background-color: #333 !important;
      border: 1px solid #555 !important;
      color: #fff !important;
    }

    /* La liste déroulante (le menu qui s'ouvre) */
    .select2-dropdown {
      background-color: #222323 !important;
      border: 1px solid #444 !important;
      color: #d1d1d1 !important;
    }

    /* Les options individuelles dans la liste */
    .select2-results__option {
      background-color: #222323 !important;
      color: #d1d1d1 !important;
    }

    /* L'option quand on passe la souris dessus (hover) ou quand elle est sélectionnée */
    .select2-results__option--highlighted[aria-selected],
    .select2-results__option[aria-selected=true] {
      background-color: #444 !important;
      /* Un gris un peu plus clair au survol */
      color: #ffffff !important;
    }

    /* La barre de recherche à l'intérieur du menu */
    .select2-search__field {
      background-color: #333 !important;
      color: #fff !important;
      border: 1px solid #555 !important;
    }

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
  <?php

  $conn = new mysqli("db", "root", "SoftiP24", "africa_db");
  if ($conn->connect_error) die("Échec de la connexion : " . $conn->connect_error);

  $sql = "SELECT id, nom FROM temoignages ORDER BY id DESC";
  $result = $conn->query($sql);

  $sql_antennes = "SELECT id, nom FROM antennes ORDER BY nom ASC";
  $result_antennes = $conn->query($sql_antennes);

  $sql_projets = "SELECT id, nom FROM projets ORDER BY nom ASC";
  $result_projets = $conn->query($sql_projets);
  ?>

  <div class="container py-4">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <h2 class="comic-neue-bold mb-4">Publier un nouvel article</h2>
        <form action="traitement_insert_actualite.php" method="post" enctype="multipart/form-data">
          <div class="row">

            <div class="col-md-4 mb-3">
              <label for="title" class="form-label comic-neue-regular">Titre :</label>
              <input type="text" class="form-control comic-neue-regular" id="title" name="title" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="image" class="form-label comic-neue-regular">Image :</label>
              <input type="file" class="form-control comic-neue-regular" id="image" name="image" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="lieu" class="form-label comic-neue-regular">Lieu :</label>
              <input type="text" class="form-control comic-neue-regular" id="lieu" name="lieu" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="start_date" class="form-label comic-neue-regular">Début date :</label>
              <input type="date" class="form-control comic-neue-regular" id="start_date" name="start_date" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="end_date" class="form-label comic-neue-regular">Fin date :</label>
              <input type="date" class="form-control comic-neue-regular" id="end_date" name="end_date" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="antenne" class="form-label comic-neue-regular">Antenne :</label>
              <select class="form-control comic-neue-regular" id="antenne" name="antenne" required>
                <option value="">Sélectionner une antenne</option>
                <?php
                if ($result_antennes->num_rows > 0) {
                  while ($row = $result_antennes->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["nom"]) . "</option>";
                  }
                } else {
                  echo "<option disabled>Aucune antenne disponible</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="projet" class="form-label comic-neue-regular">Projet lié (Optionnel) :</label>
              <select class="form-control comic-neue-regular" id="projet" name="projet">
                <option value="">-- Aucun projet spécifique --</option>
                <?php
                if ($result_projets->num_rows > 0) {
                  while ($row = $result_projets->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["nom"]) . "</option>";
                  }
                }
                ?>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label comic-neue-regular">Contenu :</label>
            <textarea class="form-control comic-neue-regular" id="description" name="description" required></textarea>
          </div>

          <div class="mb-3">
            <label for="temoignages" class="form-label comic-neue-regular text-light">Sélectionner des Participants :</label>
            <select class="form-control select2-multiple" id="temoignages" name="temoignages[]" multiple="multiple">
              <?php
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  // On retire le style inline ici, le CSS global s'en occupe
                  echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["nom"]) . "</option>";
                }
              }
              ?>
            </select>
            <small class="text-muted">Vous pouvez taper le nom pour chercher et sélectionner plusieurs personnes.</small>
          </div>

          <script>
            $(document).ready(function() {
              $('.select2-multiple').select2({
                placeholder: "🔍 Rechercher un participant...",
                allowClear: true,
                width: '100%'
              });
            });
          </script>

          <div class="text-start mb-4 pt-3">
            <input type="submit" class="btn btn-success comic-neue-regular" name="submit" value="Publier l'article">
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
        placeholder: '✍️ Rédigez votre contenu ici...',
        tabsize: 2,
        height: 600,
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
          },
          // ⚡ Quand le contenu change, on stylise les images automatiquement
          onChange: function(contents, $editable) {
            // Cible toutes les images dans l'éditeur
            $editable.find('img').each(function() {
              $(this).addClass('styled-summernote-img'); // Ajoute une classe unique
            });
          }
        }
      });
    });
  </script>



  <?php // require_once $_SERVER['DOCUMENT_ROOT'] . '/config/footer_2.php'; ?>
</body>

</html>