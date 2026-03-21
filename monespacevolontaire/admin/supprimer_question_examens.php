<?php
require_once '../inclusion/db.php';

if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM examens WHERE id = ?");
    $stmt->execute([$id]);
}
