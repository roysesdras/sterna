<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();
require_once '../inclusion/db.php';

// Vérifie que le formateur est connecté
if (!isset($_SESSION['formateur_id'])) {
    header('Location: admin/connect');
    exit;
}

// Récupération des données du formateur connecté
$stmt = $pdo->prepare("SELECT * FROM formateurs WHERE id = ?");
$stmt->execute([$_SESSION['formateur_id']]);
$formateur = $stmt->fetch();

if (!$formateur) {
    echo "Formateur introuvable.";
    exit;
}

// Récupérer les 7 premiers volontaires
$limit = 5;

$stmt = $pdo->prepare("SELECT * FROM users ORDER BY nom ASC LIMIT :limit");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();

$volontaires = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Connexion africa_db
try {
    $pdoAfrica = new PDO(
        'mysql:host=db;dbname=africa_db',
        'root',
        'SoftiP24'
    );
    $pdoAfrica->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à africa_db : " . $e->getMessage());
}

// Récupérer les missions pour les premiers volontaires
$missionStmt = $pdoAfrica->query("
    SELECT volontaire_id, COUNT(DISTINCT mission_id) AS total
    FROM temoignages
    WHERE is_volontaire = 1
    GROUP BY volontaire_id
");

$missions = [];
foreach ($missionStmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $missions[$row['volontaire_id']] = $row['total'];
}

// Récupérer le nombre total de volontaires
$stmt = $pdo->query("SELECT COUNT(*) AS total FROM users");
$total_volontaires = $stmt->fetchColumn();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace admin volontaire</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js CDN -->
    <script defer src="https://unpkg.com/alpinejs@3.13.0/dist/cdn.min.js"></script>

    <link href="https://sternaafrica.org/assets/img/favicon.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/apple-touch-icon.png" rel="apple-touch-icon">
</head>

<body class="bg-gray-200 font-sans min-h-screen">
    <div x-data="{ openSidebar: false, activeSection: 'dashboard' }" class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar -->
        <aside class="bg-white shadow-lg transition-all duration-300 ease-in-out fixed md:static inset-y-0 left-0 z-50 w-20 md:w-64"
            :class="{ 'w-64': openSidebar, 'hidden md:block': !openSidebar }">
            <div class="p-4 flex items-center justify-between border-b">
                <h1 :class="{ 'opacity-100': openSidebar || window.innerWidth >= 768, 'opacity-0 hidden': !openSidebar && window.innerWidth < 768 }"
                    class="text-xl font-bold text-indigo-700 transition-opacity duration-300">Sterna Africa</h1>
                <button @click="openSidebar = !openSidebar" class="md:hidden p-2 rounded-full hover:bg-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
            <nav class="py-4">
                <ul class="space-y-2">
                    <li>
                        <a href="#" @click.prevent="activeSection = 'dashboard'; openSidebar = false"
                            class="flex items-center space-x-3 px-4 py-2 hover:bg-gray-100 rounded-lg transition-colors"
                            :class="{ 'bg-gray-100': activeSection === 'dashboard' }">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0l-2-2m2 2V4a1 1 0 00-1-1h-3a1 1 0 00-1 1z" />
                            </svg>
                            <span :class="{ 'block opacity-100': openSidebar || window.innerWidth >= 768, 'hidden opacity-0': !openSidebar && window.innerWidth < 768 }"
                                class="text-gray-700 transition-opacity duration-300">Espace</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="activeSection = 'orders'; openSidebar = false"
                            class="flex items-center space-x-3 px-4 py-2 hover:bg-gray-100 rounded-lg transition-colors"
                            :class="{ 'bg-gray-100': activeSection === 'orders' }">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            <span :class="{ 'block opacity-100': openSidebar || window.innerWidth >= 768, 'hidden opacity-0': !openSidebar && window.innerWidth < 768 }"
                                class="text-gray-700 transition-opacity duration-300">Créer Formation</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" @click.prevent="activeSection = 'reponses'; openSidebar = false"
                            class="flex items-center space-x-3 px-4 py-2 hover:bg-gray-100 rounded-lg transition-colors"
                            :class="{ 'bg-gray-100': activeSection === 'reponses' }">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            <span :class="{ 'block opacity-100': openSidebar || window.innerWidth >= 768, 'hidden opacity-0': !openSidebar && window.innerWidth < 768 }"
                                class="text-gray-700 transition-opacity duration-300">Réponses aux Formations</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" @click.prevent="activeSection = 'examens'; openSidebar = false"
                            class="flex items-center space-x-3 px-4 py-2 hover:bg-gray-100 rounded-lg transition-colors"
                            :class="{ 'bg-gray-100': activeSection === 'examens' }">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span :class="{ 'block opacity-100': openSidebar || window.innerWidth >= 768, 'hidden opacity-0': !openSidebar && window.innerWidth < 768 }"
                                class="text-gray-700 transition-opacity duration-300">Examens</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" @click.prevent="activeSection = 'message'; openSidebar = false"
                            class="flex items-center space-x-3 px-4 py-2 hover:bg-gray-100 rounded-lg transition-colors"
                            :class="{ 'bg-gray-100': activeSection === 'message' }">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span :class="{ 'block opacity-100': openSidebar || window.innerWidth >= 768, 'hidden opacity-0': !openSidebar && window.innerWidth < 768 }"
                                class="text-gray-700 transition-opacity duration-300">Envoyer un message aux volontaires</span>
                        </a>
                    </li>

                    <li>
                        <a href="logout.php" class="flex items-center space-x-3 px-4 py-2 hover:bg-gray-100 rounded-lg transition-colors"
                            :class="{ 'bg-gray-100': activeSection === 'message' }">
                            <span :class="{ 'block opacity-100': openSidebar || window.innerWidth >= 768, 'hidden opacity-0': !openSidebar && window.innerWidth < 768 }"
                                class="text-gray-700 transition-opacity duration-300">Déconnexion</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-6 overflow-y-auto">
            <!-- Mobile Menu Toggle -->
            <div class="md:hidden flex justify-between items-center mb-4">
                <h1 class="text-xl font-bold text-gray-800">Sterna Africa</h1>
                <button @click="openSidebar = !openSidebar" class="p-2 rounded-full hover:bg-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>

            <!-- Dashboard Section -->
            <div x-show="activeSection === 'dashboard'" class="space-y-6">
                <header class="flex items-center justify-between flex-wrap gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            Bienvenu, <?= htmlspecialchars($formateur['prenom'] . ' ' . $formateur['nom']) ?> !
                        </h1>
                        <p class="text-gray-600">Gérez vos tâches, interagissez et suivez les progrès.</p>
                    </div>
                    <div class="flex-shrink-0">
                        <img src="./uploads/<?= htmlspecialchars($formateur['avatar']) ?>" alt="Avatar" class="w-12 h-12 rounded-full border border-gray-300 shadow">
                    </div>
                </header>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h2 class="text-lg font-semibold text-gray-700">Total volontaires</h2>
                        <p class="text-2xl font-bold text-green-600"><?= $total_volontaires ?></p>
                    </div>

                    <!-- <div class="bg-white p-4 rounded-lg shadow-md">
                        <h2 class="text-lg font-semibold text-gray-700">Pending Orders</h2>
                        <p class="text-2xl font-bold text-yellow-600">3</p>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h2 class="text-lg font-semibold text-gray-700">Total Spent</h2>
                        <p class="text-2xl font-bold text-blue-600">$500.00</p>
                    </div> -->
                </div>
                <br>

                <h2 class="text-xl font-bold text-gray-700 mb-4">📋 Liste des volontaires inscrits</h2>

                <div class="w-full overflow-x-auto block">
                    <table class="min-w-[1000px] table-auto border border-gray-300 text-sm shadow-md">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <!-- <th class="px-4 py-2 border">Avatar</th> -->
                                <th class="px-4 py-2 border">Nom</th>
                                <th class="px-4 py-2 border">Genre</th>
                                <th class="px-4 py-2 border">Ville</th>
                                <th class="px-4 py-2 border">Profession</th>
                                <th class="px-4 py-2 border">Compétences</th>
                                <th class="px-4 py-2 border">Téléphone</th>
                                <th class="px-4 py-2 border">Sterne depuis</th>
                                <th class="px-4 py-2 border">Disponibilité</th>
                                <th class="px-4 py-2 border">Activités</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($volontaires as $v): ?>
                                <tr class="hover:bg-gray-50">
                                    <!-- <td class="px-4 py-2 border text-center">
                                        <?php
                                            // $avatar = !empty($v['avatar']) ? '../' . htmlspecialchars($v['avatar']) : '../assets/img/default-avatar.png';
                                        ?>
                                        <img src="<?= $avatar ?>" alt="Avatar" loading="lazy" class="w-10 h-10 rounded-full mx-auto object-cover border">
                                    </td> -->
                                    
                                    <td class="px-4 py-2 border">
                                        <?= htmlspecialchars(($v['nom'] ?? '') . ' ' . ($v['prenom'] ?? '')) ?>
                                    </td>
                                    
                                    <td class="px-4 py-2 border text-center"><?= htmlspecialchars((string)($v['genre'] ?? '')) ?></td>
                                    <td class="px-4 py-2 border"><?= htmlspecialchars((string)($v['ville'] ?? '')) ?></td>
                                    <td class="px-4 py-2 border"><?= htmlspecialchars((string)($v['profession'] ?? '')) ?></td>
                                    <td class="px-4 py-2 border"><?= htmlspecialchars((string)($v['competences'] ?? '')) ?></td>
                                    <td class="px-4 py-2 border text-center"><?= htmlspecialchars((string)($v['telephone'] ?? '')) ?></td>
                                    <td class="px-4 py-2 border text-center"><?= htmlspecialchars((string)($v['annee_integration'] ?? '')) ?></td>
                                    <td class="px-4 py-2 border"><?= htmlspecialchars((string)($v['disponibilite'] ?? '')) ?></td>
                                    
                                    <td class="px-4 py-2 border text-center">
                                        <span class="font-bold text-blue-600">
                                            <?php 
                                                // Utilisation de la variable $missions définie dans ton PHP
                                                $id_volontaire = $v['id'] ?? null;
                                                echo ($id_volontaire && isset($missions[$id_volontaire])) ? $missions[$id_volontaire] : 0;
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($total_volontaires > 5): ?>
                    <div class="flex justify-between items-center mt-4">
                        <button id="toggleVolontaires"
                            class="text-blue-600 hover:underline text-sm font-medium">
                            Voir plus
                        </button>

                        <a href="export_emails_volontaires.php"
                        class="text-orange-600 hover:underline text-sm font-medium">
                            Checker mails volontaires
                        </a>
                    </div>
                <?php endif; ?>

                <script>
                    let offset = 5;
                    const btn = document.getElementById('toggleVolontaires');
                    const tbody = document.querySelector('table tbody');

                    btn.addEventListener('click', () => {
                        btn.disabled = true;
                        btn.textContent = 'Chargement...';

                        fetch(`charger_volontaires.php?offset=${offset}`)
                            .then(r => r.json())
                            .then(data => {

                                if (data.volontaires.length === 0) {
                                    btn.remove();
                                    return;
                                }

                                const fragment = document.createDocumentFragment();

                                data.volontaires.forEach(v => {
                                    const tr = document.createElement('tr');
                                    tr.className = 'hover:bg-gray-50';
                                    tr.innerHTML = `
                                        <!-- <td class="px-4 py-2 border text-center">
                                            <img loading="lazy"
                                                src="../${v.avatar || 'assets/img/default-avatar.png'}"
                                                class="w-10 h-10 rounded-full mx-auto object-cover border">
                                        </td> -->
                                        <td class="px-4 py-2 border">${v.nom || ''} ${v.prenom || ''}</td>
                                        <td class="px-4 py-2 border text-center">${v.genre || '-'}</td>
                                        <td class="px-4 py-2 border">${v.ville || '-'}</td>
                                        <td class="px-4 py-2 border">${v.profession || '-'}</td>
                                        <td class="px-4 py-2 border">${v.competences || '-'}</td>
                                        <td class="px-4 py-2 border text-center">${v.telephone || '-'}</td>
                                        <td class="px-4 py-2 border text-center">${v.annee_integration || '-'}</td>
                                        <td class="px-4 py-2 border">${v.disponibilite || '-'}</td>
                                        <td class="px-4 py-2 border text-center font-bold text-blue-600">
                                            ${data.missions[v.id] || 0}
                                        </td>
                                    `;
                                    fragment.appendChild(tr);
                                });

                                tbody.appendChild(fragment);
                                offset += data.volontaires.length;

                                btn.disabled = false;
                                btn.textContent = 'Voir plus';

                                if (data.volontaires.length < 5) {
                                    btn.remove();
                                }
                            })
                            .catch(() => {
                                btn.disabled = false;
                                btn.textContent = 'Voir plus';
                            });
                    });
                </script>

                <br>
                <?php
                // Récupération des réponses + questions + infos volontaires
                $stmt = $pdo->query("
                        SELECT 
                            r.*, 
                            u.nom, u.prenom, u.avatar, u.genre, u.ville, u.profession,
                            e.question_text
                        FROM reponses_examens r
                        JOIN users u ON r.volontaire_id = u.id
                        JOIN examens e ON r.examen_id = e.id
                        ORDER BY u.nom, r.examen_id
                    ");

                $grouped = [];
                while ($row = $stmt->fetch()) {
                    $grouped[$row['volontaire_id']]['infos'] = $row;
                    $grouped[$row['volontaire_id']]['reponses'][] = $row;
                }
                ?>


                <h2 class="text-xl font-bold text-gray-700 mb-4 mt-4">✏️ Examens des volontaires – À corriger</h2>

                <div class="space-y-4">
                    <?php foreach ($grouped as $volontaire_id => $data): ?>
                        <?php $v = $data['infos']; ?>
                        <details class="bg-white shadow rounded-lg overflow-hidden">
                            <summary class="cursor-pointer px-6 py-4 bg-gray-100 hover:bg-gray-200 flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <!-- <img src="../uploads/<?= htmlspecialchars($v['avatar']) ?>" class="w-10 h-10 rounded-full object-cover border"> -->
                                    <div>
                                        <div class="text-sm font-semibold"><?= htmlspecialchars($v['nom'] . ' ' . $v['prenom']) ?></div>
                                        <div class="text-xs text-gray-500"><?= htmlspecialchars($v['ville']) ?> • <?= htmlspecialchars($v['profession']) ?></div>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500"><?= count($data['reponses']) ?> réponses</span>
                            </summary>

                            <div class="p-6 space-y-6">
                                <?php foreach ($data['reponses'] as $rep): ?>
                                    <div class="bg-gray-50 p-4 rounded-md border">
                                        <div class="text-sm font-medium mb-2 text-gray-700">
                                            <?= htmlspecialchars($rep['question_text']) ?>
                                        </div>

                                        <!-- <?php if (!empty($rep['image'])): ?>
                                            <div class="mt-2">
                                                <img src="../uploads/<?= htmlspecialchars($rep['image']) ?>" alt="Image question" class="max-w-full h-auto rounded border">
                                            </div>
                                        <?php endif; ?> -->

                                        <div class="text-sm text-gray-800 bg-white p-3 rounded border whitespace-pre-line"><?= nl2br(htmlspecialchars($rep['reponse'])) ?></div>

                                        <form id="form-rep-<?= $rep['id'] ?>" class="noter-form mt-3 space-y-2" data-rep-id="<?= $rep['id'] ?>">
                                            <input type="hidden" name="reponse_id" value="<?= $rep['id'] ?>">

                                            <label class="block text-sm font-medium text-gray-700">Note :</label>
                                            <input type="number" name="note" min="0" max="20" class="note-individuelle w-24 px-2 py-1 border rounded" value="<?= htmlspecialchars($rep['note'] ?? '') ?>">

                                            <label class="block text-sm font-medium text-gray-700">Commentaire :</label>
                                            <textarea name="commentaire" rows="2" class="w-full border rounded p-2"><?= htmlspecialchars($rep['commentaire'] ?? '') ?></textarea>

                                            <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 text-sm">Enregistrer</button>

                                            <div class="feedback mt-2 text-sm"></div>
                                        </form>

                                    </div>
                                <?php endforeach; ?>

                                <form action="noter-module.php" method="POST" class="mt-6 border-t pt-4">
                                    <input type="hidden" name="volontaire_id" value="<?= $volontaire_id ?>">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Note globale du module :</label>
                                    <input type="number" name="note" id="note-globale" min="0" max="20" class="w-24 px-2 py-1 border rounded mb-2 bg-gray-100 text-gray-700" readonly>

                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Commentaire général :</label>
                                    <textarea name="commentaire" rows="3" class="w-full border rounded p-2 mb-3"></textarea>

                                    <button type="submit" class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700 text-sm">Noter le module</button>
                                </form>
                            </div>
                        </details>
                    <?php endforeach; ?>
                </div>

                <!-- JavaScript pour le calcul automatique des notes -->
                <script>
                    function recalculerNoteGlobale() {
                        let total = 0;
                        document.querySelectorAll('.note-individuelle').forEach(input => {
                            const val = parseFloat(input.value);
                            if (!isNaN(val)) {
                                total += val;
                            }
                        });
                        document.getElementById('note-globale').value = total.toFixed(1); // par ex: 13.5
                    }

                    // Mettre à jour au chargement
                    document.addEventListener('DOMContentLoaded', recalculerNoteGlobale);

                    // Mettre à jour dès qu'une note change
                    document.querySelectorAll('.note-individuelle').forEach(input => {
                        input.addEventListener('input', recalculerNoteGlobale);
                    });
                </script>

                <!-- JavaScript pour le rechargement des notes en ajax -->
                <script>
                    document.querySelectorAll('.noter-form').forEach(form => {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault(); // Empêche le rechargement

                            const formData = new FormData(this);
                            const feedback = this.querySelector('.feedback');
                            feedback.textContent = 'Enregistrement...';
                            feedback.className = 'feedback mt-2 text-sm text-gray-500';

                            fetch('noter_reponse.php', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => response.text())
                                .then(result => {
                                    if (result.trim() === 'OK') {
                                        feedback.textContent = '✅ Note enregistrée avec succès.';
                                        feedback.className = 'feedback mt-2 text-sm text-green-600';
                                    } else {
                                        feedback.textContent = '❌ Erreur : ' + result;
                                        feedback.className = 'feedback mt-2 text-sm text-red-600';
                                    }
                                })
                                .catch(error => {
                                    feedback.textContent = '❌ Erreur AJAX.';
                                    feedback.className = 'feedback mt-2 text-sm text-red-600';
                                });
                        });
                    });
                </script>

                <!-- JavaScript pour le l'accordeon au clic -->
                <script>
                    const toggleBtn = document.getElementById('toggleVolontaires');
                    const hiddenRows = document.querySelectorAll('.extra-volontaire');
                    let expanded = false;

                    toggleBtn?.addEventListener('click', () => {
                        expanded = !expanded;
                        hiddenRows.forEach(row => row.classList.toggle('hidden'));
                        toggleBtn.textContent = expanded ? 'Réduire' : 'Afficher plus';
                    });
                </script>

            </div>

            <!-- Formations Section -->
            <div x-show="activeSection === 'orders'" class="space-y-6">

                <header class="flex justify-between items-center mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Modules de Formation</h1>
                        <p class="text-gray-600">Liste des modules créés avec leurs informations essentielles.</p>
                    </div>
                    <a href="ajouter-module" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded">
                        + Ajouter un module
                    </a>
                </header>

                <div class="bg-white p-4 rounded-lg shadow-md overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vidéo</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Exercice</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visible</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php
                            $stmt = $pdo->query("SELECT * FROM modules ORDER BY ordre ASC");

                            while ($module = $stmt->fetch()) :
                                $questionsStmt = $pdo->prepare("SELECT question_text FROM questions WHERE module_id = ? ORDER BY id ASC");
                                $questionsStmt->execute([$module['id']]);
                                $questions = $questionsStmt->fetchAll();
                            ?>
                                <!-- Ligne du module -->
                                <tr class="bg-white">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900"><?= htmlspecialchars($module['titre']) ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($module['description']) ?></td>
                                    <td class="px-4 py-3 text-sm text-blue-500">
                                        <a href="<?= htmlspecialchars($module['video_url']) ?>" target="_blank">Voir</a>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-blue-500">
                                        <?php if ($module['exercice_url']) : ?>
                                            <a href="<?= htmlspecialchars($module['exercice_url']) ?>" target="_blank">Télécharger</a>
                                        <?php else : ?>
                                            <span class="text-gray-400 italic">Aucun</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <?= $module['visible'] ? '<span class="text-green-600 font-semibold">Oui</span>' : '<span class="text-red-600 font-semibold">Non</span>' ?>
                                    </td>
                                    <td class="px-4 py-3 text-sm space-x-2">
                                        <a href="modifier_module.php?id=<?= $module['id'] ?>" class="text-indigo-600 hover:underline">Modifier</a>

                                        <a href="#" class="text-red-600 hover:underline delete-module-link" data-id="<?= $module['id'] ?>">
                                            Supprimer
                                        </a>

                                        <a href="#"
                                            class="text-gray-600 hover:text-gray-800 toggle-questions-link"
                                            data-id="<?= $module['id'] ?>">
                                            Voir les questions
                                        </a>
                                    </td>
                                </tr>

                                <!-- Contenu caché : Questions liées -->
                                <tr class="hidden question-row" data-id="<?= $module['id'] ?>">
                                    <td colspan="6" class="px-4 py-3 bg-gray-50">
                                        <div class="ml-4 animate-fade-in">
                                            <p class="font-semibold text-gray-800 mb-2">Questions liées :</p>
                                            <?php if (count($questions) > 0): ?>
                                                <ul class="list-disc list-inside space-y-1 text-gray-700">
                                                    <?php foreach ($questions as $q): ?>
                                                        <li><?= htmlspecialchars($q['question_text']) ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else: ?>
                                                <p class="text-gray-500 italic">Aucune question pour ce module.</p>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Animation CSS -->
                <style>
                    @keyframes fadeIn {
                        from {
                            opacity: 0;
                            transform: translateY(-5px);
                        }

                        to {
                            opacity: 1;
                            transform: translateY(0);
                        }
                    }

                    .animate-fade-in {
                        animation: fadeIn 0.3s ease-out;
                    }
                </style>

                <!-- JS toggle des questions -->
                <script>
                    document.querySelectorAll('.toggle-questions-link').forEach(link => {
                        link.addEventListener('click', function(e) {
                            e.preventDefault();
                            const id = this.dataset.id;
                            const row = document.querySelector(`.question-row[data-id="${id}"]`);

                            if (row) {
                                row.classList.toggle('hidden');
                                this.textContent = row.classList.contains('hidden') ? "Voir les questions" : "Masquer les questions";
                            }
                        });
                    });
                </script>


            </div>

            <!-- Reponse Formation Section -->
            <div x-show="activeSection === 'reponses'" class="space-y-6">

                <header class="flex justify-between items-center mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Réponses des Volontaires</h1>
                        <p class="text-gray-600">Accédez aux réponses envoyées par les volontaires pour chaque module.</p>
                    </div>
                </header>

                <div class="max-w-6xl mx-auto p-4 space-y-6">
                    <?php
                    require_once '../inclusion/db.php';
                    // Activer les erreurs pour le debug (décommenter si besoin)
                    // ini_set('display_errors', 1);
                    // ini_set('display_startup_errors', 1);
                    // error_reporting(E_ALL);

                    // Récupérer tous les modules
                    $modules = $pdo->query("SELECT * FROM modules ORDER BY ordre ASC")->fetchAll();

                    foreach ($modules as $module):
                        // Récupérer les réponses des utilisateurs pour les questions du module
                        $reponsesStmt = $pdo->prepare("
                                SELECT 
                                    u.id AS user_id,
                                    u.nom,
                                    u.prenom,
                                    q.question_text,
                                    r.reponse
                                FROM reponses r
                                JOIN questions q ON r.question_id = q.id
                                JOIN users u ON r.volontaire_id = u.id
                                WHERE q.module_id = ?
                                ORDER BY u.nom, q.id
                            ");
                        $reponsesStmt->execute([$module['id']]);

                        $usersData = [];

                        while ($row = $reponsesStmt->fetch(PDO::FETCH_ASSOC)) {
                            $userId = $row['user_id'];
                            $usersData[$userId]['nom'] = $row['nom'];
                            $usersData[$userId]['prenom'] = $row['prenom'];
                            $usersData[$userId]['reponses'][$row['question_text']] = $row['reponse'];
                        }
                    ?>
                        <!-- Affichage du module -->
                        <details class="mb-4 border rounded shadow">
                            <summary class="bg-gray-100 px-4 py-2 font-semibold cursor-pointer">
                                <?= htmlspecialchars($module['titre']) ?>
                            </summary>
                            <div class="p-4 space-y-4 bg-white">
                                <?php if (!empty($usersData)): ?>
                                    <?php foreach ($usersData as $user): ?>
                                        <details class="border rounded p-3">
                                            <summary class="font-medium cursor-pointer text-indigo-600">
                                                👤 <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?>
                                            </summary>
                                            <div class="mt-2 space-y-2">
                                                <?php foreach ($user['reponses'] as $question => $reponse): ?>
                                                    <div class="border p-2 rounded bg-gray-50">
                                                        <p class="text-sm text-gray-500 mb-1">❓ <?= htmlspecialchars($question) ?></p>
                                                        <p class="text-gray-800 whitespace-pre-wrap"><?= nl2br(htmlspecialchars($reponse)) ?></p>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </details>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-gray-500 italic">⚠️ Aucune réponse enregistrée pour ce module.</p>
                                <?php endif; ?>
                            </div>
                        </details>
                    <?php endforeach; ?>
                </div>



            </div>

            <!-- Examens Section -->
            <div x-show="activeSection === 'examens'" class="space-y-6">
                <!-- ✅ HEADER ET MESSAGE -->
                <header class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Créer l'examen final</h1>
                    <p class="text-gray-600">Ajoutez autant de questions que nécessaire avec ou sans QCM.</p>
                    <div id="message" class="mt-4 text-sm text-green-600 hidden"></div>
                </header>

                <!-- ✅ FORMULAIRE D'EXAMEN -->
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <form id="examForm" enctype="multipart/form-data" class="space-y-6">
                        <div id="questionsContainer" class="space-y-4">
                            <div class="question-block bg-gray-50 p-4 rounded-md border border-gray-200">
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Question</label>
                                    <input type="text" name="questions[]" class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm text-sm" placeholder="Entrez la question" required>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Type de question</label>
                                    <select name="types[]" class="type-select mt-1 block w-full px-3 py-2 border rounded-md shadow-sm text-sm" onchange="gererAffichageOptions(this)" required>
                                        <option value="texte">Réponse texte</option>
                                        <option value="qcm">QCM (choix multiples)</option>
                                    </select>
                                </div>
                                <div class="mb-3 options-block hidden">
                                    <label class="block text-sm font-medium text-gray-700">Options (séparées par un point-virgule ";")</label>
                                    <input type="text" name="options[]" class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm text-sm" placeholder="Ex: Option 1;Option 2;Option 3">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Image (facultative)</label>
                                    <input type="file" name="images[]" accept="image/*" class="mt-1 block w-full text-sm">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="button" onclick="ajouterQuestion()" class="text-green-600 hover:underline text-sm font-medium">
                                + Ajouter une autre question
                            </button>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                Enregistrer
                            </button>
                        </div>
                    </form>

                    <hr class="my-6 border-gray-300">

                    <div id="listeQuestions" class="bg-white p-4 rounded-lg shadow-md">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Questions enregistrées</h2>
                        <div id="questionsTable">
                            <!-- Les questions vont s'afficher ici en AJAX -->
                            <p class="text-gray-500">Chargement des questions...</p>
                        </div>
                    </div>

                </div>

                <!-- Modal Modification -->
                <div id="modalModification" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                    <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Modifier la question</h3>
                        <form id="formModification" class="space-y-4">
                            <input type="hidden" id="modifId" name="id">

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Question</label>
                                <input type="text" id="modifQuestion" name="question_text" class="mt-1 block w-full border px-3 py-2 rounded-md" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Type de question</label>
                                <select id="modifType" name="type_question" class="mt-1 block w-full border px-3 py-2 rounded-md" required onchange="gererAffichageModifOptions()">
                                    <option value="texte">Réponse texte</option>
                                    <option value="qcm">QCM (choix multiples)</option>
                                </select>
                            </div>

                            <div id="modifOptionsContainer" class="hidden">
                                <label class="block text-sm font-medium text-gray-700">Options (séparées par ;)</label>
                                <input type="text" id="modifOptions" name="options" class="mt-1 block w-full border px-3 py-2 rounded-md">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Image (facultative)</label>
                                <input type="file" name="image" class="block w-full text-sm">
                            </div>

                            <div class="flex justify-end gap-4 pt-2">
                                <button type="button" onclick="fermerModal()" class="px-4 py-2 text-sm bg-gray-200 rounded hover:bg-gray-300">Annuler</button>
                                <button type="submit" class="px-4 py-2 text-sm bg-green-600 text-white rounded hover:bg-green-700">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- ✅ JAVASCRIPT POUR GESTION AJAX + LOGIQUE DYNAMIQUE -->
                <script>
                    function gererAffichageOptions(selectElement) {
                        const container = selectElement.closest('.question-block');
                        const optionsBlock = container.querySelector('.options-block');
                        optionsBlock.classList.toggle('hidden', selectElement.value !== 'qcm');
                    }

                    function ajouterQuestion() {
                        const container = document.getElementById('questionsContainer');
                        const index = container.children.length;
                        const block = document.createElement('div');
                        block.className = 'question-block bg-gray-50 p-4 rounded-md border border-gray-200';
                        block.innerHTML = `
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700">Question</label>
                                <input type="text" name="questions[]" class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm text-sm" required>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700">Type de question</label>
                                <select name="types[]" class="type-select mt-1 block w-full px-3 py-2 border rounded-md shadow-sm text-sm" onchange="gererAffichageOptions(this)" required>
                                    <option value="texte">Réponse texte</option>
                                    <option value="qcm">QCM (choix multiples)</option>
                                </select>
                            </div>
                            <div class="mb-3 options-block hidden">
                                <label class="block text-sm font-medium text-gray-700">Options (séparées par un point-virgule ";")</label>
                                <input type="text" name="options[]" class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Image (facultative)</label>
                                <input type="file" name="images[]" accept="image/*" class="mt-1 block w-full text-sm">
                            </div>
                        `;
                        container.appendChild(block);
                    }

                    // Soumission Ajax
                    const form = document.getElementById('examForm');
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const formData = new FormData(form);

                        fetch('traitement_examens.php', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error("Erreur HTTP " + response.status);
                                }
                                return response.text();
                            })
                            .then(data => {
                                console.log('Réponse reçue :', data);
                                if (data.includes('ajoutée')) {
                                    const msg = document.getElementById('message');
                                    msg.textContent = data;
                                    msg.classList.remove('hidden');
                                    form.reset();
                                    const questionsContainer = document.getElementById('questionsContainer');
                                    questionsContainer.innerHTML = '';
                                    ajouterQuestion();
                                } else {
                                    throw new Error("Réponse inattendue : " + data);
                                }
                            })
                            .catch(error => {
                                console.error('Erreur AJAX :', error);
                                const msg = document.getElementById('message');
                                msg.textContent = "Une erreur est survenue.";
                                msg.classList.remove('hidden');
                            });
                    });
                </script>

                <script>
                    function chargerQuestions() {
                        fetch('charger_questions_examens.php')
                            .then(res => res.text())
                            .then(html => {
                                document.getElementById('questionsTable').innerHTML = html;
                            });
                    }

                    function supprimerQuestion(id) {
                        if (!confirm("Supprimer cette question ?")) return;

                        fetch('supprimer_question_examens.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: 'id=' + encodeURIComponent(id)
                        }).then(res => res.text()).then(response => {
                            chargerQuestions(); // Recharge la liste
                        });
                    }

                    // Charger les questions dès le chargement
                    window.addEventListener('DOMContentLoaded', chargerQuestions);
                </script>

                <script>
                    function ouvrirModal(id, question, type, options) {
                        document.getElementById('modalModification').classList.remove('hidden');
                        document.getElementById('modifId').value = id;
                        document.getElementById('modifQuestion').value = question;
                        document.getElementById('modifType').value = type;

                        if (type === 'qcm') {
                            document.getElementById('modifOptionsContainer').classList.remove('hidden');
                            document.getElementById('modifOptions').value = options;
                        } else {
                            document.getElementById('modifOptionsContainer').classList.add('hidden');
                            document.getElementById('modifOptions').value = '';
                        }
                    }

                    function fermerModal() {
                        document.getElementById('modalModification').classList.add('hidden');
                        document.getElementById('formModification').reset();
                    }

                    function gererAffichageModifOptions() {
                        const type = document.getElementById('modifType').value;
                        const optionsDiv = document.getElementById('modifOptionsContainer');
                        if (type === 'qcm') {
                            optionsDiv.classList.remove('hidden');
                        } else {
                            optionsDiv.classList.add('hidden');
                        }
                    }

                    document.getElementById('formModification').addEventListener('submit', function(e) {
                        e.preventDefault();
                        const formData = new FormData(this);

                        fetch('modifier_question_examens.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(res => res.text())
                            .then(response => {
                                fermerModal();
                                chargerQuestions(); // Recharge la liste des questions
                            });
                    });
                </script>


            </div>

            <!-- Alpine component -->
            <div x-data="messageForm()" class="space-y-6">
                <header>
                    <h1 class="text-2xl font-bold text-gray-800">Envoyer un message aux volontaires</h1>
                    <p class="text-gray-600">Ce message sera visible par tous les volontaires dans leur tableau de bord.</p>
                </header>

                <!-- Message de succès -->
                <div x-show="successMsg" x-text="successMsg"
                    class="mb-4 p-3 rounded bg-green-100 text-green-700 border border-green-300"
                    x-transition></div>

                <!-- Formulaire -->
                <form @submit="submitForm" class="bg-white p-4 rounded-lg shadow-md space-y-4">
                    <div>
                        <label for="titre" class="block text-sm font-medium text-gray-700">Titre du message</label>
                        <input type="text" name="titre" id="titre" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            placeholder="Ex. : Annonce importante">
                    </div>
                    <div>
                        <label for="contenu" class="block text-sm font-medium text-gray-700">Contenu</label>
                        <textarea name="contenu" id="contenu" rows="5" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                            placeholder="Rédigez ici votre message..."></textarea>
                    </div>
                    <button type="submit"
                        class="w-full sm:w-auto inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Envoyer à tous les volontaires
                    </button>
                </form>
            </div>

            <!-- Alpine logic -->
            <script>
                function messageForm() {
                    return {
                        successMsg: '',
                        async submitForm(e) {
                            e.preventDefault();
                            const form = e.target;
                            const formData = new FormData(form);

                            const response = await fetch('envoyer_message.php', {
                                method: 'POST',
                                body: formData
                            });

                            const result = await response.json();

                            if (response.ok && result.success) {
                                form.reset();
                                this.successMsg = "Message envoyé avec succès !";
                                setTimeout(() => this.successMsg = '', 4000);
                            } else {
                                alert(result.error || "Erreur lors de l’envoi.");
                            }
                        }
                    };
                }
            </script>


        </main>
    </div>

    <script>
        document.querySelectorAll('.delete-module-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                const id = this.dataset.id;
                const confirmed = confirm("Supprimer ce module ?");

                if (!confirmed) return;

                fetch('supprimer_module.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'id=' + encodeURIComponent(id)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Supprimer visuellement l'élément parent (par ex. ligne de tableau)
                            this.closest('tr')?.remove(); // ou adapte selon ton HTML
                            alert("Module supprimé avec succès.");
                        } else {
                            alert("Erreur lors de la suppression.");
                        }
                    })
                    .catch(error => {
                        console.error('Erreur AJAX :', error);
                        alert("Erreur réseau ou serveur.");
                    });
            });
        });
    </script>
</body>

</html>