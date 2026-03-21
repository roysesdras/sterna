<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once '../includes/db.php';
require_once '../includes/auth.php';
require_once '../includes/antenne_db.php'; // Connexion à la base de données des pays

//require_login();

if ($_SESSION['role'] !== 'admin') {
    // Redirige si l'utilisateur n'est pas admin
    header('Location: login.php');
    exit();
}

// Création d'un chantier si formulaire soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $country = trim($_POST['country']);
    $year = trim($_POST['year']);

    if ($title && $country && $year) {
        $stmt = $pdo->prepare("INSERT INTO projects (title, country, year, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$title, $country, $year]);
        $success = "Nouveau chantier créé avec succès !";
    } else {
        $error = "Tous les champs sont obligatoires.";
    }
}

// Récupère la liste des projets
$projects = $pdo->query("SELECT * FROM projects ORDER BY year DESC, country")->fetchAll();
// Récupération des antennes pour le champ "Pays"
$antennes = $antennesPdo->query("SELECT id, nom FROM antennes ORDER BY nom ASC")->fetchAll();
$pays_disponibles = $antennes;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Cahier d’Or</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Favicons -->
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="icon">
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="apple-touch-icon">
</head>

<body class="bg-gray-900 text-white font-sans min-h-screen py-10 px-4 flex flex-col">

    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-yellow-400 mb-8 text-center">🎛️ Tableau de bord Admin</h1>

        <?php if (!empty($success)): ?>
            <div class="bg-green-700/20 text-green-400 p-4 mb-4 rounded border border-green-600">
                <?= $success ?>
            </div>
        <?php elseif (!empty($error)): ?>
            <div class="bg-red-700/20 text-red-400 p-4 mb-4 rounded border border-red-600">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <div class="bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-700 mb-10">
            <h2 class="text-xl font-semibold text-yellow-300 mb-4">✨ Créer un nouveau chantier</h2>
            <form method="post" class="space-y-4">
                <input type="text" name="title" placeholder="Titre du projet (ex: CSI Côte d'Ivoire 2025)"
                    class="w-full bg-gray-700 border border-gray-600 p-3 rounded text-white placeholder-gray-400">

                <div>
                    <label class="block text-sm mb-1 text-gray-300">Pays</label>
                    <select name="country" required
                        class="w-full bg-gray-700 border border-gray-600 p-3 rounded text-white">
                        <option value="">-- Sélectionner un pays --</option>
                        <?php foreach ($pays_disponibles as $pays): ?>
                            <option value="<?= htmlspecialchars($pays['nom']) ?>"><?= htmlspecialchars($pays['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <input type="number" name="year" placeholder="Année"
                    class="w-full bg-gray-700 border border-gray-600 p-3 rounded text-white placeholder-gray-400">

                <button type="submit"
                    class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold py-2 px-6 rounded-lg transition duration-200">
                    ➕ Créer
                </button>
            </form>
        </div>

        <div class="bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-700">
            <h2 class="text-xl font-semibold text-yellow-300 mb-4">🏗️ Chantiers existants</h2>
            <ul class="divide-y divide-gray-700">
                <?php foreach ($projects as $p): ?>
                    <li class="py-3">
                        <strong class="text-white"><?= htmlspecialchars($p['title']) ?></strong>
                        <span class="text-gray-400"> (<?= $p['country'] ?>, <?= $p['year'] ?>)</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="flex justify-start mb-6 mt-4">
            <a href="logout.php"
                class="text-sm text-red-400 hover:text-red-300 px-4 py-2 rounded bg-gray-800 hover:bg-gray-700 border border-red-500 transition">
                Se déconnecter
            </a>
        </div>

    </div>

    <?php include_once '../includes/footer.php'; ?>
</body>

</html>