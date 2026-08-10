<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/db.php';

$stmt = $conn->query("SELECT id, nom, photo, is_volontaire, volontaire_avatar FROM temoignages");
if (!$stmt) {
    echo "Error: " . $conn->error;
} else {
    while($row = $stmt->fetch_assoc()) {
        echo $row['nom'] . " | photo: " . $row['photo'] . " | vol_avatar: " . $row['volontaire_avatar'] . "\n";
    }
}
?>
