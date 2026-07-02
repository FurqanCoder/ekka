<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    @include(
        'partials.admin.head'
    )
</head>
<body>
      <!-- Preloader -->
  <div class="preloader">
    <img src="../assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid">
  </div>
    @yield('dev-content')
  <div class="dark-transparent sidebartoggler"></div>

@include(
    'partials.admin.footer'
)    
</body>
</html>