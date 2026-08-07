<?php
include 'config/db.php';
$res = $conn->query("SHOW TABLES");
echo "Tables:\n";
while($row = $res->fetch_array()) {
    echo "- " . $row[0] . "\n";
    $desc = $conn->query("DESCRIBE " . $row[0]);
    while($col = $desc->fetch_assoc()) {
        echo "  - " . $col['Field'] . " (" . $col['Type'] . ")\n";
    }
}
?>
