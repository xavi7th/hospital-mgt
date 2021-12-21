<!DOCTYPE html>
<html lang="en" class="dark">
<!-- BEGIN: Head -->

<head>
  <meta charset="utf-8">
  <link href="dist/images/logo.svg" rel="shortcut icon">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Trade Binary Options with the best platform, on a wide selection of assets, with high payouts, lightning-fast order execution and get personal customer support around the clock, fast withdrawals and the expertise of industry leaders.">
  <meta name="keywords" content="crypto trading">
  <title>{{ config('app.name')}} | {{ $title }}</title>

  <link rel="preload" href="{{ mix('js/manifest.js') }}" as="script">
  <link rel="preload" href="{{ mix('js/vendor.js') }}" as="script">
  <link rel="preload" href="{{ mix('js/dashboard-init.js') }}" as="script">
  <link rel="preload" href="{{ mix('js/dashboard.js') }}" as="script">
  <link rel="preload" href="{{ mix('css/dashboard.css') }}" as="style">
  <script type="text/javascript" src="https://s3.tradingview.com/tv.js" async></script>

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

  {!! config('services.tidio.code') !!}

</body>

</html>
