<?php
require_once '../config/db.php';
session_start();
if (!isset($_SESSION['animateur_id'])) {
    header("Location: animateur-connect");
    exit;
}

// Récupérer le pseudo pour l’affichage
$pseudo = htmlspecialchars($_SESSION['animateur_pseudo'], ENT_QUOTES, 'UTF-8');

// Récupérer catégories
$categories = $conn->query("SELECT * FROM categorie_quiz ORDER BY nom ASC");

// Récupérer questions et bonnes réponses
$questions = $conn->query("
    SELECT q.id AS question_id, q.question, c.nom AS categorie
    FROM question_quiz q
    LEFT JOIN categorie_quiz c ON q.categorie_id = c.id
    ORDER BY c.nom ASC
");

$reponses_correctes = [];
$res = $conn->query("SELECT question_id, reponse FROM reponse_quiz WHERE correcte = 1");
while ($row = $res->fetch_assoc()) {
    $reponses_correctes[$row['question_id']][] = $row['reponse'];
}

// Récupérer le code de l’animateur
$stmt = $conn->prepare("SELECT code FROM animateur_quiz WHERE id = ?");
$stmt->bind_param("i", $_SESSION['animateur_id']);
$stmt->execute();
$stmt->bind_result($animateur_code);
$stmt->fetch();
$stmt->close();

// ✅ Ajoute ceci :
$question_lancee = $_SESSION['question_lancee'] ?? null;

// Génération du code si demande
if (isset($_POST['generate_code']) && empty($animateur_code)) {
    $animateur_code = strtoupper(substr($_SESSION['animateur_pseudo'], 0, 4)) . rand(1000, 9999);
    $upd = $conn->prepare("UPDATE animateur_quiz SET code = ? WHERE id = ?");
    $upd->bind_param("si", $animateur_code, $_SESSION['animateur_id']);
    $upd->execute();
    $upd->close();
}

if (isset($_POST['nouvelle_session'])) {
    $animateur_id = $_SESSION['animateur_id'];

    // 1. Créer la nouvelle session
    $insert = $conn->prepare("
        INSERT INTO quiz_sessions (animateur, categorie_id, date_debut, termine) 
        VALUES (?, NULL, NOW(), 0)
    ");
    $insert->bind_param("i", $animateur_id);
    $insert->execute();
    $new_session_id = $insert->insert_id; // si besoin
    $insert->close();

    // 2. Supprimer les participants de l'ancienne session
    $delete = $conn->prepare("DELETE FROM participants WHERE animateur_id = ?");
    $delete->bind_param("i", $animateur_id);
    $delete->execute();
    $delete->close();

    // 3. Redirection
    header("Location: animateur#LancerNewQuiz");
    exit;
}

// Correction des lignes 74 et 75
$_SESSION['partie_id'] = $id_partie_en_cours ?? null;
$_SESSION['question_lancee'] = $id_question_en_cours ?? null;

// 🔍 Récupérer la dernière session active de l'animateur
$stmt = $conn->prepare("
    SELECT id, termine 
    FROM quiz_sessions 
    WHERE animateur = ? 
    ORDER BY id DESC 
    LIMIT 1
");
$stmt->bind_param("i", $_SESSION['animateur_id']);
$stmt->execute();
$stmt->bind_result($session_id, $session_terminee);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="fr" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pseudo ?> | Animateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#6f2be4">

    <!-- Favicons -->
    <link href="https://sternaafrica.org/assets/img/icon-192.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/icon-192.png" rel="apple-touch-icon">

    <link rel="stylesheet" href="./style.css">
    <script src="./script.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            100: '#1a1a1a',
                            200: '#2d2d2d',
                            300: '#404040',
                            400: '#525252',
                        }
                    }
                }
            }
        }
    </script>

    <script src="https://stats.digiroys.com/tracker.js" data-key="key_sterna_123"></script>

</head>

