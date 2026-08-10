<?php
require_once __DIR__ . '/old/config/db.php';
$stmt = $conn->query("SELECT id, nom, photo, is_volontaire, volontaire_id FROM temoignages");
while($row = $stmt->fetch_assoc()) {
    echo $row['nom'] . " | photo: " . $row['photo'] . " | vol_id: " . $row['volontaire_id'] . "\n";
}
?>
