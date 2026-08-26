<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
$abonnes_count = 0;
$result = $conn->query("SELECT COUNT(*) as count FROM abonnes");
if ($result) {
    $row = $result->fetch_assoc();
    $abonnes_count = (int)$row['count'];
}
$total_abonnes = 1500 + $abonnes_count;

$antennes_count = 0;
$result_ant = $conn->query("SELECT COUNT(*) as count FROM antennes");
if ($result_ant) {
    $row_ant = $result_ant->fetch_assoc();
    $antennes_count = (int)$row_ant['count'];
}
?>
<section class="relative overflow-hidden py-10 bg-sterna-yellow">

    <div class="absolute -top-0 md:top-0 left-0 w-full overflow-hidden leading-none">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-12 md:h-20 text-gray-100 fill-current">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
    </div>

    <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full" style="background:rgba(245, 185, 4, 0.04);"></div>
    <div class="absolute -bottom-20 -right-20 w-72 h-72 rounded-full" style="background:rgba(234, 15, 104, 0.06);"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="mb-16 mt-8 md:mt-16">
            <h2 class="text-2xl md:text-4xl font-black text-white uppercase tracking-tighter">Impact Global & <span class="text-sterna-blue">Chiffres Clés</span></h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-y-12 lg:divide-x divide-sterna-blue">

            <div class="flex flex-col items-center text-center px-4">
                <p class="counter" data-target="99552" style="font-size: clamp(24px, 6vw, 36px) !important; font-weight: 900 !important; color: #ffffff !important; font-family: 'Quicksand', sans-serif !important; line-height: 1.1 !important; margin: 0 !important; letter-spacing: -0.03em !important;">0</p>
                <div class="w-8 h-1 bg-sterna-blue rounded-full my-4"></div>
                <p style="font-size: 11px !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: 0.1em !important; color: #034890 !important; line-height: 1.3 !important; font-family: 'Quicksand', sans-serif !important; margin: 0 !important;">Bénéficiaires <br>Directs & Indirects</p>
            </div>

            <div class="flex flex-col items-center text-center px-4">
                <p class="counter" data-target="<?php echo $total_abonnes; ?>" style="font-size: clamp(24px, 6vw, 36px) !important; font-weight: 900 !important; color: #ffffff !important; font-family: 'Quicksand', sans-serif !important; line-height: 1.1 !important; margin: 0 !important; letter-spacing: -0.03em !important;">0</p>
                <div class="w-8 h-1 bg-sterna-blue rounded-full my-4"></div>
                <p style="font-size: 11px !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: 0.1em !important; color: #034890 !important; line-height: 1.3 !important; font-family: 'Quicksand', sans-serif !important; margin: 0 !important;">Nombre <br>d'abonnés</p>
            </div>

            <div class="flex flex-col items-center text-center px-4">
                <p class="counter" data-target="1039" style="font-size: clamp(24px, 6vw, 36px) !important; font-weight: 900 !important; color: #ffffff !important; font-family: 'Quicksand', sans-serif !important; line-height: 1.1 !important; margin: 0 !important; letter-spacing: -0.03em !important;">0</p>
                <div class="w-8 h-1 bg-sterna-blue rounded-full my-4"></div>
                <p style="font-size: 11px !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: 0.1em !important; color: #034890 !important; line-height: 1.3 !important; font-family: 'Quicksand', sans-serif !important; margin: 0 !important;">Personnes <br>formées</p>
            </div>

            <div class="flex flex-col items-center text-center px-4">
                <p class="counter" data-target="380" style="font-size: clamp(24px, 6vw, 36px) !important; font-weight: 900 !important; color: #ffffff !important; font-family: 'Quicksand', sans-serif !important; line-height: 1.1 !important; margin: 0 !important; letter-spacing: -0.03em !important;">0</p>
                <div class="w-8 h-1 bg-sterna-blue rounded-full my-4"></div>
                <p style="font-size: 11px !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: 0.1em !important; color: #034890 !important; line-height: 1.3 !important; font-family: 'Quicksand', sans-serif !important; margin: 0 !important;">Volontaires <br>adhérents</p>
            </div>

            <div class="flex flex-col items-center text-center px-4">
                <p class="counter" data-target="203" style="font-size: clamp(24px, 6vw, 36px) !important; font-weight: 900 !important; color: #ffffff !important; font-family: 'Quicksand', sans-serif !important; line-height: 1.1 !important; margin: 0 !important; letter-spacing: -0.03em !important;">0</p>
                <div class="w-8 h-1 bg-sterna-blue rounded-full my-4"></div>
                <p style="font-size: 11px !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: 0.1em !important; color: #034890 !important; line-height: 1.3 !important; font-family: 'Quicksand', sans-serif !important; margin: 0 !important;">Projets & <br>Activités</p>
            </div>

            <div class="flex flex-col items-center text-center px-4">
                <p class="counter" data-target="<?php echo $antennes_count; ?>" style="font-size: clamp(24px, 6vw, 36px) !important; font-weight: 900 !important; color: #ffffff !important; font-family: 'Quicksand', sans-serif !important; line-height: 1.1 !important; margin: 0 !important; letter-spacing: -0.03em !important;">0</p>
                <div class="w-8 h-1 bg-sterna-blue rounded-full my-4"></div>
                <p style="font-size: 11px !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: 0.1em !important; color: #034890 !important; line-height: 1.3 !important; font-family: 'Quicksand', sans-serif !important; margin: 0 !important;">Pays <br>d'intervention</p>
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