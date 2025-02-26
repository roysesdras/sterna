
<body>
    <main class="bar mb-2"">
        <nav class="navbar navbar-expand-sm navbar-tertiary-dark bg-tertiary-dark fixed shadow p-1" aria-label="Third navbar example>
            <div class="container-fluid">
                <a href="https://sternaafrica.org/" class="logo me-auto">
                    <img src="https://sternaafrica.org/assets/img/logos/sternaofficiel-2.png" alt="logoSterna" class="img-fluid">
                </a>

                <form class="d-flex me-auto" role="search" id="searchForm" style="position: relative; left: -40px;">
                    <input class="form-control comic-neue-regular" type="search" placeholder="search..." aria-label="Rechercher" id="searchInput">
                </form>
                <div id="searchResults" class="dropdown-menu tertiary-dark" style="display: none; max-width: 500px;"></div>

                <!-- Bouton pour ouvrir le menu (avec ombre) -->
                <span style="cursor: pointer; position: fixed; z-index: 1000; right: 30px; top: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); background-color: white; color: #111; padding: 5px 8px; border-radius: 5px;" onclick="openNav()" class="comic-neue-regular">menu</span>

            </div>
        </nav>
    </main>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

        <a class="nav-link comic-neue-regular" href="https://sternaafrica.org/"><i class="fa-solid fa-house"></i> Acceuil</a>

        <a class="nav-link comic-neue-regular" href="https://sternaafrica.org/pages/about.php"><i class="fa-solid fa-circle-info"></i> Sur Nous</a>

        <a class="nav-link comic-neue-regular" href="https://sternaafrica.org/pages/activite.php"><i class="fa-regular fa-calendar-days"></i> Activités</a>

        <div class="dropdown">
            <a class="nav-link comic-neue-regular" href="#" onclick="toggleDropdown(event)">
            <i class="fa-solid fa-chart-line"></i> Évènements <i class="fas fa-caret-down dropdown-icon"></i>
            </a>
            <div class="dropdown-content">
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/pages/festival_solidarite.php">Fest. des Solidarités</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/pages/festival_alimenterre.php">Fest. Alimenterre</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/pages/jvf.php">Journée Volontariat Fr</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/pages/jiv.php">Journée Int. Volontariat</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/pages/jide.php">Journée Int. Dr. Enfants</a>
            </div>
        </div>

        <a class="nav-link comic-neue-regular" href="http://localhost/sternaafrica/ils_parlent.php"><i class="fa-solid fa-people-arrows"></i> Ils Parlent de Nous</a></li>

        <div class="dropdown">
            <a class="nav-link comic-neue-regular" href="#" onclick="toggleDropdown(event)">
            <i class="fa-regular fa-newspaper"></i> Newsletters <i class="fas fa-caret-down dropdown-icon"></i>
            </a>
            <div class="dropdown-content">
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/newsletters/annee_2024/decembre">Décembre 2024</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/newsletters/annee_2024/octobre">Octobre 2024</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/newsletters/annee_2024/juin">Juin 2024</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/newsletters/annee_2024/mars">Mars 2024</a>

                <hr>
                
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/newsletters/annee_2023/decembre">Décembre 2023</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/newsletters/annee_2023/octobre">Octobre 2023</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/newsletters/annee_2023/juillet">Juillet 2023</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/newsletters/annee_2023/avril">Avril 2023</a>
            </div>
        </div>
        
        <div class="dropdown">
            <a class="nav-link comic-neue-regular" href="#" onclick="toggleDropdown(event)">
            <i class="fa-solid fa-scroll"></i> Rapports Annuels <i class="fas fa-caret-down dropdown-icon"></i>
            </a>
            <div class="dropdown-content">
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/rapport/annee_2024">Année 2024</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/rapport/annee_2023">Année 2023</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/rapport/annee_2022">Année 2022</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/rapport/annee_2021">Année 2021</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/rapport/annee_2020">Année 2020</a>
            </div>
        </div>

        <div class="dropdown">
            <a class="nav-link comic-neue-regular" href="#" onclick="toggleDropdown(event)">
            <i class="fa-solid fa-satellite-dish"></i> Nos Antennes <i class="fas fa-caret-down dropdown-icon"></i>
            </a>
            <div class="dropdown-content">
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/antenne/CotedIvoire.php">Côte d'Ivoire</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/antenne/benin.php">Bénin</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/antenne/burkinaFaso.php">Burkina Faso</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/antenne/togo.php">Togo</a>
                <a class="dropdown-item comic-neue-regular" href="https://sternaafrica.org/antenne/congoBrazza.php">Congo-Brazza</a>
            </div>
        </div>

        <a class="nav-link comic-neue-regular" href="https://sternaafrica.org/admin/admin_login.php"><i class="fa-solid fa-user-tie"></i> Espace Admin</a>

        <a class="nav-link comic-neue-regular" href="https://sternaafrica.org/interview"><i class="fa-solid fa-quote-left"></i> Temoignager</a>

        <button class="get-started comic-neue-regular" style="margin-left: 25px;" onclick="window.open('https://buy.stripe.com/aEU4iXa9Y9gA5j2000', '_blank')">
        <i class="fa-solid fa-circle-dollar-to-slot"></i> Faire un Don
        </button>


    </div>

    <script>

    function openNav(){document.getElementById("mySidenav").style.width="250px"}function closeNav(){document.getElementById("mySidenav").style.width="0"}function toggleDropdown(e){e.preventDefault();var t=e.currentTarget.nextElementSibling;document.querySelectorAll(".dropdown-content").forEach(function(e){e!==t&&e.classList.remove("dropdown-active")}),t.classList.toggle("dropdown-active")}document.addEventListener("DOMContentLoaded",function(){let e=document.getElementById("searchInput"),t=document.getElementById("searchResults"),n;e.addEventListener("input",function(){let r=e.value;if(clearTimeout(n),r.length<1){t.style.display="none",t.innerHTML="";return}n=setTimeout(()=>{fetch(`https://sternaafrica.org/search_actualites.php?query=${r}`).then(e=>e.text()).then(e=>{console.log("R\xe9ponse brute:",e);try{let n=JSON.parse(e);t.innerHTML="",t.style.display="block",n.length>0?n.forEach(e=>{let n=document.createElement("a");n.classList.add("dropdown-item"),n.href=`https://sternaafrica.org/actualite/actualite_detail.php?id=${e.id}`,n.innerHTML=`
                                    <div class="d-flex align-items-center">
                                        <img src="https://sternaafrica.org/images/${e.image}" class="float-start me-2" alt="${e.title}">
                                        <div>
                                            <strong class="comic-neue-bold">${e.title.substring(0,40)}</strong><br>
                                            <small class="comic-neue-regular">${e.description.substring(0,30)}...</small>
                                        </div>
                                    </div>
                                `,t.appendChild(n)}):t.innerHTML='<span class="dropdown-item">Aucun r\xe9sultat</span>'}catch(r){console.error("Erreur de parsing JSON:",r)}}).catch(e=>{console.error("Erreur de requ\xeate:",e)})},200)}),document.addEventListener("click",function(n){e.contains(n.target)||t.contains(n.target)||(t.style.display="none")})});
                                
    </script>