<?php
require_once 'includes/db.php';
//require_login();

$stmt = $pdo->query("
    SELECT e.*, u.name, u.avatar
    FROM entries e
    JOIN users u ON e.user_id = u.id
    ORDER BY e.entry_date ASC, e.id DESC
");  //Si tu veux inverser l'ordre (du plus ancien au plus récent) Il suffit de changer ce DESC en ASC : ORDER BY e.entry_date ASC, e.id ASC

$entries_by_date = [];
while ($entry = $stmt->fetch()) {
    $date = $entry['entry_date'];
    if (!isset($entries_by_date[$date])) {
        $entries_by_date[$date] = [];
    }
    $entries_by_date[$date][] = $entry;
}

// Récupérer tous les projets
$projects = $pdo->query("SELECT * FROM projects ORDER BY year DESC, title ASC")->fetchAll(PDO::FETCH_ASSOC);
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

    <meta property="og:title" content="Sternaafrica" />

    <meta name="description" content="Le Livre d'Or des volontaires du CSI : un espace où chaque jour de chantier devient un récit personnel, un témoignage précieux et partagé." />

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="/favicon/site.webmanifest" />

    <!-- Canonical URL (pour le SEO) -->
    <link rel="canonical" href="https://cahierdor.sternaafrica.org/" /> 
    <!-- meta for og.graph -->
    <meta property="og:image" content="https://i.postimg.cc/QdXTXZdD/Design-sans-titre-1.png" />
    <meta property="og:url" content="https://cahierdor.sternaafrica.org/" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="sternaafrica" />

    <!-- Twitter Cards -->
    <meta name="twitter:url" content="https://cahierdor.sternaafrica.org/" />
    <meta name="twitter:image" content="https://i.postimg.cc/QdXTXZdD/Design-sans-titre-1.png" />

    <link rel="manifest" href="./manifest.json">
    <meta name="theme-color" content="#1e3a8a">

</head>

<?php 
    require_once 'send_notification.php';

    // Si tu veux que ça envoie à chaque rechargement (temporairement)
    sendPushNotification(
    "Test automatique 📢",
    "Page index.php chargée → Notification envoyée automatiquement"
    );

    if (isset($_GET['testnotif'])) {
        sendPushNotification("Notification test depuis index", "Tu as bien reçu ce message 🎯");
      }
?>

<body class="bg-gray-900 text-gray-100 min-h-screen font-sans py-2  md:px-0 flex flex-col">
    <div class="max-w-4xl mx-auto md:p-0">
        <?php foreach ($projects as $project): ?>
            <h1 class="text-xl md:text-3xl font-bold text-yellow-400 mb-4 text-center">💫 Livre d'Or CSI <?= htmlspecialchars($project['country'] ?? 'Projet sans pays') ?> (<?= htmlspecialchars($project['year']) ?>)</h1>
        <?php endforeach; ?>

        <?php if (empty($entries_by_date)): ?>
            <p class="text-gray-400 text-center">Aucune entrée enregistrée pour le moment.😜</p>
        <?php else: ?>
            <div id="accordion">
                <?php $jour_index = 1;
                foreach ($entries_by_date as $date => $entries): ?>
                    <div class="mb-4">
                        <button class="w-full text-left p-1 md:p-4 bg-gray-700 hover:bg-gray-600 font-semibold text-yellow-300 focus:outline-none accordion-header text-center" style="border-radius: 8px 8px 0 0">
                            <?= date('d M Y', strtotime($date)) ?> | <?= $jour_index === 1 ? '1er jour' : $jour_index . 'e jour' ?> du CSI | Sterna - Mobil'
                        </button>
                        <div class="accordion-content hidden p-2 md:p-4 space-y-6">
                            <?php foreach ($entries as $entry): ?>
                                <div class="flex flex-col sm:flex-row items-start gap-3 sm:gap-4">
                                    <!-- Avatar seulement visible en dehors sur sm et plus -->
                                    <img src="<?= htmlspecialchars($entry['avatar']) ?>" class="w-12 h-12 rounded-full  shadow hidden sm:block" alt="Avatar">

                                    <!-- Bloc principal -->
                                    <div class="md:p-3 rounded-2xl w-full">
                                        <!-- Avatar + Nom côte à côte sur mobile -->
                                        <div class="flex items-center space-x-3 sm:hidden">
                                            <img src="<?= htmlspecialchars($entry['avatar']) ?>" class="w-10 h-10 rounded-full shadow" alt="Avatar">
                                            <p class="font-bold text-yellow-300 text-sm md:text-base"><?= htmlspecialchars($entry['name']) ?> - raconte sa journée
                                        </p>
                                        </div>

                                        <div class="text-gray-200 text-md md:text-base !mt-2 md:!mt-0">

                                            <?php
                                            $stmtBlocks = $pdo->prepare("SELECT * FROM entry_blocks WHERE entry_id = ?");
                                            $stmtBlocks->execute([$entry['id']]);
                                            while ($block = $stmtBlocks->fetch()):
                                                if (!empty($block['image'])) {
                                                    echo "<img src='uploads/" . htmlspecialchars($block['image']) . "' class='w-full max-h-96 object-cover rounded-lg mb-1'>";
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
                endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
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
                                const div = document.createElement("div");
                                div.className = "bg-gray-600 p-3 rounded-xl shadow text-sm md:text-base";
                                div.innerHTML = `
                                    <p class="font-semibold text-yellow-300">${comment.pseudo}</p>
                                    <p class="text-gray-200">${comment.comment.replace(/\n/g, '<br>')}</p>
                                    <p class="text-xs text-gray-400 text-right">${new Date(comment.created_at).toLocaleString()}</p>
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
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
            navigator.serviceWorker.register('/service-worker.js')
                .then(reg => console.log('✅ Service Worker enregistré:', reg.scope))
                .catch(err => console.error('❌ Erreur lors de l’enregistrement du SW:', err));
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

                // Si on vient d'ouvrir (et donc il était caché), on scroll
                if (wasHidden) {
                    // Petite pause pour que l'ouverture visuelle ait lieu, puis scroll
                    setTimeout(() => {
                        button.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 100);
                }
            });
        });
    </script>

    <?php include_once 'includes/footer.php'; ?>

 <!-- Firebase SDK -->
  <script src="https://www.gstatic.com/firebasejs/10.12.0/firebase-app-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/10.12.0/firebase-messaging-compat.js"></script>

  <script>
    const firebaseConfig = {
      apiKey: "AIzaSyAKQ0-2OjcsJTiReIlGuj0cRobabOOF_p4",
      authDomain: "Livredor-notifs.firebaseapp.com",
      projectId: "Livredor-notifs",
      storageBucket: "Livredor-notifs.appspot.com",
      messagingSenderId: "465608324866",
      appId: "1:465608324866:web:fbd51de15d6512588c741b"
    };

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('/firebase-messaging-sw.js')
        .then((registration) => {
          console.log('✅ Service Worker bien enregistré');

          Notification.requestPermission().then((permission) => {
            if (permission === 'granted') {
              console.log('🔔 Permission notifications accordée');

              messaging.getToken({
                vapidKey: "BCncP3ZREU78GAYnoD8cOTFP3NGNkXBZRYf06G1wJ0hoQaecG5NWe2ij5KrZdHI0On2i4YEzC0R35EwoWa31Hxs",
                serviceWorkerRegistration: registration
              })
              .then((token) => {
                console.log('🎯 Token reçu :', token);
              })
              .catch((err) => {
                console.error('❌ Erreur de récupération du token :', err);
              });

            } else {
              console.warn('🔕 Permission refusée');
            }
          });

        }).catch((error) => {
          console.error('❌ Erreur lors de l’enregistrement du SW :', error);
        });
    }
  </script>

</body>

</html>