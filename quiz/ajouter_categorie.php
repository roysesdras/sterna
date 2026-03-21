<?php
require_once '../config/db.php';
session_start();
if (!isset($_SESSION['admin_quiz_id'])) {
    header("Location: login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = sanitize_input($_POST['nom'], $conn);
    $description = sanitize_input($_POST['description'], $conn);

    if (!empty($nom)) {
        $stmt = $conn->prepare("INSERT INTO categorie_quiz (nom, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $nom, $description);
        if ($stmt->execute()) {
            $success = "Catégorie ajoutée avec succès ✅";
        } else {
            $error = "Erreur lors de l'ajout.";
        }
    } else {
        $error = "Le nom de la catégorie est requis.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une catégorie</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Favicons -->
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="icon">
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="apple-touch-icon">
</head>

<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">
    <div class="bg-gray-800 p-2 rounded-2xl shadow-xl w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Ajouter une Catégorie</h2>

        <?php if (!empty($success)): ?>
            <div class="bg-green-600 text-white p-3 rounded mb-4 text-center"><?= $success ?></div>
        <?php elseif (!empty($error)): ?>
            <div class="bg-red-600 text-white p-3 rounded mb-4 text-center"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Nom de la catégorie</label>
                <input type="text" name="nom" required class="w-full bg-gray-700 border border-gray-600 rounded-xl py-3 px-4 text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <textarea name="description" rows="5" class="w-full bg-gray-700 border border-gray-600 rounded-xl py-3 px-4 text-white"></textarea>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white py-3 rounded-xl transition-all duration-300">
                Ajouter
            </button>
            <div class="text-center mt-4">
                <a href="dashboard#categorie" class="text-purple-400 hover:text-purple-300">← Retour au tableau de bord</a>
            </div>
        </form>
    </div>
</body>

</html>