<?php
// temoignage_detail.php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// 1. Connexion à africa_db (base principale) via ton fichier central
require_once('../config/db.php');

// On récupère la connexion de db.php (souvent $conn) pour l'attribuer à $pdoAfrica
if (isset($conn) && !isset($pdoAfrica)) {
    $pdoAfrica = $conn;
}

// 2. Connexion à monespace (base des volontaires) - Gardé en PDO comme tu l'as fait
// Dans pages/temoignage_detail.php
try {
    // Utilise bien 'SoftiP4' (le mot de passe de ton docker-compose)
    $pdoMonespace = new PDO('mysql:host=db;dbname=monespace', 'root', 'SoftiP24');
    $pdoMonespace->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à monespace : " . $e->getMessage());
}

// Récupérer l'ID de l'URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    echo "ID invalide.";
    exit;
}

// 3. Récupérer le témoignage depuis africa_db (Version MySQLi)
$sql = "SELECT * FROM temoignages WHERE id = ?";
$stmt = $pdoAfrica->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$temoignage = $result->fetch_assoc();

if (!$temoignage) {
    echo "Témoignage introuvable.";
    exit;
}

// Gestion de la photo
$photoPath = "../assets/img/avatar-default.jpg";

if (!empty($temoignage['is_volontaire']) && !empty($temoignage['volontaire_id'])) {
    $stmtUser = $pdoMonespace->prepare("SELECT avatar FROM users WHERE id = ?");
    $stmtUser->execute([$temoignage['volontaire_id']]);
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if ($user && !empty($user['avatar'])) {
        $avatarPath = htmlspecialchars($user['avatar']);
        if (strpos($avatarPath, '/uploads/') !== false) {
            $avatarPath = str_replace('/uploads/', '/', $avatarPath);
        }
        $photoPath = "https://monespacevolontaire.sternaafrica.org/" . ltrim($avatarPath, '/');
    }
} elseif (!empty($temoignage['photo'])) {
    $photoPath = "../uploads/" . htmlspecialchars($temoignage['photo']);
}

// 4. Récupérer mission liée (Version MySQLi)
$sql_mission = "SELECT DISTINCT m.id, m.title 
                FROM missions m
                JOIN questions q ON m.id = q.mission_id
                JOIN reponses r ON q.id = r.question_id
                WHERE r.temoignage_id = ?";
$stmt_m = $pdoAfrica->prepare($sql_mission);
$stmt_m->bind_param("i", $id);
$stmt_m->execute();
$res_m = $stmt_m->get_result();
$mission = $res_m->fetch_assoc();

$mission_id = $mission['id'] ?? 0;
$mission_title = $mission['title'] ?? "Mission inconnue";

// 5. Récupérer les questions (Version MySQLi)
$sql_questions = "SELECT id, question_text FROM questions WHERE mission_id = ? ORDER BY id ASC";
$stmt_q = $pdoAfrica->prepare($sql_questions);
$stmt_q->bind_param("i", $mission_id);
$stmt_q->execute();
$res_q = $stmt_q->get_result();
$questions = [];
while ($row = $res_q->fetch_assoc()) {
    $questions[] = $row;
}

// 6. Récupérer les réponses (Version MySQLi)
$sql_reponses = "SELECT question_id, reponse FROM reponses WHERE temoignage_id = ?";
$stmt_r = $pdoAfrica->prepare($sql_reponses);
$stmt_r->bind_param("i", $id);
$stmt_r->execute();
$res_r = $stmt_r->get_result();
$reponses = [];
while ($row = $res_r->fetch_assoc()) {
    $reponses[$row['question_id']] = $row['reponse'];
}
?>

<!DOCTYPE html>
<html lang="fr" class="bg-[#0A0F14]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title><?php echo htmlspecialchars($temoignage['nom']); ?> - Expérience Sterna</title>
    <style>
        /* .comic-neue {
            font-family: 'Comic Neue', cursive;
        } */

        .glass-effect {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>

<body class="text-slate-200 antialiased">

    <nav class="p-6">
        <a href="javascript:history.back()" class="text-yellow-500 hover:text-white transition flex items-center gap-2 font-bold">
            <i class="fas fa-arrow-left"></i> RETOUR
        </a>
    </nav>

    <main class="container mx-auto px-4 max-w-4xl pb-20">

        <header class="mb-12 text-center">
            <span class="bg-blue-600/20 text-blue-400 px-4 py-1 rounded-full text-xs font-black tracking-widest uppercase">
                Témoignage Volontaire
            </span>
            <h1 class="comic-neue text-4xl md:text-5xl font-bold mt-6 mb-4 text-white">
                <?php echo htmlspecialchars($temoignage['nom']); ?>
            </h1>
            <p class="text-yellow-500 text-xl comic-neue italic">
                « <?php echo htmlspecialchars($mission_title); ?> »
            </p>
            <div class="flex justify-center items-center gap-4 mt-8 text-slate-400 text-sm">
                <span class="flex items-center gap-2">
                    <i class="far fa-calendar-alt"></i>
                    Publié le <?php echo date("d M Y", strtotime($temoignage['date_submis'])); ?>
                </span>
            </div>
        </header>

        <div class="relative w-full mb-16 rounded-3xl overflow-hidden shadow-2xl bg-black/40 flex items-center justify-center min-h-[400px]">
            <img src="<?php echo $photoPath; ?>" class="absolute inset-0 w-full h-full object-cover blur-2xl opacity-30 scale-110">

            <img src="<?php echo $photoPath; ?>"
                class="relative z-10 w-auto max-w-full h-auto max-h-[80vh] shadow-2xl">

            <div class="absolute inset-0 bg-gradient-to-t from-[#0A0F14] via-transparent to-transparent z-20 pointer-events-none"></div>
        </div>

        <div class="grid grid-cols-1 gap-12">
            <?php foreach ($questions as $question): ?>
                <section class="glass-effect p-4 rounded-3xl shadow-lg hover:border-yellow-500/50 transition-colors duration-500">
                    <h2 class="comic-neue text-lg font-bold text-blue-400 mb-6 flex items-start gap-3">
                        <span class="text-yellow-500">Q.</span>
                        <?php echo htmlspecialchars($question['question_text']); ?>
                    </h2>
                    <div class="comic-neue text-md leading-relaxed text-slate-300 pl-8 border-l-2 border-slate-800">
                        <?php echo nl2br(htmlspecialchars($reponses[$question['id']] ?? "L'émotion est là, mais les mots manquent pour l'instant.")); ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>

        <div class="mt-20 p-10 rounded-3xl bg-gradient-to-br from-blue-900/40 to-yellow-900/20 text-center border border-white/5">
            <h3 class="comic-neue text-2xl font-bold text-white mb-4">Vous aussi, vivez l'aventure Sterna</h3>
            <p class="text-slate-400 mb-8">Chaque témoignage commence par un premier pas. Et si le prochain était le vôtre ?</p>
            <a href="/recrutement" class="bg-yellow-500 hover:bg-yellow-400 text-black font-black py-4 px-10 rounded-full transition-all hover:scale-105 inline-block">
                DEVENIR VOLONTAIRE
            </a>
        </div>

    </main>

    <?php require_once('../config/footer_2.php'); ?>
</body>

</html>