<?php
// contact/index.php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous | Sterna Africa</title>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/head.php'; ?>
</head>
<body class="bg-gray-100 font-sans text-gray-800">
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/nav.php'; ?>
    
    <!-- En-tête de la page -->
    <header class="relative bg-sterna-blue py-20 text-center text-white overflow-hidden">
        <div class="relative z-10 max-w-4xl mx-auto px-4 mt-8">
            <h1 class="text-4xl md:text-5xl font-black uppercase tracking-widest mb-4">Restons en <span class="text-sterna-yellow">Contact</span></h1>
            <p class="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto">Vous avez une question, un projet ou envie de rejoindre notre aventure ? Écrivez-nous, nous vous répondrons avec le sourire !</p>
        </div>
        <!-- SVG Divider -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none translate-y-1">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-12 fill-current text-gray-50">
                <path d="M1200 120L0 120 0 0 1200 120z"></path>
            </svg>
        </div>
    </header>

    <!-- Contenu Principal -->
    <main class="max-w-7xl mx-auto px-4 py-16">
        <div class="flex flex-col lg:flex-row gap-12 items-start mt-8">
            
            <!-- Informations de Contact -->
            <div class="lg:w-1/3 space-y-8">
                <!-- Mascotte 3 qui dit bonjour -->
                <div class="relative bg-white rounded-3xl p-8 shadow-xl text-center border border-gray-100 overflow-visible mt-12">
                    <img src="/assets/img/external/8497d6acd9_Whats-App-Image-2026-08-15-at-5-15-13-PM-removebg-preview.png" alt="Mascotte Sterna" class="absolute -top-16 left-1/2 transform -translate-x-1/2 w-32 h-32 object-contain drop-shadow-xl animate-[bounce_3s_infinite]">
                    <div class="mt-16">
                        <h3 class="text-2xl font-black text-sterna-blue mb-2">Besoin d'aide ?</h3>
                        <p class="text-gray-500 text-sm mb-6">Notre équipe est là pour vous écouter et vous accompagner dans toutes vos démarches de solidarité.</p>
                        
                        <div class="space-y-4 text-left">
                            <div class="flex items-center gap-4 text-gray-600">
                                <div class="w-10 h-10 rounded-full bg-blue-50 text-sterna-blue flex items-center justify-center text-xl shrink-0"><i class="fi fi-rr-marker"></i></div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm uppercase">Notre Adresse</h4>
                                    <p class="text-sm">Bordeaux, France (Siège Social)</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 text-gray-600">
                                <div class="w-10 h-10 rounded-full bg-orange-50 text-sterna-yellow flex items-center justify-center text-xl shrink-0"><i class="fi fi-rr-envelope"></i></div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm uppercase">E-mail</h4>
                                    <p class="text-sm">sternaafrica@gmail.com</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 text-gray-600">
                                <div class="w-10 h-10 rounded-full bg-blue-50 text-sterna-blue flex items-center justify-center text-xl shrink-0"><i class="fi fi-rr-phone-call"></i></div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm uppercase">Téléphone</h4>
                                    <p class="text-sm">+225 05 56 77 90 12</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire de Contact -->
            <div class="lg:w-2/3 bg-white p-8 md:p-12 rounded-3xl shadow-xl border border-gray-100">
                <h2 class="text-3xl font-black text-sterna-blue mb-8 uppercase border-l-4 border-sterna-yellow pl-4">Envoyez-nous un Message</h2>
                <form id="contactForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Votre Nom</label>
                            <input type="text" id="contactName" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-sterna-blue focus:ring-2 focus:ring-blue-100 transition-all text-gray-800">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Votre E-mail</label>
                            <input type="email" id="contactEmail" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-sterna-blue focus:ring-2 focus:ring-blue-100 transition-all text-gray-800">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Sujet</label>
                        <select id="contactSubject" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-sterna-blue focus:ring-2 focus:ring-blue-100 transition-all text-gray-800 appearance-none">
                            <option value="">Sélectionnez un sujet...</option>
                            <option value="Devenir Volontaire">Devenir Volontaire</option>
                            <option value="Devenir Partenaire">Devenir Partenaire</option>
                            <option value="Faire un don">Faire un don</option>
                            <option value="Autre question">Autre question</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Votre Message</label>
                        <textarea id="contactMessage" rows="5" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-sterna-blue focus:ring-2 focus:ring-blue-100 transition-all text-gray-800 resize-none"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-sterna-blue text-white font-black text-lg py-4 rounded-xl hover:bg-sterna-yellow hover:text-sterna-blue hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2">
                        Envoyer le message <i class="fi fi-rr-paper-plane"></i>
                    </button>
                </form>
                
                <script>
                    document.getElementById('contactForm').addEventListener('submit', function(e) {
                        e.preventDefault();
                        
                        const name = document.getElementById('contactName').value;
                        const email = document.getElementById('contactEmail').value;
                        const subjectSelection = document.getElementById('contactSubject').value;
                        const message = document.getElementById('contactMessage').value;
                        
                        const fullSubject = encodeURIComponent("Contact Sterna Africa : " + subjectSelection);
                        const body = encodeURIComponent("Nom : " + name + "\nEmail : " + email + "\n\nMessage :\n" + message);
                        
                        window.location.href = "mailto:sternaafrica@gmail.com?subject=" + fullSubject + "&body=" + body;
                    });
                </script>
            </div>
        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/footer_2.php'; ?>
</body>
</html>
