<?php
require_once '../config/db.php';
session_start();
if (!isset($_SESSION['admin_quiz_id'])) {
    header("Location: login");
    exit;
}

// Récupérer les catégories
$categories = $conn->query("SELECT * FROM categorie_quiz ORDER BY nom ASC");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categorie_id = intval($_POST['categorie_id']);
    $question = sanitize_input($_POST['question'], $conn);
    $reponses = $_POST['reponses'] ?? [];
    $bonne_reponse = intval($_POST['bonne_reponse'] ?? -1);

    if (!empty($categorie_id) && !empty($question) && !empty($reponses)) {
        // Insertion de la question
        $stmt = $conn->prepare("INSERT INTO question_quiz (categorie_id, question) VALUES (?, ?)");
        $stmt->bind_param("is", $categorie_id, $question);
        if ($stmt->execute()) {
            $question_id = $stmt->insert_id;

            // Insertion des réponses
            $stmt_rep = $conn->prepare("INSERT INTO reponse_quiz (question_id, reponse, correcte) VALUES (?, ?, ?)");

            $bonnes_reponses = $_POST['bonne_reponse'] ?? []; // tableau des index cochés

            foreach ($reponses as $index => $texte) {
                $texte = sanitize_input($texte, $conn);
                $correcte = in_array($index, $bonnes_reponses) ? 1 : 0;
                $stmt_rep->bind_param("isi", $question_id, $texte, $correcte);
                $stmt_rep->execute();
            }


            $success = "Question et réponses ajoutées avec succès ✅";
        } else {
            $error = "Erreur lors de l'ajout de la question.";
        }
    } else {
        $error = "Tous les champs sont obligatoires.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter une Question et ses Réponses</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        function addReponseField() {
            const container = document.getElementById('reponsesContainer');
            const index = container.children.length;
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2 mb-2';
            div.innerHTML = `
                <input type="checkbox" name="bonne_reponse[]" value="${index}" class="text-purple-600 focus:ring-purple-500">

                <textarea name="reponses[]" required rows="2" 
                    class="flex-1 bg-gray-700 border border-gray-600 rounded-xl py-2 px-3 text-white placeholder-gray-500 resize" 
                    placeholder="Entrez la réponse ici..."></textarea>

                <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-300">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(div);
        }
    </script>

    <script src="https://kit.fontawesome.com/a2e0e6ad8f.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">
    <div class="bg-gray-800 p-8 rounded-2xl shadow-xl w-full max-w-2xl">
        <h2 class="text-2xl font-bold text-center mb-6">Ajouter une Question & Réponses</h2>

        <?php if (!empty($success)): ?>
            <div class="bg-green-600 text-white p-3 rounded mb-4 text-center"><?= $success ?></div>
        <?php elseif (!empty($error)): ?>
            <div class="bg-red-600 text-white p-3 rounded mb-4 text-center"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-md font-medium text-gray-300 mb-2">Catégorie</label>
                <select name="categorie_id" required
                    class="w-full bg-gray-700 border border-gray-600 rounded-xl py-3 px-4 text-white">
                    <option value="">-- Choisir une catégorie --</option>
                    <?php while ($cat = $categories->fetch_assoc()): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label class="block text-md font-medium text-gray-300 mb-2">Question</label>
                <textarea name="question" rows="2" required
                    class="w-full bg-gray-700 border border-gray-600 rounded-xl py-3 px-4 text-white"></textarea>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-md font-medium text-gray-300">Réponses possibles</label>
                    <button type="button" onclick="addReponseField()"
                        class="text-sm text-purple-400 hover:text-purple-300">
                        + Ajouter une réponse
                    </button>
                </div>
                <div id="reponsesContainer">
                    <!-- champs dynamiques ici -->
                </div>
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white py-3 rounded-xl transition-all duration-300">
                Enregistrer la question
            </button>

            <div class="text-start mt-4">
                <a href="dashboard" class="text-purple-400 hover:text-purple-300">← Retour au tableau de bord</a>
            </div>
        </form>
    </div>
</body>

</html>