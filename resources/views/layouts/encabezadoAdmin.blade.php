<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS,JS -->
    <link type="text/css" href="{{ asset('css/app.css')}}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Scripts -->
    <script src="{{ asset('js/funcions.js') }}"></script>
    <script src="{{ asset('qjs/jquery-3.4.1.min.js') }}"></script>

    @yield('estilos')
    <title>INICIO</title>
  </head>

  @include('layouts.header')

  <body>   
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="{{route('admin.calendario')}}">
        <img src="{{ asset('imagenes/calendario.png') }}" style="width:40px;"><b>Agenda</b>
      </a>      
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">


        <ul class="nav lista">
          <li>
            <button class="botont dropdown-toggle" type="button">
              <img src="{{ asset('imagenes/reunion.png') }}" style="width:40px;"><b>Reunión</b>
            </button>
            <ul>
              <li><a href="{{route('citatorio.index')}}"><img src="{{ asset('imagenes/citatorio.png') }}" style="width:30px;">Citatorio</a></li>
              <li><a href="{{route('listaasistencia.index')}}"><img src="{{ asset('imagenes/lista.png') }}" style="width:30px;">Pase de lista</a></li>
              <li><a href="{{route('acta.index')}}"><img src="{{ asset('imagenes/acta.png') }}" style="width:28px;">Acta</a></li>
            </ul>
          </li>
        </ul>

      


        <a class="navbar-brand" href="{{route('solicitudes')}}">
          <img src="{{ asset('imagenes/solicit1.png') }}" style="width:40px;"  ><b>Solicitudes</b>
        </a>                     
        <a class="navbar-brand" href="{{route('recomendaciones')}}">
          <img src="{{ asset('imagenes/recomendacion.png') }}" style="width:40px;"  ><b>Recomendación</b>
        </a>
        <a class="navbar-brand" href="{{route('director.dictamenes','pendientes')}}" style="color: #000000;">
          <img src="{{ asset('imagenes/dictamen.png') }}" style="width:40px;"  ><b>Dictamen</b>
        </a>
        

        <ul class="nav lista">
          <li>
            <button class="botont dropdown-toggle" type="button">
              <img src="{{ asset('imagenes/masconfig.png') }}" style="width:40px;"><b>Configuración</b>
            </button>
            <ul>
              <li><a href="{{route('usuarios','estudiante')}}"><img src="{{ asset('imagenes/usuarios.png') }}" style="width:30px;">Usuarios</a></li>
              <li><a href="{{route('carrera.adscripcion')}}"><img src="{{ asset('imagenes/carrera.png') }}" style="width:30px;">Carreras</a></li>
              <li><a href="{{route('formato')}}"><img src="{{ asset('imagenes/formatos.png') }}" style="width:28px;">Formatos</a></li>
            </ul>
          </li>
        </ul>


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