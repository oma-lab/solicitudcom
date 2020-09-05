@extends('layouts.encabezadoAdmin')
@section('contenido')

<div class="container-fluid">
@include('layouts.filtrado.mensaje')

 <div class="row">

  <!--Carreras-->  
  <div class="col-md-6">        
   <div class="card">
   <b>CARRERAS</b>
    <div class="card-header">
     <form class="form-inline" method="POST" action="{{route('guardar.carrera')}}" enctype="multipart/form-data">
     {{ csrf_field()}}
       <input type="text" class="form-control mr-sm-2" name="nombre" placeholder="carrera" required>
       <button class="btn btn-outline-success my-2 my-sm-0" type="input">+Agregar</button> 
     </form>        
    </div>          
    <div class="card-body">
      <table class="table table-sm">
        <thead>
         <tr>
          <th scope="col">Carrera</th>
          <th scope="col">Eliminar</th>
         </tr>
        </thead>
        <tbody>
        @foreach($carreras as $carrera)
         <tr>
          <td>{{$carrera->nombre}}</td>
          <td>
           <form method="POST" action="{{route('eliminar.carrera',$carrera->id)}}">
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

  <!--Adscripciones-->  
  <div class="col-md-6">
   <div class="card">
   <b>ADSCRIPCIONES</b>
    <div class="card-header">
     <form class="form-inline" method="POST" action="{{route('guardar.adscripcion')}}" enctype="multipart/form-data">
     {{ csrf_field()}}
       <input type="text" class="form-control mr-sm-2" name="nombre_adscripcion" placeholder="adscripcion" required>
       <select class="form-control mr-sm-2" name="tipo" required>
        <option value="">TIPO</option>
        <option value="carrera">Departamento de carrera</option>
        <option value="administrativo">Otro</option>
       </select> 
       <button class="btn btn-outline-success my-2 my-sm-0" type="input">+Agregar</button> 
     </form>           
    </div>
    <div class="card-body">
      <table class="table table-sm">
       <thead>
        <tr>
         <th scope="col">Adscripcion</th>
        </tr>
       </thead>
       <tbody>
       @foreach($adscripciones as $adscripcion)
       <tr>
        <td>{{$adscripcion->nombre_adscripcion}}</td>
        <td>
         <form method="post" action="{{route('eliminar.adscripcion',$adscripcion->id)}}">
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
</div>
@endsection