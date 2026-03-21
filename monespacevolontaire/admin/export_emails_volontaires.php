<?php
// Connexion à la base de données
require_once '../inclusion/db.php'; // Adapter selon ton fichier de connexion PDO

// Requête : récupérer les emails des volontaires ET responsables
$stmt = $pdo->query("
    SELECT email 
    FROM users 
    WHERE 
        LOWER(role) IN ('volontaire', 'responsable')
        AND email IS NOT NULL
        AND email != ''
");

$emails = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Définir les en-têtes pour le téléchargement CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="emails_volontaires.csv"');

// Ouvrir la sortie standard
$output = fopen('php://output', 'w');

// Écrire l'en-tête du CSV
fputcsv($output, ['email']);

// Écrire les lignes
foreach ($emails as $row) {
    fputcsv($output, [$row['email']]);
}

// Fermer la sortie
fclose($output);
exit;
