const pdf = "RAPPORT ANNUEL 2024.pdf";

// Sélection des éléments (attention aux IDs dans ton HTML)
const pageNum = document.querySelector("#page_num") || { textContent: "" }; 
const pageCount = document.querySelector("#page_count");
const currentPage = document.querySelector("#current_page");
const previousPage = document.querySelector("#prev_page");
const nextPage = document.querySelector("#next_page");

const initialState = {
  pdfDoc: null,
  currentPage: 1,
  pageCount: 0,
  zoom: 1,
};

// --- FONCTION DE RENDU ADAPTATIVE ---
const renderPage = () => {
  initialState.pdfDoc.getPage(initialState.currentPage).then((page) => {
    const canvas = document.querySelector("#canvas");
    const ctx = canvas.getContext("2d");

    // 1. Calculer la largeur disponible dans le conteneur parent
    const containerWidth = canvas.parentElement.clientWidth;
    
    // 2. Obtenir le viewport original (échelle 1)
    const unscaledViewport = page.getViewport({ scale: 1 });
    
    // 3. Calculer l'échelle nécessaire pour que le PDF remplisse la largeur
    // On ajoute un multiplicateur initialState.zoom pour garder la fonction zoom active
    const scale = (containerWidth / unscaledViewport.width) * initialState.zoom;
    const viewport = page.getViewport({ scale: scale });

    canvas.height = viewport.height;
    canvas.width = viewport.width;

    const renderCtx = {
      canvasContext: ctx,
      viewport: viewport,
    };

    page.render(renderCtx);

    // Mise à jour des numéros
    if(pageNum) pageNum.textContent = initialState.currentPage;
    currentPage.value = initialState.currentPage;
  });
};

// Charger le Document
pdfjsLib.getDocument(pdf).promise.then((data) => {
    initialState.pdfDoc = data;
    pageCount.textContent = initialState.pdfDoc.numPages;
    renderPage();
  }).catch((err) => {
    console.error("Erreur PDF:", err);
  });

// --- GESTION DU REDIMENSIONNEMENT FENÊTRE ---
// Pour que le PDF se réadapte si on tourne le téléphone
window.addEventListener('resize', () => {
  if (initialState.pdfDoc) renderPage();
});

const showPrevPage = (e) => {
  if (e) e.preventDefault();
  if (initialState.pdfDoc === null || initialState.currentPage <= 1) return;
  initialState.currentPage--;
  renderPage();
};

const showNextPage = (e) => {
  if (e) e.preventDefault();
  if (initialState.pdfDoc === null || initialState.currentPage >= initialState.pdfDoc.numPages) return;
  initialState.currentPage++;
  renderPage();
};

previousPage.addEventListener("click", showPrevPage);
nextPage.addEventListener("click", showNextPage);

// Aller à une page spécifique
currentPage.addEventListener("keypress", (event) => {
  if (initialState.pdfDoc === null) return;
  const keycode = event.keyCode ? event.keyCode : event.which;
  if (keycode === 13) {
    let desiredPage = parseInt(currentPage.value);
    if(desiredPage >= 1 && desiredPage <= initialState.pdfDoc.numPages) {
        initialState.currentPage = desiredPage;
        renderPage();
    }
  }
});