<?php
// avis.php

// 1. CONNEXION (Reprise de ton code)
$pdo = new PDO('mysql:host=db;dbname=africa_db', 'root', 'SoftiP24', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// Note : Si ta table users est dans la même base, on utilise $pdo. 
// Sinon, assure-toi que $pdo_users est défini. Ici je vais utiliser $pdo pour la cohérence.
$pdo_users = $pdo;

// 2. LOGIQUE DE DATE (Récolte Idéale)
$today = date('Y-m-d');
$today_dt = new DateTime($today);

// On cherche la mission éligible
$stmt = $pdo->prepare("SELECT * FROM missions WHERE end_date >= DATE_SUB(?, INTERVAL 7 DAY) ORDER BY end_date ASC LIMIT 1");
$stmt->execute([$today]);
$mission = $stmt->fetch();

if (!$mission) {
    echo "<div style='margin-top: 40px; text-align: center; color: #dc2626; font-weight: 600; background-color: #fee2e2; border: 1px solid #fca5a5; padding: 20px; border-radius: 8px; max-width: 600px; margin-left: auto; margin-right: auto;'>
        Aucune mission active ou récemment terminée pour le moment.
    </div>";
    exit;
}

$mission_id = $mission['id'];
$mission_title = $mission['title'];
$mission_end = new DateTime($mission['end_date']);

$opening_date = (clone $mission_end)->modify('-2 days');
$limit_date = (clone $mission_end)->modify('+2 days');

// Vérification de la fenêtre de tir
if ($today_dt < $opening_date) {
    echo "<div style='margin-top: 40px; text-align: center; color: #1e40af; background-color: #dbeafe; border: 1px solid #93c5fd; padding: 20px; border-radius: 8px; max-width: 600px; margin-left: auto; margin-right: auto;'>
        La mission <strong>$mission_title</strong> est encore en cours. <br>
        Le formulaire ouvrira le <strong>" . $opening_date->format('d/m/Y') . "</strong>.
    </div>";
    exit;
}

if ($today_dt > $limit_date) {
    echo "<div style='margin-top: 40px; text-align: center; color: #dc2626; font-weight: 600; background-color: #fee2e2; border: 1px solid #fca5a5; padding: 20px; border-radius: 8px; max-width: 600px; margin-left: auto; margin-right: auto;'>
        La période pour soumettre un témoignage pour la mission <strong>$mission_title</strong> est terminée.
    </div>";
    exit;
}

// 3. RÉCUPÉRATION DES QUESTIONS
$questions_stmt = $pdo->prepare("SELECT * FROM questions WHERE mission_id = ?");
$questions_stmt->execute([$mission_id]);
$questions = $questions_stmt->fetchAll();

if (count($questions) === 0) {
    echo "<div style='margin-top: 40px; text-align: center; color: #dc2626; font-weight: 600; background-color: #fee2e2; border: 1px solid #fca5a5; padding: 20px; border-radius: 8px; max-width: 600px; margin-left: auto; margin-right: auto;'>
        Désolé, il n'y a pas de questions de témoignage pour le moment.
    </div>";
    exit;
}

// 4. GESTION DU FORMULAIRE (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isVolontaire = isset($_GET['volontaire']) && $_GET['volontaire'] == 1;

    if ($isVolontaire) {
        $volontaire_id = $_POST['volontaire_id'];
        $stmt_u = $pdo_users->prepare("SELECT nom, avatar FROM users WHERE id = ?");
        $stmt_u->execute([$volontaire_id]);
        $user = $stmt_u->fetch();

        if (!$user) {
            echo "Utilisateur non trouvé.";
            exit;
        }

        $nom = $user['nom'];
        $photoName = $user['avatar'];
    } else {
        $nom = $_POST['nom'];
        $photo = $_FILES['photo'];
        $targetDir = "./uploads/";
        $photoName = basename($photo["name"]);
        $targetFile = $targetDir . $photoName;

        if (!move_uploaded_file($photo["tmp_name"], $targetFile)) {
            echo "Erreur lors de l'upload de la photo.";
            exit;
        }
    }

    // Insertion du témoignage
    $stmt_t = $pdo->prepare("INSERT INTO temoignages (nom, photo, mission_id, is_volontaire, volontaire_id) VALUES (:nom, :photo, :mission_id, :is_volontaire, :volontaire_id)");
    $stmt_t->execute([
        ':nom' => $nom,
        ':photo' => $photoName,
        ':mission_id' => $mission_id,
        ':is_volontaire' => $isVolontaire ? 1 : 0,
        ':volontaire_id' => $isVolontaire ? $volontaire_id : null
    ]);

    $temoignageId = $pdo->lastInsertId();

    // Insertion des réponses
    foreach ($questions as $q) {
        $reponse = $_POST['question_' . $q['id']] ?? null;
        if ($reponse !== null) {
            $stmt_r = $pdo->prepare("INSERT INTO reponses (temoignage_id, question_id, reponse) VALUES (:temoignage_id, :question_id, :reponse)");
            $stmt_r->execute([
                ':temoignage_id' => $temoignageId,
                ':question_id' => $q['id'],
                ':reponse' => $reponse
            ]);
        }
    }

    header('Location: merci.php');
    exit;
}

