@extends('layouts.encabezadoAdmin')
@section('contenido')
<div class="container"> 

<nav class="navbar navbar-light bg-light">
 <div><b>Lista de Asistencia</b>
   <button class="btn btn-outline-success ml-5" type="submit" data-toggle="modal" data-target="#nuevalista"><i class="fa fa-clipboard"></i> Nueva Lista</button>
 </div>
 <form method="GET" action="{{route('listaasistencia.index')}}" class="form-inline">
 Fecha:
 <input class="form-control mr-sm-2" type="date" name="fechareunion" value="{{request('fechareunion')}}">
 <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fa fa-search"></i> Buscar</button>
 </form>
</nav>

<br>
@include('layouts.filtrado.mensaje')

<table class="table">
  <thead class="thead-light">
   <tr>
    <th scope="col">#</th>
    <th scope="col">Fecha</th>
    <th scope="col">Descripcion</th>
    <th scope="col">Acción</th>
   </tr>
  </thead>
  <tbody>   
   @foreach($listas as $lista)
   <tr>
    <th scope="row">{{$loop->iteration}}</th>
    <td>{{fecha($lista->calendario->start)}}</td>
    <td>{{$lista->descripcion}}</td>
    <td>
      <a href="{{route('verLista',$lista->id)}}" target= "_blank">
       <button type="button" class="btn btn-outline-primary btn-sm">
        <i class="fa fa-download"></i> Descargar
       </button>
      </a>
      <a href="{{url('/listaasistencia/'.$lista->id.'/edit')}}">
       <button type="button" class="btn btn-outline-success btn-sm">
        <i class="fa fa-eye"></i> Modificar
       </button>
      </a>
      <form method="POST" action="{{url('/listaasistencia/'.$lista->id)}}" style="display:inline;">
      {{csrf_field()}}
      {{method_field('DELETE')}} 
      <button type="submit" class="btn btn-outline-danger btn-sm">
       <i class="fa fa-trash"></i> Eliminar
      </button>
      </form>
      <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#modalsubir" onclick="document.getElementById('formsubir').action = '/listaasistencia/{{$lista->id}}'; document.getElementById('subirfile').value = '';document.getElementById('labelpdf').innerHTML = 'Elegir Archivo PDF';">
       <i class="fa fa-eye"></i> Archivar
      </button>
      <a href="{{url('storage/'.$lista->lista_archivo)}}" target= "_blank">
       <button type="button" class="btn btn-outline-primary btn-sm">
        <i class="fa fa-eye"></i> Ver
       </button>
      </a>
    </td>
   </tr>
   @endforeach
  </tbody>
</table>
{{$listas->links()}}
</div>
@include('layouts.modals.asistencia')
@include('layouts.modals.file')
@endsection


@section('script')
<script src="{{ asset('js/lista.js') }}"></script>
@endsection  