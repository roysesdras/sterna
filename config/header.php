<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
$query_header = "SELECT image, title, description FROM actualites WHERE image != '' AND image IS NOT NULL ORDER BY end_date DESC LIMIT 6";
$result_header = $conn->query($query_header);
$header_images = [];
if ($result_header) {
    while($r = $result_header->fetch_assoc()) {
        $header_images[] = $r;
    }
}

// Fallback si pas d'image
if (empty($header_images)) {
    $header_images[] = [
        'image' => 'https://i.ibb.co/MD9zmRRC/1755464569925.jpg', 
        'title' => 'Sterna Africa',
        'description' => 'Nous sommes partout où le besoin se fait sentir. Rejoignez notre mouvement pour construire un avenir meilleur.'
    ];
}

// Préparer les descriptions pour le JS
$descriptions_js = [];
foreach($header_images as $item) {
    $desc = isset($item['description']) && !empty(trim($item['description'])) 
            ? strip_tags(html_entity_decode($item['description'])) 
            : 'Nous sommes partout où le besoin se fait sentir. Rejoignez notre mouvement pour construire un avenir meilleur.';
    // Garder seulement environ 120 caractères pour que ça reste beau
    $desc = mb_strlen($desc) > 120 ? mb_substr($desc, 0, 120) . '...' : $desc;
    $descriptions_js[] = json_encode(trim(preg_replace('/\s+/', ' ', $desc)));
}
?>
<header class="relative w-full h-screen min-h-[600px] overflow-hidden bg-[#0f277e]">
    <!-- Container des slides -->
    <div id="hero-slider" class="absolute inset-0 w-full h-full">
        <?php foreach($header_images as $index => $item): ?>
            <?php 
                $img_url = (filter_var($item['image'], FILTER_VALIDATE_URL)) ? $item['image'] : "/images/" . $item['image'];
            ?>
            <div class="hero-slide absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out <?php echo $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0'; ?>" data-index="<?php echo $index; ?>">
                <img src="<?php echo htmlspecialchars($img_url); ?>" 
                     alt="<?php echo htmlspecialchars($item['title']); ?>"
                     class="w-full h-full object-cover transform scale-105 transition-transform duration-[10000ms] ease-out">
                
                <!-- Overlay Dégradé (Noir/Bleu profond vers transparent) pour lisibilité -->
                <div class="absolute inset-0 bg-gradient-to-r from-[#0f277e]/90 via-[#0f277e]/50 to-transparent"></div>
                <!-- Voile sombre global léger -->
                <div class="absolute inset-0 bg-black/20"></div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Contenu Texte (Fixe par dessus le slider) -->
    <div class="relative z-20 container mx-auto px-6 md:px-12 h-full flex flex-col justify-center pointer-events-none pt-20">
        <div class="max-w-3xl pointer-events-auto">
            <!-- Petit badge ou ligne au dessus -->
            <div class="flex items-center gap-4 mb-6">
                <span class="w-12 h-1 bg-[#ea750fff]"></span>
                <span id="dynamic-badge-text" class="text-white uppercase tracking-widest font-bold text-sm md:text-base transition-opacity duration-300">Éducation Populaire</span>
            </div>

            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white mb-6 leading-tight cabin-sketch drop-shadow-lg">
                STERNA <span class="text-[#ea750fff]">AFRICA</span><br>
                <span class="text-4xl md:text-6xl text-gray-200">WHEREVER NEEDED</span>
            </h1>

            <p id="dynamic-desc-text" class="text-xl md:text-2xl text-blue-100 mb-10 leading-relaxed font-light max-w-2xl text-shadow-sm transition-opacity duration-300">
                <?php echo json_decode($descriptions_js[0]); ?>
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="/a-propos/" class="bg-[#ea750fff] hover:bg-[#c7620a] text-white font-bold py-3 px-4 rounded-full transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl hover:shadow-[#ea750fff]/30">
                    Découvrir qui nous sommes
                </a>
                <!-- <a href="/don.php" class="bg-transparent border-2 border-white hover:bg-white hover:text-[#0f277e] text-white font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:-translate-y-1">
                    Soutenir Sterna
                </a> -->
            </div>
        </div>
    </div>

    <!-- Contrôles du Slider -->
    <?php if (count($header_images) > 1): ?>
    <div class="absolute z-30 bottom-10 right-6 md:right-12 flex items-center gap-6">
        <!-- Flèches -->
        <div class="flex gap-2">
            <button id="hero-prev" class="w-12 h-12 rounded-full border border-white/50 flex items-center justify-center text-white hover:bg-white hover:text-[#0f277e] transition-colors focus:outline-none backdrop-blur-sm pointer-events-auto">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button id="hero-next" class="w-12 h-12 rounded-full border border-white/50 flex items-center justify-center text-white hover:bg-white hover:text-[#0f277e] transition-colors focus:outline-none backdrop-blur-sm pointer-events-auto">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
    
    <!-- Indicateurs (Dots) -->
    <div class="absolute z-30 bottom-10 left-6 md:left-12 flex gap-3 pointer-events-auto">
        <?php foreach($header_images as $index => $item): ?>
            <button class="hero-dot w-3 h-3 rounded-full transition-all duration-300 <?php echo $index === 0 ? 'bg-[#ea750fff] w-8' : 'bg-white/50 hover:bg-white'; ?>" data-index="<?php echo $index; ?>" aria-label="Slide <?php echo $index + 1; ?>"></button>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Script JavaScript pour le Slider -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slides = document.querySelectorAll('.hero-slide');
            const dots = document.querySelectorAll('.hero-dot');
            const btnPrev = document.getElementById('hero-prev');
            const btnNext = document.getElementById('hero-next');
            const badgeText = document.getElementById('dynamic-badge-text');
            const descText = document.getElementById('dynamic-desc-text');
            
            const badges = [
                "Éducation Populaire",
                "Solidarité internationale",
                "Volontariat",
                "Développement communautaire"
            ];

            const descriptions = [
                <?php echo implode(", ", $descriptions_js); ?>
            ];
            
            if (slides.length <= 1) return;

            let currentSlide = 0;
            let slideInterval;
            const intervalTime = 6000; // 6 secondes

            function goToSlide(n) {
                // Masquer la slide actuelle
                slides[currentSlide].classList.remove('opacity-100', 'z-10');
                slides[currentSlide].classList.add('opacity-0', 'z-0');
                if (dots[currentSlide]) {
                    dots[currentSlide].classList.remove('bg-[#ea750fff]', 'w-8');
                    dots[currentSlide].classList.add('bg-white/50');
                }
                
                // Retirer l'effet de zoom lent
                const imgOld = slides[currentSlide].querySelector('img');
                if(imgOld) {
                    imgOld.classList.remove('scale-100');
                    imgOld.classList.add('scale-105');
                }

                currentSlide = (n + slides.length) % slides.length;

                // Mettre à jour le badge et la description avec un effet de fondu
                if (badgeText || descText) {
                    if (badgeText) badgeText.classList.add('opacity-0');
                    if (descText) descText.classList.add('opacity-0');
                    
                    setTimeout(() => {
                        if (badgeText) {
                            badgeText.textContent = badges[currentSlide % badges.length];
                            badgeText.classList.remove('opacity-0');
                        }
                        if (descText && descriptions[currentSlide]) {
                            descText.textContent = descriptions[currentSlide];
                            descText.classList.remove('opacity-0');
                        }
                    }, 300);
                }

                // Afficher la nouvelle slide
                slides[currentSlide].classList.remove('opacity-0', 'z-0');
                slides[currentSlide].classList.add('opacity-100', 'z-10');
                if (dots[currentSlide]) {
                    dots[currentSlide].classList.remove('bg-white/50');
                    dots[currentSlide].classList.add('bg-[#ea750fff]', 'w-8');
                }
                
                // Déclencher le léger zoom arrière sur l'image affichée
                setTimeout(() => {
                    const imgNew = slides[currentSlide].querySelector('img');
                    if(imgNew) {
                        imgNew.classList.remove('scale-105');
                        imgNew.classList.add('scale-100');
                    }
                }, 50);
            }

            function nextSlide() { goToSlide(currentSlide + 1); }
            function prevSlide() { goToSlide(currentSlide - 1); }

            function startSlideShow() {
                slideInterval = setInterval(nextSlide, intervalTime);
            }
            function resetSlideShow() {
                clearInterval(slideInterval);
                startSlideShow();
            }

            if (btnNext) btnNext.addEventListener('click', () => { nextSlide(); resetSlideShow(); });
            if (btnPrev) btnPrev.addEventListener('click', () => { prevSlide(); resetSlideShow(); });

            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    goToSlide(index);
                    resetSlideShow();
                });
            });

            // Initialiser le zoom sur la première image
            setTimeout(() => {
                if(slides[0]) {
                    const imgFirst = slides[0].querySelector('img');
                    if(imgFirst) {
                        imgFirst.classList.remove('scale-105');
                        imgFirst.classList.add('scale-100');
                    }
                }
            }, 50);

            startSlideShow();
        });
    </script>
</header>