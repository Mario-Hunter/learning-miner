<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Learning Miner</title>

    <!-- Bootstrap core CSS -->
    <link href="https://v4-alpha.getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/miner.css" rel="stylesheet">

  </head>

  <body>

    @include('layouts.nav')

    <div class="container" style="height:500px;">
      @yield('content')
    </div>
    @include('layouts.jquery')

  </body>
</html>
