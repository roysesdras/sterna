<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/db.php';

// 1. Create projets table
$sql = "CREATE TABLE IF NOT EXISTS projets (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "Table 'projets' created successfully.\n";
} else {
    echo "Error creating table 'projets': " . $conn->error . "\n";
}

// 2. Add projet_id to actualites if it doesn't exist
$checkColumn = "SHOW COLUMNS FROM actualites LIKE 'projet_id'";
$result = $conn->query($checkColumn);
if ($result && $result->num_rows == 0) {
    $alter = "ALTER TABLE actualites ADD COLUMN projet_id INT(11) NULL";
    if ($conn->query($alter) === TRUE) {
        echo "Column 'projet_id' added to 'actualites' successfully.\n";
    } else {
        echo "Error adding column: " . $conn->error . "\n";
    }
} else {
    echo "Column 'projet_id' already exists.\n";
}

// 3. Insert initial projects if table is empty
$res = $conn->query("SELECT COUNT(*) as count FROM projets");
$row = $res->fetch_assoc();
if ($row['count'] == 0) {
    $projets = [
        ['Educ\'Moi', 'educmoi'],
        ['TriPop', 'tripop'],
        ['Camp ECSI', 'camp-ecsi'],
        ['Sang Tabous', 'sang-tabous'],
        ['CSI & MSI', 'vigilance-sensibilisation-et-soutien-contre-les-violences-sexistes-et-sexuelles-vss-c-vss']
    ];
    $stmt = $conn->prepare("INSERT INTO projets (nom, slug) VALUES (?, ?)");
    foreach ($projets as $p) {
        $stmt->bind_param("ss", $p[0], $p[1]);
        $stmt->execute();
    }
    echo "Initial projects inserted.\n";
} else {
    echo "Projects table already populated.\n";
}

echo "Database update complete.\n";
?>
