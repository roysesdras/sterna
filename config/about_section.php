<section class="section-dna-dark" id="about">
    <div class="container">
        <!-- <div class="dna-header">
            <h2 class="comic-neue-bold">Notre <span class="text-gradient">ADN</span></h2>
            <p class="dna-subtitle">Une solidarité enracinée, un impact mesurable à l'horizon 2030.</p>
        </div> -->

        <div class="bento-container">
            <div class="bento-card card-manifesto">
                <i class="fi fi-rr-quote-right quote-bg"></i>
                <p>
                    Association d’Éducation à la Citoyenneté et à la Solidarité Internationale (ECSI), active au <b>Bénin</b>, <b>Côte d’Ivoire</b>, <b>Burkina Faso</b>, <b>Togo</b> et <b>France</b>, notre mission est d’œuvrer pour un monde plus juste et durable, en plaçant les populations locales au cœur de nos initiatives.
                </p>
                <div class="countries-tags">
                    <span class="tag tag-benin">#Bénin</span>
                    <span class="tag tag-togo">#Togo</span>
                    <span class="tag tag-ci">#Côte d'Ivoire</span>
                    <span class="tag tag-burkina">#Burkina-Faso</span>
                    <span class="tag tag-france">#France</span>
                </div>
            </div>

            <div class="bento-card pillar kids">
                <div class="pillar-icon" style="background: rgba(186, 104, 216, 0.2); color: #BA68C8;">
                    <i class="fi fi-rr-user"></i>
                </div>
                <h3>Les Enfants</h3>
                <p>Éducation inclusive et bien-être en milieu rural.</p>
            </div>

            <div class="bento-card pillar women">
                <div class="pillar-icon" style="background: rgba(255, 112, 67, 0.2); color: #FF7043;">
                    <i class="fi fi-rr-venus"></i>
                </div>
                <h3>Les Femmes</h3>
                <p>Autonomie socio-économique et droits.</p>
            </div>

            <div class="bento-card pillar youth">
                <div class="pillar-icon" style="background: rgba(40, 167, 69, 0.2); color: #28A745;">
                    <i class="fi fi-rr-users"></i>
                </div>
                <h3>La Jeunesse</h3>
                <p>Formation des futurs leaders communautaires.</p>
            </div>

            <div class="bento-card pillar eco">
                <div class="pillar-icon" style="background: rgba(100, 181, 246, 0.2); color: #64B5F6;">
                    <i class="fi fi-rr-leaf"></i>
                </div>
                <h3>L'Environnement</h3>
                <p>Solutions locales face au défi climatique.</p>
            </div>
        </div>
    </div>
</section>

<style>
    .section-dna-dark {
        background-color: #0A0F14;
        /* Le noir profond */
        color: #ffffff;
        padding: 20px 0;
    }

    .text-gradient {
        background: linear-gradient(to right, #2ecc71, #64B5F6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .bento-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .bento-card {
        background: rgba(255, 255, 255, 0.03);
        /* Fond très léger */
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        padding: 10px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .bento-card:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-5px);
    }

    .card-manifesto {
        grid-column: span 2;
        grid-row: span 2;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .quote-bg {
        position: absolute;
        top: -10px;
        right: -10px;
        font-size: 8rem;
        opacity: 0.03;
        transform: rotate(-10deg);
    }

    .pillar-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .pillar h3 {
        font-size: 1.25rem;
        margin-bottom: 10px;
    }

    .pillar p {
        font-size: 0.9rem;
        color: #94a3b8;
        line-height: 1.5;
    }

    /* Couleurs de bordure "Glow" au survol */
    .kids:hover {
        border-color: #BA68C8;
        box-shadow: 0 0 20px rgba(186, 104, 216, 0.15);
    }

    .women:hover {
        border-color: #FF7043;
        box-shadow: 0 0 20px rgba(255, 112, 67, 0.15);
    }

    .youth:hover {
        border-color: #28A745;
        box-shadow: 0 0 20px rgba(40, 167, 69, 0.15);
    }

    .eco:hover {
        border-color: #64B5F6;
        box-shadow: 0 0 20px rgba(100, 181, 246, 0.15);
    }

    @media (max-width: 992px) {
        .bento-container {
            grid-template-columns: repeat(2, 1fr);
        }

        .card-manifesto {
            grid-column: span 2;
        }
    }

    .countries-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .tag {
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid transparent;
        transition: all 0.3s ease;
        cursor: default;
    }

    /* Couleurs spécifiques par pays */
    .tag-benin {
        color: #4facfe;
        /* Bleu azur */
        background: rgba(79, 172, 254, 0.1);
        border-color: rgba(79, 172, 254, 0.3);
    }

    .tag-togo {
        color: #f5b904;
        /* Jaune Sterna */
        background: rgba(245, 185, 4, 0.1);
        border-color: rgba(245, 185, 4, 0.3);
    }

    .tag-ci {
        color: #ff9f43;
        /* Orange vif */
        background: rgba(255, 159, 67, 0.1);
        border-color: rgba(255, 159, 67, 0.3);
    }

    .tag-burkina {
        color: #2ecc71;
        /* Vert émeraude */
        background: rgba(46, 204, 113, 0.1);
        border-color: rgba(46, 204, 113, 0.3);
    }

    .tag-france {
        color: #eb4d4b;
        /* Rouge corail doux */
        background: rgba(235, 77, 75, 0.1);
        border-color: rgba(235, 77, 75, 0.3);
    }

    /* Effet au survol des tags */
    .tag:hover {
        transform: scale(1.1);
        filter: brightness(1.3);
        box-shadow: 0 0 15px currentColor;
        /* Crée une aura de la couleur du pays */
    }
</style>