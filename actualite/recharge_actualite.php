<?php
// Connexion (Assure-toi que les paramètres sont corrects pour ton environnement)
$conn = new mysqli('db', 'root', 'SoftiP24', 'africa_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupération sécurisée des paramètres
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 12;

$sql = "SELECT * FROM actualites ORDER BY start_date DESC LIMIT $limit OFFSET $offset";
$result_actualites = $conn->query($sql);

// Configuration des couleurs par pays (Norme Sterna 2026)
$classes = [
    "Côte Ivoire"   => "bg-[#f5b904] text-black", // Jaune Sterna
    "Bénin"         => "bg-[#305196] text-white", // Bleu Sterna
    "France"        => "bg-[#305196] text-white",
    "Burkina-Faso"  => "bg-[#f5b904] text-black",
    "Togo"          => "bg-[#f5b904] text-black"
];

if ($result_actualites && $result_actualites->num_rows > 0):
    while ($row = $result_actualites->fetch_assoc()):
        $lieu = htmlspecialchars($row['lieu']);
        $classe_bg = "bg-slate-600 text-white"; // Couleur par défaut

        foreach ($classes as $pays => $couleur) {
            if (stripos($lieu, $pays) !== false) {
                $classe_bg = $couleur;
                break;
            }
        }

        // Nettoyage du titre
        $title = htmlspecialchars($row['title']);
        $display_title = (mb_strlen($title) > 60) ? mb_substr($title, 0, 60) . '...' : $title;
?>
        <div class="group relative bg-white border border-gray-100 rounded-[2rem] overflow-hidden hover:border-[#ea750fff]/50 transition-all duration-500 shadow-md hover:shadow-xl fade-in-card">

            <div class="relative h-56 overflow-hidden">
                <span class="absolute top-4 left-4 z-20 <?php echo $classe_bg; ?> text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-lg">
                    <?php echo $lieu; ?>
                </span>

                <a href="./actualite_detail.php?id=<?php echo $row['id']; ?>" class="block h-full w-full">
                    <img src="../images/<?php echo $row['image']; ?>"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 group-hover:rotate-1"
                        alt="<?php echo $title; ?>">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#05070A] via-transparent to-transparent opacity-60"></div>
                </a>
            </div>

            <div class="p-6 flex flex-col justify-between h-[calc(100%-14rem)]">
                <div>
                    <span class="text-gray-500 text-xs flex items-center gap-2 mb-3 comic-neue">
                        <i class="far fa-calendar-alt text-[#ea750fff]"></i>
                        <?= date('d M Y', strtotime($row['end_date'])) ?>
                    </span>
                    <h5 class="comic-neue text-[#0f277e] text-lg font-bold leading-tight mb-6 group-hover:text-[#ea750fff] transition-colors">
                        <?php echo $display_title; ?>
                    </h5>
                </div>

                <a href="./actualite_detail.php?id=<?php echo $row['id']; ?>"
                    class="inline-flex items-center gap-2 text-[#305196] hover:text-[#ea750fff] font-black text-xs uppercase tracking-widest transition-all group/link">
                    Lire l'article
                    <i class="fas fa-chevron-right text-[10px] transform group-hover/link:translate-x-2 transition-transform"></i>
                </a>
            </div>
        </div>

<?php
    endwhile;
else:
    echo "no_more";
endif;

$conn->close();
?>