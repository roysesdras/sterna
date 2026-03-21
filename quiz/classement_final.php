<?php
require_once '../config/db.php';
session_start();

// Sécurité : Uniquement pour l'animateur
if (!isset($_SESSION['animateur_id'])) {
    header("Location: animateur-connect");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Podium Final | LiveQ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Favicons -->
    <link href="https://sternaafrica.org/assets/img/icon-192.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/icon-192.png" rel="apple-touch-icon">

    <style>
        body {
            background-color: #0c0a09;
        }

        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-rank {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body class="text-white min-h-screen flex flex-col">

    <header class="pt-10 pb-6 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-tr from-yellow-400 to-orange-600 rounded-full mb-4 shadow-2xl shadow-orange-500/20 floating">
            <i class="fas fa-trophy text-white text-3xl"></i>
        </div>
        <h1 class="text-4xl font-black tracking-tighter italic">CLASSEMENT</h1>
        <p class="text-gray-500 text-sm uppercase tracking-[0.3em]">Résultats de la session</p>
    </header>

    <main class="flex-1 px-4 pb-32 max-w-2xl mx-auto w-full">
        <div id="listeResultats" class="space-y-4">
            <div class="text-center py-20 text-gray-600">
                <i class="fas fa-circle-notch fa-spin text-3xl mb-4"></i>
                <p class="animate-pulse">Calcul du podium final...</p>
            </div>
        </div>
    </main>

    <footer class="fixed bottom-0 left-0 right-0 p-4 bg-stone-950/80 backdrop-blur-xl border-t border-white/5 z-50">
        <div class="max-w-2xl mx-auto grid grid-cols-2 gap-4">
            <form method="POST" action="animateur" class="w-full">
                <button type="submit" name="nouvelle_session"
                    class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-4 rounded-2xl font-black shadow-lg shadow-purple-500/20 active:scale-95 transition-all text-sm uppercase">
                    <i class="fas fa-plus-circle mr-2"></i> Nouvelle partie
                </button>
            </form>
            <a href="logout_animateur.php"
                class="flex items-center justify-center bg-stone-800 text-white py-4 rounded-2xl font-bold border border-white/10 active:scale-95 transition-all text-sm uppercase">
                <i class="fas fa-home mr-2"></i> Fermer
            </a>
        </div>
    </footer>

    <script>
        async function fetchEtAfficherClassement() {
            const container = document.getElementById("listeResultats");
            try {
                const res = await fetch("get_results.php");
                if (!res.ok) throw new Error("Erreur de chargement");
                const joueurs = await res.json();

                container.innerHTML = "";

                if (!joueurs || joueurs.length === 0) {
                    container.innerHTML = '<p class="text-center text-gray-500 py-10">Aucun participant pour cette session.</p>';
                    return;
                }

                joueurs.forEach((j, index) => {
                    const rank = index + 1;
                    const item = document.createElement("div");

                    let bgStyle = "glass";
                    let icon = "";

                    if (rank === 1) {
                        bgStyle = "bg-gradient-to-r from-yellow-500/10 to-transparent border border-yellow-500/30";
                        icon = '<i class="fas fa-crown text-yellow-400 text-xl mr-3"></i>';
                    } else if (rank === 2) {
                        bgStyle = "bg-gradient-to-r from-gray-400/10 to-transparent border border-gray-400/20";
                        icon = '<i class="fas fa-medal text-gray-300 text-lg mr-3"></i>';
                    } else if (rank === 3) {
                        bgStyle = "bg-gradient-to-r from-orange-600/10 to-transparent border border-orange-600/20";
                        icon = '<i class="fas fa-medal text-orange-500 text-lg mr-3"></i>';
                    }

                    item.className = `flex items-center justify-between p-5 rounded-3xl mb-3 animate-rank ${bgStyle}`;
                    item.style.animationDelay = `${index * 0.1}s`;

                    item.innerHTML = `
                        <div class="flex items-center">
                            <div class="flex flex-col items-center justify-center mr-4">
                                ${icon ? icon : `<span class="text-gray-600 font-bold ml-2">#${rank}</span>`}
                            </div>
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center font-black text-lg shadow-lg mr-4">
                                ${j.pseudo.slice(0, 1).toUpperCase()}
                            </div>
                            <div>
                                <h3 class="font-bold text-lg leading-tight">${j.pseudo}</h3>
                                <p class="text-xs text-gray-500 uppercase tracking-tighter">
                                    ${j.reponses_correctes} réponses
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-black bg-gradient-to-l from-white to-purple-400 bg-clip-text text-transparent">
                                ${j.score_total}
                            </p>
                            <p class="text-[10px] text-gray-600 font-bold uppercase">Points</p>
                        </div>
                    `;
                    container.appendChild(item);
                });
            } catch (e) {
                container.innerHTML = `<div class="bg-red-500/10 text-red-500 p-4 rounded-xl text-center border border-red-500/20">${e.message}</div>`;
            }
        }

        document.addEventListener("DOMContentLoaded", fetchEtAfficherClassement);
    </script>
</body>

</html>