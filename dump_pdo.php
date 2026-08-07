<?php
try {
    $pdo = new PDO("mysql:host=db;dbname=africa_db;charset=utf8mb4", "root", "SoftiP24");
    $res = $pdo->query("SHOW TABLES");
    echo "Tables:\n";
    while($row = $res->fetch(PDO::FETCH_NUM)) {
        echo "- " . $row[0] . "\n";
        $desc = $pdo->query("DESCRIBE " . $row[0]);
        while($col = $desc->fetch(PDO::FETCH_ASSOC)) {
            echo "  - " . $col['Field'] . " (" . $col['Type'] . ")\n";
        }
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
