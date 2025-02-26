<!-- Section Actualités -->
<?php if (count($actualites) > 0): ?>
    <?php
    $count = 0;
    $max_activities = 6;
    ?>
    <?php foreach ($actualites as $actualite): ?>
        <?php if ($count < $max_activities): ?>
            <div class="col-md-4">
                <div class="mb-4">
                    <a href="./actualite/<?php echo $actualite['id']; ?>"><img class="w-100" style="border-radius: 5px 5px 0px 0px;" src="images/<?php echo $actualite['image']; ?>" alt="<?php echo $actualite['title']; ?>"></a>
                    <div class="card-body">
                        <h5 class="card-title comic-neue-regular"><?php echo $actualite['title']; ?></h5>
                        <!-- <p class="mb-1 text-body-secondary comic-neue-regular">Du <?php //echo $actualite['start_date']; ?> au <?php //echo $actualite['end_date']; ?></p> -->
                        <a href="./actualite/<?php echo $actualite['id']; ?>" class="icon-link gap-1 icon-link-hover comic-neue-regular"> Lir la suite 
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php $count++; ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>
    <div class="col-md-12">
        <p>Aucune actualité disponible pour le moment.</p>
    </div>
<?php endif; ?>