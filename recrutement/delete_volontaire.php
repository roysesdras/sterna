<?php
// delete_volontaire.php
$servername = "db";
$username = "root";
$password = "SoftiP24";
$dbname = "africa_db";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $stmt = $conn->prepare("DELETE FROM benevoles WHERE id = :id");
        $success = $stmt->execute(['id' => $_POST['id']]);
        echo json_encode(['success' => $success]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}
