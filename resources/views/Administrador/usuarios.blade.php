@extends('layouts.encabezadoAdmin')
@section('contenido')

<nav class="navbar navbar-expand-lg navbar-light bg-light">
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link {{$rol == 'estudiante' ? 'active' : ''}}" href="{{route('usuarios','estudiante')}}">Estudiantes</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{$rol == 'docente' ? 'active' : ''}}" href="{{route('usuarios','docente')}}">Docentes</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{$rol == 'coordinador' ? 'active' : ''}}" href="{{route('usuarios','coordinador')}}">Coordinadores</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{$rol == 'integrante' ? 'active' : ''}}" href="{{route('usuarios','integrante')}}">Integrantes</a>
  </li>
  @if(Auth::user()->role_id == 9)
  <li class="nav-item">
    <a class="nav-link" href="{{route('usuarios.edit',Auth::user()->id)}}">Mi usuario</a>
  </li>  
  @endif
  <li class="nav-item">
    <a href="{{route('crear.usuario')}}"><button class="btn btn-outline-success my-2 my-sm-0" type="button">+Agregar</button></a>
  </li>
</ul>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
 <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav mr-auto"></ul>
<form method="GET" action="{{ route('usuarios',$rol) }}" class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" name="nombre" placeholder="nombre/apellido" aria-label="Search" value="{{request('nombre')}}">
      @if($rol == 'estudiante')
      <select class="form-control mr-sm-2" name="carrera_id" style="width:225px">
        <option value="">TODAS LAS CARRERAS</option>
        @foreach($carreras as $carrera)
        <option value="{{$carrera->id}}" {{request('carrera_id') == $carrera['id'] ? 'selected' : '' }}>{{$carrera->nombre}}</option>
        @endforeach
      </select>
      @else
      <select class="form-control mr-sm-2" name="adscripcion_id" style="width:225px">
        <option value="">TODAS LAS ADSCRIPCIONES</option>
        @foreach($adscripciones as $adscripcion)
        <option value="{{$adscripcion->id}}" {{request('adscripcion_id') == $adscripcion['id'] ? 'selected' : '' }}>{{$adscripcion->nombre_adscripcion}}</option>
        @endforeach
      </select> 
      @endif
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fa fa-search"></i> Buscar</button>
</form>                     
</div>
</nav>


<br>
<div class="container-fluid">
@include('layouts.filtrado.mensaje')
<table class="table table-light table-hover">
  <thead class="thead-light">
    <tr>
      <th>{{$rol == 'estudiante' ? 'Número de Control' : 'RFC'}}</th>
      <th>Nombre</th>
      <th>{{$rol == 'estudiante' ? 'Carrera' : 'Adscripción'}}</th>
      <th>Acción</th>
    </tr>
  </thead>
  <tbody>
  @foreach($usuarios as $usuario)
  <tr>
    <td>{{$usuario->identificador}}</td>
    <td>{{$usuario->nombre_completo()}}</td>
    <td>{{$usuario->carrera_adscripcion()}}</td>
    <td>          
      <form method="POST" action="{{url('/usuarios/'.$usuario->id)}}">
      {{csrf_field()}}
      {{method_field('DELETE')}} 
      <a href="{{url('/usuarios/'.$usuario->id.'/edit')}}">
        <button type="button" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i> VER</button>
      </a>
      <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</button></a>
      @if($rol == 'coordinador' || $rol == 'integrante')
      <button type="button" class="btn btn-outline-danger btn-sm" onclick="verPermisos({{$usuario->id}})">
        <i class="fa fa-key"></i> Permisos
      </button>
      @endif
      </form>
    </td>          
  </tr>
  @endforeach
  </tbody>
</table>
{{$usuarios->links()}}
</div>


<!-- Modal -->
<form method="POST" action="{{route('permisos')}}" enctype="multipart/form-data">
{{ csrf_field()}}
 <div class="modal fade" id="modalpermiso" data-backdrop="static">
  <div class="modal-dialog" role="document">
   <div class="modal-content">
    <div class="modal-header">
      <h5>Permisos</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <input type="hidden" id="iduser" name="iduser" value="">
      <b id="nombre_usuario"></b><br>
      <div class="form-group row">
        <label for="roleid" class="col-sm-1 col-form-label">ROL:</label>
        <div class="col-sm-8">
          <select id="roleid" class="form-control" name="role_id" required>
           @foreach($roles as $r)
           <option value="{{$r->id}}">{{$r->nombre_rol}}</option> 
           @endforeach
          </select>
        </div>
      </div>
      <b>SELLECCIONE LAS CARRERAS DE LAS CUALES RECIBIRÁ SOLICITUDES</b>                
      <div class="col-12">
       <label><input type="checkbox" onclick="seleccionar(this,'.cars')">SELECCIONAR TODO</label><br>
       @foreach($carreras as $carrera)
       <label><input class="cars" type="checkbox" value="{{$carrera->id}}" id="checkcar{{$carrera->id}}" name="multiple[]"> {{$carrera->nombre}}</label><br>                            
       @endforeach
      </div>
      @if($rol == 'integrante')
      <b>SELECCIONE SOLICITUDES A RECIBIR DE DOCENTES</b>                
      <div class="col-12">
       <label><input type="checkbox" onclick="seleccionar(this,'.adsc')">SELECCIONAR TODO</label><br>
       @foreach($adscripciones as $adscripcion)
       @if($adscripcion->tipo == "carrera")
       <label><input class="adsc" type="checkbox" value="{{$adscripcion->id}}" id="checkads{{$adscripcion->id}}" name="multipled[]"> {{$adscripcion->nombre_adscripcion}}</label><br>                            
       @endif
       @endforeach
      </div>
      @endif
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
   </div>
  </div>
 </div>
</form>
<!--Fin Modal-->




@endsection
@section('script')
<script src="{{ asset('js/marcar.js') }}"></script>
@endsection