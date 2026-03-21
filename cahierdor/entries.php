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
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="icon">
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="apple-touch-icon">
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
            <div class="bg-green-700/20 p-4 rounded-lg border border-green-500">
                <h3 class="text-lg font-semibold text-green-400 mb-2">C’est noté ! Tu viens de remplir le Cahier d'Or pour aujourd’hui. À la prochaine pour une nouvelle aventure ✨</h3>
                <p class="whitespace-pre-line text-gray-300"><?= nl2br(htmlspecialchars($entry['content'])) ?></p>

                <?php if ($entry['image']): ?>
                    <div class="mt-4">
                        <img src="uploads/<?= htmlspecialchars($entry['image']) ?>" alt="Image du jour" class="rounded-lg shadow w-full max-w-sm">
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <form action="submit_entry.php" method="post" enctype="multipart/form-data" class="space-y-6" id="entry-form">
                <div id="entry-blocks"></div>

                <input type="hidden" name="project_id" value="<?= htmlspecialchars($project_id) ?>">

                <div class="flex flex-wrap items-center mt-6 gap-3">
                    <!-- Bouton Ajouter un bloc -->
                    <button
                        type="button"
                        id="add-block"
                        class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold px-5 py-2.5 rounded-xl shadow-md transition duration-200">
                        + Ajouter un bloc
                    </button>

                    <!-- Espace auto entre les deux -->
                    <div class="flex-grow"></div>

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
                    const addButton = document.getElementById('add-block');

                    function addBlock(showRemoveButton = false) {
                        const block = document.createElement('div');
                        block.className = 'entry-block rounded-lg relative mb-4';

                        block.innerHTML = `
                            <!-- Zone de contenu (textarea) -->  
                            <textarea 
                                name="content[]" 
                                rows="8"
                                placeholder="Alors, tu nous racontes quoi de beau aujourd’hui ? 😎"
                                class="w-full bg-gray-800 text-white placeholder-gray-400 p-4 rounded-2xl shadow-inner resize-none focus:outline-none focus:ring-2 focus:ring-yellow-400 transition duration-150 ease-in-out mb-4"
                            ></textarea>

                            <!-- Input image stylisé -->
                            <label class="relative inline-flex items-center justify-center px-4 py-2 bg-gray-700 text-white rounded-xl shadow hover:bg-gray-600 transition cursor-pointer mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 01-2.828 0L2 10.828M17 7h5v5M21 21H3V3" />
                                </svg>
                                <span>Ajouter une image</span>
                                <input type="file" name="image[]" accept="image/*" class="image-input absolute inset-0 w-full h-full opacity-0 cursor-pointer">
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

                    addButton.addEventListener('click', () => {
                        addBlock(true);
                    });
                });
            </script>
        <?php endif; ?>

    </div>
    <div class="flex mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <a href="logout.php" class="text-sm text-gray-400 hover:text-red-400 bg-gray-700 px-4 py-2 rounded-lg shadow transition">
            Se déconnecter
        </a>
    </div>
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

</body>

</html>