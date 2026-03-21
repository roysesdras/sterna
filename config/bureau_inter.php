<section class="team-section-dark py-3">
    <div class="mad-items-container">
        <div class="mad-track">
            <div class="mad"><img src="https://i.postimg.cc/nhHB3JZB/MADRICK.png" alt="Madrick" class="photo"></div>
            <div class="mad"><img src="https://i.postimg.cc/NFmmzG57/HERMINE.png" alt="Hermine" class="photo"></div>
            <div class="mad"><img src="https://i.postimg.cc/sDCpZWNn/ISMAEL.png" alt="Ismael" class="photo"></div>
            <div class="mad"><img src="https://i.postimg.cc/ZYd8RHVB/GRACE.png" alt="Grace" class="photo"></div>
            <div class="mad"><img src="https://i.postimg.cc/VL9X96yz/ARNOULD.png" alt="Arnould" class="photo"></div>
            <div class="mad"><img src="https://i.postimg.cc/DzNGf4GP/SOUWE.png" alt="Souwe" class="photo"></div>
            <div class="mad"><img src="https://i.postimg.cc/bvrbj9Zv/KONATE.png" alt="Konate" class="photo"></div>
            <div class="mad"><img src="https://i.postimg.cc/rmtrDyCX/VIANNEY.png" alt="Vianney" class="photo"></div>
            <div class="mad"><img src="https://i.postimg.cc/P52ZcRrc/ULRICH.png" alt="Ulrich" class="photo"></div>
        </div>
    </div>
</section>

<style>
    .team-section-dark {
        background: #0A0F14;
        overflow: hidden;
    }

    .mad-items-container {
        position: relative;
        width: 100%;
        /* Création du fondu transparent sur les côtés */
        -webkit-mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
        mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
    }

    .mad-track {
        display: flex;
        gap: 30px;
        /* Plus d'espace pour laisser respirer les visages */
        width: max-content;
        animation: scrollTeam 40s linear infinite;
    }

    .mad {
        flex: 0 0 auto;
        width: 250px;
        /* Taille optimisée */
        filter: grayscale(40%) brightness(0.8);
        transition: all 0.5s ease;
        position: relative;
    }

    .photo {
        width: 100%;
        height: auto;
        border-radius: 20px;
        object-fit: cover;
        /* Petit reflet sous la photo */
        -webkit-box-reflect: below 5px linear-gradient(transparent, rgba(255, 255, 255, 0.1));
    }

    /* Mise en avant au survol */
    .mad:hover {
        filter: grayscale(0%) brightness(1.1);
        transform: scale(1.1) translateY(-10px);
        z-index: 10;
    }

    @keyframes scrollTeam {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-50%);
        }
    }

    /* Pause l'animation quand on regarde un visage */
    .mad-track:hover {
        animation-play-state: paused;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const track = document.querySelector(".mad-track");
        if (track) {
            const clone = track.innerHTML;
            track.innerHTML += clone; // Double les éléments pour l'effet infini
        }
    });
</script>