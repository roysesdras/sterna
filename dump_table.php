<?php
require_once 'config/db.php';
$res = $conn->query("SELECT * FROM actualites");
$rows = [];
while($row = $res->fetch_assoc()){ $rows[] = $row; }
echo json_encode($rows, JSON_PRETTY_PRINT);
