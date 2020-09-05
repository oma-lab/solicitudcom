@extends('layouts.encabezadoAdmin')
@section('contenido')


<div class="container">
<form method="POST" action="{{route('acta.update',$acta->id)}}" enctype="multipart/form-data">
{{ csrf_field()}}
{{method_field('PATCH')}}
<div class="row justify-content-center">
  <div class="form-group col-md-9">
    <input id="titulo" type="text" class="form-control form-control-sm centrado" name="titulo" value="{{$acta->titulo}}">
  </div>
</div>
<div class="row justify-content-center">  
  <div class="form-group col-md-9">
    <textarea class="form-control" id="contenido" rows="40" cols="5" name="contenido" style="text-transform: uppercase;">{{$acta->contenido}}</textarea>
  </div>
</div>  

<div class="row">
  <div class="col centrado">
    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
  </div> 
  <div class="col centrado"> 
    <a href="{{route('acta.index')}}"><button class="btn btn-danger" type="button"> Cancelar </button></a>
  </div>
</div>



</form>   
</div>
@endsection