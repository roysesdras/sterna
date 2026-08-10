<?php
require_once __DIR__ . '/config/db.php';

$message = '';
$message_type = '';

// Récupération dynamique des antennes pour les sélecteurs de pays
$antennes_list = [];
$res_antennes = $conn->query("SELECT nom FROM antennes ORDER BY nom ASC");
if ($res_antennes) {
    while ($row = $res_antennes->fetch_assoc()) {
        $clean_nom = trim($row['nom']);
        if (!empty($clean_nom)) {
            $antennes_list[] = $clean_nom;
        }
    }
}
$default_countries = ['Bénin', 'Burkina Faso', 'Côte d\'Ivoire', 'France', 'Togo'];
$all_countries = array_values(array_unique(array_merge($antennes_list, $default_countries)));
sort($all_countries);

// Traitement du formulaire lors de la soumission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_complet = trim($_POST['nom_complet'] ?? '');
    $pays_provenance = trim($_POST['pays_provenance'] ?? '');
    $pays_reception = trim($_POST['pays_reception'] ?? '');
    $structure_envoi = trim($_POST['structure_envoi'] ?? '');
    $type_relation = trim($_POST['type_relation'] ?? '');
    $date_debut = !empty($_POST['date_debut']) ? $_POST['date_debut'] : null;
    $date_fin = !empty($_POST['date_fin']) ? $_POST['date_fin'] : null;
    $recit = trim($_POST['recit'] ?? '');
    $question_1 = '';
    $question_2 = '';
    $question_3 = '';
    $question_4 = '';

    // Validation de base
    if (empty($nom_complet) || empty($pays_provenance) || empty($pays_reception) || empty($type_relation) || empty($recit)) {
        $message = "Veuillez remplir tous les champs obligatoires (*).";
        $message_type = "error";
    } else {
        // Upload photo principale
        $photo_volontaire_path = '';
        if (isset($_FILES['photo_volontaire']) && $_FILES['photo_volontaire']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['photo_volontaire']['name'], PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
            if (in_array($ext, $allowed_ext)) {
                $filename = 'volontaire_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
                $target_dir = __DIR__ . '/uploads/pont_solidaire/';
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $target_path = $target_dir . $filename;
                if (move_uploaded_file($_FILES['photo_volontaire']['tmp_name'], $target_path)) {
                    $photo_volontaire_path = '/uploads/pont_solidaire/' . $filename;
                }
            }
        }

        if (empty($photo_volontaire_path)) {
            $message = "La photo de profil du volontaire est obligatoire (formats acceptés: JPG, PNG, WEBP).";
            $message_type = "error";
        } else {
            // Upload des 2-3 images d'expérience
            $experience_images = [];
            if (isset($_FILES['images_experience'])) {
                $total_files = count($_FILES['images_experience']['name']);
                for ($i = 0; $i < min($total_files, 3); $i++) {
                    if ($_FILES['images_experience']['error'][$i] === UPLOAD_ERR_OK) {
                        $ext = strtolower(pathinfo($_FILES['images_experience']['name'][$i], PATHINFO_EXTENSION));
                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                            $exp_filename = 'exp_' . time() . '_' . $i . '_' . rand(100, 999) . '.' . $ext;
                            $exp_target_dir = __DIR__ . '/uploads/pont_solidaire/';
                            $exp_target_path = $exp_target_dir . $exp_filename;
                            if (move_uploaded_file($_FILES['images_experience']['tmp_name'][$i], $exp_target_path)) {
                                $experience_images[] = '/uploads/pont_solidaire/' . $exp_filename;
                            }
                        }
                    }
                }
            }
            $images_exp_str = implode(',', $experience_images);

            // Insertion en base de données avec requête préparée
            $stmt = $conn->prepare("INSERT INTO pont_solidaire (nom_complet, pays_provenance, pays_reception, structure_envoi, type_relation, photo_volontaire, date_debut, date_fin, recit, question_1, question_2, question_3, question_4, images_experience, statut) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'en_attente')");

            $stmt->bind_param("ssssssssssssss", 
                $nom_complet, 
                $pays_provenance, 
                $pays_reception, 
                $structure_envoi,
                $type_relation, 
                $photo_volontaire_path, 
                $date_debut, 
                $date_fin, 
                $recit, 
                $question_1, 
                $question_2, 
                $question_3, 
                $question_4, 
                $images_exp_str
            );

            if ($stmt->execute()) {
                $message = "Félicitations ! Votre récit a été enregistré avec succès et apparaît désormais sur la plateforme après validation.";
                $message_type = "success";
            } else {
                $message = "Une erreur est survenue lors de l'enregistrement : " . $conn->error;
                $message_type = "error";
            }
            $stmt->close();
        }
    }
}
?>
<?php include __DIR__ . '/config/head.php'; ?>

