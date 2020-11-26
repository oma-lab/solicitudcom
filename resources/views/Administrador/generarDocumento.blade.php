@extends('layouts.encabezadoAdmin')
@section('contenido')

<h3 class="centrado" style="text-transform: uppercase;">REGISTRAR</h3>
<div class="container-sm">
<form method="POST" action="{{ route('generar.documento') }}" enctype="multipart/form-data" onsubmit="esSolicitud()">
{{ csrf_field()}}

 <div class="form-row"> 
   <div class="form-group col-md-3">
     <label for="nombre">Nombre</label>
     <input type="text"  class="form-control form-control-sm" id="nombre" name="nombre" placeholder="Nombre" required>
   </div>
   <div class="form-group col-md-3">
     <label for="apellido_paterno">Apellido Paterno</label>
     <input type="text"  class="form-control form-control-sm" id="apellido_paterno" name="apellido_paterno" placeholder="Apellido paterno" required>
   </div>
   <div class="form-group col-md-3">
     <label for="apellido_materno">Apellido Materno</label>
     <input type="text"  class="form-control form-control-sm" id="apellido_materno" name="apellido_materno" value="" placeholder="Apellido Materno">
   </div>
   <div class="form-group col-md-3">              
     <label for="sexo">Sexo:</label>
     <select id="sexo" class="form-control form-control-sm" name="sexo" required>
        <option value="">SELECCIONA SEXO</option>
        <option value="H" {{old('sexo') == 'H' ? 'selected' : '' }}>HOMBRE</option>
        <option value="M" {{old('sexo') == 'M' ? 'selected' : '' }}>MUJER</option>
      </select>     
   </div>
 </div>  

 <div class="form-group row">
 <div class="form-check col-sm-2">
   <input class="form-check-input" type="radio" name="role_id" id="check1" value="3" checked onclick="rol('estudiante','N°Control:')">
   <label class="form-check-label" for="check1">Estudiante</label>
 </div>
 <div class="form-check col-sm-2">
   <input class="form-check-input" type="radio" name="role_id" id="check2" value="4" onclick="rol('docente','RFC:')">
   <label class="form-check-label" for="check2">Docente</label>
 </div>
 </div>

 <div class="form-group row">
   <label id="ident" for="identificador" class="col-sm-1 col-form-label col-form-label-sm">N°Control:</label>
   <div class="col-sm-2">
     <input class="form-control form-control-sm" type="text" id="identificador" name="identificador" required>
   </div>
   <label for="fecha" class="col-sm-1 col-form-label col-form-label-sm">Fecha:</label>
   <div class="col-sm-2">
     <input class="form-control form-control-sm" type="date" id="fecha" name="fecha" value="{{hoy()}}" required>
   </div>
   <label for="calendario_id" class="col-sm-1 col-form-label col-form-label-sm">Reunión:</label>
   <div class="col-sm-2">
     <select  class="form-control form-control-sm" name="calendario_id" required>
      @foreach($proximas as $proxima)
      <option value="{{$proxima->id}}">{{fecha($proxima->start)}}</option>
      @endforeach
      @foreach($pasadas as $pasada)
      <option value="{{$pasada->id}}">{{fecha($pasada->start)}}</option>
      @endforeach  
     </select>
   </div>
 </div>

 <div id="estudiante" style="display:block">
 <div class="form-row">
   <div class="form-group col-md-6">              
     <label for="carrera_id">Carrera:</label>
     <select class="form-control form-control-sm" name="carrera_id">
       <option value="">ELIGE CARRERA</option>
       @foreach($carreras as $carrera)
       <option value="{{$carrera->id}}">{{$carrera->nombre}}</option>
       @endforeach            
     </select>
   </div>
   <div class="form-group col-md-2">
     <label for="semestre">Semestre</label>
     <input type="text" class="form-control form-control-sm" id="semestre" name="semestre" placeholder="Semestre">
   </div>
 </div>
 </div>

 <div id="docente" style="display:none">
 <div class="form-row">
   <div class="form-group col-md-6">              
     <label for="adscripcion_id">Adscripcion:</label>
     <select class="form-control form-control-sm" name="adscripcion_id">
       <option value="">ELIGE ADSCRIPCIÓN</option>
       @foreach($adscripciones as $adscripcion)
       <option value="{{$adscripcion->id}}">{{$adscripcion->nombre_adscripcion}}</option>
       @endforeach            
     </select>
   </div>
   <div class="form-group col-md-6">              
     <label for="carrera_profesor">Profesor de la carrera de:</label>
     <select class="form-control form-control-sm" name="carrera_profesor">
       <option value="">ELIGE CARRERA</option>
       @foreach($carreras as $carrera)
       <option>{{$carrera->nombre}}</option>
       @endforeach            
     </select>
   </div>
 </div>
 </div>


 <div class="form-row"> 
   <div class="form-group col-md-12">
     <label for="asunto">Asunto</label>
     <textarea class="form-control" id="asunto" rows="2" name="asunto" placeholder="Escriba el asunto" required></textarea>
   </div>
 </div>

 <div class="form-group row">
 <div class="form-check col-sm-2">
   <input class="form-check-input" type="radio" name="tipo_doc" id="check3" value="solicitud" checked onclick="documento('solicitud')">
   <label class="form-check-label" for="check3">Solicitud</label>
 </div>
 <div class="form-check col-sm-2">
   <input class="form-check-input" type="radio" name="tipo_doc" id="check4" value="recomendacion" onclick="documento('recomendacion')">
   <label class="form-check-label" for="check4">Recomendación</label>
 </div>
 <div class="form-check col-sm-2">
   <input class="form-check-input" type="radio" name="tipo_doc" id="check5" value="dictamen" onclick="documento('dictamen')">
   <label class="form-check-label" for="check5">Dictamen</label>
 </div>
 </div>


 <div class="documento" id="solicitud" style="display:block">
 <div class="form-row">
   <div class="form-group col-md-6">
     <label for="motivos_academicos">Motivos académicos</label>
     <textarea class="form-control" id="motivos_academicos" rows="2" name="motivos_academicos" placeholder="Escribe tus motivos académicos" ></textarea>
   </div>
   <div class="form-group col-md-6">
     <label for="motivos_personales">Motivos personales</label>
     <textarea class="form-control" id="motivos_personales" rows="2" name="motivos_personales" placeholder="Escribe tus motivos personales"></textarea>
   </div>   
 </div>

 <div class="form-group">
   <label for="otros_motivos">Otros motivos</label>
   <textarea class="form-control" id="otros_motivos" rows="2" name="otros_motivos" placeholder="Otros Motivos"></textarea>
 </div>
 </div>




 <div class="documento" id="recomendacion" style="display:none">
 <div class="form-row">
  <div class="form-group col-md-3">
    <label for="num_oficio">Oficio</label>
    <input type="text" name="num_oficio" class="form-control form-control-sm" id="num_oficio" placeholder="CA-00-256/20">
  </div>
  
  <div class="form-group col-md-3">
    <label for="num_recomendacion">Número de Recomendación</label>
    <input type="num_recomendacion" name="num_recomendacion" class="form-control form-control-sm" id="num_recomendacion" placeholder="571/20">
  </div>

  <div class="form-group col-md-3">
    <label for="respuesta_rec">{{ __('¿Se recomienda?') }}</label>                    
    <select class="form-control form-control-sm" name="respuesta_rec" value="">
      <option value="">ELIGE</option>
      <option value="SI">SI</option>
      <option value="NO">NO</option> 
    </select>
  </div>
 </div>

 <div class="form-group">
   <label for="otros_motivos">Condicionado a:</label>
   <textarea class="form-control" id="condicion" rows="2" name="condicion" placeholder=""></textarea>
 </div>
 <div class="form-group">
   <label for="otros_motivos">Por los siguientes motivos:</label>
   <textarea class="form-control" id="motivos" rows="2" name="motivos" placeholder=""></textarea>
 </div>
 
 </div>



 <div class="documento" id="dictamen" style="display:none">

 <div class="form-row">
   <div class="form-group col-md-3">
     <label for="num_oficio_dic">Oficio:</label>
     <input type="num_oficio_dic" name="num_oficio_dic" class="form-control form-control-sm" id="num_oficio_dic" value="" autocomplete="off" placeholder="DIR-00-xxx/2020">
   </div>
   <div class="form-group col-md-3">
     <label for="num_dictamen">Número de Dictamen:</label>
     <input type="num_dictamen" name="num_dictamen" class="form-control form-control-sm" id="num_dictamen" value="" autocomplete="off" placeholder="xxx/2020">
   </div>
   <div class="form-group col-md-3">
     <label for="respuesta_dic">{{ __('¿Se recomienda?') }}</label>                    
     <select class="form-control form-control-sm" name="respuesta_dic" value="">
       <option value="">ELIGE</option>
       <option value="SI">SI</option>
       <option value="NO">NO</option>
     </select>
   </div> 
 </div>

 <div class="form-row">            
   <div class="form-group col-md-12">
     <label for="anotaciones">Anotaciones:</label>
     <textarea id="anotaciones" class="form-control form-control-sm" rows="2" name="anotaciones"></textarea>
   </div>
 </div>

 </div>

 <b id="notasolicitud" style="color:red"></b>
 <div id="botonesaccion" class="row" style="visibility: visible;">
     <div class="col centrado">
       <button id="botongenerar" type="submit" class="btn btn-primary">Generar</button>
     </div> 
     <div class="col centrado"> 
       <a href="{{route('home')}}"><button class="btn btn-danger" type="button"> Cancelar </button></a>
     </div>
 </div>
 <div id="botoneshecho" class="row" style="visibility: hidden;">
     <div class="col centrado">
       <a href="{{route('registrar.documento')}}"><button class="btn btn-success" type="button">Generar Nuevo</button></a>
     </div> 
     <div class="col centrado"> 
       <a href="{{route('home')}}"><button class="btn btn-primary" type="button">Ver solicitudes</button></a>
     </div>
 </div>



</form>
</div>
@endsection






@section('script')
<script src="{{ asset('js/lista.js') }}"></script>
@endsection

      

   