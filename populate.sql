CREATE TABLE IF NOT EXISTS rapports (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT NULL,
    cover_image VARCHAR(255) NULL,
    pdf_link VARCHAR(255) NOT NULL,
    type VARCHAR(50) DEFAULT 'annuel',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO rapports (titre, cover_image, pdf_link, created_at) VALUES 
('Rapport d\'activités 2024', '/wp-content/uploads/2025/06/Capture-decran-2025-06-24-110734.png', '/wp-content/uploads/2025/06/E_D_Rapport-activit_2024_VF.pdf', NOW()),
('Rapport d\'activités 2023', '/wp-content/uploads/2024/07/Image-1.jpeg', '/wp-content/uploads/2024/07/Rapport-dactivites-E.D-2023.pdf', NOW() - INTERVAL 1 SECOND),
('Rapport d\'activités 2022', '/wp-content/uploads/2024/07/Image-2.jpeg', '/wp-content/uploads/2024/07/Rapport-dactivite-E.D-2022.pdf', NOW() - INTERVAL 2 SECOND),
('Rapport d\'activités 2021', '/wp-content/uploads/2024/07/Image-3.jpeg', '/wp-content/uploads/2024/07/Rapport-dactivites-E.D-2021.pdf', NOW() - INTERVAL 3 SECOND),
('Rapport d\'activités 2020', '/wp-content/uploads/2024/07/Image-4.jpeg', '/wp-content/uploads/2024/07/Rapport-dactivites-E.D-2020.pdf', NOW() - INTERVAL 4 SECOND),
('Rapport d\'activités 2019', '/wp-content/uploads/2024/07/Image-5.jpeg', '/wp-content/uploads/2024/07/Rapport-dactivites-E.D-2019.pdf', NOW() - INTERVAL 5 SECOND),
('Rapport financier 2023', '/wp-content/uploads/2024/07/Image-6.jpeg', '/wp-content/uploads/2024/07/2023-Rapport-CAC-sur-les-comptes-annuels.pdf', NOW() - INTERVAL 6 SECOND),
('Rapport financier 2022', '/wp-content/uploads/2024/07/Image-7.jpeg', '/wp-content/uploads/2024/07/Rapport-du-CAC-sur-les-comptes-annuels-de-lexercice-2022-de-lassociation-ED.pdf', NOW() - INTERVAL 7 SECOND),
('Rapport financier 2021', '/wp-content/uploads/2024/07/Image-8.jpeg', '/wp-content/uploads/2024/07/ED-RAPPORT-GENERAL-DU-CAC-2021.pdf', NOW() - INTERVAL 8 SECOND),
('Rapport financier 2020', '/wp-content/uploads/2024/07/Image-9.jpeg', '/wp-content/uploads/2024/07/ED-RAPPORT-GENERAL-DU-CAC-2020.pdf', NOW() - INTERVAL 9 SECOND),
('Rapport financier 2019', '/wp-content/uploads/2024/07/Image-10.jpeg', '/wp-content/uploads/2024/07/ED-RAPPORT-GENERAL-DU-CAC-2019.pdf', NOW() - INTERVAL 10 SECOND),
('Dispositif de suivi évaluation 2022-2023', '/wp-content/uploads/2024/09/DSE-2022_2023_Page_1-724x1024.jpg', '/wp-content/uploads/2024/09/DSE-2022_2023.pdf', NOW() - INTERVAL 11 SECOND),
('Dispositif de suivi évaluation 2021-2022', '/wp-content/uploads/2024/09/DSE-2021_2022_Page_1-724x1024.jpg', '/wp-content/uploads/2024/09/DSE-2021_2022.pdf', NOW() - INTERVAL 12 SECOND),
('Dispositif de suivi évaluation 2020-2021', '/wp-content/uploads/2024/09/DSE-2020_2021_Page_1-724x1024.jpg', '/wp-content/uploads/2024/09/DSE-2020_2021.pdf', NOW() - INTERVAL 13 SECOND);
