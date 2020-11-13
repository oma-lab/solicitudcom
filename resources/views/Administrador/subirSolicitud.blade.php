@extends('layouts.encabezadoAdmin')
@section('contenido')

<section>
 <div class="container-fluid">
 <div class="card">
 

 <div class="form-group row">
   <label for="nombre" class="col-sm-1 col-form-label col-form-label-sm">Nombre:</label>
   <div class="col-sm-4">
     <input class="form-control form-control-sm" type="text" id="nombre" value="{{$solicitud->user->nombre_completo()}}" disabled>
   </div>
   <label for="identificador" class="col-sm-1 col-form-label col-form-label-sm">{{$solicitud->user->tipo_id()}}:</label>
   <div class="col-sm-2">
     <input class="form-control form-control-sm" type="text" id="identificador" value="{{$solicitud->user->identificador}}" disabled>
   </div>
 </div>

 <div class="form-group row">
   <label for="asunto" class="col-sm-1 col-form-label col-form-label-sm">Asunto:</label>
   <div class="col-sm-10">
     <input class="form-control form-control-sm" type="text" id="asunto" value="{{$solicitud->asunto}}" disabled>
   </div>
 </div>
 
 <form method="POST" action="{{ route('solicitud.guardar') }}" enctype="multipart/form-data">
 {{ csrf_field()}}
  <input name="solicitud_id" type="hidden" value="{{$solicitud->id}}">
  <div class="row">
   <div class="col-md-12">
     <b>Subir Solicitud y Evidencias</b><br><br>
       <div class="row" id="camposo">
         <div id="div1" >
         <b id="info1" style="color:red"></b>
           <div id="imagen1" class="input-group">
             <div class="input-group-prepend">
               <button class="btn btn-outline-danger" type="button" onclick="borrarimg(1)"><i class="fa fa-trash"></i></button>
             </div>
             <div class="custom-file mr-sm-2">
               <input id="files" type="file" class="file custom-file-input" name="file[]" required accept=".jpg, .jpeg, .png" onchange="editarfile(this,1)"/>
               <label id="labelfileo1" class="custom-file-label">Elegir imagen</label>
               <div class="invalid-feedback">Archivo invalido</div>
             </div>
           </div>
         </div>
       </div>
   </div>
  </div>
  <br><br>

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
 </div>
</section>

@endsection
@section('script')
<script src="{{ asset('js/solicitud.js') }}"></script>
@endsection