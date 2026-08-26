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

// Création ou modification d'un chantier si formulaire soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'edit') {
        // Modification
        $project_id = (int)($_POST['project_id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        
        if ($project_id && $title) {
            $stmt = $pdo->prepare("UPDATE projects SET title = ? WHERE id = ?");
            $stmt->execute([$title, $project_id]);
            $success = "Le nom du chantier a été mis à jour avec succès !";
        } else {
            $error = "Le titre ne peut pas être vide.";
        }
    } else {
        // Création
        $title = trim($_POST['title'] ?? '');
        $country = trim($_POST['country'] ?? '');
        $year = trim($_POST['year'] ?? '');

        if ($title && $country && $year) {
            $stmt = $pdo->prepare("INSERT INTO projects (title, country, year, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$title, $country, $year]);
            $success = "Nouveau chantier créé avec succès !";
        } else {
            $error = "Tous les champs sont obligatoires pour la création.";
        }
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
    <link href="/assets/img/external/84e554fe99_sternaofficiel-2.png" rel="icon">
    <link href="/assets/img/external/84e554fe99_sternaofficiel-2.png" rel="apple-touch-icon">
</head>

<body class="bg-gray-900 text-white font-sans min-h-screen py-10 px-4 flex flex-col">

    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-yellow-400 mb-4 md:mb-0 text-center">Tableau de bord Admin</h1>
            <a href="subscribers.php" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg font-semibold shadow transition flex items-center gap-2">
                ✉️ Voir les abonnés newsletter
            </a>
        </div>

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
            <h2 class="text-xl font-semibold text-yellow-300 mb-4">Créer un nouveau chantier</h2>
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
                    Créer
                </button>
            </form>
        </div>

        <div class="bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-700">
            <h2 class="text-xl font-semibold text-yellow-300 mb-4">Chantiers existants</h2>
            <ul class="divide-y divide-gray-700">
                <?php foreach ($projects as $p): ?>
                    <li class="py-4 flex flex-col gap-3">
                        <div class="flex justify-between items-center w-full">
                            <div>
                                <strong class="text-white text-lg"><?= htmlspecialchars($p['title']) ?></strong>
                                <span class="text-gray-400 block text-sm sm:inline"> (<?= htmlspecialchars($p['country']) ?>, <?= htmlspecialchars($p['year']) ?>)</span>
                            </div>
                            <button type="button" onclick="document.getElementById('edit-form-<?= $p['id'] ?>').classList.toggle('hidden')" class="text-sm bg-gray-700 hover:bg-gray-600 text-yellow-400 border border-gray-600 px-3 py-1 rounded transition">
                                Modifier
                            </button>
                        </div>
                        <form id="edit-form-<?= $p['id'] ?>" class="hidden bg-gray-900/50 p-4 rounded-lg border border-gray-700 flex flex-col md:flex-row gap-3 mt-1" method="post">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="project_id" value="<?= $p['id'] ?>">
                            <input type="text" name="title" value="<?= htmlspecialchars($p['title']) ?>" class="bg-gray-700 border border-gray-600 p-2 rounded text-white flex-1 focus:ring-2 focus:ring-yellow-400 focus:outline-none" required>
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 px-5 py-2 rounded-lg font-semibold transition">Enregistrer</button>
                        </form>
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