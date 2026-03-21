<?php
require_once '../config/db.php';
session_start();
if (!isset($_SESSION['admin_quiz_id'])) {
    header("Location: login");
    exit;
}

$questions = $conn->query("
    SELECT q.id, q.question, c.nom AS categorie
    FROM question_quiz q
    LEFT JOIN categorie_quiz c ON q.categorie_id = c.id
    ORDER BY c.nom ASC
");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_id = intval($_POST['question_id']);
    $reponse = sanitize_input($_POST['reponse'], $conn);
    $correcte = isset($_POST['correcte']) ? 1 : 0;

    if (!empty($question_id) && !empty($reponse)) {
        $stmt = $conn->prepare("INSERT INTO reponse_quiz (question_id, reponse, correcte) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $question_id, $reponse, $correcte);
        if ($stmt->execute()) {
            $success = "Réponse ajoutée avec succès ✅";
        } else {
            $error = "Erreur lors de l'ajout.";
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
    <title>Ajouter une réponse</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">
    <div class="bg-gray-800 p-8 rounded-2xl shadow-xl w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Ajouter une Réponse</h2>

        <?php if (!empty($success)): ?>
            <div class="bg-green-600 text-white p-3 rounded mb-4 text-center"><?= $success ?></div>
        <?php elseif (!empty($error)): ?>
            <div class="bg-red-600 text-white p-3 rounded mb-4 text-center"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Question liée</label>
                <select name="question_id" required class="w-full bg-gray-700 border border-gray-600 rounded-xl py-3 px-4 text-white">
                    <option value="">-- Choisir une question --</option>
                    <?php while ($q = $questions->fetch_assoc()): ?>
                        <option value="<?= $q['id'] ?>">
                            <?= htmlspecialchars($q['categorie']) ?> — <?= htmlspecialchars($q['question']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Texte de la réponse</label>
                <textarea name="reponse" rows="3" required class="w-full bg-gray-700 border border-gray-600 rounded-xl py-3 px-4 text-white"></textarea>
            </div>

            <label class="flex items-center space-x-2">
                <input type="checkbox" name="correcte" class="rounded bg-gray-700 border-gray-600 text-purple-600 focus:ring-purple-500">
                <span class="text-sm text-gray-300">Ceci est la bonne réponse</span>
            </label>

            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white py-3 rounded-xl transition-all duration-300">
                Ajouter
            </button>

            <div class="text-center mt-4">
                <a href="dashboard" class="text-purple-400 hover:text-purple-300">← Retour au tableau de bord</a>
            </div>
        </form>
    </div>
</body>

</html>