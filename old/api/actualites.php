<?php
header('Content-Type: application/json');
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

$today = date('Y-m-d');
$sql_actualites = "SELECT * FROM actualites 
                   WHERE end_date <= '$today' 
                   ORDER BY end_date DESC 
                   LIMIT 3";

$result_actualites = $conn->query($sql_actualites);
$actualites = [];
if ($result_actualites && $result_actualites->num_rows > 0) {
    while ($row = $result_actualites->fetch_assoc()) {
        $actualites[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'image' => $row['image']
        ];
    }
}

echo json_encode($actualites);
?>
