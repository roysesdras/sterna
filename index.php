<?php
// Envoie un code 404 pour les moteurs de recherche
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Compte Suspendu | Hostinger</title>
    <!-- Chargement de la police Inter utilisée par Hostinger -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --hostinger-purple: #673DE6;
            --hostinger-purple-hover: #522bc7;
            --hostinger-dark: #2F1C6A;
            --hostinger-text: #50466E;
            --hostinger-bg: #F8F9FA;
            --hostinger-white: #FFFFFF;
            --hostinger-danger: #E63D52;
            --hostinger-border: #E5E7EB;
        }

        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--hostinger-bg);
            color: var(--hostinger-text);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background-color: var(--hostinger-white);
            border-radius: 16px;
            box-shadow: 0 12px 32px rgba(47, 28, 106, 0.05), 0 2px 8px rgba(47, 28, 106, 0.02);
            width: 100%;
            max-width: 520px;
            padding: 56px 48px;
            text-align: center;
            box-sizing: border-box;
            margin: 20px;
            border: 1px solid var(--hostinger-border);
        }

        .logo {
            margin-bottom: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .logo img {
            width: 180px;
            height: auto;
        }

        .icon-wrapper {
            width: 72px;
            height: 72px;
            background-color: #FEE2E2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px auto;
        }

        .icon-wrapper svg {
            width: 36px;
            height: 36px;
            color: var(--hostinger-danger);
        }

        h1 {
            color: var(--hostinger-dark);
            font-size: 28px;
            font-weight: 800;
            margin: 0 0 16px 0;
            letter-spacing: -0.03em;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin: 0 0 32px 0;
            color: var(--hostinger-text);
        }

        .btn {
            display: inline-block;
            background-color: var(--hostinger-purple);
            color: var(--hostinger-white);
            font-weight: 600;
            font-size: 16px;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(103, 61, 230, 0.2);
            width: 100%;
            box-sizing: border-box;
        }

        .btn:hover {
            background-color: var(--hostinger-purple-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(103, 61, 230, 0.3);
        }

        .footer {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--hostinger-border);
            font-size: 13px;
            color: #8C85A3;
        }

        .footer span {
            font-weight: 600;
            color: var(--hostinger-dark);
        }

        @media (max-width: 600px) {
            .container {
                padding: 40px 24px;
            }
            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Logo Hostinger officiel -->
    <div class="logo">
        <img src="https://assets.hostinger.com/images/logo-hostinger.svg" alt="Hostinger Logo" onerror="this.onerror=null; this.src='https://raw.githubusercontent.com/hostinger/hostinger-design-system/master/assets/logo.svg';">
        <!-- Au cas où l'image SVG ne charge pas, on laisse un fallback textuel mais l'image devrait charger -->
    </div>

    <!-- Icône d'avertissement -->
    <div class="icon-wrapper">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
    </div>

    <!-- Message -->
    <h1>404 - Site Inaccessible</h1>
    <p>Ce compte a été suspendu ou l'abonnement pour ce domaine a expiré. Si vous êtes l'administrateur de ce site, veuillez vous connecter à votre espace client pour réactiver le service.</p>

    <!-- Bouton d'action -->
    <a href="https://hpanel.hostinger.com/" class="btn">Se connecter au hPanel</a>

    <!-- Footer de la carte -->
    <div class="footer">
        Code d'erreur : <span>404_ACCOUNT_SUSPENDED</span>
    </div>
</div>

<script>
    // Si l'image logo officielle ne charge pas (ce qui est possible si l'url change), 
    // on injecte le logo en SVG directement
    document.querySelector('img').addEventListener('error', function() {
        this.outerHTML = `<svg viewBox="0 0 156 32" fill="none" style="width: 180px; height: auto;" xmlns="http://www.w3.org/2000/svg"><path d="M15.3534 0C23.8344 0 30.7067 6.87233 30.7067 15.3534C30.7067 23.8344 23.8344 30.7067 15.3534 30.7067C6.87233 30.7067 0 23.8344 0 15.3534C0 6.87233 6.87233 0 15.3534 0Z" fill="#673DE6"/><path fill-rule="evenodd" clip-rule="evenodd" d="M10.155 9.07693C9.56066 9.07693 9.07886 9.55873 9.07886 10.1531V20.5534C9.07886 21.1478 9.56066 21.6296 10.155 21.6296C10.7493 21.6296 11.2311 21.1478 11.2311 20.5534V16.4294H19.4756V20.5534C19.4756 21.1478 19.9574 21.6296 20.5517 21.6296C21.1461 21.6296 21.6279 21.1478 21.6279 20.5534V10.1531C21.6279 9.55873 21.1461 9.07693 20.5517 9.07693C19.9574 9.07693 19.4756 9.55873 19.4756 10.1531V14.277H11.2311V10.1531C11.2311 9.55873 10.7493 9.07693 10.155 9.07693Z" fill="white"/><path d="M48.2435 9.0769H50.5186V14.1863H56.5925V9.0769H58.8676V21.6296H56.5925V16.0357H50.5186V21.6296H48.2435V9.0769Z" fill="#2F1C6A"/><path d="M72.0945 15.3533C72.0945 19.1234 69.2131 21.8492 65.3426 21.8492C61.4722 21.8492 58.5908 19.1234 58.5908 15.3533C58.5908 11.5831 61.4722 8.85742 65.3426 8.85742C69.2131 8.85742 72.0945 11.5831 72.0945 15.3533ZM69.8194 15.3533C69.8194 12.6366 67.8967 10.7068 65.3426 10.7068C62.7886 10.7068 60.8659 12.6366 60.8659 15.3533C60.8659 18.0699 62.7886 19.9997 65.3426 19.9997C67.8967 19.9997 69.8194 18.0699 69.8194 15.3533Z" fill="#2F1C6A"/><path d="M73.5413 19.868L74.8584 18.1565C76.1315 19.4296 77.8437 20.0881 79.5559 20.0881C81.1802 20.0881 82.2338 19.4296 82.2338 18.3759C82.2338 17.5418 81.6192 16.9711 80.0388 16.5321L78.2828 16.0492C75.8243 15.3907 74.3755 14.1176 74.3755 12.0103C74.3755 9.59567 76.5266 8.85742 79.4681 8.85742C81.4437 8.85742 83.2875 9.42813 84.8241 10.5695L83.5948 12.3695C82.4095 11.3598 80.9607 10.7452 79.4681 10.7452C77.8003 10.7452 76.7466 11.3159 76.7466 12.1859C76.7466 12.9322 77.3173 13.459 78.8978 13.898L80.6538 14.3809C83.2439 15.1272 84.6049 16.3125 84.6049 18.42C84.6049 20.9663 82.4095 21.8443 79.4681 21.8443C77.1413 21.8492 75.034 21.0589 73.5413 19.868Z" fill="#2F1C6A"/><path d="M86.8166 10.9257H84.1386V9.0769H91.8213V10.9257H89.1433V21.6296H86.8166V10.9257Z" fill="#2F1C6A"/><path d="M92.7161 9.0769H95.0428V21.6296H92.7161V9.0769Z" fill="#2F1C6A"/><path d="M96.8624 9.0769H98.838L104.941 17.155V9.0769H107.267V21.6296H105.424L99.1892 13.3312V21.6296H96.8624V9.0769Z" fill="#2F1C6A"/><path d="M121.288 15.3533C121.288 19.0356 118.653 21.8443 114.702 21.8443C110.832 21.8443 108.106 19.0356 108.106 15.3533C108.106 11.6709 110.832 8.85742 114.702 8.85742C116.897 8.85742 118.829 9.86711 120.014 11.4475L118.17 12.6328C117.336 11.4914 116.107 10.7452 114.702 10.7452C112.155 10.7452 110.385 12.675 110.385 15.3533C110.385 18.0315 112.155 19.9565 114.702 19.9565C116.195 19.9565 117.468 19.1663 118.258 17.8931H114.702V16.1371H121.112V21.4931H119.356L118.917 19.6493C117.907 20.8785 116.414 21.8443 114.702 21.8443C110.832 21.8443 108.106 19.0356 108.106 15.3533C108.106 11.6709 110.832 8.85742 114.702 8.85742C116.897 8.85742 118.829 9.86711 120.014 11.4475L121.288 10.2622C121.288 11.8427 121.288 13.5987 121.288 15.3533Z" fill="#2F1C6A"/><path d="M123.633 9.0769H130.657V10.9257H125.96V14.1863H130.218V16.0357H125.96V19.7808H130.833V21.6296H123.633V9.0769Z" fill="#2F1C6A"/><path d="M136.37 16.5321H134.438V21.6296H132.111V9.0769H136.37C139.136 9.0769 140.76 10.4818 140.76 12.8086C140.76 14.6963 139.619 15.9694 138.038 16.4084L141.287 21.6296H138.653L135.667 16.5321H136.37ZM136.194 14.7402C137.643 14.7402 138.477 13.9939 138.477 12.8086C138.477 11.6233 137.643 10.9205 136.194 10.9205H134.438V14.7402H136.194Z" fill="#2F1C6A"/></svg>`;
    });
</script>

</body>
</html>
