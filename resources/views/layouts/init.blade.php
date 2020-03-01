<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap core CSS -->
        <link href="{{ asset('css/styles.css') }} " rel="stylesheet" />
  </head>

  <body class="text-center d-flex justify-content-center align-items-center">

    <div class="container">
        <div class="">
            <h1 class="display-2 text-secondary" style="font-family:Quicksand, sans-serif">{{ config('app.name', 'Laravel') }}</h1>
        </div>
        <div class="row">
            @yield('form')
        </div>
    </div>

  </body>
</html>
