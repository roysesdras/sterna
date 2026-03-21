<?php
require_once '../config/db.php';
session_start();

// 1. Vérification de session
if (!isset($_SESSION['admin_quiz_id'])) {
    header("Location: login");
    exit;
}

$id = intval($_GET['id'] ?? 0);
$success = "";
$error = "";
$redirect = false; // Flag pour déclencher la redirection JS ou Meta

// 2. Charger la question
$stmt = $conn->prepare("SELECT * FROM question_quiz WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$question = $result->fetch_assoc();
$stmt->close();

if (!$question) {
    die("❌ Question introuvable !");
}

// 3. Traitement du formulaire au POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nouvelle_question = trim($_POST['question'] ?? '');
    $categorie_id = intval($_POST['categorie_id'] ?? 0);

    if (!empty($nouvelle_question) && $categorie_id > 0) {

        // --- A. Supprimer les réponses cochées pour suppression ---
        if (!empty($_POST['reponses_delete']) && is_array($_POST['reponses_delete'])) {
            $del_stmt = $conn->prepare("DELETE FROM reponse_quiz WHERE id = ?");
            foreach ($_POST['reponses_delete'] as $del_id) {
                $did = intval($del_id);
                if ($did > 0) {
                    $del_stmt->bind_param("i", $did);
                    $del_stmt->execute();
                }
            }
            $del_stmt->close();
        }

        // --- B. Mettre à jour la question principale ---
        $stmt = $conn->prepare("UPDATE question_quiz SET question = ?, categorie_id = ? WHERE id = ?");
        $stmt->bind_param("sii", $nouvelle_question, $categorie_id, $id);
        $stmt->execute();
        $stmt->close();

        // --- C. Mettre à jour les réponses existantes ---
        if (!empty($_POST['reponses_exist']) && is_array($_POST['reponses_exist'])) {
            $upd = $conn->prepare("UPDATE reponse_quiz SET reponse = ?, correcte = ? WHERE id = ?");
            foreach ($_POST['reponses_exist'] as $rep_id => $texte) {
                $rid = intval($rep_id);
                $texte = trim($texte);
                $correcte = (isset($_POST['correcte_exist'][$rep_id]) ? 1 : 0);

                if ($texte === '') {
                    $del2 = $conn->prepare("DELETE FROM reponse_quiz WHERE id = ?");
                    $del2->bind_param("i", $rid);
                    $del2->execute();
                    $del2->close();
                } else {
                    $upd->bind_param("sii", $texte, $correcte, $rid);
                    $upd->execute();
                }
            }
            $upd->close();
        }

        // --- D. Ajouter les nouvelles réponses ---
        if (!empty($_POST['reponses_nouvelles']) && is_array($_POST['reponses_nouvelles'])) {
            $add = $conn->prepare("INSERT INTO reponse_quiz (question_id, reponse, correcte) VALUES (?, ?, ?)");
            foreach ($_POST['reponses_nouvelles'] as $index => $texte) {
                $texte = trim($texte);
                if ($texte !== '') {
                    $correcte = isset($_POST['correcte_nouvelles'][$index]) ? 1 : 0;
                    $add->bind_param("isi", $id, $texte, $correcte);
                    $add->execute();
                }
            }
            $add->close();
        }

        $success = "✅ Modifications enregistrées. Retour au dashboard...";
        $redirect = true; // On active la redirection

    } else {
        $error = "❌ Tous les champs sont requis.";
    }
}

// 4. Charger (ou recharger) les données pour l'affichage
$categories = $conn->query("SELECT id, nom FROM categorie_quiz ORDER BY nom ASC");

