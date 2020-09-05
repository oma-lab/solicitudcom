<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link type="text/css" href="{{ asset('css/app.css')}}" rel="stylesheet">

    <!-- CSS-->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
      
    <title>INICIO</title>
  </head>

  @include('layouts.header')

  <main class="py-0">
  @yield('login')
  </main>
  
</html>