<nav class="bottom-nav">
    <div class="dock-container">
        <a href="#actualites" class="dock-item">
            <i class="fi fi-rr-flame"></i>
            <span class="comic-neue-regular" style="font-size: 12px;">Actu</span>
        </a>
        <a href="#about" class="dock-item">
            <i class="fi fi-rr-globe"></i>
            <span class="comic-neue-regular" style="font-size: 12px;">Impact</span>
        </a>

        <a href="https://sternaafrica.org/" class="dock-logo-main">
            <img src="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" alt="Sterna">
        </a>

        <a href="#antennes" class="dock-item">
            <i class="fi fi-rr-marker"></i>
            <span class="comic-neue-regular" style="font-size: 12px;">Réseau</span>
        </a>
        <button class="dock-item" onclick="openSidebar()">
            <i class="fi fi-rr-messages text-sternaYellow"></i>
            <span class="comic-neue-regular" style="font-size: 12px;">Chat IA</span>
        </button>
    </div>
</nav>

<style>
    :root {
        --nav-bg: rgba(10, 10, 10, 0.9);
        /* Noir presque pur */
        --accent-glow: #2ecc71;
        /* On garde le vert pour l'aura seulement */
        --dock-border: rgba(255, 255, 255, 0.08);
    }

    .bottom-nav {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 95%;
        max-width: 420px;
        z-index: 1000;
    }

    .dock-container {
        background: var(--nav-bg);
        backdrop-filter: blur(25px);
        border: 1px solid var(--dock-border);
        border-radius: 40px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        padding: 8px 10px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.8);
    }

    .dock-item {
        background: none;
        border: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #888;
        /* Gris pour les items inactifs */
        text-decoration: none;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dock-item i {
        font-size: 18px;
        margin-bottom: 2px;
    }

    .dock-item:hover {
        color: #fff;
        transform: translateY(-3px);
    }

    /* LE CERCLE CENTRAL RÉVISÉ */
    .dock-logo-main {
        width: 65px;
        height: 65px;
        /* Fond sombre avec un dégradé subtil au lieu du vert plein */
        background: linear-gradient(145deg, #1a1a1a, #0d0d0d);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: -40px;
        border: 4px solid #0A0F14;
        /* Découpe sur le fond du site */
        box-shadow: 0 0 20px rgba(46, 204, 113, 0.2);
        /* Aura verte légère */
        transition: 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
    }

    .dock-logo-main img {
        width: 75%;
        /* Le logo prend une bonne place dans le cercle */
        height: auto;
        filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.2));
    }

    .dock-logo-main:hover {
        transform: scale(1.15) rotate(10deg);
        box-shadow: 0 0 30px rgba(46, 204, 113, 0.5);
        /* L'aura s'intensifie au survol */
    }
</style>