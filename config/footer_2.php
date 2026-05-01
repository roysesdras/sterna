<footer class="mt-auto py-6 border-t border-white/5 bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">

            <div class="text-slate-500 text-sm comic-neue tracking-wide">
                &copy; <span id="year"></span>
                <span class="text-gray-600 font-bold ml-1 uppercase">Sterna Africa International</span>
                <span class="mx-2 text-slate-700">|</span>
                <span class="text-orange-500/80 italic">Wherever Needed</span>
            </div>

            <div class="flex items-center gap-6">
                <a href="https://twitter.com/AfricaSterna" class="text-slate-500 hover:text-gray-600 transition-colors">
                    <i class="fi fi-brands-twitter-alt text-lg"></i>
                </a>
                <a href="https://www.instagram.com/associationsterna/" class="text-slate-500 hover:text-pink-500 transition-colors">
                    <i class="fab fa-instagram text-lg"></i>
                </a>
                <a href="https://www.linkedin.com/..." class="text-slate-500 hover:text-blue-600 transition-colors">
                    <i class="fab fa-linkedin text-lg"></i>
                </a>
            </div>
        </div>
    </div>
</footer>

<script>
    // Mise à jour automatique de l'année
    document.getElementById('year').textContent = new Date().getFullYear();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

<style>
    /* Pour assurer que le footer reste en bas (Sticky Footer) */
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    main,
    .container {
        flex-grow: 1;
        /* Pousse le footer vers le bas */
    }

    /* .comic-neue {
        font-family: 'Comic Neue', cursive;
    } */
</style>