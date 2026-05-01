<?php
// Récupérer les 12 actualités récentes (en excluant l'actuelle si on est sur une page de détail)
$current_id = isset($actualite_id) ? intval($actualite_id) : 0;
$sql = "SELECT * FROM actualites WHERE id != $current_id ORDER BY start_date DESC LIMIT 12";
$result_actualites = $conn->query($sql);

$actualites = [];
if ($result_actualites) {
    while ($row = $result_actualites->fetch_assoc()) {
        $actualites[] = $row;
    }
}

shuffle($actualites);

// Couleurs thématiques 2026 (plus douces et saturées)
$classes = [
    'Bénin'          => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30',
    'Togo'           => 'bg-red-500/20 text-red-400 border-red-500/30',
    'Côte d\'Ivoire' => 'bg-orange-500/20 text-orange-400 border-orange-500/30',
    'Sénégal'        => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
    'France'         => 'bg-indigo-500/20 text-indigo-400 border-indigo-500/30',
];
?>

<div class="mt-16 mb-12">
    <h3 class="font-comic text-xl font-bold text-orange-500 mb-6 flex items-center gap-2">
        <i class="fi fi-rr- Ter-actualite text-sternaYellow"></i> Vous pourriez aussi aimer
    </h3>

    <div class="flex overflow-x-auto gap-6 pb-6 snap-x snap-mandatory scrollbar-hide scroll-smooth" style="scrollbar-width: none; -ms-overflow-style: none;">
        <?php foreach ($actualites as $actualite):
            $lieu = htmlspecialchars($actualite['lieu']);
            $badge_style = "bg-slate-800 text-slate-400 border-white/5"; // Défaut

            foreach ($classes as $pays => $style) {
                if (stripos($lieu, $pays) !== false) {
                    $badge_style = $style;
                    break;
                }
            }
            $short_title = (mb_strlen($actualite['title']) > 55) ? mb_substr($actualite['title'], 0, 55) . '...' : $actualite['title'];
        ?>
            <div class="min-w-[240px] md:min-w-[280px] snap-start group">
                <a href="../actualite/<?php echo $actualite['id']; ?>" class="block">
                    <div class="relative h-40 rounded-2xl overflow-hidden mb-3 border border-white/5 shadow-lg group-hover:border-sternaYellow/50 transition-all duration-500">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            src="../images/<?php echo $actualite['image']; ?>"
                            alt="<?php echo html_entity_decode($actualite['title'], ENT_QUOTES, 'UTF-8'); ?>">

                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

                        <span class="absolute bottom-2 left-2 text-[9px] font-black uppercase tracking-tighter px-2 py-0.5 rounded border backdrop-blur-sm <?php echo $badge_style; ?>">
                            <?php echo $lieu; ?>
                        </span>
                    </div>

                    <h4 class="text-sm font-bold text-gray-800 leading-snug group-hover:text-sternaYellow transition-colors line-clamp-2">
                        <?php echo html_entity_decode($short_title, ENT_QUOTES, 'UTF-8'); ?>
                    </h4>
                    <p class="text-[10px] text-gray-500 mt-1 uppercase tracking-widest font-bold">
                        <?= date('M Y', strtotime($actualite['start_date'])) ?>
                    </p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    /* Masquer la scrollbar pour un look "App mobile" sur Chrome/Safari */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>