// firebase-messaging-sw.js
importScripts('https://www.gstatic.com/firebasejs/10.12.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.12.0/firebase-messaging-compat.js');

// Config Firebase (on mettra tes vraies clés plus tard)
firebase.initializeApp({
  apiKey: "AIzaSyAKQ0-2OjcsJTiReIlGuj0cRobabOOF_p4",
  authDomain: "cahierdor-notifs.firebaseapp.com",
  projectId: "cahierdor-notifs",
  storageBucket: "cahierdor-notifs.firebasestorage.app",
  messagingSenderId: "465608324866",
  appId: "1:465608324866:web:fbd51de15d6512588c741b"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
  console.log('[firebase-messaging-sw.js] Message reçu : ', payload);
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: 'https://i.postimg.cc/mD1YfCSq/logos-sterna.png' // Une petite icône à afficher
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});
