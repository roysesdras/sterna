<?php
// config.php (ou en haut de ta page)
$servername = "db";
$username = "root";
$password = "SoftiP24";
$dbname = "africa_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion.");
}

// 1. Récupérer les données pour le tableau
$sql = "SELECT * FROM benevoles ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$volontaires = $stmt->fetchAll(PDO::FETCH_ASSOC); // On stocke tout dans un tableau

// 2. Préparer le lien Mailto (sans refaire de boucle SQL plus tard)
$emails_list = array_column($volontaires, 'email');
$mailto_link = '';
if (!empty($emails_list)) {
    $to = "sternaafrica@gmail.com,eesseulrich@gmail.com";
    $cc = implode(',', $emails_list);
    $mailto_link = "mailto:$to?cc=$cc";
}
?>

<!DOCTYPE html>
<html lang="fr" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Volontaires</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        /* Custom scrollbar pour le mode sombre */
        .custom-scrollbar::-webkit-scrollbar {
            height: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1e293b;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /* Forcer le tableau à garder sa structure */
        table {
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 0;
        }
    </style>
</head>

<body class="bg-slate-950 text-slate-200 font-sans antialiased">

    <div class="container-fluid mx-auto px-2 py-10">
        <header class="mb-10 text-center">
            <h2 class="text-3xl font-extrabold text-white uppercase tracking-widest flex flex-col md:flex-row items-center justify-center gap-4">
                Registre des Volontaires
                <span class="bg-indigo-600 text-white text-xs font-black px-3 py-1 rounded-full shadow-lg shadow-indigo-500/20 border border-indigo-400 animate-pulse">
                    <?= count($volontaires) ?> INSCRITS
                </span>
            </h2>
            <p class="text-slate-400 mt-2 text-sm italic">Gestion et suivi des recrutements en temps réel</p>

            <div class="w-24 h-1 bg-indigo-500 mx-auto mt-4 rounded-full opacity-50"></div>
        </header>

        <div class="overflow-x-auto shadow-2xl rounded-2xl border border-slate-800 bg-slate-900 custom-scrollbar">
            <table class="w-full text-left">
                <thead class="bg-slate-800 text-slate-300 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="p-4 w-32">Photo</th>
                        <th class="p-4 w-64 border-l border-slate-700">Nom et Prénom</th>
                        <th class="p-4 w-64 border-l border-slate-700">Adresse E-mail</th>
                        <th class="p-4 w-48 border-l border-slate-700">WhatsApp</th>
                        <th class="p-4 w-40 border-l border-slate-700">Nationalité</th>
                        <th class="p-4 w-24 border-l border-slate-700 text-center">Âge</th>
                        <th class="p-4 w-64 border-l border-slate-700">Profession</th>
                        <th class="p-4 w-64 border-l border-slate-700">Orga. Actuelle</th>
                        <th class="p-4 w-64 border-l border-slate-700">Nom Orga.</th>
                        <th class="p-4 w-56 border-l border-slate-700 text-center">Membre Orga.</th>
                        <th class="p-4 w-64 border-l border-slate-700">Nom Orga. Membre</th>
                        <th class="p-4 w-56 border-l border-slate-700">Canal Comm.</th>
                        <th class="p-4 w-80 border-l border-slate-700">Motivation</th>
                        <th class="p-4 w-80 border-l border-slate-700 text-xs">Déf. Volontariat</th>
                        <th class="p-4 w-80 border-l border-slate-700">Engagement</th>
                        <th class="p-4 w-64 border-l border-slate-700 text-center">Disponibilité</th>
                        <th class="p-4 w-56 border-l border-slate-700 text-center">Passeport</th>
                        <th class="p-4 w-64 border-l border-slate-700 text-green-400">Qualités</th>
                        <th class="p-4 w-64 border-l border-slate-700 text-red-400">Défauts</th>
                        <th class="p-4 w-64 border-l border-slate-700 text-blue-400">Apport</th>
                        <th class="p-4 w-64 border-l border-slate-700">Dernier mot</th>
                        <th class="p-4 w-40 sticky right-0 bg-slate-800 shadow-2xl z-10 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-sm">
                    <?php if ($stmt->rowCount() > 0):
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr class="hover:bg-slate-800/50 transition-all duration-200">
                                <td class="p-4">
                                    <div class="w-20 h-20 mx-auto overflow-hidden rounded-xl border-2 border-slate-700 bg-slate-800 shadow-inner group">
                                        <?php if (!empty($row['image_path'])): ?>
                                            <img src="<?= htmlspecialchars($row['image_path']); ?>"
                                                class="w-full h-full object-cover object-center cursor-zoom-in thumbnail-trigger transition-transform duration-300 group-hover:scale-110"
                                                data-fullsize="<?= htmlspecialchars($row['image_path']); ?>">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-slate-500">
                                                <i class="bi bi-person-fill text-2xl"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <td class="p-4 font-semibold text-white border-l border-slate-800/50"><?= htmlspecialchars($row['fullname']); ?></td>

                                <td class="p-4 text-blue-400 hover:text-blue-300 border-l border-slate-800/50 underline truncate lowercase"><?= htmlspecialchars($row['email']); ?></td>

                                <td class="p-4 border-l border-slate-800/50 font-mono"><?= htmlspecialchars($row['numero']); ?></td>

                                <td class="p-4 border-l border-slate-800/50"><?= htmlspecialchars($row['nationalite']); ?></td>

                                <td class="p-4 border-l border-slate-800/50 text-center"><?= htmlspecialchars($row['age']); ?></td>

                                <td class="p-4 border-l border-slate-800/50"><?= nl2br(htmlspecialchars($row['profession'])); ?></td>

                                <td class="p-4 border-l border-slate-800/50"><?= nl2br(htmlspecialchars($row['organisation'])); ?></td>

                                <td class="p-4 border-l border-slate-800/50 text-slate-300 italic text-sm">
                                    <?php
                                    // 1. Nettoyage des slashs (l\' -> l')
                                    $nomOrg = stripslashes($row['nom_organisation']);

                                    // 2. Nettoyage des "rn" et sauts de ligne textuels
                                    $nomOrg = str_replace(['\r\n', '\r', '\n', 'rn ', ' rn', 'rn'], " ", $nomOrg);

                                    // 3. Affichage sécurisé et mis en forme
                                    echo htmlspecialchars(trim($nomOrg));
                                    ?>
                                </td>

                                <td class="p-4 border-l border-slate-800/50 text-center uppercase text-xs">
                                    <?php
                                    // 1. On retire les slashs (l\' devient l')
                                    $membreStatus = stripslashes($row['membre']);
                                    ?>
                                    <span class="px-2 py-1 rounded bg-slate-700 font-bold text-slate-200">
                                        <?= htmlspecialchars($membreStatus); ?>
                                    </span>
                                </td>

                                <td class="p-4 border-l border-slate-800/50 text-sm text-slate-300">
                                    <?php
                                    // 1. On retire les slashs indésirables (l\' -> l')
                                    $orgName = stripslashes($row['nom_membre_organisation']);

                                    // 2. On nettoie les éventuels "rn" ou sauts de ligne collés
                                    $orgName = str_replace(['\r\n', '\r', '\n', 'rn ', ' rn', 'rn'], " ", $orgName);

                                    // 3. Affichage sécurisé
                                    echo htmlspecialchars(trim($orgName));
                                    ?>
                                </td>

                                <td class="p-4 border-l border-slate-800/50"><?= htmlspecialchars($row['sources']); ?></td>

                                <td class="p-4 border-l border-slate-800/50 italic text-slate-400 leading-tight text-sm">
                                    <?php
                                    // 1. Nettoyage complet (slashs et résidus "rn")
                                    $brutAmbition = stripslashes($row['motivation']);
                                    $cleanAmbition = str_replace(['\r\n', '\r', '\n', 'rn ', ' rn', 'rn'], " ", $brutAmbition);
                                    $texteAmbition = trim($cleanAmbition);

                                    // 2. Découpage par mots
                                    $motsAmbition = preg_split('/\s+/', $texteAmbition, -1, PREG_SPLIT_NO_EMPTY);
                                    $totalMotsAmbition = count($motsAmbition);
                                    $limiteAmbition = 20;

                                    if ($totalMotsAmbition > $limiteAmbition):
                                        $debutAmb = implode(' ', array_slice($motsAmbition, 0, $limiteAmbition));
                                        $resteAmb = implode(' ', array_slice($motsAmbition, $limiteAmbition));
                                    ?>
                                        <div class="leading-relaxed">
                                            <span><?= nl2br(htmlspecialchars($debutAmb)); ?></span>
                                            <span id="dots-amb-<?= $row['id']; ?>">...</span>
                                            <span id="more-amb-<?= $row['id']; ?>" class="hidden"><?= " " . nl2br(htmlspecialchars($resteAmb)); ?></span>

                                            <button type="button"
                                                onclick="toggleAmbition(<?= $row['id']; ?>)"
                                                id="btn-amb-<?= $row['id']; ?>"
                                                class="text-indigo-400 hover:text-indigo-300 font-bold block mt-2 focus:outline-none underline text-xs">
                                                Lire la suite
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <div class="leading-relaxed">
                                            <?= nl2br(htmlspecialchars($texteAmbition)); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td class="p-4 border-l border-slate-800/50 text-slate-300 text-sm">
                                    <?php
                                    // 1. Nettoyage des slashs et des "rn" fantômes
                                    $brutMotiv = stripslashes($row['volonteer']);
                                    $cleanMotiv = str_replace(['\r\n', '\r', '\n', 'rn ', ' rn', 'rn'], " ", $brutMotiv);
                                    $texteMotiv = trim($cleanMotiv);

                                    // 2. Découpage par mots (Expression régulière pour être précis)
                                    $motsMotiv = preg_split('/\s+/', $texteMotiv, -1, PREG_SPLIT_NO_EMPTY);
                                    $totalMotsMotiv = count($motsMotiv);
                                    $limiteMotiv = 20;

                                    if ($totalMotsMotiv > $limiteMotiv):
                                        $debutMotiv = implode(' ', array_slice($motsMotiv, 0, $limiteMotiv));
                                        $resteMotiv = implode(' ', array_slice($motsMotiv, $limiteMotiv));
                                    ?>
                                        <div class="leading-relaxed">
                                            <span><?= nl2br(htmlspecialchars($debutMotiv)); ?></span>
                                            <span id="dots-motiv-<?= $row['id']; ?>">...</span>
                                            <span id="more-motiv-<?= $row['id']; ?>" class="hidden"><?= " " . nl2br(htmlspecialchars($resteMotiv)); ?></span>

                                            <button type="button"
                                                onclick="toggleMotiv(<?= $row['id']; ?>)"
                                                id="btn-motiv-<?= $row['id']; ?>"
                                                class="text-indigo-400 hover:text-indigo-300 font-bold block mt-2 focus:outline-none underline">
                                                Voir plus (<?= ($totalMotsMotiv - $limiteMotiv); ?> mots restants)
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <div class="leading-relaxed">
                                            <?= nl2br(htmlspecialchars($texteMotiv)); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td class="p-4 border-l border-slate-800/50 text-center"><?= nl2br(htmlspecialchars($row['engagement_gratuit'])); ?></td>

                                <td class="p-4 border-l border-slate-800/50 text-center"><?= nl2br(htmlspecialchars($row['disponibilite'])); ?></td>

                                <td class="p-4 border-l border-slate-800/50 text-center"><?= nl2br(htmlspecialchars($row['passeport'])); ?></td>

                                <td class="p-4 border-l border-slate-800/50 text-green-500 font-medium text-sm">
                                    <?php
                                    // 1. Nettoyage des slashs (l\' -> l')
                                    $cleanQualites = stripslashes($row['qualites']);

                                    // 2. Remplacement des variantes "rn" et sauts de ligne par de vrais retours à la ligne
                                    $recherche = ['\r\n', '\r', '\n', 'rn ', ' rn', 'rn'];
                                    $cleanQualites = str_replace($recherche, "\n", $cleanQualites);

                                    // 3. Affichage final propre
                                    echo nl2br(htmlspecialchars(trim($cleanQualites)));
                                    ?>
                                </td>

                                <td class="p-4 border-l border-slate-800/50 text-red-400 font-medium text-sm">
                                    <?php
                                    // 1. On nettoie les slashs (l\')
                                    $clean = stripslashes($row['defauts']);

                                    // 2. On remplace les variantes "rn", "\r\n", "rn " par un vrai saut de ligne
                                    // On ajoute des espaces autour pour être sûr de séparer les mots collés
                                    $recherche = ['\r\n', '\r', '\n', 'rn ', ' rn', 'rn'];
                                    $clean = str_replace($recherche, "\n", $clean);

                                    // 3. On affiche proprement
                                    echo nl2br(htmlspecialchars(trim($clean)));
                                    ?>
                                </td>

                                <td class="p-4 border-l border-slate-800/50 text-blue-300 text-sm">
                                    <?php
                                    // 1. Nettoyage des slashs (l\' -> l') ET des sauts de ligne textuels
                                    $brut = stripslashes($row['apport']);
                                    $cleanStr = str_replace(['\r\n', '\r', '\n'], " ", $brut);
                                    $texteNettoye = trim($cleanStr);

                                    // 2. Découpage par mots
                                    $motsArray = preg_split('/\s+/', $texteNettoye, -1, PREG_SPLIT_NO_EMPTY);
                                    $total = count($motsArray);

                                    $limite = 20; // Ta limite actuelle

                                    if ($total > $limite):
                                        $debut = implode(' ', array_slice($motsArray, 0, $limite));
                                        $reste = implode(' ', array_slice($motsArray, $limite));
                                    ?>
                                        <div class="leading-relaxed">
                                            <span><?= nl2br(htmlspecialchars($debut)); ?></span>
                                            <span id="dots-apport-<?= $row['id']; ?>">...</span>
                                            <span id="more-apport-<?= $row['id']; ?>" class="hidden"><?= " " . nl2br(htmlspecialchars($reste)); ?></span>

                                            <button type="button"
                                                onclick="toggleApport(<?= $row['id']; ?>)"
                                                id="btn-apport-<?= $row['id']; ?>"
                                                class="text-indigo-400 hover:text-indigo-300 font-bold block mt-2 focus:outline-none underline text-xs">
                                                Lire la suite (<?= ($total - $limite); ?> mots restants)
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <div class="leading-relaxed"><?= nl2br(htmlspecialchars($texteNettoye)); ?></div>
                                    <?php endif; ?>
                                </td>

                                <td class="p-4 border-l border-slate-800/50 text-md">
                                    <?php
                                    // 1. Suppression des slashs (l\' -> l')
                                    $nettoyé = stripslashes($row['dernierMot']);

                                    // 2. Transformation des symboles textuels \r\n en vrais sauts de ligne
                                    $brut = str_replace(['\r\n', '\r', '\n'], "\n", $nettoyé);
                                    $dernierMot = trim($brut);

                                    // 3. Limite à 200 caractères (Multibyte pour les accents)
                                    $limite = 150;
                                    if (mb_strlen($dernierMot, 'UTF-8') > $limite):
                                        $debut = mb_substr($dernierMot, 0, $limite, 'UTF-8');
                                        $reste = mb_substr($dernierMot, $limite, null, 'UTF-8');
                                    ?>
                                        <div class="text-slate-400 leading-relaxed">
                                            <span><?= nl2br(htmlspecialchars($debut)); ?></span>
                                            <span id="dots-<?= $row['id']; ?>">...</span>
                                            <span id="more-<?= $row['id']; ?>" class="hidden"><?= nl2br(htmlspecialchars($reste)); ?></span>

                                            <button type="button"
                                                onclick="toggleText(<?= $row['id']; ?>)"
                                                id="btn-<?= $row['id']; ?>"
                                                class="text-indigo-400 hover:text-indigo-300 font-bold ml-1 focus:outline-none">
                                                Voir plus
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-slate-400 leading-relaxed">
                                            <?= nl2br(htmlspecialchars($dernierMot)); ?>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td class="p-4 sticky right-0 bg-slate-900 border-l border-slate-800 shadow-[-10px_0_15px_rgba(0,0,0,0.5)] text-center">
                                    <button
                                        data-id="<?= $row['id']; ?>"
                                        class="delete-btn inline-flex items-center bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded-lg transition-all transform hover:scale-105 active:scale-95 shadow-lg">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="22" class="p-20 text-center">
                                <div class="flex flex-col items-center text-slate-500">
                                    <i class="bi bi-inbox text-5xl mb-4"></i>
                                    <p class="text-xl">Aucun volontaire recruté pour le moment.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-10 flex flex-col md:flex-row items-center justify-between gap-4">
            <?php if ($mailto_link): ?>
                <a href="<?= htmlspecialchars($mailto_link); ?>"
                    class="w-full md:w-auto flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-4 px-10 rounded-2xl transition-all shadow-xl hover:shadow-indigo-500/20">
                    <i class="bi bi-envelope-paper-fill mr-3 text-xl"></i> Diffuser un mail à tous
                </a>
            <?php endif; ?>
            <p class="text-slate-500 text-xs uppercase tracking-widest">© 2026 Système de Gestion Volontariat</p>
        </div>
    </div>

    <div id="imageModal" class="fixed inset-0 z-[100] hidden bg-black/95 backdrop-blur-md flex items-center justify-center p-6">
        <button id="closeBtn" class="absolute top-8 right-8 text-white/50 text-5xl font-thin hover:text-white transition-colors">&times;</button>
        <img id="modalImage" class="max-w-full max-h-[85vh] rounded-2xl shadow-[0_0_50px_rgba(255,255,255,0.1)] border border-white/10">
    </div>

    <script>
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const closeBtn = document.getElementById('closeBtn');

        document.querySelectorAll('.thumbnail-trigger').forEach(img => {
            img.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modalImg.src = img.dataset.fullsize;
                document.body.style.overflow = 'hidden';
            });
        });

        const closeModal = () => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        };

        closeBtn.onclick = closeModal;
        modal.onclick = (e) => {
            if (e.target === modal) closeModal();
        };
        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape") closeModal();
        });
    </script>

    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const row = this.closest('tr'); // Cible la ligne du tableau

                if (confirm('Confirmer la suppression définitive de ce volontaire ?')) {
                    // Création des données à envoyer
                    const formData = new FormData();
                    formData.append('id', id);

                    // Envoi de la requête AJAX via Fetch
                    fetch('delete_volontaire.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Effet visuel de sortie (fondu et réduction)
                                row.style.transition = "all 0.5s ease";
                                row.style.opacity = "0";
                                row.style.transform = "translateX(20px)";

                                setTimeout(() => {
                                    row.remove(); // Supprime l'élément du DOM après l'animation
                                }, 500);
                            } else {
                                alert("Erreur : " + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            alert("Une erreur de communication est survenue.");
                        });
                }
            });
        });


        // 1. Fonction pour la colonne "Dernier Mot" (Basée sur les caractères)
        function toggleText(id) {
            const dots = document.getElementById(`dots-${id}`);
            const moreText = document.getElementById(`more-${id}`);
            const btnText = document.getElementById(`btn-${id}`);

            if (moreText.classList.contains("hidden")) {
                moreText.classList.remove("hidden");
                dots.classList.add("hidden");
                btnText.innerText = "Voir moins";
            } else {
                moreText.classList.add("hidden");
                dots.classList.remove("hidden");
                btnText.innerText = "Voir plus";
            }
        }

        // 2. Fonction pour la colonne "Apport" (Basée sur les mots)
        function toggleApport(id) {
            const dots = document.getElementById(`dots-apport-${id}`);
            const moreText = document.getElementById(`more-apport-${id}`);
            const btnText = document.getElementById(`btn-apport-${id}`);

            if (moreText.classList.contains("hidden")) {
                moreText.classList.remove("hidden");
                dots.classList.add("hidden");
                btnText.innerText = "Réduire";
            } else {
                moreText.classList.add("hidden");
                dots.classList.remove("hidden");
                btnText.innerText = "Lire la suite";
            }
        }

        // 3. Fonction pour la colonne "Motivation" (Basée sur les mots)
        function toggleMotiv(id) {
            const dots = document.getElementById(`dots-motiv-${id}`);
            const moreText = document.getElementById(`more-motiv-${id}`);
            const btnText = document.getElementById(`btn-motiv-${id}`);

            if (moreText.classList.contains("hidden")) {
                moreText.classList.remove("hidden");
                dots.classList.add("hidden");
                btnText.innerText = "Réduire";
            } else {
                moreText.classList.add("hidden");
                dots.classList.remove("hidden");
                btnText.innerText = "Voir plus";
            }
        }

        // 4. Fonction pour la colonne "Définition du Volontariat" (Basée sur les mots)
        function toggleAmbition(id) {
            const dots = document.getElementById(`dots-amb-${id}`);
            const moreText = document.getElementById(`more-amb-${id}`);
            const btnText = document.getElementById(`btn-amb-${id}`);

            if (moreText.classList.contains("hidden")) {
                moreText.classList.remove("hidden");
                dots.classList.add("hidden");
                btnText.innerText = "Réduire";
            } else {
                moreText.classList.add("hidden");
                dots.classList.remove("hidden");
                btnText.innerText = "Lire la suite";
            }
        }
    </script>

</body>

</html>


<?php
// Fermer la connexion PDO
$conn = null;
?>