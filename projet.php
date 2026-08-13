<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    header("Location: /a-propos/");
    exit();
}

$slug = $conn->real_escape_string($_GET['slug']);

// Récupérer le projet
$stmt = $conn->prepare("SELECT * FROM projets WHERE slug = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Projet introuvable
    header("Location: /a-propos/");
    exit();
}

$projet = $result->fetch_assoc();
$stmt->close();

// Définition des balises SEO dynamiques pour le projet
$page_title = "Projet : " . $projet['nom'] . " | Sterna Africa";
// Nettoyer la description (enlever le HTML) et la couper à ~160 caractères
$clean_desc = strip_tags(html_entity_decode($projet['description'] ?? ''));
$page_desc = mb_strlen($clean_desc) > 160 ? mb_substr($clean_desc, 0, 157) . '...' : $clean_desc;
if (empty(trim($page_desc))) {
    $page_desc = "Découvrez le projet " . $projet['nom'] . " porté par Sterna Africa.";
}

// Générateur de miniature ultra-légère (pour WhatsApp qui limite fortement la taille en Ko)
function get_seo_thumbnail($image_filename) {
    if (empty($image_filename)) return "https://sternaafrica.org/images/garde.jpg";
    $source_path = $_SERVER['DOCUMENT_ROOT'] . "/images/projets/" . $image_filename;
    if (!file_exists($source_path)) return "https://sternaafrica.org/images/garde.jpg";
    
    $path_info = pathinfo($image_filename);
    $thumb_filename = $path_info['filename'] . '_seo.jpg';
    $thumb_path = $_SERVER['DOCUMENT_ROOT'] . "/images/projets/" . $thumb_filename;
    
    if (!file_exists($thumb_path)) {
        list($width, $height, $type) = getimagesize($source_path);
        $max_dim = 600; // Réduire à max 600px pour WhatsApp
        
        $new_width = $width;
        $new_height = $height;
        if ($width > $max_dim || $height > $max_dim) {
            $ratio = $width / $height;
            if ($width > $height) { $new_width = $max_dim; $new_height = $max_dim / $ratio; }
            else { $new_height = $max_dim; $new_width = $max_dim * $ratio; }
        }
        
        $src = null;
        if ($type == IMAGETYPE_JPEG) $src = @imagecreatefromjpeg($source_path);
        elseif ($type == IMAGETYPE_PNG) $src = @imagecreatefrompng($source_path);
        elseif ($type == IMAGETYPE_WEBP) $src = @imagecreatefromwebp($source_path);
        elseif ($type == IMAGETYPE_GIF) $src = @imagecreatefromgif($source_path);
        
        if ($src) {
            $dst = imagecreatetruecolor((int)$new_width, (int)$new_height);
            $bg = imagecolorallocate($dst, 255, 255, 255); // Fond blanc
            imagefill($dst, 0, 0, $bg);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, (int)$new_width, (int)$new_height, $width, $height);
            imagejpeg($dst, $thumb_path, 65); // Compression à 65% (Généralement < 50Ko)
            imagedestroy($src);
            imagedestroy($dst);
        } else {
            return "https://sternaafrica.org/images/projets/" . $image_filename;
        }
    }
    return "https://sternaafrica.org/images/projets/" . $thumb_filename;
}

