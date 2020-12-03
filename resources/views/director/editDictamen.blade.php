@extends(Auth::user()->esAdmin() ? 'layouts.encabezadoAdmin' : 'layouts.encabezadoDirector')
@section('contenido');
<h3 class="centrado" style="color:#1B396A">DICTAMEN</h3>
<div class="container-sm">
 <h4 style="color:#1B396A"><b>Datos del Solicitante</b></h3>
 
 <div class="form-row">
   <div class="form-group col-md-5" >
   <label for="nombre">Nombre</label>
     <input type="text" class="form-control form-control-sm" value="{{$dictamen->usuario()->nombre_completo()}}" disabled>
   </div>
   <div class="form-group col-md-2">
     <label for="identificador">{{$dictamen->usuario()->tipo_id()}}</label>
     <input type="text" class="form-control form-control-sm" value="{{$dictamen->usuario()->identificador}}" disabled>
   </div>              
   <div class="form-group col-md-3">
     <label for="carrera_id">{{$dictamen->usuario()->tipo_carrera_adscripcion()}}</label>
     <input type="text" class="form-control form-control-sm" value="{{$dictamen->usuario()->carrera_adscripcion()}}" disabled>
   </div>       
 </div>
 <br>   

 <form method="POST" action="{{route('guardar.dictamen',$dictamen->id)}}" enctype="multipart/form-data">
 {{ csrf_field()}}
 {{method_field('PATCH')}}
 <h4 style="color:#1B396A"><b>Datos de Dictamen</b></h3>

 <div class="form-row">
   <div class="form-group col-md-3 " >
     <label for="fecha">Fecha</label>
     <input type="text" name="fecha" class="form-control form-control-sm" id="fecha" 
     value="@if($dictamen->fecha){{$dictamen->fecha}} @else{{hoyMesLetra()}} @endif">
   </div>
   <div class="form-group col-md-3">
     <label for="num_oficio">Oficio</label>
     <input type="num_oficio" name="num_oficio" class="form-control form-control-sm @error('num_oficio') is-invalid @enderror" id="num_oficio" value="@if(old('num_oficio')){{old('num_oficio')}}@else{{$dictamen->num_oficio}}@endif" autocomplete="off">
     @error('num_oficio')
     <span class="invalid-feedback" role="alert">
       <strong>{{ $message }}</strong>
     </span>
     @enderror
   </div>
   <div class="form-group col-md-3">
     <label for="num_dictamen">Número de Dictamen</label>
     <input type="num_dictamen" name="num_dictamen" class="form-control form-control-sm @error('num_dictamen') is-invalid @enderror" id="num_dictamen" value="@if(old('num_dictamen')){{old('num_dictamen')}}@else{{$dictamen->num_dictamen}}@endif" autocomplete="off">
     @error('num_dictamen')
     <span class="invalid-feedback" role="alert">
       <strong>{{ $message }}</strong>
     </span>
     @enderror
   </div>              
 </div>
 
 <div class="form-row">            
   <div class="form-group col-md-8">
    <label for="asunto">Asunto de solicitud:</label>
    <textarea id="asunto" class="form-control form-control-sm" rows="3" disabled required>{{$dictamen->asunto()}}</textarea>
   </div>
   <div class="form-group col-md-3">
     <label for="respuesta">{{ __('¿Se recomienda?') }}</label>                    
     <select class="form-control form-control-sm @error('respuesta') is-invalid @enderror" name="respuesta" value="">
       @if(old('respuesta'))
       <option value="SI" {{old('respuesta') == "SI" ? 'selected' : ''}}>SI</option>
       <option value="NO" {{old('respuesta') == "NO" ? 'selected' : ''}}>NO</option>
       @else
       <option value="">ELIGE</option>
       <option value="SI" {{$dictamen['respuesta'] == "SI" ? 'selected' : ''}}>SI</option>
       <option value="NO" {{$dictamen['respuesta'] == "NO" ? 'selected' : ''}}>NO</option>
       @endif
     </select>
   </div> 
 </div>

 <div class="form-row">
   <div class="input-group mb-3">
    <div class="input-group-prepend">
      <button class="btn btn-outline-danger" type="button" onclick="document.getElementById('observaciones').value = '';"><i class="fa fa-trash"></i></button>
    </div>
    <input id="observaciones" type="text" name="observaciones" value="{{old('observaciones') ? old('observaciones') : $dictamen->recomendacion->observaciones}}" placeholder="Asunto" class="form-control" aria-label="" aria-describedby="basic-addon1">
   </div>
 </div>
 
 <div class="form-row">            
   <div class="form-group col-md-12">
     <label for="anotaciones">Anotaciones:</label>
     <textarea id="anotaciones" class="form-control form-control-sm" rows="2" name="anotaciones" placeholder="Ejemplo:{{($dictamen->recomendacion->condicion) ? $dictamen->recomendacion->condicion : 'condicionado a..'}}">{{(old('anotaciones')) ? old('anotaciones') : $dictamen->anotaciones}}</textarea>
   </div>
 </div>

 <div class="row">
     <div class="col centrado">
       <button type="submit" class="btn btn-primary">Guardar</button>
     </div> 
     <div class="col centrado"> 
       <a href="{{route('director.dictamenes','pendientes')}}"><button class="btn btn-danger" type="button"> Cancelar </button></a>
     </div>
 </div>



 
 </form>
</div>
@endsection