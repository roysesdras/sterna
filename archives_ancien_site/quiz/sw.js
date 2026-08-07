const CACHE_NAME = "liveq-quiz-v1";
const ASSETS_TO_CACHE = ["index.php", "manifest.json"];

// Installation : Mise en cache des fichiers de base
self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(ASSETS_TO_CACHE);
    }),
  );
});

// Stratégie : Réseau en priorité pour le Quiz (Temps réel obligé)
self.addEventListener("fetch", (event) => {
  const url = new URL(event.request.url);

  // Si la requête concerne un fichier PHP, on va TOUJOURS sur le réseau
  if (url.pathname.endsWith(".php")) {
    event.respondWith(fetch(event.request));
    return;
  }

  // Pour le reste (images, icônes), on regarde le cache, sinon réseau
  event.respondWith(
    caches.match(event.request).then((response) => {
      return response || fetch(event.request);
    }),
  );
});
