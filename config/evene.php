<?php if (count($missions) > 0): ?>
    <div class="mission-scroll-container pb-5">
        <div class="d-flex flex-nowrap gap-4 px-3">
            <?php
            $today = strtotime(date('Y-m-d'));
            $moisFr = ['JAN', 'FÉV', 'MAR', 'AVR', 'MAI', 'JUIN', 'JUIL', 'AOÛT', 'SEP', 'OCT', 'NOV', 'DÉC'];

            foreach ($missions as $mission):
                $start = strtotime($mission['start_date']);
                $end   = strtotime($mission['end_date']);

                // Logique des couleurs et statuts
                if ($end < $today) {
                    $statusLabel = 'CLÔTURÉ';
                    $accentColor = '#64748b'; // Gris ardoise (discret)
                } elseif ($start <= $today && $end >= $today) {
                    $statusLabel = 'EN COURS';
                    $accentColor = '#EF9B0F'; // Orange Sterna
                } else {
                    $statusLabel = 'À VENIR';
                    $accentColor = '#2ecc71'; // Vert Impact
                }

                $jour = date('d', $start);
                $annee = date('Y', $start);
                $mois = $moisFr[date('n', $start) - 1];
            ?>

                <div class="modern-ticket" style="--ticket-color: <?php echo $accentColor; ?>;">

                    <div class="ticket-date-side">
                        <span class="t-month"><?php echo $mois; ?></span>
                        <span class="t-day"><?php echo $jour; ?></span>
                        <span class="t-year"><?php echo $annee; ?></span>
                        <div class="t-status-badge"><?php echo $statusLabel; ?></div>
                    </div>

                    <div class="ticket-media">
                        <img src="images/<?php echo htmlspecialchars($mission['image']); ?>" alt="Sterna Mission">
                        <div class="notch n-top"></div>
                        <div class="notch n-bottom"></div>
                    </div>

                    <div class="ticket-details">
                        <div class="details-wrap">
                            <h4 class="comic-neue-bold"><?php echo htmlspecialchars($mission['title']); ?></h4>
                            <p class="ticket-loc">
                                <i class="fi fi-rr-marker"></i> <?php echo htmlspecialchars($mission['lieu']); ?>
                            </p>
                        </div>
                        <a href="/evenement/<?php echo $mission['id']; ?>" class="btn-view-ticket">VOIR L'ÉVÈNEMENT</a>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <div class="text-center py-5">
        <p class="comic-neue-regular text-muted">Aucune mission ou événement à l'horizon.</p>
    </div>
<?php endif; ?>

<style>
    /* Container de défilement */
    .mission-scroll-container {
        overflow-x: auto;
        scrollbar-width: none;
        /* Firefox */
        padding-top: 20px;
    }

    .mission-scroll-container::-webkit-scrollbar {
        display: none;
    }

    /* Chrome/Safari */

    /* La Carte Ticket */
    .modern-ticket {
        flex: 0 0 auto;
        width: 460px;
        height: 170px;
        background: rgba(255, 255, 255, 0.03);
        /* Verre sombre */
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        display: flex;
        position: relative;
        transition: all 0.4s ease;
        backdrop-filter: blur(10px);
    }

    .modern-ticket:hover {
        transform: translateY(-8px);
        border-color: var(--ticket-color);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6), 0 0 20px rgba(var(--ticket-color), 0.2);
    }

    /* Bloc Date (Gauche) */
    .ticket-date-side {
        width: 90px;
        background: var(--ticket-color);
        border-radius: 23px 0 0 23px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #fff;
        padding: 10px;
    }

    .t-month {
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 1px;
        opacity: 0.9;
    }

    .t-day {
        font-size: 36px;
        font-weight: 900;
        line-height: 1;
    }

    .t-year {
        font-size: 14px;
        font-weight: 700;
        opacity: 0.8;
        border-top: 1px solid rgba(255, 255, 255, 0.3);
        margin-top: 4px;
        padding-top: 2px;
    }

    .t-status-badge {
        font-size: 8px;
        font-weight: 900;
        margin-top: 12px;
        background: rgba(0, 0, 0, 0.25);
        padding: 4px 8px;
        border-radius: 6px;
    }

    /* Image (Milieu) */
    .ticket-media {
        width: 130px;
        position: relative;
        overflow: hidden;
    }

    .ticket-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.7) contrast(1.1);
    }

    /* Encoches de découpe */
    .notch {
        position: absolute;
        left: -12px;
        width: 24px;
        height: 24px;
        background: #0A0F14;
        /* Doit correspondre à ton fond de page */
        border-radius: 50%;
        z-index: 10;
    }

    .n-top {
        top: -12px;
    }

    .n-bottom {
        bottom: -12px;
    }

    /* Contenu (Droite) */
    .ticket-details {
        flex: 1;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .ticket-details h4 {
        font-size: 1.1rem;
        color: #fff;
        margin-bottom: 8px;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .ticket-loc {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 600;
    }

    .ticket-loc i {
        color: var(--ticket-color);
        margin-right: 6px;
    }

    .btn-view-ticket {
        align-self: flex-end;
        font-size: 10px;
        font-weight: 800;
        color: #fff;
        padding: 8px 18px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 50px;
        text-decoration: none;
        transition: 0.3s;
        background: rgba(255, 255, 255, 0.05);
    }

    .btn-view-ticket:hover {
        background: #fff;
        color: #0A0F14;
        border-color: #fff;
    }

    /* Responsive Mobile */
    @media (max-width: 500px) {
        .modern-ticket {
            width: 340px;
            height: 140px;
        }

        .ticket-date-side {
            width: 75px;
        }

        .t-day {
            font-size: 28px;
        }

        .ticket-media {
            width: 100px;
        }

        .ticket-details {
            padding: 15px;
        }
    }
</style>