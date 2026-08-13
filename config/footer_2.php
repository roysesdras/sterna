<footer class="relative overflow-hidden py-8" style="background: linear-gradient(135deg, #034890 0%, #034890 100%);">


    <div class="max-w-7xl mx-auto px-2 relative z-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            
            <div class="flex flex-col md:flex-row items-center gap-2 md:gap-4">
                <img src="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" alt="Sterna" class="h-6 w-auto brightness-0 invert opacity-80 mb-2 md:mb-0">
                <p class="text-[11px] font-bold text-white/40 uppercase tracking-[0.2em]">
                    © 2026 Sterna Africa — <span class="text-white/80">Wherever Needed</span>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Bouton Back to Top Design Moderne -->
<button id="backToTopBtn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-8 right-8 z-50 flex items-center justify-center w-12 h-12 rounded-full bg-sterna-blue/90 backdrop-blur-md text-white shadow-[0_0_20px_rgba(3,72,144,0.4)] hover:shadow-[0_0_30px_rgba(252,185,0,0.6)] hover:bg-sterna-yellow hover:text-sterna-blue transition-all duration-500 opacity-0 pointer-events-none translate-y-12 group overflow-hidden" aria-label="Retour en haut">
    <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out"></div>
    <i class="fi fi-rr-arrow-up text-xl relative z-10 group-hover:-translate-y-1 transition-transform duration-300"></i>
</button>

<!-- Popup Cookies -->
<div id="cookiePopup" class="fixed bottom-4 left-4 right-4 md:bottom-24 md:right-6 md:left-auto z-40 bg-gray-50 shadow-2xl rounded-3xl p-6 max-w-sm transform translate-y-full opacity-0 pointer-events-none transition-all duration-700 hidden">
    <div class="flex items-start gap-4">
        <div class="text-4xl">🍪</div>
        <div>
            <h4 class="font-bold text-gray-900 mb-2">Respect de votre vie privée</h4>
            <p class="text-xs text-gray-500 leading-relaxed font-medium mb-4">
                Nous utilisons des cookies pour améliorer votre expérience sur notre site. 
                En continuant, vous acceptez notre utilisation des cookies.
            </p>
            <div class="flex gap-2">
                <button onclick="acceptCookies()" class="bg-sterna-blue text-white text-xs font-bold py-2 px-6 rounded-full hover:bg-sterna-yellow hover:shadow-lg transition-all w-full md:w-auto">Accepter</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Logique Back to Top
    const backToTopBtn = document.getElementById('backToTopBtn');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTopBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-12');
            backToTopBtn.classList.add('opacity-100', 'translate-y-0');
        } else {
            backToTopBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-12');
            backToTopBtn.classList.remove('opacity-100', 'translate-y-0');
        }
    });

    // Logique Cookies
    const cookiePopup = document.getElementById('cookiePopup');
    
    function checkCookies() {
        if (!localStorage.getItem('sternaCookiesAccepted')) {
            cookiePopup.classList.remove('hidden');
            // Léger délai pour l'animation d'entrée (1 seconde après chargement)
            setTimeout(() => {
                cookiePopup.classList.remove('translate-y-full', 'opacity-0', 'pointer-events-none');
            }, 1000);
        }
    }

    function acceptCookies() {
        localStorage.setItem('sternaCookiesAccepted', 'true');
        cookiePopup.classList.add('translate-y-full', 'opacity-0');
        setTimeout(() => {
            cookiePopup.classList.add('hidden');
        }, 700);
    }

    // Lancer la vérification au chargement
    document.addEventListener('DOMContentLoaded', checkCookies);
</script>