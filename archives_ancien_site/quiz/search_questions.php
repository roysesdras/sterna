<?php
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

if (isset($_GET['q'])) {
    $search = isset($_GET['q']) ? '%' . $_GET['q'] . '%' : '%%'; // <-- AJOUT DES WILDCARDS %
    $sql = "SELECT id, question FROM question_quiz WHERE question LIKE ? ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    $questions = [];
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }

    echo json_encode($questions);
}
