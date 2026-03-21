<!DOCTYPE html>
<html lang="fr" data-bs-theme="auto">
<head>
    <script src="../assets/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejoignez l'Aventure Sterna Africa 2025 : Devenez Volontaire  !</title>
    <meta name="robots" content="index">
    <meta name="robots" content="follow">

    <meta name="description" content="Participez à une expérience humaine unique avec Sterna Africa en 2025. Rejoignez nos projets solidaires et interculturels pour faire la différence sur le terrain. Inscrivez-vous dès maintenant !">
    <meta property="og:title" content="Devenez Volontaire  : sternaafrica" />
    <meta property="og:description" content="Participez à une expérience humaine unique avec Sterna Africa en 2025. Rejoignez nos projets solidaires et interculturels pour faire la différence sur le terrain. Inscrivez-vous dès maintenant !" />
    <!-- Favicons -->
    <link href="../assets/img/favicon1.png" rel="icon">
    <link href="../assets/img/apple-touch-icon1.png" rel="apple-touch-icon">
    <!-- meta for og.graph -->
    <meta property="og:image" content="https://lh6.googleusercontent.com/f5Fi-QxBDrTgg3U9Q49VhuK7JWt9IJ0n8xm_WQ4-uTMZs4EowQJQPvuOMWZlwGbobyhtSzTAvmClnAwudozRWK8v-_-mCOzhCj5ZxisAVhMW0GNI2eJodM7oHJyVh7j2dg=w1040" />
    <meta property="og:url" content="https://sternaafrica.org/" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="sternaafrica" />

    <!-- all css -->
    <link rel="canonical" href="https://sternaafrica.org/">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Start cookieyes banner --> <script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/495fc865e66d221c0516bda6/script.js"></script> <!-- End cookieyes banner -->
</head>

