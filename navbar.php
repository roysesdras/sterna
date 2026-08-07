<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// Fetch Bulletins (newsletters) grouped by year
$newsletters = [];
$stmt_bull = $conn->query("SELECT * FROM rapports WHERE type_document = 'bulletin' ORDER BY annee DESC, trimestre DESC");
if ($stmt_bull) {
    while ($row = $stmt_bull->fetch_assoc()) {
        $year = $row['annee'];
        if (!isset($newsletters[$year])) {
            $newsletters[$year] = [];
        }
        $newsletters[$year][$row['titre']] = $row['pdf_link'];
    }
}

// Fetch Rapports Annuels grouped by year
$rapports_annuels = [];
$stmt_rap = $conn->query("SELECT * FROM rapports WHERE type_document = 'rapport_annuel' ORDER BY annee DESC");
if ($stmt_rap) {
    while ($row = $stmt_rap->fetch_assoc()) {
        $year = $row['annee'];
        $rapports_annuels[$year] = $row['pdf_link'];
    }
}
?>
<!-- Load Tailwind and Flaticon Icons -->
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.1.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
<link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.1.0/uicons-brands/css/uicons-brands.css">
<script>
	tailwind.config = {
		corePlugins: {
			preflight: false,
		},
		theme: {
			extend: {
				colors: {
					'sterna-blue': '#04378bec',
					'sterna-yellow': '#ffbd17ff',
					'sterna-green': '#eaf0edff',
					'sterna-keppel': '#44aca0',
					'sterna-rose': '#ea0f68',
					'sterna-orange': '#ff8800',
					'urunani-orange': '#ff8800',
					'urunani-rose': '#ea750fff',
				},
				fontFamily: {
					'sans': ['Quicksand', 'sans-serif'],
				}
			}
		}
	}
