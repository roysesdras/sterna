<?php
// 404.php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Introuvable | Sterna Africa</title>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/head.php'; ?>
</head>
<body class="bg-gray-50 font-sans text-gray-800 flex flex-col min-h-screen">
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/nav.php'; ?>
    
    <main class="flex-grow flex items-center justify-center py-20 px-4">
        <div class="max-w-2xl w-full text-center">
            <!-- Mascotte 4 (surprise) -->
            <div class="relative w-48 h-48 mx-auto mb-8">
                <img src="https://i.postimg.cc/26dk0Yw3/Whats-App-Image-2026-08-15-at-5-15-14-PM-removebg-preview.png" alt="Mascotte Perdue" class="absolute inset-0 w-full h-full object-contain drop-shadow-2xl hover:scale-110 transition-transform duration-300">
            </div>
            
            <h1 class="text-6xl md:text-8xl font-black text-sterna-blue mb-4">404</h1>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">Oups ! Ce chemin ne mène nulle part.</h2>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">Il semblerait que vous vous soyez perdu. La page que vous cherchez n'existe pas ou a été déplacée.</p>
            
            <a href="/" class="inline-flex items-center gap-2 bg-sterna-blue text-white font-bold px-8 py-4 rounded-full hover:bg-sterna-yellow hover:text-sterna-blue hover:shadow-lg transition-all">
                <i class="fi fi-rr-home"></i> Retour à l'accueil
            </a>
        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/footer.php'; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/footer_2.php'; ?>
</body>
</html>
