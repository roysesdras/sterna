<?php
// 1. On définit $today en premier pour qu'il soit disponible pour le tri
$today = strtotime(date('Y-m-d'));

// 2. Tri intelligent : "En cours" et "À venir" d'abord, "Terminés" à la fin
usort($missions, function($a, $b) use ($today) {
    $timeA_end = strtotime($a['end_date']);
    $timeB_end = strtotime($b['end_date']);
    $timeA_start = strtotime($a['start_date']);
    $timeB_start = strtotime($b['start_date']);
    
    // Si l'un est fini et l'autre non, on remonte celui qui n'est pas fini
    if ($timeA_end < $today && $timeB_end >= $today) return 1;
    if ($timeA_end >= $today && $timeB_end < $today) return -1;
    
    // Si les deux sont dans la même catégorie, on trie par date de début (le plus proche en premier)
    return $timeA_start - $timeB_start;
});
?>

<div class="space-y-8 sticky top-24">
    <div class="bg-white p-6 rounded-2xl shadow-sm border-t-4 border-sterna-blue">
        <h2 class="text-xl font-black text-sterna-orange mb-8 uppercase tracking-tighter">Événements & Missions</h2>
        
        <div class="space-y-8">
            <?php if (count($missions) > 0): ?>
                <?php
                $moisFr = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
                $count = 0;

                foreach ($missions as $mission):
                    if ($count >= 8) break; 

                    $start = strtotime($mission['start_date']);
                    $end   = strtotime($mission['end_date']);

                    // Couleurs basées sur le statut réel
                    if ($end < $today) {
                        $accentClass = "text-gray-400";
                        $hoverColor = "group-hover:bg-gray-400"; // Clôturé
                        $statusText = "Terminé";
                    } elseif ($start <= $today && $end >= $today) {
                        $accentClass = "text-sterna-orange";
                        $hoverColor = "group-hover:bg-sterna-orange"; // En cours
                        $statusText = "En cours";
                    } else {
                        $accentClass = "text-sterna-rose";
                        $hoverColor = "group-hover:bg-sterna-rose"; // À venir
                        $statusText = "À venir";
                    }

                    $jour = date('d', $start);
                    $mois = $moisFr[date('n', $start) - 1];
                    $lieu = htmlspecialchars($mission['lieu']);
                    $mission_link = "/evenement/" . $mission['id'];
                ?>

                    <div class="flex items-center space-x-5 group cursor-pointer" onclick="window.location.href='<?php echo $mission_link; ?>'">
                        <div class="bg-gray-50 text-sterna-blue p-3 rounded-xl text-center min-w-[60px] <?php echo $hoverColor; ?> group-hover:text-white transition-colors duration-300">
                            <span class="block text-xl font-black"><?php echo $jour; ?></span>
                            <span class="text-[9px] font-bold uppercase tracking-widest"><?php echo $mois; ?></span>
                        </div>

                        <div>
                            <h4 class="font-black text-sm text-sterna-blue leading-tight uppercase group-hover:text-sterna-yellow transition-colors">
                                <?php echo htmlspecialchars($mission['title']); ?>
                            </h4>
                            <p class="text-[11px] text-gray-400 font-bold mt-1 uppercase tracking-tighter italic">
                                <?php echo $lieu; ?> • 
                                <span class="text-[9px] <?php echo $accentClass; ?>">
                                    <?php echo $statusText; ?>
                                </span>
                            </p>
                        </div>
                    </div>

                <?php 
                    $count++;
                endforeach; 
                ?>
            <?php else: ?>
                <p class="text-[11px] text-gray-400 font-bold text-center py-4 italic uppercase">Aucune mission à l'horizon.</p>
            <?php endif; ?>
        </div>

        <!-- <a href="/agenda" class="block w-full text-center mt-10 py-3 border-2 border-urunani-rose text-urunani-rose font-black text-[10px] uppercase tracking-[0.2em] rounded-lg hover:bg-urunani-rose hover:text-white transition-all shadow-sm">
            Tout l'agenda
        </a> -->
    </div>
</div>