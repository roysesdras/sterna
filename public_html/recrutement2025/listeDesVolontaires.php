<?php
// Connexion à la base de données via PDO
$servername = "localhost";
$username = "u694220522_sterna_africa";
$password = "@sterna_Africa225";
$dbname = "u694220522_africa_db";

try {
    // Créer une connexion PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Définir le mode d'erreur de PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Masquer les informations sensibles dans l'erreur
    die("Erreur de connexion à la base de données. Veuillez contacter l'administrateur.");
}

// Supprimer un abonné
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM benevoles WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Candidat supprimé avec succès.</div>";
        } else {
            echo "<div class='alert alert-danger'>Erreur lors de la suppression du candidat.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>ID invalide.</div>";
    }
}

// Récupérer les données
$sql = "SELECT * FROM benevoles";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Préparer les e-mails pour le lien mailto
$emails = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $emails[] = htmlspecialchars($row['email']); // Protection contre les attaques XSS
}

// Créer un lien mailto si des e-mails existent
$mailto_link = '';
if (!empty($emails)) {
    $to = "sternaafrica@gmail.com, eesseulrich@gmail.com"; // Ajouter une deuxième adresse e-mail
    $cc = implode(',', $emails); // Liste des e-mails des candidats
    $mailto_link = "mailto:$to?cc=$cc"; // Lien mailto avec CC rempli
}

?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="auto">
<head>
    <script src="../assets/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des bénévoles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Favicons -->
    <link href="../assets/img/favicon1.png" rel="icon">
    <link href="../assets/img/apple-touch-icon1.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="../assets/styles.css">

    <style>
        /* Style de l'image miniature */
        .thumbnail-image {
            max-width: 100%;
            object-fit: cover;
            cursor: pointer;
        }

        /* Style de la fenêtre modale */
        .modal {
            display: none; /* Cachée par défaut */
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Ombre de fond */
            justify-content: center;
            align-items: center;
        }

        /* Style de l'image dans la fenêtre modale */
        .modal-content {
            max-width: 80%;
            max-height: 100%;
            margin: auto;
            display: block;
        }

        /* Bouton de fermeture */
        .close-btn {
            color: white;
            font-size: 30px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 25px;
            cursor: pointer;
        }

        /* Élégir les cellules <td> */
td {
    width: 250px; /* Ajustez la largeur en fonction de vos besoins */
    padding: 15px; /* Espacement à l'intérieur des cellules */
    word-wrap: break-word; /* Pour gérer le texte long */
}

/* Élégir les en-têtes <th> */
th {
    width: 250px; /* Ajustez la largeur en fonction de vos besoins */
    padding: 15px; /* Espacement à l'intérieur des cellules d'en-tête */
    text-align: left; /* Vous pouvez ajuster l'alignement selon vos préférences */
}

/* Pour que le tableau s'ajuste selon l'écran */
table {
    width: 100%; /* Le tableau prendra 100% de la largeur disponible */
    table-layout: fixed; /* Permet de fixer la largeur des colonnes */
}


    </style>
    
</head>
<body>
<div class="container-fluid mt-5">
    <?php require_once ('../config/mode_theme.php'); ?>
    <h2 class="text-center mb-4">Liste des volontaires recrutés</h2>

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle" style="border-radius: 8px; overflow: hidden;">
            <thead class="table-dark">
                <tr>
                    <th>Photo du volontaire</th>
                    <th>Nom et Prenom</th>
                    <th>Adresse E-mail</th>
                    <th>Numéro WhatsApp</th>
                    <th>Nationalité.e</th>
                    <th>Âge du volontaire</th>
                    <th>Profession du volontaire</th>
                    <th>Organisat.. actuelle</th>
                    <th>Nom de l'organisat..</th>
                    <th>Membre d'une organisat..</th>
                    <th>Nom l'organisat.. membre</th>
                    <th>Canal de communicat..</th>
                    <th>Motivation du volontaire</th>
                    <th>Déf. Volontariat</th>
                    <th>Engagement</th>
                    <th>Disponibilité au activités</th>
                    <th>Passeport</th>
                    <th>3 Qualités du volontaire</th>
                    <th>3 Défauts du volontaire</th>
                    <th>Apport nouvel</th>
                    <th>Dernier mot</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Vérifier s'il y a des abonnés
                if ($stmt->rowCount() > 0):
                    $stmt->execute(); // Réexécuter la requête pour itérer à nouveau
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td>
                                <?php if (!empty($row['image_path'])): ?>
                                    <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Image" class="thumbnail-image" data-fullsize="<?php echo htmlspecialchars($row['image_path']); ?>">
                                <?php else: ?>
                                    Pas d'image
                                <?php endif; ?>
                            </td>

                            <!-- Fenêtre modale pour l'image agrandie -->
                            <div id="imageModal" class="modal">
                                <span class="close-btn">&times;</span>
                                <img id="modalImage" class="modal-content">
                            </div>

                            <script>
                                // Ouvrir l'image dans la fenêtre modale
                                document.querySelectorAll('.thumbnail-image').forEach(function (img) {
                                    img.addEventListener('click', function () {
                                        var modal = document.getElementById('imageModal');
                                        var modalImage = document.getElementById('modalImage');
                                        modal.style.display = 'block'; // Affiche la modale
                                        modalImage.src = this.dataset.fullsize; // Charge l'image en taille réelle
                                    });
                                });

                                // Fermer la fenêtre modale en cliquant sur le fond ou sur le bouton de fermeture
                                document.querySelector('.close-btn').addEventListener('click', function () {
                                    document.getElementById('imageModal').style.display = 'none'; // Ferme la modale
                                });

                                window.onclick = function(event) {
                                    if (event.target == document.getElementById('imageModal')) {
                                        document.getElementById('imageModal').style.display = 'none'; // Ferme la modale si on clique en dehors de l'image
                                    }
                                };

                            </script>

                            <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['numero']); ?></td>
                            <td><?php echo htmlspecialchars($row['nationalite']); ?></td>
                            <td><?php echo htmlspecialchars($row['age']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['profession'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['organisation'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['nom_organisation'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['membre'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['nom_membre_organisation'])); ?></td>
                            <td><?php echo htmlspecialchars($row['sources']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['motivation'])); ?></td>

 
                            <td><?php echo nl2br(htmlspecialchars($row['volonteer'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['engagement_gratuit'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['disponibilite'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['passeport'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['qualites'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['defauts'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['apport'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['dernierMot'])); ?></td>
                            <td>
                                <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-sm" 
                                onclick="return confirm('Etes-vous sûr de vouloir supprimer cet enregistrement ?');">
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="18" class="text-center">Aucun recru pour le moment.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <form method="POST" action="" class="mb-3 mt-3 text-left">
        <!-- Lien mailto pour ouvrir le client de messagerie avec toutes les adresses en CC -->
        <?php if ($mailto_link): ?>
            <a href="<?php echo htmlspecialchars($mailto_link); ?>" class="btn ">Envoyer un e-mail à tous</a>
        <?php else: ?>
            <button type="button" class="btn btn-secondary" disabled>Aucun recru à contacter</button>
        <?php endif; ?>
    </form>
</div>

<?php require_once('../config/footer_2.php'); ?>
</body>
</html>


<?php
// Fermer la connexion PDO
$conn = null;
?>