<body class="bg-gray-100 font-sans text-gray-800">

    <?php include __DIR__ . '/config/nav.php'; ?>

    <!-- En-tête de la page -->
    <section class="py-12 md:py-20 bg-gradient-to-r from-sterna-blue to-blue-900 text-white relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <span class="px-4 py-1.5 rounded-full bg-sterna-yellow text-sterna-blue font-black text-xs uppercase tracking-widest inline-block mb-4">
                Pont Solidaire — Mobilité & Récits
            </span>
            <h1 class="text-3xl md:text-5xl font-black uppercase tracking-tight mb-4">
                Partagez Votre Expérience
            </h1>
            <p class="text-blue-100 text-sm md:text-base max-w-2xl mx-auto font-medium leading-relaxed">
                Racontez votre parcours de volontariat Nord-Sud, Sud-Nord ou Sud-Sud et inspirez les prochains volontaires de Sterna Africa !
            </p>
        </div>
    </section>

    <!-- Formulaire -->
    <div class="max-w-4xl mx-auto px-4 py-12 -mt-8 relative z-20">
        
        <?php if (!empty($message)): ?>
            <div class="mb-8 p-4 rounded-2xl shadow-md border <?php echo $message_type === 'success' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-rose-50 text-rose-800 border-rose-200'; ?> flex items-center gap-3">
                <i class="fi <?php echo $message_type === 'success' ? 'fi-rr-check-circle text-emerald-600' : 'fi-rr-cross-circle text-rose-600'; ?> text-2xl"></i>
                <div class="flex-1 font-bold text-sm">
                    <?php echo htmlspecialchars($message); ?>
                </div>
                <?php if ($message_type === 'success'): ?>
                    <a href="/" class="px-4 py-2 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 transition-all">
                        Ok!
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form id="recitForm" action="/recit_volontaire.php" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 md:p-10 shadow-xl border border-gray-100 space-y-8">

            <!-- Section 1 : Informations personnelles -->
            <div>
                <h3 class="text-xl font-black text-sterna-blue uppercase tracking-tight mb-6 pb-2 border-b-2 border-sterna-yellow flex items-center gap-2">
                    <i class="fi fi-rr-user text-sterna-yellow"></i> 1. Informations du Volontaire
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Nom Complet -->
                    <div>
                        <label class="block text-xs font-black uppercase text-gray-700 mb-2">
                            Nom Complet <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nom_complet" required placeholder="ex: Aïcha GBO" 
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-sterna-blue focus:ring-2 focus:ring-sterna-blue/20 transition-all text-sm font-medium outline-none">
                    </div>

                    <!-- Association / Structure d'envoi -->
                    <div>
                        <label class="block text-xs font-black uppercase text-gray-700 mb-2">
                            Structure d'envoi / Org.
                        </label>
                        <input type="text" name="structure_envoi" placeholder="ex: Sterna Africa, France Volontaires..." 
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-sterna-blue focus:ring-2 focus:ring-sterna-blue/20 transition-all text-sm font-medium outline-none">
                    </div>

                    <!-- Photo du Volontaire -->
                    <div>
                        <label class="block text-xs font-black uppercase text-gray-700 mb-2">
                            Photo de Profil <span class="text-rose-500">*</span>
                        </label>
                        <input type="file" name="photo_volontaire" required accept="image/jpeg,image/png,image/webp"
                               class="w-full px-3 py-2.5 rounded-2xl border border-gray-200 text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sterna-blue file:text-white hover:file:bg-blue-900 cursor-pointer">
                    </div>
                </div>
            </div>

            <!-- Section 2 : Relation & Mobilité -->
            <div>
                <h3 class="text-xl font-black text-sterna-blue uppercase tracking-tight mb-6 pb-2 border-b-2 border-sterna-yellow flex items-center gap-2">
                    <i class="fi fi-rr-paper-plane text-sterna-yellow"></i> 2. Type de Mobilité & Durée
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Type de Relation -->
                    <div>
                        <label class="block text-xs font-black uppercase text-gray-700 mb-2">
                            Type de Mobilité <span class="text-rose-500">*</span>
                        </label>
                        <select name="type_relation" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-sterna-blue focus:ring-2 focus:ring-sterna-blue/20 transition-all text-sm font-bold text-sterna-blue outline-none">
                            <option value="">-- Sélectionner --</option>
                            <option value="sud_nord">Sud ➔ Nord (ex: Bénin vers France)</option>
                            <option value="nord_sud">Nord ➔ Sud (ex: France vers Afrique)</option>
                            <option value="sud_sud">Sud ➔ Sud (ex: Bénin vers Togo/Côte d'Ivoire)</option>
                        </select>
                    </div>

                    <!-- Liste de suggestions de pays (Datalist) -->
                    <datalist id="country_list">
                        <?php foreach ($all_countries as $c): ?>
                            <option value="<?php echo htmlspecialchars($c); ?>"></option>
                        <?php endforeach; ?>
                        <!-- On ajoute explicitement le Canada et d'autres pays du Nord au cas où ils ne seraient pas dans $all_countries -->
                        <option value="Canada"></option>
                        <option value="Belgique"></option>
                        <option value="Suisse"></option>
                        <option value="États-Unis"></option>
                        <option value="Allemagne"></option>
                    </datalist>

                    <!-- Pays Provenance -->
                    <div>
                        <label class="block text-xs font-black uppercase text-gray-700 mb-2">
                            Pays d'origine / Provenance <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" list="country_list" name="pays_provenance" placeholder="Ex: Canada, France, Bénin..." required class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-sterna-blue focus:ring-2 focus:ring-sterna-blue/20 transition-all text-sm font-medium outline-none">
                    </div>

                    <!-- Pays Réception -->
                    <div>
                        <label class="block text-xs font-black uppercase text-gray-700 mb-2">
                            Pays de Réception / Destination <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" list="country_list" name="pays_reception" placeholder="Ex: Bénin, Togo, France..." required class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-sterna-blue focus:ring-2 focus:ring-sterna-blue/20 transition-all text-sm font-medium outline-none">
                    </div>
                </div>

                <!-- Durée de Service (Dates) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-600 mb-1">
                            Date de début de mission
                        </label>
                        <input type="date" name="date_debut" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-600 mb-1">
                            Date de fin de mission
                        </label>
                        <input type="date" name="date_fin" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium outline-none">
                    </div>
                </div>
            </div>

            <!-- Section 3 : Récit d'Expérience Unique (Champ Élastique) -->
            <div>
                <h3 class="text-xl font-black text-sterna-blue uppercase tracking-tight mb-4 pb-2 border-b-2 border-sterna-yellow flex items-center gap-2">
                    <i class="fi fi-rr-quote-right text-sterna-yellow"></i> 3. Votre Récit d'Expérience
                </h3>

                <!-- Reformulation claire des conseils -->
                <div class="bg-sterna-yellow/15 border-l-4 border-sterna-yellow p-5 rounded-r-2xl mb-6 space-y-3">
                    <p class="text-sm font-bold text-sterna-blue leading-relaxed">
                        Racontez-nous votre expérience comme vous le sentez. Si vous manquez d'inspiration, tentez de répondre à ces 4 questions dans votre récit (en effectuant de belles formulations avec des sauts de ligne pour chaque point) :
                    </p>
                    <ul class="text-xs md:text-sm text-gray-700 space-y-2 font-medium pl-2">
                        <li class="flex items-start gap-2">
                            <span class="text-sterna-blue font-bold">1.</span>
                            <span>Quel a été le moment le plus marquant ou le plus inattendu de votre mission ?</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-sterna-blue font-bold">2.</span>
                            <span>Qu'est-ce qui vous a le plus surpris ou dépaysé sur place ?</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-sterna-blue font-bold">3.</span>
                            <span>Comment cette expérience a-t-elle changé votre regard ou votre façon de voir les choses ?</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-sterna-blue font-bold">4.</span>
                            <span>Un mot ou un conseil pour les futurs volontaires ?</span>
                        </li>
                    </ul>
                </div>

                <!-- Champ Texte Élastique (Auto-expanding Textarea) -->
                <div>
                    <label class="block text-xs font-black uppercase text-gray-700 mb-2">
                        Rédigez votre Récit <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="recit" id="recit_textarea" required rows="6" oninput="autoExpand(this)"
                              placeholder="Écrivez votre témoignage ici... (Ce champ s'agrandit automatiquement au fur et à mesure de votre saisie)"
                              class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-sterna-blue focus:ring-2 focus:ring-sterna-blue/20 transition-all text-sm font-medium outline-none resize-none overflow-hidden min-h-[180px] leading-relaxed"></textarea>
                </div>
            </div>

            <!-- Section 4 : Images souvenir de la mission -->
            <div>
                <h3 class="text-xl font-black text-sterna-blue uppercase tracking-tight mb-4 pb-2 border-b-2 border-sterna-yellow flex items-center gap-2">
                    <i class="fi fi-rr-picture text-sterna-yellow"></i> 4. Photos Souvenirs
                </h3>
                <label class="block text-xs font-black uppercase text-gray-700 mb-2">
                    Partagez avec nous 2 ou 3 images de votre expérience (Format JPG, PNG)
                </label>
                <input type="file" name="images_experience[]" multiple accept="image/jpeg,image/png,image/webp"
                       class="w-full px-3 py-3 rounded-2xl border border-gray-200 text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sterna-yellow file:text-sterna-blue hover:file:bg-amber-400 cursor-pointer">
                <p class="text-[11px] text-gray-400 mt-1">Vous pouvez sélectionner jusqu'à 3 photos simultanément.</p>
            </div>

            <!-- Bouton de Soumission -->
            <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="/#pont-solidaire" class="text-xs font-bold text-gray-500 hover:text-sterna-blue flex items-center gap-1">
                    <i class="fi fi-rr-arrow-left"></i> Annuler et retourner à l'accueil
                </a>
                <button id="submitBtn" type="submit" class="w-full sm:w-auto px-8 py-4 bg-sterna-blue hover:bg-blue-900 text-white font-black rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 uppercase tracking-wider text-sm flex items-center justify-center gap-2">
                    <span id="submitIcon"><i class="fi fi-rr-paper-plane"></i></span>
                    <svg id="submitSpinner" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="submitText">Publier mon Récit</span>
                </button>
            </div>

        </form>
    </div>

    <?php include __DIR__ . '/config/footer_2.php'; ?>

    <!-- Script JavaScript pour le champ textarea élastique et le chargement -->
    <script>
        function autoExpand(element) {
            element.style.height = 'auto';
            element.style.height = (element.scrollHeight) + 'px';
        }

        document.getElementById('recitForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('submitBtn');
            const icon = document.getElementById('submitIcon');
            const spinner = document.getElementById('submitSpinner');
            const text = document.getElementById('submitText');

            // Prevent multiple submissions
            if (btn.disabled) {
                e.preventDefault();
                return;
            }

            // Visual loading state
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
            icon.classList.add('hidden');
            spinner.classList.remove('hidden');
            text.textContent = 'Envoi en cours...';
        });
    </script>

</body>
</html>
