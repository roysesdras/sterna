<section class="overflow-hidden" id="equipe">
    <div class="max-w-7xl mx-auto px-6 mb-12">
        <h2 class="text-3xl font-black text-sterna-blue uppercase tracking-tighter border-l-8 border-sterna-orange pl-6">
            Le Bureau <br><span class="text-sterna-orange">Sterna Africa</span>
        </h2>
    </div>

    <div class="team-scroll-container">
        <div class="team-track">
            <div class="team-card group">
                <div class="image-wrapper">
                    <img src="https://i.postimg.cc/nhHB3JZB/MADRICK.png" alt="Madrick" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Madrick</p>
                    <p class="role">Président Fondateur</p>
                </div>
            </div>

            <div class="team-card group">
                <div class="image-wrapper">
                    <img src="https://i.postimg.cc/NFmmzG57/HERMINE.png" alt="Hermine" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Hermine</p>
                    <p class="role">Secrétaire Générale</p>
                </div>
            </div>

            <div class="team-card group">
                <div class="image-wrapper">
                    <img src="https://i.postimg.cc/sDCpZWNn/ISMAEL.png" alt="Ismael" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Ismael</p>
                    <p class="role">Chargé des relations extérieurs</p>
                </div>
            </div>

            <div class="team-card group">
                <div class="image-wrapper">
                    <img src="https://i.postimg.cc/ZYd8RHVB/GRACE.png" alt="Grace" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Grace</p>
                    <p class="role">Directrice Executive CI</p>
                </div>
            </div>

            <div class="team-card group">
                <div class="image-wrapper">
                    <img src="https://i.postimg.cc/VL9X96yz/ARNOULD.png" alt="Arnould" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Arnould</p>
                    <p class="role">Directeur Exécutif BJ</p>
                </div>
            </div>

            <div class="team-card group">
                <div class="image-wrapper">
                    <img src="https://i.postimg.cc/DzNGf4GP/SOUWE.png" alt="Souwe" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Souwebatha</p>
                    <p class="role">Coordinatrice Nationale FR</p>
                </div>
            </div>

            <div class="team-card group">
                <div class="image-wrapper">
                    <img src="https://i.postimg.cc/bvrbj9Zv/KONATE.png" alt="Konate" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Konaté</p>
                    <p class="role">Coordinateur National BF</p>
                </div>
            </div>
            
            <div class="team-card group">
                <div class="image-wrapper">
                    <img src="https://i.postimg.cc/rmtrDyCX/VIANNEY.png" alt="Vianney" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Vianney</p>
                    <p class="role">Trésoriere générale</p>
                </div>
            </div>

            <div class="team-card group">
                <div class="image-wrapper">
                    <img src="https://i.postimg.cc/P52ZcRrc/ULRICH.png" alt="Ulrich" class="team-img">
                </div>
                <div class="team-info">
                    <p class="name">Ulrich</p>
                    <p class="role">Resp. Volontaires</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .team-scroll-container {
        position: relative;
        width: 100%;
        /* Effet de fondu sur les bords pour le mode clair */
        -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
        mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
    }

    .team-track {
        display: flex;
        gap: 20px;
        width: max-content;
        animation: scrollTeam 50s linear infinite;
        padding: 20px 0;
    }

    .team-card {
        flex: 0 0 auto;
        width: 250px;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .image-wrapper {
        width: 100%;
        aspect-ratio: 4/5;
        border-radius: 30px;
        overflow: hidden;
        background: #f8fafc;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        margin-bottom: 15px;
        transition: all 0.4s ease;
    }

    .team-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Les photos sont colorées mais douces */
        filter: saturate(0.8);
        transition: all 0.4s ease;
    }

    .team-info .name {
        font-size: 16px;
        font-weight: 900;
        color: #0f277e; /* urunani-blue */
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 4px;
    }

    .team-info .role {
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Hover effects */
    .team-card:hover {
        transform: translateY(-10px);
    }

    .team-card:hover .image-wrapper {
        box-shadow: 0 20px 40px rgba(15, 39, 126, 0.15);
        border: 2px solid #ea750fff; /* urunani-rose pour l'accent */
    }

    .team-card:hover .team-img {
        filter: saturate(1.1);
        transform: scale(1.05);
    }

    @keyframes scrollTeam {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
    }

    .team-track:hover {
        animation-play-state: paused;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const track = document.querySelector(".team-track");
        if (track) {
            const clone = track.innerHTML;
            track.innerHTML += clone; // Duplication pour le scroll infini
        }
    });
</script>