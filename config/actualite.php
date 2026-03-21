<?php if (count($actualites) > 0): ?>
    <div class="news-scroll-wrapper py-4">
        <?php
        $count = 0;
        $max_activities = 6;
        $classes = [
            "Côte Ivoire" => "pill-yellow",
            "Bénin" => "pill-blue",
            "France" => "pill-blue",
            "Burkina-Faso" => "pill-yellow",
            "Togo" => "pill-yellow"
        ];

        foreach ($actualites as $actualite):
            if ($count >= $max_activities) break;

            $lieu = htmlspecialchars($actualite['lieu']);
            $pill_class = "pill-gray";

            foreach ($classes as $pays => $couleur) {
                if (stripos($lieu, $pays) !== false) {
                    $pill_class = $couleur;
                    break;
                }
            }
        ?>

            <div class="news-card-item">
                <div class="news-card">
                    <div class="news-img-box">
                        <span class="news-pill <?php echo $pill_class; ?>">
                            <i class="fi fi-rr-marker"></i> <?php echo $lieu; ?>
                        </span>
                        <a href="./actualite/<?php echo $actualite['id']; ?>">
                            <img src="images/<?php echo $actualite['image']; ?>" alt="Actualité Sterna" class="news-img">
                        </a>
                    </div>

                    <div class="news-body">
                        <span class="news-date">
                            <i class="fi fi-rr-calendar"></i> <?= date('d M Y', strtotime($actualite['end_date'])) ?>
                        </span>
                        <h5 class="news-title comic-neue-bold">
                            <?php
                            $title = $actualite['title'];
                            echo (mb_strlen($title) > 50) ? mb_substr($title, 0, 50) . '...' : $title;
                            ?>
                        </h5>
                        <a href="./actualite/<?php echo $actualite['id']; ?>" class="news-link">
                            Lire l'article <i class="fi fi-rr-arrow-small-right"></i>
                        </a>
                    </div>
                </div>
            </div>

        <?php $count++;
        endforeach; ?>
    </div>
<?php else: ?>
    <p class="text-center text-muted py-5">Aucune actualité pour le moment.</p>
<?php endif; ?>

<style>
    /* Container de défilement horizontal */
    .news-scroll-wrapper {
        display: flex;
        overflow-x: auto;
        gap: 20px;
        padding: 20px 10px;
        scrollbar-width: none;
    }

    .news-scroll-wrapper::-webkit-scrollbar {
        display: none;
    }

    /* Carte Individuelle */
    .news-card-item {
        flex: 0 0 auto;
        width: 300px;
    }

    .news-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        overflow: hidden;
        height: 100%;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        backdrop-filter: blur(10px);
    }

    .news-card:hover {
        transform: translateY(-10px);
        background: rgba(255, 255, 255, 0.07);
        border-color: #f5b904;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }

    /* Image et Pill */
    .news-img-box {
        position: relative;
        height: 180px;
        overflow: hidden;
    }

    .news-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .news-card:hover .news-img {
        transform: scale(1.1) rotate(1deg);
    }

    .news-pill {
        position: absolute;
        top: 15px;
        left: 15px;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 10px;
        font-weight: 800;
        color: #fff;
        z-index: 5;
        text-transform: uppercase;
    }

    .pill-blue {
        background: #305196;
        box-shadow: 0 4px 10px rgba(48, 81, 150, 0.4);
    }

    .pill-yellow {
        background: #f5b904;
        color: #000;
        box-shadow: 0 4px 10px rgba(245, 185, 4, 0.4);
    }

    .pill-gray {
        background: #64748b;
    }

    /* Contenu du texte */
    .news-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .news-date {
        font-size: 11px;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .news-title {
        font-size: 1.05rem;
        color: #fff;
        line-height: 1.4;
        min-height: 45px;
    }

    .news-link {
        font-size: 13px;
        color: #f5b904;
        text-decoration: none;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
        transition: gap 0.3s;
    }

    .news-link:hover {
        gap: 15px;
        color: #fff;
    }
</style>