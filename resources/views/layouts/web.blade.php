<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.web.header')
    <meta name="theme-color" content="#1e40af">
    <!-- For iOS Safari -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- PWA Meta Tags -->
    <link rel="manifest" href="/manifest.json">
    <meta name="apple-mobile-web-app-title" content="CSB">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    <meta name="mobile-web-app-capable" content="yes">
    
    <!-- Toastify CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <title>@yield('title', 'Cloud Skin Beauty')</title>
</head>

<body>
    <!-- Notification Container -->
    <div id="notification-container" style="position: fixed; top: 20px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 10px; max-width: 400px; width: 100%;"></div>

    <!-- Header start -->
    @livewire('web.components.global.header-component')
    <!-- Header End -->

    <!-- ekka Cart Start -->
    @livewire('web.components.cart-component')
    <!-- ekka Cart End -->

    <!-- Category Sidebar start -->
    @livewire('web.components.global.category-sidebar')

    <!-- Main Slider Start -->
    {{-- @include('components.web.slider') --}}
    <!-- Main Slider End -->

    @yield('web-content')

    @livewire('web.components.pwa-install-popup')
    
    <!-- Footer Start -->
    @include('components.web.footer')
    <!-- Footer Area End -->

    <!-- Modal -->
    @include('components.web.modal')
    <!-- Newsletter Modal end -->

    <!-- Footer navigation panel for responsive display -->
    @include('components.web.mobile-footer')
    <!-- Footer navigation panel for responsive display end -->
    
    @include('components.web.floating')
    @include('partials.web.footer')

    @livewireScripts()
    
    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    
    <script>
        document.addEventListener('livewire:initialized', function () {
            // Listen for notify events from Livewire
            Livewire.on('notify', (data) => {
                console.log('Notification received:', data); // Debug log
                showNotification(data.message, data.type);
            });
        });

        function showNotification(message, type = 'info') {
            console.log('Showing notification:', message, type); // Debug log
            
            const colors = {
                success: '#10b981',
                error: '#ef4444',
                warning: '#f59e0b',
                info: '#3b82f6'
            };

            const icons = {
                success: '✅',
                error: '❌',
                warning: '⚠️',
                info: 'ℹ️'
            };

            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'notification-alert';
            notification.style.cssText = `
                background: ${colors[type] || colors.info};
                color: white;
                padding: 16px 20px;
                border-radius: 12px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.2);
                font-weight: 500;
                font-size: 15px;
                animation: slideInRight 0.5s ease;
                display: flex;
                align-items: center;
                gap: 12px;
                width: 100%;
                box-sizing: border-box;
            `;
            
            notification.innerHTML = `
                <span style="font-size: 20px; flex-shrink: 0;">${icons[type] || 'ℹ️'}</span>
                <span style="flex: 1;">${message}</span>
                <button onclick="this.closest('.notification-alert').remove()" 
                        style="background:none;border:none;color:white;font-size:20px;cursor:pointer;flex-shrink:0;padding:0 4px;">
                    ×
                </button>
            `;
            
            // Add to container
            const container = document.getElementById('notification-container');
            if (container) {
                container.appendChild(notification);
            } else {
                // Fallback: append to body
                document.body.appendChild(notification);
            }
            
            // Auto remove after 4 seconds
            setTimeout(() => {
                if (notification && notification.parentNode) {
                    notification.style.animation = 'slideOutRight 0.5s ease';
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.remove();
                        }
                    }, 500);
                }
            }, 4000);
        }

        // Add animation styles
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
            
            .notification-alert {
                transition: all 0.3s ease;
                margin-bottom: 8px;
            }
        `;
        document.head.appendChild(style);
    </script>

    <!-- Firebase -->
    <script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js"></script>

    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyCOZkMo90ufIQJ5mHHxfRgcHO5L7y3ZRgg",
            authDomain: "ekka-notification.firebaseapp.com",
            projectId: "ekka-notification",
            storageBucket: "ekka-notification.firebasestorage.app",
            messagingSenderId: "383515960154",
            appId: "1:383515960154:web:1b53b188a5209b9b05c963",
            measurementId: "G-FNXY5LV7MV",
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        Notification.requestPermission().then(permission => {
            if (permission === "granted") {
                messaging.getToken({
                    vapidKey: "BBN61rkoHg3nxDczTDNvUrtQrZxD-fvl7lByf22H4gmKl_SFKjDVQMP0J3W24k_0JjY13tAROdsWo6vZrRSNWT4"
                }).then((currentToken) => {
                    console.log("Token:", currentToken);
                    if (currentToken) {
                        fetch('/save-fcm-token', {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ token: currentToken })
                        })
                        .then(res => res.json())
                        .then(data => console.log("Token saved:", data))
                        .catch(err => console.error("Save error:", err));
                    }
                }).catch((err) => {
                    console.error("Error getting token:", err);
                });
            } else {
                console.log("Permission denied");
            }
        });

        // Foreground message
        messaging.onMessage((payload) => {
            console.log("Foreground message:", payload);
            showNotification(payload.notification.body, 'info');
        });
    </script>

    <script>
        // Single Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('✅ ServiceWorker registered successfully');
                    })
                    .catch(function(err) {
                        console.log('❌ ServiceWorker registration failed: ', err);
                    });
            });
        }
        
        // Check if app is in standalone mode
        if (window.matchMedia('(display-mode: standalone)').matches || 
            window.navigator.standalone) {
            localStorage.setItem('pwa_installed', 'true');
        }
        
        // Handle app installed event
        window.addEventListener('appinstalled', function() {
            localStorage.setItem('pwa_installed', 'true');
        });
    </script>

</body>

</html>