if ('serviceWorker' in navigator && 'PushManager' in window) {
    navigator.serviceWorker.register('/service-worker.js')
        .then(function(registration) {
            // Vérifier si déjà abonné
            return registration.pushManager.getSubscription()
                .then(async function(subscription) {
                    if (subscription) {
                        return subscription;
                    }
                    // Remplace 'YOUR_PUBLIC_VAPID_KEY' par ta clé publique VAPID
                    const applicationServerKey = urlB64ToUint8Array('BGQdEqUtOB2wqSZdfJ_A9Y_LoLuFMNwbKS2AO_qx0uAsEEXBIHGps6vG71leBCTp9apmpdj3ArqE2j-35LTKkAU');
                    return registration.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: applicationServerKey
                    });
                });
        })
        .then(function(subscription) {
            // Envoi de l'abonnement à ton serveur via Ajax pour sauvegarde dans la base de données
            fetch('/save-subscription.php', {
                method: 'POST',
                body: JSON.stringify(subscription),
                headers: {
                    'Content-Type': 'application/json'
                }
            });
        })
        .catch(function(err) {
            console.error('Erreur lors de l’enregistrement du Service Worker ou de l’abonnement.', err);
        });
}

// Fonction utilitaire pour convertir ta clé publique
function urlB64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);
    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}
