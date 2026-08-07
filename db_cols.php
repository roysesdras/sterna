<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/db.php";
$stmt = $conn->query("SHOW COLUMNS FROM projets");
while ($row = $stmt->fetch_assoc()) {
    echo $row["Field"] . "\n";
}
?>
