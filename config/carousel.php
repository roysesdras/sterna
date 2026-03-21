<div id="heroStar" class="hero-container">
    <div class="hero-inner">
        <?php
        $isActive = true;
        foreach ($actualites as $actualite):
            // 1. Récupération du lieu
            $lieu = htmlspecialchars($actualite['lieu']);
            $style_dynamique = "color: #94a3b8;"; // Couleur grise par défaut

            // // 2. Attribution de la couleur selon le pays
            // foreach ($pays_styles as $pays => $couleur) {
            //     if (stripos($lieu, $pays) !== false) {
            //         $style_dynamique = $couleur;
            //         break;
            //     }
            // }

            $actualite_link = "https://sternaafrica.org/actualite/" . $actualite['id'];
        ?>
            <div class="hero-item <?php echo $isActive ? 'active' : ''; ?>">
                <div class="hero-image-wrapper">
                    <img src="images/<?php echo $actualite['image']; ?>" class="hero-img" alt="Actu">
                    <div class="hero-overlay"></div>
                </div>

                <div class="hero-content">
                    <div class="bento-badge">Impact Terrain</div>

                    <h1 class="comic-neue-regular">
                        <a href="<?php echo $actualite_link; ?>"><?php echo $actualite['title']; ?></a>
                    </h1>

                    <div class="hero-footer">
                        <span class="location" style="<?php echo $style_dynamique; ?> font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">
                            <i class="fi fi-rr-marker" style="margin-right: 5px;"></i>
                            <?php echo $lieu; ?>
                        </span>

                        <span class="hero-date" style="color: rgba(255,255,255,0.4); font-size: 0.9rem;">
                            <?= date('d M Y', strtotime($actualite['end_date'])) ?>
                        </span>

                        <a href="<?php echo $actualite_link; ?>" class="btn-read">Détails</a>
                    </div>
                </div>
            </div>
        <?php
            $isActive = false;
        endforeach;
        ?>
    </div>
</div>

<style>
    .hero-container {
        position: relative;
        width: 100%;
        height: 90vh;
        /* Presque toute la hauteur de l'écran */
        background: #0A0F14;
        overflow: hidden;
    }

    .hero-item {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 1.5s ease-in-out;
        display: flex;
        align-items: flex-end;
        /* Texte en bas */
        padding: 0 5% 120px 5%;
        /* On laisse de la place pour ton dock en bas */
    }

    .hero-item.active {
        opacity: 1;
        z-index: 10;
    }

    .hero-image-wrapper {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
    }

    .hero-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.6);
        /* Sombre par défaut pour faire ressortir le texte */
        transform: scale(1.05);
        transition: transform 10s linear;
        /* Zoom lent continu très immersif */
    }

    .hero-item.active .hero-img {
        transform: scale(1.15);
    }

    /* Le dégradé 2026 : Noir profond vers transparent */
    .hero-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 60%;
        background: linear-gradient(to top, #0A0F14 10%, rgba(10, 15, 20, 0) 100%);
    }

    /* Le bloc de texte (Style Bento Dark) */
    .hero-content {
        position: relative;
        z-index: 20;
        max-width: 800px;
    }

    .bento-badge {
        background: var(--accent-color, #073776);
        color: #fff;
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        margin-bottom: 20px;
        text-transform: uppercase;
    }

    .hero-content h1 a {
        color: #FFFFFF !important;
        text-decoration: none;
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.1;
        text-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .hero-footer {
        margin-top: 30px;
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .location {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9rem;
    }

    .btn-read {
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 10px 25px;
        border-radius: 30px;
        text-decoration: none;
        backdrop-filter: blur(10px);
        transition: 0.3s;
    }

    .btn-read:hover {
        background: #fff;
        color: #000;
    }

    /* Responsive Mobile */
    @media (max-width: 768px) {
        .hero-container {
            height: 70vh;
        }

        .hero-content h1 a {
            font-size: 1.8rem;
        }

        .hero-item {
            padding-bottom: 150px;
        }
    }

    .location {
        display: flex;
        align-items: center;
        text-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        /* Ombre pour la lisibilité */
        transition: all 0.3s ease;
    }

    .location:hover {
        filter: brightness(1.2);
        /* Le pays s'illumine au survol */
    }
</style>