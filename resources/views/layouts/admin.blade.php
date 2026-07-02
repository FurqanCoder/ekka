<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  @include('partials.admin.head')
  @livewireStyles
</head>

<body>
  <!-- Toast -->
  <div class="toast toast-onload align-items-center text-bg-primary border-0" role="alert" aria-live="assertive"
    aria-atomic="true">
    <div class="toast-body hstack align-items-start gap-6">
      <i class="ti ti-alert-circle fs-6"></i>
      <div>
        <h5 class="text-white fs-3 mb-1">Welcome to MatDash</h5>
        <h6 class="text-white fs-2 mb-0">
          Easy to costomize the Template!!!
        </h6>
      </div>
      <button type="button" class="btn-close btn-close-white fs-2 m-0 ms-auto shadow-none" data-bs-dismiss="toast"
        aria-label="Close"></button>
    </div>
  </div>
  <!-- Preloader -->
  <div class="preloader">
    <img src="../assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div id="main-wrapper">
    <!-- Sidebar Start -->
    @include('components.admin.sidebar')
    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      @include('components.admin.header')
      <!--  Header End -->
      @include('components.admin.leftside')

      @yield('admin-content')
      @include('components.admin.button')
    </div>

    <!--  Search Bar -->
    @include('components.admin.modal')
  </div>
  <div class="dark-transparent sidebartoggler"></div>
 @include('partials.admin.footer')
 @livewireScripts 
</body>

</html>