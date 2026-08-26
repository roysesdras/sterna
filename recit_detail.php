<?php
require_once __DIR__ . '/config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$volontaire = null;

if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM pont_solidaire WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows > 0) {
        $volontaire = $res->fetch_assoc();
    }
    $stmt->close();
}

if (!$volontaire) {
    header("Location: /#pont-solidaire");
    exit;
}

// Extraction des images d'expérience
$images_exp = !empty($volontaire['images_experience']) ? explode(',', $volontaire['images_experience']) : [];
?>
<?php include __DIR__ . '/config/head.php'; ?>

<body class="bg-gray-50 font-sans text-gray-800">

    <?php include __DIR__ . '/config/nav.php'; ?>

    <!-- Banner -->
    <section class="py-12 md:py-16 bg-sterna-blue text-white relative overflow-hidden">
        <!-- Background image of the respondent -->
        <img src="<?php echo htmlspecialchars($volontaire['photo_volontaire']); ?>?v=<?php echo @filemtime($_SERVER['DOCUMENT_ROOT'] . $volontaire['photo_volontaire']); ?>" 
             alt="" 
             class="absolute inset-0 w-full h-full object-cover opacity-30 blur-md pointer-events-none z-0" aria-hidden="true">

        <div class="max-w-5xl mx-auto px-4 relative z-10">
            <a href="/#pont-solidaire" class="inline-flex items-center gap-2 text-sterna-yellow font-bold text-xs uppercase tracking-wider mb-6 hover:underline">
                <i class="fi fi-rr-arrow-left"></i> Retour au Pont Solidaire
            </a>

            <div class="flex flex-col md:flex-row items-center gap-8">
                <!-- Photo du volontaire -->
                <div class="w-40 h-56 md:w-48 md:h-64 rounded-2xl overflow-hidden border-4 border-sterna-yellow shadow-2xl shrink-0 relative bg-gray-900 flex items-center justify-center">
                    <!-- Image Floue de fond pour remplir l'espace -->
                    <img src="<?php echo htmlspecialchars($volontaire['photo_volontaire']); ?>?v=<?php echo @filemtime($_SERVER['DOCUMENT_ROOT'] . $volontaire['photo_volontaire']); ?>" 
                         class="absolute inset-0 w-full h-full object-cover blur-xl opacity-50 scale-110" aria-hidden="true">
                    
                    <!-- Image Principale Entière -->
                    <img src="<?php echo htmlspecialchars($volontaire['photo_volontaire']); ?>?v=<?php echo @filemtime($_SERVER['DOCUMENT_ROOT'] . $volontaire['photo_volontaire']); ?>" 
                         alt="<?php echo htmlspecialchars($volontaire['nom_complet']); ?>" 
                         class="relative z-10 w-full h-full object-contain">
                </div>

                <div class="text-center md:text-left flex-1">
                    <!-- Badge type relation -->
                    <?php 
                    $relation_label = '';
                    $relation_class = 'bg-sterna-yellow text-sterna-blue';
                    if ($volontaire['type_relation'] === 'sud_nord') {
                        $relation_label = 'Sud ➔ Nord';
                        $relation_class = 'bg-blue-100 text-sterna-blue';
                    } elseif ($volontaire['type_relation'] === 'nord_sud') {
                        $relation_label = 'Nord ➔ Sud';
                        $relation_class = 'bg-amber-100 text-amber-900';
                    } else {
                        $relation_label = 'Sud ➔ Sud';
                        $relation_class = 'bg-emerald-100 text-emerald-900';
                    }
                    ?>
                    <span class="px-3.5 py-1 rounded-full text-xs font-black uppercase tracking-wider <?php echo $relation_class; ?> inline-block mb-3">
                        <?php echo $relation_label; ?> : <?php echo htmlspecialchars($volontaire['pays_provenance']); ?> <i class="fi fi-rr-arrow-right text-[10px]"></i> <?php echo htmlspecialchars($volontaire['pays_reception']); ?>
                    </span>

                    <h1 class="text-3xl md:text-5xl font-black uppercase tracking-tight text-white mb-1">
                        <?php echo htmlspecialchars($volontaire['nom_complet']); ?>
                    </h1>

                    <?php if (!empty($volontaire['structure_envoi'])): ?>
                        <p class="text-xs md:text-sm font-bold text-sterna-yellow uppercase tracking-wider mb-3 flex items-center gap-1.5 justify-center md:justify-start">
                            <i class="fi fi-rr-building"></i> Org. d'envoi : <?php echo htmlspecialchars($volontaire['structure_envoi']); ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($volontaire['date_debut']) || !empty($volontaire['date_fin'])): ?>
                        <p class="text-xs text-blue-100 font-bold uppercase tracking-widest">
                            <i class="fi fi-rr-calendar"></i> Mission : 
                            <?php 
                            if (!empty($volontaire['date_debut'])) echo date('d/m/Y', strtotime($volontaire['date_debut']));
                            if (!empty($volontaire['date_fin'])) echo ' au ' . date('d/m/Y', strtotime($volontaire['date_fin']));
                            ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenu principal du récit -->
    <main class="max-w-4xl mx-auto px-4 py-12">
        <div class="bg-white rounded-3xl p-6 md:p-10 shadow-xl border border-gray-100 space-y-10">

            <!-- Récit principal -->
            <div>
                <h3 class="text-xl font-black text-sterna-blue uppercase tracking-tight mb-4 pb-2 border-b-2 border-sterna-yellow flex items-center gap-2">
                    <i class="fi fi-rr-quote-right text-sterna-yellow"></i> Récit du Volontaire
                </h3>
                <div class="text-gray-700 leading-relaxed text-base font-medium space-y-1">
                    <?php echo nl2br(htmlspecialchars($volontaire['recit'])); ?>
                </div>
            </div>

            <!-- Questions de guidage (si remplies) -->
            <?php if (!empty($volontaire['question_1']) || !empty($volontaire['question_2']) || !empty($volontaire['question_3']) || !empty($volontaire['question_4'])): ?>
                <div class="space-y-6 bg-gray-50 p-6 md:p-8 rounded-3xl border border-gray-100">
                    <h3 class="text-lg font-black text-sterna-blue uppercase tracking-tight mb-2">
                        <i class="fi fi-rr-comments text-sterna-yellow"></i> Questions & Réponses
                    </h3>

                    <?php if (!empty($volontaire['question_1'])): ?>
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                            <h4 class="text-xs font-black uppercase text-sterna-blue mb-1">
                                Quel a été le moment le plus marquant ou le plus inattendu de votre mission ?
                            </h4>
                            <p class="text-sm text-gray-700 font-medium">
                                "<?php echo htmlspecialchars($volontaire['question_1']); ?>"
                            </p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($volontaire['question_2'])): ?>
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                            <h4 class="text-xs font-black uppercase text-sterna-blue mb-1">
                                Qu'est-ce qui vous a le plus surpris ou dépaysé sur place ?
                            </h4>
                            <p class="text-sm text-gray-700 font-medium">
                                "<?php echo htmlspecialchars($volontaire['question_2']); ?>"
                            </p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($volontaire['question_3'])): ?>
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                            <h4 class="text-xs font-black uppercase text-sterna-blue mb-1">
                                Comment cette expérience a-t-elle changé votre regard ou votre façon de voir les choses ?
                            </h4>
                            <p class="text-sm text-gray-700 font-medium">
                                "<?php echo htmlspecialchars($volontaire['question_3']); ?>"
                            </p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($volontaire['question_4'])): ?>
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                            <h4 class="text-xs font-black uppercase text-sterna-blue mb-1">
                                Un mot ou un conseil pour les futurs volontaires ?
                            </h4>
                            <p class="text-sm text-gray-700 font-medium">
                                "<?php echo htmlspecialchars($volontaire['question_4']); ?>"
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Galerie de photos d'expérience -->
            <?php if (!empty($images_exp)): ?>
                <div>
                    <h3 class="text-xl font-black text-sterna-blue uppercase tracking-tight mb-4 pb-2 border-b-2 border-sterna-yellow flex items-center gap-2">
                        <i class="fi fi-rr-picture text-sterna-yellow"></i> Photos Souvenirs de la Mission
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <?php foreach ($images_exp as $img_path): ?>
                            <?php if (!empty(trim($img_path))): ?>
                                <div class="h-56 md:h-64 rounded-2xl overflow-hidden shadow-md group relative bg-gray-900 flex items-center justify-center">
                                    <!-- Image Floue de fond pour remplir l'espace -->
                                    <img src="<?php echo htmlspecialchars(trim($img_path)); ?>" 
                                         class="absolute inset-0 w-full h-full object-cover blur-xl opacity-50 scale-110" aria-hidden="true">
                                    
                                    <!-- Image Principale Entière -->
                                    <img src="<?php echo htmlspecialchars(trim($img_path)); ?>" 
                                         alt="Photo d'expérience" 
                                         class="relative z-10 w-full h-full object-contain group-hover:scale-105 transition-transform duration-500">
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Bouton Retour -->
            <div class="pt-6 border-t border-gray-100 text-center">
                <a href="/#pont-solidaire" class="inline-flex items-center gap-2 px-6 py-3 bg-sterna-blue text-white font-bold rounded-2xl hover:bg-blue-900 transition-all text-sm">
                    <i class="fi fi-rr-arrow-left"></i> Découvrir d'autres volontaires
                </a>
            </div>

        </div>
    </main>

    <?php include __DIR__ . '/config/footer_2.php'; ?>

</body>
</html>
