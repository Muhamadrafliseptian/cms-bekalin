<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('assets/img/bekalin/logo.png') }}" />

    @yield('css')
    @include('layout.partials.head-css')
    <title>@yield('title', 'Dashboard Bekelin')</title>
</head>

<body>
    <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      @include('layout.topbar')
      @include('layout.sidebar')

      <div class="main-content">
        <section class="section">
            @yield('content')
        </section>
      </div>
      @include('layout.footer')
    </div>
  </div>
    @include('layout.partials.footer-js')
    @yield('js')
    @stack('js')
</body>

</html>
