<?php require_once('config/head.php'); ?>
<!-- <button class="dock-item" onclick="openSidebar()">
    <i class="fi fi-rr-apps text-sternaYellow"></i> <span class="comic-neue-regular" style="font-size: 12px;">Plus</span>
</button> -->

<!-- ia Sterna -->
<div id="aiSidebar" class="d-flex flex-column border-0"
    style="position: fixed; bottom: -100%;  height: 85vh; max-height: 750px; 
           background: #0D1117; z-index: 999999; border-radius: 1.5rem; 
           transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 24px 48px rgba(0,0,0,0.4); overflow: hidden;">

    <div class="px-4 py-2 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <div class="bg-warning rounded-circle" style="width: 8px; height: 8px;"></div>
            <span class="text-white fw-bold" style="letter-spacing: -0.5px;">Sterna AI</span>
        </div>
        <button onclick="closeSidebar()" class="btn btn-link text-secondary p-0 shadow-none">
            <i class="fi fi-rr-cross-small fs-4"></i>
        </button>
    </div>

    <div id="chatHistory" class="flex-grow-1 overflow-auto px-4 py-2 scrollbar-hide">
        <!-- <div class="mb-5 animate-fade-in">
            <div class="text-white-50 small mb-2 fw-bold text-uppercase" style="font-size: 10px;">Assistant</div>
            <div class="fs-5 text-white lh-base" style="max-width: 90%; font-weight: 400;">
                Salut ! Prêt à découvrir l'univers de <span class="text-warning">Sterna Africa</span> ? Je vous écoute.
            </div>
        </div> -->
    </div>

    <div class="p-2">
        <div class="position-relative d-flex align-items-center">
            <input type="text" id="aiInput"
                class="form-control border-0 bg-white bg-opacity-10 text-white shadow-none rounded-pill py-2 ps-4 pe-5"
                placeholder="Demander à Sterna AI..."
                style="backdrop-filter: blur(15px); font-size: 0.95rem; border: 1px solid rgba(255,255,255,0.1) !important;">

            <button onclick="askSternaIA()" id="sendBtn"
                class="btn btn-ai-send position-absolute end-0 me-2 d-flex align-items-center justify-content-center shadow-sm">
                <i class="fi fi-sr-paper-plane-top" style="margin-right: -10px; margin-top: 8px; font-size: 1.5rem; color: #ffc107;"></i>
            </button>
        </div>

        <div class="suggested-questions mt-2" id="suggestedQuestions">
            <a href="#" class="suggestion" onclick="useSuggestion(event, 'Que fait Sterna Africa ?')">Que fait Sterna Africa ?</a>
            <a href="#" class="suggestion" onclick="useSuggestion(event, 'Quelles sont les dernières actions de Sterna Africa ?')">Quelles sont les dernières actions de Sterna Africa ?</a>
            <a href="#" class="suggestion" onclick="useSuggestion(event, 'Comment devenir volontaire ?')">Comment devenir volontaire ?</a>
        </div>

        <div class="text-center">
            <span class="text-white-50" style="font-size: 6px; letter-spacing: 2px; opacity: 0.4;">POWERED BY STERNA AFRICA</span>
        </div>
    </div>
</div>

<div id="aiOverlay" onclick="closeSidebar()"
    style="position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 999998; display: none; backdrop-filter: blur(8px); transition: opacity 0.4s;">
</div>

<style>
    #aiInput::placeholder {
        color: rgba(255, 255, 255, 0.66);
    }

    /* Adaptation Mobile/Desktop */
    @media (min-width: 768px) {
        #aiSidebar {
            left: auto !important;
            right: 2rem !important;
            width: 450px !important;
        }
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    /* Bulles et Textes */
    .user-msg {
        background: rgba(255, 255, 255, 0.1) !important;
        color: #fff !important;
        padding: 12px 18px;
        border-radius: 1.2rem !important;
        font-size: 0.95rem;
    }

    .ai-msg {
        color: #e2e8f0 !important;
        font-size: 1rem;
        line-height: 1.7;
    }

    .ai-msg ul {
        padding-left: 1.2rem;
        margin-top: 10px;
    }

    .ai-msg li {
        margin-bottom: 8px;
    }

    /* Animations */
    .animate-fade-in {
        animation: chatAppear 0.5s ease-out forwards;
    }

    @keyframes chatAppear {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .pulse-dot {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(255, 193, 7, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
        }
    }


    .suggested-questions .suggestion {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        display: block;
        padding: 2px 0;
    }

    .suggested-questions .suggestion:hover {
        color: #fff;
    }
</style>

<script>
    const GATEWAY_URL = 'https://rebonly.com/ai_gateway.php';

    function openSidebar() {
        const modal = document.getElementById('aiSidebar');
        const overlay = document.getElementById('aiOverlay');
        if (modal) {
            modal.style.bottom = "30px";
            modal.style.opacity = "1";
        }
        if (overlay) {
            overlay.style.display = "block";
            setTimeout(() => overlay.style.opacity = "1", 10);
        }
    }

    function closeSidebar() {
        const modal = document.getElementById('aiSidebar');
        const overlay = document.getElementById('aiOverlay');
        if (modal) {
            modal.style.bottom = "-100%";
            modal.style.opacity = "0";
        }
        if (overlay) {
            overlay.style.opacity = "0";
            setTimeout(() => overlay.style.display = "none", 500);
        }
    }

    window.askSternaIA = async function() {
        const input = document.getElementById('aiInput');
        const history = document.getElementById('chatHistory');
        const message = input.value.trim();

        if (!message) return;

        // 1. Message Utilisateur
        history.insertAdjacentHTML('beforeend', `
        <div class="mb-4 animate-fade-in text-end">
            <div class="user-msg d-inline-block text-start">${message}</div>
        </div>
    `);

        input.value = '';
        history.scrollTop = history.scrollHeight;

        // 2. Loader
        const loadingId = 'ai-' + Date.now();
        history.insertAdjacentHTML('beforeend', `
        <div id="${loadingId}" class="mb-5 animate-fade-in">
            <div class="text-white-50 small mb-2 fw-bold text-uppercase" style="font-size: 10px;">Sterna AI</div>
            <div class="spinner-grow text-warning spinner-grow-sm" role="status"></div>
        </div>
    `);
        history.scrollTop = history.scrollHeight;

        try {
            const formData = new FormData();
            formData.append('action', 'chat_sterna');
            formData.append('message', message);

            const response = await fetch(GATEWAY_URL, {
                method: 'POST',
                body: formData
            });
            const data = await response.json();

            document.getElementById(loadingId)?.remove();

            if (data.reponse) {
                history.insertAdjacentHTML('beforeend', `
                <div class="mb-5 animate-fade-in">
                    <div class="text-white-50 small mb-2 fw-bold text-uppercase" style="font-size: 10px;">Sterna AI</div>
                    <div class="ai-msg">${data.reponse}</div>
                </div>
            `);
            }
        } catch (e) {
            document.getElementById(loadingId).innerHTML = '<span class="text-danger small">Erreur de connexion.</span>';
        }
        history.scrollTop = history.scrollHeight;
    };

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('aiInput')?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') askSternaIA();
        });
    });

    function useSuggestion(e, text) {
        e.preventDefault();
        document.getElementById("aiInput").value = text;
        document.getElementById("suggestedQuestions").style.display = "none";
        askSternaIA();
    }
</script>