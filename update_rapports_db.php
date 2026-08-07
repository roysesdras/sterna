<?php
require_once __DIR__ . '/config/db.php';

$sql = "ALTER TABLE rapports 
        ADD COLUMN type_document VARCHAR(50) DEFAULT 'bulletin' AFTER id,
        ADD COLUMN annee INT(4) DEFAULT 2026 AFTER type_document,
        ADD COLUMN trimestre VARCHAR(10) DEFAULT NULL AFTER annee";

if ($conn->query($sql) === TRUE) {
    echo "Columns added successfully.\n";
} else {
    echo "Error updating table or columns already exist: " . $conn->error . "\n";
}
?>
