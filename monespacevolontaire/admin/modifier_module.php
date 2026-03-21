<?php
// modifier_module.php
require_once '../inclusion/db.php';

// Vérifier si l'ID est passé
if (!isset($_GET['id'])) {
    die("ID du module manquant.");
}

$id = (int) $_GET['id'];

// Récupérer le module existant
$stmt = $pdo->prepare("SELECT * FROM modules WHERE id = ?");
$stmt->execute([$id]);
$module = $stmt->fetch();

// Récupérer les questions existantes
$stmt = $pdo->prepare("SELECT * FROM questions WHERE module_id = ?");
$stmt->execute([$id]);
$questions = $stmt->fetchAll();


if (!$module) {
    die("Module introuvable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'] ?? '';
    $description = $_POST['description'] ?? '';
    $ordre = $_POST['ordre'] ?? 0;
    $date_disponibilite = $_POST['date_disponibilite'] ?? null;
    $video_url = $_POST['video_url'] ?? '';
    $exercice_url = $_POST['exercice_url'] ?? '';
    $exercice_facultatif = isset($_POST['exercice_facultatif']) ? 1 : 0;
    $visible = isset($_POST['visible']) ? 1 : 0;

    // Mise à jour du module
    $sql = "UPDATE modules SET titre=?, description=?, ordre=?, date_disponibilite=?, video_url=?, exercice_url=?, exercice_facultatif=?, visible=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titre, $description, $ordre, $date_disponibilite, $video_url, $exercice_url, $exercice_facultatif, $visible, $id]);

    // Mise à jour des questions existantes
    if (!empty($_POST['existing_questions'])) {
        $updateStmt = $pdo->prepare("UPDATE questions SET question_text = ? WHERE id = ?");
        foreach ($_POST['existing_questions'] as $questionId => $questionText) {
            $questionText = trim($questionText);
            if (!empty($questionText)) {
                $updateStmt->execute([$questionText, $questionId]);
            }
        }
    }

    // Ajout de nouvelles questions
    if (!empty($_POST['new_questions'])) {
        $insertStmt = $pdo->prepare("INSERT INTO questions (module_id, question_text, date_creation) VALUES (?, ?, NOW())");
        foreach ($_POST['new_questions'] as $newQuestionText) {
            $newQuestionText = trim($newQuestionText);
            if (!empty($newQuestionText)) {
                $insertStmt->execute([$id, $newQuestionText]);
            }
        }
    }

    // Redirection après TOUT traitement
    header('Location: https://monespacevolontaire.sternaafrica.org/admin?section=orders');
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un module</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://sternaafrica.org/assets/img/favicon.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/apple-touch-icon.png" rel="apple-touch-icon">
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded-xl shadow-lg">
        <h2 class="text-3xl font-bold text-center text-blue-800 mb-6">Modifier le module du jour</h2>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium">Titre</label>
                <input type="text" name="titre" value="<?= htmlspecialchars($module['titre']) ?>" required class="mt-1 w-full border border-gray-300 rounded-md shadow-sm p-2" />
            </div>

            <div>
                <label class="block text-sm font-medium">Objectifs</label>
                <textarea name="description" required class="mt-1 w-full border border-gray-300 rounded-md shadow-sm p-2"><?= htmlspecialchars($module['description']) ?></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Ordre</label>
                    <input type="number" name="ordre" value="<?= $module['ordre'] ?>" required class="mt-1 w-full border border-gray-300 rounded-md shadow-sm p-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium">Date de disponibilité</label>
                    <input type="date" name="date_disponibilite" value="<?= $module['date_disponibilite'] ?>" required class="mt-1 w-full border border-gray-300 rounded-md shadow-sm p-2" />
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium">URL de la vidéo</label>
                <input type="url" name="video_url" value="<?= htmlspecialchars($module['video_url']) ?>" class="mt-1 w-full border border-gray-300 rounded-md shadow-sm p-2" />
            </div>

            <div>
                <label class="block text-sm font-medium">URL de l'exercice</label>
                <input type="url" name="exercice_url" value="<?= htmlspecialchars($module['exercice_url']) ?>" class="mt-1 w-full border border-gray-300 rounded-md shadow-sm p-2" />
            </div>

            <div class="flex items-center gap-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="exercice_facultatif" class="form-checkbox text-blue-600" <?= $module['exercice_facultatif'] ? 'checked' : '' ?>>
                    <span class="ml-2 text-sm">Exercice facultatif</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="visible" class="form-checkbox text-blue-600" <?= $module['visible'] ? 'checked' : '' ?>>
                    <span class="ml-2 text-sm">Visible pour les volontaires</span>
                </label>
            </div>

            <!-- Questions -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Questions existantes</h3>
                <?php foreach ($questions as $q): ?>
                    <textarea name="existing_questions[<?= $q['id'] ?>]" class="w-full border border-gray-300 rounded-md shadow-sm p-2 mb-2"><?= htmlspecialchars($q['question_text']) ?></textarea>
                <?php endforeach; ?>
            </div>

            <div>
                <label class="block text-sm font-medium">Ajouter des questions</label>
                <div id="new-questions-container" class="space-y-2 mt-2">
                    <textarea name="new_questions[]" class="w-full border border-gray-300 rounded-md shadow-sm p-2" placeholder="Ajouter une nouvelle question..."></textarea>
                </div>
                <button type="button" id="add-new-question" class="mt-2 text-sm text-blue-600 hover:text-blue-800 hover:underline transition">
                    + Ajouter une autre question
                </button>
            </div>

            <!-- Bouton -->
            <div class="text-center">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md shadow transition">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>

    <!-- Script -->
    <script>
        document.getElementById('add-new-question').addEventListener('click', function () {
            const container = document.getElementById('new-questions-container');
            const textarea = document.createElement('textarea');
            textarea.name = 'new_questions[]';
            textarea.placeholder = 'Ajouter une nouvelle question...';
            textarea.className = 'w-full border border-gray-300 rounded-md shadow-sm p-2 mt-2';
            container.appendChild(textarea);
        });
    </script>

</body>
</html>
