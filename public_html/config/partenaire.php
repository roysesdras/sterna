<style>
        /* Style pour la section des partenaires */
        .partner-section {
            overflow-x: auto; /* Barre de défilement horizontale */
            white-space: nowrap; /* Forcer tout le contenu à s'afficher sur une seule ligne */
            scroll-behavior: smooth; /* Permet un défilement fluide */
        }

        /* Style pour les images */
        .partner-section img {
            display: inline-block;
            width: 150px; /* Ajustez la taille des images selon vos besoins */
            margin-right: 20px; /* Espace entre les images */
        }

        /* Cachez la barre de défilement si vous voulez la cacher (facultatif) */
        .partner-section::-webkit-scrollbar {
            display: none;
        }

        .partner-section {
            -ms-overflow-style: none;  /* Internet Explorer 10+ */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body>

<h3 class="mb-4 fst-italic border-bottom comic-neue-bold"><i class="fa-regular fa-handshake"></i>&nbsp; Nos Partenaires</h3>

<section class="partner-section" id="partnerCarousel">
    <img src="https://i.ibb.co/NKRx7N1/logos-1.png" alt="Logo 1">
    <img src="https://ethique-sur-etiquette.org/images/logo.png" alt="Logo 5">
    <img src="https://sgdf.fr/wp-content/themes/sgdf/assets/images/logos/SGDF_logo_CMJN_horizontal.png" alt="Logo 29">
    <img src="https://i.ibb.co/N2Z9H006/logo-ASA.png" alt="Logo 14">
    <img src="https://i.ibb.co/Vx8181M/logos-16.png" alt="Logo 16">

    <img src="https://i.ibb.co/KpXspt49/uranani-removebg-preview.png" alt="Logo 17">
    <img src="https://i.ibb.co/zQ3fDLN/logos-18.png" alt="Logo 18">
    <img src="https://i.ibb.co/dwYkf6bx/embassade-removebg-preview.png" alt="Logo 19">
    <img src="https://iteco.be/squelettes/style/images/logoIteco.png" alt="Logo 20">
    <img src="https://i.ibb.co/gyhWZ33/logos-23.png" alt="Logo 23">

    <img src="https://i.ibb.co/xfkyG7h/logos-24.png" alt="Logo 24">
    <img src="https://i.ibb.co/ydBKycG/logos-25.png" alt="Logo 25">
    <img src="https://culturekonnect.com/wp-content/uploads/2024/05/Culture-Konnect-Couleurs-transparant.png" alt="Logo 26">
    <img src="https://i.ibb.co/6rzzmXz/logos-27.png" alt="Logo 27">

    <img src="https://i.ibb.co/C5hXY4R4/katalizo-removebg-preview.png" alt="Logo 28">
    <img src="https://i.ibb.co/pQMxtPQ/logos-30.png" alt="Logo 30">
    <img src="https://i.ibb.co/wwH9z3H/logos-31.png" alt="Logo 31">
    <img src="https://i.ibb.co/LzQRWxZV/cetri-removebg-preview.png" alt="Logo 32">
    <img src="https://i.ibb.co/ch3zNRNW/mobil-removebg-preview.png" alt="Logo 29">

    <img src="https://i.ibb.co/gZNMY5fV/rjuc-removebg-preview.png" alt="Logo 29">
    <img src="https://scd.asso.fr/wp-content/themes/theme-scd/images/logo-scd.png" alt="Logo 29">
    <img src="https://i.ibb.co/S7ZfpwYv/reseau-mondial-removebg-preview.png" alt="Logo 29">
    <img src="https://www.lp-lomet.fr/static/assets/imgs/logo.png" alt="Logo 29">
    <img src="https://i.ibb.co/kVH6tyRj/rijf-removebg-preview.png" alt="Logo 29">

    <img src="https://i.ibb.co/Y7gQNwhR/cour-Circuit-removebg-preview.png" alt="Logo 29">
    <img src="https://i.ibb.co/M56gk6Jx/alternative-removebg-preview.png" alt="Logo 29">
    <img src="https://i.ibb.co/XrJ2jstY/wear-removebg-preview.png" alt="Logo 29">

    
    <!-- Ajoutez tous les logos ici -->
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.getElementById('partnerCarousel');
        const content = container.innerHTML; // Récupérer le contenu original

        // Duplication du contenu pour simuler un défilement infini
        container.innerHTML += content;

        let scrollSpeed = 2; // Vitesse du défilement
        let scrollInterval;

        function startScrolling() {
            scrollInterval = setInterval(() => {
                container.scrollLeft += scrollSpeed;

                // Si on atteint la moitié, on revient au début sans transition visible
                if (container.scrollLeft >= container.scrollWidth / 2) {
                    container.scrollLeft = 0;
                }
            }, 20); // Fréquence d'actualisation
        }

        function stopScrolling() {
            clearInterval(scrollInterval);
        }

        // Démarrer le défilement au chargement
        startScrolling();

        // Pause au survol pour éviter un défilement involontaire
        container.addEventListener('mouseenter', stopScrolling);
        container.addEventListener('mouseleave', startScrolling);
    });
</script>
