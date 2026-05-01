<?php
// On garde juste la connexion ici pour d'autres besoins si nécessaire
$conn = new mysqli('db', 'root', 'SoftiP24', 'africa_db');
?>
<!DOCTYPE html>
<html lang="fr" class="bg-gray-200">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal de Bord : Sterna Africa</title>
    <!-- Favicons -->
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="icon">
    <link href="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" rel="apple-touch-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        
        /* Smooth transition pour l'apparition des nouvelles cartes */
        .fade-in-card {
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom Scrollbar pour le mode sombre */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #e2e8f0;
        }

        ::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 10px;
        }
    </style>
</head>

<body class="text-gray-700 antialiased">
    <?php include_once('../config/nav.php'); ?>

    <main class="container mx-auto px-4 pt-5 pb-20">
        <div class="mb-12 border-l-4 border-[#ea750fff] pl-6">
            <h1 class="comic-neue text-4xl md:text-5xl font-bold text-[#0f277e] mb-2">
                JOURNAL DE <span class="text-[#ea750fff]">BORD</span>
            </h1>
            <p class="text-gray-600 max-w-xl">
                Suivez nos missions, nos victoires et le quotidien de nos volontaires sur le terrain.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="actualites-container">
        </div>

        <div class="text-center mt-16">
            <button id="load-more" class="group relative inline-flex items-center justify-center px-8 py-3 font-bold text-white transition-all duration-200 bg-[#0f277e] hover:bg-blue-900 font-pj rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0f277e]">
                <span class="flex items-center gap-2">
                    <i class="fas fa-plus-circle text-[#ea750fff] group-hover:rotate-180 transition-transform duration-500"></i>
                    Afficher plus d'actualités
                </span>
            </button>
        </div>
    </main>

    <?php include_once('../config/footer_2.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let offset = 0;
        let limit = 12;

        function loadActualites() {
            const btn = $("#load-more");
            btn.addClass('opacity-50 cursor-not-allowed').html('<i class="fas fa-spinner fa-spin"></i> Chargement...');

            $.ajax({
                url: "recharge_actualite.php",
                type: "GET",
                data: {
                    offset: offset,
                    limit: limit
                },
                success: function(data) {
                    if (data.trim() === "no_more") {
                        btn.fadeOut();
                    } else {
                        // On ajoute les nouvelles cartes avec une petite animation
                        const $newItems = $(data).addClass('fade-in-card');
                        $("#actualites-container").append($newItems);
                        offset += limit;
                        btn.removeClass('opacity-50 cursor-not-allowed').html('<span class="flex items-center gap-2"><i class="fas fa-plus-circle text-[#ea750fff]"></i> Afficher plus d\'actualités</span>');
                    }
                }
            });
        }

        $(document).ready(function() {
            loadActualites();
            $("#load-more").click(function() {
                loadActualites();
            });
        });
    </script>
</body>

</html>