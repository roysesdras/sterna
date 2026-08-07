<?php
$host = 'db';
$dbname = 'africa_db';
$user = 'root';
$pass = 'SoftiP24';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "ALTER TABLE rapports 
            ADD COLUMN type_document VARCHAR(50) DEFAULT 'bulletin' AFTER id,
            ADD COLUMN annee INT(4) DEFAULT 2026 AFTER type_document,
            ADD COLUMN trimestre VARCHAR(10) DEFAULT NULL AFTER annee";
    
    $pdo->exec($sql);
    echo "Columns added successfully.\n";
} catch(PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column') !== false) {
        echo "Columns already exist.\n";
    } else {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
?>
