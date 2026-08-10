<?php
$conn = new mysqli('db', 'root', 'SoftiP24', 'africa_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Tables:\n";
$result = $conn->query("SHOW TABLES");
while ($row = $result->fetch_row()) {
    echo "- " . $row[0] . "\n";
}

echo "\nColumns in rapports:\n";
$result = $conn->query("SHOW COLUMNS FROM rapports");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
    }
}

echo "\nData in rapports:\n";
$result = $conn->query("SELECT * FROM rapports LIMIT 10");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
}

$conn->close();
?>
