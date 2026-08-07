<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/db.php";
$stmt = $conn->query("SHOW TABLES");
while ($row = $stmt->fetch_array()) {
    echo $row[0] . "\n";
}
?>
