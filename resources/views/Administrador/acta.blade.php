@extends('layouts.encabezadoAdmin')
@section('contenido')

<div class="container">

@include('layouts.filtrado.mensaje')

<nav class="navbar navbar-light bg-light">
<form method="GET" action="{{route('acta.create')}}" enctype="multipart/form-data" class="form-inline">
{{ csrf_field()}} 
<div><b>Nueva Acta</b>
  Reunión:
  <select class="custom-select" name="calendario_id" required>
    @forelse($reunion as $r)
    <option value="{{$r->id}}">{{fecha($r->start)}}</option>
    @empty
    <option value="">No hay fecha registra</option>
    @endforelse
  </select>
  <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fa fa-clipboard"></i> Generar</button>   
</form>
</div>
</nav><br>


<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">Fecha</th>
      <th scope="col">Descripcion</th>
      <th scope="col">Acción</th>
    </tr>
  </thead>
  <tbody>   
    @foreach($actas as $acta)
    <tr>
      <td>{{fecha($acta->fecha())}}</td>
      <td>{{$acta->titulo}}</td>
      <td>
         <a href="{{url('/acta/'.$acta->id.'/edit')}}">
          <button class="btn btn-outline-success" type="submit"><i class="fa fa-eye"></i> Ver</button>
         </a>
         <form method="POST" action="{{url('/acta/'.$acta->id)}}" style="display:inline;">
          {{csrf_field()}}
          {{method_field('DELETE')}} 
          <button class="btn btn-outline-danger" type="submit"><i class="fa fa-trash"></i> Borrar</button>
         </form>
         <a href="{{url('acta/descargar/'.$acta->id)}}" target= "_blank">
          <button class="btn btn-outline-success" type="submit"><i class="fa fa-download"></i> Descargar</button>
         </a>
         <button class="btn btn-outline-success" type="button" data-toggle="modal" data-target="#modalsubir" onclick="document.getElementById('formsubir').action = '/acta/{{$acta->id}}'">Subir</button>
         <a href="{{ url('storage/'.$acta->acta_file)}}" target= "_blank">
          <button class="btn btn-outline-success" type="button"></i> Ver subido</button>
         </a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{$actas->links()}}
</div>
@include('layouts.modals.file')
@endsection