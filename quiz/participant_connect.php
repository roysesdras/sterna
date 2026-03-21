<?php
require_once '../config/db.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = trim($_POST['pseudo']);
    $code = trim($_POST['code']); // Code animateur

    if (!empty($pseudo) && !empty($code)) {

        // 🔹 Vérifie si le code animateur existe
        $stmt = $conn->prepare("SELECT id, pseudo FROM animateur_quiz WHERE code = ?");
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $stmt->bind_result($animateur_id, $animateur_pseudo);
        $animateur_exists = $stmt->fetch();
        $stmt->close();

        if (!$animateur_exists) {
            $error = "Code animateur invalide.";
        } else {
            // 🔹 Récupérer la session en cours de l'animateur
            $stmt_session = $conn->prepare("
                SELECT id 
                FROM quiz_sessions 
                WHERE animateur = ? AND termine = 0 
                ORDER BY id DESC 
                LIMIT 1
            ");
            $stmt_session->bind_param("i", $animateur_id);
            $stmt_session->execute();
            $stmt_session->bind_result($session_id);
            $stmt_session->fetch();
            $stmt_session->close();

            if (empty($session_id)) {
                $error = "Aucune session en cours pour cet animateur.";
            } else {
                // 🔹 Vérifie si le pseudo existe déjà
                $stmt2 = $conn->prepare("SELECT id FROM participants WHERE pseudo = ?");
                $stmt2->bind_param("s", $pseudo);
                $stmt2->execute();
                $stmt2->bind_result($participant_id);
                $exists = $stmt2->fetch();
                $stmt2->close();

                if ($exists) {
                    // ✅ Met à jour animateur_id et session_id pour ce participant
                    $update = $conn->prepare("
                        UPDATE participants 
                        SET animateur_id = ?, session_id = ?, connecte = 1, dernier_ping = NOW() 
                        WHERE id = ?
                    ");
                    $update->bind_param("iii", $animateur_id, $session_id, $participant_id);
                    $update->execute();
                    $update->close();

                    // ✅ Connexion
                    $_SESSION['participant_id'] = $participant_id;
                    $_SESSION['participant_pseudo'] = $pseudo;
                    $_SESSION['animateur_id'] = $animateur_id;
                    $_SESSION['animateur_pseudo'] = $animateur_pseudo;
                    header("Location: participant");
                    exit;
                } else {
                    // ✅ Création du participant lié à la session
                    $insert = $conn->prepare("
                        INSERT INTO participants (pseudo, animateur_id, session_id, a_repondu, date_inscription, connecte, dernier_ping) 
                        VALUES (?, ?, ?, 0, NOW(), 1, NOW())
                    ");
                    $insert->bind_param("sii", $pseudo, $animateur_id, $session_id);

                    if ($insert->execute()) {
                        $_SESSION['participant_id'] = $insert->insert_id;
                        $_SESSION['participant_pseudo'] = $pseudo;
                        $_SESSION['animateur_id'] = $animateur_id;
                        $_SESSION['animateur_pseudo'] = $animateur_pseudo;
                        $insert->close();

                        header("Location: participant");
                        exit;
                    } else {
                        $error = "Erreur lors de l'inscription. Réessayez.";
                    }
                }
            }
        }
    } else {
        $error = "Veuillez entrer votre pseudo et le code animateur.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Participant</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Favicons -->
    <link href="https://sternaafrica.org/assets/img/icon-192.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/icon-192.png" rel="apple-touch-icon">

    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#7c3aed">
</head>

<body class="bg-stone-950 text-white flex items-center justify-center min-h-screen">
    <div class="bg-stone-900 p-6 rounded-2xl w-full max-w-md shadow-xl">
        <h1 class="text-2xl font-bold mb-6 text-center">🎮 Connexion au Quiz</h1>

        <?php if ($error): ?>
            <p class="bg-red-600 text-white px-3 py-2 rounded mb-4 text-sm"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <input type="text" name="pseudo" placeholder="Entrez votre pseudo"
                class="w-full bg-stone-800 border border-gray-600 px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-600" required>
            <input type="text" name="code" placeholder="Entrez le code animateur"
                class="w-full bg-stone-800 border border-gray-600 px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-600" required>
            <button type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 py-3 rounded-xl font-semibold transition">
                Se connecter
            </button>
        </form>

        <p class="mt-6 text-gray-400 text-sm text-center">
            Entrez votre pseudo et le code de l'animateur pour rejoindre le quiz en cours.
        </p>
    </div>

    <div id="install-banner" class="hidden fixed bottom-4 left-4 right-4 z-50 bg-stone-900 border border-amber-500/50 p-4 rounded-2xl shadow-2xl flex items-center justify-between animate-bounce">
        <div class="flex items-center gap-3">
            <div class="bg-amber-500 p-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-white">Installer LiveQ</p>
                <p class="text-xs text-gray-400">Pour une expérience plus rapide !</p>
            </div>
        </div>
        <button id="install-pwa-btn" class="bg-amber-500 hover:bg-amber-600 text-black px-4 py-2 rounded-xl text-sm font-bold transition-all">
            Installer
        </button>
    </div>

    <script>
        // 1. Enregistrement du Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('./sw.js')
                    .then(reg => console.log('SW enregistré'))
                    .catch(err => console.log('Erreur SW', err));
            });
        }

        // 2. Gestion du popup d'installation
        let deferredPrompt;
        const installBtn = document.getElementById('install-pwa-btn');
        const installBanner = document.getElementById('install-banner');

        window.addEventListener('beforeinstallprompt', (e) => {
            // Empêche Chrome d'afficher sa propre bannière automatique
            e.preventDefault();
            // Garde l'événement pour plus tard
            deferredPrompt = e;
            // Affiche notre bannière personnalisée
            installBanner.classList.remove('hidden');
        });

        if (installBtn) {
            installBtn.addEventListener('click', async () => {
                if (deferredPrompt) {
                    // Affiche le vrai prompt d'installation
                    deferredPrompt.prompt();
                    const {
                        outcome
                    } = await deferredPrompt.userChoice;
                    console.log(`Réponse de l'utilisateur : ${outcome}`);
                    deferredPrompt = null;
                    // Cache notre bannière après le choix
                    installBanner.classList.add('hidden');
                }
            });
        }
    </script>
</body>

</html>