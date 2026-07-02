// ==================================================
// PWA Service Worker – Laravel + Livewire Compatible
// ==================================================

// ====== VERSION (change on every update) ======
const APP_VERSION = "v1.0.4";

// ====== Cache Names ======
const STATIC_CACHE = `static-cache-${APP_VERSION}`;
const DYNAMIC_CACHE = `dynamic-cache-${APP_VERSION}`;
const RUNTIME_CACHE = `runtime-cache-${APP_VERSION}`;

// ====== Static Assets (Pre-Cached) ======
const STATIC_ASSETS = [
    "/",
    "/offline",
    "/css/app.css",
    "/js/app.js",

    // Livewire core JS
    "/livewire/livewire.js",
    "/livewire/livewire.js?id=1", // safe variant

    // Icons
    "/images/logo.png",
    "/images/icons/icon-192x192.png",
    "/images/icons/icon-512x512.png",
];

// ====== INSTALL ======
self.addEventListener("install", (event) => {
    console.log("[SW] Installing...");

    event.waitUntil(
        caches.open(STATIC_CACHE).then((cache) => {
            console.log("[SW] Caching static assets");
            return cache.addAll(STATIC_ASSETS);
        })
    );

    self.skipWaiting();
});

// ====== ACTIVATE ======
self.addEventListener("activate", (event) => {
    console.log("[SW] Activating...");

    event.waitUntil(
        caches.keys().then((keys) =>
            Promise.all(
                keys
                    .filter(
                        (key) =>
                            key !== STATIC_CACHE &&
                            key !== DYNAMIC_CACHE &&
                            key !== RUNTIME_CACHE
                    )
                    .map((key) => caches.delete(key))
            )
        )
    );

    self.clients.claim();
});

// ====== FETCH EVENT ======
self.addEventListener("fetch", (event) => {
    const req = event.request;

    // Ignore browser extensions
    if (req.url.includes("chrome-extension")) return;

    // Ignore admin panel (optional)
    if (req.url.includes("/admin")) return;

    // ====== FIX: Handle Livewire AJAX safely ======
    if (req.url.includes("/livewire/message/") || req.url.includes("/livewire/update")) {
        event.respondWith(livewireOffline(req));
        return;
    }

    // Livewire core JS → cache first
    if (req.url.includes("/livewire/livewire.js")) {
        event.respondWith(cacheFirst(req));
        return;
    }

    // HTML pages → stale-while-revalidate
    if (req.headers.get("accept")?.includes("text/html")) {
        event.respondWith(staleWhileRevalidate(req));
        return;
    }

    // API routes → network-first fallback to cache
    if (req.url.includes("/api/")) {
        event.respondWith(apiCache(req));
        return;
    }

    // Static assets → cache first
    if (["script", "style", "image"].includes(req.destination)) {
        event.respondWith(cacheFirst(req));
        return;
    }

    // Default → network first
    event.respondWith(networkFirst(req));
});

// ==================================================
// CACHE STRATEGIES
// ==================================================

// ====== Cache First (JS, CSS, Images) ======
async function cacheFirst(req) {
    const cached = await caches.match(req);
    if (cached) return cached;

    const fresh = await fetch(req);
    caches.open(DYNAMIC_CACHE).then((cache) => cache.put(req, fresh.clone()));
    return fresh;
}

// ====== Network First (Pages fallback) ======
async function networkFirst(req) {
    try {
        const fresh = await fetch(req);
        const cache = await caches.open(RUNTIME_CACHE);

        if (req.headers.get("accept")?.includes("text/html")) {
            cache.put(req, fresh.clone());
        }

        return fresh;
    } catch (err) {
        const cached = await caches.match(req);
        return cached || caches.match("/offline");
    }
}

// ====== Stale While Revalidate (HTML Pages) ======
async function staleWhileRevalidate(req) {
    const cache = await caches.open(RUNTIME_CACHE);

    const cachedResponse = await caches.match(req);

    const networkFetch = fetch(req)
        .then((fresh) => {
            if (req.headers.get("accept")?.includes("text/html")) {
                cache.put(req, fresh.clone());
            }
            return fresh;
        })
        .catch(() => null);

    return cachedResponse || networkFetch || caches.match("/offline");
}

// ====== API Cache ======
async function apiCache(req) {
    try {
        const response = await fetch(req);
        const cache = await caches.open(DYNAMIC_CACHE);
        cache.put(req, response.clone());
        return response;
    } catch {
        return caches.match(req);
    }
}

// ====== FIX: Livewire Offline Support ======
async function livewireOffline(req) {
    try {
        // Try online first
        return await fetch(req);
    } catch (e) {
        // Serve a safe empty JSON response so Livewire does NOT crash offline
        return new Response(
            JSON.stringify({
                effects: [],
                serverMemo: { html: "" },
            }),
            {
                headers: { "Content-Type": "application/json" },
                status: 200,
            }
        );
    }
}

// ====== Background Sync (Optional) ======
self.addEventListener("sync", (event) => {
    if (event.tag === "sync-cart") {
        event.waitUntil(syncCartWithServer());
    }
});

async function syncCartWithServer() {
    console.log("[SW] Background Sync Running...");
    // POST data to backend here
}
