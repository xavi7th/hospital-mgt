<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <!-- Standard Meta -->
  <meta charset="utf-8">
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
  <link rel="preload" href="{{ mix('css/app-init.css') }}" as="style">

  <!-- Favicon and apple icon -->
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon-precomposed" href="apple-touch-icon.png">
  <!-- Stylesheet -->

  @routes(['auth'])

</head>

<body class="antialiased">

  @inertia

  <script src="{{ mix('js/manifest.js') }}"></script>
  <script src="{{ mix('js/vendor.js') }}"></script>
  <script src="{{ mix('js/app-init.js') }}"></script>
  <link rel="stylesheet" href="{{ mix('css/app-init.css') }}">

</body>

</html>
