<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <!-- Standard Meta -->
  <meta charset="utf-8">
  <meta name="description" content="{{ config('app.name') }} is a group of finance experts, designers, and software engineers on a mission to change the way the world sees Forex, Comodities, Indices, Metals, Cryptocurrency, Mining and other trade investments.">
  <meta name="keywords" content="{{ config('app.name') }}, trading, forex">
  <meta name="author" content="{{ config('app.name') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#313131" />
  <!-- Site Properties -->
  <title>{{ $title }} | {{ config('app.name') }}</title>

  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <!-- Critical preload -->
  <link rel="preload" href="{{ mix('js/manifest.js') }}" as="script">
  <link rel="preload" href="{{ mix('js/vendor.js') }}" as="script">
  <link rel="preload" href="{{ mix('js/app-init.js') }}" as="script">
  <link rel="preload" href="{{ mix('css/app-name-slug.css') }}" as="style">

  <!-- Icon preload -->
  <link rel="preload" href="fonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="fonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>
  <!-- Font preload -->
  <link rel="preload" href="fonts/rubik-v9-latin-500.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="fonts/rubik-v9-latin-300.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="fonts/rubik-v9-latin-regular.woff2" as="font" type="font/woff2" crossorigin>
  <!-- Favicon and apple icon -->
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon-precomposed" href="apple-touch-icon.png">
  <!-- Stylesheet -->

  @routes(['public', 'auth'])

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="antialiased">

  @if(config('app.has_google_translate'))
    <x-publicpages::google-translate />
    @yield('customCSS')
  @endif

  @if(config('app.has_initial_preloader'))
    <x-publicpages::preloader />
  @endif

  @inertia

  <div class="go-top">
    <i class='bx bx-up-arrow-alt'></i>
  </div>

  <script src="{{ mix('js/manifest.js') }}"></script>
  <script src="{{ mix('js/vendor.js') }}"></script>
  <script src="{{ mix('js/app-name-slug.js') }}"></script>
  <link rel="stylesheet" href="{{ mix('css/app-name-slug.css') }}">

  {!! config('services.tidio.code') !!}
</body>

</html>
