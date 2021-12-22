<!DOCTYPE html>
<html lang="en" class="dark">
<!-- BEGIN: Head -->

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title>{{ config('app.name')}} | {{ $title }}</title>

  <link rel="preload" href="{{ mix('js/manifest.js') }}" as="script">
  <link rel="preload" href="{{ mix('js/vendor.js') }}" as="script">
  <link rel="preload" href="{{ mix('js/dashboard-init.js') }}" as="script">
  <link rel="preload" href="{{ mix('js/dashboard.js') }}" as="script">
  <link rel="preload" href="{{ mix('css/dashboard.css') }}" as="style">

  <!-- Favicon and apple icon -->
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon-precomposed" href="apple-touch-icon.png">
  <!-- Stylesheet -->

  @routes(['frontdeskuser', 'auth'])

</head>
<!-- END: Head -->

<body class="antialiased app">

  @inertia

  <script src="{{ mix('js/manifest.js') }}"></script>
  <script src="{{ mix('js/vendor.js') }}"></script>
  <script src="{{ mix('js/dashboard.js') }}"></script>
  <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">

</body>

</html>
