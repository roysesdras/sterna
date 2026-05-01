<section class="relative overflow-hidden py-10" style="background: linear-gradient(135deg, #0f277e 0%, #071952 100%);">

    <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255,255,255,0.1) 1.5px, transparent 1.5px); background-size: 30px 30px;"></div>
    <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full" style="background:rgba(245, 185, 4, 0.04);"></div>
    <div class="absolute -bottom-20 -right-20 w-72 h-72 rounded-full" style="background:rgba(234, 15, 104, 0.06);"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-white/50 text-md font-black uppercase tracking-[0.4em]">Impact Global & Chiffres Clés</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-y-12 lg:divide-x divide-white/10">

            <div class="flex flex-col items-center text-center px-4">
                <p class="text-5xl md:text-6xl font-black text-white leading-none tracking-tighter counter" data-target="99552">0</p>
                <div class="w-8 h-1 bg-urunani-orange rounded-full my-4"></div>
                <p class="text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-white/70 leading-relaxed">Bénéficiaires <br>Directs & Indirects</p>
            </div>

            <div class="flex flex-col items-center text-center px-4">
                <p class="text-5xl md:text-6xl font-black text-white leading-none tracking-tighter counter" data-target="66000">0</p>
                <div class="w-8 h-1 bg-urunani-rose rounded-full my-4"></div>
                <p class="text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-white/70 leading-relaxed">Communauté <br>en ligne</p>
            </div>

            <div class="flex flex-col items-center text-center px-4">
                <p class="text-5xl md:text-6xl font-black text-white leading-none tracking-tighter counter" data-target="1039">0</p>
                <div class="w-8 h-1 bg-urunani-keppel rounded-full my-4"></div>
                <p class="text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-white/70 leading-relaxed">Personnes <br>formées</p>
            </div>

            <div class="flex flex-col items-center text-center px-4">
                <p class="text-5xl md:text-6xl font-black text-white leading-none tracking-tighter counter" data-target="380">0</p>
                <div class="w-8 h-1 bg-urunani-orange rounded-full my-4"></div>
                <p class="text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-white/70 leading-relaxed">Volontaires <br>adhérents</p>
            </div>

            <div class="flex flex-col items-center text-center px-4">
                <p class="text-5xl md:text-6xl font-black text-white leading-none tracking-tighter counter" data-target="203">0</p>
                <div class="w-8 h-1 bg-urunani-rose rounded-full my-4"></div>
                <p class="text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-white/70 leading-relaxed">Projets & <br>Activités</p>
            </div>

            <div class="flex flex-col items-center text-center px-4">
                <p class="text-5xl md:text-6xl font-black text-white leading-none tracking-tighter counter" data-target="4">0</p>
                <div class="w-8 h-1 bg-urunani-keppel rounded-full my-4"></div>
                <p class="text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-white/70 leading-relaxed">Pays <br>d'intervention</p>
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