<?php 
// Supposons que $missions et $actualites soient des tableaux d'associations représentant chaque mission et actualité respectivement

// Initialisation de la variable $isActive pour le premier élément actif dans le carousel
$isActive = true;

?>

<div id="carouselExampleInterval" class="carousel slide mb-4 pt-0" data-bs-ride="carousel">
    <div class="carousel-inner">

        <?php
        // Boucle pour les missions
        foreach ($missions as $mission) {
            $mission_id = $mission['id'];
            $mission_image = $mission['image'];
            $mission_title = $mission['title'];
            $mission_video = $mission['video'];
            $mission_link = "https://sternaafrica.org/evenement/" . $mission_id;
            ?>

            <div class="carousel-item <?php echo $isActive ? 'active' : ''; ?>" data-bs-interval="2000">
                <a href="<?php echo $mission_link; ?>">
                    <?php if (!empty($mission_video)): ?>
                        <div class="ratio ratio-16x9">
                            <iframe class="d-block w-100" src="https://www.youtube.com/embed/<?php echo htmlspecialchars($mission_video); ?>" allowfullscreen></iframe>
                        </div>
                    <?php else: ?>
                        <img src="images/<?php echo ($mission_image); ?>" class="d-block w-100" alt="Mission Image">
                    <?php endif; ?>
                    <div class="carousel-caption component">
                        <a href="<?php echo $mission_link; ?>" class="comic-neue-regular" ><i class="fas fa-quote-left"></i> A venir : <br> <?php echo ($mission_title); ?></a>
                    </div>
                </a>
            </div>

            <?php
            $isActive = false; // Seul le premier élément doit être actif
        }
        // Boucle pour les actualites
        foreach ($actualites as $actualite) {
            $actualite_id = $actualite['id'];
            $actualite_image = $actualite['image'];
            $actualite_title = $actualite['title'];
            $actualite_link = "https://sternaafrica.org/actualite/" . $actualite_id;
            ?>

            
            <div class="carousel-item <?php echo $isActive ? 'active' : ''; ?>" data-bs-interval="2000">
                <a href="<?php echo $actualite_link; ?>">
                    <img src="images/<?php echo $actualite_image; ?>" class="d-block w-100" alt="Actualité Image">
                    <div class="carousel-caption component">
                        <a href="<?php echo $actualite_link; ?>" type="button" class="comic-neue-regular" ><i class="fas fa-quote-left"></i> Actualité : <br> <?php echo $actualite_title; ?></a>
                    </div>
                </a>
            </div>
           

            <?php
            $isActive = false; // Seul le premier élément doit être actif
        }
        ?>

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>

</div>
