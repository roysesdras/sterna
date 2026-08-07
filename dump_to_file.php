<?php
$host = 'db';
$dbname = 'africa_db';
$username = 'root';
$password = 'SoftiP24';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $stmt = $pdo->query('SHOW COLUMNS FROM actualites');
    $cols = "";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $cols .= $row['Field'] . "\n";
    }
    file_put_contents('/var/www/sternaafrica.org/db_cols.txt', $cols);
} catch(PDOException $e) {
    file_put_contents('/var/www/sternaafrica.org/db_cols.txt', $e->getMessage());
}
