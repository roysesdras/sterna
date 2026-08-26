<?php
// config/infographics_carousel.php
?>
<section class="w-full bg-gray-100 py-10 md:py-16">
    <div class="max-w-[1400px] mx-auto relative group">
        
        <div class="text-left mb-6 px-4">
            <h2 class="text-3xl md:text-4xl font-black text-[#0f277e] uppercase tracking-wide">
                Sterna Africa, c'est :
            </h2>
        </div>
        
        <!-- Conteneur défilant avec Scroll Snapping (Swipe natif sur mobile/PC) -->
        <div id="infographics-carousel" class="flex overflow-x-auto gap-6 md:gap-10 snap-x snap-mandatory [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden scroll-smooth px-6 py-4">
            
            <div class="shrink-0 w-[85%] md:w-[70%] lg:w-[60%] snap-center flex justify-center mx-auto">
                <img loading="lazy" decoding="async" src="/assets/img/external/9af343c8df_Whats-App-Image-2026-08-13-at-11-54-14-AM.jpg" alt="Infographie 1" class="w-full h-auto rounded-3xl">
            </div>
            
            <div class="shrink-0 w-[85%] md:w-[70%] lg:w-[60%] snap-center flex justify-center mx-auto">
                <img loading="lazy" decoding="async" src="/assets/img/external/cd5daeec73_Whats-App-Image-2026-08-13-at-11-54-20-AM.jpg" alt="Infographie 2" class="w-full h-auto rounded-3xl">
            </div>

            <div class="shrink-0 w-[85%] md:w-[70%] lg:w-[60%] snap-center flex justify-center mx-auto">
                <img loading="lazy" decoding="async" src="/assets/img/external/499f59a408_Whats-App-Image-2026-08-13-at-11-54-18-AM.jpg" alt="Infographie 3" class="w-full h-auto rounded-3xl">
            </div>

        </div>

        <!-- Boutons de navigation (Visibles partout, très jolis) -->
        <button id="btn-prev-info" class="absolute left-2 md:left-12 top-1/2 -translate-y-1/2 bg-white hover:bg-[#ea750fff] text-[#0f277e] hover:text-white w-12 h-12 md:w-16 md:h-16 rounded-full shadow-[0_10px_30px_rgba(0,0,0,0.15)] flex items-center justify-center transition-all duration-300 z-10 focus:outline-none opacity-90 hover:opacity-100 hover:scale-110">
            <i class="fas fa-chevron-left text-xl md:text-2xl"></i>
        </button>
        <button id="btn-next-info" class="absolute right-2 md:right-12 top-1/2 -translate-y-1/2 bg-white hover:bg-[#ea750fff] text-[#0f277e] hover:text-white w-12 h-12 md:w-16 md:h-16 rounded-full shadow-[0_10px_30px_rgba(0,0,0,0.15)] flex items-center justify-center transition-all duration-300 z-10 focus:outline-none opacity-90 hover:opacity-100 hover:scale-110">
            <i class="fas fa-chevron-right text-xl md:text-2xl"></i>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const carouselInfo = document.getElementById('infographics-carousel');
            const btnPrevInfo = document.getElementById('btn-prev-info');
            const btnNextInfo = document.getElementById('btn-next-info');

            if (!carouselInfo || !btnPrevInfo || !btnNextInfo) return;

            // Fonction de défilement avec les flèches
            btnNextInfo.addEventListener('click', () => {
                const slideWidth = carouselInfo.querySelector('div').offsetWidth + 24; // + gap
                carouselInfo.scrollBy({ left: slideWidth, behavior: 'smooth' });
            });

            btnPrevInfo.addEventListener('click', () => {
                const slideWidth = carouselInfo.querySelector('div').offsetWidth + 24;
                carouselInfo.scrollBy({ left: -slideWidth, behavior: 'smooth' });
            });
            
            // Centrer initialement la première image sur PC
            setTimeout(() => {
                carouselInfo.scrollLeft = 0;
            }, 100);
        });
    </script>
</section>
