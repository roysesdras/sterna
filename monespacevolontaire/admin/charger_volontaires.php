<?php
// header('Content-Type: application/json');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Connexion à la base principale
require_once '../inclusion/db.php';

// Connexion africa_db
try {
    $pdoAfrica = new PDO(
        'mysql:host=db;dbname=africa_db',
        'root',
        'SoftiP24'
    );
    $pdoAfrica->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur de connexion à africa_db : ' . $e->getMessage()]);
    exit;
}

// Récupère l'offset envoyé par JS
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

// Nombre de volontaires par requête
$limit = 5;

// Sélection des volontaires
$stmt = $pdo->prepare("SELECT * FROM users ORDER BY nom ASC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$volontaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Missions
$stmt2 = $pdoAfrica->query("
    SELECT volontaire_id, COUNT(DISTINCT mission_id) AS total
    FROM temoignages
    WHERE is_volontaire = 1
    GROUP BY volontaire_id
");

$missionsParVolontaire = [];
foreach ($stmt2->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $missionsParVolontaire[$row['volontaire_id']] = $row['total'];
}

// JSON de retour
echo json_encode([
    'volontaires' => $volontaires,
    'missions' => $missionsParVolontaire
]);
