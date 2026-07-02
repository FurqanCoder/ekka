<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.web.header')
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#1e40af">
    <!-- For iOS Safari -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <!-- For Android Chrome -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">
    <link rel="manifest" href="/manifest.json">
    {{-- <script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-app.js"></script> --}}
    {{-- <script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging.js"></script> --}}

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <div id="ec-overlay">
        <div class="ec-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- Header start  -->
    @include('components.web.header')
    <!-- Header End  -->

    <!-- ekka Cart Start -->
    @livewire('web.components.cart-component')

    <!-- ekka Cart End -->

    <!-- Category Sidebar start -->
    @include('components.web.category-sidebar')

    <!-- Main Slider Start -->
    {{-- @include('components.web.slider') --}}
    <!-- Main Slider End -->

    @yield('web-content')

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
    @if (config('app.env') === 'production')
        <script>
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/service-worker.js');
            }
        </script>
    @endif
<!-- Firebase Compat Version (Works in Laravel Blade) -->
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

    // Works in browser because compat exposes "firebase"
    firebase.initializeApp(firebaseConfig);

    const messaging = firebase.messaging();

    // Ask permission
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

        new Notification(payload.notification.title, {
            body: payload.notification.body,
            icon: payload.notification.icon,
        });
    });
</script>



</body>

</html>