$page_image = get_seo_thumbnail($projet['image_main']);
$page_url = "https://sternaafrica.org/projet.php?slug=" . urlencode($projet['slug']);
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/config/head.php'; ?>
<body class="bg-gray-100 font-sans text-gray-800">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/nav.php'; ?>

    <!-- En-tête du Projet -->
    <header class="relative pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden bg-sterna-blue">
        <div class="absolute inset-0">
            <?php if (!empty($projet['image_main'])): ?>
                <img src="/images/projets/<?php echo htmlspecialchars($projet['image_main']); ?>" alt="<?php echo htmlspecialchars($projet['nom']); ?>" class="w-full h-full object-cover opacity-30 scale-105">
            <?php else: ?>
                <div class="w-full h-full bg-sterna-blue opacity-50"></div>
            <?php endif; ?>
            <div class="absolute inset-0 bg-gradient-to-t from-gray-50 to-transparent opacity-90"></div>
            <div class="absolute inset-0 bg-sterna-blue mix-blend-multiply opacity-60"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-sterna-yellow text-sterna-blue text-xs font-bold uppercase tracking-widest mb-4">Projet Sterna Africa</span>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white mb-6 tracking-tight leading-tight">
                <?php echo htmlspecialchars($projet['nom']); ?>
            </h1>
        </div>
    </header>

    <main class="relative z-20 container mx-auto px-4 -mt-10 mb-24">
        
        <div class="bg-gray-100 rounded-3xl shadow-md overflow-hidden">
            <!-- Image Principale -->
            <?php if (!empty($projet['image_main'])): ?>
            <div class="w-full h-64 md:h-96">
                <img src="/images/projets/<?php echo htmlspecialchars($projet['image_main']); ?>" alt="<?php echo htmlspecialchars($projet['nom']); ?>" class="w-full h-full object-cover">
            </div>
            <?php endif; ?>

            <div class="p-4 md:p-8">
                
                <!-- Description -->
                <div class="prose prose-lg max-w-none text-gray-600 mb-12">
                    <h2 class="text-3xl font-black text-sterna-blue mb-6">À propos de ce projet</h2>
                    <?php if (!empty($projet['description'])): ?>
                        <p class="leading-relaxed"><?php echo nl2br(htmlspecialchars($projet['description'])); ?></p>
                    <?php else: ?>
                        <p class="italic text-gray-400">La description détaillée de ce projet sera bientôt disponible.</p>
                    <?php endif; ?>
                </div>

                <!-- Galerie optionnelle -->
                <?php if (!empty($projet['image_2']) || !empty($projet['image_3'])): ?>
                <div class="mt-16 pt-12 border-t border-gray-100">
                    <!-- <h3 class="text-2xl font-black text-sterna-blue mb-8 text-center">Galerie d'images</h3> -->
                    <div class="flex md:grid md:grid-cols-2 gap-4 md:gap-8 overflow-x-auto snap-x snap-mandatory [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden pb-4 md:pb-0">
                        <?php if (!empty($projet['image_2'])): ?>
                        <div class="shrink-0 w-[85%] md:w-auto rounded-2xl overflow-hidden shadow-lg h-64 md:h-80 snap-center">
                            <img src="/images/projets/<?php echo htmlspecialchars($projet['image_2']); ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($projet['image_3'])): ?>
                        <div class="shrink-0 w-[85%] md:w-auto rounded-2xl overflow-hidden shadow-lg h-64 md:h-80 snap-center">
                            <img src="/images/projets/<?php echo htmlspecialchars($projet['image_3']); ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>

        <!-- Section Actualités du Projet -->
        <div class="mt-16">
            <h3 class="text-3xl font-black text-[#0f277e] mb-8 text-left" style="font-family: 'Cabin Sketch', cursive;">
                Les actions de ce projet
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="actualites-container">
                <!-- Les actualités seront chargées ici via AJAX -->
            </div>

            <div class="text-center mt-12" id="load-more-container" style="display: none;">
                <button id="load-more" class="group relative inline-flex items-center justify-center px-8 py-3 font-bold text-white transition-all duration-200 bg-[#0f277e] hover:bg-blue-900 font-pj rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0f277e]">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-plus-circle text-[#ea750fff] group-hover:rotate-180 transition-transform duration-500"></i>
                        Afficher plus d'actualités
                    </span>
                </button>
            </div>
        </div>
        
        <div class="text-left mt-12">
            <a href="/a-propos/" class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-8 rounded-xl transition-colors">
                <i class="fi fi-rr-arrow-small-left mt-1"></i> Retour aux projets
            </a>
        </div>

    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/footer_2.php'; ?>

    <!-- Styles et Scripts pour les actualités -->
    <link href="https://fonts.googleapis.com/css2?family=Cabin+Sketch:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .cabin-sketch {
            font-family: 'Cabin Sketch', cursive;
        }
        .fade-in-card {
            animation: fadeIn 0.6s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let offset = 0;
        let limit = 12;
        let projet_id = <?php echo intval($projet['id']); ?>;

        function loadActualites() {
            const btn = $("#load-more");
            btn.addClass('opacity-50 cursor-not-allowed').html('<i class="fas fa-spinner fa-spin"></i> Chargement...');

            $.ajax({
                url: "/old/actualite/recharge_actualite.php",
                type: "GET",
                data: {
                    offset: offset,
                    limit: limit,
                    projet_id: projet_id
                },
                success: function(data) {
                    if (data.trim() === "no_more") {
                        $("#load-more-container").fadeOut();
                        if (offset === 0) {
                            $("#actualites-container").html('<p class="text-gray-500 italic text-center col-span-full">Aucune actualité liée à ce projet pour le moment.</p>');
                        }
                    } else {
                        const $newItems = $(data).addClass('fade-in-card');
                        $("#actualites-container").append($newItems);
                        offset += limit;
                        $("#load-more-container").fadeIn();
                        btn.removeClass('opacity-50 cursor-not-allowed').html('<span class="flex items-center gap-2"><i class="fas fa-plus-circle text-[#ea750fff]"></i> Afficher plus d\'actualités</span>');
                    }
                }
            });
        }

        $(document).ready(function() {
            loadActualites();
            $("#load-more").click(function() {
                loadActualites();
            });
        });
    </script>
</body>
</html>
