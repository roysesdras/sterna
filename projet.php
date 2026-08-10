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

    <main class="relative z-20 max-w-5xl mx-auto px-4 -mt-10 mb-24">
        
        <div class="bg-gray-100 rounded-3xl shadow-xl overflow-hidden">
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
                    <h3 class="text-2xl font-black text-sterna-blue mb-8 text-center">Galerie d'images</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <?php if (!empty($projet['image_2'])): ?>
                        <div class="rounded-2xl overflow-hidden shadow-lg h-64 md:h-80">
                            <img src="/images/projets/<?php echo htmlspecialchars($projet['image_2']); ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($projet['image_3'])): ?>
                        <div class="rounded-2xl overflow-hidden shadow-lg h-64 md:h-80">
                            <img src="/images/projets/<?php echo htmlspecialchars($projet['image_3']); ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="/a-propos/" class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-8 rounded-xl transition-colors">
                <i class="fi fi-rr-arrow-small-left mt-1"></i> Retour aux projets
            </a>
        </div>

    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/footer_2.php'; ?>
</body>
</html>
