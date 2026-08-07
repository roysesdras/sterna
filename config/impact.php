<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
$abonnes_count = 0;
$result = $conn->query("SELECT COUNT(*) as count FROM abonnes");
if ($result) {
    $row = $result->fetch_assoc();
    $abonnes_count = (int)$row['count'];
}
$total_abonnes = 1500 + $abonnes_count;
?>
<section class="relative overflow-hidden py-10" style="background: #085191;">

    <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255,255,255,0.1) 1.5px, transparent 1.5px); background-size: 30px 30px;"></div>
    <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full" style="background:rgba(245, 185, 4, 0.04);"></div>
    <div class="absolute -bottom-20 -right-20 w-72 h-72 rounded-full" style="background:rgba(234, 15, 104, 0.06);"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-white/70 uppercase tracking-[0.25em]" style="font-size: 16px !important; font-weight: 800 !important; font-family: 'Quicksand', sans-serif !important; line-height: 1.2 !important; margin: 0 auto !important; letter-spacing: 0.25em !important; text-transform: uppercase !important; border: none !important;">Impact Global & Chiffres Clés</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-y-12 lg:divide-x divide-white/10">

            <div class="flex flex-col items-center text-center px-4">
                <p class="counter" data-target="99552" style="font-size: clamp(24px, 6vw, 36px) !important; font-weight: 900 !important; color: #ffffff !important; font-family: 'Quicksand', sans-serif !important; line-height: 1.1 !important; margin: 0 !important; letter-spacing: -0.03em !important;">0</p>
                <div class="w-8 h-1 bg-urunani-orange rounded-full my-4"></div>
                <p style="font-size: 11px !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: 0.1em !important; color: rgba(255,255,255,0.7) !important; line-height: 1.3 !important; font-family: 'Quicksand', sans-serif !important; margin: 0 !important;">Bénéficiaires <br>Directs & Indirects</p>
            </div>

            <div class="flex flex-col items-center text-center px-4">
                <p class="counter" data-target="<?php echo $total_abonnes; ?>" style="font-size: clamp(24px, 6vw, 36px) !important; font-weight: 900 !important; color: #ffffff !important; font-family: 'Quicksand', sans-serif !important; line-height: 1.1 !important; margin: 0 !important; letter-spacing: -0.03em !important;">0</p>
                <div class="w-8 h-1 bg-urunani-rose rounded-full my-4"></div>
                <p style="font-size: 11px !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: 0.1em !important; color: rgba(255,255,255,0.7) !important; line-height: 1.3 !important; font-family: 'Quicksand', sans-serif !important; margin: 0 !important;">Nombre <br>d'abonnés</p>
            </div>

            <div class="flex flex-col items-center text-center px-4">
                <p class="counter" data-target="1039" style="font-size: clamp(24px, 6vw, 36px) !important; font-weight: 900 !important; color: #ffffff !important; font-family: 'Quicksand', sans-serif !important; line-height: 1.1 !important; margin: 0 !important; letter-spacing: -0.03em !important;">0</p>
                <div class="w-8 h-1 bg-urunani-keppel rounded-full my-4"></div>
                <p style="font-size: 11px !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: 0.1em !important; color: rgba(255,255,255,0.7) !important; line-height: 1.3 !important; font-family: 'Quicksand', sans-serif !important; margin: 0 !important;">Personnes <br>formées</p>
            </div>

            <div class="flex flex-col items-center text-center px-4">
                <p class="counter" data-target="380" style="font-size: clamp(24px, 6vw, 36px) !important; font-weight: 900 !important; color: #ffffff !important; font-family: 'Quicksand', sans-serif !important; line-height: 1.1 !important; margin: 0 !important; letter-spacing: -0.03em !important;">0</p>
                <div class="w-8 h-1 bg-urunani-orange rounded-full my-4"></div>
                <p style="font-size: 11px !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: 0.1em !important; color: rgba(255,255,255,0.7) !important; line-height: 1.3 !important; font-family: 'Quicksand', sans-serif !important; margin: 0 !important;">Volontaires <br>adhérents</p>
            </div>

            <div class="flex flex-col items-center text-center px-4">
                <p class="counter" data-target="203" style="font-size: clamp(24px, 6vw, 36px) !important; font-weight: 900 !important; color: #ffffff !important; font-family: 'Quicksand', sans-serif !important; line-height: 1.1 !important; margin: 0 !important; letter-spacing: -0.03em !important;">0</p>
                <div class="w-8 h-1 bg-urunani-rose rounded-full my-4"></div>
                <p style="font-size: 11px !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: 0.1em !important; color: rgba(255,255,255,0.7) !important; line-height: 1.3 !important; font-family: 'Quicksand', sans-serif !important; margin: 0 !important;">Projets & <br>Activités</p>
            </div>

            <div class="flex flex-col items-center text-center px-4">
                <p class="counter" data-target="4" style="font-size: clamp(24px, 6vw, 36px) !important; font-weight: 900 !important; color: #ffffff !important; font-family: 'Quicksand', sans-serif !important; line-height: 1.1 !important; margin: 0 !important; letter-spacing: -0.03em !important;">0</p>
                <div class="w-8 h-1 bg-urunani-keppel rounded-full my-4"></div>
                <p style="font-size: 11px !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: 0.1em !important; color: rgba(255,255,255,0.7) !important; line-height: 1.3 !important; font-family: 'Quicksand', sans-serif !important; margin: 0 !important;">Pays <br>d'intervention</p>
            </div>

        </div>
    </div>
</section>

<script>
    const animateCounters = () => {
        const counters = document.querySelectorAll('.counter');
        const duration = 2500; // Animation fluide de 2.5s

        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            let startTime = null;

            const step = (timestamp) => {
                if (!startTime) startTime = timestamp;
                const progress = Math.min((timestamp - startTime) / duration, 1);
                
                // Effet d'accélération/décélération (EaseOut)
                const easeProgress = 1 - Math.pow(1 - progress, 3);
                
                const currentCount = Math.floor(easeProgress * target);
                counter.innerText = currentCount.toLocaleString('fr-FR'); 

                if (progress < 1) {
                    window.requestAnimationFrame(step);
                } else {
                    counter.innerText = target.toLocaleString('fr-FR');
                }
            };

            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    window.requestAnimationFrame(step);
                    observer.unobserve(counter);
                }
            }, { threshold: 0.2 });

            observer.observe(counter);
        });
    };

    document.addEventListener('DOMContentLoaded', animateCounters);
</script>