<footer class="relative overflow-hidden py-8" style="background: linear-gradient(135deg, #034890 0%, #034890 100%);">


    <div class="max-w-7xl mx-auto px-2 relative z-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            
            <div class="flex flex-col md:flex-row items-center gap-2 md:gap-4">
                <img src="/assets/img/external/84e554fe99_sternaofficiel-2.png" alt="Sterna" class="h-6 w-auto brightness-0 invert opacity-80 mb-2 md:mb-0">
                <p class="text-[11px] font-bold text-white/40 uppercase tracking-[0.2em]">
                    © 2026 Sterna Africa — <span class="text-white/80">Wherever Needed</span>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Bouton Back to Top avec Mascotte -->
<button id="backToTopBtn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-6 right-6 md:bottom-8 md:right-8 z-50 flex items-center justify-center transition-all duration-500 opacity-0 pointer-events-none translate-y-12 group focus:outline-none" aria-label="Retour en haut">
    <img src="/assets/img/external/478a9bc9cc_mascort1.png" alt="Remonter" class="w-16 h-16 md:w-20 md:h-20 object-contain drop-shadow-[0_8px_15px_rgba(0,0,0,0.2)] group-hover:-translate-y-4 group-hover:scale-110 transition-all duration-300 animate-[bounce_3s_infinite]">
</button>

<!-- Popup Cookies avec Mascotte -->
<div id="cookiePopup" class="fixed bottom-4 left-4 right-4 md:bottom-24 md:right-6 md:left-auto z-40 bg-gray-50 shadow-2xl rounded-3xl p-6 max-w-sm transform translate-y-full opacity-0 pointer-events-none transition-all duration-700 hidden">
    <div class="flex items-start gap-4">
        <div class="shrink-0">
            <img src="/assets/img/external/baf0f05e37_mascotte2.png" alt="Mascotte Cookies" class="w-16 h-16 object-contain">
        </div>
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