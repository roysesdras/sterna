<section class="py-6" id="equipe">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 max-w-5xl mx-auto">

        <!-- Membre 1 -->
            <div class="team-card group">
                <div class="image-wrapper">
                    <img loading="lazy" decoding="async" src="/assets/img/external/bureau_membre_9.png" alt="Membre 1" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Madrick TONAKAMBIO</p>
                    <p class="role">Président Fondateur</p>
                </div>
            </div>

            <!-- Membre 2 -->
            <div class="team-card group">
                <div class="image-wrapper">
                    <img loading="lazy" decoding="async" src="/assets/img/external/bureau_membre_1.png" alt="Membre 2" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Hermine AGBODAMAKOU</p>
                    <p class="role">Secrétaire Générale</p>
                </div>
            </div>

            <!-- Membre 3 -->
            <div class="team-card group">
                <div class="image-wrapper">
                    <img loading="lazy" decoding="async" src="/assets/img/external/bureau_membre_10.png" alt="Membre 3" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Mireille Vianney TEMOE</p>
                    <p class="role">Trésorière Générale</p>
                </div>
            </div>

            <!-- Membre 4 -->
            <div class="team-card group">
                <div class="image-wrapper">
                    <img loading="lazy" decoding="async" src="/assets/img/external/bureau_membre_7.png" alt="Membre 4" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Ismael OUATARA</p>
                    <p class="role">Chargé des relations extérieurs</p>
                </div>
            </div>

            <!-- Membre 5 -->
            <div class="team-card group">
                <div class="image-wrapper">
                    <img loading="lazy" decoding="async" src="/assets/img/external/bureau_membre_6.png" alt="Membre 5" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Ulriche Yapi ESSE</p>
                    <p class="role">Responsable des Volontaires</p>
                </div>
            </div>

            <!-- Membre 6 -->
            <div class="team-card group">
                <div class="image-wrapper">
                    <img loading="lazy" decoding="async" src="/assets/img/external/bureau_membre_2.png" alt="Membre 6" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Grâce Naomi KOUAME</p>
                    <p class="role">Directrice Executive Côte d'Ivoire</p>
                </div>
            </div>
            
            <!-- Membre 7 -->
            <div class="team-card group">
                <div class="image-wrapper">
                    <img loading="lazy" decoding="async" src="/assets/img/external/bureau_membre_4.png" alt="Membre 7" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Arlould BOGNON</p>
                    <p class="role">Directeur Executif Bénin</p>
                </div>
            </div>

            <!-- Membre 8 -->
            <div class="team-card group">
                <div class="image-wrapper">
                    <img loading="lazy" decoding="async" src="/assets/img/external/bureau_membre_3.png" alt="Membre 8" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Julie AMEGBOR</p>
                    <p class="role">Coordinatrice Sterna Africa TOGO</p>
                </div>
            </div>

            <!-- Membre 9 -->
            <div class="team-card group">
                <div class="image-wrapper">
                    <img loading="lazy" decoding="async" src="/assets/img/external/bureau_membre_5.png" alt="Membre 9" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Mathilde Théau-Audin</p>
                    <p class="role">Chargée de mission Sterna Africa Bordeaux</p>
                </div>
            </div>

            <!-- Membre 10 -->
            <div class="team-card group">
                <div class="image-wrapper">
                    <img loading="lazy" decoding="async" src="/assets/img/external/bureau_membre_8.png" alt="Membre 10" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Souwébath ASHANTI</p>
                    <p class="role">Coordinatrice nationale France</p>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
    .team-card {
        text-align: center;
        transition: all 0.35s cubic-bezier(0.25, 1, 0.5, 1);
    }

    .image-wrapper {
        width: 100%;
        aspect-ratio: 1 / 1;
        border-radius: 10px; /* Forme carrée avec coins arrondis à 10px */
        overflow: hidden;
        /* background: rgba(255, 255, 255, 0.08); /* Effet verre transparent pour s'adapter au fond bleu */
        /* border: 1px solid rgba(255, 255, 255, 0.15); */
        /* backdrop-filter: blur(4px); */
        /* box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); */
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
        transition: all 0.35s ease;
    }

    .team-img {
        width: 100%;
        height: 100%;
        object-fit: contain; /* Conserve le détourage sans fond et les proportions sans déformation */
        transition: transform 0.35s ease;
    }

    .team-info .name {
        font-size: 15px;
        font-weight: 800;
        color: #ffffff; /* Texte blanc lisible sur fond bleu */
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .team-info .role {
        font-size: 12px;
        font-weight: 600;
        color: #cbd5e1; /* Gris bleu clair lisible sur fond bleu */
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    /* --- EFFETS ET COULEURS AU SURVOL (HOVER) --- */
    .team-card:hover {
        transform: translateY(-6px);
    }

    .team-card:hover .image-wrapper {
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.25);
        border-color: #ea750f;                  /* <-- MODIFIER ICI : Couleur de la bordure au survol */
        background: rgba(236, 219, 154, 0.12); /* <-- MODIFIER ICI : Couleur/transparence du fond au survol */
    }

    .team-card:hover .name {
        color: #facc15;                         /* <-- MODIFIER ICI : Couleur du nom/texte au survol */
    }

    .team-card:hover .team-img {
        transform: scale(1.05);
    }
</style>