<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once 'includes/db.php';
require_once 'includes/auth.php';
require_login();

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];
$avatar = $_SESSION['avatar'];
$date_today = date('Y-m-d');

$stmt = $pdo->prepare("SELECT * FROM entries WHERE entry_date = ? AND user_id = ?");
$stmt->execute([$date_today, $user_id]);
$entry = $stmt->fetch();

$entry_blocks = [];
if ($entry) {
    $stmtBlocks = $pdo->prepare("SELECT * FROM entry_blocks WHERE entry_id = ?");
    $stmtBlocks->execute([$entry['id']]);
    $entry_blocks = $stmtBlocks->fetchAll();
}

$stmt = $pdo->query("SELECT id FROM projects ORDER BY year DESC LIMIT 1");
$project = $stmt->fetch();
$project_id = $project['id'] ?? null;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Journée | Cahier d’Or</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="/assets/img/external/84e554fe99_sternaofficiel-2.png" rel="icon">
    <link href="/assets/img/external/84e554fe99_sternaofficiel-2.png" rel="apple-touch-icon">
    <style>
        .image-preview {
            max-height: 200px;
            margin-top: 10px;
        }
    </style>
</head>

<body class="bg-gray-900 text-white min-h-screen font-sans flex flex-col">
    <div class="max-w-3xl mx-auto py-2 px-4 sm:px-6 lg:px-8 mt-4">

        <div class="flex items-center mb-6">
            <img src="<?= $avatar ?>" alt="avatar" class="w-14 h-14 rounded-full border-2 border-yellow-400 shadow">
            <div class="ml-4">
                <h2 class="text-xl font-bold text-yellow-300">Bonjour, <?= htmlspecialchars($name) ?> 👋</h2>
                <p class="text-gray-400 text-sm">Nous sommes le <?= date('d F Y') ?></p>
            </div>
        </div>

        <?php if ($entry): ?>
            <div class="bg-green-700/20 p-4 rounded-2xl border border-green-500 text-center shadow-xl flex flex-col items-center justify-center min-h-[50vh]">
                <h3 class="text-xl md:text-2xl font-bold text-green-400 mb-4">C’est noté !</h3>
                <p class="text-gray-300 text-base md:text-lg mb-8 max-w-md">Tu viens de remplir le livre d'Or pour aujourd’hui. À la prochaine.</p>
                
                <a href="index.php" class="bg-green-600 hover:bg-green-500 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition duration-200 transform hover:scale-105">
                    OK
                </a>
            </div>
        <?php else: ?>
            <!-- Bannière d'alerte hors-ligne -->
            <div id="offline-warning" class="hidden bg-yellow-600/30 border border-yellow-500/50 p-4 rounded-2xl text-yellow-300 mb-6 text-sm flex items-center gap-3 animate-pulse">
                <span class="text-xl">📶</span>
                <div>
                    <p class="font-semibold">Mode hors-ligne détecté</p>
                    <p class="text-xs text-gray-300">Tu as un récit en attente de réseau sur cet appareil. Il sera automatiquement publié dès que tu seras connecté !</p>
                </div>
            </div>

            <form action="submit_entry.php" method="post" enctype="multipart/form-data" class="space-y-6" id="entry-form">
                <div id="entry-blocks"></div>

                <input type="hidden" name="project_id" value="<?= htmlspecialchars($project_id) ?>">

                <!-- Sélecteur d'Humeur -->
                <div class="bg-gray-800/80 border border-gray-700/50 p-5 rounded-2xl shadow-inner mb-6">
                    <label class="block text-sm font-semibold text-yellow-300 mb-3">Comment s'est passée ta journée ? 😊</label>
                    <div class="flex flex-wrap gap-2.5">
                        <label class="cursor-pointer">
                            <input type="radio" name="mood" value="😊 En forme" class="hidden peer" checked>
                            <span class="px-3.5 py-2 bg-gray-700/60 hover:bg-gray-700 text-sm rounded-xl border border-transparent peer-checked:border-yellow-400 peer-checked:bg-yellow-400 peer-checked:text-gray-900 inline-block transition duration-200">😊 En forme</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="mood" value="🛠️ Productif" class="hidden peer">
                            <span class="px-3.5 py-2 bg-gray-700/60 hover:bg-gray-700 text-sm rounded-xl border border-transparent peer-checked:border-yellow-400 peer-checked:bg-yellow-400 peer-checked:text-gray-900 inline-block transition duration-200">🛠️ Productif</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="mood" value="😴 Fatigué mais heureux" class="hidden peer">
                            <span class="px-3.5 py-2 bg-gray-700/60 hover:bg-gray-700 text-sm rounded-xl border border-transparent peer-checked:border-yellow-400 peer-checked:bg-yellow-400 peer-checked:text-gray-900 inline-block transition duration-200">😴 Fatigué mais heureux</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="mood" value="🌟 Ému" class="hidden peer">
                            <span class="px-3.5 py-2 bg-gray-700/60 hover:bg-gray-700 text-sm rounded-xl border border-transparent peer-checked:border-yellow-400 peer-checked:bg-yellow-400 peer-checked:text-gray-900 inline-block transition duration-200">🌟 Ému</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="mood" value="🍲 Repas local au top" class="hidden peer">
                            <span class="px-3.5 py-2 bg-gray-700/60 hover:bg-gray-700 text-sm rounded-xl border border-transparent peer-checked:border-yellow-400 peer-checked:bg-yellow-400 peer-checked:text-gray-900 inline-block transition duration-200">🍲 Repas local au top</span>
                        </label>
                    </div>
                </div>

                <div class="flex flex-wrap items-center mt-6 gap-3">


                    <!-- Bouton Publier à droite -->
                    <button
                        type="submit"
                        class="ml-auto bg-indigo-500 hover:bg-indigo-600 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md transition duration-200">
                        Publier
                    </button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const container = document.getElementById('entry-blocks');

                    function addBlock(showRemoveButton = false) {
                        const block = document.createElement('div');
                        block.className = 'entry-block rounded-lg relative mb-4';

                        block.innerHTML = `
                            <textarea 
                                name="content[]" 
                                rows="8"
                                placeholder="Alors, tu nous racontes quoi de beau aujourd’hui ? 😎"
                                class="w-full bg-gray-800 text-white placeholder-gray-400 p-4 rounded-2xl shadow-inner resize-none focus:outline-none focus:ring-2 focus:ring-yellow-400 transition duration-150 ease-in-out mb-4"
                                required
                                oninvalid="this.setCustomValidity('Il faut écrire un petit texte pour raconter ta journée ! 📝')"
                                oninput="this.setCustomValidity('')"
                            ></textarea>

                            <!-- Input image stylisé -->
                            <label class="relative inline-flex items-center justify-center px-4 py-2 bg-gray-700 text-white rounded-xl shadow hover:bg-gray-600 transition cursor-pointer mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 01-2.828 0L2 10.828M17 7h5v5M21 21H3V3" />
                                </svg>
                                <span>Ajouter une image</span>
                                <input type="file" name="image[]" accept="image/*" class="image-input absolute inset-0 w-full h-full opacity-0 cursor-pointer" required oninvalid="this.setCustomValidity('Il faut obligatoirement ajouter une photo pour illustrer ton récit ! 📸')" onchange="this.setCustomValidity('')">
                            </label>

                            <img class="image-preview hidden rounded-lg max-h-40">

                            ${showRemoveButton ? `<button type="button" class="remove-block absolute top-0 right-0 text-red-500 hover:text-red-700 text-3xl">&times;</button>` : ''}
                        `;


                        container.appendChild(block);

                        const input = block.querySelector('.image-input');
                        const preview = block.querySelector('.image-preview');

                        input.addEventListener('change', () => {
                            const file = input.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = () => {
                                    preview.src = reader.result;
                                    preview.classList.remove('hidden');
                                };
                                reader.readAsDataURL(file);
                            } else {
                                preview.src = '';
                                preview.classList.add('hidden');
                            }
                        });

                        const removeBtn = block.querySelector('.remove-block');
                        if (removeBtn) {
                            removeBtn.addEventListener('click', () => {
                                container.removeChild(block);
                            });
                        }
                    }

                    addBlock(false);
                });
            </script>
        <?php endif; ?>

    </div>
    <?php if (!$entry): ?>
    <div class="flex mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <a href="logout.php" class="text-sm text-gray-400 hover:text-red-400 bg-gray-700 px-4 py-2 rounded-lg shadow transition">
            Se déconnecter
        </a>
    </div>
    <?php endif; ?>
    <?php include_once 'includes/footer.php'; ?>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll("textarea[name='content[]']").forEach(textarea => {
                const setAutoHeight = el => {
                    el.style.height = "auto";
                    el.style.height = el.scrollHeight + "px";
                };

                // Initial adjustment (for when page is pre-filled)
                setAutoHeight(textarea);

                // Adjust on input
                textarea.addEventListener("input", () => setAutoHeight(textarea));
            });
        });
    </script>

    <!-- Script de Synchronisation Hors-ligne (IndexedDB) -->
    <script>
        const DB_NAME = 'CahierDorOffline';
        const DB_VERSION = 1;
        const STORE_NAME = 'drafts';

        function openDB() {
            return new Promise((resolve, reject) => {
                const request = indexedDB.open(DB_NAME, DB_VERSION);
                request.onupgradeneeded = (e) => {
                    const db = e.target.result;
                    if (!db.objectStoreNames.contains(STORE_NAME)) {
                        db.createObjectStore(STORE_NAME, { keyPath: 'id', autoIncrement: true });
                    }
                };
                request.onsuccess = (e) => resolve(e.target.result);
                request.onerror = (e) => reject(e.target.error);
            });
        }

        async function saveDraft(draft) {
            const db = await openDB();
            return new Promise((resolve, reject) => {
                const tx = db.transaction(STORE_NAME, 'readwrite');
                const store = tx.objectStore(STORE_NAME);
                store.put(draft);
                tx.oncomplete = () => resolve();
                tx.onerror = () => reject(tx.error);
            });
        }

        async function getDrafts() {
            const db = await openDB();
            return new Promise((resolve, reject) => {
                const tx = db.transaction(STORE_NAME, 'readonly');
                const store = tx.objectStore(STORE_NAME);
                const request = store.getAll();
                request.onsuccess = () => resolve(request.result);
                request.onerror = () => reject(request.error);
            });
        }

        async function clearDrafts() {
            const db = await openDB();
            return new Promise((resolve, reject) => {
                const tx = db.transaction(STORE_NAME, 'readwrite');
                const store = tx.objectStore(STORE_NAME);
                store.clear();
                tx.oncomplete = () => resolve();
                tx.onerror = () => reject(tx.error);
            });
        }

        // Intercepter la soumission du formulaire
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('entry-form');
            if (form) {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    const submitBtn = form.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg> Envoi...
                    `;

                    // Si l'utilisateur est hors-ligne d'emblée
                    if (!navigator.onLine) {
                        await captureAndSaveDraft();
                        submitBtn.disabled = false;
                        submitBtn.textContent = "Publier";
                        return;
                    }

                    // Tentative d'envoi AJAX
                    const formData = new FormData(form);
                    try {
                        const response = await fetch('submit_entry.php', {
                            method: 'POST',
                            body: formData
                        });

                        if (response.ok) {
                            window.location.reload();
                        } else {
                            throw new Error("Erreur serveur");
                        }
                    } catch (error) {
                        console.warn("Échec de l'envoi réseau, basculement en local...", error);
                        await captureAndSaveDraft();
                    } finally {
                        submitBtn.disabled = false;
                        submitBtn.textContent = "Publier";
                    }
                });
            }

            // Vérifier et synchroniser
            checkAndSyncDrafts();
            window.addEventListener('online', checkAndSyncDrafts);
        });

        async function captureAndSaveDraft() {
            const form = document.getElementById('entry-form');
            const moodEl = form.querySelector('input[name="mood"]:checked');
            const projectEl = form.querySelector('input[name="project_id"]');

            const draft = {
                project_id: projectEl ? projectEl.value : '',
                mood: moodEl ? moodEl.value : '',
                blocks: []
            };

            const blocks = form.querySelectorAll('.entry-block');
            for (let block of blocks) {
                const textEl = block.querySelector('textarea[name="content[]"]');
                const fileEl = block.querySelector('input[type="file"]');

                const blockData = {
                    text: textEl ? textEl.value : '',
                    image: null,
                    imageName: ''
                };

                if (fileEl && fileEl.files.length > 0) {
                    blockData.image = fileEl.files[0];
                    blockData.imageName = fileEl.files[0].name;
                }

                if (blockData.text || blockData.image) {
                    draft.blocks.push(blockData);
                }
            }

            if (draft.blocks.length === 0) {
                alert("Ton récit est vide !");
                return;
            }

            await saveDraft(draft);

            // Notification visuelle
            alert("📶 Pas de connexion stable détectée. Ton récit du jour a été enregistré sur ton téléphone !\n\nIl sera publié automatiquement dès que tu seras connecté à internet.");
            window.location.reload();
        }

        async function checkAndSyncDrafts() {
            const drafts = await getDrafts();
            if (drafts.length === 0) return;

            const warningBanner = document.getElementById('offline-warning');

            if (navigator.onLine) {
                if (warningBanner) warningBanner.classList.add('hidden');

                // Notification toast de synchro
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 left-4 right-4 max-w-md mx-auto bg-yellow-500 text-gray-900 shadow-2xl rounded-2xl px-5 py-3.5 text-center z-50 font-bold flex items-center justify-center gap-2';
                toast.innerHTML = `
                    <svg class="animate-spin h-5 w-5 text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Synchronisation automatique de ton récit en cours...</span>
                `;
                document.body.appendChild(toast);

                for (let draft of drafts) {
                    const formData = new FormData();
                    formData.append('project_id', draft.project_id);
                    formData.append('mood', draft.mood);

                    draft.blocks.forEach((block, index) => {
                        formData.append('content[]', block.text);
                        if (block.image) {
                            formData.append(`image[${index}]`, block.image, block.imageName);
                        }
                    });

                    try {
                        const response = await fetch('submit_entry.php', {
                            method: 'POST',
                            body: formData
                        });

                        if (response.ok) {
                            await clearDrafts();
                            toast.className = 'fixed top-4 left-4 right-4 max-w-md mx-auto bg-green-600 text-white shadow-2xl rounded-2xl px-5 py-3.5 text-center z-50 font-bold flex items-center justify-center gap-2';
                            toast.innerHTML = '<span>✅ Récit synchronisé et publié avec succès !</span>';
                            setTimeout(() => {
                                toast.remove();
                                window.location.reload();
                            }, 2000);
                        } else {
                            throw new Error("Synchro échouée");
                        }
                    } catch (err) {
                        console.error(err);
                        toast.className = 'fixed top-4 left-4 right-4 max-w-md mx-auto bg-red-600 text-white shadow-2xl rounded-2xl px-5 py-3.5 text-center z-50 font-bold';
                        toast.innerHTML = '<span>⚠️ Échec de la synchronisation (réseau instable). Nouvelle tentative automatique.</span>';
                        setTimeout(() => toast.remove(), 4000);
                    }
                }
            } else {
                if (warningBanner) warningBanner.classList.remove('hidden');
            }
        }
    </script>

</body>

</html>