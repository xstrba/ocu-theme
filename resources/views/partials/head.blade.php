<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Favicons -->
  <link rel="apple-touch-icon" sizes="180x180" href="{{ Vite::asset('resources/images/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ Vite::asset('resources/images/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ Vite::asset('resources/images/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ Vite::asset('resources/images/site.webmanifest') }}">
  <link rel="shortcut icon" href="{{ Vite::asset('resources/images/favicon.ico') }}">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-config" content="{{ Vite::asset('resources/images/browserconfig.xml') }}">
  <meta name="theme-color" content="#ffffff">
  <!-- End Favicons -->

  @php do_action('get_header'); wp_head(); @endphp
  <script src="https://code.iconify.design/1/1.0.3/iconify.min.js" defer></script>

  @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
