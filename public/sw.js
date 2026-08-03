// ==================================================
// PWA Service Worker – Cloud Skin Beauty
// ==================================================

const CACHE_NAME = 'csb-v1';
const STATIC_ASSETS = [
    '/',
    '/manifest.json',
    '/icons/icon-192x192.png',
    '/icons/icon-512x512.png',
    // Add your main CSS/JS files here
    '/css/app.css',
    '/js/app.js',
];

// ====== INSTALL ======
self.addEventListener('install', (event) => {
    console.log('[SW] Installing...');
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log('[SW] Caching static assets');
                return cache.addAll(STATIC_ASSETS);
            })
            .then(() => self.skipWaiting())
    );
});

// ====== ACTIVATE ======
self.addEventListener('activate', (event) => {
    console.log('[SW] Activating...');
    event.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(
                keys.filter((key) => key !== CACHE_NAME)
                    .map((key) => caches.delete(key))
            );
        }).then(() => self.clients.claim())
    );
});

// ====== FETCH ======
self.addEventListener('fetch', (event) => {
    const req = event.request;
    
    // Skip non-GET requests
    if (req.method !== 'GET') return;
    
    // Skip browser extensions
    if (req.url.includes('chrome-extension')) return;
    
    event.respondWith(
        caches.match(req)
            .then((cached) => {
                if (cached) {
                    // Return cached and update in background
                    event.waitUntil(
                        fetch(req).then((fresh) => {
                            if (fresh && fresh.status === 200) {
                                const clone = fresh.clone();
                                caches.open(CACHE_NAME).then((cache) => {
                                    cache.put(req, clone);
                                });
                            }
                        }).catch(() => {})
                    );
                    return cached;
                }
                
                // If not cached, fetch from network
                return fetch(req).then((response) => {
                    if (response && response.status === 200) {
                        const clone = response.clone();
                        caches.open(CACHE_NAME).then((cache) => {
                            cache.put(req, clone);
                        });
                    }
                    return response;
                }).catch(() => {
                    // Return offline page if available
                    return caches.match('/offline');
                });
            })
    );
});