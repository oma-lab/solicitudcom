<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link type="text/css" href="{{ asset('css/app.css')}}" rel="stylesheet">
    
    <!-- Bootstrap JS -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Script -->
    <script src="{{ asset('qjs/jquery-3.4.1.min.js') }}"></script>

    @yield('estilos')    
    <title>INICIO</title>
  </head>

  @include('layouts.header')

  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #ffffff;">
      <a class="navbar-brand" href="{{route('solicitante.home')}}">
        <img src="{{ asset('imagenes/iniciooo.png') }}" style="width:40px;"><b>Inicio</b>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <a class="navbar-brand" href="{{ route('crear.solicitud') }}" style="color: #000000;">
          <img src="{{ asset('imagenes/solicit1.png') }}" style="width:40px;"  ><b>Realizar Solicitud</b>
        </a>
        <a class="navbar-brand" href="{{ route('dictamenes') }}" style="color: #000000;">
          <img src="{{ asset('imagenes/dictamen.png') }}" style="width:40px;"  ><b>Dictamen</b>
        </a>
        <a class="navbar-brand" href="{{route('usuario.calendario')}}">
          <img src="{{ asset('imagenes/calendario.png') }}" style="width:40px;"><b>Calendario</b>
        </a>
        <a class="navbar-brand" href="{{route('solicitante.editar')}}">
          <img src="{{ asset('imagenes/configuser.png') }}" style="width:40px;"><b>Usuario</b>
        </a>

        <ul class="nav lista not">
          <li>
            <button class="botont dropdown-toggle" type="button">
              <img src="{{ asset('imagenes/nott.png') }}" style="width:40px;"><span class="badge badge-warning"><b id="numnoti">0</b></span><b>Notificaciones</b>
            </button>
            <ul id="notifica">
            </ul>
          </li>
        </ul>
        
        <ul class="navbar-nav mr-auto"></ul>
        {{ Auth::user()->nombre }}
        <a class="navbar-brand" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('cierrasesionform').submit();">
          <img src="{{ asset('imagenes/logout.png') }}" style="width:40px;"><b>Cerrar Sesión</b>
        </a>
        <form id="cierrasesionform" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
        </form>
      </div>      
    </nav>
    
    <main class="py-0">
    @yield('contenido')
    </main>

  </body>

@yield('script')
<script src="{{ asset('js/filtro.js') }}"></script>
</html>