<style>
.cube-container {
    display: flex;
    gap: 25px;
    overflow-x: auto;
    padding: 30px;
    white-space: nowrap;
    text-align: center;
}

/* Style spécifique pour les écrans plus larges (ordinateurs) */
@media (min-width: 768px) {
    .cube-container {
        justify-content: center; /* Centre les cubes uniquement sur les écrans larges */
        padding: 1em;
    }
}

.cube-container::-webkit-scrollbar {
    height: 6px;
}

.cube-container::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 3px;
}

.cube-container::-webkit-scrollbar-track {
    background-color: #f0f0f0;
}

.cube {
    min-width: 150px;
    /* height: 150px; */
    font-size: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 5px;
    border: 2px solid #033e60;
    transition: background 0.4s ease, transform 0.3s ease;
    white-space: normal;
    cursor: pointer;
    padding: 1em;
}

.cube:hover {
    background: linear-gradient(45deg, #033e60, #50C878);
    transform: scale(1.1);
    border: 0px solid #033e60;
    color: white;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" referrerpolicy="no-referrer" />

<div class="cube-container">
    <div class="cube p-2 comic-neue-bold" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Solidarité Internationale
    </div>

    <div class="cube comic-neue-bold" data-bs-toggle="modal" data-bs-target="#exampleModal1">
        Volontariat
    </div>

    <div class="cube p-2 comic-neue-bold" data-bs-toggle="modal" data-bs-target="#exampleModal2">
        Développement Communautaire
    </div>
</div>

<!-- Modal 1-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body comic-neue-regular">
        Favoriser une meilleure prise de conscience autour des problèmes de développement, afin de construire à terme des rapports sociaux et économiques équitables pour un développement durable au profit de la population africaine en particulier.
      </div>
    </div>
  </div>
</div>

<!-- Modal 2-->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body comic-neue-regular">
        Le volontariat des jeunes est une façon innovante de stimuler le développement à l’échelle mondiale. C'est l’une des meilleures façons d’aider la jeunesse à pleinement réaliser son potentiel social, économique et humain pour le développement mondial et la paix. Il habilite les jeunes à assumer un rôle de leadership tout en leur permettant d’acquérir des compétences professionnelles et pratiques précieuses, ce qui les prépare au marché du travail et augmente leur capacité d’insertion professionnelle. Nos volontaires sont engagés pour une bonne cause et sans contrainte, à donner de leur temps et de leur énergie parce que nous voulons aider, atténuer les conditions de vie des populations, leur apporter un sourire, une satisfaction, sans aucune contrepartie financière.
      </div>
    </div>
  </div>
</div>

<!-- Modal 3-->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body comic-neue-regular">
        En unissant nos efforts à ceux des Pouvoirs publics en vue d'améliorer la situation économique, sociale et culturelle des collectivités, grâce à nos activités au profit des populations cibles. <br>
        Nos actions visent particulièrement l'atteinte des 17 Objectifs de Développement Durable, en particulier :
        <h3 translate="no" class="pt-2"><b> ODD 1 </b></h3>
        Le premier objectif vise la fin de la pauvreté et la lutte contre les inégalités sous toutes ses formes et partout dans le monde. La pauvreté est le premier obstacle au développement et à une qualité de vie décente. C'est plus qu'un manque de revenus et de ressources. Ses manifestations se traduisent par plusieurs privatisations : accès limité aux soins de santé, à l'éducation, à l'eau et au logement, mais aussi les phénomènes de discrimination et d'exclusion sociale, ainsi que l'exclusion du processus de décision. Grâce aux multiples actions des organisations internationales et locales, le nombre de personnes qui, dans le monde vivent dans l’extrême pauvreté a été divisé par deux depuis 1990. En 2015, il y avait cependant encore environ 737 millions de personnes vivant avec moins de 1,90 dollars par jour (Banque mondiale). Environ les trois quarts des personnes en situation d’extrême pauvreté vivent en zone rurale, et la plupart dépendent de l’agriculture pour leurs moyens d’existence et leur sécurité alimentaire. L’agriculture inclusive, la production alimentaire et les activités extra-agricoles peuvent créer des emplois et éliminer la faim dans les zones rurales, en donnant aux populations une possibilité de nourrir leurs familles et de mener une vie décente. Les efforts de <strong>STERNA AFRICA</strong> sur ce volet sont concentrés sur : <span class="fst-italic"> <b>L'activité du déjeuner des démunis, les différentes donations en vivre et en vêtements, la mise en coopérative et la formation des femmes des milieux ruraux, la mise en place d'une ferme agricole pour continuer à aider les couches nécessiteuses</b></span> .

        <h3 translate="no" class="pt-2"><b>ODD 3</b></h3>
        Permettre à tous de vivre en bonne santé et promouvoir le bien-être de tous à tout âge sont des conditions essentielles au développement durable. Actuellement, le monde est en proie à une crise sanitaire mondiale sans précédent, la COVID-19 provoque de grandes souffrances, déstabilise l’économie mondiale et bouleverse la vie de milliards de personnes dans le monde entier. Davantage d'efforts sont réquis pour éradiquer un large éventail de maladies et pour résoudre de nombreux enjeux sanitaires, qu’ils soient anciens ou nouveaux. Assurer la santé et le bien-être de tous, améliorer la santé procréative, maternelle et infantile, en réduisant les principales maladies transmissibles, non transmissibles, environnementales et mentales. Ces enjeux sanitaires pourront être réalisés à condition de mettre en place des systèmes de prévention visant la réduction des comportements déviants ainsi que tout facteur de risque pour la santé, d’assurer un accès universel à une couverture médicale et aux services de santé. <br> <br>
        Pour l'instant, la sensibilisation des couches les plus vulnérables reste la stratégie que <strong>STERNA AFRICA</strong> utilise pour assurer le bien-être des population. De nombreuses activités de sensibilisations sur les sujets tels que: <span class="fst-italic"><b>l'Electrophorèse, les Hépatites, les Grossesses en milieu scolaire, les Maladies sexuellement transmissible, la COVID-19 et sa vaccination, l'Hygiène menstruelle et l'utilisation des serviettes hygiénique lavable, mais aussi des activités de don de sang, etc.</b></span> 

        <h3 translate="no" class="pt-2"><b>ODD 4 </b></h3>
        En 2020, alors que la pandémie de COVID-19 se propageait dans le monde entier, une majorité de pays a imposé la fermeture temporaire des écoles ; plus de 91% des élèves dans le monde ont été concernés. En avril 2020, la fermeture des écoles a touché près de 1,6 milliard d’enfants et de jeunes. Près de 369 millions d’enfants qui dépendent normalement des repas scolaires comme source fiable de nutrition quotidienne ont dû se tourner vers d’autres sources. <br> <br>
        Jamais dans l’histoire, autant d’enfants n’ont été déscolarisés en même temps ; cette situation a perturbé leur apprentissage et bouleversé leur vie, notamment en ce qui concerne les enfants les plus vulnérables et les plus marginalisés. La pandémie mondiale a de graves conséquences qui peuvent mettre en péril les progrès durement acquis dans le domaine de l’amélioration de la qualité de l’éducation au niveau mondial.
        Nos actions dans ce sens sont très diversifiées, de la distribution de kits scolaires aux élèves les plus démunis, en passant par nos chantiers de soutien scolaire réalisé chaque été dans les communautés reculées pour renforcer le niveau des enfants, les échanges épistolaires entre les élèves dans différents pays sans oublier le programme d'éducation à l'environnement avec les tout petits, les enfants sont nos principales cibles en matière d'éducation et nous y consacrons 60% de nos activités chaque année.

        <h3 translate="no" class="pt-2"><b>ODD 5 </b></h3>
        L’égalité des sexes n’est pas seulement un droit fondamental à la personne, elle est aussi un fondement nécessaire pour l’instauration d’un monde pacifique, prospère et durable. Des progrès ont été réalisés au cours des dernières décennies. Davantage de filles sont scolarisées, moins de filles sont contraintes de se marier précocement, davantage de femmes siègent dans les parlements et occupent des postes de direction, et les lois sont réformées afin de faire progresser l’égalité des sexes. <br> <br>
        En dépit de ces avancées, de nombreux défis subsistent : les lois et les normes sociales discriminatoires restent omniprésentes ; les femmes restent sous-représentées à tous les niveaux du pouvoir politique ; les femmes et les filles continuent de subir des violences physiques ou sexuelles de la part d’un partenaire intime.
        Rendre les femmes autonomes est pour nous la seule solution sinon la toute première pour aboutir à une réduction des inégalités entre les sexes. C'est pour cette raison que nous multiplions les formations à l'endroit des coopératives de femmes, travaillons sur leur alphabétisation, leur mises en coopérative pour créer une activité génératrice de revenus, leur fournir l'information nécessaire pour ne plus être coupé de la réalité du monde extérieur.

        <h3 translate="no" class="pt-2"><b>ODD 13 </b></h3>

        L’année 2019 a été la deuxième année la plus chaude de l’histoire et marque la fin d’une décennie (2010- 2019) de chaleur exceptionnelle. Les changements climatiques affectent désormais tous les pays sur tous les continents. Ils perturbent les économies nationales et affectent des vies, tandis que les conditions météorologiques changent, le niveau de la mer monte et les phénomènes météorologiques deviennent plus extrêmes. Bien que les émissions de gaz à effet de serre ont diminuées en 2020 en raison des restrictions de déplacement et du ralentissement des activités économiques liés à la pandémie de COVID-19, cette amélioration n’était que temporaire. Les changements climatiques ne connaissent aucun répit. Une fois que l’économie mondiale a trouver une stratégie de vivre avec la pandémie, les émissions sont revenus à des niveaux plus élevés. Pour sauver des vies et des moyens de subsistance, il faut agir de toute urgence pour lutter à la fois contre la pandémie et contre l’urgence climatique. <br> <br>
        Le travail de sensibilisation, de dénonciation, de salubrité à toutes les échelles locales et internationales et l'incitation des politiques à une prise en compte plus sérieuse du danger que constitue le réchauffement climatique pour la vie humaine qui doit prendre le dessus sur tout autres sujets.
      </div>
    </div>
  </div>
</div>


