
@php
    $settings = \App\Helpers\WebsiteHelper::getSettings();
@endphp
<meta charset="UTF-8">
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

@if($settings->meta_title)
    <title>{{ $settings->meta_title }}</title>
@endif
@if($settings->meta_keywords)
    <meta name="keywords" content="{{ $settings->meta_keywords }}">
@endif
@if($settings->meta_description)
    <meta name="description" content="{{ $settings->meta_description }}">
@endif
<meta name="author" content="ashishmaraviya">

<!-- site Favicon -->
<link rel="icon" href="{{ $settings->favicon }}" sizes="32x32" />
<link rel="apple-touch-icon" href="{{ $settings->favicon }}" />
<meta name="msapplication-TileImage" content="{{ $settings->favicon }}" />

<!-- css Icon Font -->
<link rel="stylesheet" href="{{ asset('web/css/vendor/ecicons.min.css') }}" />

<!-- css All Plugins Files -->
<link rel="stylesheet" href="{{asset('web/css/plugins/animate.css')}}" />
<link rel="stylesheet" href="{{ asset('web/css/plugins/swiper-bundle.min.css') }}" />
<link rel="stylesheet" href="{{ asset('web/css/plugins/jquery-ui.min.css') }}" />
<link rel="stylesheet" href="{{ asset('web/css/plugins/countdownTimer.css') }}" />
<link rel="stylesheet" href="{{ asset('web/css/plugins/slick.min.css') }}" />
<link rel="stylesheet" href="{{ asset('web/css/plugins/bootstrap.css') }}" />

<!-- Main Style -->

<link rel="stylesheet" href="{{ asset('web/css/demo1.css') }}" />
<link rel="stylesheet" href="{{ asset('web/css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('web/css/responsive.css') }}" />
{{-- new --}}
<link rel="stylesheet" href="{{ asset('web/css/tokens.css') }}">
<link rel="stylesheet" href="{{ asset('web/css/theme.css') }}">
{{-- pwa links --}}
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#1e40af">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<!-- Background css -->
{{-- <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('web/css/backgrounds/bg-4.css') }}"> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/locomotive-scroll@4.2.0/dist/locomotive-scroll.min.js"></script> --}}
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/locomotive-scroll@4.2.0/dist/locomotive-scroll.min.css" /> --}}

{{-- bootstrap --}}
<!-- Swiper -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- EasyZoom -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/easyzoom/2.5.0/easyzoom.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/easyzoom/2.5.0/easyzoom.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
    <script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js')
                .then(function(registration) {
                    console.log('ServiceWorker registration successful');
                })
                .catch(function(err) {
                    console.log('ServiceWorker registration failed: ', err);
                });
        });
    }
</script>
@livewireStyles()