<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['admin_quiz_id'])) {
    header("Location: login");
    exit;
}

require_once __DIR__ . '/../config/db.php'; // chemin absolu sécurisé

// Récupérer le nom de l'admin connecté
$admin_id = $_SESSION['admin_quiz_id'];
$sql_admin = "SELECT nom FROM admin_quiz WHERE id = ?";
$stmt = $conn->prepare($sql_admin);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result_admin = $stmt->get_result();
$admin = $result_admin->fetch_assoc();
$admin_name = $admin['nom'] ?? 'Nom inconnu'; // Nom de l'admin, ou 'Nom inconnu' si aucune correspondance

// Récupérer les données pour les catégories, questions et utilisateurs
// Récupérer toutes les catégories depuis la table
// Requête pour récupérer seulement les 3 premières catégories
$sql_categories = "SELECT id, nom, description FROM categorie_quiz ORDER BY id DESC LIMIT 4";
$result_categories = $conn->query($sql_categories);

// Récupérer toutes les questions avec leur catégorie ainsi que leurs réponses
// Limiter à 5 questions par défaut
$sql_questions = "
    SELECT q.id AS question_id, q.question, c.nom AS categorie
    FROM question_quiz q
    LEFT JOIN categorie_quiz c ON q.categorie_id = c.id
    ORDER BY q.id DESC
    LIMIT 3
";
$questions = $conn->query($sql_questions);

// Requête pour récupérer le nombre total de catégories
$sql_count_categories = "SELECT COUNT(*) AS total FROM categorie_quiz";
$res_categories = $conn->query($sql_count_categories);
$total_categories = $res_categories->fetch_assoc()['total'] ?? 0;
$categorie_count = $total_categories;

// Récupérer le nombre de questions
$sql_count_questions = "SELECT COUNT(*) AS total FROM question_quiz";
$res_questions = $conn->query($sql_count_questions);
$question_count = $res_questions->fetch_assoc()['total'] ?? 0;

// Récupérer le nombre total d'utilisateurs (admin + participant + animateur)
$sql_total_users = "
    SELECT 
        (SELECT COUNT(*) FROM admin_quiz) +
        (SELECT COUNT(*) FROM participants) +
        (SELECT COUNT(*) FROM quiz_sessions) AS total_users
";
$res_users = $conn->query($sql_total_users);
$total_users = $res_users->fetch_assoc()['total_users'] ?? 0;

// Requête pour calculer la moyenne des scores des participants
$sql_average_score = "SELECT AVG(score_total) AS average_score FROM scores_participants";
$result_average_score = $conn->query($sql_average_score);

