<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  @include('partials.admin.head')
  @livewireStyles
</head>

<body>
  <div id="main-wrapper">
    @include('components.admin.sidebar')

    <div class="page-wrapper">
      @include('components.admin.header')

      @yield('admin-content')
      @include('components.admin.button')
    </div>

    @include('components.admin.modal')
  </div>
  <div class="dark-transparent sidebartoggler"></div>
  @include('partials.admin.footer')
  @livewireScripts
</body>

</html>