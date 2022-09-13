<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/main.css?0.2">
  <script src="js/app.js"></script>
</head>

<body>
  @include('web._header')
  <div class="main">
    @yield('main')
  </div>
  @include('web._footer')
</body>