</script>
<style>
/* Custom Global Desktop Dropdown Styles */
@media (min-width: 768px) {
    /* Dropdown container */
    .elementor-widget-nav-menu .elementor-nav-menu--dropdown {
        background-color: #fcb900 !important;
        border-radius: 12px !important;
        padding: 8px !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        border: none !important;
    }
    /* Dropdown links */
    .elementor-widget-nav-menu .elementor-nav-menu--dropdown a.elementor-sub-item {
        color: #085191 !important;
        background-color: transparent !important;
        border-radius: 8px !important;
        padding: 10px 15px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        transition: all 0.25s ease !important;
    }
    /* Hover effect */
    .elementor-widget-nav-menu .elementor-nav-menu--dropdown a.elementor-sub-item:hover,
    .elementor-widget-nav-menu .elementor-nav-menu--dropdown a.elementor-sub-item:focus {
        background-color: #085191 !important;
        color: #ffffff !important;
    }
}
</style>
<header data-elementor-type="header" data-elementor-id="574"
		class="elementor elementor-574 elementor-location-header" data-elementor-post-type="elementor_library">
		<header class="elementor-element elementor-element-8184513 e-flex e-con-boxed e-con e-parent" data-id="8184513"
			data-element_type="container" data-e-type="container"
			data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;jet_parallax_layout_list&quot;:[]}">
			<div class="e-con-inner">
				<div class="elementor-element elementor-element-ae90c4b elementor-widget__width-initial elementor-widget elementor-widget-image"
					data-id="ae90c4b" data-element_type="widget" data-e-type="widget" data-widget_type="image.default">
					<div class="elementor-widget-container">
						<a href="/">
							<img width="90" height="52" src="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png"
								class="attachment-large size-large wp-image-566" alt="" style="max-width: 100px; height: auto;" /> </a>
					</div>
				</div>
				<div class="elementor-element elementor-element-578d3e7 elementor-nav-menu__align-justify elementor-nav-menu--stretch elementor-hidden-desktop elementor-hidden-tablet elementor-nav-menu--dropdown-tablet elementor-nav-menu__text-align-aside elementor-nav-menu--toggle elementor-nav-menu--burger elementor-widget elementor-widget-nav-menu"
					data-id="578d3e7" data-element_type="widget" data-e-type="widget"
					data-settings="{&quot;full_width&quot;:&quot;stretch&quot;,&quot;layout&quot;:&quot;horizontal&quot;,&quot;submenu_icon&quot;:{&quot;value&quot;:&quot;&lt;svg aria-hidden=\&quot;true\&quot; class=\&quot;e-font-icon-svg e-fas-caret-down\&quot; viewBox=\&quot;0 0 320 512\&quot; xmlns=\&quot;http:\/\/www.w3.org\/2000\/svg\&quot;&gt;&lt;path d=\&quot;M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z\&quot;&gt;&lt;\/path&gt;&lt;\/svg&gt;&quot;,&quot;library&quot;:&quot;fa-solid&quot;},&quot;toggle&quot;:&quot;burger&quot;}"
					data-widget_type="nav-menu.default">
					<div class="elementor-widget-container">
						<nav aria-label="Menu"
							class="elementor-nav-menu--main elementor-nav-menu__container elementor-nav-menu--layout-horizontal e--pointer-text e--animation-grow">
							<ul id="menu-1-578d3e7" class="elementor-nav-menu">
								<li
									class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-994">
									<a href="/a-propos/" class="elementor-item">A propos</a>
									<ul class="sub-menu elementor-nav-menu--dropdown">
										<li
											class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3291">
											<a href="/a-propos/"
												class="elementor-sub-item">Sur nous</a>
										</li>
										
										
										<li
											class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3294">
											<a href="#" style="color: #aaa !important; cursor: not-allowed; pointer-events: none;" aria-disabled="true" class="elementor-sub-item">Équipe</a>
										</li>
									</ul>
								</li>
								<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">
									<a href="#" class="elementor-item">Bull. Trimestriels</a>
									<ul class="sub-menu elementor-nav-menu--dropdown">
										<?php if(!empty($newsletters)): foreach ($newsletters as $year => $months): ?>
										<li class="menu-item menu-item-type-custom menu-item-object-custom">
											<span class="elementor-sub-item" style="font-weight: 900; color: #ea0f68 !important; background: transparent !important; cursor: default; border-bottom: 2px solid #ea0f68; border-radius: 0 !important; padding: 5px 15px !important; margin-bottom: 5px;">Année <?php echo htmlspecialchars($year); ?></span>
										</li>
										<?php foreach ($months as $month => $pdf): ?>
										<li class="menu-item menu-item-type-custom menu-item-object-custom">
											<a href="<?php echo htmlspecialchars($pdf); ?>" download class="elementor-sub-item" style="padding-left: 25px !important;"><i class="bi bi-download"></i> <?php echo htmlspecialchars($month); ?></a>
										</li>
										<?php endforeach; ?>
										<?php endforeach; else: ?>
										<li class="menu-item"><a href="#" class="elementor-sub-item">Aucun bulletin</a></li>
										<?php endif; ?>
									</ul>
								</li>
								<li
									class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-993">
									<a href="/missions/" class="elementor-item">Missions</a>
									<ul class="sub-menu elementor-nav-menu--dropdown">
										<li
											class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3312">
											<a href="/missions/laccompagnement/"
												class="elementor-sub-item">L’accompagnement</a>
										</li>
										<li
											class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3313">
											<a href="/missions/sensibiliser-aux-enjeux-globaux/"
												class="elementor-sub-item">Sensibiliser aux enjeux globaux </a>
										</li>
										<li
											class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3314">
											<a href="/missions/les-voix-et-messages-du-reseau/"
												class="elementor-sub-item">Les voix et messages du réseau</a>
										</li>
										<li
											class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3315">
											<a href="/missions/soutiller-et-se-renforcer/"
												class="elementor-sub-item">S’outiller et se renforcer</a>
										</li>
										<li
											class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3316">
											<a href="/missions/place-aux-jeunes/"
												class="elementor-sub-item">Place aux Jeunes</a>
										</li>
									</ul>
								</li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-995"><a
										href="/projets/" class="elementor-item">Projets</a></li>
								<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">
									<a href="#" class="elementor-item">Rapp. Annuels</a>
									<ul class="sub-menu elementor-nav-menu--dropdown">
										<?php if(!empty($rapports_annuels)): foreach ($rapports_annuels as $year => $pdf): ?>
										<li class="menu-item menu-item-type-custom menu-item-object-custom">
											<a href="<?php echo htmlspecialchars($pdf); ?>" download class="elementor-sub-item">Année <?php echo htmlspecialchars($year); ?></a>
										</li>
										<?php endforeach; else: ?>
										<li class="menu-item"><a href="#" class="elementor-sub-item">Aucun rapport</a></li>
										<?php endif; ?>
									</ul>
								</li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-997"><a
										href="/actus/" class="elementor-item">Actus</a></li>
								<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-998"><a
										href="/evenements/" class="elementor-item">Agenda</a></li>
							</ul>
						</nav>
						<div class="elementor-menu-toggle" role="button" tabindex="0" aria-label="Permuter le menu"
							aria-expanded="false">
							<svg aria-hidden="true" role="presentation"
								class="elementor-menu-toggle__icon--open e-font-icon-svg e-eicon-menu-bar"
								viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg">
								<path
									d="M104 333H896C929 333 958 304 958 271S929 208 896 208H104C71 208 42 237 42 271S71 333 104 333ZM104 583H896C929 583 958 554 958 521S929 458 896 458H104C71 458 42 487 42 521S71 583 104 583ZM104 833H896C929 833 958 804 958 771S929 708 896 708H104C71 708 42 737 42 771S71 833 104 833Z">
								</path>
							</svg><svg aria-hidden="true" role="presentation"
								class="elementor-menu-toggle__icon--close e-font-icon-svg e-eicon-close"
								viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg">
								<path
									d="M742 167L500 408 258 167C246 154 233 150 217 150 196 150 179 158 167 167 154 179 150 196 150 212 150 229 154 242 171 254L408 500 167 742C138 771 138 800 167 829 196 858 225 858 254 829L496 587 738 829C750 842 767 846 783 846 800 846 817 842 829 829 842 817 846 804 846 783 846 767 842 750 829 737L588 500 833 258C863 229 863 200 833 171 804 137 775 137 742 167Z">
								</path>
							</svg>
						</div>
						<nav class="elementor-nav-menu--dropdown elementor-nav-menu__container" aria-hidden="true">
							<ul id="menu-2-578d3e7" class="elementor-nav-menu">
								<li
									class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-994">
									<a href="/a-propos/" class="elementor-item" tabindex="-1">A propos</a>
									<ul class="sub-menu elementor-nav-menu--dropdown">
										<li
											class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3291">
											<a href="/a-propos/" class="elementor-sub-item"
												tabindex="-1">Sur nous</a>
										</li>
										
										
										<li
											class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3294">
											<a href="#" style="color: #aaa !important; cursor: not-allowed; pointer-events: none;" aria-disabled="true" class="elementor-sub-item"
												tabindex="-1">Équipe</a>
										</li>
									</ul>
								</li>
								<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">
									<a href="#" class="elementor-item" tabindex="-1">Bull. Trimestriels</a>
									<ul class="sub-menu elementor-nav-menu--dropdown">
										<?php if(!empty($newsletters)): foreach ($newsletters as $year => $months): ?>
										<li class="menu-item menu-item-type-custom menu-item-object-custom">
											<span class="elementor-sub-item" style="font-weight: 900; color: #ea0f68 !important; background: transparent !important; cursor: default; border-bottom: 2px solid #ea0f68; border-radius: 0 !important; padding: 5px 15px !important; margin-bottom: 5px;">Année <?php echo htmlspecialchars($year); ?></span>
										</li>
										<?php foreach ($months as $month => $pdf): ?>
										<li class="menu-item menu-item-type-custom menu-item-object-custom">
											<a href="<?php echo htmlspecialchars($pdf); ?>" download class="elementor-sub-item" tabindex="-1" style="padding-left: 25px !important;"><i class="bi bi-download"></i> <?php echo htmlspecialchars($month); ?></a>
										</li>
										<?php endforeach; ?>
										<?php endforeach; else: ?>
										<li class="menu-item"><a href="#" class="elementor-sub-item" tabindex="-1">Aucun bulletin</a></li>
										<?php endif; ?>
									</ul>
								</li>
								<li
									class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-993">
									<a href="/missions/" class="elementor-item" tabindex="-1">Missions</a>
									<ul class="sub-menu elementor-nav-menu--dropdown">
										<li
											class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3312">
											<a href="/missions/laccompagnement/" class="elementor-sub-item"
												tabindex="-1">L’accompagnement</a>
										</li>
										<li
											class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3313">
											<a href="/missions/sensibiliser-aux-enjeux-globaux/"
												class="elementor-sub-item" tabindex="-1">Sensibiliser aux enjeux
												globaux </a>
										</li>
										<li
											class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3314">
											<a href="/missions/les-voix-et-messages-du-reseau/"
												class="elementor-sub-item" tabindex="-1">Les voix et messages du
												réseau</a>
										</li>
										<li
											class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3315">
											<a href="/missions/soutiller-et-se-renforcer/"
												class="elementor-sub-item" tabindex="-1">S’outiller et se renforcer</a>
										</li>
										<li
											class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3316">
											<a href="/missions/place-aux-jeunes/" class="elementor-sub-item"
												tabindex="-1">Place aux Jeunes</a>
										</li>
									</ul>
								</li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-995"><a
										href="/projets/" class="elementor-item" tabindex="-1">Projets</a></li>
								<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">
									<a href="#" class="elementor-item" tabindex="-1">Rapp. Annuels</a>
									<ul class="sub-menu elementor-nav-menu--dropdown">
										<?php if(!empty($rapports_annuels)): foreach ($rapports_annuels as $year => $pdf): ?>
										<li class="menu-item menu-item-type-custom menu-item-object-custom">
											<a href="<?php echo htmlspecialchars($pdf); ?>" download class="elementor-sub-item" tabindex="-1">Année <?php echo htmlspecialchars($year); ?></a>
										</li>
										<?php endforeach; else: ?>
										<li class="menu-item"><a href="#" class="elementor-sub-item" tabindex="-1">Aucun rapport</a></li>
										<?php endif; ?>
									</ul>
								</li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-997"><a
										href="/actus/" class="elementor-item" tabindex="-1">Actus</a></li>
								<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-998"><a
										href="/evenements/" class="elementor-item" tabindex="-1">Agenda</a></li>
							</ul>
						</nav>
					</div>
				</div>
				<div class="elementor-element elementor-element-d01517a elementor-search-form--skin-minimal elementor-widget__width-initial elementor-hidden-desktop elementor-hidden-tablet elementor-widget elementor-widget-search-form"
					data-id="d01517a" data-element_type="widget" data-e-type="widget"
					data-settings="{&quot;skin&quot;:&quot;minimal&quot;}" data-widget_type="search-form.default">
					<div class="elementor-widget-container">
						<search role="search">
							<form class="elementor-search-form" action="/engage" method="get">
								<div class="elementor-search-form__container">
									<label class="elementor-screen-only" for="elementor-search-form-d01517a">Rechercher
									</label>

									<div class="elementor-search-form__icon">
										<div class="e-font-icon-svg-container"><svg aria-hidden="true"
												class="e-font-icon-svg e-fas-search" viewBox="0 0 512 512"
												xmlns="http://www.w3.org/2000/svg">
												<path
													d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z">
												</path>
											</svg></div> <span class="elementor-screen-only">Rechercher </span>
									</div>

									<input id="elementor-search-form-d01517a" placeholder=""
										class="elementor-search-form__input" type="search" name="s" value="">


								</div>
							</form>
						</search>
					</div>
				</div>
				<div class="elementor-element elementor-element-5944f62 e-con-full elementor-hidden-mobile e-flex e-con e-child"
					data-id="5944f62" data-element_type="container" data-e-type="container"
					data-settings="{&quot;jet_parallax_layout_list&quot;:[]}">
					<div class="elementor-element elementor-element-77a1fae e-con-full e-flex e-con e-child"
						data-id="77a1fae" data-element_type="container" data-e-type="container"
						data-settings="{&quot;jet_parallax_layout_list&quot;:[]}">
						<div class="elementor-element elementor-element-7764b14 elementor-widget__width-initial elementor-search-form--skin-classic elementor-search-form--button-type-icon elementor-search-form--icon-search elementor-widget elementor-widget-search-form"
							data-id="7764b14" data-element_type="widget" data-e-type="widget"
							data-settings="{&quot;skin&quot;:&quot;classic&quot;}"
							data-widget_type="search-form.default">
							<div class="elementor-widget-container">
								<search role="search">
									<form class="elementor-search-form" action="/engage" method="get">
										<div class="elementor-search-form__container">
											<label class="elementor-screen-only"
												for="elementor-search-form-7764b14">Rechercher </label>


											<input id="elementor-search-form-7764b14" placeholder="Rechercher"
												class="elementor-search-form__input" type="search" name="s" value="">

											<button class="elementor-search-form__submit" type="submit"
												aria-label="Rechercher ">
												<div class="e-font-icon-svg-container"><svg
														class="fa fa-search e-font-icon-svg e-fas-search"
														viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
														<path
															d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z">
														</path>
													</svg></div>
											</button>

										</div>
									</form>
								</search>
							</div>
						</div>
						<div class="elementor-element elementor-element-3be5492 elementor-align-center elementor-widget elementor-widget-button"
							data-id="3be5492" data-element_type="widget" data-e-type="widget"
							data-widget_type="button.default">
							<div class="elementor-widget-container">
								<div class="elementor-button-wrapper">
									<a class="elementor-button elementor-button-link elementor-size-sm"
										href="/login/" target="_blank" rel="nofollow">
										<span class="elementor-button-content-wrapper">
											<span class="elementor-button-icon">
												<svg aria-hidden="true" class="e-font-icon-svg e-fas-user-circle"
													viewBox="0 0 496 512" xmlns="http://www.w3.org/2000/svg">
													<path
														d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 96c48.6 0 88 39.4 88 88s-39.4 88-88 88-88-39.4-88-88 39.4-88 88-88zm0 344c-58.7 0-111.3-26.6-146.5-68.2 18.8-35.4 55.6-59.8 98.5-59.8 2.4 0 4.8.4 7.1 1.1 13 4.2 26.6 6.9 40.9 6.9 14.3 0 28-2.7 40.9-6.9 2.3-.7 4.7-1.1 7.1-1.1 42.9 0 79.7 24.4 98.5 59.8C359.3 421.4 306.7 448 248 448z">
													</path>
												</svg> </span>
											<span class="elementor-button-text">Me connecter</span>
										</span>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="elementor-element elementor-element-61121aa elementor-nav-menu__align-justify elementor-nav-menu--dropdown-mobile elementor-nav-menu__text-align-aside elementor-nav-menu--toggle elementor-nav-menu--burger elementor-widget elementor-widget-nav-menu"
						data-id="61121aa" data-element_type="widget" data-e-type="widget"
						data-settings="{&quot;layout&quot;:&quot;horizontal&quot;,&quot;submenu_icon&quot;:{&quot;value&quot;:&quot;&lt;svg aria-hidden=\&quot;true\&quot; class=\&quot;e-font-icon-svg e-fas-caret-down\&quot; viewBox=\&quot;0 0 320 512\&quot; xmlns=\&quot;http:\/\/www.w3.org\/2000\/svg\&quot;&gt;&lt;path d=\&quot;M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z\&quot;&gt;&lt;\/path&gt;&lt;\/svg&gt;&quot;,&quot;library&quot;:&quot;fa-solid&quot;},&quot;toggle&quot;:&quot;burger&quot;}"
						data-widget_type="nav-menu.default">
						<div class="elementor-widget-container">
							<nav aria-label="Menu"
								class="elementor-nav-menu--main elementor-nav-menu__container elementor-nav-menu--layout-horizontal e--pointer-text e--animation-grow">
								<ul id="menu-1-61121aa" class="elementor-nav-menu">
									<li
										class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-994">
										<a href="/a-propos/" class="elementor-item">A propos</a>
										<ul class="sub-menu elementor-nav-menu--dropdown">
											<li
												class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3291">
												<a href="/a-propos/"
													class="elementor-sub-item">Sur nous</a>
											</li>
											
											
											<li
												class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3294">
												<a href="#" style="color: #aaa !important; cursor: not-allowed; pointer-events: none;" aria-disabled="true" class="elementor-sub-item">Équipe</a>
											</li>
										</ul>
									</li>
									<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">
									<a href="#" class="elementor-item">Bull. Trimestriels</a>
									<ul class="sub-menu elementor-nav-menu--dropdown">
										<?php if(!empty($newsletters)): foreach ($newsletters as $year => $months): ?>
										<li class="menu-item menu-item-type-custom menu-item-object-custom">
											<span class="elementor-sub-item" style="font-weight: 900; color: #ea0f68 !important; background: transparent !important; cursor: default; border-bottom: 2px solid #ea0f68; border-radius: 0 !important; padding: 5px 15px !important; margin-bottom: 5px;">Année <?php echo htmlspecialchars($year); ?></span>
										</li>
										<?php foreach ($months as $month => $pdf): ?>
										<li class="menu-item menu-item-type-custom menu-item-object-custom">
											<a href="<?php echo htmlspecialchars($pdf); ?>" download class="elementor-sub-item" style="padding-left: 25px !important;"><i class="bi bi-download"></i> <?php echo htmlspecialchars($month); ?></a>
										</li>
										<?php endforeach; ?>
										<?php endforeach; else: ?>
										<li class="menu-item"><a href="#" class="elementor-sub-item">Aucun bulletin</a></li>
										<?php endif; ?>
									</ul>
								</li>
									<li
										class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-993">
										<a href="/missions/" class="elementor-item">Missions</a>
										<ul class="sub-menu elementor-nav-menu--dropdown">
											<li
												class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3312">
												<a href="/missions/laccompagnement/"
													class="elementor-sub-item">L’accompagnement</a>
											</li>
											<li
												class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3313">
												<a href="/missions/sensibiliser-aux-enjeux-globaux/"
													class="elementor-sub-item">Sensibiliser aux enjeux globaux </a>
											</li>
											<li
												class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3314">
												<a href="/missions/les-voix-et-messages-du-reseau/"
													class="elementor-sub-item">Les voix et messages du réseau</a>
											</li>
											<li
												class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3315">
												<a href="/missions/soutiller-et-se-renforcer/"
													class="elementor-sub-item">S’outiller et se renforcer</a>
											</li>
											<li
												class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3316">
												<a href="/missions/place-aux-jeunes/"
													class="elementor-sub-item">Place aux Jeunes</a>
											</li>
										</ul>
									</li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-995">
										<a href="/projets/" class="elementor-item">Projets</a>
									</li>
									<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">
									<a href="#" class="elementor-item">Rapp. Annuels</a>
									<ul class="sub-menu elementor-nav-menu--dropdown">
										<?php if(!empty($rapports_annuels)): foreach ($rapports_annuels as $year => $pdf): ?>
										<li class="menu-item menu-item-type-custom menu-item-object-custom">
											<a href="<?php echo htmlspecialchars($pdf); ?>" download class="elementor-sub-item">Année <?php echo htmlspecialchars($year); ?></a>
										</li>
										<?php endforeach; else: ?>
										<li class="menu-item"><a href="#" class="elementor-sub-item">Aucun rapport</a></li>
										<?php endif; ?>
									</ul>
								</li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-997">
										<a href="/actus/" class="elementor-item">Actus</a>
									</li>
									<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-998"><a
											href="/evenements/" class="elementor-item">Agenda</a></li>
								</ul>
							</nav>
							<div class="elementor-menu-toggle" role="button" tabindex="0" aria-label="Permuter le menu"
								aria-expanded="false">
								<svg aria-hidden="true" role="presentation"
									class="elementor-menu-toggle__icon--open e-font-icon-svg e-eicon-menu-bar"
									viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg">
									<path
										d="M104 333H896C929 333 958 304 958 271S929 208 896 208H104C71 208 42 237 42 271S71 333 104 333ZM104 583H896C929 583 958 554 958 521S929 458 896 458H104C71 458 42 487 42 521S71 583 104 583ZM104 833H896C929 833 958 804 958 771S929 708 896 708H104C71 708 42 737 42 771S71 833 104 833Z">
									</path>
								</svg><svg aria-hidden="true" role="presentation"
									class="elementor-menu-toggle__icon--close e-font-icon-svg e-eicon-close"
									viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg">
									<path
										d="M742 167L500 408 258 167C246 154 233 150 217 150 196 150 179 158 167 167 154 179 150 196 150 212 150 229 154 242 171 254L408 500 167 742C138 771 138 800 167 829 196 858 225 858 254 829L496 587 738 829C750 842 767 846 783 846 800 846 817 842 829 829 842 817 846 804 846 783 846 767 842 750 829 737L588 500 833 258C863 229 863 200 833 171 804 137 775 137 742 167Z">
									</path>
								</svg>
							</div>
							<nav class="elementor-nav-menu--dropdown elementor-nav-menu__container" aria-hidden="true">
								<ul id="menu-2-61121aa" class="elementor-nav-menu">
									<li
										class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-994">
										<a href="/a-propos/" class="elementor-item" tabindex="-1">A propos</a>
										<ul class="sub-menu elementor-nav-menu--dropdown">
											<li
												class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3291">
												<a href="/a-propos/"
													class="elementor-sub-item" tabindex="-1">Sur nous</a>
											</li>
											
											
											<li
												class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3294">
												<a href="#" style="color: #aaa !important; cursor: not-allowed; pointer-events: none;" aria-disabled="true" class="elementor-sub-item"
													tabindex="-1">Équipe</a>
											</li>
										</ul>
									</li>
									<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">
									<a href="#" class="elementor-item" tabindex="-1">Bull. Trimestriels</a>
									<ul class="sub-menu elementor-nav-menu--dropdown">
										<?php if(!empty($newsletters)): foreach ($newsletters as $year => $months): ?>
										<li class="menu-item menu-item-type-custom menu-item-object-custom">
											<span class="elementor-sub-item" style="font-weight: 900; color: #ea0f68 !important; background: transparent !important; cursor: default; border-bottom: 2px solid #ea0f68; border-radius: 0 !important; padding: 5px 15px !important; margin-bottom: 5px;">Année <?php echo htmlspecialchars($year); ?></span>
										</li>
										<?php foreach ($months as $month => $pdf): ?>
										<li class="menu-item menu-item-type-custom menu-item-object-custom">
											<a href="<?php echo htmlspecialchars($pdf); ?>" download class="elementor-sub-item" tabindex="-1" style="padding-left: 25px !important;"><i class="bi bi-download"></i> <?php echo htmlspecialchars($month); ?></a>
										</li>
										<?php endforeach; ?>
										<?php endforeach; else: ?>
										<li class="menu-item"><a href="#" class="elementor-sub-item" tabindex="-1">Aucun bulletin</a></li>
										<?php endif; ?>
									</ul>
								</li>
									<li
										class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-993">
										<a href="/missions/" class="elementor-item" tabindex="-1">Missions</a>
										<ul class="sub-menu elementor-nav-menu--dropdown">
											<li
												class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3312">
												<a href="/missions/laccompagnement/" class="elementor-sub-item"
													tabindex="-1">L’accompagnement</a>
											</li>
											<li
												class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3313">
												<a href="/missions/sensibiliser-aux-enjeux-globaux/"
													class="elementor-sub-item" tabindex="-1">Sensibiliser aux enjeux
													globaux </a>
											</li>
											<li
												class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3314">
												<a href="/missions/les-voix-et-messages-du-reseau/"
													class="elementor-sub-item" tabindex="-1">Les voix et messages du
													réseau</a>
											</li>
											<li
												class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3315">
												<a href="/missions/soutiller-et-se-renforcer/"
													class="elementor-sub-item" tabindex="-1">S’outiller et se
													renforcer</a>
											</li>
											<li
												class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3316">
												<a href="/missions/place-aux-jeunes/" class="elementor-sub-item"
													tabindex="-1">Place aux Jeunes</a>
											</li>
										</ul>
									</li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-995">
										<a href="/projets/" class="elementor-item" tabindex="-1">Projets</a>
									</li>
									<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">
									<a href="#" class="elementor-item" tabindex="-1">Rapp. Annuels</a>
									<ul class="sub-menu elementor-nav-menu--dropdown">
										<?php if(!empty($rapports_annuels)): foreach ($rapports_annuels as $year => $pdf): ?>
										<li class="menu-item menu-item-type-custom menu-item-object-custom">
											<a href="<?php echo htmlspecialchars($pdf); ?>" download class="elementor-sub-item" tabindex="-1">Année <?php echo htmlspecialchars($year); ?></a>
										</li>
										<?php endforeach; else: ?>
										<li class="menu-item"><a href="#" class="elementor-sub-item" tabindex="-1">Aucun rapport</a></li>
										<?php endif; ?>
									</ul>
								</li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-997">
										<a href="/actus/" class="elementor-item" tabindex="-1">Actus</a>
									</li>
									<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-998"><a
											href="/evenements/" class="elementor-item" tabindex="-1">Agenda</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		<style>
		/* --- Root-Level Mobile Popup Menu --- */
		.mobile-popup-overlay {
			display: none;
		}
		@media (max-width: 767px) {
			.elementor-nav-menu--dropdown {
				display: none !important;
			}
			
			/* Backdrop Overlay */
			.mobile-popup-overlay {
				position: fixed !important;
				top: 0 !important;
				left: 0 !important;
				width: 100vw !important;
				height: 100vh !important;
				background-color: rgba(0, 0, 0, 0.6) !important; /* Dark translucent backdrop */
				z-index: 999999999 !important;
				display: none;
				justify-content: center !important;
				align-items: center !important;
				box-sizing: border-box !important;
				padding: 20px !important;
			}

			.mobile-popup-overlay.active {
				display: flex !important;
				animation: mobile-backdrop-fade-in 0.25s ease-out forwards;
			}

			@keyframes mobile-backdrop-fade-in {
				from { opacity: 0; }
				to { opacity: 1; }
			}

			/* Floating Menu Card */
			.mobile-popup-card {
				background-color: #085191 !important; /* Sterna blue background */
				width: 100% !important;
				max-width: 330px !important;
				max-height: 80vh !important;
				border-radius: 16px !important;
				box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4) !important;
				padding: 50px 20px 30px 20px !important;
				box-sizing: border-box !important;
				overflow-y: auto !important;
				position: relative !important;
				display: flex !important;
				flex-direction: column !important;
				align-items: center !important;
				transform: scale(0.9) translateY(20px);
				opacity: 0;
				transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease;
			}

			.mobile-popup-overlay.active .mobile-popup-card {
				transform: scale(1) translateY(0);
				opacity: 1;
			}

			/* Close button (Croix) inside card */
			.mobile-popup-close-btn {
				position: absolute !important;
				top: 10px !important;
				right: 15px !important;
				background: transparent !important;
				border: none !important;
				color: #fcb900 !important; /* Yellow close icon */
				font-size: 40px !important;
				font-weight: 300 !important;
				font-family: Arial, sans-serif !important;
				cursor: pointer !important;
				line-height: 1 !important;
				z-index: 10 !important;
				outline: none !important;
				padding: 0 !important;
				margin: 0 !important;
			}

			/* Navigation styling inside popup */
			.mobile-popup-nav {
				width: 100% !important;
				text-align: center !important;
			}

			.mobile-popup-menu-list {
				list-style: none !important;
				padding: 0 !important;
				margin: 0 !important;
				display: flex !important;
				flex-direction: column !important;
				gap: 12px !important;
			}

			.mobile-popup-menu-list > li {
				width: 100% !important;
			}

			.mobile-popup-menu-list a.elementor-item {
				display: inline-block !important;
				font-size: 19px !important;
				font-weight: 800 !important;
				color: #ffffff !important;
				text-decoration: none !important;
				text-transform: uppercase !important;
				padding: 6px 15px !important;
				border-radius: 30px !important;
				transition: all 0.2s ease !important;
			}

			.mobile-popup-menu-list a.elementor-item:hover,
			.mobile-popup-menu-list a.elementor-item:focus {
				background-color: #fcb900 !important;
				color: #085191 !important;
			}

			/* Submenus styling inside popup */
			.mobile-popup-menu-list ul.sub-menu {
				list-style: none !important;
				background-color: rgba(252, 185, 0, 0.15) !important;
				border-radius: 10px !important;
				padding: 8px 0 !important;
				margin: 8px auto 4px auto !important;
				width: 90% !important;
				display: none;
				flex-direction: column !important;
				gap: 6px !important;
			}

			.mobile-popup-menu-list li.menu-item-has-children.open > ul.sub-menu {
				display: flex !important;
			}

			/* Nested submenus for Bull. Trimestriels (Année -> Months) */
			.mobile-popup-menu-list ul.sub-menu ul.sub-menu {
				background-color: rgba(255, 255, 255, 0.1) !important;
				margin-top: 4px !important;
				width: 95% !important;
			}

			.mobile-popup-menu-list ul.sub-menu a.elementor-sub-item {
				font-size: 15px !important;
				color: #ffffff !important;
				font-weight: 700 !important;
				text-decoration: none !important;
				padding: 5px 12px !important;
				border-radius: 6px !important;
				display: inline-block !important;
			}

			.mobile-popup-menu-list ul.sub-menu a.elementor-sub-item:hover {
				background-color: #fcb900 !important;
				color: #085191 !important;
			}

			/* Caret arrow indicator for submenus */
			.mobile-popup-menu-list li.menu-item-has-children > a.elementor-item::after {
				content: ' ▼' !important;
				font-size: 10px !important;
				vertical-align: middle !important;
			}
			
			.mobile-popup-menu-list li.menu-item-has-children.open > a.elementor-item::after {
				content: ' ▲' !important;
			}
		}
		</style>
		</header>