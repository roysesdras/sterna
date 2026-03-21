<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// animateur_login.php

require_once '../config/db.php';
session_start();  // Démarrer la session pour gérer l'utilisateur

$error = '';  // Variable pour stocker l'erreur

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer et sécuriser le pseudo
    $pseudo = sanitize_input($_POST['pseudo'], $conn);

    if (!empty($pseudo)) {
        // Vérifier si le pseudo existe
        $stmt = $conn->prepare("SELECT id FROM animateur_quiz WHERE pseudo = ?");
        $stmt->bind_param("s", $pseudo);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id);

        if ($stmt->num_rows > 0 && $stmt->fetch()) {
            // Pseudo existant → connexion
            $_SESSION['animateur_id'] = $id;
            $_SESSION['animateur_pseudo'] = $pseudo;
        } else {
            // Pseudo inexistant → création
            $stmt_insert = $conn->prepare("INSERT INTO animateur_quiz (pseudo) VALUES (?)");
            $stmt_insert->bind_param("s", $pseudo);
            if ($stmt_insert->execute()) {
                $new_id = $stmt_insert->insert_id;
                $_SESSION['animateur_id'] = $new_id;
                $_SESSION['animateur_pseudo'] = $pseudo;
            } else {
                $error = "Erreur lors de la création du pseudo. Veuillez réessayer.";
            }
        }
        $stmt->close();

        if (empty($error)) {
            $animateur_id = $_SESSION['animateur_id'];

            // 🔹 Mettre à jour la dernière connexion
            $update = $conn->prepare("UPDATE animateur_quiz SET derniere_connexion = NOW() WHERE id = ?");
            $update->bind_param("i", $animateur_id);
            $update->execute();
            $update->close();

            // 🔹 Vérifier la dernière session
            $stmt = $conn->prepare("
                SELECT id, termine 
                FROM quiz_sessions 
                WHERE animateur = ? 
                ORDER BY id DESC 
                LIMIT 1
            ");
            $stmt->bind_param("i", $animateur_id);
            $stmt->execute();
            $stmt->bind_result($last_session_id, $termine);
            $stmt->fetch();
            $stmt->close();

            // 🔹 Créer une nouvelle session si aucune ou terminée
            if (empty($last_session_id) || $termine == 1) {
                $stmt = $conn->prepare("
        INSERT INTO quiz_sessions (animateur, termine, date_debut)
        VALUES (?, 0, NOW())
    ");
                $stmt->bind_param("i", $animateur_id);
                $stmt->execute();
                $new_session_id = $stmt->insert_id;
                $stmt->close();

                $_SESSION['quiz_session_id'] = $new_session_id;
            } else {
                $_SESSION['quiz_session_id'] = $last_session_id;
            }

            // Redirection vers le dashboard
            header("Location: animateur");
            exit;
        }
    } else {
        $error = "Veuillez entrer votre pseudo.";
    }
}

// Fonction pour sécuriser les entrées utilisateur
function sanitize_input($data, $conn)
{
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="theme-color" content="#7c3aed">
    <link rel="manifest" href="./manifest.json">

    <link rel="apple-touch-icon" href="https://sternaafrica.org/assets/img/icon-192.png">

    <title>Connexion Animateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Favicons -->
    <link href="https://sternaafrica.org/assets/img/icon-192.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/icon-192.png" rel="apple-touch-icon">
</head>

<body class="bg-stone-950 flex items-center justify-center min-h-screen text-white">
    <div class="bg-stone-900 p-2 rounded-2xl w-full max-w-sm shadow-xl">
        <h2 class="text-2xl font-bold mb-6 text-center">Connexion Animateur</h2>

        <?php if ($error): ?>
            <div class="bg-red-600 p-3 rounded mb-4 text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <input type="text" name="pseudo" placeholder="Votre pseudo" required
                class="w-full py-2 px-3 rounded-xl bg-stone-800 border border-stone-900 text-white placeholder-gray-400">
            <button type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 py-2 rounded-xl text-md transition-colors">
                Entrer
            </button>
        </form>
        <div class="mt-4">
            <p class="text-gray-400 text-md">
                Espace réservé exclusivement aux animateurs et formateurs.
                Saisissez simplement votre nom ou pseudo, puis cliquez sur "Entrer". <br>
                Une fois dans votre espace de travail, pensez toujours à lancer une nouvelle session avant toute action.
            </p>
        </div>
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