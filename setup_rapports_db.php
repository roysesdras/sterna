<?php
require_once __DIR__ . '/config/db.php';

$sql = "CREATE TABLE IF NOT EXISTS rapports (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    type_document VARCHAR(50) DEFAULT 'bulletin',
    annee INT(4) DEFAULT 2026,
    trimestre VARCHAR(10) DEFAULT NULL,
    titre VARCHAR(255) NOT NULL,
    cover_image VARCHAR(255) DEFAULT NULL,
    pdf_link VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$result = $conn->query("SHOW COLUMNS FROM rapports LIKE 'type_document'");
if ($result->num_rows == 0) {
    $conn->query("ALTER TABLE rapports ADD COLUMN type_document VARCHAR(50) DEFAULT 'bulletin' AFTER id");
}

$result = $conn->query("SHOW COLUMNS FROM rapports LIKE 'annee'");
if ($result->num_rows == 0) {
    $conn->query("ALTER TABLE rapports ADD COLUMN annee INT(4) DEFAULT 2026 AFTER type_document");
}

$result = $conn->query("SHOW COLUMNS FROM rapports LIKE 'trimestre'");
if ($result->num_rows == 0) {
    $conn->query("ALTER TABLE rapports ADD COLUMN trimestre VARCHAR(10) DEFAULT NULL AFTER annee");
}

echo "Database schema verified and updated successfully.\n";
?>
