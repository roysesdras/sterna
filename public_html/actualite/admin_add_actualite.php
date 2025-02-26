<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="../assets/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/img/logos/sternaofficiel-2.png" rel="icon">
    
    <title>Ajouter nouvelle actualité</title>
    <link rel="canonical" href="https://sternaafrica.org/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Inclure Summernote CSS et JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

</head>
<body>
  <?php 
  include_once ('../inclusion/mode_theme.php'); 
  // Connexion à la base de données
  $servername = "localhost"; // Change si nécessaire
  $username = "u694220522_sterna_africa"; // Remplace avec ton nom d'utilisateur
  $password = "@sterna_Africa225"; // Remplace avec ton mot de passe
  $dbname = "u694220522_africa_db"; // Remplace avec le nom de ta base de données

  // Création de la connexion
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Vérification de la connexion
  if ($conn->connect_error) {
      die("Échec de la connexion : " . $conn->connect_error);
  }

  // Requête pour récupérer les témoignages
  $sql = "SELECT id, nom FROM temoignages ORDER BY id DESC";
  $result = $conn->query($sql);
  ?>

  <div class="container">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <h2 class="comic-neue-bold mb-4">Ajouter une Nouvelle Actualité</h2>

        <form action="traitement_insert_actualite.php" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="title" class="form-label comic-neue-regular">Titre :</label>
                <input type="text" class="form-control comic-neue-regular" id="title" name="title" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="start_date" class="form-label comic-neue-regular">Début date :</label>
                <input type="date" class="form-control comic-neue-regular" id="start_date" name="start_date" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="end_date" class="form-label comic-neue-regular">Fin date :</label>
                <input type="date" class="form-control comic-neue-regular" id="end_date" name="end_date" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="image" class="form-label comic-neue-regular">Image :</label>
                <input type="file" class="form-control comic-neue-regular" id="image" name="image" required>
              </div>
            </div>
          </div>
            
          <div class="mb-3">
            <label for="description" class="form-label comic-neue-regular">Contenu :</label>
            <textarea class="form-control comic-neue-regular" id="description" name="description" required></textarea>
          </div>
          
          <div class="mb-3">
            <label for="temoignages" class="form-label comic-neue-regular">Sélectionner des Participants :</label>
            <select class="form-control comic-neue-regular" style="height: 200px;" id="temoignages" name="temoignages[]" multiple>
                <?php
                // Génération des options à partir de la base de données
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($row["nom"]) . "</option>";
                    }
                } else {
                    echo "<option disabled>Aucun témoignage disponible</option>";
                }
                // Fermeture de la connexion
                $conn->close();
                ?>
            </select>


          </div>

          <div class="text-start mb-4 pt-3">
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
            placeholder: '✍️ Votre contenu ici...',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['codeview', 'help']],
                ['misc', ['undo', 'redo']],
                ['alignment', ['alignleft', 'aligncenter', 'alignright', 'justify']],
                ['highlight', ['highlight']]
            ]
        });
    });
  </script>

  <?php require_once('../config/footer_2.php'); ?>   
</body>
</html>
