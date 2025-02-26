<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
<head><script src="../../assets/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <!-- meta for SEO -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="description" content=" Sterna Africa: Association de solidarité internationale engagée dans le volontariat et le développement communautaire à l'échelle mondiale. Notre action s'étend sur plusieurs pays, œuvrant pour un impact positif et durable au service des communautés.">
    <meta property="og:title" content="Rapport annuel 2024" />
    <meta property="og:description" content="rapport annuel sterna afrca 2024" />
    <!-- Favicons -->
    <link href="../../assets/img/favicon.png" rel="icon">
    <link href="../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- meta for og.graph -->
    <meta property="og:image" content="https://i.postimg.cc/QMDVmBVC/RAPPORT-ANNUEL-2024-compressed-images-0.jpg" />
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
    <?php //include_once ('../../config/mode_theme.php'); ?>
    <?php include_once ('../../config/navbar.php'); ?>
    <!-- <div class="bg-primary-subtle">
        <h1 class="text-center p-1 comic-neue-bold">Rapport Annuel 2024</h1>
    </div> -->
    
    <div class="container mb-4" id="rapport2022">
        <div class="row pt-2">
            <div class="col-md-10">
                <canvas
                    id="canvas"
                    class="
                    d-flex
                    flex-column
                    justify-content-center
                    align-items-center
                    mx-auto
                    "
                    style="max-width: 100%; padding-bottom: 0.2em;">
                </canvas>
                    <div class="mt-2" style="text-align:center;">
                        <a href="RAPPORT ANNUEL 2024.pdf" class="get-started comic-neue-regular" download="rappor-annuel-2024">Télécharger</a>
                    </div>   
            </div>

            <div class="col-md-2">
                <div class="position-sticky" style="top: 2rem">
                    <div class="mt-2">
                    <ul class="
                            nav nav-tabs
                            d-flex
                            justify-content-between
                            align-items-center
                            p-3
                            ">
                                <li class="nav-item" style="text-align:center;">
                                <a
                                    href="#"
                                    class="p-1 border rounded-circle"
                                    id="prev_page"
                                    title=""
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="bottom"
                                >
                                <i class="bi bi-chevron-left"></i></a>

                                <input
                                    type="number"
                                    id="current_page"
                                    value="1"
                                    class="d-inline form-control"
                                />

                                <a
                                    href="#"
                                    class="p-1 border rounded-circle"
                                    id="next_page"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="bottom"
                                    title=""
                                    ><i class="bi bi-chevron-right"></i
                                ></a>

                                <!-- page 1 of 5 
                                Page-->
                                <span id="page_num"></span>
                                /
                                <span id="page_count"></span>
                                </li>  
                        </ul>
                    </div>
                </div>
                
            </div>

        </div>
    </div>

    

    <?php include_once('../../config/footer_2.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.10.377/build/pdf.min.js"></script>
    <script src="./script.js"></script>
</body>
</html>