<body class="bg-stone-900 text-gray-200 min-h-screen font-sans">
    <!-- Contenu principal avec sidebar -->
    <main class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-2">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar des catégories - Visible seulement sur desktop SECTION 1-->
            <div class="hidden lg:block lg:w-1/4">
                <div class="glass-effect rounded-2xl p-4 sticky top-2 flex flex-col" style="max-height: 95vh;">

                    <h3 class="text-lg font-semibold mb-4 text-white">Catégories</h3>

                    <ul class="space-y-2 overflow-y-auto pr-2" id="listeCategories" style="max-height: 40vh; min-height: 150px;">
                        <?php while ($cat = $categories->fetch_assoc()): ?>
                            <li class="mr-1">
                                <button
                                    class="categorie-btn w-full text-left px-4 py-3 rounded-xl bg-dark-200 hover:bg-dark-300 text-gray-300 transition-all duration-300"
                                    data-target="cat-<?= $cat['id'] ?>">
                                    <?= htmlspecialchars($cat['nom']) ?>
                                </button>
                            </li>
                        <?php endwhile; ?>
                    </ul>

                    <div class="mt-auto pt-6 border-t border-dark-300 space-y-3">
                        <?php if (empty($animateur_code)): ?>
                            <form method="POST">
                                <button type="submit" name="generate_code" class="w-full flex items-center justify-center space-x-2 bg-dark-200 hover:bg-dark-300 text-gray-300 py-3 rounded-xl transition-colors duration-300">
                                    Générer votre code d'animateur
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="flex items-center space-x-2">
                                <input type="text" value="<?= htmlspecialchars($animateur_code) ?>" id="animateurCode" readonly
                                    class="bg-stone-700 px-3 py-2 rounded-xl text-white w-full text-sm font-mono">
                                <button onclick="copyCode()" type="button"
                                    class="bg-green-600 hover:bg-green-700 px-3 py-2 rounded-xl text-white transition text-sm">
                                    Copier
                                </button>
                            </div>
                        <?php endif; ?>

                        <div class="pt-2">
                            <?php if (empty($session_terminee) || $session_terminee == 0): ?>
                                <form id="formTerminer">
                                    <button type="submit" id="btnTerminer"
                                        class="w-full bg-red-700 hover:bg-red-800 px-4 py-2 rounded-xl text-white font-semibold transition">
                                        Terminer l’animation
                                    </button>
                                </form>
                            <?php else: ?>
                                <p class="text-green-600 font-semibold text-center py-2">
                                    Animation terminée ✓
                                </p>
                            <?php endif; ?>
                        </div>

                        <button class="w-full flex items-center justify-center space-x-2 bg-dark-200 hover:bg-dark-300 text-gray-300 py-3 rounded-xl transition-colors duration-300" onclick="window.location.href = 'documentation';">
                            <i class="fas fa-book"></i>
                            <span>Documentation</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Contenu FAQ et sidebar pour les mobiles-->
            <div class="lg:w-1/2">
                <!-- Bouton pour ouvrir les catégories sur mobile -->
                <div class="lg:hidden mb-2">
                    <button onclick="toggleMobileMenu()" id="iconButton" class="bg-dark-400 hover:bg-dark-500 text-white p-3 rounded-full transition-colors duration-300 shadow-lg">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>

                <!-- Section questions et reponse par categorie -->
                <div class="mb-4 space-y-6">
                    <?php
                    $categories = $conn->query("SELECT * FROM categorie_quiz ORDER BY nom ASC");

                    while ($cat = $categories->fetch_assoc()):
                        $cat_id = (int)$cat['id'];
                        $questions = $conn->query("
                        SELECT q.id AS question_id, q.question, cq.nom AS categorie
                        FROM question_quiz q
                        JOIN categorie_quiz cq ON q.categorie_id = cq.id
                        WHERE q.categorie_id = $cat_id
                        ORDER BY q.id DESC
                    ");

                        if ($questions && $questions->num_rows > 0):
                    ?>
                            <div class="categorie-section hidden animate-fade-in" id="cat-<?= $cat_id ?>">
                                <div class="flex items-center justify-between mb-6 pb-2 border-b border-white/10">
                                    <h2 class="text-2xl font-extrabold text-white flex items-center">
                                        <span class="w-2 h-8 bg-orange-500 rounded-full mr-4"></span>
                                        <?= htmlspecialchars($cat['nom']) ?>
                                    </h2>
                                    <span class="bg-dark-300 text-gray-400 text-xs px-3 py-1 rounded-full border border-white/5">
                                        <?= $questions->num_rows ?> questions
                                    </span>
                                </div>

                                <div class="grid gap-6">
                                    <?php while ($q = $questions->fetch_assoc()): ?>
                                        <div class="glass-effect rounded-2xl overflow-hidden border border-white/5 hover:border-purple-500/30 transition-all duration-300 shadow-xl">
                                            <div class="p-2 md:p-4">
                                                <button class="w-full flex justify-between items-start text-left group" onclick="toggleFAQ(<?= $q['question_id'] ?>)">
                                                    <div class="flex-1">
                                                        <div class="flex items-center gap-2 mb-2">
                                                            <span class="text-[10px] uppercase tracking-widest font-bold text-purple-400">Question #<?= $q['question_id'] ?></span>
                                                        </div>
                                                        <h3 class="text-lg font-bold text-white group-hover:text-purple-300 transition-colors leading-tight">
                                                            <?= stripslashes(htmlspecialchars_decode($q['question'])) ?>
                                                        </h3>
                                                    </div>
                                                    <div class="ml-4 mt-1 bg-white/5 p-2 rounded-lg group-hover:bg-purple-500/20 transition-all">
                                                        <i class="fas fa-chevron-down text-purple-500 faq-transition" id="icon-<?= $q['question_id'] ?>"></i>
                                                    </div>
                                                </button>

                                                <div class="faq-answer mt-2 overflow-hidden max-h-0 transition-all duration-300" id="answer-<?= $q['question_id'] ?>">
                                                    <div class="pt-4 mt-4 border-t border-white/5 space-y-2">
                                                        <?php if (isset($reponses_correctes[$q['question_id']])): ?>
                                                            <p class="text-[10px] font-bold text-green-500 uppercase tracking-wider mb-2">Réponses validées :</p>
                                                            <?php foreach ($reponses_correctes[$q['question_id']] as $i => $rep): ?>
                                                                <div class="flex items-center gap-3 bg-green-500/10 border border-green-500/20 p-2 rounded-xl">
                                                                    <i class="fas fa-check-circle text-green-500"></i>
                                                                    <p class="text-gray-200 text-sm italic">
                                                                        <?= stripslashes(htmlspecialchars_decode($rep)) ?>
                                                                    </p>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <div class="mt-6 flex items-center justify-between">
                                                    <div class="flex items-center gap-2 text-gray-500">
                                                        <i class="fas fa-tag text-xs"></i>
                                                        <span class="text-xs font-medium"><?= htmlspecialchars(stripslashes($q['categorie'])) ?></span>
                                                    </div>

                                                    <?php if ($question_lancee !== $q['question_id']): ?>
                                                        <button
                                                            type="button"
                                                            class="lancer-btn flex items-center gap-2 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-lg shadow-purple-900/20 transition-all active:scale-95"
                                                            data-question-id="<?= $q['question_id'] ?>">
                                                            <i class="fas fa-rocket text-xs"></i>
                                                            Lancer la question
                                                        </button>
                                                    <?php else: ?>
                                                        <button
                                                            type="button"
                                                            class="flex items-center gap-2 bg-stone-800 text-gray-500 text-sm font-bold px-5 py-2.5 rounded-xl cursor-not-allowed border border-white/5 shadow-inner"
                                                            disabled>
                                                            <i class="fas fa-check text-xs"></i>
                                                            Déjà lancée
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            </div>

                    <?php
                        else:
                            echo '<div class="categorie-section hidden italic text-gray-500 p-8 text-center bg-dark-200 rounded-2xl border border-dashed border-white/10" id="cat-' . $cat_id . '">Aucune question dans cette catégorie.</div>';
                        endif;
                    endwhile;
                    ?>
                </div>

                <script>
                    const sections = document.querySelectorAll('.categorie-section');
                    const catButtons = document.querySelectorAll('.categorie-btn');

                    function showCategory(targetId) {
                        // Cacher toutes les catégories
                        sections.forEach(section => section.classList.add('hidden'));

                        // Afficher la bonne
                        const activeSection = document.getElementById(targetId);
                        if (activeSection) {
                            activeSection.classList.remove('hidden');
                            activeSection.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }

                    catButtons.forEach(btn => {
                        btn.addEventListener('click', () => {
                            const target = btn.dataset.target;
                            showCategory(target);
                        });
                    });

                    // Afficher la première catégorie au chargement
                    document.addEventListener('DOMContentLoaded', () => {
                        const firstBtn = document.querySelector('.categorie-btn');
                        if (firstBtn) {
                            firstBtn.classList.add('active');
                            showCategory(firstBtn.dataset.target);
                        }
                    });
                </script>

                <script>
                    const mobileCatButtons = document.querySelectorAll('.mobile-categorie-btn');

                    mobileCatButtons.forEach(btn => {
                        btn.addEventListener('click', () => {
                            const target = btn.dataset.target;

                            // Synchroniser avec les boutons desktop
                            document.querySelectorAll('.categorie-btn').forEach(b => {
                                b.classList.toggle('active', b.dataset.target === target);
                            });

                            // Afficher la bonne catégorie
                            showCategory(target);

                            // Fermer le menu mobile
                            toggleMobileMenu();
                        });
                    });
                </script>

            </div>

            <!-- Sidebar : Joueurs Connectés -->
            <div class="lg:w-1/4">
                <div class="sticky top-2 z-4 space-y-4">

                    <div class="glass-effect rounded-2xl p-4">
                        <h3 class="text-lg font-semibold mb-4 text-white flex items-center gap-2">
                            <i class="fas fa-circle text-green-500 animate-pulse"></i>
                            Joueurs connectés
                        </h3>

                        <div id="joueursConnectes" class="space-y-2 max-h-[50vh] overflow-y-auto pr-1">
                            <p id="jc-loading" class="text-sm text-gray-400">Chargement...</p>
                        </div>

                        <div class="mt-3 text-sm text-orange-400 font-mono" id="jc-lastupdate"></div>
                        <div class="mt-1 text-sm text-green-400 font-semibold" id="jc-counter">
                            Questions lancées : 0
                        </div>
                    </div>

                    <div class="flex items-center">
                        <a id="btnLogout"
                            class="w-full text-center bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg"
                            style="cursor: pointer;"
                            onclick="window.location.href = 'logout_animateur.php';">
                            <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                        </a>
                    </div>

                </div>
            </div>

            <script>
                const JC_ENDPOINT = 'joueurs_connectes.php';
                const jcContainer = document.getElementById('joueursConnectes');
                const jcLast = document.getElementById('jc-lastupdate');
                const jcCounter = document.getElementById('jc-counter'); // ← ajoute ça
                let questionsLancees = 0; // ← compteur local

                let countdown = 15;
                let countdownInterval;
                let currentQuestionId = null; // Tracker la question en cours

                function renderJoueurs(data) {
                    jcContainer.innerHTML = '';

                    if (data.error) {
                        jcContainer.innerHTML = `<p class="text-sm text-red-400">${data.error}</p>`;
                        return;
                    }

                    // ✅ Met à jour le compteur directement depuis le PHP
                    if (typeof data.questions_lancees !== 'undefined') {
                        jcCounter.textContent = `Questions lancées : ${data.questions_lancees}`;
                    }

                    if (!data.joueurs || data.joueurs.length === 0) {
                        jcContainer.innerHTML = '<p class="text-sm text-gray-400">Aucun participant pour le moment.</p>';
                    } else {
                        data.joueurs.forEach(j => {
                            const item = document.createElement('div');
                            item.className = 'flex items-center justify-between px-3 py-2 rounded-xl bg-dark-200';

                            const left = document.createElement('div');
                            left.className = 'flex items-center space-x-3';
                            const avatar = document.createElement('div');
                            avatar.className = 'w-8 h-8 rounded-full bg-stone-700 flex items-center justify-center text-xs text-white';
                            avatar.textContent = j.pseudo.slice(0, 2).toUpperCase();
                            const name = document.createElement('div');
                            name.className = 'text-md text-gray-200';
                            name.textContent = j.pseudo;
                            left.appendChild(avatar);
                            left.appendChild(name);

                            const right = document.createElement('div');
                            if (j.a_repondu) {
                                right.className = 'text-md text-green-400 font-medium';
                                right.textContent = ' ' + (j.reponse || 'OK');
                            } else {
                                right.className = 'text-md text-yellow-400 font-medium';
                                right.textContent = 'En attente';
                            }

                            item.appendChild(left);
                            item.appendChild(right);
                            item.classList.add('animate-fade-in');

                            jcContainer.appendChild(item);
                        });
                    }

                    // 🔹 Si la question change, réinitialiser le timer
                    if (data.question_lancee !== currentQuestionId) {
                        currentQuestionId = data.question_lancee;
                        resetCountdown();
                    }
                }

                // 🔹 Timer
                function resetCountdown() {
                    clearInterval(countdownInterval);
                    countdown = 15;
                    updateCountdownDisplay();

                    countdownInterval = setInterval(() => {
                        countdown--;
                        updateCountdownDisplay();

                        if (countdown <= 0) {
                            clearInterval(countdownInterval);
                            jcLast.textContent = '⏰ Temps écoulé ! Lancez une nouvelle question.';
                        }
                    }, 1000);
                }

                function updateCountdownDisplay() {
                    jcLast.textContent = `Temps restant : 00:${countdown.toString().padStart(2, '0')}`;
                }

                // 🔹 Fetch des joueurs
                async function fetchJoueurs() {
                    try {
                        const res = await fetch(JC_ENDPOINT, {
                            cache: 'no-store',
                            credentials: 'include'
                        });
                        const data = await res.json();
                        renderJoueurs(data);
                    } catch (e) {
                        jcContainer.innerHTML = '<p class="text-sm text-red-400">Erreur de connexion.</p>';
                    }
                }

                // 🔹 Lancer le fetch initial + mise à jour toutes les 2s
                fetchJoueurs();
                setInterval(fetchJoueurs, 2000);
            </script>
        </div>
    </main>

    <!-- Modal des catégories sur mobile -->
    <div id="mobileMenuModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm transition-opacity duration-300">
        <!-- Conteneur latéral -->
        <div class="absolute top-0 right-0 w-3/4 max-w-xs h-full bg-dark-900 rounded-l-2xl shadow-2xl transform translate-x-full transition-transform duration-300">
            <div class="p-6 overflow-y-auto h-full">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-white">Catégories</h3>
                    <button onclick="toggleMobileMenu()" class="text-gray-400 hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <?php
                $categories_sidebar = $conn->query("SELECT * FROM categorie_quiz ORDER BY nom ASC");
                ?>
                <ul class="space-y-3 overflow-y-auto pr-2"
                    style="max-height: 45vh; scrollbar-width: thin; scrollbar-color: #6d28d9 transparent;">
                    <?php while ($cat = $categories_sidebar->fetch_assoc()): ?>
                        <li>
                            <button
                                class="w-full text-left px-4 py-3 rounded-xl bg-dark-200 hover:bg-dark-300 text-gray-300 transition-colors duration-300 mobile-categorie-btn"
                                data-target="cat-<?= $cat['id'] ?>">
                                <?= htmlspecialchars($cat['nom']) ?>
                            </button>
                        </li>
                    <?php endwhile; ?>
                </ul>

                <div class="mt-2 pt-6 border-t border-dark-300">
                    <div class="space-y-3">
                        <?php if (empty($animateur_code)): ?>
                            <form method="POST">
                                <button type="submit" name="generate_code"
                                    class="w-full flex items-center justify-center space-x-2 bg-dark-200 hover:bg-dark-300 text-gray-300 py-3 rounded-xl transition-colors duration-300">
                                    Générer votre code d'animateur
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="flex items-center space-x-3">
                                <input type="text" value="<?= htmlspecialchars($animateur_code) ?>" id="animateurCode" readonly
                                    class="bg-stone-700 px-3 py-2 rounded-xl text-white w-32">
                                <button onclick="copyCode()" type="button"
                                    class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-xl text-white transition">
                                    Copier
                                </button>
                            </div>
                        <?php endif; ?>

                        <script>
                            function copyCode() {
                                const codeInput = document.getElementById('animateurCode');
                                codeInput.select();
                                codeInput.setSelectionRange(0, 99999);
                                navigator.clipboard.writeText(codeInput.value)
                                    .then(() => alert("Code copié dans le presse-papier !"));
                            }
                        </script>

                        <?php
                        // Vérifier la dernière session de l'animateur
                        $stmt = $conn->prepare("
                                SELECT id, termine 
                                FROM quiz_sessions 
                                WHERE animateur = ? 
                                ORDER BY id DESC 
                                LIMIT 1
                            ");
                        $stmt->bind_param("i", $_SESSION['animateur_id']);
                        $stmt->execute();
                        $stmt->bind_result($last_session_id, $session_terminee);
                        $stmt->fetch();
                        $stmt->close();
                        ?>

                        <?php if (empty($session_terminee) || $session_terminee == 0): ?>
                            <!-- Bouton mobile pour terminer l’animation -->
                            <button id="btnTerminerMobile"
                                class="w-full bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-xl">
                                Terminer l’animation
                            </button>

                            <script>
                                document.getElementById('btnTerminerMobile').addEventListener('click', function() {
                                    const btn = this;
                                    btn.disabled = true;
                                    btn.style.opacity = "0.6";
                                    btn.innerText = "Animation terminée...";

                                    fetch('terminer_quiz.php', {
                                            method: 'POST'
                                        })
                                        .then(res => res.json())
                                        .then(data => {
                                            if (data.status === 'success') {
                                                // Masquer le bouton et afficher le message
                                                btn.style.display = "none";
                                                const msg = document.createElement('p');
                                                msg.className = "text-green-600 font-semibold text-center mt-4";
                                                msg.textContent = "Animation terminée ✓";
                                                btn.parentNode.appendChild(msg);

                                                // Désactiver les autres boutons de la page
                                                document.querySelectorAll('button').forEach(b => {
                                                    if (b.id !== 'btnTerminerMobile') {
                                                        b.disabled = true;
                                                        b.style.opacity = "0.5";
                                                    }
                                                });

                                                // Synchroniser avec le bouton desktop s’il existe
                                                const desktopBtn = document.getElementById('btnTerminer');
                                                if (desktopBtn) {
                                                    desktopBtn.disabled = true;
                                                    desktopBtn.style.opacity = "0.6";
                                                    desktopBtn.innerText = "Animation terminée...";
                                                    setTimeout(() => desktopBtn.style.display = "none", 800);
                                                }
                                            }
                                        })
                                        .catch(err => {
                                            console.error(err);
                                            btn.disabled = false;
                                            btn.style.opacity = "1";
                                            btn.innerText = "Terminer l’animation";
                                        });
                                });
                            </script>
                        <?php else: ?>
                            <!-- Message session déjà terminée -->
                            <p class="text-green-600 font-semibold text-center mt-4">
                                Animation terminée ✓
                            </p>
                        <?php endif; ?>
                    </div>
                </div>


                <div class="mt-8 pt-6 border-t border-dark-300">
                    <div class="space-y-3">
                        <button class="w-full flex items-center justify-center space-x-2 bg-dark-200 hover:bg-dark-300 text-gray-300 py-3 rounded-xl  transition-colors duration-300" onclick="window.location.href = 'documentation';">
                            <i class="fas fa-book"></i>
                            <span>Documentation</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // -----------------------------
            // FAQ toggle (inchangé)
            // -----------------------------
            let openFAQ = null;
            window.toggleFAQ = function(id) {
                const answer = document.getElementById(`answer-${id}`);
                const icon = document.getElementById(`icon-${id}`);
                if (!answer || !icon) return;

                if (openFAQ === id) {
                    answer.style.maxHeight = '0';
                    icon.style.transform = 'rotate(0deg)';
                    openFAQ = null;
                    return;
                }

                if (openFAQ !== null) {
                    const prevAnswer = document.getElementById(`answer-${openFAQ}`);
                    const prevIcon = document.getElementById(`icon-${openFAQ}`);
                    if (prevAnswer) prevAnswer.style.maxHeight = '0';
                    if (prevIcon) prevIcon.style.transform = 'rotate(0deg)';
                }

                answer.style.maxHeight = answer.scrollHeight + 'px';
                icon.style.transform = 'rotate(180deg)';
                openFAQ = id;
            }

            // -----------------------------
            // MOBILE SIDEBAR
            // -----------------------------
            const mobileModal = document.getElementById('mobileMenuModal');
            const mobileSidebar = mobileModal?.querySelector('.bg-dark-900');
            const mobileButtons = document.querySelectorAll('.mobile-categorie-btn');
            const allSections = document.querySelectorAll('.categorie-section');

            // Toggle menu mobile
            window.toggleMobileMenu = function() {
                if (!mobileModal || !mobileSidebar) return;

                if (mobileModal.classList.contains('hidden')) {
                    mobileModal.classList.remove('hidden');
                    mobileModal.style.display = 'block';
                    setTimeout(() => mobileSidebar.style.transform = 'translateX(0)', 10);
                } else {
                    mobileSidebar.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        mobileModal.classList.add('hidden');
                        mobileModal.style.display = 'none';
                    }, 300);
                }
            }

            // Clic sur catégorie mobile
            mobileButtons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetId = btn.dataset.target;
                    const targetSection = document.getElementById(targetId);

                    if (!targetSection) return;

                    // 1. Activer le bouton visuellement
                    mobileButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    // 2. Afficher la section (en arrière-plan)
                    allSections.forEach(s => s.classList.add('hidden'));
                    targetSection.classList.remove('hidden');

                    // 3. FERMER LE MENU (On utilise ta fonction existante)
                    // C'est beaucoup plus stable que transitionend
                    window.toggleMobileMenu();

                    // 4. Scroll fluide après un petit délai
                    setTimeout(() => {
                        targetSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 350);
                });
            });

            // Fermer mobile avec ESC
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape' && mobileModal && !mobileModal.classList.contains('hidden')) {
                    toggleMobileMenu();
                }
            });

            // Fermer en cliquant sur le fond
            mobileModal?.addEventListener('click', e => {
                if (e.target === mobileModal) toggleMobileMenu();
            });

            // -----------------------------
            // DESKTOP SIDEBAR
            // -----------------------------
            const desktopButtons = document.querySelectorAll('.categorie-btn');

            desktopButtons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetId = btn.dataset.target;
                    const targetSection = document.getElementById(targetId);
                    if (!targetSection) return;

                    // ✅ Activer le bouton
                    desktopButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    // ✅ Afficher uniquement la section cible
                    allSections.forEach(s => s.classList.add('hidden'));
                    targetSection.classList.remove('hidden');

                    // Scroll fluide
                    targetSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });

            // -----------------------------
            // Copier code animateur
            // -----------------------------
            window.copyCode = function() {
                const codeInput = document.getElementById('animateurCode');
                if (!codeInput) return;
                codeInput.select();
                codeInput.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(codeInput.value)
                    .then(() => alert("Code copié dans le presse-papier !"));
            }

        });
    </script>

    <!-- div pour le scroll vers la catégorie -->
    <script>
        function scrollToCategory(catId) {
            const target = document.getElementById(catId);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    </script>

    <script>
        function toggleMobileMenu() {
            const modal = document.getElementById('mobileMenuModal');
            modal.classList.toggle('hidden');
            const sidebar = modal.querySelector('div.absolute');
            sidebar.classList.toggle('translate-x-full');
        }

        // Scroll vers la catégorie et ferme le menu
        document.querySelectorAll('.mobile-categorie-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-target');
                const target = document.getElementById(targetId);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
                // Fermer le menu mobile
                toggleMobileMenu();
            });
        });
    </script>

    <!-- Bouton scroll intelligent -->
    <button id="scrollBtn" style="width: 40px; height: 40px;"
        class="fixed bottom-10 left-1/2 bg-stone-800 hover:bg-stone-700 text-white rounded-full shadow-2xl hidden transition-all duration-300">
        <i class="fas fa-arrow-down text-xl"></i>
    </button>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const scrollBtn = document.getElementById("scrollBtn");
            const icon = scrollBtn.querySelector("i");

            // Gestion de l'affichage intelligent
            window.addEventListener("scroll", () => {
                const scrollTop = window.scrollY;
                const windowHeight = window.innerHeight;
                const fullHeight = document.body.scrollHeight;

                // Montrer le bouton quand on n'est pas en haut
                if (scrollTop > 150) {
                    scrollBtn.classList.remove("hidden");
                } else {
                    scrollBtn.classList.add("hidden");
                }

                // Changer l'icône selon la position
                if (scrollTop + windowHeight >= fullHeight - 200) {
                    icon.classList.remove("fa-arrow-down");
                    icon.classList.add("fa-arrow-up");
                } else {
                    icon.classList.remove("fa-arrow-up");
                    icon.classList.add("fa-arrow-down");
                }
            });

            // Action du bouton
            scrollBtn.addEventListener("click", () => {
                const windowHeight = window.innerHeight;
                const fullHeight = document.body.scrollHeight;
                const scrollTop = window.scrollY;

                // Si on est déjà en bas → remonter
                if (scrollTop + windowHeight >= fullHeight - 200) {
                    window.scrollTo({
                        top: 0,
                        behavior: "smooth"
                    });
                } else {
                    // Sinon → descendre en bas
                    window.scrollTo({
                        top: fullHeight,
                        behavior: "smooth"
                    });
                }
            });
        });
    </script>
    <!-- Fin bouton scroll -->

    <button id="install-dash-btn" class="hidden fixed top-4 right-4 z-50 bg-amber-500 text-black p-2 rounded-full shadow-lg animate-pulse">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
        </svg>
    </button>

    <script>
        let dashPrompt;
        const dashBtn = document.getElementById('install-dash-btn');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            dashPrompt = e;
            // On affiche le bouton seulement si l'app n'est pas installée
            if (dashBtn) dashBtn.classList.remove('hidden');
        });

        if (dashBtn) {
            dashBtn.addEventListener('click', async () => {
                if (dashPrompt) {
                    dashPrompt.prompt();
                    const {
                        outcome
                    } = await dashPrompt.userChoice;
                    if (outcome === 'accepted') {
                        dashBtn.classList.add('hidden');
                    }
                    dashPrompt = null;
                }
            });
        }
    </script>

    <script>
        const categorieButtons = document.querySelectorAll('.categorie-btn');

        categorieButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                // Retirer l'état actif partout
                categorieButtons.forEach(b => b.classList.remove('active'));

                // Activer la catégorie cliquée
                btn.classList.add('active');
            });
        });

        if (categorieButtons.length > 0) {
            categorieButtons[0].classList.add('active');
        }
    </script>

    <script>
        document.addEventListener('click', function(e) {
            // On vérifie si l'élément cliqué (ou son parent) a la classe .lancer-btn
            const btn = e.target.closest('.lancer-btn');

            if (btn && typeof DigiStats !== 'undefined') {
                // On récupère le nom du quiz (soit dans le texte du bouton, soit dans un attribut data)
                const quizName = btn.innerText.trim() || "Quiz sans nom";

                DigiStats.track('quiz_start', {
                    quiz_name: quizName,
                    page_url: window.location.pathname,
                    timestamp: new Date().getTime()
                });

                console.log("Stats envoyées : Lancement du quiz " + quizName);
            }
        });
    </script>

</body>

</html>