<?php
require_once '../config/db.php'; // Connexion à la base de données

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 1; // Début après la première actualité
$limit = 1; // Nombre d'actualités à charger à chaque fois

$sql = "SELECT * FROM actualites ORDER BY start_date DESC LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

while ($actualite = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$actualite['id']}</td>";
    echo "<td>{$actualite['title']}</td>";
    echo "<td class='description'>" . substr($actualite['description'], 0, 450) . "...</td>"; // Tronquer la description
    echo "<td>" . date('d/m/y', strtotime($actualite['start_date'])) . "</td>";
    echo "<td>" . date('d/m/y', strtotime($actualite['end_date'])) . "</td>";
    echo "<td><img src='../images/{$actualite['image']}' alt='Image' class='thumbnail'></td>";
    echo "<td>";
    echo "<a href='admin_edit_actualite.php?id={$actualite['id']}' class='btn btn-warning btn-sm'><i class='bi bi-pencil-square'></i></a> ";
    echo "<a href='admin_delete_actualite.php?id={$actualite['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Êtes-vous sûr ?');\"><i class='bi bi-trash'></i></a>";
    echo "</td>";
    echo "</tr>";
}

$stmt->close();
$conn->close();
?>
