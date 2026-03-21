<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// On crée une connexion PDO spécifique pour ce fichier 
// en utilisant les variables déjà présentes dans db.php
try {
    // On réutilise $host, $dbname, etc. définis dans db.php
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion PDO : " . $e->getMessage());
}

$mission_id = isset($_GET['mission_id']) ? (int) $_GET['mission_id'] : 0;
$annee = isset($_GET['annee']) ? (int) $_GET['annee'] : 0;

// Modifier une réponse
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reponse_id'], $_POST['nouvelle_reponse'])) {
    $stmt = $pdo->prepare("UPDATE reponses SET reponse = :reponse WHERE id = :id");
    $stmt->execute([
        'reponse' => trim($_POST['nouvelle_reponse']),
        'id'      => (int) $_POST['reponse_id']
    ]);
    $success_message = "Réponse mise à jour avec succès.";
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des réponses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="max-w-5xl mx-auto py-8 px-4">

        <?php if ($mission_id === 0 && $annee === 0): ?>
            <h2 class="text-2xl font-bold mb-6 text-gray-800">📅 Choisissez une année</h2>

            <?php
            $annees = $pdo->query("SELECT DISTINCT YEAR(start_date) as annee FROM missions ORDER BY annee DESC")->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <div class="flex flex-wrap gap-3">
                <?php foreach ($annees as $a): ?>
                    <a href="?annee=<?= $a['annee'] ?>" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        <?= $a['annee'] ?>
                    </a>
                <?php endforeach; ?>
            </div>

        <?php elseif ($mission_id === 0 && $annee > 0): ?>

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">🗂️ Activités de l'année <?= $annee ?></h2>
                <a href="?" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">⬅️ Retour aux années</a>
            </div>

            <?php
            $stmt = $pdo->prepare("SELECT id, title FROM missions WHERE YEAR(start_date) = :annee ORDER BY start_date DESC");
            $stmt->execute(['annee' => $annee]);
            $missions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <?php if (empty($missions)): ?>
                <div class="bg-yellow-100 text-yellow-800 p-4 rounded">Aucune activité trouvée.</div>
            <?php endif; ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <?php foreach ($missions as $mission): ?>
                    <div class="bg-white p-4 rounded shadow">
                        <h3 class="font-semibold text-lg"><?= htmlspecialchars($mission['title']) ?></h3>
                        <a href="?annee=<?= $annee ?>&mission_id=<?= $mission['id'] ?>" class="inline-block mt-3 px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Voir les réponses</a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="flex">
                <a href="?" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 ml-auto">⬅️ Retour aux années</a>
            </div>


        <?php else: ?>

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">📝 Réponses pour l'activité #<?= $mission_id ?></h2>
                <a href="?annee=<?= $annee ?>" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">⬅️ Retour aux activités</a>
            </div>

            <?php
            $stmt = $pdo->prepare("SELECT r.id AS reponse_id, r.reponse, r.temoignage_id, q.question_text, t.nom, t.photo
                               FROM reponses r
                               JOIN questions q ON r.question_id = q.id
                               JOIN temoignages t ON r.temoignage_id = t.id
                               WHERE q.mission_id = :mission_id
                               ORDER BY t.nom ASC, q.id ASC");
            $stmt->execute(['mission_id' => $mission_id]);
            $reponses = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $groupes = [];
            foreach ($reponses as $rep) {
                $groupes[$rep['temoignage_id']]['nom'] = $rep['nom'];
                $groupes[$rep['temoignage_id']]['photo'] = $rep['photo'];
                $groupes[$rep['temoignage_id']]['reponses'][] = $rep;
            }
            ?>

            <?php if (!empty($success_message)): ?>
                <div class="bg-green-100 text-green-800 p-4 mb-4 rounded"><?= $success_message ?></div>
            <?php endif; ?>

            <?php foreach ($groupes as $data): ?>
                <div class="bg-white mb-6 rounded shadow overflow-hidden">
                    <div class="bg-blue-500 text-white p-2 flex justify-between items-center">
                        <span class="font-semibold" style="font-size: 18px;"><?= htmlspecialchars($data['nom']) ?></span>
                        <!-- <?php if (!empty($data['photo'])): ?>
                            <img src="<?= htmlspecialchars($data['photo']) ?>" alt="Photo" class="w-10 h-10 rounded-full object-cover">
                        <?php endif; ?> -->
                    </div>
                    <div class="p-4 space-y-4">
                        <?php foreach ($data['reponses'] as $rep): ?>
                            <form method="post" class="space-y-2">
                                <label class="block font-medium text-gray-700" style="font-size: 20px;"><?= htmlspecialchars($rep['question_text']) ?></label>
                                <textarea name="nouvelle_reponse" rows="5" class="w-full border rounded px-3 py-2"><?= htmlspecialchars($rep['reponse']) ?></textarea>
                                <input type="hidden" name="reponse_id" value="<?= $rep['reponse_id'] ?>">
                                <button type="submit" class="px-3 py-2 bg-green-500 text-black rounded hover:bg-green-600">💾 Enregistrer</button>
                            </form>
                            <hr>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="flex">
                <a href="?annee=<?= $annee ?>" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 ml-auto">⬅️ Retour aux activités</a>
            </div>
        <?php endif; ?>

    </div>

</body>

</html>