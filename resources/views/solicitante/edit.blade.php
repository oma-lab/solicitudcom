@extends('layouts.encabezadoSolicitante')
@section('contenido')
<h3 class="centrado" style="color:#1B396A">MODIFICAR SOLICITUD</h3>
<div class="container-sm">
<form method="POST" action="{{route('update.solicitud',$solicitud->id)}}" enctype="multipart/form-data">
{{ csrf_field()}}
{{method_field('PATCH')}}
  <div class="form-row">
    <div class="form-group col-md-4 " >
      <label for="nombre">Nombre</label>
      <input type="nombre"  class="form-control form-control-sm" id="nombre" placeholder="{{ usuario()->nombre_completo() }}" disabled>
    </div>
    <div class="form-group col-md-2">
      <label for="identificador">{{usuario()->tipo_id()}}</label>
      <input type="identificador" class="form-control form-control-sm" id="identificador" placeholder="{{ usuario()->identificador }}" disabled>
    </div>
    <div class="form-group col-md-4">
      <label for="carrera_ads">{{usuario()->tipo_carrera_adscripcion()}}</label>
      <input type="text" class="form-control form-control-sm" id="carrera_ads" placeholder="{{ usuario()->carrera_adscripcion() }}" disabled>
    </div>
  </div>

  <div class="form-group row">
    @if(usuario()->esDocente())
    <div class="form-group col-md-6">              
      <label for="carrera_profesor">Profesor de la carrera de:</label>
      <select  class="form-control form-control-sm" name="carrera_profesor">
        @foreach($carreras as $carrera)
        <option {{$solicitud['carrera_profesor'] == $carrera['nombre'] ? 'selected' : '' }}>{{$carrera->nombre}}</option>
        @endforeach             
      </select>
    </div>
    @else
    <label for="semestre" class="col-sm-1 col-form-label col-form-label-sm">Semestre</label>
    <div class="col-sm-2">
      <input id="semestre" name="semestre" type="text" class="form-control form-control-sm" value="{{$solicitud->semestre}}" autofocus required>
    </div>
    @endif
    <label for="fecha" class="col-sm-1 col-form-label col-form-label-sm">Fecha:</label>
    <div class="col-sm-2">
      <input class="form-control form-control-sm" type="date" id="fecha" name="fecha" value="{{fechabase($solicitud->fecha)}}" required>
    </div>
  </div>
  
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="asunto">Asunto:<b id="texto" style="color:blue"></b></label>
      <textarea class="form-control" id="asunto" rows="2" name="asunto" placeholder="Escribe tu asunto" required>{{$solicitud->asunto}}</textarea>
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6"> 
      <label for="motivos_academicos">Motivos académicos</label>
      <textarea class="form-control" id="motivos_academicos" rows="2" name="motivos_academicos" placeholder="Escribe tus motivos académicos">{{$solicitud->motivos_academicos}}</textarea>
    </div>
    <div class="form-group col-md-6">
      <label for="motivos_personales">Motivos personales</label>
      <textarea class="form-control" id="motivos_personales" rows="2" name="motivos_personales" placeholder="Escribe tus motivos personales" >{{$solicitud->motivos_personales}}</textarea>
    </div>   
  </div>      

  <div class="form-group">
    <label for="otros_motivos">Otros</label>                  
    <textarea class="form-control" id="otros_motivos" rows="2" name="otros_motivos" placeholder="Otros motivos">{{$solicitud->otros_motivos}}</textarea>
  </div>
  
  <a href="{{url('storage/'.$solicitud->evidencias)}}" target= "_blank">Ver evidencias actuales</a><br>            
  <label><b>Evidencias:</b>Al subir nuevas se eliminaran las actuales</label><br>
  <label>Sube tus evidencias en formato de imagen(.png ,.jpeg, .jpg)</label><br>
  <label>Asegúrate que tus evidencias sean claras que no tengan un fondo muy obscuro y tu hoja debe estar de manera vertical, cualquier omisión de estas indicaciones anulará tu solicitud.</label><br>
  <b id="labelinfo" style="color:red"></b>   
  <div class="row" id="camposo">
    <div id="div1">
      <div id="imagen1" class="input-group">
        <div class="input-group-prepend">
          <button class="btn btn-outline-danger" type="button" onclick="borrarimg(1)"><i class="fa fa-trash"></i></button>
        </div>
        <div class="custom-file mr-sm-2">
          <input id="files" type="file" class="file custom-file-input" name="file[]" accept=".jpg, .jpeg, .png" onchange="editarfile(this,1)"/>
          <label id="labelfileo1" class="custom-file-label">Elegir imagen</label>
          <div class="invalid-feedback">Archivo invalido</div>
        </div>
      </div>
    </div>
  </div><br>

  <div class="row">
     <div class="col centrado">
       <button type="submit" class="btn btn-primary">Guardar</button>
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
