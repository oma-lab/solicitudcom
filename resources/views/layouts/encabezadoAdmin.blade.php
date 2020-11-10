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
    <nav class="nav-menu">
      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fa fa-bars"></i>
      </label>
      <ul class="menu">
        <li><a href="{{route('admin.calendario')}}"><img src="{{ asset('imagenes/calendario.png') }}" style="width:40px;"><b>Agenda</b></a></li>
        <li>
          <button class="botont dropdown-toggle" type="button">
            <img src="{{ asset('imagenes/reunion.png') }}" style="width:40px;"><b>Reunión</b>
          </button>
          <ul class="submenu">
            <li><a href="{{route('citatorio.index')}}"><img src="{{ asset('imagenes/citatorio.png') }}" style="width:30px;">Citatorio</a></li>
            <li><a href="{{route('listaasistencia.index')}}"><img src="{{ asset('imagenes/lista.png') }}" style="width:30px;">Pase de lista</a></li>
            <li><a href="{{route('acta.index')}}"><img src="{{ asset('imagenes/acta.png') }}" style="width:28px;">Acta</a></li>
          </ul>
        </li>
        <li><a href="{{route('solicitudes')}}"><img src="{{ asset('imagenes/solicit1.png') }}" style="width:40px;"><b>Solicitudes</b></a></li>
        <li><a href="{{route('recomendaciones')}}"><img src="{{ asset('imagenes/recomendacion.png') }}" style="width:40px;"><b>Recomendación</b></a></li>
        <li><a href="{{route('director.dictamenes','pendientes')}}"><img src="{{ asset('imagenes/dictamen.png') }}" style="width:40px;"><b>Dictamen</b></a></li>
        <li>
          <button class="botont dropdown-toggle" type="button">
            <img src="{{ asset('imagenes/masconfig.png') }}" style="width:40px;"><b>Configuración</b>
          </button>
          <ul class="submenu">
            <li><a href="{{route('usuarios','estudiante')}}"><img src="{{ asset('imagenes/usuarios.png') }}" style="width:30px;">Usuarios</a></li>
            <li><a href="{{route('carrera.adscripcion')}}"><img src="{{ asset('imagenes/carrera.png') }}" style="width:30px;">Carreras</a></li>
            <li><a href="{{route('formato')}}"><img src="{{ asset('imagenes/formatos.png') }}" style="width:28px;">Formatos</a></li>
          </ul>
        </li>
        <li>
          <button class="botont dropdown-toggle" type="button">
            <img src="{{ asset('imagenes/nott.png') }}" style="width:40px;"><span class="badge badge-warning"><b id="numnoti">0</b></span><b>Notificaciones</b>
          </button>
          <ul class="submenu notifi" id="notifica">
          </ul>
        </li>
        <li class="cerrar">
          <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('cierrasesionform').submit();">
            <img src="{{ asset('imagenes/logout.png') }}" style="width:40px;"><b>Cerrar Sesión</b>
          </a>
        <li>
        <form id="cierrasesionform" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
        </form>
      </ul>
    </nav>
    <div class="contenedor" style="text-align:right">
    <b>{{(usuario()->role_id == 1) ? usuario()->puesto() : 'Administrador'}} | {{usuario()->nombre_completo()}}</b>
    </div>
    

    <main class="py-0 contenedor">
    @yield('contenido')
    </main>             
  
  </body>
  
@yield('script')
<script src="{{ asset('js/filtro.js') }}"></script>
</html>