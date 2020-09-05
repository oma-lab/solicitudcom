@extends('layouts.encabezadoAdmin')
@section('estilos')
<style>
.derecha {
  text-align: right;
}
.container div img{
  cursor: pointer;
  border: black 1px solid;
}
</style>
@endsection
@section('contenido')

<div class="container">

 <div class="row">
  <div class="form-group col-md-5">
    <img style="height:80px;" src="{{asset('storage/'.$datospdf->head1)}}" onclick="cambiar('head1')">
  </div>
  <div class="form-group col-md-5 derecha">
    <img style="height:80px;" src="{{asset('storage/'.$datospdf->head2)}}" onclick="cambiar('head2')"> 
  </div>
  <div class="form-group col-md-2">
    <b >*Da Clic sobre la imagen que quieres cambiar</b>
  </div>
 </div>

 <form method="POST" action="{{route('vistaprevia')}}" enctype="multipart/form-data">
 {{ csrf_field()}}
 <div class="row">
  <div class="form-group col-md-10">
    <input id="leyenda" type="text" class="form-control form-control-sm centrado" name="headtext" value="{{$datospdf->headtext}}">
  </div>
 </div>

 <div class="row">
  <div class="form-group col-md-10 centrado">
    <img  style="width:30%;" src="{{asset('storage/'.$datospdf->body)}}" onclick="cambiar('body')"> 
  </div>
  <div class="form-group col-md-2">
    <button type="submit" class="btn btn-success" formtarget="_blank">Vista previa/Guardar</button>
  </div>
 </div>
 </form>

 <div class="row">
  <div class="form-group col-md-1">
    <img style="height:60px;" src="{{asset('storage/'.$datospdf->pie1)}}" onclick="cambiar('pie1')">
  </div>
  <div class="form-group col-md-1">
    <img style="height:60px;" src="{{asset('storage/'.$datospdf->pie2)}}" onclick="cambiar('pie2')">
  </div>
  <div class="form-group col-md-1">
    <img style="height:60px;" src="{{asset('storage/'.$datospdf->pie3)}}" onclick="cambiar('pie3')">
  </div>
  <div class="form-group col-md-4">
  <textarea class="form-control form-control-sm centrado" id="leyendapie" rows="5" name="pietext" disabled>
  Av. Ing. Víctor Bravo Ahuja # 125 esq. Clz. Tecnológico. C.P. 68030. Oaxaca, Oax. 
  Tels. (951) 5015016, Conmt. Ext. 218, e-mail: comite.academico@itoaxaca.edu.mx
  www.oaxaca.tecnm.mx
  </textarea>
  </div>
  <div class="form-group col-md-1">
    <img style="height:60px;" src="{{asset('storage/'.$datospdf->pie4)}}" onclick="cambiar('pie4')">
  </div>
  <div class="form-group col-md-1">
    <img style="height:60px;" src="{{asset('storage/'.$datospdf->pie5)}}" onclick="cambiar('pie5')">
  </div>
  <div class="form-group col-md-1">
    <img style="height:60px;" src="{{asset('storage/'.$datospdf->pie6)}}" onclick="cambiar('pie6')">
  </div>
 </div>

</div><!--FIN CONTAINER-->





<!-- Modal para seleccionar y cambiar imagen-->
<form method="POST" action="{{route('cambiar.formato')}}" enctype="multipart/form-data">
{{ csrf_field()}}
<div class="modal fade" id="encabezado" data-backdrop="static">
 <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
   <div class="modal-header">
     <h5>Nuevo</h5>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </button>
   </div>
   <div class="modal-body">
     <input id="subir" name="img" type="hidden" value="">        
     <div class="form-row">               
      <div class="form-group col-md-12">
        <b>Formato: </b> .png<br><b>Tamaño recomendado: </b><label id="tamanio"></label>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="validatedCustomFile" name="img_subida" accept="image/png, image/jpeg, image/jpg">
          <label id="labelpng" class="custom-file-label" for="validatedCustomFile">No se eligió archivo</label>
          <div class="invalid-feedback">Archivo invalido</div>
        </div>
      </div>
     </div>
   </div>
   <div class="modal-footer">
     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
     <button type="button" class="btn btn-danger" onclick="event.preventDefault();document.getElementById('eliminarform').submit();">Borrar</button>
     <button type="submit" class="btn btn-primary">Guardar</button>        
   </div>
  </div>
 </div>
</div>
</form>

<form id="eliminarform" action="{{route('eliminar.formato')}}" method="POST">
{{ csrf_field()}}
{{method_field('DELETE')}} 
<input id="eliminar" name="img" type="hidden" value="">  
</form>

@endsection



@section('script')
<script>
function cambiar(img){
 if(img == 'head1'){
  $('#tamanio').text("503px x 122px");
 }else if(img == 'head2'){
  $('#tamanio').text("232px x 130px");
 }else if(img == 'body'){
  $('#tamanio').text("1057px x 817px");
 }else{
  $('#tamanio').text("60px x 60px");
 }
 $('#subir').val(img);
 $('#eliminar').val(img);
 $("#encabezado").modal("show");
}
</script>
@endsection