// Récupérer la moyenne des scores
$average_score = 0;
if ($result_average_score && $row = $result_average_score->fetch_assoc()) {
    $average_score = round($row['average_score'], 2); // Arrondir à 2 décimales
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Favicons -->
    <link href="https://sternaafrica.org/assets/img/icon-192.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/icon-192.png" rel="apple-touch-icon">
</head>

<body class="bg-stone-950 text-white font-sans">

    <!-- Page Dashboard -->
    <div class="max-w-7xl mx-auto px-4 sm:px-2 lg:px-2 py-4">

        <!-- Navigation Dashboard -->
        <nav class="bg-gray-800 p-4 rounded-lg shadow-lg mb-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-headset text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold">Admin</span>
                </div>
                <div>
                    <button class="bg-gray-700 text-white px-4 py-2 rounded-lg" onclick="window.location.href = 'logout.php';">
                        <i class="fas fa-sign-out-alt"></i> Se déconnecter
                    </button>
                </div>
            </div>
        </nav>

        <!-- En-tête Dashboard -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2"><?php echo htmlspecialchars($admin_name); ?> | Dash</h1>
            <p class="text-gray-400">Gérer les questionnaires et les réponses du quiz.</p>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Catégories -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                <div class="flex justify-between">
                    <p class="text-gray-400">Catégories</p>
                    <p class="text-2xl font-bold text-white"><?= $categorie_count ?></p>
                </div>
                <i class="fas fa-folder text-purple-500 text-3xl mt-4"></i>
            </div>

            <!-- Questions -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                <div class="flex justify-between">
                    <p class="text-gray-400">Questions</p>
                    <p class="text-2xl font-bold text-white"><?= $question_count ?></p>
                </div>
                <i class="fas fa-question-circle text-blue-500 text-3xl mt-4"></i>
            </div>

            <!-- Utilisateurs -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                <div class="flex justify-between">
                    <p class="text-gray-400">Utilisateurs</p>
                    <p class="text-2xl font-bold text-white"><?= $total_users ?></p>
                </div>
                <i class="fas fa-users text-green-500 text-3xl mt-4"></i>
            </div>

            <!-- Performance -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                <div class="flex justify-between">
                    <p class="text-gray-400">Performance des Quiz</p>
                    <p class="text-2xl font-bold text-white"><?= $average_score ?>%</p> <!-- Moyenne des scores -->
                </div>
                <i class="fas fa-chart-line text-yellow-500 text-3xl mt-4"></i>
            </div>

        </div>

        <!-- Liste des Catégories -->
        <div class="bg-gray-800 p-2 rounded-lg shadow-lg mb-8">
            <div class="flex justify-between items-center mb-6" id="categorie">
                <h2 class="text-xl font-bold text-white">Catégories</h2>
                <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg" onclick="window.location.href = 'ajouter-categorie';">
                    <i class="fas fa-plus"></i> Ajouter
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php if ($result_categories && $result_categories->num_rows > 0): ?>
                    <?php while ($row = $result_categories->fetch_assoc()): ?>
                        <div class="bg-gray-700 p-4 rounded-xl">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-semibold text-white"><?= htmlspecialchars($row['nom']); ?></h3>
                                <div class="flex space-x-2">
                                    <button class="text-blue-400 hover:text-blue-300" onclick="window.location.href='edit_category.php?id=<?= $row['id']; ?>'">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-400 hover:text-red-300" onclick="if(confirm('Supprimer cette catégorie ?')) window.location.href='delete_category.php?id=<?= $row['id']; ?>'">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <p class="text-gray-400 text-sm mb-3">
                                <?= htmlspecialchars($row['description']); ?>
                            </p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-gray-400">Aucune catégorie enregistrée pour le moment.</p>
                <?php endif; ?>
            </div>
            <div id="moreCategories" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4"></div>


            <?php if ($total_categories > 4): ?>
                <div class="text-start mt-2">
                    <button id="loadMoreCategories" class="text-cyan-600 hover:text-cyan-700">Afficher plus</button>
                </div>
            <?php endif; ?>
        </div>

        <script>
            const loadBtn = document.getElementById('loadMoreCategories');
            const container = document.getElementById('moreCategories');

            let categoriesLoaded = false;

            loadBtn.addEventListener('click', function() {
                if (!categoriesLoaded) {
                    // Charger les catégories supplémentaires
                    fetch('load_more_categories.php')
                        .then(response => response.json())
                        .then(data => {
                            container.innerHTML = ''; // vider au cas où

                            data.forEach(cat => {
                                const div = document.createElement('div');
                                div.classList.add('bg-gray-700', 'p-4', 'rounded-xl');
                                div.innerHTML = `
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-semibold text-white">${cat.nom}</h3>
                            <div class="flex space-x-2">
                                <button class="text-blue-400 hover:text-blue-300"
                                    onclick="window.location.href='edit_category.php?id=${cat.id}'">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-400 hover:text-red-300"
                                    onclick="if(confirm('Supprimer cette catégorie ?')) window.location.href='delete_category.php?id=${cat.id}'">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <p class="text-gray-400 text-sm mb-3">${cat.description}</p>
                    `;
                                container.appendChild(div);
                            });

                            loadBtn.textContent = 'Voir moins'; // changer le texte
                            categoriesLoaded = true;
                        });
                } else {
                    // Cacher les catégories supplémentaires
                    container.innerHTML = '';
                    loadBtn.textContent = 'Afficher plus';
                    categoriesLoaded = false;
                }
            });
        </script>

        <?php if ($question_count > 3): ?>
            <div class="mt-8 mb-8 max-w-md">
                <button onclick="openModal()"
                    class="w-full group flex items-center justify-between bg-stone-900/50 border border-white/10 hover:border-purple-500/50 p-1.5 rounded-2xl transition-all duration-300 shadow-xl backdrop-blur-sm">

                    <div class="flex items-center gap-3 pl-3">
                        <div class="w-10 h-10 bg-purple-600/20 rounded-xl flex items-center justify-center group-hover:bg-purple-600/30 transition-colors">
                            <i class="fas fa-search text-purple-400"></i>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-bold text-white">Rechercher une question</p>
                            <p class="text-[10px] text-gray-500 uppercase tracking-widest">Modifier ou Supprimer</p>
                        </div>
                    </div>

                    <div class="pr-3 text-gray-600 group-hover:text-purple-400 transition-colors">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </div>
                </button>
            </div>
        <?php endif; ?>


        <!-- Questions récentes -->
        <div class="bg-gray-800 p-2 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-6" id="question">
                <h2 class="text-xl font-bold text-white">Questions récentes</h2>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg" onclick="window.location.href = 'ajouter-question-reponse';">
                    <i class="fas fa-plus"></i> Ajouter
                </button>
            </div>

            <div class="space-y-4">
                <?php if ($questions && $questions->num_rows > 0): ?>
                    <?php while ($q = $questions->fetch_assoc()): ?>
                        <?php
                        // Récupérer les bonnes réponses
                        $stmt = $conn->prepare("SELECT reponse FROM reponse_quiz WHERE question_id = ? AND correcte = 1");
                        $stmt->bind_param("i", $q['question_id']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $bonnes_reponses = [];
                        while ($r = $result->fetch_assoc()) {
                            $bonnes_reponses[] = $r['reponse'];
                        }
                        ?>
                        <div class="bg-gray-700 p-4 rounded-xl">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-semibold text-white">
                                        <?= stripslashes(htmlspecialchars_decode($q['question'])) ?>
                                    </h3>
                                    <p class="text-gray-400 text-sm">
                                        Catégorie : <?= htmlspecialchars($q['categorie']) ?>
                                    </p>
                                </div>

                                <div class="flex space-x-2">
                                    <button class="text-blue-400 hover:text-blue-300"
                                        onclick="window.location.href='edit-question?id=<?= $q['question_id']; ?>'">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-400 hover:text-red-300"
                                        onclick="if(confirm('Supprimer cette question ?')) window.location.href='delete-question?id=<?= $q['question_id']; ?>'">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <?php if (!empty($bonnes_reponses)): ?>
                                <div class="mt-2">
                                    <?php foreach ($bonnes_reponses as $i => $rep): ?>
                                        <p class="text-green-400 text-md">
                                            Bonne réponse <?= $i + 1 ?> :
                                            <?= stripslashes(htmlspecialchars_decode($rep)) ?>
                                        </p>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-red-400 text-sm mt-2">Aucune bonne réponse définie</p>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-gray-400">Aucune question enregistrée pour le moment.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Modale pour afficher plus de questions -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        </div>

        <div id="questionModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="closeModal()"></div>

            <div class="relative bg-stone-900 border border-white/10 p-6 rounded-2xl w-full max-w-md shadow-2xl">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Chercher</h2>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <input type="text" id="searchQuestion"
                    class="rounded-xl border-none ring-1 ring-white/10 p-3 mb-4 w-full bg-stone-800 focus:ring-2 focus:ring-blue-500 transition-all text-white"
                    placeholder="Tapez votre recherche..."
                    oninput="loadQuestions()">

                <div id="searchResults" class="space-y-2 max-h-[50vh] overflow-y-auto pr-2 custom-scrollbar">
                </div>

                <div class="mt-6">
                    <button class="w-full bg-stone-800 hover:bg-stone-700 text-white py-3 rounded-xl font-semibold transition-colors" onclick="closeModal()">
                        Fermer
                    </button>
                </div>
            </div>
        </div>

        <div id="questionContainer" class="hidden fixed inset-0 z-[70] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/90 backdrop-blur-md" onclick="closeQuestionContainer()"></div>

            <div class="relative bg-stone-800 rounded-2xl p-6 w-full max-w-sm text-center shadow-2xl border border-white/10">
                <div class="w-16 h-16 bg-blue-600/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-edit text-blue-500 text-2xl"></i>
                </div>

                <h3 id="selectedQuestionText" class="text-lg font-medium text-white mb-6 px-2"></h3>

                <div class="grid grid-cols-2 gap-3">
                    <button id="editButton"
                        class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-bold transition-transform active:scale-95">
                        <i class="fas fa-pen text-xs"></i> Éditer
                    </button>
                    <button id="deleteButton"
                        class="flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-bold transition-transform active:scale-95">
                        <i class="fas fa-trash text-xs"></i> Supprimer
                    </button>
                </div>

                <button class="mt-6 text-gray-500 hover:text-gray-300 text-xs uppercase tracking-widest font-bold" onclick="closeQuestionContainer()">
                    Annuler
                </button>
            </div>
        </div>

        <script>
            let searchTimeout;

            // 1. Fonction pour ouvrir la fenêtre modale
            function openModal() {
                const modal = document.getElementById('questionModal');
                if (modal) {
                    modal.classList.remove('hidden');
                    loadQuestions();
                }
            }

            // 2. Fonction pour fermer la fenêtre modale
            function closeModal() {
                const modal = document.getElementById('questionModal');
                if (modal) modal.classList.add('hidden');
            }

            // 3. Charger les questions avec sécurité anti-caractères spéciaux
            function loadQuestions() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const searchInput = document.getElementById('searchQuestion').value;
                    const searchResults = document.getElementById('searchResults');

                    fetch('search_questions.php?q=' + encodeURIComponent(searchInput))
                        .then(response => response.json())
                        .then(data => {
                            searchResults.innerHTML = '';
                            data.forEach(question => {
                                let div = document.createElement('div');
                                div.className = 'p-3 bg-stone-800 rounded-xl mb-2 border border-white/5 hover:border-purple-500/50 transition-all';

                                // Sécurisation : on échappe les guillemets pour l'attribut HTML
                                const safeQuestion = question.question.replace(/"/g, '&quot;');

                                div.innerHTML = `
                            <div class="flex justify-between items-center gap-4">
                                <p class="text-sm text-gray-200"><strong>Question:</strong> ${question.question}</p>
                                <button class="flex-shrink-0 bg-green-700 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors shadow-lg"
                                        onclick="handleSelection(this)"
                                        data-id="${question.id}"
                                        data-text="${safeQuestion}">
                                    Sélectionner
                                </button>
                            </div>
                        `;
                                searchResults.appendChild(div);
                            });
                        })
                        .catch(err => console.error("Erreur de chargement :", err));
                }, 300);
            }

            // 4. Gestionnaire de sélection robuste (récupère les données depuis l'élément)
            function handleSelection(button) {
                const id = button.getAttribute('data-id');
                const questionText = button.getAttribute('data-text');

                // On appelle la fonction de remplissage de la modale de sélection
                selectQuestion(id, questionText);
            }

            // 5. Remplir la modale de sélection / édition
            function selectQuestion(id, question) {
                const container = document.getElementById('questionContainer');
                const questionDisplay = document.getElementById('selectedQuestionText');
                const editBtn = document.getElementById('editButton');
                const deleteBtn = document.getElementById('deleteButton');

                if (!container) return;

                // On remplit le texte (textContent est plus sûr que innerHTML ici)
                questionDisplay.textContent = question;

                // Mise à jour des liens des boutons
                editBtn.onclick = () => window.location.href = 'edit-question?id=' + id;
                deleteBtn.onclick = () => {
                    if (confirm('Voulez-vous vraiment supprimer cette question ?')) {
                        window.location.href = 'delete-question?id=' + id;
                    }
                };

                // Afficher la modale de confirmation d'action
                container.classList.remove('hidden');
            }

            // 6. Fermer le conteneur de sélection
            function closeQuestionContainer() {
                const container = document.getElementById('questionContainer');
                if (container) container.classList.add('hidden');
            }
        </script>

    </div>

    <!-- Fenêtre modale pour afficher la question sélectionnée -->
    <div id="questionContainer"
        class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 backdrop-blur-sm z-50">
        <div class="bg-stone-800 rounded-xl p-6 w-96 text-center shadow-2xl">
            <h3 id="selectedQuestionText" class="text-lg font-semibold text-white mb-4"></h3>

            <div class="flex justify-center space-x-4">
                <button id="editButton"
                    class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg">
                    ✏️ Éditer
                </button>
                <button id="deleteButton"
                    class="bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-lg">
                    🗑️ Supprimer
                </button>
            </div>

            <button class="mt-6 text-gray-400 hover:text-gray-200 text-sm" onclick="closeQuestionContainer()">
                Fermer
            </button>
        </div>
    </div>


</body>

</html>