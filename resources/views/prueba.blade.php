<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>NAVBAR</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link type="text/css" href="{{ asset('css/app.css')}}" rel="stylesheet">
        <script src="{{ asset('qjs/jquery-3.4.1.min.js') }}"></script>
    </head>
    @include('layouts.header')
    <body>
        <nav>
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
                <li><a href="{{route('solicitudes')}}"><img src="{{ asset('imagenes/solicit1.png') }}" style="width:40px;"  ><b>Solicitudes</b></a></li>
                <li><a href="{{route('recomendaciones')}}"><img src="{{ asset('imagenes/recomendacion.png') }}" style="width:40px;"  ><b>Recomendación</b></a></li>
                <li><a href="{{route('director.dictamenes','pendientes')}}"><img src="{{ asset('imagenes/dictamen.png') }}" style="width:40px;"  ><b>Dictamen</b></a></li>
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
                      <li><a href="/home/"><i class="fa fa-envelope-square" style="color:#1B396A;"></i><b>1 Nuevas solicitudes </b><br><p class="puntos">descripcionde la notificacion xdfjh sabf jbfsja hjvsfjhs jhbasj</p></a></li>
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
        

        <div class="container-fluid contenedor">
          <div class="row justify-content-center">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                SOLICITUDES PENDIENTES
                     <a class="btn btn-outline-success" href="{{route('registrar.documento')}}" role="button" title="Generar Solicitud">+Recomendación/Dictamen</a>
                     <div class="form-inline float-right">
                     CARRERA:
                     <form method="GET" action="{{ route('solicitudes') }}" class="form-inline my-2 my-lg-0">  
                      <select class="form-control mr-sm-2 filtro" name="carrera_id" style="width:225px">
                       <option value="">TODAS LAS CARRERAS</option>
                       
                      </select> 
                      FECHA REUNIÓN:
                      <select class="form-control filtro" name="filtrofecha" style="width:150px">
                        
                      </select>
                     </form>
             
                     </div>
                </div>
                  <div class="card-body">                    
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">Solicitud</th>
                            <th scope="col">Ver solicitud</th>
                            <th scope="col">Recibido</th>
                            <th scope="col">Observaciones</th>
                            <th scope="col">Respuesta</th>
                            <th scope="col">Guardar</th>
                          </tr>
                        </thead>  
                        <tbody>
                
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>
            </div>
          </div>  
        </div>






        <div class="container-fluid contenedor">
          <div class="row justify-content-center">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                SOLICITUDES PENDIENTES
                     <a class="btn btn-outline-success" href="{{route('registrar.documento')}}" role="button" title="Generar Solicitud">+Recomendación/Dictamen</a>
                     <div class="form-inline float-right">
                     CARRERA:
                     <form method="GET" action="{{ route('solicitudes') }}" class="form-inline my-2 my-lg-0">  
                      <select class="form-control mr-sm-2 filtro" name="carrera_id" style="width:225px">
                       <option value="">TODAS LAS CARRERAS</option>
                       
                      </select> 
                      FECHA REUNIÓN:
                      <select class="form-control filtro" name="filtrofecha" style="width:150px">
                        
                      </select>
                     </form>
             
                     </div>
                </div>
                  <div class="card-body">                    
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">Solicitud</th>
                            <th scope="col">Ver solicitud</th>
                            <th scope="col">Recibido</th>
                            <th scope="col">Observaciones</th>
                            <th scope="col">Respuesta</th>
                            <th scope="col">Guardar</th>
                          </tr>
                        </thead>  
                        <tbody>
                
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>
            </div>
          </div>  
        </div>
        <div class="container-fluid contenedor">
          <div class="row justify-content-center">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                SOLICITUDES PENDIENTES
                     <a class="btn btn-outline-success" href="{{route('registrar.documento')}}" role="button" title="Generar Solicitud">+Recomendación/Dictamen</a>
                     <div class="form-inline float-right">
                     CARRERA:
                     <form method="GET" action="{{ route('solicitudes') }}" class="form-inline my-2 my-lg-0">  
                      <select class="form-control mr-sm-2 filtro" name="carrera_id" style="width:225px">
                       <option value="">TODAS LAS CARRERAS</option>
                       
                      </select> 
                      FECHA REUNIÓN:
                      <select class="form-control filtro" name="filtrofecha" style="width:150px">
                        
                      </select>
                     </form>
             
                     </div>
                </div>
                  <div class="card-body">                    
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">Solicitud</th>
                            <th scope="col">Ver solicitud</th>
                            <th scope="col">Recibido</th>
                            <th scope="col">Observaciones</th>
                            <th scope="col">Respuesta</th>
                            <th scope="col">Guardar</th>
                          </tr>
                        </thead>  
                        <tbody>
                
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>
            </div>
          </div>  
        </div>

    </body>
</html>

