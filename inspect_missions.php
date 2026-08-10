<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/db.php";
$result = $conn->query("DESCRIBE actualites");
while ($row = $result->fetch_assoc()) {
    print_r($row);
}
?>
