<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=u694220522_africa_db', 'u694220522_sterna_africa', '@sterna_Africa225');

// Récupération des témoignages (en ordre décroissant)
$sql = "SELECT id, nom, photo, question5 FROM temoignages ORDER BY id DESC";
$stmt = $pdo->query($sql);
$temoignages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <style>
        /* Conteneur principal pour les cartes */
        .temoignages-container {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto; /* Pour la barre de défilement horizontale */
            padding-bottom: 10px;
        }

        /* Style des cartes de témoignages */
        .temoignages-container .card {
            min-width: 300px;
            max-width: 300px;
            margin-right: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Effets au survol */
        .temoignages-container .card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Style de la barre de défilement */
        .temoignages-container::-webkit-scrollbar {
            height: 8px;
        }
        .temoignages-container::-webkit-scrollbar-thumb {
            background-color: #333; /* Couleur du curseur de défilement */
            border-radius: 10px;
        }
        .temoignages-container::-webkit-scrollbar-track {
            background-color: #f1f1f1;
        }
    </style>

    <!-- Conteneur horizontal pour les cartes -->
    <div class="temoignages-container pt-2">
        <?php foreach ($temoignages as $temoignage): ?>
        <div class="card h-100" onclick="window.location.href='../temoignage/<?php echo $temoignage['id']; ?>'" style="cursor:pointer;"> 
            <img src="../uploads/<?php echo htmlspecialchars($temoignage['photo']); ?>" class="card-img-top w-100" alt="Photo de <?php echo htmlspecialchars($temoignage['nom']); ?>">
            <div class="card-body">
                <p class="card-text comic-neue-regular">
                    <i class="fas fa-quote-left"></i>
                    <?php echo substr(htmlspecialchars($temoignage['question5']), 0, 150) . '..... <span style="color: #0000FF;">Lire la suite</span>'; ?>
                </p>
                <h5 class="card-title comic-neue-bold"><?php echo htmlspecialchars($temoignage['nom']); ?></h5>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

