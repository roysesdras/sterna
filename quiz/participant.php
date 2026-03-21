<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require_once '../config/db.php';
session_start();

/* Vérifie si le participant est connecté */
if (!isset($_SESSION['participant_id'])) {
    header("Location: participant-connect");
    exit;
}

/* Vérifie si un animateur est connecté */
if (!isset($_SESSION['animateur_id'])) {
    die("<h2 style='color:red;'>❌ Aucun animateur connecté.</h2>");
}

$participant_id = (int) $_SESSION['participant_id'];
$animateur_id   = (int) $_SESSION['animateur_id'];

/* 🔎 1. Cherche une partie active pour cet animateur */
$stmt = $conn->prepare("
    SELECT id, termine 
    FROM parties_quiz 
    WHERE termine = 0 AND animateur_id = ? 
    ORDER BY date_debut DESC LIMIT 1
");
$stmt->bind_param("i", $animateur_id);
$stmt->execute();
$stmt->bind_result($partie_id, $termine);
$stmt->fetch();
$stmt->close();

/* 🆕 2. Si aucune partie active, créer automatiquement une nouvelle */
if (empty($partie_id)) {
    $titre = "Partie du " . date("d/m/Y H:i");
    $stmt = $conn->prepare("
        INSERT INTO parties_quiz (titre, date_debut, termine, animateur_id) 
        VALUES (?, NOW(), 0, ?)
    ");
    $stmt->bind_param("si", $titre, $animateur_id);
    $stmt->execute();
    $partie_id = $stmt->insert_id;
    $termine = 0;
    $stmt->close();
}

// Mettre à jour la session avec le `partie_id`
$_SESSION['partie_id'] = $partie_id;

/* 🔗 3. Associer le participant à la partie */
$stmt = $conn->prepare("
    SELECT COUNT(*) FROM scores_participants 
    WHERE participant_id = ? AND partie_id = ?
");
$stmt->bind_param("ii", $participant_id, $partie_id);
$stmt->execute();
$stmt->bind_result($existe);
$stmt->fetch();
$stmt->close();

if (!$existe) {
    $stmt = $conn->prepare("
        INSERT INTO scores_participants (participant_id, partie_id, score_total)
        VALUES (?, ?, 0)
    ");
    $stmt->bind_param("ii", $participant_id, $partie_id);
    $stmt->execute();
    $stmt->close();
}

/* 🔎 4. Récupérer le score total du participant */
$score_total = 0;
$stmt = $conn->prepare("
    SELECT score_total FROM scores_participants 
    WHERE participant_id = ? AND partie_id = ?
");
$stmt->bind_param("ii", $participant_id, $partie_id);
$stmt->execute();
$stmt->bind_result($score_total);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Quiz – Participant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#7c3aed">

    <!-- Favicons -->
    <link href="https://sternaafrica.org/assets/img/icon-192.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/icon-192.png" rel="apple-touch-icon">

    <script src="https://stats.digiroys.com/tracker.js" data-key="key_sterna_123"></script>

</head>

<style>
    #chrono-circle {
        transition: stroke-dashoffset 1s linear;
        filter: drop-shadow(0 0 6px #fbbf24);
    }

    #chrono-text {
        animation: pulse 1s ease-in-out infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.2);
            opacity: 0.8;
        }
    }
</style>


<body class="min-h-screen flex flex-col items-center bg-gradient-to-br from-stone-900 via-stone-800 to-black text-white overflow-y-auto relative">

    <canvas id="confetti-canvas" class="fixed inset-0 pointer-events-none"></canvas>

    <div class="w-full max-w-2xl p-2 rounded-2xl shadow-2xl relative z-10 border border-white/10 backdrop-blur-md bg-white/5 transition-transform">

        <h1 class="text-3xl text-center font-extrabold mb-3 bg-gradient-to-r from-amber-400 via-purple-400 to-pink-500 bg-clip-text text-transparent animate-pulse">
            🎯 Quiz en Live
        </h1>

        <div id="score" class="text-lg mb-4 text-center text-amber-300">
            Score total : <span id="score-total" class="font-bold text-amber-400"><?= (int)$score_total ?></span> point(s)
        </div>


        <div id="quiz-content" class="text-center">
            <p class="text-gray-400">Le jeu démarre bientôt… Préparez-vous !😁</p>
        </div>
    </div>

    <script>
        const PARTIE_ID = <?= (int)$partie_id ?>;
        let derniereQuestionId = null;
        let answeredQuestionId = null;
        let answeredMessage = "";
        let gameFinished = false;
        let chargerQuestionInterval = null;
        let verifierTermineInterval = null;

        function escapeHtml(unsafe) {
            if (unsafe === null || unsafe === undefined) return '';
            return String(unsafe)
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // ✅ Charger les questions régulièrement
        async function chargerQuestion() {
            if (gameFinished) return;

            try {
                const res = await fetch(`fetch_question.php?partie_id=${PARTIE_ID}`, {
                    cache: "no-store"
                });
                if (!res.ok) return;
                const data = await res.json();
                const zone = document.getElementById('quiz-content');

                if (!data || !data.question) {
                    if (!derniereQuestionId) {
                        zone.innerHTML = `<p class="text-gray-400">Le jeu démarre bientôt… Préparez-vous !😁</p>`;
                    }
                    return;
                }

                // Même question affichée : on garde le message précédent
                if (derniereQuestionId === data.question_id) {
                    if (answeredQuestionId === data.question_id && answeredMessage) {
                        const msgDiv = document.getElementById('message-reponse');
                        if (msgDiv) msgDiv.innerHTML = answeredMessage;
                    }
                    return;
                }

                // Nouvelle question détectée
                answeredQuestionId = null;
                answeredMessage = "";

                let html = `<div id="message-reponse" class="mb-2 font-semibold"></div>`;
                html += `<h2 class="text-xl font-semibold mb-3">${escapeHtml(data.question)}</h2>`;
                html += `
                    <div class="flex justify-center mb-3">
                        <div class="relative w-16 h-16">
                            <svg class="w-16 h-16 transform -rotate-90">
                                <circle cx="32" cy="32" r="28" stroke="gray" stroke-width="6" fill="none" opacity="0.2" />
                                <circle id="chrono-circle" cx="32" cy="32" r="28" stroke="#fbbf24" stroke-width="6" fill="none"
                                    stroke-linecap="round"
                                    stroke-dasharray="${2 * Math.PI * 28}"
                                    stroke-dashoffset="0" />
                            </svg>
                            <span id="chrono-text"
                                class="absolute inset-0 flex items-center justify-center text-lg font-bold text-amber-400">15</span>
                        </div>
                    </div>
                    `;
                // ⏳ chrono
                html += `<form id="formReponses" class="space-y-3">`;


                data.reponses.forEach(rep => {
                    html += `
                <label class="block text-center bg-gradient-to-r from-purple-700 to-indigo-700 hover:from-purple-600 hover:to-indigo-600 transition-all px-4 py-3 rounded-xl cursor-pointer shadow-md hover:shadow-lg">

                    <input type="checkbox" name="reponses[]" value="${rep.id}" class="mr-2 accent-purple-600">
                    ${escapeHtml(rep.reponse)}
                </label>
            `;
                });

                html += `
                    <input type="hidden" name="question_id" value="${data.question_id}">
                    <input type="hidden" name="partie_id" value="${PARTIE_ID}">
                    <button type="submit" id="submit-btn" class="mt-5 w-full py-3 rounded-xl bg-gradient-to-r from-amber-500 to-pink-500 font-semibold text-white hover:opacity-90 transition-all shadow-lg hover:shadow-amber-500/30">

                        Valider ma réponse
                    </button>
                </form>`;

                zone.innerHTML = html;
                derniereQuestionId = data.question_id;

                // ⏳ Chrono de 5 secondes animé
                let tempsRestant = 15;
                const circle = document.getElementById('chrono-circle');
                const chronoText = document.getElementById('chrono-text');
                const inputs = document.querySelectorAll('#formReponses input[type="checkbox"]');
                const boutonValider = document.getElementById('submit-btn');
                const circumference = 2 * Math.PI * 28;

                circle.style.strokeDasharray = circumference;
                circle.style.strokeDashoffset = 0;

                const intervalChrono = setInterval(() => {
                    tempsRestant--;
                    chronoText.textContent = tempsRestant;

                    const progress = tempsRestant / 15;
                    circle.style.strokeDashoffset = circumference * (1 - progress);

                    if (tempsRestant <= 0) {
                        clearInterval(intervalChrono);

                        // Désactiver les réponses et le bouton
                        inputs.forEach(i => i.disabled = true);
                        boutonValider.disabled = true;
                        boutonValider.textContent = "⏰ Temps écoulé";
                        boutonValider.classList.add("opacity-60", "cursor-not-allowed");
                    }
                }, 1000);


                // Gestion du formulaire
                const form = document.getElementById('formReponses');
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    clearInterval(intervalChrono);
                    if (gameFinished) return;

                    const formData = new FormData(e.target);
                    try {
                        const rep = await fetch('enregistrer_reponse.php', {
                            method: 'POST',
                            body: formData,
                            cache: "no-store"
                        });
                        const msg = await rep.text();

                        answeredQuestionId = data.question_id;
                        answeredMessage = msg;

                        const divMsg = document.getElementById('message-reponse');
                        if (divMsg) divMsg.innerHTML = msg;

                        // Masquer le bouton de validation
                        const submitBtn = document.getElementById('submit-btn');
                        if (submitBtn) submitBtn.style.display = 'none';

                        // Désactiver toutes les cases à cocher
                        document.querySelectorAll('#formReponses input[type="checkbox"]').forEach(el => el.disabled = true);

                        // ✅ Mise à jour locale du score
                        if (msg.includes('✅')) {
                            const found = msg.match(/\+(\d+)\s*point/);
                            if (found) {
                                const points = parseInt(found[1], 10);
                                const scoreSpan = document.getElementById('score-total');
                                scoreSpan.textContent = parseInt(scoreSpan.textContent || "0", 10) + points;
                            }
                        }
                    } catch (err) {
                        console.error('Erreur en soumettant la réponse', err);
                    }
                }, {
                    once: true
                });

            } catch (err) {
                console.error('Erreur chargerQuestion', err);
            }
        }

        // ✅ Vérifier si la partie est terminée
        async function verifierPartieTerminee() {
            if (gameFinished) return;

            try {
                const res = await fetch('resultats_quiz.php?partie_id=' + PARTIE_ID, {
                    cache: "no-store"
                });
                if (!res.ok) return;

                // Sécuriser le parsing JSON (éviter le "Unexpected token <")
                const text = await res.text();
                if (text.trim().startsWith('<')) {
                    console.error('⚠️ Le script PHP a renvoyé du HTML, pas du JSON:', text.slice(0, 200));
                    return;
                }

                const data = JSON.parse(text);
                if (data && data.termine) {
                    afficherResultats(data);
                    freezeUI();
                    gameFinished = true;
                    clearInterval(chargerQuestionInterval);
                    clearInterval(verifierTermineInterval);
                }
            } catch (err) {
                console.error('Erreur verifierPartieTerminee', err);
            }
        }

        function freezeUI() {
            document.querySelectorAll('#quiz-content button, #quiz-content input').forEach(el => {
                el.disabled = true; // Désactive tous les éléments interactifs dans quiz-content
            });
            // Le bouton Quitter reste actif
            const quitter = document.getElementById('btnQuitter');
            if (quitter) quitter.disabled = false;
        }

        // ✅ Affichage final fluide et responsive
        function afficherResultats(data) {
            const totalPoints = data.total_points || 0;
            const scoreTotal = data.score_total || 0;
            const pourcentage = totalPoints > 0 ? Math.round((scoreTotal / totalPoints) * 100) : 0;

            const reponsesHTML = (data.reponses || []).map((rep) => {
                const isCorrect = rep.correct;
                const colorClass = isCorrect ? 'bg-green-50 border-green-300' : 'bg-red-50 border-red-300';
                const icon = isCorrect ? '✅' : '❌';
                const textColor = isCorrect ? 'text-green-700' : 'text-red-700';

                return `
                <li class="p-2 border rounded-xl ${colorClass}">
                    <p class="font-medium ${textColor}">${icon} ${escapeHtml(rep.question_texte)}</p>
                    <p class="text-lg text-gray-600 mt-1">
                        Ta réponse : ${escapeHtml(rep.choix_participant.join(', ') || 'Aucune')}
                    </p>
                    ${!isCorrect ? `
                        <p class="text-sm text-green-700 mt-1">
                            La bonne réponse est : ${escapeHtml(rep.bonne_reponses.join(', '))}
                        </p>` : ''
                    }
                </li>
            `;
            }).join('');

            // 🔹 Bloc classement
            let classementHTML = '';
            if (data.classement && data.classement.length > 0) {
                const lignes = data.classement.map((p, i) => `
            <div class="flex justify-between py-1 border-b border-gray-200 text-gray-800">
                <span class="${i === 0 ? 'font-bold text-amber-600' : ''}">
                    ${i + 1}. ${escapeHtml(p.nom)}
                </span>
                <span class="${i === 0 ? 'font-bold text-amber-600' : ''}">
                    ${p.score_total} pts
                </span>
            </div>
        `).join('');

                classementHTML = `
                <div class="mt-4 bg-gray-50 border border-gray-200 rounded-xl p-2 shadow-sm">
                    <h3 class="text-lg font-semibold mb-2 text-gray-700 text-center">
                        🏆 Classement général
                    </h3>
                    ${lignes}
                </div>
            `;
            }

            // 🔹 Contenu complet avec page scrollable
            document.getElementById('quiz-content').innerHTML = `
            <div class="bg-gray-100 text-gray-900 shadow-2xl rounded-2xl p-2 border border-gray-200 max-w-3xl mx-auto flex flex-col space-y-6 animate-fade-in">

                <h2 class="text-3xl font-bold text-center">🎉 Quiz Terminé !</h2>
                <p class="text-center text-gray-600">Merci pour ta participation 👏</p>

                <div class="bg-gradient-to-r ${getColorGradient(pourcentage)} text-white text-center py-2 rounded-xl">
                    <p class="text-5xl font-extrabold">${pourcentage}%</p>
                    <p class="text-lg">Score : ${scoreTotal} / ${totalPoints} points</p>
                </div>

                ${classementHTML}

                <h3 class="text-xl font-semibold text-gray-700 mt-4">🧩 Tes réponses :</h3>
                <ul class="space-y-4">
                    ${reponsesHTML}
                </ul>
            </div>

        <!-- Bouton quitter toujours visible -->
        <div class="mt-4 text-center">
            <button id="btnQuitter" type="button"
                onclick="window.location.href='logout_participant.php'"
                class="px-4 py-3 rounded-full bg-amber-600 text-white font-medium hover:bg-amber-700 text-md shadow-md transition">
                Quitter
            </button>

        </div>
    `;
        }



        function getColorGradient(pourcentage) {
            if (pourcentage >= 80) return 'from-green-500 to-emerald-400';
            if (pourcentage >= 50) return 'from-yellow-500 to-amber-400';
            return 'from-red-500 to-orange-400';
        }

        // ✅ Lancer au chargement
        window.addEventListener('load', () => {
            chargerQuestion();
            verifierPartieTerminee();
            chargerQuestionInterval = setInterval(chargerQuestion, 3000);
            verifierTermineInterval = setInterval(verifierPartieTerminee, 2000);
        });
    </script>

    <script>
        // ✅ Ping automatique toutes les 5 secondes
        setInterval(() => {
            fetch('ping.php', {
                cache: "no-store"
            });
        }, 5000);
    </script>

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
        function startQuiz(quizName) {
            if (typeof DigiStats !== 'undefined') {
                DigiStats.track('quiz_start', {
                    quiz_name: quizName, // Ex: "Culture Générale"
                    difficulty: 'difficile',
                    user_level: 5
                });
            }
        }
    </script>

</body>

</html>