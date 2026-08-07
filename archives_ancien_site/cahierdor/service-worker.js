const cacheName = 'livredor-v4';
const assets = [
  './',
  'index.php',
  'manifest.json',
  'favicon/web-app-manifest-192x192.png',
  'favicon/web-app-manifest-512x512.png',
  'offline.html'
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

// === PUSH NOTIFICATION LISTENERS ===
self.addEventListener('push', (event) => {
  if (event.data) {
    try {
      const data = event.data.json();
      const title = data.title || "Livre d'Or";
      const options = {
        body: data.body,
        icon: data.icon || 'favicon/web-app-manifest-192x192.png',
        badge: 'favicon/favicon-96x96.png',
        data: {
          url: data.url || '/'
        }
      };
      event.waitUntil(
        self.registration.showNotification(title, options)
      );
    } catch (e) {
      const text = event.data.text();
      event.waitUntil(
        self.registration.showNotification("Livre d'Or", {
          body: text,
          icon: 'favicon/web-app-manifest-192x192.png',
          badge: 'favicon/favicon-96x96.png'
        })
      );
    }
  }
});

self.addEventListener('notificationclick', (event) => {
  event.notification.close();
  event.waitUntil(
    clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
      const targetUrl = event.notification.data?.url || '/';
      for (const client of clientList) {
        if (client.url.includes(targetUrl) && 'focus' in client) {
          return client.focus();
        }
      }
      if (clients.openWindow) {
        return clients.openWindow(targetUrl);
      }
    })
  );
});