$reponses = [];
$res = $conn->prepare("SELECT * FROM reponse_quiz WHERE question_id = ?");
$res->bind_param("i", $id);
$res->execute();
$reponses_result = $res->get_result();
while ($r = $reponses_result->fetch_assoc()) {
    $reponses[] = $r;
}
$res->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Édition rapide | Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <?php if (isset($redirect) && $redirect): ?>
        <meta http-equiv="refresh" content="1.5;url=dashboard#question">
    <?php endif; ?>

    <style>
        .glass-card {
            background: rgba(31, 41, 55, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .custom-checkbox {
            width: 20px;
            height: 20px;
            accent-color: #10b981;
        }
    </style>
</head>

<body class="bg-stone-950 text-white min-h-screen">

    <nav class="bg-gray-800/50 border-b border-white/5 p-4 sticky top-0 z-50 backdrop-blur-md">
        <div class="max-w-3xl mx-auto flex justify-between items-center">
            <a href="dashboard#question" class="text-gray-400 hover:text-white transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-sm font-bold uppercase tracking-widest text-purple-400">Édition Question</h1>
            <button onclick="window.location.href='dashboard'" class="text-gray-400"><i class="fas fa-home"></i></button>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto p-4 pb-24">

        <?php if (!empty($success)): ?>
            <div class="fixed top-20 left-4 right-4 z-[60] bg-green-600 text-white p-4 rounded-xl shadow-2xl text-center animate-bounce">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div class="glass-card p-5 rounded-2xl">
                <label class="block text-xs font-bold text-gray-400 uppercase mb-3">Contenu de la question</label>
                <textarea name="question" rows="3" required
                    class="w-full bg-gray-800 border-none ring-1 ring-white/10 rounded-xl py-3 px-4 text-white focus:ring-2 focus:ring-purple-500 transition-all"><?= stripslashes(htmlspecialchars_decode($question['question'])) ?></textarea>

                <div class="mt-4">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Catégorie</label>
                    <select name="categorie_id" required class="w-full bg-gray-800 border-none ring-1 ring-white/10 rounded-xl py-3 px-4 text-white">
                        <?php
                        $categories = $conn->query("SELECT id, nom FROM categorie_quiz ORDER BY nom ASC");
                        while ($cat = $categories->fetch_assoc()): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $question['categorie_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nom']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="glass-card p-5 rounded-2xl">
                <div class="flex justify-between items-center mb-4">
                    <label class="block text-xs font-bold text-gray-400 uppercase">Réponses</label>
                    <span class="text-[10px] bg-green-500/20 text-green-400 px-2 py-1 rounded">Cochez la bonne</span>
                </div>

                <div id="reponses-container" class="space-y-3">
                    <?php foreach ($reponses as $r): ?>
                        <div class="flex items-center gap-3 p-2 bg-white/5 rounded-xl border border-white/5 reponse-item">
                            <input type="text" name="reponses_exist[<?= $r['id'] ?>]"
                                value="<?= stripslashes(htmlspecialchars_decode($r['reponse'])) ?>"
                                class="flex-1 bg-transparent border-none text-white focus:ring-0">

                            <input type="checkbox" name="correcte_exist[<?= $r['id'] ?>]"
                                class="custom-checkbox" <?= $r['correcte'] ? 'checked' : '' ?>>

                            <button type="button" class="text-red-400 p-2" onclick="supprimerReponseExist(<?= $r['id'] ?>, this)">
                                <i class="fas fa-trash-can"></i>
                            </button>
                        </div>
                    <?php endforeach; ?>
                    <div id="nouvelles-reponses"></div>
                </div>

                <button type="button" onclick="ajouterReponse()"
                    class="w-full mt-4 py-3 border-2 border-dashed border-white/10 rounded-xl text-gray-400 hover:text-white hover:border-purple-500 transition-all">
                    <i class="fas fa-plus-circle mr-2"></i> Ajouter une option
                </button>
            </div>

            <div class="fixed bottom-0 left-0 right-0 p-4 bg-stone-900/80 backdrop-blur-lg border-t border-white/5 lg:relative lg:bg-transparent lg:border-none lg:p-0">
                <div class="max-w-3xl mx-auto flex gap-3">
                    <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-4 rounded-2xl font-bold shadow-lg shadow-purple-500/20 transition-all active:scale-95">
                        <i class="fas fa-save mr-2"></i> Enregistrer
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function supprimerReponseExist(id, btn) {
            if (!confirm("Supprimer cette réponse ?")) return;
            const form = btn.closest('form');
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'reponses_delete[]';
            hidden.value = id;
            form.appendChild(hidden);
            btn.closest('.reponse-item').remove();
        }

        function ajouterReponse() {
            const container = document.getElementById('nouvelles-reponses');
            const index = Date.now();
            const div = document.createElement('div');
            div.className = "flex items-center gap-3 p-2 bg-white/5 rounded-xl border border-purple-500/30 mt-3 reponse-item animate-slide-in";
            div.innerHTML = `
                <input type="text" name="reponses_nouvelles[${index}]" placeholder="Nouvelle réponse..."
                       class="flex-1 bg-transparent border-none text-white focus:ring-0">
                <input type="checkbox" name="correcte_nouvelles[${index}]" class="custom-checkbox">
                <button type="button" class="text-red-400 p-2" onclick="this.closest('.reponse-item').remove()">
                    <i class="fas fa-trash-can"></i>
                </button>
            `;
            container.appendChild(div);
        }
    </script>
</body>

</html>