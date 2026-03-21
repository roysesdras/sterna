<?php
session_start();
require_once './inclusion/db.php';

// Redirection si non connecté
if (!isset($_SESSION['google_id'])) {
    header("Location: connect");
    exit;
}

// Récupération de l'utilisateur connecté
$stmt = $pdo->prepare("SELECT * FROM users WHERE google_id = ?");
$stmt->execute([$_SESSION['google_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Utilisateur non trouvé.");
}

// Vérification si le profil est complet (tous les champs)
$requiredFields = [
    'google_id',
    'email',
    'avatar',
    'nom',
    'prenom',
    'date_naissance',
    'annee_integration',
    'genre',
    'telephone',
    'ville',
    'profession',
    'competences',
    'disponibilite',
    'motivation',
    'role'
];

foreach ($requiredFields as $field) {
    if (empty($user[$field])) {
        // Si un champ est vide, redirige vers la page de complétion du profil
        header("Location: complet-profile");
        exit;
    }
}

// On stocke l'ID pour l'utiliser ailleurs dans la session
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_nom'] = $user['nom']; //. ' ' . $user['nom'];

$volontaireId = $user['id'];

// Après authentification
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_role'] = $user['role']; // très important

// Connexion à la base africa_db (témoignages et missions)
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

// Nombre de missions accomplies
$stmt = $pdoAfrica->prepare("
    SELECT COUNT(DISTINCT mission_id) AS total
    FROM temoignages
    WHERE is_volontaire = 1 AND volontaire_id = ?
");
$stmt->execute([$volontaireId]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$missionsAccomplies = $row ? (int)$row['total'] : 0;

// Pourcentage de progression
$progression = min(100, $missionsAccomplies * 10);

// Récupération des missions où ce volontaire a témoigné
$stmt = $pdoAfrica->prepare("
    SELECT m.*
    FROM missions m
    INNER JOIN temoignages t ON t.mission_id = m.id
    WHERE t.volontaire_id = ? AND t.is_volontaire = 1
    GROUP BY m.id
    ORDER BY m.start_date DESC
");
$stmt->execute([$volontaireId]);
$missions = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Préparer les messages non lus
$messages_stmt = $pdo->prepare("
    SELECT m.* 
    FROM messages_globaux m
    LEFT JOIN messages_lus ml 
        ON ml.message_id = m.id AND ml.volontaire_id = :volontaire_id
    WHERE ml.id IS NULL
    ORDER BY m.date_envoi DESC
");
$messages_stmt->execute(['volontaire_id' => $volontaireId]);
$messages_non_lus = $messages_stmt->fetchAll(PDO::FETCH_ASSOC);

$all_messages_stmt = $pdo->query("SELECT * FROM messages_globaux ORDER BY date_envoi DESC");
$messages = $all_messages_stmt->fetchAll(PDO::FETCH_ASSOC);


// Récupérer toutes les catégories existantes
$categories = [];
$query = $pdo->query("SELECT id, nom FROM categories ORDER BY nom ASC");
if ($query) {
    $categories = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($user['nom']); ?> | Volontaire - Sterna Africa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://sternaafrica.org/assets/img/favicon.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Canonical URL (pour le SEO) -->
    <link rel="canonical" href="https://monespacevolontaire.sternaafrica.org/" />
    <!-- (Note : Ceci est une balise `<link>`, pas `<meta>`, mais souvent associée) -->

    <!-- Open Graph (Facebook, LinkedIn) -->
    <meta property="og:url" content="https://monespacevolontaire.sternaafrica.org/" />
    <meta property="og:image" content="https://i.postimg.cc/dVVWkdSh/volonyaire.png" />

    <!-- Twitter Cards -->
    <meta name="twitter:url" content="https://monespacevolontaire.sternaafrica.org/" />
    <meta name="twitter:image" content="https://i.postimg.cc/dVVWkdSh/volonyaire.png" />

    <!-- Favicons -->
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="icon">
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="apple-touch-icon">

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sterna: {
                            primary: '#0A3D62',
                            secondary: '#FF6F00',
                            dark: '#1A3A4F',
                            light: '#E8F4F8',
                        }
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>

<body class="bg-sterna-light font-sans">
    <!-- Header avec menu mobile -->
    <header class="bg-sterna-primary text-white shadow-md relative">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="https://i.postimg.cc/mD1YfCSq/logos-sterna.png" alt="Logo Sterna" class="h-10">
                <h1 class="text-xl font-bold">Sterna<span class="text-sterna-secondary">Volontaires</span></h1>
            </div>

            <!-- Bouton menu mobile -->
            <button id="menu-toggle" class="lg:hidden focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- Navigation desktop -->
            <nav class="hidden lg:block">
                <ul class="flex space-x-6">
                    <li>
                        <a href="/" class="hover:text-sterna-secondary transition">Accueil</a>
                    </li>

                    <!-- Alpine.js bloc -->
                    <div x-data="{ openMessageModal: false, hasUnreadMessages: <?= count($messages_non_lus) > 0 ? 'true' : 'false' ?> }">
                        <!-- Lien vers le modal -->
                        <li class="relative">
                            <a href="#"
                                @click.prevent="
                                openMessageModal = true;
                                hasUnreadMessages = false; // Cache le point rouge immédiatement
                                fetch('marquer_messages_lus.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                    body: ''
                                });
                            "
                                class="hover:text-sterna-secondary transition">
                                Message
                            </a>

                            <!-- Point rouge -->
                            <span x-show="hasUnreadMessages"
                                x-transition
                                class="absolute -top-1 -right-2 w-2 h-2 bg-red-600 rounded-full"></span>
                        </li>

                        <!-- Modal -->
                        <!-- <div
                            x-show="openMessageModal"
                            x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                            <div class="bg-white max-w-lg w-full p-6 rounded-xl shadow-lg overflow-y-auto max-h-[90vh]">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-bold text-gray-800">Messages reçus</h2>
                                    <button @click="openMessageModal = false" class="text-gray-500 hover:text-red-500 text-xl">&times;</button>
                                </div>

                                <?php foreach ($messages as $message): ?>
                                    <div class="mb-4 border-b pb-4">
                                        <h3 class="font-semibold text-blue-700 text-lg"><?= htmlspecialchars($message['titre']) ?></h3>
                                        <p class="text-gray-700 mt-2"><?= nl2br(htmlspecialchars($message['contenu'])) ?></p>
                                        <p class="text-sm text-gray-400 mt-1"><?= date('d/m/Y H:i', strtotime($message['date_envoi'])) ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div> -->
                    </div>

                    <li>
                        <a href="examens" class="hover:text-sterna-secondary transition">Examens</a>
                    </li>
                    <li>
                        <a href="formation" class="hover:text-sterna-secondary transition">Formations</a>
                    </li>
                    <li>
                        <a href="#" onclick="document.getElementById('profileModal').classList.remove('hidden')" class="hover:text-sterna-secondary transition">Mon Profil</a>
                    </li>
                    <li>
                        <a href="logout.php" class="hover:text-sterna-secondary transition">Déconnexion</a>
                    </li>
                </ul>
            </nav>
        </div>

        <div id="profileModal" class="fixed inset-0 bg-black bg-opacity-70 z-50 flex items-center justify-center hidden">
            <div class="bg-gray-800 text-white w-full max-w-xl max-h-[95vh] overflow-y-auto rounded-2xl shadow-lg p-4 relative">
                <!-- Bouton de fermeture -->
                <button onclick="document.getElementById('profileModal').classList.add('hidden')" class="absolute top-4 right-4 text-white text-2xl">&times;</button>

                <h2 class="text-2xl font-bold mb-6 text-center">Modifier mon profil</h2>
                <form id="updateProfileForm" method="POST" enctype="multipart/form-data" action="./update_profile.php" class="space-y-5">

                    <!-- Avatar -->
                    <div>
                        <label for="avatar" class="block mb-2 font-medium">Photo / Avatar</label>

                        <?php if (!empty($user['avatar'])): ?>
                            <div class="mb-3">
                                <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar actuel"
                                    class="w-24 h-24 rounded-full object-cover border border-gray-500">
                            </div>
                        <?php endif; ?>

                        <input type="file" name="avatar" id="avatar"
                            class="block w-full text-sm text-gray-300 bg-gray-700 border border-gray-600 rounded-lg cursor-pointer">
                    </div>

                    <!-- Nom -->
                    <div>
                        <label for="nom" class="block mb-2 font-medium">Prénoms</label>
                        <input type="text" name="nom" id="nom"
                            value="<?= htmlspecialchars($user['nom']) ?>"
                            class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white">
                    </div>

                    <!-- Prénom -->
                    <div>
                        <label for="prenom" class="block mb-2 font-medium">Nom</label>
                        <input type="text" name="prenom" id="prenom"
                            value="<?= htmlspecialchars($user['prenom']) ?>"
                            class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white" required>
                    </div>

                    <!-- Date de naissance -->
                    <div>
                        <label for="date_naissance" class="block mb-2 font-medium">Date de naissance</label>
                        <input type="date" name="date_naissance" id="date_naissance"
                            value="<?= htmlspecialchars($user['date_naissance']) ?>"
                            class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white" required>
                    </div>

                    <!-- Email (non modifiable) -->
                    <div>
                        <label class="block mb-2 font-medium">Email</label>
                        <input type="text" value="<?= htmlspecialchars($user['email']) ?>" disabled
                            class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-gray-400 cursor-not-allowed" required>
                    </div>

                    <!-- Genre -->
                    <div>
                        <label class="block mb-2 font-medium">Genre</label>
                        <input type="text" value="<?= htmlspecialchars($user['genre']) ?>" disabled
                            class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-gray-400 cursor-not-allowed" required>
                    </div>

                    <!-- Numero WhatsApp -->
                    <div>
                        <label for="telephone" class="block mb-2 font-medium">Numéro WhatsApp</label>
                        <input type="tel"
                            name="telephone"
                            id="telephone"
                            value="<?= htmlspecialchars($user['telephone']) ?>"
                            maxlength="15"
                            pattern="^\+\d{1,3}\s?\d{6,12}$"
                            placeholder="+225 0700000000"
                            required
                            class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:ring-2 focus:ring-blue-500"
                            oninput="formatPhoneNumber(this)">
                        <p class="text-sm text-gray-400 mt-1">Format attendu : <code>+225 0700000000</code> (préfixe obligatoire, 15 caractères max)</p>
                    </div>

                    <!-- Année d'adhésion -->
                    <div>
                        <label class="block mb-2 font-medium">Année d'adhésion</label>
                        <input type="text" value="<?= htmlspecialchars($user['annee_integration']) ?>" disabled
                            class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-gray-400 cursor-not-allowed" required>
                    </div>

                    <!-- Ville -->
                    <div>
                        <label for="ville" class="block mb-2 font-medium">Ville</label>
                        <input type="text" name="ville" id="ville"
                            value="<?= htmlspecialchars($user['ville']) ?>"
                            class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white" required>
                    </div>

                    <!-- Profession -->
                    <div>
                        <label for="profession" class="block mb-2 font-medium">Profession</label>
                        <input type="text" name="profession" id="profession"
                            value="<?= htmlspecialchars($user['profession']) ?>"
                            class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white" required>
                    </div>

                    <!-- Compétences -->
                    <div>
                        <label for="competences" class="block mb-2 font-medium">Compétences</label>
                        <input type="text" name="competences" id="competences"
                            value="<?= htmlspecialchars($user['competences']) ?>"
                            class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white" required>
                    </div>

                    <!-- Disponibilité -->
                    <div>
                        <label for="disponibilite" class="block mb-2 font-medium">Disponibilité</label>
                        <select name="disponibilite" id="disponibilite"
                            class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white">
                            <option value="Plein temps" <?= $user['disponibilite'] == 'Plein temps' ? 'selected' : '' ?>>Plein temps</option>
                            <option value="Temps partiel" <?= $user['disponibilite'] == 'Temps partiel' ? 'selected' : '' ?>>Temps partiel</option>
                            <option value="Week-ends uniquement" <?= $user['disponibilite'] == 'Week-ends uniquement' ? 'selected' : '' ?>>Week-ends uniquement</option>
                            <option value="Occasionnel" <?= $user['disponibilite'] == 'Occasionnel' ? 'selected' : '' ?>>Occasionnel</option>
                        </select>
                    </div>

                    <!-- Motivation -->
                    <div>
                        <label for="motivation" class="block mb-2 font-medium">Motivation</label>
                        <textarea name="motivation" id="motivation" rows="4" required
                            class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white"><?= htmlspecialchars($user['motivation']) ?></textarea>
                    </div>

                    <!-- Bouton -->
                    <div class="text-center pt-4">
                        <button type="submit"
                            class="px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 transition text-white font-semibold">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Menu mobile (caché par défaut) -->
        <div id="mobile-menu" class="lg:hidden hidden fixed inset-y-0 right-0 w-50 bg-sterna-dark z-50 transform translate-x-full transition-transform duration-300 ease-in-out">
            <div class="flex justify-end p-4">
                <button id="menu-close" class="text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <nav class="px-6 py-4">
                <ul class="space-y-4">
                    <li><a href="/" class="block text-white hover:text-sterna-secondary transition">Accueil</a></li>

                    <!-- Alpine.js bloc -->
                    <div x-data="{ openMessageModal: false, hasUnreadMessages: <?= count($messages_non_lus) > 0 ? 'true' : 'false' ?> }">
                        <!-- Lien vers le modal -->
                        <li class="relative">
                            <a href="#"
                                @click.prevent="
                                openMessageModal = true;
                                hasUnreadMessages = false; // Cache le point rouge immédiatement
                                fetch('marquer_messages_lus.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                    body: ''
                                });
                            "
                                class="hover:text-sterna-secondary transition">
                                Message
                            </a>

                            <!-- Point rouge -->
                            <span x-show="hasUnreadMessages"
                                x-transition
                                class="absolute -top-1 -right-2 w-2 h-2 bg-red-600 rounded-full"></span>
                        </li>

                        <!-- Modal -->
                        <div
                            x-show="openMessageModal"
                            x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                            <div class="bg-white max-w-lg w-full p-6 rounded-xl shadow-lg overflow-y-auto max-h-[90vh]">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-bold text-gray-800">Messages reçus</h2>
                                    <button @click="openMessageModal = false" class="text-gray-500 hover:text-red-500 text-xl">&times;</button>
                                </div>

                                <?php foreach ($messages as $message): ?>
                                    <div class="mb-4 border-b pb-4">
                                        <h3 class="font-semibold text-blue-700 text-lg"><?= htmlspecialchars($message['titre']) ?></h3>
                                        <p class="text-gray-700 mt-2"><?= nl2br(htmlspecialchars($message['contenu'])) ?></p>
                                        <p class="text-sm text-gray-400 mt-1"><?= date('d/m/Y H:i', strtotime($message['date_envoi'])) ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <li><a href="examens" class="block text-white hover:text-sterna-secondary transition">Examens</a></li>
                    <li><a href="formation" class="block text-white hover:text-sterna-secondary transition">Formations</a></li>

                    <li><a href="#" onclick="document.getElementById('profileModal').classList.remove('hidden')" class="hover:text-sterna-secondary transition">Mon Profil</a>
                    </li>
                    <li class="pt-4 border-t border-gray-700">
                        <a href="logout.php" class="block text-sterna-secondary">Déconnexion</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Overlay pour menu mobile -->
    <div id="menu-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40"></div>

    <!-- Dashboard -->
    <main class="container mx-auto px-2 py-2">
        <!-- Version mobile : Profil en haut -->
        <div class="lg:hidden bg-white rounded-lg shadow-md p-1 mb-6">
            <div class="flex items-center space-x-4">
                <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar actuel"
                    class="rounded-full h-16 w-16">
                <div>
                    <h2 class=""><?= htmlspecialchars($user['nom'] . ' ' . $user['prenom']) ?> (<?= htmlspecialchars($user['profession']) ?>)</h2>
                    <p class="text-sterna-dark text-sm">Volontaire depuis <strong><?= htmlspecialchars($user['annee_integration']) ?></strong></p>
                    <div class="flex flex-wrap gap-1">
                        <?php
                        $tags = explode(',', $user['competences']);
                        foreach ($tags as $tag) {
                            echo '<span class="bg-orange-200 px-3 py-1 rounded-full text-xs text-orange-600">' . htmlspecialchars(trim($tag)) . '</span>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Version pc ou ecran large Sidebar Profil (visible sur tous les écrans si tu veux, retire "hidden lg:block" si besoin)-->
        <div class="flex flex-col lg:flex-row gap-6">
            <aside class="hidden lg:block lg:w-1/4 rounded-lg h-fit">
                <div class="bg-white rounded-lg shadow-md p-2 mb-6 text-center">
                    <!-- Avatar centré -->
                    <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Photo profil" class="rounded-lg h-50 w-50 mx-auto mb-4">

                    <!-- Nom et prénom -->
                    <h2 class="text-lg mb-1"><?= htmlspecialchars($user['nom'] . ' ' . $user['prenom']) ?> (<?= htmlspecialchars($user['profession']) ?>)</h2>

                    <!-- Année d'intégration -->
                    <p class="text-sterna-dark text-sm mb-2">Volontaire depuis <strong><?= htmlspecialchars($user['annee_integration']) ?></strong></p>

                    <!-- Compétences -->
                    <div class="flex flex-wrap justify-center space-y-0 gap-2 mt-2">
                        <h3 class="font-semibold text-sterna-primary">Mes Compétences</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php
                            $tags = explode(',', $user['competences']);
                            foreach ($tags as $tag) {
                                echo '<span class="bg-orange-200 px-3 py-1 rounded-full text-xs text-orange-600">' . htmlspecialchars(trim($tag)) . '</span>';
                            }
                            ?>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-semibold text-sterna-primary mb-2 mt-4">Statistiques</h3>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm">Missions accomplies: <span class="font-bold"><?php echo $missionsAccomplies; ?></span></p>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-sterna-secondary h-2 rounded-full" style="width: <?php echo $progression; ?>%"></div>
                                </div>
                            </div>

                            <!-- <div>
                                <p class="text-sm">Heures engagées: <span class="font-bold">42h</span></p>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-sterna-secondary h-2 rounded-full" style="width: 30%"></div>
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <div class="mt-2">
                        <p class=""><?= nl2br(htmlspecialchars($user['motivation'])) ?></p>
                    </div>

                </div>
            </aside>


            <!-- Contenu Principal -->
            <div class="lg:w-3/4 space-y-6">
                <!-- Section Missions (optimisé mobile) -->
                <section class="bg-white rounded-lg shadow-md p-2 md:p-2">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg md:text-xl font-bold text-sterna-dark">Mes Missions</h2>
                        <button id="toggleMissions" class="text-sm md:text-base text-sterna-primary hover:underline">Voir toutes</button>
                    </div>

                    <div id="missionsContainer" class="grid grid-cols-1 gap-3">
                        <?php foreach ($missions as $index => $mission): ?>
                            <?php
                            // Ne montrer que la première mission par défaut
                            $isHidden = $index > 0 ? 'hidden' : '';

                            $aujourdhui = date('Y-m-d');
                            $dateDebut = $mission['start_date'];
                            $dateFin = $mission['end_date'];

                            if ($dateFin < $aujourdhui) {
                                $statut = 'Terminée';
                                $bgColor = 'bg-green-600';
                            } elseif ($dateDebut <= $aujourdhui && $dateFin >= $aujourdhui) {
                                $statut = 'En cours';
                                $bgColor = 'bg-orange-500';
                            } elseif ($dateDebut > $aujourdhui) {
                                $statut = 'À venir';
                                $bgColor = 'bg-blue-500';
                            } else {
                                $statut = 'Inconnu';
                                $bgColor = 'bg-gray-500';
                            }

                            $debut = date('d', strtotime($mission['start_date']));
                            $fin = date('d M', strtotime($mission['end_date']));

                            $desc = strip_tags($mission['description']);
                            $desc = (strlen($desc) > 60) ? substr($desc, 0, 57) . '...' : $desc;
                            ?>
                            <div class="border border-sterna-light rounded-lg p-3 hover:shadow-md transition <?= $isHidden ?>">
                                <div class="flex justify-between items-start mb-1">
                                    <h3 class="font-semibold text-sm md:text-base text-sterna-primary"><?= htmlspecialchars($mission['title']) ?></h3>
                                    <span class="<?= $bgColor ?> text-white text-xs px-1.5 py-0.5 rounded"><?= $statut ?></span>
                                </div>
                                <p class="text-xs md:text-sm text-gray-600 mb-2"><?= htmlspecialchars($desc) ?></p>
                                <div class="flex justify-between text-xs text-gray-500">
                                    <span>📅 <?= $debut ?>–<?= $fin ?></span>
                                    <span>📍 <?= htmlspecialchars($mission['lieu']) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <!-- MODAL Tailwind CSS -->
                <!-- <div id="modalMissions" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                    <div class="bg-white rounded-lg max-w-2xl w-full p-6 relative">
                        <button id="closeModalMissions" class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-lg">&times;</button>
                        <h2 class="text-xl font-bold mb-4 text-sterna-dark">Toutes mes missions</h2>

                        <div class="space-y-4 max-h-[70vh] overflow-y-auto">
                            <?php
                            // Requête pour toutes les missions du volontaire
                            $stmt = $pdoAfrica->prepare("
                                SELECT m.*
                                FROM temoignages t
                                JOIN missions m ON t.mission_id = m.id
                                WHERE t.is_volontaire = 1 AND t.volontaire_id = ?
                                ORDER BY m.start_date DESC
                            ");
                            $stmt->execute([$volontaireId]);
                            $allMissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($allMissions as $mission):
                                $aujourdhui = date('Y-m-d');
                                $dateDebut = $mission['start_date'];
                                $dateFin = $mission['end_date'];

                                if ($dateFin < $aujourdhui) {
                                    $statut = 'Terminée';
                                    $bgColor = 'bg-green-600';
                                } elseif ($dateDebut <= $aujourdhui && $dateFin >= $aujourdhui) {
                                    $statut = 'En cours';
                                    $bgColor = 'bg-orange-500';
                                } elseif ($dateDebut > $aujourdhui) {
                                    $statut = 'À venir';
                                    $bgColor = 'bg-blue-500';
                                } else {
                                    $statut = 'Inconnu';
                                    $bgColor = 'bg-gray-500';
                                }

                                $debut = date('d', strtotime($mission['start_date']));
                                $fin = date('d M Y', strtotime($mission['end_date']));

                                $desc = strip_tags($mission['description']);
                                $desc = (strlen($desc) > 100) ? substr($desc, 0, 97) . '...' : $desc;
                            ?>
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-semibold text-md text-sterna-primary"><?= htmlspecialchars($mission['title']) ?></h3>
                                        <span class="<?= $bgColor ?> text-white text-xs px-2 py-0.5 rounded"><?= $statut ?></span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2"><?= htmlspecialchars($desc) ?></p>
                                    <div class="flex justify-between text-xs text-gray-500">
                                        <span>📅 <?= $debut ?> – <?= $fin ?></span>
                                        <span>📍 <?= htmlspecialchars($mission['lieu']) ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div> -->
                <!-- <script>
                    document.getElementById('toggleMissions').addEventListener('click', function () {
                        document.getElementById('modalMissions').classList.remove('hidden');
                    });

                    document.getElementById('closeModalMissions').addEventListener('click', function () {
                        document.getElementById('modalMissions').classList.add('hidden');
                    });

                    // Clique en dehors du modal pour le fermer
                    window.addEventListener('click', function (e) {
                        const modal = document.getElementById('modalMissions');
                        if (e.target === modal) {
                            modal.classList.add('hidden');
                        }
                    });
                </script> -->

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const toggleBtn = document.getElementById('toggleMissions');
                        const allMissions = document.querySelectorAll('#missionsContainer > div');
                        let expanded = false;

                        toggleBtn.addEventListener('click', function() {
                            expanded = !expanded;
                            allMissions.forEach((el, i) => {
                                if (i > 0) {
                                    el.classList.toggle('hidden', !expanded);
                                }
                            });
                            toggleBtn.textContent = expanded ? 'Voir moins' : 'Voir toutes';
                        });
                    });
                </script>


                <!-- Section Calendrier (scroll horizontal sur mobile) -->
                <?php
                $aujourdhui = date('Y-m-d');
                $annee = date('Y');

                // Récupérer les missions, d'abord les futures puis les passées
                $stmt = $pdoAfrica->prepare("
                        SELECT * FROM missions 
                        WHERE YEAR(start_date) = YEAR(CURDATE()) 
                        ORDER BY start_date >= CURDATE() DESC, start_date ASC
                    ");
                $stmt->execute();
                $missionsCalendrier = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>


                <!-- calendrier des evenements section -->
                <section class="bg-white rounded-lg shadow-md p-2 md:p-2">
                    <h2 class="text-lg md:text-xl font-bold text-sterna-dark mb-3">Calendrier <?= $annee ?></h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-max">
                            <thead class="bg-sterna-primary text-white">
                                <tr>
                                    <th class="p-2 text-left text-xs md:text-sm">Date</th>
                                    <th class="p-2 text-left text-xs md:text-sm">Événement</th>
                                    <th class="p-2 text-left text-xs md:text-sm">Lieu</th>
                                    <th class="p-2 text-left text-xs md:text-sm">Action</th>
                                    <th class="p-2 text-left text-xs md:text-sm">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($missionsCalendrier as $mission): ?>
                                    <?php
                                    $debut = date('d M', strtotime($mission['start_date']));
                                    $dateDebut = $mission['start_date'];
                                    $dateFin = $mission['end_date'];

                                    if ($dateFin < $aujourdhui) {
                                        $statut = 'Passée';
                                        $color = 'text-green-600';
                                    } elseif ($dateDebut <= $aujourdhui && $dateFin >= $aujourdhui) {
                                        $statut = 'En cours';
                                        $color = 'text-orange-500';
                                    } elseif ($dateDebut > $aujourdhui) {
                                        $statut = 'À venir';
                                        $color = 'text-blue-500';
                                    } else {
                                        $statut = 'Inconnu';
                                        $color = 'text-gray-500';
                                    }
                                    ?>
                                    <tr class="border-b border-sterna-light hover:bg-sterna-light/50">
                                        <td class="p-2 text-xs md:text-sm"><?= $debut ?></td>
                                        <td class="p-2 text-xs md:text-sm"><?= htmlspecialchars($mission['title']) ?></td>
                                        <td class="p-2 text-xs md:text-sm"><?= htmlspecialchars($mission['lieu']) ?></td>
                                        <td class="p-2 text-xs md:text-sm">
                                            <a href="#" class="text-sterna-primary hover:underline">S'inscrire</a>
                                        </td>
                                        <td class="p-2 text-xs md:text-sm font-semibold <?= $color ?>"><?= $statut ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Sections resultats examens -->
                <?php
                require_once './inclusion/db.php';
                // session_start();

                $volontaireId = $_SESSION['user_id'] ?? null;

                if ($volontaireId) {
                    $stmt = $pdo->prepare("SELECT note, commentaire, date_creation FROM notes_modules WHERE volontaire_id = ?");
                    $stmt->execute([$volontaireId]);
                    $noteData = $stmt->fetch();

                    if ($noteData):
                ?>

                        <section class="bg-white rounded-lg shadow-md p-4 md:p-6 mt-6">
                            <h2 class="text-lg md:text-xl font-bold text-sterna-dark mb-4">Résultats examens - section <?= date('Y') ?></h2>

                            <div class="mb-3">
                                <p class="text-gray-800 text-base md:text-lg font-semibold">
                                    🎓 Note obtenue : <span class="text-blue-600"><?= htmlspecialchars($noteData['note']) ?>/20</span>
                                </p>
                            </div>

                            <div class="mb-2">
                                <p class="text-sm text-gray-700"><strong>Commentaire de l’évaluateur :</strong></p>
                                <p class="bg-gray-100 text-gray-800 rounded px-3 py-2 text-sm whitespace-pre-line">
                                    <?= nl2br(htmlspecialchars($noteData['commentaire'])) ?>
                                </p>
                            </div>

                            <p class="text-xs text-gray-500 mt-3">
                                📅 Note attribuée le : <?= date('d/m/Y', strtotime($noteData['date_creation'])) ?>
                            </p>
                        </section>

                <?php
                    else:
                        echo '<section class="mt-6"><p class="text-red-600 text-sm">Vous n\'avez pas encore de note.</p></section>';
                    endif;
                } else {
                    echo '<section class="mt-6"><p class="text-red-600 text-sm">Erreur : utilisateur non identifié.</p></section>';
                }
                ?>

                <!-- Sections ajouts categorie de discussion forum-->
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 9): ?>
                    <!-- Formulaire d'ajout de catégorie -->
                    <form action="ajouter_categorie.php" method="post" class="flex items-center gap-2 w-full overflow-x-auto">
                        <label for="nom_categorie" class="text-gray-700 font-medium whitespace-nowrap">Nom :</label>

                        <input
                            type="text"
                            name="nom_categorie"
                            id="nom_categorie"
                            required
                            class="flex-1 min-w-0 px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                            placeholder="Nouvelle catégorie">

                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-4 py-1 rounded-md hover:bg-blue-700 transition whitespace-nowrap">
                            Ajouter
                        </button>
                    </form>
                <?php endif; ?>

                <section class="w-full bg-white rounded-lg shadow-md p-2 md:p-2">
                    <h2 class="text-lg md:text-xl font-bold text-sterna-dark">Discussion</h2>
                    <p class="text-gray-600 mb-2">Sélectionnez une discussion pour y prendre part.</p>

                    <?php
                    $req = $pdo->prepare("
                            SELECT 
                                t.id, 
                                t.titre, 
                                t.date_creation, 
                                t.auteur_id, 
                                u.prenom, 
                                u.nom, 
                                c.nom AS categorie_nom,
                                (
                                    SELECT fm.message 
                                    FROM forum_messages fm 
                                    WHERE fm.topic_id = t.id 
                                    ORDER BY fm.date_envoi ASC 
                                    LIMIT 1
                                ) AS message,
                                (
                                    SELECT COUNT(*) 
                                    FROM forum_messages fm 
                                    WHERE fm.topic_id = t.id
                                ) AS nb_reponses
                            FROM forum_topics t
                            JOIN users u ON t.auteur_id = u.id
                            JOIN categories c ON t.categorie_id = c.id
                            ORDER BY t.date_creation DESC
                        ");
                    $req->execute();
                    $discussions = $req->fetchAll();
                    ?>

                    <div id="discussions-container">
                        <?php foreach ($discussions as $index => $d): ?>
                            <div
                                class="relative bg-white p-2 rounded-lg shadow transition-all duration-300 cursor-pointer discussion-item <?= $index >= 2 ? 'hidden' : '' ?> group hover:border-l-4 hover:shadow-lg hover:-translate-y-1"
                                data-id="<?= $d['id'] ?>"
                                onclick="openDiscussion(<?= $d['id'] ?>, '<?= htmlspecialchars(addslashes($d['titre'])) ?>')">

                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold text-blue-600 group-hover:text-blue-700 transition-colors"><?= htmlspecialchars($d['titre']) ?></h3>
                                        <p class="text-gray-600 text-md mt-1">
                                            <?= htmlspecialchars($d['message']) ?>
                                        </p>

                                        <p class="text-gray-600 text-sm mt-1">
                                            Posté par
                                            <span class="font-medium"><?= htmlspecialchars($d['nom']) ?></span> ·
                                            <?= date('d M Y', strtotime($d['date_creation'])) ?>
                                        </p>
                                    </div>
                                    <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full h-fit">
                                        <?= htmlspecialchars($d['categorie_nom']) ?>
                                    </span>
                                </div>
                                <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                                    <span><?= $d['nb_reponses'] ?> réponse<?= $d['nb_reponses'] > 1 ? 's' : '' ?></span>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (count($discussions) > 2): ?>
                        <div class="text-center mt-4">
                            <button id="toggleBtn" class="text-blue-600 hover:underline text-sm">Voir plus</button>
                        </div>
                    <?php endif; ?>

                    <script>
                        const toggleBtn = document.getElementById('toggleBtn');
                        const hiddenItems = document.querySelectorAll('.discussion-item.hidden');
                        let expanded = false;

                        toggleBtn?.addEventListener('click', () => {
                            expanded = !expanded;
                            hiddenItems.forEach(item => {
                                item.classList.toggle('hidden');
                            });
                            toggleBtn.textContent = expanded ? 'Voir moins' : 'Voir plus';
                        });
                    </script>


                    <!-- Liste des Discussions -->
                    <div id="liste-discussions" class="space-y-4">

                    </div>

                    <!-- Formulaire de creation de discussion -->
                    <div id="nouvelle-discussion" class="mt-12 bg-white p-2 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Créer une nouvelle discussion</h3>
                        <form id="form-nouvelle-discussion">
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">Titre</label>
                                <input name="titre" type="text" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">Catégorie</label>
                                <select name="categorie_id" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                                    <option value="" disabled selected>Choisissez une catégorie</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= htmlspecialchars($cat['id']) ?>"><?= htmlspecialchars($cat['nom']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">Message</label>
                                <textarea name="message" rows="4" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required></textarea>
                            </div>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium">
                                Publier
                            </button>
                            <p id="form-message" class="mt-4 text-sm text-green-600 hidden">✅ Discussion créée avec succès.</p>
                        </form>
                    </div>

                    <!-- script AJAX pour rechargement apres creation de topic ou discussion -->
                    <script>
                        document.getElementById('form-nouvelle-discussion').addEventListener('submit', async function(e) {
                            e.preventDefault();

                            const form = e.target;
                            const formData = new FormData(form);

                            // 👇 ajoute cette ligne AVANT le fetch
                            const select = form.querySelector('select[name="categorie_id"]');
                            formData.append('categorie_nom', select.options[select.selectedIndex].text);

                            try {
                                const response = await fetch('create_topic.php', {
                                    method: 'POST',
                                    body: formData
                                });

                                const result = await response.json();

                                const messageEl = document.getElementById('form-message');
                                if (result.success) {
                                    messageEl.textContent = "✅ Discussion créée avec succès.";
                                    messageEl.classList.remove('hidden', 'text-red-600');
                                    messageEl.classList.add('text-green-600');
                                    form.reset();

                                    const liste = document.getElementById('liste-discussions');
                                    const blocHTML = `
                                    <div class="discussion-card bg-white p-5 rounded-lg shadow hover:shadow-lg transition-shadow duration-300 cursor-pointer" data-id="${result.id}">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-lg font-semibold text-blue-600">${result.titre}</h3>
                                                <p class="text-gray-600 text-sm mt-1">Posté par <span class="font-medium">${result.auteur}</span> · ${result.date}</p>
                                            </div>
                                            <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full h-fit">${result.categorie}</span>
                                        </div>
                                        <p class="mt-3 text-gray-700 text-sm">${result.message}</p>
                                        <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                                            <span>0 réponse</span>
                                            <span class="text-blue-500 hover:underline">Voir la discussion →</span>
                                        </div>
                                    </div>
                                    `;
                                    liste.insertAdjacentHTML('afterbegin', blocHTML);
                                } else {
                                    messageEl.textContent = "❌ Erreur : " + result.message;
                                    messageEl.classList.remove('hidden', 'text-green-600');
                                    messageEl.classList.add('text-red-600');
                                }
                            } catch (error) {
                                console.error('Erreur AJAX :', error);
                            }
                        });
                    </script>

                </section>

                <!-- Modal (mobile) -->
                <div id="modalDiscussion" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden md:hidden">
                    <div class="bg-white w-11/12 max-w-md rounded-lg shadow-lg p-4 relative">
                        <button onclick="closeDiscussion()" class="absolute top-2 right-2 text-gray-600 hover:text-black text-xl">&times;</button>

                        <!-- Titre dynamique -->
                        <h3 id="discussionTitle" class="text-lg font-bold text-gray-800 mb-2">Discussion</h3>

                        <!-- Champ caché pour l'ID de discussion -->
                        <input type="hidden" id="discussion_id" name="discussion_id" value="">

                        <!-- Conteneur des messages -->
                        <div id="chatMessagesMobile" class="text-sm text-gray-700 max-h-[450px] overflow-y-auto space-y-3">
                            Chargement du contenu de la discussion...
                        </div>

                        <!-- Formulaire d'envoi du message -->
                        <form id="chatForm" class="mt-4 flex items-end gap-2">
                            <textarea
                                id="chatInput"
                                placeholder="Écrire un message..."
                                rows="1"
                                class="flex-grow border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm resize-none overflow-hidden"
                                autocomplete="off"
                                oninput="autoResize(this)"></textarea>

                            <button type="submit" class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 12L5 5l4 7-4 7 14-7z" />
                                </svg>
                            </button>
                        </form>

                        <script>
                            function autoResize(textarea) {
                                textarea.style.height = 'auto';
                                textarea.style.height = (textarea.scrollHeight) + 'px';
                            }
                        </script>

                    </div>
                </div>


                <!-- Panel latéral (desktop) -->
                <div id="sidePanelDiscussion"
                    class="fixed top-0 right-0 w-[400px] h-[calc(100vh-42px)] bg-white dark:bg-gray-800 shadow-xl z-40 transform translate-x-full transition-transform duration-300 rounded-l-2xl flex flex-col overflow-hidden hidden">

                    <div class="p-2 flex flex-col h-full">
                        <!-- Titre -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 id="discussionTitle" class="text-lg font-bold text-gray-800 dark:text-white">Discussion</h3>
                            <button onclick="closeDiscussion()" class="ext-gray-600 dark:text-gray-300 hover:text-black dark:hover:text-white text-xl">&times;</button>
                        </div>

                        <!-- Champ caché pour l'ID de discussion -->
                        <input type="hidden" id="discussion_id_desktop" name="discussion_id" value="">

                        <!-- Messages -->
                        <div id="chatMessagesDesktop" class="flex-1 overflow-y-auto px-2 py-2 space-y-3 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800">
                            Chargement du contenu de la discussion...
                        </div>

                        <!-- Formulaire desktop -->
                        <form id="chatFormDesktop" class="flex items-end gap-2">
                            <textarea
                                id="chatInputDesktop"
                                placeholder="Écrire un message..."
                                rows="1"
                                class="flex-1 min-w-0 rounded-full px-4 py-2 border border-gray-300 focus:ring focus:ring-blue-200 focus:outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white text-sm resize-none overflow-hidden"
                                autocomplete="off"
                                oninput="autoResize(this)"></textarea>

                            <button type="submit" class="shrink-0 bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 12L5 5l4 7-4 7 14-7z" />
                                </svg>
                            </button>
                        </form>

                        <script>
                            function autoResize(textarea) {
                                textarea.style.height = 'auto';
                                textarea.style.height = textarea.scrollHeight + 'px';
                            }
                        </script>

                    </div>
                </div>

                <!-- Script pour ouvrir Modal de discussion pour ouvrir une discussion (avec chargement dynamique du contenu) -->
                <script>
                    let messageRefreshInterval = null;

                    function openDiscussion(discussionId, titre) {
                        const isMobile = window.innerWidth < 768;

                        // 1. Affiche le bon conteneur
                        if (isMobile) {
                            document.getElementById("modalDiscussion").classList.remove("hidden");
                        } else {
                            const panel = document.getElementById("sidePanelDiscussion");
                            panel.classList.remove("hidden", "translate-x-full");
                        }

                        // 2. Met à jour l'input caché dans les deux contextes (mobile et desktop)
                        document.getElementById('discussion_id').value = discussionId;
                        document.getElementById('discussion_id_desktop').value = discussionId;

                        // 3. Met à jour dynamiquement le titre si présent
                        const titleElem = document.getElementById("discussionTitle");
                        if (titleElem) titleElem.textContent = titre;

                        // 4. Sélectionne la bonne boîte de chat
                        const chatBox = isMobile ? document.getElementById("chatMessagesMobile") : document.getElementById("chatMessagesDesktop");
                        if (chatBox) {
                            chatBox.innerHTML = "<p class='text-center text-gray-400'>Chargement des messages...</p>";

                            // 5. Fonction pour charger les messages
                            function chargerMessages() {
                                fetch(`load_messages.php?id=${discussionId}`)
                                    .then(response => {
                                        if (!response.ok) throw new Error("Erreur réseau.");
                                        return response.text();
                                    })
                                    .then(html => {
                                        chatBox.innerHTML = html;
                                        chatBox.scrollTop = chatBox.scrollHeight;
                                    })
                                    .catch(error => {
                                        console.error("Erreur lors du chargement :", error);
                                        chatBox.innerHTML = "<p class='text-red-500'>Impossible de charger les messages.</p>";
                                    });
                            }

                            // 6. Chargement initial
                            chargerMessages();

                            // 7. Arrêter les anciens intervalles et lancer un nouveau
                            if (messageRefreshInterval) clearInterval(messageRefreshInterval);
                            messageRefreshInterval = setInterval(chargerMessages, 3000);
                        }
                    }

                    function closeDiscussion() {
                        // Fermer le modal mobile
                        document.getElementById("modalDiscussion").classList.add("hidden");

                        // Fermer le panneau desktop avec animation
                        const panel = document.getElementById("sidePanelDiscussion");
                        panel.classList.add("translate-x-full");
                        setTimeout(() => panel.classList.add("hidden"), 300);

                        // Stopper le rafraîchissement automatique quand on ferme la discussion
                        if (messageRefreshInterval) {
                            clearInterval(messageRefreshInterval);
                            messageRefreshInterval = null;
                        }
                    }
                </script>


                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const mobileForm = document.getElementById('chatForm');
                        const mobileInput = document.getElementById('chatInput');
                        const mobileDiscussionId = document.getElementById('discussion_id');

                        const desktopForm = document.getElementById('chatFormDesktop');
                        const desktopInput = document.getElementById('chatInputDesktop');
                        const desktopDiscussionId = document.getElementById('discussion_id_desktop');

                        function handleSubmit(form, input, discussionInput, chatBoxId) {
                            form.addEventListener('submit', function(e) {
                                e.preventDefault();

                                const message = input.value.trim();
                                const discussionId = discussionInput.value;

                                if (message === '' || !discussionId || isNaN(discussionId)) {
                                    alert("Message ou ID de discussion invalide.");
                                    return;
                                }

                                const formData = new FormData();
                                formData.append('message', message);
                                formData.append('discussion_id', discussionId);

                                fetch('send_message.php', {
                                        method: 'POST',
                                        body: formData
                                    })
                                    .then(response => {
                                        if (!response.ok) throw new Error("Erreur d'envoi.");
                                        return response.text();
                                    })
                                    .then(() => {
                                        input.value = '';
                                        // On NE met pas à jour manuellement le chatBox : il sera mis à jour par setInterval automatiquement
                                    })
                                    .catch(error => {
                                        alert("Erreur : " + error.message);
                                    });
                            });
                        }


                        if (mobileForm && mobileInput && mobileDiscussionId)
                            handleSubmit(mobileForm, mobileInput, mobileDiscussionId, 'chatMessagesMobile');

                        if (desktopForm && desktopInput && desktopDiscussionId)
                            handleSubmit(desktopForm, desktopInput, desktopDiscussionId, 'chatMessagesDesktop');
                    });
                </script>


            </div>
        </div>

    </main>

    <!-- Footer optimisé mobile -->
    <footer class="bg-sterna-dark text-white py-6 mt-8">
        <div class="container mx-auto px-4">
            <div class="text-sm text-center" x-data="{ year: new Date().getFullYear() }">
                <p>© <span x-text="year"></span> Sterna Africa International</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript pour la gestion du mobile -->
    <script>
        // Gestion du menu mobile
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuClose = document.getElementById('menu-close');
        const menuOverlay = document.getElementById('menu-overlay');

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.remove('hidden');
            mobileMenu.classList.remove('translate-x-full');
            mobileMenu.classList.add('translate-x-0');
            menuOverlay.classList.remove('hidden');
        });

        menuClose.addEventListener('click', () => {
            mobileMenu.classList.add('translate-x-full');
            mobileMenu.classList.remove('translate-x-0');
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
                menuOverlay.classList.add('hidden');
            }, 300);
        });

        menuOverlay.addEventListener('click', () => {
            mobileMenu.classList.add('translate-x-full');
            mobileMenu.classList.remove('translate-x-0');
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
                menuOverlay.classList.add('hidden');
            }, 300);
        });
    </script>

    <!-- JavaScript pour les notification Phuse navigateur -->
    <script>
        // Demande de permission
        document.addEventListener('DOMContentLoaded', () => {
            if ('Notification' in window && navigator.serviceWorker) {
                Notification.requestPermission().then(permission => {
                    if (permission === 'granted') {
                        console.log("Permission de notification accordée.");
                    }
                });

                navigator.serviceWorker.register('service-worker.js')
                    .then(reg => {
                        console.log('Service worker enregistré', reg);
                    })
                    .catch(err => {
                        console.error('Erreur service worker', err);
                    });
            } else {
                console.warn("Notifications ou service workers non supportés.");
            }
        });

        // Fonction pour déclencher une notif (exemple)
        function envoyerNotification(titre, body) {
            if (Notification.permission === 'granted') {
                navigator.serviceWorker.getRegistration().then(reg => {
                    if (reg) {
                        reg.showNotification(titre, {
                            body: body,
                            icon: 'https://i.postimg.cc/mD1YfCSq/logos-sterna.png', // optionnel
                            tag: 'sterna africa'
                        });
                    }
                });
            }
        }
    </script>

    <script type="module" src="chat.js"></script>

    <!-- <button onclick="envoyerNotification('Nouveau message', 'Un nouveau message est disponible sur Sterna Africa')">
    Tester la notification
</button> -->


</body>

</html>