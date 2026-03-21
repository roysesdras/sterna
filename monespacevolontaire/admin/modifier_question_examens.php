<?php
require_once '../inclusion/db.php';

$id = $_POST['id'];
$question = $_POST['question_text'];
$type = $_POST['type_question'];
$options = isset($_POST['options']) ? $_POST['options'] : null;

$image = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads_examens/" . $filename);
    $image = $filename;
}

$sql = "UPDATE examens SET question_text = ?, type_question = ?, options = ?";
$params = [$question, $type, $options];

if ($image) {
    $sql .= ", image = ?";
    $params[] = $image;
}

$sql .= " WHERE id = ?";
$params[] = $id;

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
?>
