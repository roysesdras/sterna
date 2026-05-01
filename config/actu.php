<div class="lg:col-span-2">
    <h2 class="text-3xl font-black text-sterna-blue mb-10 border-l-8 border-sterna-orange pl-6 inline-block uppercase tracking-tight">
        Actualités du Réseau
    </h2>

    <div class="space-y-12">
        <?php if (count($actualites) > 0): ?>
            <?php
            $count = 0;
            $max_activities = 8;
            
            // On définit les couleurs basées sur votre nouvelle charte Urunani
            $classes_pays = [
                "Côte d'Ivoire" => "text-sterna-orange",
                "Bénin" => "text-sterna-blue",
                "France" => "text-sterna-orange",
                "Burkina-Faso" => "text-sterna-blue",
                "Togo" => "text-sterna-keppel",
            ];

            foreach ($actualites as $actualite):
                if ($count >= $max_activities) break;

                $lieu = htmlspecialchars($actualite['lieu']);
                $color_class = "text-gray-500"; // Couleur par défaut

                foreach ($classes_pays as $pays => $couleur) {
                    if (stripos($lieu, $pays) !== false) {
                        $color_class = $couleur;
                        break;
                    }
                }
                
                $actualite_link = "./actualite/" . $actualite['id'];
            ?>

                <article class="flex flex-col md:flex-row gap-6 group cursor-pointer" onclick="window.location.href='<?php echo $actualite_link; ?>'">
                    <div class="w-full md:w-72 h-48 bg-gray-100 rounded-xl overflow-hidden shrink-0 relative">
                        <?php $title_for_alt = htmlspecialchars(html_entity_decode($actualite['title'])); ?>
                        <img src="images/<?php echo $actualite['image']; ?>" 
                             alt="<?php echo $title_for_alt; ?>" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-urunani-blue opacity-0 group-hover:opacity-20 transition-opacity"></div>
                    </div>

                    <div>
                        <span class="<?php echo $color_class; ?> font-bold text-[10px] uppercase tracking-widest">
                            <?php echo $lieu; ?> • <?= date('d M Y', strtotime($actualite['end_date'])) ?>
                        </span>
                        
                        <h3 class="text-2xl font-black text-sterna-blue mt-2 group-hover:<?php echo $color_class; ?> transition-colors leading-tight">
                            <?php
                            $title = $actualite['title'];
                            echo (mb_strlen($title) > 65) ? mb_substr($title, 0, 65) . '...' : $title;
                            ?>
                        </h3>

                        <p class="text-gray-600 mt-3 text-sm leading-relaxed line-clamp-3 font-medium">
                            Découvrez les détails de notre action à <?php echo $lieu; ?>. Sterna Africa continue de s'engager pour l'Éducation à la Citoyenneté et à la Solidarité Internationale.
                        </p>

                        <a href="<?php echo $actualite_link; ?>" 
                           class="inline-block mt-4 text-urunani-blue font-bold border-b-2 border-urunani-orange text-xs uppercase tracking-tighter">
                            Lire la suite &rarr;
                        </a>
                    </div>
                </article>

            <?php 
                $count++;
            endforeach; 
            ?>
        <?php else: ?>
            <div class="p-10 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 text-center">
                <p class="text-gray-500 font-medium">Aucune actualité pour le moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>