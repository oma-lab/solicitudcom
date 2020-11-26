@extends('layouts.encabezadoAdmin')
@section('contenido')

<div class="container-fluid">
@include('layouts.filtrado.mensaje')

 <div class="row">

  <div class="col-md-12">        
   <div class="card">
   <b>ASUNTOS</b>
    <div class="card-header">
     <form class="form-inline" method="POST" action="{{route('guardar.asunto')}}" enctype="multipart/form-data">
     {{ csrf_field()}}
       <input type="text" class="form-control mr-sm-2" name="asunto" placeholder="Nuevo Asunto" size="60"  required>
       <input type="text" class="form-control mr-sm-2" name="descripcion" placeholder="Descripción que se mostrara al solicitante" size="60"  required>
       <button class="btn btn-outline-success my-2 my-sm-0" type="input">+Agregar</button> 
     </form>        
    </div>          
    <div class="card-body">
      <table class="table table-sm">
        <thead>
         <tr>
          <th scope="col">Asunto</th>
          <th scope="col">Descripción</th>
          <th scope="col">Actualizar</th>
          <th scope="col">Eliminar</th>
         </tr>
        </thead>
        <tbody>
        @foreach($asuntos as $asunto)
         <tr>
          <form method="POST" action="{{route('actualizar.asunto',$asunto->id)}}">
          {{csrf_field()}}
          {{method_field('PATCH')}}
          <td><input type="text" class="form-control" name="asunto" value="{{$asunto->asunto}}" required></td>
          <td><input type="text" class="form-control" name="descripcion" value="{{$asunto->descripcion}}" required></td>
          <td>
           <button class="btn btn-outline-primary sm" type="input" ><i class="fa fa-undo"></i></button>  
          </td>
          </form>
          <td>
           <form method="POST" action="{{route('eliminar.asunto',$asunto->id)}}">
           {{csrf_field()}}
           {{method_field('DELETE')}} 
           <button class="btn btn-outline-danger sm" type="input" onClick='return confirm("¿Borrar?")'><i class="fa fa-trash"></i></button>
           </form>  
          </td>
         </tr>
        @endforeach
        </tbody>
      </table>
    </div>
   </div>
  </div>

 </div>
</div>
@endsection