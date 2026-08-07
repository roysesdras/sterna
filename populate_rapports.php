<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// First create table if not exists
$create_table = "CREATE TABLE IF NOT EXISTS rapports (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT NULL,
    cover_image VARCHAR(255) NULL,
    pdf_link VARCHAR(255) NOT NULL,
    type VARCHAR(50) DEFAULT 'annuel',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($create_table);

$rapports = [
    // Activites
    ['titre' => 'Rapport d\'activités 2024', 'img' => '/wp-content/uploads/2025/06/Capture-decran-2025-06-24-110734.png', 'pdf' => '/wp-content/uploads/2025/06/E_D_Rapport-activit_2024_VF.pdf'],
    ['titre' => 'Rapport d\'activités 2023', 'img' => '/wp-content/uploads/2024/07/Image-1.jpeg', 'pdf' => '/wp-content/uploads/2024/07/Rapport-dactivites-E.D-2023.pdf'],
    ['titre' => 'Rapport d\'activités 2022', 'img' => '/wp-content/uploads/2024/07/Image-2.jpeg', 'pdf' => '/wp-content/uploads/2024/07/Rapport-dactivite-E.D-2022.pdf'],
    ['titre' => 'Rapport d\'activités 2021', 'img' => '/wp-content/uploads/2024/07/Image-3.jpeg', 'pdf' => '/wp-content/uploads/2024/07/Rapport-dactivites-E.D-2021.pdf'],
    ['titre' => 'Rapport d\'activités 2020', 'img' => '/wp-content/uploads/2024/07/Image-4.jpeg', 'pdf' => '/wp-content/uploads/2024/07/Rapport-dactivites-E.D-2020.pdf'],
    ['titre' => 'Rapport d\'activités 2019', 'img' => '/wp-content/uploads/2024/07/Image-5.jpeg', 'pdf' => '/wp-content/uploads/2024/07/Rapport-dactivites-E.D-2019.pdf'],
    
    // Financiers
    ['titre' => 'Rapport financier 2023', 'img' => '/wp-content/uploads/2024/07/Image-6.jpeg', 'pdf' => '/wp-content/uploads/2024/07/2023-Rapport-CAC-sur-les-comptes-annuels.pdf'],
    ['titre' => 'Rapport financier 2022', 'img' => '/wp-content/uploads/2024/07/Image-7.jpeg', 'pdf' => '/wp-content/uploads/2024/07/Rapport-du-CAC-sur-les-comptes-annuels-de-lexercice-2022-de-lassociation-ED.pdf'],
    ['titre' => 'Rapport financier 2021', 'img' => '/wp-content/uploads/2024/07/Image-8.jpeg', 'pdf' => '/wp-content/uploads/2024/07/ED-RAPPORT-GENERAL-DU-CAC-2021.pdf'],
    ['titre' => 'Rapport financier 2020', 'img' => '/wp-content/uploads/2024/07/Image-9.jpeg', 'pdf' => '/wp-content/uploads/2024/07/ED-RAPPORT-GENERAL-DU-CAC-2020.pdf'],
    ['titre' => 'Rapport financier 2019', 'img' => '/wp-content/uploads/2024/07/Image-10.jpeg', 'pdf' => '/wp-content/uploads/2024/07/ED-RAPPORT-GENERAL-DU-CAC-2019.pdf'],
    
    // DSE
    ['titre' => 'Dispositif de suivi évaluation 2022-2023', 'img' => '/wp-content/uploads/2024/09/DSE-2022_2023_Page_1-724x1024.jpg', 'pdf' => '/wp-content/uploads/2024/09/DSE-2022_2023.pdf'],
    ['titre' => 'Dispositif de suivi évaluation 2021-2022', 'img' => '/wp-content/uploads/2024/09/DSE-2021_2022_Page_1-724x1024.jpg', 'pdf' => '/wp-content/uploads/2024/09/DSE-2021_2022.pdf'],
    ['titre' => 'Dispositif de suivi évaluation 2020-2021', 'img' => '/wp-content/uploads/2024/09/DSE-2020_2021_Page_1-724x1024.jpg', 'pdf' => '/wp-content/uploads/2024/09/DSE-2020_2021.pdf']
];

$stmt = $conn->prepare("INSERT INTO rapports (titre, cover_image, pdf_link) VALUES (?, ?, ?)");
foreach ($rapports as $r) {
    // only insert if not exists
    $check = $conn->prepare("SELECT id FROM rapports WHERE titre = ?");
    $check->bind_param("s", $r['titre']);
    $check->execute();
    $res = $check->get_result();
    if ($res->num_rows == 0) {
        $stmt->bind_param("sss", $r['titre'], $r['img'], $r['pdf']);
        $stmt->execute();
    }
}
echo "Populated successfully";
?>
