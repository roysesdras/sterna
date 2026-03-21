<div class="container-fluid mt-2" id="presse">
    <div class="horizontal-scroll-wrapper py-4">

        <div class="polaroid-card rotate-left">
            <a href="https://france-volontaires.org/actualite/temoignage/dominique-et-patrice-retraites-et-engages-dans-un-chantier-de-solidarite-internationale/" target="_blank" class="polaroid-link">
                <div class="polaroid-frame">
                    <img src="https://i.postimg.cc/ydTmppJp/5.png" class="polaroid-img">
                </div>
                <div class="polaroid-caption comic-neue-regular">
                    <p style="font-size: 16px;">🌍 "Une aventure humaine et solidaire en Côte d'Ivoire..." - France Volontaires</p>
                </div>
            </a>
        </div>

        <div class="polaroid-card rotate-right">
            <a href="https://france-volontaires.org/actualite/temoignage/samantha-benevole-dans-une-association-defendant-les-droits-des-enfants-en-cote-divoire/" target="_blank" class="polaroid-link">
                <div class="polaroid-frame">
                    <img src="https://i.postimg.cc/ydTmppJp/5.png" class="polaroid-img">
                </div>
                <div class="polaroid-caption comic-neue-regular">
                    <p style="font-size: 16px;">📢 "Le parcours inspirant de Samantha..." - Témoignage Bénévole</p>
                </div>
            </a>
        </div>

        <div class="polaroid-card rotate-left">
            <a href="https://www.gralon.net/mairies-france/rhone/association-sterna-africa-villeurbanne_W691109313.htm" target="_blank" class="polaroid-link">
                <div class="polaroid-frame">
                    <img src="https://i.postimg.cc/ydTmppJp/5.png" class="polaroid-img">
                </div>
                <div class="polaroid-caption comic-neue-regular">
                    <p style="font-size: 16px;">Sterna Africa association de solidarité internationale basée à Villeurbanne...</p>
                </div>
            </a>
        </div>

        <div class="polaroid-card rotate-right">
            <a href="https://www.radsi.org/rencontres-sterna-africa-2025" target="_blank" class="polaroid-link">
                <div class="polaroid-frame">
                    <img src="https://i.postimg.cc/ydTmppJp/5.png" class="polaroid-img">
                </div>
                <div class="polaroid-caption comic-neue-regular">
                    <p style="font-size: 16px;">Février 2025 à Bordeaux, Madrick rencontre des membres du réseau Festisol...</p>
                </div>
            </a>
        </div>

        <div class="polaroid-card rotate-left">
            <a href="https://www.helloasso.com/associations/sterna-africa" target="_blank" class="polaroid-link">
                <div class="polaroid-frame">
                    <img src="https://i.postimg.cc/ydTmppJp/5.png" class="polaroid-img">
                </div>
                <div class="polaroid-caption comic-neue-regular">
                    <p style="font-size: 16px;">Sterna Africa transforme des vies en défendant les droits humains, en...</p>
                </div>
            </a>
        </div>

        <div class="polaroid-card rotate-left">
            <a href="https://www.festivaldessolidarites.org/acteurs/association-sterna-africa-14830/" target="_blank" class="polaroid-link">
                <div class="polaroid-frame">
                    <img src="https://i.postimg.cc/ydTmppJp/5.png" class="polaroid-img">
                </div>
                <div class="polaroid-caption comic-neue-regular">
                    <p style="font-size: 16px;">pour un monde plus juste et solidaire ! 🌍💫 STERNA Africa, une associat... </p>
                </div>
            </a>
        </div>

    </div>
</div>

<style>
    /* Wrapper de scroll horizontal (Réutilisable) */
    .horizontal-scroll-wrapper {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 25px;
        /* Espace plus grand pour les polaroids */
        padding-left: 10px;
        padding-right: 10px;
        /* Ta barre de défilement personnalisée */
        scrollbar-width: thin;
        scrollbar-color: #888 #f1f1f1;
        -webkit-overflow-scrolling: touch;
    }

    .horizontal-scroll-wrapper::-webkit-scrollbar {
        height: 8px;
    }

    .horizontal-scroll-wrapper::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    /* .horizontal-scroll-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
    } */


    /* STYLE POLAROID */
    .polaroid-card {
        flex: 0 0 auto;
        width: 260px;
        border-radius: 18px;
        background: radial-gradient(circle at top right, #1a1f25 0%, #0a0f14 100%);
        /* Le secret du polaroid : grosse marge blanche en bas */
        padding: 10px 10px 35px 10px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        transition: all 0.3s ease-in-out;
        position: relative;
    }

    /* L'image dans le cadre */
    .polaroid-img {
        width: 100%;
        height: 200px;
        /* Hauteur fixe carrée */
        object-fit: cover;
    }

    /* Le texte en bas (comme écrit à la main) */
    .polaroid-caption p {
        margin: 15px 0 0 0;
        text-align: center;
        font-size: 14px;
        color: #94a3b8;
        line-height: 1.3;
        /* Limite le texte à 3 lignes pour garder le look */
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .polaroid-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    /* Effets de rotation et survol */
    .rotate-left {
        transform: rotate(-2deg);
    }

    .rotate-right {
        transform: rotate(2deg);
    }

    .polaroid-card:hover {
        transform: rotate(0deg) scale(1.03);
        /* Se redresse et grossit un peu */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        z-index: 2;
    }
</style>