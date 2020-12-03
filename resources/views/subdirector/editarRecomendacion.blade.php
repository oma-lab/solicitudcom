@extends(Auth::user()->esAdmin() ? 'layouts.encabezadoAdmin' : 'layouts.encabezadosub')
@section('contenido')

<h3 class="centrado" style="color:#1B396A">RECOMENDACION</h3>
<div class="container-sm">
<h4 style="color:#1B396A"><b>Datos del solicitante</b></h3>

 <div class="form-row">
  <div class="form-group col-md-6 " >
    <label for="nombre">Nombre</label>
    <input type="text" class="form-control form-control-sm" value="{{$recomendacion->usuario()->nombre_completo()}}" disabled>
  </div>
  <div class="form-group col-md-2">
    <label for="identificador">{{$recomendacion->usuario()->tipo_id()}}</label>           
    <input type="text" class="form-control form-control-sm" value="{{$recomendacion->usuario()->identificador}}" disabled>
  </div>              
  <div class="form-group col-md-3">
    <label for="ads">{{$recomendacion->usuario()->tipo_carrera_adscripcion()}}</label>
    <input type="text" class="form-control form-control-sm"  value="{{$recomendacion->usuario()->carrera_adscripcion()}}" disabled>       
  </div>       
 </div>
 <br>   

 <form method="POST" action="{{route('guardar.recomendacion',$recomendacion->id)}}" enctype="multipart/form-data">
 {{ csrf_field()}}
 {{method_field('PATCH')}}      
 <h4 style="color:#1B396A"><b>Datos de Recomendacion</b></h3>
 
 <div class="form-row">
  <div class="form-group col-md-2" >
    <label for="fecha">Fecha</label>
    <input type="text" name="fecha" class="form-control form-control-sm" id="fecha" value="@if($recomendacion->fecha){{$recomendacion->fecha}} @else{{$fecha}} @endif">
  </div>
  
  <div class="form-group col-md-3">
    <label for="calendario_id">Fecha de reunión de comité académico</label>                    
    <select class="form-control form-control-sm" name="calendario_id" value="" required>
      <option value="">Selecciona</option>
      @foreach($fechasreuniones as $fr)
      @if($fr->id == $recomendacion->solicitud->calendario_id)
      <option value="{{$fr->id}}" selected>{{fecha($fr->start)}}</option>
      @else
      <option value="{{$fr->id}}">{{fecha($fr->start)}}</option>
      @endif
      @endforeach
    </select>
  </div> 

  <div class="form-group col-md-3">
    <label for="num_oficio">Oficio</label>
    <input type="text" name="num_oficio" class="form-control form-control-sm @error('num_oficio') is-invalid @enderror" id="num_oficio" value="@if(old('num_oficio')){{old('num_oficio')}}@else{{$recomendacion->num_oficio}}@endif" placeholder="">
    @error('num_oficio')
     <span class="invalid-feedback" role="alert">
       <strong>{{ $message }}</strong>
     </span>
     @enderror
  </div>
  
  <div class="form-group col-md-3">
    <label for="num_recomendacion">Número de Recomendación</label>
    <input type="num_recomendacion" name="num_recomendacion" class="form-control form-control-sm @error('num_recomendacion') is-invalid @enderror" id="num_recomendacion" value="@if(old('num_recomendacion')){{old('num_recomendacion')}}@else{{$recomendacion->num_recomendacion}}@endif" placeholder="">
    @error('num_recomendacion')
     <span class="invalid-feedback" role="alert">
       <strong>{{ $message }}</strong>
     </span>
     @enderror
  </div>              
 </div>
            
 <div class="form-row">
  <div class="form-group col-md-8">
    <label for="asunto">Asunto de solicitud</label>
    <textarea id="asunto" class="form-control form-control-sm" rows="3" disabled required>{{$recomendacion->asunto()}}</textarea>
  </div>
  <div class="form-group col-md-3">
    <label for="respuesta">{{ __('¿Se recomienda?') }}</label>                    
    <select class="form-control form-control-sm" name="respuesta" value="">
      @if(old('respuesta'))
      <option value="SI" {{old('respuesta') == "SI" ? 'selected' : '' }}>SI</option>
      <option value="NO" {{old('respuesta') == "NO" ? 'selected' : '' }}>NO</option>      
      @else
      <option value="SI" {{$recomendacion['respuesta'] == "SI" ? 'selected' : '' }}>SI</option>
      <option value="NO" {{$recomendacion['respuesta'] == "NO" ? 'selected' : '' }}>NO</option>
      @endif
    </select>
  </div> 
 </div>

 <div class="form-row">
   <div class="input-group mb-3">
    <div class="input-group-prepend">
      <button class="btn btn-outline-danger" type="button" onclick="document.getElementById('observaciones').value = '';"><i class="fa fa-trash"></i></button>
    </div>
    <input id="observaciones" type="text" name="observaciones" value="{{old('observaciones') ? old('observaciones') : $recomendacion->observaciones}}" placeholder="Asunto" class="form-control" aria-label="" aria-describedby="basic-addon1">
   </div>
 </div>
 
 <button type="button" class="btn btn-default" onclick="verobs({{$recomendacion->id_solicitud}})">
   <span class="fa fa-question-circle"  aria-hidden="true"></span>ver observaciones/votos
 </button><br>
 <b>Observaciones hechas en reunión:</b> @if($recomendacion->solicitud->observaciones){{$recomendacion->solicitud->observaciones}} @else Ninguna @endif
          
 <div class="form-row">
   <label for="condicion">Anotaciones:</label>
   <div class="input-group mb-3">
    <div class="input-group-prepend">
      <button class="btn btn-outline-danger" type="button" onclick="document.getElementById('condicion').value = '';"><i class="fa fa-trash"></i></button>
    </div>
    <input id="condicion" type="text" name="condicion" value="{{old('condicion') ? old('condicion') : $recomendacion->condicion}}" placeholder="Ejemplo: condicionado a ..." class="form-control" aria-label="" aria-describedby="basic-addon1">
   </div>
 </div>

 <div class="form-row">
   <label for="motivos">Por los siguientes motivos:</label>
   <div class="input-group mb-3">
    <div class="input-group-prepend">
      <button class="btn btn-outline-danger" type="button" onclick="document.getElementById('motivos').value = '';"><i class="fa fa-trash"></i></button>
    </div>
    <input id="motivos" type="text" name="motivos" value="{{old('motivos') ? old('motivos') : $recomendacion->motivos}}" placeholder="Ejemplo: Considerando las evidencias presentadas por el estudiante y su avance académico en el programa educativo de ingeniería industrial" class="form-control" aria-label="" aria-describedby="basic-addon1">
   </div>
 </div>

 <div class="row">
     <div class="col centrado">
       <button type="submit" class="btn btn-primary">Guardar</button>
     </div> 
     <div class="col centrado"> 
       <a href="{{route('recomendaciones')}}"><button class="btn btn-danger" type="button"> Cancelar </button></a>
     </div>
 </div>



 </form>
</div>
@include('layouts.modals')
@endsection