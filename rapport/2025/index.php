   <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
    ?>
   <!DOCTYPE html>
   <html lang="en" data-bs-theme="auto">

   <head>
       <!-- <script src="../../assets/js/color-modes.js"></script> -->
       <meta charset="UTF-8">
       <!-- meta for SEO -->
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <meta name="robots" content="index, follow">
       <meta name="description" content=" Sterna Africa: Association de solidarité internationale engagée dans le volontariat et le développement communautaire à l'échelle mondiale. Notre action s'étend sur plusieurs pays, œuvrant pour un impact positif et durable au service des communautés.">
       <meta property="og:title" content="Rapport annuel 2025" />
       <meta property="og:description" content="rapport annuel sterna afrca 2025" />
       <!-- Favicons -->
       <link href="../../assets/img/favicon.png" rel="icon">
       <link href="../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">
       <!-- meta for og.graph -->
       <meta property="og:image" content="https://i.postimg.cc/PrKBbtzc/rapp.png" />
       <meta property="og:url" content="https://sternaafrica.org/" />
       <meta property="og:type" content="website" />
       <meta property="og:site_name" content="sternaafrica" />
       <title>sternaafrica: rapport annuels</title>
       <!-- all css -->
       <link rel="canonical" href="https://sternaafrica.org/">
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
       <link rel="stylesheet" href="../../assets/styles.css">
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
       <link rel="stylesheet" href="style.css" />
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

   </head>

   <body>
       <?php //include_once ('../../config/mode_theme.php'); 
        ?>
       <!-- <div class="bg-primary-subtle">
        <h1 class="text-center p-1 comic-neue-bold">Rapport Annuel 2025</h1>
    </div> -->

       <style>
           /* --- Styles existants pour la liseuse --- */
           .rapport-container {
               background: #ffffffef;
               border-radius: 15px;
               padding: 20px;
               box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
               margin-bottom: 100px;
               /* Espace pour ne pas cacher le bas du PDF par le bouton */
           }

           .viewer-section {
               display: flex;
               justify-content: center;

               border-radius: 8px;
               padding: 10px;
               overflow: hidden;
           }

           /* --- Bouton Télécharger Flottant --- */
           .download-fab {
               position: fixed;
               bottom: 30px;
               right: 30px;
               background: #f5b904;
               /* Ton jaune */
               color: #000 !important;
               padding: 15px 25px;
               border-radius: 50px;
               text-decoration: none;
               font-weight: bold;
               box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
               transition: all 0.3s ease;
               z-index: 1050;
               /* Passe au-dessus de tout */
               display: flex;
               align-items: center;
               gap: 10px;
               border: 2px solid white;
           }

           .download-fab:hover {
               background: #305196;
               /* Ton bleu au survol */
               color: white !important;
               transform: translateY(-5px);
               box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
           }

           /* --- Barre de navigation PDF --- */
           .pdf-navigation {
               position: sticky;
               bottom: 20px;
               background: rgba(255, 255, 255, 0.9);
               backdrop-filter: blur(10px);
               padding: 10px 20px;
               border-radius: 50px;
               display: inline-flex;
               align-items: center;
               gap: 15px;
               border: 1px solid #ddd;
               box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
           }
       </style>

       <div class="container my-5">
           <div class="text-center mb-4">
               <h2 class="comic-neue-bold" style="color: #305196;">Rapport Annuel 2025</h2>
               <hr style="width: 50px; border: 2px solid #f5b904; margin: auto;">
           </div>

           <div class="rapport-container">
               <div class="viewer-section">
                   <canvas id="canvas"></canvas>
               </div>

               <div class="text-center mt-3">
                   <div class="pdf-navigation">
                       <button class="btn btn-sm btn-outline-dark rounded-circle" id="prev_page">
                           <i class="bi bi-chevron-left"></i>
                       </button>

                       <span class="comic-neue-regular">
                           Page <input type="number" id="current_page" value="1" style="width: 45px; border:none; background:transparent; text-align:center; font-weight:bold;">
                           sur <span id="page_count">0</span>
                       </span>

                       <button class="btn btn-sm btn-outline-dark rounded-circle" id="next_page">
                           <i class="bi bi-chevron-right"></i>
                       </button>
                   </div>
               </div>
           </div>
       </div>

       <a href="RAPPORT ANNUEL 2025.pdf" class="download-fab comic-neue-bold" download>
           <i class="bi bi-file-earmark-pdf-fill" style="font-size: 1.5rem;"></i>
           <span>Télécharger le Rapport</span>
       </a>

       <?php include_once('../../config/footer_2.php'); ?>
       <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.10.377/build/pdf.min.js"></script>
       <script src="./script.js"></script>
   </body>

   </html>