// --- AFFICHAGE DU FORMULAIRE HTML (Optionnel, commence ici) ---
echo "<h1>Témoignage : $mission_title</h1>";
?>

<!DOCTYPE html>
<html lang="fr" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback-Mission | Sternaafrica</title>
    <meta property="og:title" content="Votre Avis Compte - Sterna Africa" />
    <meta property="og:description" content="Partagez votre expérience avec Sterna Africa et au reste du monde pour inspirer d'autres." />
    <meta property="og:image" content="https://i.postimg.cc/L6CMKbk0/Design-sans-titre-1.png" />
    <meta property="og:url" content="https://sternaafrica.org/interview" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="Sterna Africa" />

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Dark mode activation -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {},
            },
        }
    </script>

    <!-- Favicons -->
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="icon">
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="apple-touch-icon">
</head>

<body class="bg-gray-900 text-white min-h-screen flex items-start justify-center mt-20">

    <div class="container mx-auto px-4">
        <section id="temoignage-section" class="w-full max-w-2xl mx-auto p-2 bg-gray-800 rounded-lg shadow-lg">

            <h5 class="text-2xl font-semibold border-b border-gray-700 pb-4 mb-6 flex items-center gap-2 text-blue-400">
                Un témoignage peut tout changer — Votre voix, la clé.
            </h5>

            <?php
            $isVolontaire = isset($_GET['volontaire']) && $_GET['volontaire'] == 1;

            // Si volontaire, on récupère la liste pour le champ select
            $volontaires = [];
            if ($isVolontaire) {
                $stmt = $pdo_users->query("SELECT id, nom, prenom FROM users ORDER BY nom ASC");
                $volontaires = $stmt->fetchAll();
            }
            ?>

            <form id="temoignage-form" enctype="multipart/form-data" method="POST" class="space-y-6">

                <!-- 🚩 ÉTAPE 1 : Identification (volontaire ou non) -->
                <div class="form-step active-step">
                    <?php if ($isVolontaire): ?>
                        <!-- ✅ Si volontaire : sélection dans la liste -->
                        <label for="volontaire_id" class="block mb-2 text-sm font-medium text-white">Je suis :</label>
                        <select id="volontaire_id" name="volontaire_id"
                            class="form-control w-full p-3 rounded bg-gray-700 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-400 focus:outline-none"
                            required>
                            <option value="">-- Sélectionnez votre nom --</option>
                            <?php foreach ($volontaires as $v): ?>
                                <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['nom'] . ' ' . $v['prenom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <!-- ✅ Si non volontaire : saisir un nom + uploader une photo -->
                        <label for="nom" class="block mb-2 text-sm font-medium text-white">Prénom ou Pseudonyme</label>
                        <input type="text" id="nom" name="nom"
                            class="form-control w-full p-3 rounded bg-gray-700 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-400 focus:outline-none"
                            required>

                        <label for="photo" class="block mb-2 text-sm font-medium text-white mt-4">Photo</label>
                        <input type="file" id="photo" name="photo" accept="image/*"
                            class="w-full p-3 rounded bg-gray-700 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-400 focus:outline-none"
                            required>
                        <!-- Affiche les erreurs ici -->
                        <p id="errorMessage" class="text-red-500 text-sm mt-2"></p>

                        <!-- Prévisualisation image -->
                        <img id="preview" class="mt-4 w-32 h-32 object-cover rounded hidden" />

                    <?php endif; ?>
                </div>

                <!-- 🚩 ÉTAPES SUIVANTES : questions dynamiques -->
                <?php foreach ($questions as $index => $question) : ?>
                    <div class="form-step hidden">
                        <label for="question_<?php echo $question['id']; ?>" class="block mb-2 text-lg font-semibold text-white">
                            <?php echo htmlspecialchars($question['question_text']); ?>
                        </label>
                        <textarea id="question_<?php echo $question['id']; ?>" name="question_<?php echo $question['id']; ?>" placeholder="Votre réponse..." required
                            class="w-full p-3 rounded bg-gray-700 border border-gray-600 focus:border-blue-500 focus:ring focus:ring-blue-400 focus:outline-none h-40"></textarea>
                    </div>
                <?php endforeach; ?>

                <!-- 🚩 Navigation entre étapes -->
                <div class="form-navigation flex justify-between items-center pt-6">
                    <button type="button" id="prev-btn" class="hidden bg-gray-700 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded transition-all">Précédent</button>
                    <button type="button" id="next-btn" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded transition-all">Suivant</button>
                    <button type="submit" id="submit-btn" class="hidden bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded transition-all">Envoyer</button>
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

            const photoInput = document.getElementById("photo"); // Peut ne pas exister
            const errorMessage = document.getElementById("errorMessage"); // Peut ne pas exister
            const preview = document.getElementById("preview"); // Peut ne pas exister

            // 👉 Affiche uniquement l'étape actuelle
            function showStep(step) {
                steps.forEach((element, index) => {
                    element.classList.toggle("hidden", index !== step);
                });

                // 👉 Gère l'affichage des boutons selon l'étape
                prevBtn.classList.toggle("hidden", step === 0);
                nextBtn.classList.toggle("hidden", step === steps.length - 1);
                submitBtn.classList.toggle("hidden", step !== steps.length - 1);
            }

            // 👉 Bouton "Suivant"
            nextBtn.addEventListener("click", function() {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            });

            // 👉 Bouton "Précédent"
            prevBtn.addEventListener("click", function() {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            // 👉 Initialisation de l'affichage
            showStep(currentStep);

            // 👉 Gestion de l'image uniquement si le champ existe (non volontaire)
            if (photoInput) {
                photoInput.addEventListener("change", function(event) {
                    const file = event.target.files[0];
                    const allowedTypes = ["image/jpeg", "image/jpg", "image/png"];
                    const maxSize = 2 * 1024 * 1024; // 2 Mo

                    if (errorMessage) errorMessage.textContent = "";
                    if (preview) preview.classList.add("hidden");

                    if (!file) {
                        if (errorMessage) errorMessage.textContent = "Veuillez sélectionner une image.";
                        return;
                    }

                    if (!allowedTypes.includes(file.type)) {
                        if (errorMessage) errorMessage.textContent = "Seuls les fichiers JPEG, JPG et PNG sont autorisés.";
                        photoInput.value = "";
                        return;
                    }

                    if (file.size > maxSize) {
                        if (errorMessage) errorMessage.textContent = "La taille du fichier ne doit pas dépasser 2 Mo.";
                        photoInput.value = "";
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (preview) {
                            preview.src = e.target.result;
                            preview.classList.remove("hidden");
                        }
                    };
                    reader.readAsDataURL(file);
                });
            }
        });
    </script>


    <?php require_once('config/footer_2.php'); ?>
</body>

</html>