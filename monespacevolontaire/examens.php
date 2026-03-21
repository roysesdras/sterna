<?php
session_start();
require 'inclusion/db.php';

if (!isset($_SESSION['user_id'])) {
    die("Accès refusé.");
}

$volontaire_id = $_SESSION['user_id'];
$annee_actuelle = date('Y');

// Récupérer les examens de l'année en cours
$stmt = $pdo->prepare("SELECT * FROM examens WHERE YEAR(date_creation) = ? ORDER BY date_creation ASC");
$stmt->execute([$annee_actuelle]);
$examens = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si le volontaire a déjà répondu
$stmt = $pdo->prepare("SELECT examen_id, reponse FROM reponses_examens WHERE volontaire_id = ?");
$stmt->execute([$volontaire_id]);
$reponses_existantes = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
$deja_repondu = count($reponses_existantes) > 0;

// Récupérer les anciens examens (archivés)
$stmt = $pdo->prepare("SELECT * FROM examens WHERE YEAR(date_creation) < ? ORDER BY date_creation DESC");
$stmt->execute([$annee_actuelle]);
$archives = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Examen - Sterna</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://sternaafrica.org/assets/img/favicon.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/apple-touch-icon.png" rel="apple-touch-icon">
</head>
<body class="bg-gray-100 font-sans min-h-screen p-6">

<div class="max-w-2xl mx-auto bg-white shadow-2xl rounded-2xl p-6 space-y-8">
    <h1 class="text-3xl font-bold text-center text-blue-800">Examen final - <?= $annee_actuelle ?></h1>

    <?php if (count($examens) > 0): ?>
        <?php if ($deja_repondu): ?>
            <div class="text-center text-green-600 font-medium bg-green-100 rounded-lg p-4">
                <span class="font-bold">Vous avez déjà soumis cet examen.</span><br>
                Vos réponses sont affichées ci-dessous.
            </div>
        <?php endif; ?>

        <form action="submit_exam.php" method="POST" class="space-y-6">
            <?php foreach ($examens as $index => $question): ?>
                <div class="bg-gray-50 p-6 rounded-2xl border shadow-md">
                    <h2 class="font-semibold text-lg mb-3">Question <?= ($index + 1) ?> : <?= htmlspecialchars($question['question_text']) ?></h2>

                    <?php if (!empty($question['image'])): ?>
                        <img src="/admin/uploads/<?= htmlspecialchars($question['image']) ?>" alt="image question" class="rounded-xl mb-4 w-full max-h-64 object-contain">
                    <?php endif; ?>

                    <?php
                    $examen_id = $question['id'];
                    $reponse_existante = $reponses_existantes[$examen_id] ?? '';
                    ?>

                    <?php if ($question['type_question'] === 'qcm'): ?>
                        <div class="space-y-2">
                            <?php foreach (explode(';', $question['options']) as $opt): ?>
                                <label class="flex items-center space-x-3">
                                    <input type="radio"
                                           name="reponses[<?= $examen_id ?>]"
                                           value="<?= trim($opt) ?>"
                                           <?= ($reponse_existante === trim($opt)) ? 'checked' : '' ?>
                                           <?= $deja_repondu ? 'disabled' : '' ?>
                                           class="accent-blue-600">
                                    <span><?= htmlspecialchars($opt) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <textarea name="reponses[<?= $examen_id ?>]" rows="4"
                                  class="w-full border rounded-xl p-3 <?= $deja_repondu ? 'bg-gray-100 cursor-not-allowed text-gray-600' : 'focus:ring focus:ring-blue-200' ?>"
                                  placeholder="Votre réponse..."
                                  <?= $deja_repondu ? 'disabled' : '' ?>><?= htmlspecialchars($reponse_existante) ?></textarea>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <?php if (!$deja_repondu): ?>
                <div class="text-center">
                    <button type="submit" onclick="return confirm('Soumettre définitivement vos réponses ?')"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-full shadow-lg">
                        Soumettre mes réponses
                    </button>
                </div>
            <?php endif; ?>
        </form>
    <?php else: ?>
        <div class="text-center text-gray-600">Aucun examen disponible actuellement pour <?= $annee_actuelle ?>.</div>
    <?php endif; ?>
</div>

<!-- Archives -->
<?php if (count($archives) > 0): ?>
    <div class="max-w-3xl mx-auto mt-10">
        <h2 class="text-2xl font-bold text-blue-800 mb-4">Archives des anciens examens</h2>
        <ul class="space-y-3">
            <?php foreach ($archives as $arch): ?>
                <li class="p-4 bg-white shadow-md rounded-xl border">
                    <strong><?= date('Y', strtotime($arch['date_creation'])) ?> :</strong>
                    <?= htmlspecialchars($arch['question_text']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

</body>
</html>
