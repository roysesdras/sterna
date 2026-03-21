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
  ?>

  <div class="container py-4">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <h2 class="comic-neue-bold mb-4">Publier un nouvel article</h2>
        <form action="traitement_insert_actualite.php" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="mb-4">
              <div class="card-body">
                <label class="form-label font-weight-bold">Raconte ce qu'il s'est passé :</label>

                <textarea id="ai-raw-notes" class="form-control mb-3 custom-placeholder" rows="12"></textarea>

                <div class="d-flex align-items-center justify-content-between">
                  <button type="button" id="btn-ia-sterna" class="btn btn-primary px-4">
                    Avec l'assistante
                  </button>
                  <div id="ia-status" class="text-muted small font-italic"></div>
                </div>
              </div>

              <script>
                // Injection du placeholder avec les sauts de ligne réels
                const textarea = document.getElementById('ai-raw-notes');
                const placeholderText = "Pour un article riche, essayez d'inclure dans votre note :\n" +
                  "• Qui exactement ? (nombre de participants, profils, origines)\n" +
                  "• Quels ateliers précisément ? (titres, animateurs, durée)\n" +
                  "• Un moment marquant ? (une citation, une anecdote, une émotion)\n" +
                  "• Un chiffre clé ? (budget, bénéficiaires, heures d'échange)\n" +
                  "• Un témoignage ? (une parole forte d'un participant)";

                textarea.placeholder = placeholderText;
              </script>
            </div>
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

  <!-- script pour l'IA Sterna Africa (génération d'article à partir de notes) -->
  <script>
    document.getElementById('btn-ia-sterna').addEventListener('click', async function() {
      const notes = document.getElementById('ai-raw-notes').value;
      const btn = this;
      const status = document.getElementById('ia-status');
      const titleInput = document.getElementById('title');
      const lieuInput = document.getElementById('lieu');

      if (!notes) {
        alert("Veuillez saisir quelques notes sur l'événement pour guider l'assistante.");
        return;
      }

      status.innerText = "L'assistante rédige le contenu…";
      btn.disabled = true;

      const formData = new FormData();
      formData.append('action', 'generer_sterna');

      // 📝 Construction d'un prompt "Expert Asso" pour Sterna Africa
      const promptSterna = `
          Agis en tant que Copywriter Senior et Storyteller engagé pour Sterna Africa.
          Ton style est inspirant, authentique et humain, loin des clichés marketing.

          MISSION :
          Transformer les notes brutes en un article de blog captivant. Sterna Africa apparaît comme le porte-voix de ces initiatives, apportant un regard d'expert et d'allié.

          NOTES À TRAITER : "${notes}"

          RÈGLE D'OR - PAS D'HALLUCINATION :
          - Tu dois STRICTEMENT utiliser uniquement les informations présentes dans les notes.
          - Si les notes manquent de détails (noms, chiffres, ateliers précis), tu dois l'admettre ou rester générique sans inventer.
          - Tu peux reformuler pour le style, mais jamais ajouter de faits non présents.

          STRUCTURE NARRATIVE :
          1. L'ACCROCHE (Le Hook) : Titre percutant + entrée en matière qui pose l'ambiance.
          2. LE RÉCIT : Développe ce qui s'est passé, basé UNIQUEMENT sur les notes.
          3. LE BASCULEMENT : Moment où l'intervention de Sterna crée le changement (si décrit dans les notes).
          4. L'IMPACT : Résultats concrets mentionnés dans les notes.
          5. LA VISION : Conclusion sur l'engagement de Sterna (sans extrapoler).

          CONSIGNES STRICTES :
          - LONGUEUR : Maximum 3000 caractères (environ 400-500 mots). Bref et percutant.
          - Ton : Empathique, professionnel, audacieux. Pas de pathos cheap.
          - Mise en forme : Paragraphes aérés, phrases courtes privilégiées.
          - HTML : <h2> pour sous-titres, <strong> pour emphase, listes si pertinent.
          - EMOJIS : Maximum 2, placés stratégiquement.

          FORMAT DE RÉPONSE (JSON STRICT) :
          {
            "titre": "Titre accrocheur",
            "contenu": "Article formaté en HTML propre",
            "avertissement": "null" ou "Notes insuffisantes pour détailler [aspect manquant]"
          }
      `;

      formData.append('sujet_article', promptSterna);

      try {
        const response = await fetch('https://rebonly.com/ai_gateway.php', {
          method: 'POST',
          body: formData
        });

        let data = await response.json();
        if (Array.isArray(data)) data = data[0];

        // 1. Remplissage de Summernote
        $('#description').summernote('code', data.contenu || data.description);

        // 2. Mise à jour du titre si l'IA en propose un meilleur
        if (data.titre && !titleInput.value) {
          titleInput.value = data.titre;
        }

        status.innerText = "✅ Article rédigé avec succès !";
      } catch (error) {
        console.error("Erreur IA Sterna:", error);
        status.innerText = "❌ Erreur de génération.";
      } finally {
        btn.disabled = false;
      }
    });
  </script>

  <?php require_once('../config/footer_2.php'); ?>
</body>

</html>