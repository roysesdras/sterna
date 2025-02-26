
<?php 
// Fonction de comparaison pour trier par date de début
function compareByStartDate($a, $b) {
    $dateA = strtotime($a['start_date']);
    $dateB = strtotime($b['start_date']);
    return $dateA <=> $dateB;
}

// Triez le tableau $missions en utilisant la fonction de comparaison
usort($missions, 'compareByStartDate');

// Maintenant, affichez les missions triées
if (count($missions) > 0): ?>
    <div class="mission-container-wrapper">
        <?php foreach ($missions as $mission): ?>
            <div class="col-md-12 mb-2 me-2 mission-container">

                <?php if (!empty($mission['video'])): ?>

                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/<?php echo htmlspecialchars($mission['video']); ?>" allowfullscreen></iframe>
                    </div>

                <?php else: ?>
                    <a class="comic-neue-bold" href="./evenement/<?php echo htmlspecialchars($mission['id']); ?>">
                        <img src="images/<?php echo htmlspecialchars($mission['image']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($mission['title']); ?>" style="border-radius: 5px 5px 0px 0px;">
                    </a>
                <?php endif; ?>

                <h4 class="card-title comic-neue-bold">
                    <?php 
                    $title = htmlspecialchars($mission['title']); // Éviter les problèmes de sécurité
                    echo (strlen($title) > 30) ? substr($title, 0, 29) . '...' : $title;
                    ?>
                </h4>

                <div class="comic-neue-regular mission-description" style="font-size: 18px;">
                    <?php echo (substr($mission['description'], 0, 50)); ?> à <?php echo htmlspecialchars($mission['lieu']); ?> ...
                    <a class="comic-neue-regular" href="./evenement/<?php echo htmlspecialchars($mission['id']); ?>" style="font-size: 20px;">
                        <br>En savoir +
                    </a>
                </div>

                <!-- <hr> -->
            </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>
        <p>Aucune activité en cours pour le moment.</p>
    <?php endif; ?>
