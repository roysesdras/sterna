const cacheName = 'livredor-v1';
const assets = [
  '/',
  '/index.php',
  '/manifest.json',
  '/icons/icon-192.png',
  '/icons/icon-512.png',
  '/offline.html'
];

// INSTALLATION : mise en cache initiale
self.addEventListener('install', (e) => {
  self.skipWaiting();
  e.waitUntil(
    caches.open(cacheName).then((cache) => {
      return cache.addAll(assets);
    })
  );
});

// ACTIVATION : nettoyage des anciens caches
self.addEventListener('activate', (e) => {
  e.waitUntil(
    caches.keys().then((keys) =>
      Promise.all(
        keys.filter((key) => key !== cacheName).map((key) => caches.delete(key))
      )
    )
  );
  return self.clients.claim();
});

// FETCH : version sécurisée (GET uniquement, pas d'extension chrome)
self.addEventListener('fetch', (e) => {
  const req = e.request;

  // Ne pas gérer : requêtes POST ou internes au navigateur
  if (req.method !== 'GET' || req.url.startsWith('chrome-extension')) {
    return;
  }

  e.respondWith(
    fetch(req)
      .then((response) => {
        // Cloner la réponse pour mise en cache et retour
        const resClone = response.clone();
        caches.open(cacheName).then((cache) => {
          cache.put(req, resClone);
        });
        return response;
      })
      .catch(() => {
        return caches.match(req).then((cachedRes) => {
          return cachedRes || caches.match('/offline.html');
        });
      })
  );
});
