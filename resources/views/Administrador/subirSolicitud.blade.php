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

  <form method="POST" action="{{route('solicitud.guardar',$solicitud->id)}}" enctype="multipart/form-data">
  {{csrf_field()}}
   <div class="form-row">               
    <div class="form-group col-md-4">
     <label for="archivo"><b>Formato firmado y evidencias(Solo se admiten archivos PDF)</b></label>
     <div class="custom-file">
      <input type="file" class="custom-file-input" id="subirfile" name="doc_solicitud" accept="application/pdf" required>
      <label class="custom-file-label" for="subirfile">Elegir Archivo PDF</label>
      <div class="invalid-feedback">Archivo invalido</div>
      <b id="infpdf" style="color:red"></b>
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
<script src="{{ asset('js/file.js') }}"></script>
@endsection