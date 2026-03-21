<section class="section-stats-dark" id="impact">
    <div class="container text-center">
        <div class="impact-header mb-5">
            <h2 class="section-title-impact">NOS IMPACTS <span class="text-glow-green">DEPUIS LA CRÉATION</span></h2>
            <div class="title-underline"></div>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-card">
                    <div class="stat-icon icon-blue"><i class="fi fi-rr-users"></i></div>
                    <div class="counter-wrap">
                        <span class="counter" data-target="99552">0</span>
                    </div>
                    <p class="stat-label">Bénéficiaires directs & indirects</p>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-card">
                    <div class="stat-icon icon-yellow"><i class="fi fi-rr-heart"></i></div>
                    <div class="counter-wrap">
                        <span class="counter" data-target="380">0</span>
                    </div>
                    <p class="stat-label">Volontaires adhérents</p>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-card">
                    <div class="stat-icon icon-green"><i class="fi fi-rr-rocket-lunch"></i></div>
                    <div class="counter-wrap">
                        <span class="counter" data-target="203">0</span>
                    </div>
                    <p class="stat-label">Projets & Activités</p>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-card">
                    <div class="stat-icon icon-purple"><i class="fi fi-rr-graduation-cap"></i></div>
                    <div class="counter-wrap">
                        <span class="counter" data-target="1039">0</span>
                    </div>
                    <p class="stat-label">Personnes formées</p>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-card">
                    <div class="stat-icon icon-orange"><i class="fi fi-rr-share"></i></div>
                    <div class="counter-wrap">
                        <span class="counter" data-target="66000">0</span>
                    </div>
                    <p class="stat-label">Communauté en ligne</p>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-card">
                    <div class="stat-icon icon-red"><i class="fi fi-rr-globe"></i></div>
                    <div class="counter-wrap">
                        <span class="counter" data-target="4">0</span>
                    </div>
                    <p class="stat-label">Pays d'intervention</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .section-stats-dark {
        background: #0A0F14;
        padding: 50px 0;
        color: #fff;
        overflow: hidden;
    }

    .text-glow-green {
        color: #2ecc71;
        text-shadow: 0 0 15px rgba(46, 204, 113, 0.5);
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        padding: 10px 15px;
        height: 100%;
        transition: all 0.4s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .stat-card:hover {
        background: rgba(255, 255, 255, 0.06);
        transform: translateY(-10px);
        border-color: rgba(255, 255, 255, 0.2);
    }

    /* Icons Styles */
    .stat-icon {
        font-size: 28px;
        margin-bottom: 20px;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
    }

    .icon-blue {
        color: #4facfe;
        background: rgba(79, 172, 254, 0.1);
    }

    .icon-yellow {
        color: #f5b904;
        background: rgba(245, 185, 4, 0.1);
    }

    .icon-green {
        color: #2ecc71;
        background: rgba(46, 204, 113, 0.1);
    }

    .icon-purple {
        color: #BA68C8;
        background: rgba(186, 104, 216, 0.1);
    }

    .icon-orange {
        color: #FF7043;
        background: rgba(255, 112, 67, 0.1);
    }

    .icon-red {
        color: #eb4d4b;
        background: rgba(235, 77, 75, 0.1);
    }

    /* Counter Typography */
    .counter {
        font-size: 2.2rem;
        font-weight: 900;
        font-family: 'Comic Neue', sans-serif;
        letter-spacing: -1px;
        background: linear-gradient(to bottom, #fff, #94a3b8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stat-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: #94a3b8;
        margin-top: 15px;
        letter-spacing: 0.5px;
        line-height: 1.4;
    }

    .title-underline {
        width: 60px;
        height: 4px;
        background: #2ecc71;
        margin: 20px auto;
        border-radius: 10px;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const counters = document.querySelectorAll(".counter");

        const animateCounter = (el) => {
            const target = +el.getAttribute("data-target");
            const duration = 2500; // Un peu plus lent pour le prestige
            const startTime = performance.now();

            const update = (now) => {
                const elapsed = now - startTime;
                const progress = Math.min(elapsed / duration, 1);

                // Fonction d'accélération (easeOutExpo)
                const easeProgress = 1 - Math.pow(2, -10 * progress);

                const currentCount = Math.floor(easeProgress * target);
                el.innerText = currentCount.toLocaleString();

                if (progress < 1) {
                    requestAnimationFrame(update);
                } else {
                    el.innerText = target.toLocaleString();
                }
            };
            requestAnimationFrame(update);
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.7
        });

        counters.forEach(c => observer.observe(c));
    });
</script>