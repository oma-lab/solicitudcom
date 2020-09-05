<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS-->
    <link type="text/css" href="{{ asset('css/app.css')}}" rel="stylesheet">

    @yield('estilos')
    <title>@yield('title')</title>
  </head>

  @include('layouts.header')

  <body>
    <main class="py-0">
      @yield('contenido')
    </main> 
  </body>
</html>