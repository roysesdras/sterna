<?php
session_start();

// Vérifie si l'utilisateur est un administrateur
if (!isset($_SESSION['admin'])) {
    header('Location: https://sternaafrica.org/admin/admin_login.php');
    exit();
}

// Vérifie que le fichier FPDF existe
if (!file_exists('../fpdf/fpdf.php')) {
    die("La bibliothèque FPDF est manquante. Veuillez vous assurer que fpdf.php est dans le répertoire fpdf.");
}

// Inclure la bibliothèque FPDF
require('../fpdf/fpdf.php');

// Inclure le fichier de connexion à la base de données
require_once('../config/db.php');

// Vérifie si un ID de mission est fourni
if (isset($_GET['id'])) {
    $mission_id = intval($_GET['id']); // Sécuriser l'ID en le convertissant en entier

    // Préparer et exécuter la requête SQL pour récupérer le titre de la mission
    $stmt = $conn->prepare("SELECT title FROM missions WHERE id = ?");
    $stmt->bind_param("i", $mission_id);
    $stmt->execute();
    $stmt->bind_result($mission_title);
    $stmt->fetch();
    $stmt->close();

    if (!$mission_title) {
        die("Mission non trouvée.");
    }

    // Préparer et exécuter la requête SQL pour récupérer les volontaires
    $stmt = $conn->prepare("SELECT * FROM volunteers WHERE mission_id = ?");
    $stmt->bind_param("i", $mission_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Définir la classe PDF étendue depuis FPDF
    class PDF extends FPDF
    {
        protected $missionTitle;

        // Méthode pour définir le titre de la mission
        function setMissionTitle($title)
        {
            $this->missionTitle = $title;
        }

        // Méthode pour l'en-tête du PDF
        function Header()
        {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Liste des volontaires pour la mission ' . $this->missionTitle, 0, 1, 'C');
            $this->Ln(10);
        }

        // Méthode pour le pied de page du PDF
        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Association Sterna Africa | Page ' . $this->PageNo(), 0, 0, 'C');
        }
    }

    // Création d'une instance de la classe PDF
    $pdf = new PDF();
    $pdf->setMissionTitle($mission_title); // Définir le titre de la mission dans le PDF
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    // En-tête des colonnes du tableau dans le PDF
    $pdf->Cell(15, 10, 'ID', 1);
    $pdf->Cell(30, 10, 'Prénom', 1);
    $pdf->Cell(30, 10, 'Nom', 1);
    $pdf->Cell(50, 10, 'Email', 1);
    $pdf->Cell(35, 10, 'Téléphone', 1);
    $pdf->Cell(30, 10, 'Adresse', 1);
    $pdf->Ln();

    // Boucle pour récupérer et afficher les données des volontaires
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(15, 10, $row['id'], 1);
        $pdf->Cell(30, 10, $row['first_name'], 1);
        $pdf->Cell(30, 10, $row['last_name'], 1);
        $pdf->Cell(50, 10, $row['email'], 1);
        $pdf->Cell(35, 10, $row['phone'], 1);
        $pdf->Cell(30, 10, $row['address'], 1);
        $pdf->Ln();
    }

    // Nettoyer le tampon de sortie et générer le PDF pour téléchargement
    ob_end_clean();
    $pdf->Output('D', 'volunteers_mission_' . $mission_id . '.pdf');
    exit();
} else {
    echo "ID de mission invalide.";
}

$conn->close();
?>
