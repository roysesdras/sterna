<?php
require_once '../inclusion/db.php';

$stmt = $pdo->query("SELECT * FROM examens ORDER BY id DESC");
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$questions) {
    echo "<p class='text-gray-500'>Aucune question enregistrée pour le moment.</p>";
    exit;
}

echo "<div class='overflow-x-auto'><table class='min-w-full table-auto text-sm text-left border border-gray-300'>";
echo "<thead><tr class='bg-gray-100'>";
echo "<th class='px-4 py-2'>Question</th><th class='px-4 py-2'>Type</th><th class='px-4 py-2'>Options</th><th class='px-4 py-2'>Image</th><th class='px-4 py-2'>Actions</th>";
echo "</tr></thead><tbody>";

foreach ($questions as $q) {
    echo "<tr class='border-t'>";
    echo "<td class='px-4 py-2'>" . htmlspecialchars($q['question_text']) . "</td>";
    echo "<td class='px-4 py-2'>" . htmlspecialchars($q['type_question']) . "</td>";
    echo "<td class='px-4 py-2'>" . htmlspecialchars($q['options']) . "</td>";
    echo "<td class='px-4 py-2'>";
    if ($q['image']) {
        echo "<img src='./uploads/" . htmlspecialchars($q['image']) . "' alt='Image' class='h-12'>";
    } else {
        echo "-";
    }
    echo "</td>";
    echo "<td class='px-4 py-2 space-x-2'>";

    echo '<button onclick="ouvrirModal('
    . htmlspecialchars(json_encode($q['id']), ENT_QUOTES) . ', '
    . htmlspecialchars(json_encode($q['question_text']), ENT_QUOTES) . ', '
    . htmlspecialchars(json_encode($q['type_question']), ENT_QUOTES) . ', '
    . htmlspecialchars(json_encode($q['options']), ENT_QUOTES)
    . ')" class="text-blue-600 hover:underline">Modifier</button>';


    echo "<button onclick='supprimerQuestion(" . $q['id'] . ")' class='text-red-600 hover:underline'>Supprimer</button>";

    // Tu peux aussi ajouter un bouton modifier ici si besoin
    echo "</td>";
    echo "</tr>";
}
echo "</tbody></table></div>";
?>
