// service-worker.js
self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    event.waitUntil(
        clients.openWindow('/') // tu peux ouvrir un lien vers le site ici
    );
});
