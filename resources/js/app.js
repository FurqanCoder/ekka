if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js')
            .then(registration => {
                console.log('Service Worker registered:', registration);
            })
            .catch(err => {
                console.error('Service Worker registration failed:', err);
            });
    });
}

function requestNotificationPermission() {
    if ('Notification' in window && navigator.serviceWorker) {
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                console.log('Notification permission granted.');
            }
        });
    }
}
requestNotificationPermission();


// -------------------------
// Add to Home Screen
// -------------------------
window.deferredPrompt = null;

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    window.deferredPrompt = e;

    const a2hsBtn = document.getElementById('a2hs-btn');
    if (a2hsBtn) {
        a2hsBtn.style.display = 'flex';
    }
});

window.addEventListener('appinstalled', () => {
    console.log('PWA installed successfully');
    const a2hsBtn = document.getElementById('a2hs-btn');
    if (a2hsBtn) a2hsBtn.style.display = 'none';
});

window.installPWA = function() {
    if (window.deferredPrompt) {
        window.deferredPrompt.prompt();

        window.deferredPrompt.userChoice.then(result => {
            console.log(result.outcome);
            window.deferredPrompt = null;
        });
    }
};



