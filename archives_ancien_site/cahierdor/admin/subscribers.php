<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Redirige si l'utilisateur n'est pas admin
    header('Location: login.php');
    exit();
}

// Récupération des abonnés
try {
    $stmt = $pdo->query("SELECT * FROM newsletter_subscribers ORDER BY created_at DESC");
    $subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // La table n'existe peut-être pas encore si personne ne s'est inscrit
    $subscribers = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Abonnés Newsletter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen p-4 md:p-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-yellow-400">📋 Liste des abonnés</h1>
            <a href="create_project.php" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition">
                Retour aux chantiers
            </a>
        </div>

        <div class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-700">
            <div class="p-6 border-b border-gray-700 bg-gray-800/50">
                <h2 class="text-lg font-semibold text-white">
                    Total : <?= count($subscribers) ?> abonné(s)
                </h2>
                <p class="text-sm text-gray-400 mt-1">Ces adresses e-mail reçoivent une notification à chaque publication d'un nouveau récit.</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-900/50 text-gray-400 text-sm">
                            <th class="p-4 font-medium border-b border-gray-700">Adresse e-mail</th>
                            <th class="p-4 font-medium border-b border-gray-700">Date d'inscription</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        <?php if (empty($subscribers)): ?>
                            <tr>
                                <td colspan="2" class="p-8 text-center text-gray-500">
                                    Aucun abonné pour le moment.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($subscribers as $sub): ?>
                                <tr class="hover:bg-gray-700/30 transition">
                                    <td class="p-4 font-medium text-yellow-100">
                                        <a href="mailto:<?= htmlspecialchars($sub['email']) ?>" class="hover:text-yellow-400 transition">
                                            <?= htmlspecialchars($sub['email']) ?>
                                        </a>
                                    </td>
                                    <td class="p-4 text-sm text-gray-400">
                                        <?= date('d/m/Y à H:i', strtotime($sub['created_at'])) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <?php if (!empty($subscribers)): ?>
        <div class="mt-8 bg-gray-800 p-6 rounded-2xl border border-gray-700 shadow-xl">
            <h3 class="text-yellow-400 font-bold mb-4">Export rapide (pour copier-coller) :</h3>
            <textarea readonly class="w-full h-32 bg-gray-900 text-gray-300 p-3 rounded-lg border border-gray-600 focus:outline-none text-sm font-mono"><?= implode(', ', array_column($subscribers, 'email')) ?></textarea>
            <p class="text-xs text-gray-500 mt-2">Vous pouvez copier cette liste pour envoyer un e-mail groupé depuis votre boîte mail (n'oubliez pas de les mettre en copie cachée - Cci).</p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