<body>

    <?php // require_once ('../config/mode_theme.php'); ?>
    <?php // require_once ('../config/navbar.php'); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h1>Rejoignez-nous : Devenez Sterne d'Afrique !</h1>
                <p><b>NB:</b> tout les champs de ce formulaire sont obligatoire</p>
                <form action="./traitement_form.php" method="post" enctype="multipart/form-data" class="shadow p-2 mb-3 rounded">
                    <img src="https://lh6.googleusercontent.com/f5Fi-QxBDrTgg3U9Q49VhuK7JWt9IJ0n8xm_WQ4-uTMZs4EowQJQPvuOMWZlwGbobyhtSzTAvmClnAwudozRWK8v-_-mCOzhCj5ZxisAVhMW0GNI2eJodM7oHJyVh7j2dg=w1040" 
                        alt="benevol-image" class="w-100 rounded">
                    
                    <!-- Champ pour uploader une image -->
                    <div class="mt-3" style="">
                        <label for="imageUpload" class="form-label">Votre photo :</label>
                        <input type="file" class="form-control" id="imageUpload" name="imageUpload" accept=".jpg, .jpeg, .png" required>
                    </div>

                    <div class="">
                        <label for="nomComplet"></label>
                        <input type="text" class="form-control" id="nomComplet" name="fullname" placeholder="Entrer votre nom complet" required>
                    </div>

                    <div class="">
                        <label for="email"></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Votre adresse e-mail" required>
                    </div>

                    <div class="">
                        <label for="numero"></label>
                        <input type="tel" class="form-control" id="numero" name="numero" placeholder="Votre numéro WhatsApp" pattern="[0-9]+" required>
                    </div>

                    <div class="mb-3">
                        <label for="nationalite"></label>
                            <select id="nationalite" name="nationalite" class="form-control" required>
                                <option value="">-- Sélectionnez votre nationalité --</option>
                                <option value="france">France</option>
                                <option value="canada">Canada</option>
                                <option value="suisse">Suisse</option>
                                <option value="senegal">Sénégal</option>
                                <option value="cameroun">Cameroun</option>
                                <option value="benin">Bénin</option>
                                <option value="cote_divoire">Côte d'Ivoire</option>
                                <option value="burkina_faso">Burkina Faso</option>
                                <option value="niger">Niger</option>
                                <option value="belgique">Belgique</option>
                                <option value="afrique_du_sud">Afrique du Sud</option>
                                <option value="algerie">Algérie</option>
                                <option value="angola">Angola</option>
                                <option value="botswana">Botswana</option>
                                <option value="burundi">Burundi</option>
                                <option value="cap_vert">Cap-Vert</option>
                                <option value="comores">Comores</option>
                                <option value="djibouti">Djibouti</option>
                                <option value="egypte">Égypte</option>
                                <option value="erythree">Érythrée</option>
                                <option value="eswatini">Eswatini</option>
                                <option value="ethiopie">Éthiopie</option>
                                <option value="gabon">Gabon</option>
                                <option value="gambie">Gambie</option>
                                <option value="ghana">Ghana</option>
                                <option value="guinee">Guinée</option>
                                <option value="guinee_bissau">Guinée-Bissau</option>
                                <option value="guinee_equatoriale">Guinée équatoriale</option>
                                <option value="kenya">Kenya</option>
                                <option value="lesotho">Lesotho</option>
                                <option value="liberia">Libéria</option>
                                <option value="libye">Libye</option>
                                <option value="madagascar">Madagascar</option>
                                <option value="malawi">Malawi</option>
                                <option value="mali">Mali</option>
                                <option value="maroc">Maroc</option>
                                <option value="maurice">Maurice</option>
                                <option value="mauritanie">Mauritanie</option>
                                <option value="mozambique">Mozambique</option>
                                <option value="namibie">Namibie</option>
                                <option value="ouganda">Ouganda</option>
                                <option value="rd_congo">République Démocratique du Congo</option>
                                <option value="rwanda">Rwanda</option>
                                <option value="saint_tome_principe">Sao Tomé-et-Principe</option>
                                <option value="seychelles">Seychelles</option>
                                <option value="sierra_leone">Sierra Leone</option>
                                <option value="somalie">Somalie</option>
                                <option value="soudan">Soudan</option>
                                <option value="soudan_du_sud">Soudan du Sud</option>
                                <option value="tanzanie">Tanzanie</option>
                                <option value="tchad">Tchad</option>
                                <option value="togo">Togo</option>
                                <option value="tunisie">Tunisie</option>
                                <option value="zambie">Zambie</option>
                                <option value="zimbabwe">Zimbabwe</option>
                                <option value="autre">--Autre-- (précisez dans la dernière section)</option>
                            </select>
                    </div>

                    <div class="">
                        <label>Tranche d'âge :</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="age1" name="age[]" value="18-21">
                            <label class="form-check-label" for="age1">18 - 21 ans</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="age2" name="age[]" value="22-25">
                            <label class="form-check-label" for="age2">22 - 25 ans</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="age3" name="age[]" value="26-30">
                            <label class="form-check-label" for="age3">26 - 30 ans</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="profession"></label>
                        <input type="text" class="form-control" id="profession" name="profession" placeholder="Que faites-vous dans la vie (profession) ?" required>
                    </div>

                    <div class="">
                        <label>Avez-vous déjà fait du volontariat ?</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="organisation_oui" name="organisation" value="oui">
                            <label class="form-check-label" for="organisation_oui">Oui</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="organisation_non" name="organisation" value="non">
                            <label class="form-check-label" for="organisation_non">Non</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nom_organisation"></label>
                        <input type="text" class="form-control" id="nom_organisation" name="nom_organisation" placeholder="Si oui, préciser le nom de votre organisation" required>
                    </div>

                    <div class="">
                        <label>Etes vous actuellement membre d'une organisation ?</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="membre_oui" name="membre" value="oui">
                            <label class="form-check-label" for="membre_oui">Oui</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="organisation_non" name="membre" value="non">
                            <label class="form-check-label" for="membre_non">Non</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nom_organisation"></label>
                        <input type="text" class="form-control" id="nom_organisation" name="nom_membre_organisation" placeholder="Si oui, préciser le nom de l'organisation" required>
                    </div>

                    <div class="">
                        <label>Comment avez-vous découvert notre association ?</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="facebook" name="sources[]" value="facebook">
                            <label class="form-check-label" for="facebook">Facebook</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="instagram" name="sources[]" value="instagram">
                            <label class="form-check-label" for="instagram">Instagram</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="twitter" name="sources[]" value="twitter">
                            <label class="form-check-label" for="twitter">Twitter / X</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="linkedin" name="sources[]" value="linkedin">
                            <label class="form-check-label" for="linkedin">LinkedIn</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="site" name="sources[]" value="site">
                            <label class="form-check-label" for="site">Notre site</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="statut_whatsapp" name="sources[]" value="statut_whatsapp">
                            <label class="form-check-label" for="statut_whatsapp">Statut WhatsApp d'un ami</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="ami" name="sources[]" value="ami">
                            <label class="form-check-label" for="ami">Biais d'un ami</label>
                        </div>
                    </div>

                    <div class="">
                        <label for="motivation"></label>
                        <textarea class="form-control" rows="5" maxlength="500" name="motivation" placeholder="Pourquoi avez-vous choisi de rejoindre Sterna Africa ? Quelles sont vos motivations ?" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="volonteer"></label>
                        <textarea class="form-control" rows="5" maxlength="500" name="volonteer" placeholder="Comment définissez-vous le volontariat ?" required></textarea>
                    </div>

                    <div class="">
                        <label>Êtes-vous conscient.e que cet engagement est volontaire et sans rémunération ?</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="engagement_oui" name="engagement_gratuit" value="oui">
                            <label class="form-check-label" for="engagement_oui">Oui</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="engagement_non" name="engagement_gratuit" value="non">
                            <label class="form-check-label" for="engagement_non">Non</label>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label>Seriez-vous disposé.e à contribuer pour soutenir des communautés ?</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="contribution_oui" name="contribution" value="oui">
                            <label class="form-check-label" for="contribution_oui">Oui</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="contribution_non" name="contribution" value="non">
                            <label class="form-check-label" for="contribution_non">Non</label>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label>Votre disponibilité</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="disponibilite_regulièrement" name="disponibilite" value="regulièrement">
                            <label class="form-check-label" for="disponibilite_regulièrement">Régulièrement</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="disponibilite_parfois" name="disponibilite" value="parfois">
                            <label class="form-check-label" for="disponibilite_parfois">Par moment</label>
                        </div>
                    </div>

                    <div class="">
                        <label>Avez-vous un passeport ?</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="passeport_oui" name="passeport" value="oui">
                            <label class="form-check-label" for="passeport_oui">Oui</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="passeport_non" name="passeport" value="non">
                            <label class="form-check-label" for="passeport_non">Non</label>
                        </div>
                    </div>

                    <div class="">
                        <label for="qualites"></label>
                        <textarea class="form-control" rows="5" maxlength="500" name="qualites" placeholder="Citez-nous 3 de vos qualités ?" required></textarea>
                    </div>

                    <div class="">
                        <label for="defauts"></label>
                        <textarea class="form-control" rows="5" maxlength="500" name="defauts" placeholder="Citez-nous 3 de vos défauts ?" required></textarea>
                    </div>

                    <!-- <div class="mb-2">
                        <label for="enquete">Enquête</label>
                        <input type="text" class="form-control" id="enquete" placeholder="Avez-vous un ami dans notre association ? Si oui, son prénom ?" name="enquete" required>
                    </div> -->

                    <div class="">
                        <label for="apport"></label>
                        <textarea class="form-control" rows="5" placeholder="Quelles valeurs pouvez-vous apporter en rejoignant notre association ?" name="apport" required></textarea>
                    </div>

                    <div class="mb-2">
                        <label for="dernierMot"></label>
                        <textarea class="form-control" rows="5" placeholder="parler nous unpeu de vous, de votre parcours ?" name="dernierMot" required></textarea>
                    </div>

                    <div class="text-left mb-2">
                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </div>

                    <img src="https://i.postimg.cc/8c4NDxST/les-sternes-8.jpg" alt="benevol" class="w-100 rounded">
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>


    <?php require_once('../config/footer_2.php'); ?>
    
</body>
</html>