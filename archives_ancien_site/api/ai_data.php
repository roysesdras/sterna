<?php

// =============================
// 🔒 CONFIGURATION SÉCURITÉ
// =============================

header("Content-Type: application/json; charset=utf-8");

// ⚠️ Change ce token par quelque chose de long et secret
define('AI_SECRET_TOKEN', 'STERNA_9f8d7s9df87sdf87sdf98s7df98s7df38sdf');

// Vérification du token
$headers = getallheaders();
$token = $_SERVER['HTTP_X_API_KEY'] ?? '';

if ($token !== AI_SECRET_TOKEN) {
    http_response_code(403);
    echo json_encode(["error" => "Accès refusé"]);
    exit;
}

// =============================
// 🔗 CONNEXION BDD LOCALE
// =============================

require_once(__DIR__ . '/../config/db.php');

// =============================
// 📌 FONCTIONS DATA
// =============================

function getDernieresActualites($conn)
{
    $sql = "SELECT id, title, description, start_date, lieu FROM actualites ORDER BY id DESC LIMIT 5";
    $result = $conn->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "id" => $row['id'], // <--- EST-CE QUE CETTE LIGNE EXISTE ?
            "title" => $row['title'],
            "description" => $row['description'],
            "date" => $row['start_date'],
            "lieu" => $row['lieu']
        ];
    }
    return $data;
}

function getMissionsEnCours($conn)
{
    $sql = "SELECT title, description, start_date, end_date, lieu
            FROM missions
            WHERE CURDATE() BETWEEN start_date AND end_date";

    $result = $conn->query($sql);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "title" => $row['title'],
            "description" => $row['description'],
            "start_date" => $row['start_date'],
            "end_date" => $row['end_date'],
            "lieu" => $row['lieu']
        ];
    }

    return $data;
}

function getAntennes($conn)
{
    $sql = "SELECT nom FROM antennes";
    $result = $conn->query($sql);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row['nom'];
    }

    return $data;
}

// =============================
// 🚀 RÉPONSE JSON
// =============================

$response = [
    "actualites" => getDernieresActualites($conn),
    "missions_en_cours" => getMissionsEnCours($conn),
    "antennes" => getAntennes($conn),
    "generated_at" => date('Y-m-d H:i:s')
];

echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;
