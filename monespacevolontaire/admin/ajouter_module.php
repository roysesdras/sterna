<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once '../inclusion/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'] ?? '';
    $description = $_POST['description'] ?? '';
    $ordre = (int)($_POST['ordre'] ?? 0);
    $date_disponibilite = $_POST['date_disponibilite'] ?? '';
    $video_url = $_POST['video_url'] ?? '';
    $exercice_url = $_POST['exercice_url'] ?? '';
    $exercice_facultatif = isset($_POST['exercice_facultatif']) ? 1 : 0;
    $visible = isset($_POST['visible']) ? 1 : 0;

    $stmt = $pdo->prepare("INSERT INTO modules 
        (titre, description, ordre, date_disponibilite, video_url, exercice_url, exercice_facultatif, visible, date_creation) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$titre, $description, $ordre, $date_disponibilite, $video_url, $exercice_url, $exercice_facultatif, $visible]);

    $module_id = $pdo->lastInsertId();

    if (!empty($_POST['questions']) && is_array($_POST['questions'])) {
        $stmt = $pdo->prepare("INSERT INTO questions (module_id, question_text, date_creation) VALUES (?, ?, NOW())");
        foreach ($_POST['questions'] as $question_text) {
            $question_text = trim($question_text);
            if (!empty($question_text)) {
                $stmt->execute([$module_id, $question_text]);
            }
        }
    }

    header('Location: https://monespacevolontaire.sternaafrica.org/admin?section=orders');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un module</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://sternaafrica.org/assets/img/favicon.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/apple-touch-icon.png" rel="apple-touch-icon">
</head>
<body class="bg-gray-200 text-gray-800">

    <div class="max-w-2xl mx-auto p-6 bg-white shadow-lg rounded-xl mt-10">
        <h1 class="text-3xl font-bold mb-2 text-center text-blue-800">Créer le module du jour</h1>
        <p class="mb-8 text-center text-gray-600 max-w-2xl mx-auto leading-relaxed">
            Veuillez créer le module de formation quotidien en complétant les champs et objectifs pédagogiques. 
        </p>

        <form method="POST" class="space-y-6" id="moduleForm">
            <div>
                <label class="block text-sm font-medium mb-1">Titre</label>
                <input type="text" name="titre" required class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <p class="text-sm text-gray-600">
                    Définissez un titre pour ce module.
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Objectifs</label>
                <textarea name="description" required class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                <p class="text-sm text-gray-600">
                    Définissez l'objectif pédagogique de ce module quotidien.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Ordre</label>
                    <input type="number" name="ordre" required class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <p class="text-sm text-gray-600">
                        Définissez l'ordre du module. Ex: 1, 2, 3...
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Date de disponibilité</label>
                    <input type="date" name="date_disponibilite" required class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">URL de la vidéo</label>
                <input type="url" name="video_url" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <p class="text-sm text-gray-600">
                    <span class="font-medium">Lien vidéo :</span> Ajoutez l'URL de la ressource vidéo associée à ce module
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">URL de l'exercice</label>
                <input type="url" name="exercice_url" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <p class="text-sm text-gray-600">
                    <span class="font-medium">Support complémentaire :</span> Joignez si nécessaire le fichier d'exercices ou le document pédagogique
                </p>
            </div>

            <div class="flex items-center gap-6">
                <label class="inline-flex items-center gap-2 text-sm">
                <input type="checkbox(cocher si vous souhaieter rendre le module visible pour les volontaires)" name="exercice_facultatif" class="accent-blue-600">
                    Exercice facultatif
                </label>
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="visible" class="accent-blue-600">
                    Rendre visible aux volontaires (Cochez pour publier le module)
                </label>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Questions</label>
                <div id="questions-container" class="space-y-2">
                    <textarea name="questions[]" class="w-full border border-gray-300 rounded-lg p-2" placeholder="Saisir une question..."></textarea>
                </div>
                <button type="button" id="add-question" class="mt-2 text-sm text-blue-600 hover:text-blue-800 hover:underline">
                    + Ajouter une autre question
                </button>
            </div>

            <div class="text-center pt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 transition text-white font-semibold px-6 py-2 rounded-md shadow">
                    Enregistrer le module
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('add-question').addEventListener('click', function () {
            const container = document.getElementById('questions-container');
            const textarea = document.createElement('textarea');
            textarea.name = 'questions[]';
            textarea.placeholder = 'Saisir une question...';
            textarea.className = 'w-full border border-gray-300 rounded-lg p-2';
            container.appendChild(textarea);
        });
    </script>

</body>
</html>
