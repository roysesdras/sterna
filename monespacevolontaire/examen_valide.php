<!-- examen_valide.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Examen soumis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        sterna: {
                            primary: '#24698B',
                            light: '#E8F4F8',
                            dark: '#1A3A4F',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-sterna-light h-screen flex items-center justify-center font-sans">
    <div class="bg-white shadow-xl rounded-2xl p-8 max-w-md text-center">
        <svg class="mx-auto mb-4 w-16 h-16 text-green-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
        </svg>
        <h1 class="text-2xl font-semibold text-sterna-primary mb-2">Merci pour votre participation !</h1>
        <p class="text-gray-600">Vos réponses ont bien été enregistrées.</p>
        <a href="https://monespacevolontaire.sternaafrica.org/" class="inline-block mt-6 bg-sterna-primary text-white px-5 py-2 rounded-full font-semibold hover:bg-opacity-90 transition">
            Retour à l’accueil
        </a>
    </div>
</body>
</html>
