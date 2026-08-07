<?php
require_once __DIR__ . '/config/db.php';

$sql1 = "INSERT INTO rapports (type_document, annee, trimestre, titre, pdf_link) VALUES ('bulletin', 2026, 'T1', 'Bulletin T1 - 2026', '/uploads/rapports/dummy1.pdf')";
$sql2 = "INSERT INTO rapports (type_document, annee, trimestre, titre, pdf_link) VALUES ('bulletin', 2026, 'T2', 'Bulletin T2 - 2026', '/uploads/rapports/dummy2.pdf')";
$sql3 = "INSERT INTO rapports (type_document, annee, trimestre, titre, pdf_link) VALUES ('rapport_annuel', 2025, NULL, 'Rapport Annuel - 2025', '/uploads/rapports/dummy3.pdf')";

$conn->query($sql1);
$conn->query($sql2);
$conn->query($sql3);

echo "Dummy data inserted.\n";
?>
