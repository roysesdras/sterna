<section class="partners-dark-wrap py-5">
    <div class="partner-carousel">
        <div class="partner-track">
            <div class="partner-logos">
                <img src="https://i.ibb.co/NKRx7N1/logos-1.png" alt="Logo 1">
                <img src="https://ethique-sur-etiquette.org/images/logo.png" alt="Logo 5">
                <img src="https://sgdf.fr/wp-content/themes/sgdf/assets/images/logos/SGDF_logo_CMJN_horizontal.png" alt="Logo 29">
                <img src="https://i.ibb.co/N2Z9H006/logo-ASA.png" alt="Logo 14">
                <img src="https://i.ibb.co/Vx8181M/logos-16.png" alt="Logo 16">
                <img src="https://i.ibb.co/KpXspt49/uranani-removebg-preview.png" alt="Logo 17">
                <img src="https://i.ibb.co/zQ3fDLN/logos-18.png" alt="Logo 18">
                <img src="https://i.ibb.co/dwYkf6bx/embassade-removebg-preview.png" alt="Logo 19">
                <img src="https://iteco.be/squelettes/style/images/logoIteco.png" alt="Logo 20">
                <img src="https://culturekonnect.com/wp-content/uploads/2024/05/Culture-Konnect-Couleurs-transparant.png" alt="Logo 26">
                <img src="https://scd.asso.fr/wp-content/themes/theme-scd/images/logo-scd.png" alt="Logo 35">
            </div>
            <div class="partner-logos">
                <img src="https://i.ibb.co/NKRx7N1/logos-1.png" alt="Logo 1">
                <img src="https://ethique-sur-etiquette.org/images/logo.png" alt="Logo 5">
                <img src="https://sgdf.fr/wp-content/themes/sgdf/assets/images/logos/SGDF_logo_CMJN_horizontal.png" alt="Logo 29">
                <img src="https://i.ibb.co/N2Z9H006/logo-ASA.png" alt="Logo 14">
                <img src="https://i.ibb.co/Vx8181M/logos-16.png" alt="Logo 16">
                <img src="https://i.ibb.co/KpXspt49/uranani-removebg-preview.png" alt="Logo 17">
                <img src="https://i.ibb.co/zQ3fDLN/logos-18.png" alt="Logo 18">
                <img src="https://i.ibb.co/dwYkf6bx/embassade-removebg-preview.png" alt="Logo 19">
                <img src="https://iteco.be/squelettes/style/images/logoIteco.png" alt="Logo 20">
                <img src="https://culturekonnect.com/wp-content/uploads/2024/05/Culture-Konnect-Couleurs-transparant.png" alt="Logo 26">
                <img src="https://scd.asso.fr/wp-content/themes/theme-scd/images/logo-scd.png" alt="Logo 35">
            </div>
        </div>
    </div>
</section>

<style>
    .partners-dark-wrap {
        background: #0A0F14;
        padding: 20px 0;
        overflow: hidden;
    }

    .partner-carousel {
        position: relative;
        width: 100%;
        /* Masquage dégradé sur les côtés pour l'effet de disparition */
        -webkit-mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
        mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
    }

    .partner-track {
        display: flex;
        width: max-content;
        animation: scrollLogos 40s linear infinite;
    }

    .partner-logos {
        display: flex;
        align-items: center;
    }

    .partner-logos img {
        height: 65px;
        /* Taille un peu plus subtile et élégante */
        width: auto;
        margin: 0 40px;
        object-fit: contain;
        /* L'effet magique : logos en gris clair par défaut */
        filter: grayscale(100%) brightness(1.5) opacity(0.6);
        transition: all 0.4s ease;
    }

    /* Au survol d'un logo précis */
    .partner-logos img:hover {
        filter: grayscale(0%) brightness(1) opacity(1);
        transform: scale(1.1);
    }

    /* Animation de scroll */
    @keyframes scrollLogos {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-50%);
        }
    }

    /* Pause au survol du rail complet */
    .partner-track:hover {
        animation-play-state: paused;
    }

    /* Adaptation Mobile */
    @media (max-width: 768px) {
        .partner-logos img {
            height: 45px;
            margin: 0 20px;
        }

        .partner-track {
            animation-duration: 25s;
            /* Un peu plus rapide sur petit écran */
        }
    }
</style>