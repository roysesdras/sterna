<?php
$host = 'db';
$dbname = 'africa_db';
$username = 'root';
$password = 'SoftiP24';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    echo "Columns:\n";
    $stmt = $pdo->query('SHOW COLUMNS FROM actualites');
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo $row['Field'] . "\n";
    }
    
    echo "\nData:\n";
    $stmt = $pdo->query('SELECT * FROM actualites');
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        print_r($row);
    }
} catch(PDOException $e) {
    echo $e->getMessage();
}
