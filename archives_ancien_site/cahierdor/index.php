<?php
require_once 'includes/db.php';
require_once 'includes/auth.php'; // Pour la session et les rôles

$stmt = $pdo->query("
    SELECT e.*, u.name, u.avatar
    FROM entries e
    JOIN users u ON e.user_id = u.id
    ORDER BY e.entry_date ASC, e.id DESC
");  //Si tu veux inverser l'ordre (du plus ancien au plus récent) Il suffit de changer ce DESC en ASC : ORDER BY e.entry_date ASC, e.id ASC

$entries_by_project = [];
while ($entry = $stmt->fetch()) {
    $date = $entry['entry_date'];
    $proj_id = $entry['project_id'] ?? 'unknown';
    
    if (!isset($entries_by_project[$proj_id])) {
        $entries_by_project[$proj_id] = [];
    }
    if (!isset($entries_by_project[$proj_id][$date])) {
        $entries_by_project[$proj_id][$date] = [];
    }
    $entries_by_project[$proj_id][$date][] = $entry;
}

// Récupérer tous les projets (ordre descendant)
$projects = $pdo->query("SELECT * FROM projects ORDER BY year DESC, title ASC")->fetchAll(PDO::FETCH_ASSOC);

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// === GESTION DYNAMIQUE DES VIGNETTES POUR LES RÉSEAUX SOCIAUX ===
$og_title = "Livre d'Or | Sterna Africa";
$og_description = "Découvrez les récits des bénévoles de Sterna Africa sur nos chantiers de solidarité internationale !";
$og_image = "https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png"; // Image par défaut
$og_url = "https://cahierdor.sternaafrica.org/";

if (!empty($_GET['jour'])) {
    $share_param = $_GET['jour']; // Format attendu : {proj_id}-{date}
    $og_url = "https://cahierdor.sternaafrica.org/?jour=" . htmlspecialchars($share_param);

    $parts = explode('-', $share_param, 2);
    if (count($parts) === 2) {
        $share_proj = $parts[0];
        $share_date = $parts[1];
        
        $stmt_og = $pdo->prepare("SELECT e.*, u.name FROM entries e JOIN users u ON e.user_id = u.id WHERE e.project_id = ? AND e.entry_date = ? LIMIT 1");
        $stmt_og->execute([$share_proj, $share_date]);
        if ($og_entry = $stmt_og->fetch()) {
            $og_title = "Récit de {$og_entry['name']} - Livre d'Or Sterna Africa";
            // On cherche la première image du récit pour la vignette
            $stmt_img = $pdo->prepare("SELECT image, text FROM entry_blocks WHERE entry_id = ? AND image IS NOT NULL LIMIT 1");
            $stmt_img->execute([$og_entry['id']]);
            if ($og_block = $stmt_img->fetch()) {
                if (!empty($og_block['image'])) {
                    $og_image = "https://cahierdor.sternaafrica.org/uploads/" . $og_block['image'];
                }
                if (!empty($og_block['text'])) {
                    $og_description = mb_substr(strip_tags($og_block['text']), 0, 150) . '...';
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'Or | Sterna Africa</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <meta name="robots" content="index">
    <meta name="robots" content="follow">

    <meta name="description" content="Le Livre d'Or des volontaires du CSI : un espace où chaque jour de chantier devient un récit personnel, un témoignage précieux et partagé." />
    
    <!-- Meta Open Graph (Facebook, WhatsApp, LinkedIn) -->
    <meta property="og:title" content="<?= htmlspecialchars($og_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($og_description) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($og_image) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($og_url) ?>">
    <meta property="og:type" content="website">
    
    <!-- Meta Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($og_title) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($og_description) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($og_image) ?>">

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png" />

    <!-- Canonical URL (pour le SEO) -->
    <link rel="canonical" href="https://cahierdor.sternaafrica.org/" />

    <link rel="manifest" href="./manifest.json">
    <meta name="theme-color" content="#111827">

</head>

<body class="bg-gray-900 text-gray-100 min-h-screen font-sans py-2  md:px-0 flex flex-col">
    <div class="max-w-4xl mx-auto md:p-0">

        <?php if (empty($entries_by_project)): ?>
            <p class="text-gray-400 text-center">Aucune entrée enregistrée pour le moment.😜</p>
        <?php else: ?>
            <div id="accordion">
                <?php 
                $is_first_project = true;
                // On boucle d'abord sur tous les projets connus pour garder le bon ordre (year DESC)
                foreach ($projects as $p):
                    $proj_id = $p['id'];
                    if (empty($entries_by_project[$proj_id])) continue; // Ignorer les projets sans récit
                    
                    $dates = $entries_by_project[$proj_id];
                    $current_project_name = !empty($p['title']) ? $p['title'] : 'CSI ' . $p['country'];
                    
                    // On supprime ce projet du tableau pour traiter les "unknown" à la fin
                    unset($entries_by_project[$proj_id]);
                ?>
                    
                    <h1 class="text-xl md:text-3xl font-bold text-yellow-400 mt-5 mb-6 text-center">💫 <?= htmlspecialchars($current_project_name) ?></h1>
                    
                    <?php 
                    $jour_index = 1;
                    foreach ($dates as $date => $entries): ?>
                        <div class="mb-4" id="jour-<?= htmlspecialchars($proj_id) ?>-<?= htmlspecialchars($date) ?>">
                            <button class="w-full text-left p-1 md:p-4 bg-gray-700 hover:bg-gray-600 font-semibold text-yellow-300 focus:outline-none accordion-header text-center" style="border-radius: 8px 8px 0 0">
                                <?= date('d M', strtotime($date)) ?> | <?= $jour_index === 1 ? '1er jour' : $jour_index . 'e jour' ?> du CSI <?= htmlspecialchars($current_project_name) ?>
                            </button>
                        <div class="accordion-content hidden p-2 md:p-4 space-y-6">
                            <?php foreach ($entries as $entry): ?>
                                <div class="flex flex-col sm:flex-row items-start gap-3 sm:gap-4">
                                    <!-- Avatar seulement visible en dehors sur sm et plus -->
                                    <img src="<?= htmlspecialchars($entry['avatar']) ?>" class="w-12 h-12 rounded-full shadow hidden sm:block" alt="Avatar" loading="lazy">

                                    <!-- Bloc principal -->
                                    <div class="md:p-3 rounded-2xl w-full">
                                        <!-- En-tête du récit (Nom + Humeur + Partage) -->
                                        <div class="flex items-center justify-between mb-3 w-full border-b border-gray-800 pb-2">
                                            <div class="flex items-center space-x-3">
                                                <img src="<?= htmlspecialchars($entry['avatar']) ?>" class="w-10 h-10 rounded-full shadow sm:hidden" alt="Avatar" loading="lazy">
                                                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                                                    <p class="font-bold text-yellow-300 text-sm md:text-base">
                                                        <?= htmlspecialchars($entry['name']) ?>
                                                    </p>
                                                    <?php if (!empty($entry['mood'])): ?>
                                                        <!--<span class="inline-flex text-xs bg-yellow-500/20 text-yellow-300 px-2.5 py-0.5 rounded-full border border-yellow-500/30 font-medium self-start sm:self-auto">
                                                            <?= htmlspecialchars($entry['mood']) ?>
                                                        </span>-->
                                                    <?php endif; ?>
                                                    <span class="text-gray-400 text-xs sm:text-sm font-normal hidden sm:inline"> raconte</span>
                                                </div>
                                            </div>
                                            
                                            <!-- Bouton Partager -->
                                            <button class="share-btn text-xs text-gray-400 hover:text-yellow-400 flex items-center gap-1 bg-gray-800/60 hover:bg-gray-800 px-2.5 py-1.5 rounded-xl border border-gray-700/50 transition cursor-pointer" data-author="<?= htmlspecialchars($entry['name']) ?>" data-date="<?= date('d M Y', strtotime($entry['entry_date'])) ?>" data-anchor="jour-<?= htmlspecialchars($proj_id) ?>-<?= htmlspecialchars($date) ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 10.742l4.636-2.318m0 0a3 3 0 102.267-4.035 3 3 0 00-2.267 4.035zm-4.636 2.318a3 3 0 100 5.002 3 3 0 000-5.002zm0 0l4.636 2.318m0 0a3 3 0 102.267-4.035 3 3 0 00-2.267 4.035z" />
                                                </svg>
                                                <span>Partager</span>
                                            </button>
                                        </div>

                                        <div class="text-gray-200 text-md md:text-base !mt-2 md:!mt-0">

                                            <?php
                                            $stmtBlocks = $pdo->prepare("SELECT * FROM entry_blocks WHERE entry_id = ?");
                                            $stmtBlocks->execute([$entry['id']]);
                                            while ($block = $stmtBlocks->fetch()):
                                                if (!empty($block['image'])) {
                                                    echo "<img src='uploads/" . htmlspecialchars($block['image']) . "' class='w-full max-h-96 object-cover rounded-lg mb-4' loading='lazy' alt='Image du récit'>";
                                                }
                                                //texte
                                                if (!empty($block['text'])) {
                                                    echo "<p class='mb-5'>" . nl2br(htmlspecialchars($block['text'])) . "</p>";
                                                }
                                            endwhile;
                                            ?>
                                        </div>

                                        <!-- 🔽 Commentaires -->
                                        <h1 class="text-yellow-300 text-xl !pt-4">
                                            Commentaires : (<span id="comment-count-<?= $entry['id'] ?>">0</span>)
                                        </h1>

                                        <div id="comments-<?= $entry['id'] ?>" class="mt-4 space-y-4 max-h-[400px] overflow-y-auto py-1"></div>

                                        <form id="comment-form-<?= $entry['id'] ?>" data-entry-id="<?= $entry['id'] ?>" class="comment-form flex flex-col gap-2 mt-8">
    
                                            <div class="pseudo-wrapper">
                                                <input 
                                                    type="text" 
                                                    name="pseudo" 
                                                    placeholder="Ton prénom" 
                                                    class="w-full bg-gray-800 text-white placeholder-gray-400 px-4 py-2 rounded-full shadow-inner focus:outline-none focus:ring-2 focus:ring-yellow-400 transition duration-150 ease-in-out"
                                                    required
                                                >
                                            </div>

                                            <div class="flex items-end gap-2">
                                                <textarea
                                                    id="comment-<?= $entry['id'] ?>"
                                                    name="comment"
                                                    placeholder="Commentaire...😊"
                                                    rows="1"
                                                    class="flex-1 bg-gray-800 text-white placeholder-gray-400 p-3 rounded-2xl resize-none overflow-hidden shadow-inner focus:outline-none focus:ring-2 focus:ring-yellow-400 transition duration-150 ease-in-out"
                                                    required
                                                ></textarea>

                                                <button type="submit" class="flex-shrink-0 flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white p-3 rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-yellow-400 transition duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12l14-7-7 14-1.5-6L5 12z" />
                                                    </svg>
                                                </button>
                                            </div>


                                            <input type="hidden" name="entry_id" value="<?= $entry['id'] ?>">

                                            <div class="error-message text-red-500 text-sm mt-1"></div>

                                            <!-- <button type="submit" class="ml-auto flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-yellow-400 transition duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12l14-7-7 14-1.5-6L5 12z" />
                                                </svg>
                                            </button> -->

                                        </form>


                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php $jour_index++;
                endforeach; // fin boucle jours
                ?>
                <?php endforeach; // fin boucle projets ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        const IS_ADMIN = <?= $isAdmin ? 'true' : 'false' ?>;

        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".comment-form").forEach(form => {
                if (form.dataset.initialized === "true") return;

                const entryId = form.dataset.entryId;
                const container = document.getElementById("comments-" + entryId);
                const submitButton = form.querySelector('button[type="submit"]');
                const errorBox = form.querySelector(".error-message");
                const pseudoWrapper = form.querySelector(".pseudo-wrapper");
                const pseudoInput = form.querySelector("input[name='pseudo']");
                const commentInput = form.querySelector("textarea[name='comment']");
                let isSubmitting = false;

                // === GESTION LOCALSTORAGE ===
                const today = new Date().toISOString().split("T")[0];
                const storageKey = `pseudo_entry_${entryId}_${today}`;
                const savedPseudo = localStorage.getItem(storageKey);

                if (savedPseudo) {
                    if (pseudoWrapper) pseudoWrapper.style.display = "none";
                    if (pseudoInput) pseudoInput.value = savedPseudo;
                }

                // === CHARGEMENT DES COMMENTAIRES ===
                function isUserNearBottom(container, threshold = 100) {
                    return container.scrollHeight - container.scrollTop - container.clientHeight < threshold;
                }

                function loadComments(forceScroll = false) {
                    const shouldScroll = isUserNearBottom(container);

                    fetch("charger_commentaires.php?entry_id=" + entryId)
                        .then(res => res.json())
                        .then(data => {
                            if (!Array.isArray(data.comments)) return;

                            container.innerHTML = "";
                            data.comments.forEach(comment => {
                                const deleteBtn = IS_ADMIN ? `<button class="text-red-400 hover:text-red-300 text-xs ml-3 delete-comment-btn" data-comment-id="${comment.id}">🗑️ Supprimer</button>` : '';
                                const div = document.createElement("div");
                                div.className = "bg-gray-600 p-3 rounded-xl shadow text-sm md:text-base";
                                div.innerHTML = `
                                    <div class="flex justify-between items-center mb-1">
                                        <p class="font-semibold text-yellow-300">${comment.pseudo}</p>
                                        ${deleteBtn}
                                    </div>
                                    <p class="text-gray-200">${comment.comment.replace(/\n/g, '<br>')}</p>
                                    <p class="text-xs text-gray-400 text-right mt-1">${new Date(comment.created_at).toLocaleString()}</p>
                                `;
                                container.appendChild(div);
                            });

                            const countEl = document.getElementById("comment-count-" + entryId);
                            if (countEl) {
                                countEl.textContent = data.total;
                            }

                            if (forceScroll || shouldScroll) {
                                container.scrollTop = container.scrollHeight;
                            }
                        })
                        .catch(console.error);
                }

                loadComments(true);
                setInterval(() => loadComments(), 3000);

                // === DELEGATED DELETE CLICK HANDLER (ADMIN) ===
                if (IS_ADMIN) {
                    container.addEventListener("click", (e) => {
                        const target = e.target;
                        if (target.classList.contains("delete-comment-btn")) {
                            const commentId = target.dataset.commentId;
                            if (confirm("Voulez-vous vraiment supprimer ce commentaire ?")) {
                                target.disabled = true;
                                target.textContent = "Suppression...";
                                
                                fetch("delete_comment.php", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/x-www-form-urlencoded"
                                    },
                                    body: "comment_id=" + commentId
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        loadComments(true);
                                    } else {
                                        alert(data.error || "Une erreur est survenue.");
                                        target.disabled = false;
                                        target.textContent = "🗑️ Supprimer";
                                    }
                                })
                                .catch(() => {
                                    alert("Erreur réseau ou serveur.");
                                    target.disabled = false;
                                    target.textContent = "🗑️ Supprimer";
                                });
                            }
                        }
                    });
                }

                // === GESTION DU FORMULAIRE ===
                form.addEventListener("submit", (e) => {
                    e.preventDefault();
                    if (isSubmitting) return;

                    isSubmitting = true;
                    errorBox.textContent = "";
                    submitButton.disabled = true;
                    submitButton.textContent = "Envoi...";

                    const formData = new FormData(form);

                    // Si pseudo visible => enregistrer dans localStorage
                    const pseudoValue = pseudoInput.value.trim();
                    if (pseudoWrapper && pseudoWrapper.style.display !== "none" && pseudoValue !== "") {
                        localStorage.setItem(storageKey, pseudoValue);
                    }

                    fetch("submit_comment.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            form.reset();
                            loadComments(true);

                            // Cacher champ pseudo après premier envoi
                            if (pseudoWrapper) pseudoWrapper.style.display = "none";
                            if (pseudoInput) pseudoInput.value = pseudoValue;
                        } else {
                            errorBox.textContent = data.error || "Une erreur est survenue.";
                        }
                    })
                    .catch(() => {
                        errorBox.textContent = "Erreur réseau ou serveur.";
                    })
                    .finally(() => {
                        isSubmitting = false;
                        submitButton.disabled = false;

                        // Remet l'icône d'envoi
                        submitButton.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12l14-7-7 14-1.5-6L5 12z" />
                            </svg>
                        `;
                    });
                });

                // === TEXTAREA AUTO-HEIGHT ===
                commentInput.addEventListener('input', e => {
                    e.target.style.height = 'auto';
                    e.target.style.height = e.target.scrollHeight + 'px';
                });

                form.dataset.initialized = "true";
            });
        });
    </script>



    <!-- Bannière d'installation PWA -->
    <div id="installBanner" class="fixed bottom-4 left-4 right-4 max-w-xl mx-auto bg-gray-900 text-white shadow-xl rounded-xl px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4 z-50" style="display: none;">
    <div class="text-center sm:text-left">
        <p class="text-sm font-semibold">Installez <span class="text-yellow-400">le Livre d'Or</span> comme application !</p>
        <p class="text-sm text-gray-300 mt-1">Accès rapide, même hors ligne.</p>
    </div>
    <div class="flex gap-2">
        <button id="installBtn" class="bg-yellow-500 hover:bg-yellow-400 text-black font-semibold px-4 py-2 rounded-lg transition">Installer</button>
        <button id="closeBanner" class="text-gray-400 hover:text-white transition text-sm">✕</button>
    </div>
    </div>

    <script>
        let deferredPrompt;
        const installBanner = document.getElementById('installBanner');
        const installBtn = document.getElementById('installBtn');
        const closeBtn = document.getElementById('closeBanner');

        // Détection iOS
        function isIOS() {
            return /iphone|ipad|ipod/.test(window.navigator.userAgent.toLowerCase());
        }

        // Détection si l'application est déjà installée sur iOS
        function isInStandaloneMode() {
            return ('standalone' in window.navigator) && window.navigator.standalone;
        }

        if (window.location.search.includes('clearinstall')) {
            localStorage.removeItem('install-refused');
        }

        // Si l'utilisateur n'a pas déjà refusé
        if (localStorage.getItem('install-refused') !== '1') {
            // Cas Android (avec beforeinstallprompt)
            window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            installBanner.style.display = 'flex';

            installBtn.innerText = 'Installer';
            installBtn.onclick = async () => {
                deferredPrompt.prompt();
                const result = await deferredPrompt.userChoice;

                if (result.outcome === 'accepted') {
                console.log('✅ L’utilisateur a accepté l’installation');
                } else {
                console.log('❌ L’utilisateur a refusé l’installation');
                localStorage.setItem('install-refused', '1');
                }

                installBanner.style.display = 'none';
                deferredPrompt = null;
            };
            });

            // Cas iOS
            if (isIOS() && !isInStandaloneMode()) {
            installBanner.style.display = 'flex';
            installBtn.innerText = 'Ajouter à l\'écran d\'accueil';
            installBtn.onclick = () => {
                alert("Pour installer l'application sur iPhone/iPad :\n\n1. Appuyez sur le bouton de partage de Safari (carré avec flèche en bas).\n2. Choisissez « Ajouter à l’écran d’accueil ».\n\nEnsuite, relancez l'app depuis l'icône créée.");
                installBanner.style.display = 'none';
                localStorage.setItem('install-refused', '1');
            };
            }

            // Bouton de fermeture (commun)
            closeBtn.onclick = () => {
            installBanner.style.display = 'none';
            localStorage.setItem('install-refused', '1');
            };
        }

        // Optionnel : écoute de l'événement d'installation
        window.addEventListener('appinstalled', () => {
            console.log('🎉 Application installée avec succès !');
        });
    </script>

    <script>
        // Fonction utilitaire pour convertir la clé publique VAPID
        function urlBase64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding)
                .replace(/\-/g, '+')
                .replace(/_/g, '/');
            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);
            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        }

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('service-worker.js')
                    .then(reg => {
                        console.log('✅ Service Worker enregistré:', reg.scope);

                        // Demander la permission et s'abonner aux notifications
                        return reg.pushManager.getSubscription()
                            .then(async (subscription) => {
                                if (subscription) {
                                    return subscription;
                                }

                                const permission = await Notification.requestPermission();
                                if (permission !== 'granted') {
                                    throw new Error('Permission notifications non accordée');
                                }

                                const VAPID_PUBLIC_KEY = "BFraVWz7Omh0DtS2AN3ZeGt1eVZDqAQjiaGmlabUxT-Bq0CEVM8vLstuB9iFTYJqS6b3oAgwBjOjKpy776ViUmY";
                                return reg.pushManager.subscribe({
                                    userVisibleOnly: true,
                                    applicationServerKey: urlBase64ToUint8Array(VAPID_PUBLIC_KEY)
                                });
                            });
                    })
                    .then(subscription => {
                        console.log('🎯 Abonnement VAPID Push réussi :', subscription);

                        // Envoyer l'abonnement sous forme d'objet JSON au serveur
                        const formData = new FormData();
                        formData.append('token', JSON.stringify(subscription));
                        <?php if (isset($_SESSION['user_id'])): ?>
                        formData.append('user_id', <?= (int)$_SESSION['user_id'] ?>);
                        <?php endif; ?>

                        fetch('save_token.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            console.log('Enregistrement abonnement réussi :', data);
                        })
                        .catch(err => {
                            console.error('Erreur enregistrement abonnement :', err);
                        });
                    })
                    .catch(err => {
                        console.error('❌ Erreur de configuration des notifications :', err);
                    });
            });
        }
    </script>


    <script>
        document.querySelectorAll('.accordion-header').forEach(button => {
            button.addEventListener('click', () => {
                const currentContent = button.nextElementSibling;

                // Fermer tous les autres
                document.querySelectorAll('.accordion-content').forEach(content => {
                    if (content !== currentContent) {
                        content.classList.add('hidden');
                    }
                });

                // Toggle celui cliqué
                const wasHidden = currentContent.classList.contains('hidden');
                currentContent.classList.toggle('hidden');

                // Si on vient d'ouvrir (et donc il était caché), on scroll et on prépare le popup
                if (wasHidden) {
                    // Petite pause pour que l'ouverture visuelle ait lieu, puis scroll
                    setTimeout(() => {
                        button.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 100);

                    // Afficher le popup après 10 secondes de lecture
                    if (!localStorage.getItem("newsletter_subscribed")) {
                        setTimeout(() => {
                            const popup = document.getElementById('newsletter-popup');
                            if (popup && popup.classList.contains('hidden')) {
                                popup.classList.remove('hidden');
                                popup.classList.add('flex');
                                // Petite pause pour la transition Tailwind
                                setTimeout(() => {
                                    popup.classList.remove('opacity-0');
                                    popup.firstElementChild.classList.remove('scale-95', 'translate-y-4');
                                    popup.firstElementChild.classList.add('scale-100', 'translate-y-0');
                                }, 50);
                            }
                        }, 10000);
                    }
                }
            });
        });
        
        // Ouvrir automatiquement l'accordéon si un hash ou paramètre est présent
        window.addEventListener('load', () => {
            // SÉCURITÉ : Forcer la fermeture de tous les accordéons au chargement
            document.querySelectorAll('.accordion-content').forEach(c => c.classList.add('hidden'));

            let targetId = null;
            if (window.location.hash) {
                targetId = window.location.hash.substring(1);
            } else {
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has('jour')) {
                    targetId = 'jour-' + urlParams.get('jour');
                }
            }

            if (targetId) {
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    const button = targetElement.querySelector('.accordion-header');
                    if (button) {
                        setTimeout(() => {
                            targetElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            // Highlight temporaire pour montrer quel récit a été partagé
                            button.classList.add('ring-4', 'ring-yellow-400', 'ring-opacity-50');
                            setTimeout(() => button.classList.remove('ring-4', 'ring-yellow-400', 'ring-opacity-50'), 3000);
                        }, 500);
                    }
                }
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const subscribeForm = document.getElementById("subscribe-form-popup");
            const subscribeMessage = document.getElementById("subscribe-message-popup");

            if (subscribeForm) {
                subscribeForm.addEventListener("submit", (e) => {
                    e.preventDefault();
                    
                    const submitBtn = subscribeForm.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.textContent = "Inscription...";
                    
                    const formData = new FormData(subscribeForm);
                    
                    fetch("subscribe.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        subscribeMessage.classList.remove("hidden", "text-green-400", "text-red-400");
                        if (data.success) {
                            subscribeMessage.classList.add("text-green-400");
                            subscribeMessage.textContent = data.message || "Inscription réussie ! 🎉";
                            subscribeForm.reset();
                            localStorage.setItem("newsletter_subscribed", "true");
                            
                            // Fermer automatiquement le popup après succès
                            setTimeout(() => {
                                const popup = document.getElementById("newsletter-popup");
                                if (popup) {
                                    popup.classList.add('opacity-0');
                                    popup.firstElementChild.classList.remove('scale-100', 'translate-y-0');
                                    popup.firstElementChild.classList.add('scale-95', 'translate-y-4');
                                    setTimeout(() => {
                                        popup.classList.add('hidden');
                                        popup.classList.remove('flex');
                                    }, 1000);
                                }
                            }, 2500);
                        } else {
                            subscribeMessage.classList.add("text-red-400");
                            subscribeMessage.textContent = data.message || "Une erreur est survenue.";
                        }
                    })
                    .catch(() => {
                        subscribeMessage.classList.remove("hidden", "text-green-400");
                        subscribeMessage.classList.add("text-red-400");
                        subscribeMessage.textContent = "Erreur réseau ou serveur.";
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.textContent = "S'abonner";
                    });
                });
            }
        });
    </script>

    <!-- Lightbox Modale -->
    <div id="lightbox" class="fixed inset-0 bg-black/95 hidden flex-col items-center justify-center z-50 transition-opacity duration-300 opacity-0">
        <!-- Close button -->
        <button id="lightbox-close" class="absolute top-4 right-4 text-white text-4xl hover:text-yellow-400 focus:outline-none cursor-pointer">&times;</button>
        <!-- Previous button -->
        <button id="lightbox-prev" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white text-4xl hover:text-yellow-400 focus:outline-none cursor-pointer">&lsaquo;</button>
        <!-- Image container -->
        <div class="max-w-4xl max-h-[80vh] px-4 flex items-center justify-center">
            <img id="lightbox-img" src="" alt="Zoom" class="max-w-full max-h-[80vh] rounded-lg shadow-2xl object-contain transition-transform duration-300">
        </div>
        <!-- Next button -->
        <button id="lightbox-next" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white text-4xl hover:text-yellow-400 focus:outline-none cursor-pointer">&rsaquo;</button>
        <!-- Caption -->
        <div id="lightbox-caption" class="text-gray-300 text-sm mt-4 text-center px-6 max-w-xl"></div>
    </div>

    <!-- Script Lightbox & Web Share -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // === LIGHTBOX GALLERY ===
            const lightbox = document.getElementById("lightbox");
            const lightboxImg = document.getElementById("lightbox-img");
            const lightboxCaption = document.getElementById("lightbox-caption");
            const closeBtn = document.getElementById("lightbox-close");
            const prevBtn = document.getElementById("lightbox-prev");
            const nextBtn = document.getElementById("lightbox-next");
            
            let currentImages = [];
            let currentIndex = 0;
            
            // Rendre les images de blocs cliquables
            document.querySelectorAll(".accordion-content img").forEach(img => {
                // Ne pas cibler les avatars
                if (img.classList.contains("rounded-full")) return;
                
                img.classList.add("cursor-pointer", "hover:opacity-90", "transition-opacity");
                img.addEventListener("click", () => {
                    currentImages = Array.from(document.querySelectorAll(".accordion-content img:not(.rounded-full)"));
                    currentIndex = currentImages.indexOf(img);
                    openLightbox();
                });
            });
            
            function openLightbox() {
                if (currentImages.length === 0) return;
                
                const img = currentImages[currentIndex];
                lightboxImg.src = img.src;
                
                // Caption facultative avec le nom de l'auteur
                const block = img.closest('.flex-col');
                const authorEl = block ? block.querySelector('.font-bold.text-yellow-300') : null;
                const authorName = authorEl ? authorEl.textContent.trim() : '';
                lightboxCaption.textContent = authorName ? `Photo du récit de ${authorName.split('-')[0].trim()}` : '';
                
                lightbox.classList.remove("hidden");
                setTimeout(() => {
                    lightbox.classList.remove("opacity-0");
                    lightbox.classList.add("opacity-100");
                }, 10);
            }
            
            function closeLightbox() {
                lightbox.classList.remove("opacity-100");
                lightbox.classList.add("opacity-0");
                setTimeout(() => {
                    lightbox.classList.add("hidden");
                }, 300);
            }
            
            function showPrev() {
                if (currentImages.length <= 1) return;
                currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
                openLightbox();
            }
            
            function showNext() {
                if (currentImages.length <= 1) return;
                currentIndex = (currentIndex + 1) % currentImages.length;
                openLightbox();
            }
            
            if (closeBtn) closeBtn.addEventListener("click", closeLightbox);
            if (prevBtn) prevBtn.addEventListener("click", showPrev);
            if (nextBtn) nextBtn.addEventListener("click", showNext);
            
            // Fermer sur clic en dehors de l'image
            if (lightbox) {
                lightbox.addEventListener("click", (e) => {
                    if (e.target === lightbox || e.target.id === 'lightbox-img-container') {
                        closeLightbox();
                    }
                });
            }
            
            // Raccourcis clavier
            document.addEventListener("keydown", (e) => {
                if (lightbox && !lightbox.classList.contains("hidden")) {
                    if (e.key === "Escape") closeLightbox();
                    if (e.key === "ArrowLeft") showPrev();
                    if (e.key === "ArrowRight") showNext();
                }
            });

            // === WEB SHARE API ===
            document.querySelectorAll(".share-btn").forEach(btn => {
                btn.addEventListener("click", () => {
                    const author = btn.dataset.author;
                    const date = btn.dataset.date;
                    const anchor = btn.dataset.anchor;
                    const paramValue = anchor.replace('jour-', '');
                    const cacheBuster = new Date().getTime();
                    const shareUrl = window.location.origin + window.location.pathname + '?jour=' + paramValue + '&t=' + cacheBuster;
                    const shareData = {
                        title: `Récit de ${author} - Livre d'Or Sterna Africa`,
                        text: `Découvrez ce que ${author} a partagé le ${date} sur le chantier de solidarité internationale de Sterna Africa ! 🌟`,
                        url: shareUrl
                    };
                    
                    if (navigator.share) {
                        navigator.share(shareData)
                            .then(() => console.log('Partagé avec succès'))
                            .catch(console.error);
                    } else {
                        // Plan B : Copie du lien dans le presse-papier
                        navigator.clipboard.writeText(shareData.url)
                            .then(() => {
                                const originalText = btn.innerHTML;
                                btn.innerHTML = `
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-green-400">Lien copié !</span>
                                `;
                                setTimeout(() => {
                                    btn.innerHTML = originalText;
                                }, 2000);
                            })
                            .catch(console.error);
                    }
                });
            });
            // === NEWSLETTER ===
            const newsletterBox = document.getElementById("newsletter-box");
            const subscribeForm = document.getElementById("subscribe-form");
            const subscribeMessage = document.getElementById("subscribe-message");

            // Si déjà abonné, on cache la boite complètement
            if (localStorage.getItem("sterna_newsletter_subscribed") === "true") {
                if (newsletterBox) newsletterBox.style.display = "none";
            }

            if (subscribeForm) {
                subscribeForm.addEventListener("submit", async (e) => {
                    e.preventDefault();
                    const emailInput = subscribeForm.querySelector("input[name='email']");
                    const submitBtn = subscribeForm.querySelector("button[type='submit']");
                    
                    if (!emailInput.value) return;

                    const originalBtnText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = "Patientez...";
                    subscribeMessage.classList.add("hidden");

                    try {
                        const formData = new FormData();
                        formData.append("email", emailInput.value);

                        const response = await fetch("subscribe.php", {
                            method: "POST",
                            body: formData
                        });
                        const data = await response.json();

                        if (data.success) {
                            // Succès !
                            subscribeForm.innerHTML = `<p class="text-green-400 font-bold text-center w-full py-2">✅ ${data.message}</p>`;
                            // On enregistre l'abonnement dans le navigateur
                            localStorage.setItem("sterna_newsletter_subscribed", "true");
                            
                            // On fait disparaître la boite après 3 secondes pour nettoyer l'écran
                            setTimeout(() => {
                                if (newsletterBox) {
                                    newsletterBox.style.opacity = '0';
                                    setTimeout(() => newsletterBox.style.display = 'none', 500);
                                }
                            }, 3000);
                        } else {
                            // Erreur
                            subscribeMessage.textContent = "⚠️ " + data.message;
                            subscribeMessage.classList.remove("hidden");
                            subscribeMessage.classList.add("text-red-400");
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnText;
                        }
                    } catch (error) {
                        subscribeMessage.textContent = "⚠️ Une erreur est survenue. Réessayez plus tard.";
                        subscribeMessage.classList.remove("hidden");
                        subscribeMessage.classList.add("text-red-400");
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    }
                });
            }
        });
    </script>

    <?php include_once 'includes/footer.php'; ?>
    <!-- BOÎTE NEWSLETTER (POPUP) -->
    <div id="newsletter-popup" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden flex-col items-center justify-center z-50 transition-opacity duration-1000 ease-in-out opacity-0">
        <div class="bg-gray-800 border border-gray-700/50 p-2 md:p-4 rounded-3xl shadow-2xl max-w-lg w-11/12 mx-auto text-center relative transform scale-95 translate-y-4 transition-all duration-1000 ease-out">
            <button id="close-newsletter" class="absolute top-4 right-4 text-gray-400 hover:text-white transition text-3xl focus:outline-none">&times;</button>
            <h2 class="text-xl md:text-2xl font-bold text-yellow-300 mb-2">Ne manquez aucun récit !</h2>
            <p class="text-gray-300 text-sm mb-6">Abonnez-vous pour recevoir une petite notification par e-mail dès qu'un bénévole publie son journal de bord.</p>
            
            <form id="subscribe-form-popup" class="flex flex-col gap-3">
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Votre adresse e-mail" 
                    required 
                    class="w-full bg-gray-900/60 text-white placeholder-gray-500 px-4 py-3 rounded-xl border border-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition text-sm"
                >
                <button 
                    type="submit" 
                    class="w-full bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-bold px-5 py-3 rounded-xl shadow-md transition duration-200"
                >
                    M'abonner
                </button>
            </form>
            <div id="subscribe-message-popup" class="text-sm mt-4 hidden font-medium"></div>
        </div>
    </div>
    <script>
        // Logique de fermeture du popup
        document.addEventListener("DOMContentLoaded", () => {
            const popup = document.getElementById("newsletter-popup");
            const closeBtn = document.getElementById("close-newsletter");
            
            function closeNewsletter() {
                if(!popup) return;
                popup.classList.add('opacity-0');
                popup.firstElementChild.classList.remove('scale-100', 'translate-y-0');
                popup.firstElementChild.classList.add('scale-95', 'translate-y-4');
                setTimeout(() => {
                    popup.classList.add('hidden');
                    popup.classList.remove('flex');
                }, 1000); // 1000ms to match the new duration-1000
                localStorage.setItem("newsletter_closed", "true");
            }
            
            if (closeBtn) {
                closeBtn.addEventListener("click", closeNewsletter);
            }
        });
    </script>
</body>

</html>