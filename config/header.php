<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
// On récupère les 6 dernières images des actualités
$query_header = "SELECT image, title FROM actualites WHERE image != '' AND image IS NOT NULL ORDER BY end_date DESC LIMIT 6";
$result_header = $conn->query($query_header);
$header_images = [];
if ($result_header) {
    while($r = $result_header->fetch_assoc()) {
        $header_images[] = $r;
    }
}
?>
<main
    class="w-full min-h-screen bg-[url('https://i.postimg.cc/zBnHHfCj/main-bg-rcouper.png')]
    bg-[length:auto_100%] bg-top bg-no-repeat
    py-16 md:py-20 flex items-center justify-center"
>
    
    <div class="container mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-10">
        
        <!-- Texte -->
        <section class="flex-1 text-white text-center md:text-left">
            <h1 class="text-4xl md:text-6xl font-black mb-6 leading-tight">
                STERNA AFRICA <br>WHEREVER NEEDED
            </h1>

            <p class="text-lg md:text-xl text-blue-200">
                Nous sommes partout où le besoin se fait sentir,
                nous sommes une association d'ECSI
            </p>
        </section>

        <!-- Carousel d'Images (Fondu) -->
        <div class="flex-1 flex justify-center md:justify-end md:translate-y-22">
            <div class="relative w-[340px] max-w-[340px] sm:w-full sm:max-w-[400px] md:max-w-[700px] h-[350px] sm:h-[400px] md:h-[550px] rounded-[15%] shadow-3xl animate-float overflow-hidden bg-gray-100">
                
                <?php if (count($header_images) > 0): ?>
                    <?php foreach($header_images as $index => $item): ?>
                        <img src="/images/<?php echo htmlspecialchars($item['image']); ?>" 
                             alt="<?php echo htmlspecialchars($item['title']); ?>"
                             class="carousel-hero-img absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out <?php echo $index === 0 ? 'opacity-100' : 'opacity-0'; ?>"
                             onerror="this.src='https://i.ibb.co/MD9zmRRC/1755464569925.jpg'">
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Fallback si aucune image -->
                    <img src="https://i.ibb.co/MD9zmRRC/1755464569925.jpg" alt="Sterna Africa" class="absolute inset-0 w-full h-full object-cover">
                <?php endif; ?>

                <!-- Voile sombre léger pour faire ressortir l'image -->
                <div class="absolute inset-0 bg-black/10 pointer-events-none"></div>
            </div>
        </div>

    </div>

    <!-- Script pour le fondu des images -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slides = document.querySelectorAll('.carousel-hero-img');
            if (slides.length > 1) {
                let currentSlide = 0;
                setInterval(() => {
                    // Masquer l'image actuelle
                    slides[currentSlide].classList.remove('opacity-100');
                    slides[currentSlide].classList.add('opacity-0');
                    
                    // Passer à l'image suivante
                    currentSlide = (currentSlide + 1) % slides.length;
                    
                    // Afficher la nouvelle image
                    slides[currentSlide].classList.remove('opacity-0');
                    slides[currentSlide].classList.add('opacity-100');
                }, 4000); // 4 secondes par image
            }
        });
    </script>
</main>