<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php'; // Connexion à la base de données

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 5;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;

$sql = "SELECT * FROM actualites ORDER BY start_date DESC LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($actualite = $result->fetch_assoc()) {
        $description_clean = strip_tags($actualite['description']);
        $description_short = mb_strlen($description_clean) > 100 ? mb_substr($description_clean, 0, 100) . "..." : $description_clean;

        $date_debut = $actualite['start_date'] ? date('d/m/y', strtotime($actualite['start_date'])) : '-';
        $date_fin = $actualite['end_date'] ? date('d/m/y', strtotime($actualite['end_date'])) : '-';

        echo "<tr>";
        echo "<td class='text-center'>{$actualite['id']}</td>";
        echo "<td class='fw-bold'>{$actualite['title']}</td>";
        echo "<td class='text-muted small'>{$description_short}</td>";
        echo "<td class='text-center'>{$date_debut}</td>";
        echo "<td class='text-center'>{$date_fin}</td>";

        $img_path = "/images/{$actualite['image']}";
        echo "<td class='text-center'><img src='{$img_path}' alt='Img' class='thumbnail border'></td>";

        echo "<td class='text-center'>";
        echo "<div class='btn-group' role='group'>";
        echo "<a href='admin_edit_actualite.php?id={$actualite['id']}' class='btn btn-warning btn-sm' title='Modifier'><i class='bi bi-pencil-square'></i></a>";
        echo "<a href='admin_delete_actualite.php?id={$actualite['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Êtes-vous sûr ?');\" title='Supprimer'><i class='bi bi-trash'></i></a>";
        echo "</div>";
        echo "</td>";
        echo "</tr>";
    }
}

$stmt->close();
$conn->close();
?>
