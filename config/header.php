<style>
    /* 1. ANIMATION DES IMAGES (FADE) */
    @keyframes hero-fade {
        0%, 10% { opacity: 0; }
        20%, 40% { opacity: 1; }
        50%, 100% { opacity: 0; }
    }

    .hero-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        animation: hero-fade 18s infinite; /* 18s total pour 3 slides (6s chacun) */
        background-size: cover;
        background-position: center;
    }

    /* 2. ANIMATION DU TEXTE (SLIDE UP) */
    @keyframes text-slide-up {
        0%, 15% { opacity: 0; transform: translateY(20px); }
        25%, 35% { opacity: 1; transform: translateY(0); }
        45%, 100% { opacity: 0; transform: translateY(-40px); }
    }

    .hero-caption {
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        transform: translateY(-50%);
        animation: text-slide-up 18s infinite;
    }
</style>

<section class="relative h-[80vh] md:h-[85vh] flex items-center bg-[#0f277e] overflow-hidden">

    <div class="absolute inset-0 z-0">
        <?php 
        $delay = 0;
        foreach ($actualites as $index => $actualite): 
            $image_path = "images/" . $actualite['image'];
            // On limite à 3 pour respecter l'animation de 18s (6s par slide)
            if($index >= 3) break; 
        ?>
            <div class="hero-slide" 
                 style="animation-delay: <?php echo $delay; ?>s; 
                        background-image: linear-gradient(rgba(15, 39, 126, 0.4), rgba(15, 39, 126, 0.4)), url('<?php echo $image_path; ?>');">
            </div>
        <?php 
            $delay += 6;
        endforeach; 
        ?>
    </div>

    <div class="absolute top-0 right-0 w-1/4 h-full bg-[#44aca0] opacity-20 skew-x-12 transform translate-x-32 z-10 hidden md:block"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-20 w-full h-full flex items-center">
        <div class="relative w-full max-w-3xl min-h-[300px] md:min-h-auto flex items-center">

            <?php 
            $delayText = 0;
            foreach ($actualites as $index => $actualite): 
                if($index >= 3) break;
                $actualite_link = "https://sternaafrica.org/actualite/" . $actualite['id'];
                
                // Couleurs alternées selon l'index pour garder le style Urunani
                $colors = ['#ea0f68', '#0e38e4ff', '#ff8017'];
                $currentColor = $colors[$index % 3];
            ?>
                <div class="hero-caption <?php echo $index > 0 ? 'opacity-0' : ''; ?>" style="animation-delay: <?php echo $delayText; ?>s;">
                    
                    <span class="px-3 py-1 rounded-sm text-[10px] font-black text-white uppercase tracking-[0.3em] mb-4 inline-block" 
                          style="background-color: <?php echo $currentColor; ?>;">
                        Impact Terrain : <?php echo htmlspecialchars($actualite['lieu']); ?>
                    </span>

                    <h1 class="text-3xl sm:text-3xl md:text-4xl font-black text-white leading-tight mb-4 uppercase">
                        <a href="<?php echo $actualite_link; ?>">
                            <?php echo $actualite['title']; ?>
                        </a>
                    </h1>

                    <p class="text-sm md:text-xl text-gray-100 leading-relaxed font-medium max-w-xl mb-6">
                        Publié le <?= date('d M Y', strtotime($actualite['end_date'])) ?>
                    </p>

                    <a href="<?php echo $actualite_link; ?>" 
                       class="inline-block border-2 border-white text-white px-6 py-2 uppercase text-xs font-bold tracking-widest hover:bg-white hover:text-[#0f277e] rounded-md transition-all">
                        Lire les détails
                    </a>
                </div>
            <?php 
                $delayText += 6;
            endforeach; 
            ?>

        </div>
    </div>
</section>