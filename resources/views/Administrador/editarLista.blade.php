@extends('layouts.encabezadoAdmin')
@section('contenido')

<br>    
<nav class="navbar navbar-light bg-light">
<div><b>Lista de Asistencia</b>
  <a href="{{route('listaasistencia.index')}}" class="navbar-brand">
  <button class="btn btn-outline-success ml-5" type="submit"><i class="fa fa-eye"></i> Ver Listas</button>
  </a></div>
</nav>


<br>
<div class="container">
<div class="form-inline">
  <label class="mb-3"><b>Fecha de Reunión:</b></label>
  <select class="custom-select ml-2 mb-3" name="calendario_id" required>
    <option value="">{{fecha($lista->fecha)}}</option>
  </select>
</div>  
<form method="POST" action="{{url('/listaasistencia/'.$lista->id)}}" enctype="multipart/form-data">
{{ csrf_field()}}
{{method_field('PATCH')}} 
<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Departamento</th>
      <th scope="col">Asistencia</th>
    </tr>
  </thead>
  <tbody>   
    @foreach($listausuario as $usuario)
    <tr>
      <td>
        {{$usuario->user->nombre}}
        <input type="hidden" name="identificador[]" value="{{$usuario->user->identificador}}">      
      </td>
      <td>{{$usuario->user->nombre_adscripcion()}}</td>
      <td>
      <select class="custom-select" name="asistencia[]">
         <option value="ASISTENCIA" {{$usuario['observacion'] == 'ASISTENCIA' ? 'selected' : '' }}>ASISTENCIA</option>
         <option value="FALTA" {{$usuario['observacion'] == 'FALTA' ? 'selected' : '' }}>FALTA</option>
         <option value="RETARDO" {{$usuario['observacion'] == 'RETARDO' ? 'selected' : '' }}>RETARDO</option>
         <option value="JUSTIFICACION" {{$usuario['observacion'] == 'JUSTIFICACION' ? 'selected' : '' }}>JUSTIFICACIÓN</option>
      </select>
      </td>
    </tr>
    @endforeach
    @foreach($invitados as $invitado)
    <tr>
      <td>
      <input type="hidden" name="ids[]" value="{{$invitado->id}}">
      <input type="text" class="form-control" value="{{$invitado->nombre}}" name="nombres[]"></input>
      </td>
      <td>
      <input type="text" class="form-control" value="{{$invitado->puesto}}" name="puestos[]"></input>
      </td>
      <td>
      <select class="custom-select">       
        <option value="ASISTENCIA">ASISTENCIA</option>
      </select>  
      </td>
    </tr>
    @endforeach
  </tbody>
</table>


<div class="row">
  <div class="col centrado">
    <button type="submit" class="btn btn-primary">Guardar</button>
  </div> 
  <div class="col centrado"> 
    <a href="{{route('listaasistencia.index')}}"><button class="btn btn-danger" type="button"> Cancelar </button></a>
  </div>
</div>

</form>
</div>

@endsection