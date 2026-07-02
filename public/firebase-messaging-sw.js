importScripts("https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js");
importScripts("https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js");

firebase.initializeApp({
    apiKey: "AIzaSyCOZkMo90ufIQJ5mHHxfRgcHO5L7y3ZRgg",
    authDomain: "ekka-notification.firebaseapp.com",
    projectId: "ekka-notification",
    storageBucket: "ekka-notification.firebasestorage.app",
    messagingSenderId: "383515960154",
    appId: "1:383515960154:web:1b53b188a5209b9b05c963",
    measurementId: "G-FNXY5LV7MV",
});

// This must match compat method:
const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    console.log("Background message:", payload);

    self.registration.showNotification(payload.notification.title, {
        body: payload.notification.body,
        icon: payload.notification.icon,
    });
});
