<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS,JS -->
    <link type="text/css" href="{{ asset('css/app.css')}}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Scripts -->
    <script src="{{asset('js/funcions.js')}}"></script>
    <script src="{{ asset('qjs/jquery-3.4.1.min.js') }}"></script>

    @yield('estilos')    
    <title>COMITE ACADEMICO</title>
  </head>

  @include('layouts.header')

  <body>
    <nav class="nav-menu">
      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fa fa-bars"></i>
      </label>
      <ul class="menu">
        <li><a href="{{route('home')}}"><img src="{{ asset('imagenes/solicit1.png') }}" style="width:40px;"><b>Solicitudes</b></a></li>
        <li><a href="{{route('recomendaciones')}}"><img src="{{ asset('imagenes/recomendacion.png') }}" style="width:40px;"><b>Recomendación</b></a></li>
        <li><a href="{{route('sub.dictamenes')}}"><img src="{{ asset('imagenes/dictamen.png') }}" style="width:40px;"><b>Dictamenes</b></a></li>
        <li><a href="{{route('sub.calendario')}}"><img src="{{ asset('imagenes/calendario.png') }}" style="width:40px;"><b>Agenda</b></a></li>
        <li><a href="{{route('sub.editar')}}"><img src="{{ asset('imagenes/configuser.png') }}" style="width:40px;"><b>Usuario</b></a></li>
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
    <b>{{usuario()->puesto()}} | {{usuario()->nombre_completo()}}</b>
    </div>
    <main class="py-0 contenedor">
    @yield('contenido')
    </main>
                   
  </body>
  
@yield('script')
<script src="{{ asset('js/filtro.js') }}"></script>
</html>