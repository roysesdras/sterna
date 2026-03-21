<?php
// Connexion à la base de données (à adapter à ton système)
require_once './inclusion/db.php';

// ID du volontaire (à récupérer selon ta session ou système de connexion)
session_start();
$volontaire_id = $_SESSION['user_id'] ?? null;

if (!$volontaire_id) {
    die("Utilisateur non connecté");
}

// Message de confirmation si une réponse a été envoyée
$success = false;

// Traitement du formulaire de réponses
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['reponses'] as $question_id => $reponse) {
        // Vérifie si une réponse existe déjà pour cette question et ce volontaire
        $stmt = $pdo->prepare("SELECT id FROM reponses WHERE volontaire_id = ? AND question_id = ?");
        $stmt->execute([$volontaire_id, $question_id]);
        $existe = $stmt->fetch();

        if ($existe) {
            // Mettre à jour la réponse existante
            $stmt = $pdo->prepare("UPDATE reponses SET reponse = ?, date_reponse = NOW() WHERE id = ?");
            $stmt->execute([$reponse, $existe['id']]);
        } else {
            // Insérer une nouvelle réponse
            $stmt = $pdo->prepare("INSERT INTO reponses (volontaire_id, module_id, question_id, reponse, date_reponse) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$volontaire_id, $_POST['module_id'], $question_id, $reponse]);
        }
    }

    $success = true;
}

// Récupération des modules visibles **et disponibles aujourd'hui strictement**
$today = date('Y-m-d');
$modules = $pdo->prepare("SELECT * FROM modules WHERE visible = 1 AND date_disponibilite = ? ORDER BY ordre ASC");
$modules->execute([$today]);
$modules = $modules->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formations disponibles</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://sternaafrica.org/assets/img/favicon.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/apple-touch-icon.png" rel="apple-touch-icon">
</head>
<body class="bg-gray-200 text-gray-800">

<div class="max-w-2xl mx-auto py-10 px-4">

    <h1 class="text-3xl font-bold mb-6 text-center">📚 Modules du jour</h1>

    <?php if ($success): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">✅ Réponses enregistrées !</strong>
        <span class="block sm:inline">Vos réponses ont bien été soumises. Ce module est maintenant verrouillé.</span>
        </div>
    <?php endif; ?>

    <div class="space-y-4">
        <?php if (empty($modules)): ?>
            <p class="text-center text-gray-500">Aucun module disponible pour aujourd'hui.</p>
        <?php else: ?>
            <?php foreach ($modules as $module): ?>
                <?php
                    // Récupération des questions du module
                    $stmt = $pdo->prepare("SELECT * FROM questions WHERE module_id = ?");
                    $stmt->execute([$module['id']]);
                    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Vérifie si le volontaire a déjà répondu à toutes les questions de ce module
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM questions WHERE module_id = ?");
                    $stmt->execute([$module['id']]);
                    $total_questions = $stmt->fetchColumn();

                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM reponses WHERE module_id = ? AND volontaire_id = ?");
                    $stmt->execute([$module['id'], $volontaire_id]);
                    $total_reponses = $stmt->fetchColumn();

                    $deja_soumis = ($total_questions > 0 && $total_reponses >= $total_questions);

                ?>
                <details class="bg-white rounded shadow p-4 <?= $deja_soumis ? 'bg-gray-100 opacity-70 pointer-events-none' : '' ?>">
                    <summary class="cursor-pointer font-semibold text-lg flex justify-between items-center"> ♝
                        <?= htmlspecialchars($module['titre']) ?>
                        <?php if ($deja_soumis): ?>
                            <span class="text-gray-500 text-sm flex items-center ml-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3 1.343 3 3v2H9v-2c0-1.657 1.343-3 3-3zm0 0V7a4 4 0 00-8 0v4m0 0h8" />
                                </svg>
                                Module verrouillé
                            </span>
                        <?php endif; ?>
                    </summary>

                    <div class="mt-4 space-y-3">
                        <p class="text-sm text-gray-600"><?= nl2br(htmlspecialchars($module['description'])) ?></p>

                        <?php if (!empty($module['video_url'])): ?>
                            <div class="mt-2">
                                <a href="<?= htmlspecialchars($module['video_url']) ?>" target="_blank" class="text-blue-600 underline text-sm">
                                    🎥 Voir la vidéo
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ($module['exercice_facultatif'] && !empty($module['exercice_url'])): ?>
                            <div class="mt-2">
                                <a href="<?= htmlspecialchars($module['exercice_url']) ?>" target="_blank" class="text-indigo-600 underline text-sm">
                                    📄 Télécharger l'exercice facultatif
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($questions)): ?>
                            <?php if ($deja_soumis): ?>
                                <p class="text-green-600 font-semibold mt-4">✅ Vous avez déjà soumis vos réponses pour ce module.</p>
                            <?php else: ?>
                                <form method="POST" class="mt-4 space-y-4">
                                    <input type="hidden" name="module_id" value="<?= $module['id'] ?>">

                                    <?php foreach ($questions as $q): ?>
                                        <div>
                                            <label class="block font-medium mb-1"><?= htmlspecialchars($q['question_text']) ?></label>
                                            <textarea name="reponses[<?= $q['id'] ?>]" rows="2" class="w-full border rounded p-2" placeholder="Votre réponse..." required></textarea>
                                        </div>
                                    <?php endforeach; ?>

                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                        Soumettre mes réponses
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="text-sm text-gray-400 italic">Aucune question pour ce module.</p>
                        <?php endif; ?>
                    </div>
                </details>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
