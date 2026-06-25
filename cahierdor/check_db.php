<?php
require 'includes/db.php';
$stmt = $pdo->query("SELECT e.*, u.name, u.avatar FROM entries e JOIN users u ON e.user_id = u.id ORDER BY e.entry_date ASC, e.id DESC");
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo count($res) . " entries.\n";
print_r($res);
