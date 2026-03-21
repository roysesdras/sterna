<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['admin_quiz_id'])) {
    header("Location: login");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard#categorie");
    exit;
}

$id = (int) $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM categorie_quiz WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$categorie = $result->fetch_assoc();

if (!$categorie) {
    die("Catégorie introuvable.");
}

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = sanitize_input($_POST['nom'], $conn);
    $description = sanitize_input($_POST['description'], $conn);

    if (!empty($nom)) {
        $update = $conn->prepare("UPDATE categorie_quiz SET nom = ?, description = ? WHERE id = ?");
        $update->bind_param("ssi", $nom, $description, $id);
        if ($update->execute()) {
            $success = "Catégorie mise à jour avec succès ✅";
            // Recharger les données mises à jour
            $categorie['nom'] = $nom;
            $categorie['description'] = $description;
        } else {
            $error = "Erreur lors de la mise à jour.";
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
    <title>Modifier une catégorie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Favicons -->
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="icon">
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="apple-touch-icon">
</head>

<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">
    <div class="bg-gray-800 p-8 rounded-2xl shadow-xl w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Modifier la Catégorie</h2>

        <?php if (!empty($success)): ?>
            <div class="bg-green-600 text-white p-3 rounded mb-4 text-center"><?= $success ?></div>
        <?php elseif (!empty($error)): ?>
            <div class="bg-red-600 text-white p-3 rounded mb-4 text-center"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Nom de la catégorie</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($categorie['nom']) ?>" required class="w-full bg-gray-700 border border-gray-600 rounded-xl py-3 px-4 text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full bg-gray-700 border border-gray-600 rounded-xl py-3 px-4 text-white"><?= htmlspecialchars($categorie['description']) ?></textarea>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-3 rounded-xl transition-all duration-300">
                Enregistrer les modifications
            </button>

            <div class="text-center mt-4">
                <a href="dashboard#categorie" class="text-purple-400 hover:text-purple-300">← Retour au tableau de bord</a>
            </div>
        </form>
    </div>
</body>

</html>