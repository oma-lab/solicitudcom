@extends('layouts.encabezadoSolicitante')
@section('contenido')
<h3 class="centrado" style="text-transform: uppercase;">SOLICITUD</h3>
<div class="container-sm">
<form method="POST" action="{{ route('registrar.solicitud') }}" enctype="multipart/form-data" onsubmit="formdisable()">
{{ csrf_field()}}
 <div class="form-row">
   <div class="form-group col-md-4">
     <label for="nombre">Nombre</label>
     <input type="text"  class="form-control form-control-sm" id="nombre" placeholder="{{ usuario()->nombre_completo() }}" disabled>
   </div>
   <div class="form-group col-md-2">
     <label for="identificador">{{usuario()->tipo_id()}}</label>
     <input type="text" class="form-control form-control-sm" id="identificador" placeholder="{{ usuario()->identificador }}" disabled>
   </div>
   <div class="form-group col-md-4">
     <label for="carrera_ads">{{usuario()->tipo_carrera_adscripcion()}}</label>
     <input type="text" class="form-control form-control-sm" id="carrera_ads" placeholder="{{ usuario()->carrera_adscripcion() }}" disabled>
   </div>
 </div>
        
 <div class="form-group row">
   @if(usuario()->esEstudiante())   
   <label for="semestre" class="col-sm-1 col-form-label col-form-label-sm"><b>Semestre:</b></label>
   <div class="col-sm-2">
     <input id="semestre" name="semestre" type="text" class="form-control form-control-sm" value="{{semestre()}}" autofocus required>
   </div>
   @elseif(usuario()->esDocente())
   <label for="carrera_profesor" class="col-sm-2 col-form-label col-form-label-sm">Profesor de la carrera de:</label>
   <div class="col-sm-4">
     <select  class="form-control form-control-sm" name="carrera_profesor">
      @foreach($carreras as $carrera)
      <option>{{$carrera->nombre}}</option>
      @endforeach             
     </select>
   </div>
   @else
   @endif  
   <label for="fecha" class="col-sm-1 col-form-label col-form-label-sm">Fecha:</label>
   <div class="col-sm-2">
     <input class="form-control form-control-sm" type="date" id="fecha" name="fecha" value="{{hoy()}}" required>
   </div>
 </div>

 <div class="form-row">
   <div class="form-group col-md-6">              
     <label>Elige un asunto y a continuación describe el asunto de tu solicitud:</label>
     <select  class="form-control form-control-sm" onchange="mot(this,{{$asuntos}})">
       <option>ELIGE UN ASUNTO</option>
       @foreach($asuntos as $asunto)
       <option>{{$asunto->asunto}}</option>
       @endforeach    
       <option value="Otro">Otro</option>             
     </select>
   </div>          
 </div>
 
 <b id="texto" style="color:blue"></b><p id="ejemplos" style="color:blue"></p>
 <div class="form-group row">
   <label for="asunto" class="col-sm-1 col-form-label">Asunto:</label>
   <div class="col-sm-11">            
     <input id="asunto" type="text" class="form-control form-control" name="asunto" value="" autocomplete="off" required>
   </div>
 </div>
              
 <label><b>A continuación escribe los motivos por los cuales realizas la solicitud. En caso de no tener, deja el campo vacío</b></label>   
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
 
 <br>
 
 <div class="row">
     <div class="col centrado">
       <button type="submit" class="btn btn-primary" id="btnsg">Generar</button>
     </div> 
     <div class="col centrado"> 
       <a href="{{route('home')}}"><button class="btn btn-danger" type="button"> Cancelar </button></a>
     </div>
 </div>



</form>
</div>
@endsection






@section('script')
<script src="{{ asset('js/solicitud.js') }}"></script>
@endsection

      

   