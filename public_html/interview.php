<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=u694220522_africa_db', 'u694220522_sterna_africa', '@sterna_Africa225');

    // Traitement de l'upload de la photo
    $photo = $_FILES['photo'];
    $targetDir = "./uploads/";
    $targetFile = $targetDir . basename($photo["name"]);
    
    if (move_uploaded_file($photo["tmp_name"], $targetFile)) {
        // Récupérer les autres champs du formulaire
        $nom = $_POST['nom'];
        $question1 = $_POST['question1'];
        $question2 = $_POST['question2'];
        $question3 = $_POST['question3'];
        $question4 = $_POST['question4'];
        $question5 = $_POST['question5'];
        $question6 = $_POST['question6'];
        $question7 = $_POST['question7'];
        $question8 = $_POST['question8'];
        $question9 = $_POST['question9'];

        // Insertion dans la base de données
        $sql = "INSERT INTO temoignages (nom, photo, question1, question2, question3, question4, question5, question6, question7, question8, question9) 
                VALUES (:nom, :photo, :question1, :question2, :question3, :question4, :question5, :question6, :question7, :question8, :question9)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':photo' => $photo['name'],
            ':question1' => $question1,
            ':question2' => $question2,
            ':question3' => $question3,
            ':question4' => $question4,
            ':question5' => $question5,
            ':question6' => $question6,
            ':question7' => $question7,
            ':question8' => $question8,
            ':question9' => $question9
        ]);

        // Redirection après soumission
        header('Location: merci.php');
    } else {
        echo "Erreur lors de l'upload de la photo.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="./assets/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Favicons -->
    <link href="./assets/img/favicon1.png" rel="icon">
    <link href="./assets/img/apple-touch-icon1.png" rel="apple-touch-icon">
    <!-- meta for og.graph -->
    <meta property="og:image" content="https://i.postimg.cc/Hsj1pCDs/temoignagept-blog.png" />
    <meta property="og:url" content="https://sternaafrica.org/" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="sternaafrica" />
    <link rel="stylesheet" href="./assets/styles.css">
    <title>Interviews</title>
</head>
<style>
    /* Style pour le formulaire */
.form-step {
    display: none; /* Masquer toutes les étapes par défaut */
    margin-bottom: 20px; /* Espacement entre les étapes */
    padding: 15px; /* Augmentation de l'espacement interne */
    border-radius: 8px; /* Arrondi des coins */
    background-color: #transparent; /* Couleur de fond blanc pour une apparence propre */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Ombre portée douce */
    transition: all 0.3s ease; /* Transition douce pour l'affichage */
}

.form-step.active-step {
    display: block; /* Afficher uniquement l'étape active */
}

.form-navigation {
    margin-top: 20px; /* Espacement au-dessus des boutons de navigation */
    text-align: right; /* Aligner les boutons à droite */
}

.btn-primary {
    background-color: #305196; /* Couleur de fond bleu pour le bouton Suivant */
    color: white; /* Couleur du texte blanc */
    transition: background-color 0.3s; /* Transition pour le changement de couleur */
    border: solid 1px #305196;
    padding: 5px;
    border-radius:3px;
}

.btn-primary:hover {
    background-color: transparent; /* Couleur au survol */
    color: #5a6268; /* Couleur du texte blanc */
    transition: background-color 0.3s; /* Transition pour le changement de couleur */
    border: solid 1px #305196;
    padding: 5px;
    border-radius:3px;
}

.btn-secondary {
    background-color: #6c757d; /* Couleur de fond gris pour le bouton Précédent */
    color: white; /* Couleur du texte blanc */
    transition: background-color 0.3s; /* Transition pour le changement de couleur */
    border: solid 1px #6c757d;
    padding: 5px;
    border-radius:3px;
}

.btn-secondary:hover {
    background-color: #5a6268; /* Couleur au survol */
    background-color: transparent; /* Couleur au survol */
    color: #5a6268; /* Couleur du texte blanc */
    transition: background-color 0.3s; /* Transition pour le changement de couleur */
    border: solid 1px #5a6268;
    padding: 5px;
    border-radius:3px;
}

.btn-success {
    background-color: #28a745; /* Couleur de fond vert pour le bouton Envoyer */
    color: white; /* Couleur du texte blanc */
    transition: background-color 0.3s; /* Transition pour le changement de couleur */
    border: solid 1px #28a745;
    padding: 5px;
    border-radius:3px;
}

.btn-success:hover {
    background-color: transparent; /* Couleur au survol */
    color: #28a745; /* Couleur du texte blanc */
    transition: background-color 0.3s; /* Transition pour le changement de couleur */
    border: solid 1px #28a745;
    padding: 5px;
    border-radius:3px;
}

/* Amélioration de l'apparence des champs de formulaire */
.form-control {
    width: 100%; /* Prendre toute la largeur */
    padding: 10px; /* Espacement interne */
    border: 1px solid #ced4da; /* Bordure légère */
    border-radius: 4px; /* Arrondi des coins */
    transition: border-color 0.3s; /* Transition pour la bordure */
}

.form-control:focus {
    border-color: #007bff; /* Couleur de bordure lors du focus */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Ombre lors du focus */
}
textarea {
    height: 150px;
} 

</style>

<body>
<div class="container">
    <section id="temoignage-section">
        
        <?php require_once ('config/mode_theme.php'); ?>
            <h3 class="pt-4 pb-4 mb-4 fst-italic border-bottom" style="color:#305196;"><i class="fas fa-comments"></i> Témoignez votre expérience</h3>

            <form id="temoignage-form" enctype="multipart/form-data" method="POST">

                <!-- Étape 1 : Nom -->
                <div class="form-step active-step comic-neue-regular">
                    <label for="nom">Prénom ou Pseudonyme</label>
                    <input type="text" id="nom" name="nom" class="form-control" required>
                </div>
                
                <!-- Étape 2 : Photo -->
                <div class="form-step comic-neue-regular">
                    <label for="photo">Photo (importez une photo)</label>
                    <input type="file" id="photo" name="photo" class="form-control" accept="image/*" required>
                </div>

                <!-- Étape 3 : Question 1 -->
                <div class="form-step comic-neue-regular">
                    <label for="question1">Quelles étaient vos principales motivations pour participer à cette mission ?</label>
                    <textarea id="question1" name="question1" class="form-control" required placeholder="Parlez nous de vos principales motivations."></textarea>
                </div>

                <!-- Étape 4 : Question 2 -->
                <div class="form-step comic-neue-regular">
                    <label for="question2">Quelles étaient vos attentes avant la mission ? Ont-elles été atteintes ?</label>
                    <textarea id="question2" name="question2" class="form-control" required placeholder="Partagez avec nous vos attentes initiales avant de commencer cette mission et dites-nous si elles ont été pleinement atteinte."></textarea>
                </div>

                <!-- Étape 5 : Question 3 -->
                <div class="form-step comic-neue-regular">
                    <label for="question3">Comment évaluez-vous l'organisation et la préparation en amont de la mission ?</label>
                    <textarea id="question3" name="question3" class="form-control" required placeholder="Veuillez indiquer si vous avez reçu des informations logistiques avant le départ de la mission."></textarea>
                </div>

                <!-- Étape 6 : Question 4 -->
                <div class="form-step comic-neue-regular">
                    <label for="question4">Comment décririez-vous vos interactions avec les habitants du village ?</label>
                    <textarea id="question4" name="question4" class="form-control" required placeholder="Partagez votre expérience de l'accueil, des echanges avec les habitants du village."></textarea>
                </div>

                <!-- Étape 7 : Question 5 -->
                <div class="form-step comic-neue-regular">
                    <label for="question5">Comment s'est déroulée la vie sur place durant cette mission ?</label>
                    <textarea id="question5" name="question5" class="form-control" placeholder="Décrivez les conditions de vie sur place pendant la mission." required></textarea>
                </div>

                <!-- Étape 8 : Question 6 -->
                <div class="form-step comic-neue-regular">
                    <label for="question6">Quelles activités ou tâches avez-vous réalisées pendant la mission ?</label>
                    <textarea id="question6" name="question6" class="form-control" placeholder="Indiquez les activités ou tâches que vous avez effectuées durant la mission." required></textarea>
                </div>

                <!-- Étape 9 : Question 7 -->
                <div class="form-step comic-neue-regular">
                    <label for="question7">Quelles difficultés avez-vous rencontrées durant la mission et quelles suggestions proposeriez-vous pour les prochaines missions ?</label>
                    <textarea id="question7" name="question7" class="form-control" placeholder="Partagez les difficultés rencontrées pendant la mission et des propositions d'amelioration." required></textarea>

                </div>

                <!-- Étape 10 : Question 8 -->
                <div class="form-step comic-neue-regular">
                    <label for="question8">En tant que participant, Comment cette mission a-t-elle influencé votre perception de la solidarité internationale ?</label>
                    <textarea id="question8" name="question8" class="form-control" placeholder="Expliquez comment cette mission a impacté votre vision de la solidarité internationale." required></textarea>
                </div>

                <!-- Étape 11 : Question 9 -->
                <div class="form-step comic-neue-regular">
                    <label for="question9">Partagez-nous un souvenir marquant ou un moment qui vous a particulierement touché lors de cette mission ?</label>
                    <textarea id="question9" name="question9" class="form-control" placehoder="" required></textarea>
                </div>

                <!-- Boutons de navigation -->
                <div class="form-navigation mb-4">
                    <button type="button" id="prev-btn" class="btn-secondary" style="display:none;">Précédent</button>
                    <button type="button" id="next-btn" class="btn-primary">Suivant</button>
                    <button type="submit" id="submit-btn" class="btn-success" style="display:none;">Envoyer</button>
                </div>
            </form>
        
    </section>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let currentStep = 0;
        const steps = document.querySelectorAll(".form-step");
        const nextBtn = document.getElementById("next-btn");
        const prevBtn = document.getElementById("prev-btn");
        const submitBtn = document.getElementById("submit-btn");

        function showStep(step) {
            steps.forEach((element, index) => {
                element.classList.toggle("active-step", index === step);
            });

            prevBtn.style.display = step === 0 ? "none" : "inline-block";
            nextBtn.style.display = step === steps.length - 1 ? "none" : "inline-block";
            submitBtn.style.display = step === steps.length - 1 ? "inline-block" : "none";
        }

        nextBtn.addEventListener("click", function() {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });

        prevBtn.addEventListener("click", function() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });

        submitBtn.addEventListener("click", function() {
            document.getElementById("temoignage-form").submit(); // Soumettre le formulaire
        });

        showStep(currentStep); // Initialize the form to show the first question
    });
</script>


    <?php  require_once('config/footer_2.php'); ?>
</body>
</html>