@extends($encabezado)
@section('estilos')
<!-- Estilos Calendario -->
<link rel="stylesheet" href="{{ asset('cal/core/main.css') }}">
<link rel="stylesheet" href="{{ asset('cal/daygrid/main.css') }}">
<link rel="stylesheet" href="{{ asset('cal/list/main.css') }}">
<link rel="stylesheet" href="{{ asset('cal/timegrid/main.css') }}">
<!-- Calendario -->
<script src="{{ asset('cal/core/main.js') }}"></script>
<script src="{{ asset('cal/interaction/main.js') }}"></script>
<script src="{{ asset('cal/daygrid/main.js') }}"></script>
<script src="{{ asset('cal/list/main.js') }}"></script>
<script src="{{ asset('cal/timegrid/main.js') }}"></script>
<script src="{{ asset('cal/locales/es.js')}}"></script>
<style>
html,body{
  margin:0;padding:0;
  font-family: Arial, Helvetica, sans-serif;
  font-size: 12 px;
}
#calendar{
  font-weight: bold;
  width: 90%;
  margin: 10px auto;
}
</style>  
@endsection
@section('contenido')
@if(Auth::user()->esAdmin())
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Crear Programación</h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	 <span aria-hidden="true">&times;</span>
	</button>
   </div>
   <div class="modal-body">
    <input type="hidden" id="id" name="id" value="">
	<div class="form-group">
	  <label for="recipient-name" class="col-form-label">Asunto :</label>
	  <select class="form-control" name="title" id="title" required>
	    <option>reunión de Comité Académico</option>
		<option>reunión extraordinaria de Comité Académico</option>
	  </select>
	</div>
	<div class="form-group">
	  <label  class="col-form-label">Fecha:</label>
	  <input type="text" class="form-control" name="start" id="start">
	</div>
	<div class="form-group">
	  <label  class="col-form-label">Hora:</label>
	  <input type="time" class="form-control" name="hora" id="hora" max="24:00:00">
	</div>
	<div class="form-group">
	  <label for="descripcion"> Descripcion</label>
	  <textarea class="form-control" name="descripcion" id="descripcion"></textarea>
	</div>
   </div>
   <div class="modal-footer">
     <button id="btnAgregar" class="btn btn-success" >Agregar</button>
	 <button id="btnEliminar" class="btn btn-danger" >Borrar</button>
	 <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
   </div>
  </div>
 </div>
</div>
@endif
<div class="row">
  <div class="col-12"><div id='calendar'></div></div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'dayGrid','interaction','timeGrid','list' ],
      header: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,listMonth'
      },
      height: 450,
      editable: false,
      dateClick:function(info){
      $('#start').val(info.dateStr);
      $('#hora').val("");
      $('#descripcion').val("");
      $('#exampleModal').modal();
      },
      eventClick:function(info){
      var ano = calendar.formatDate(info.event.start, {				
      year: 'numeric'
      });
      var mes = calendar.formatDate(info.event.start, {
      month: '2-digit'
      });
      var dia = calendar.formatDate(info.event.start, {
      day: '2-digit'
      });
      var fech=dia+"/"+mes+"/"+ano;
      $('#id').val(info.event.id);
      $('#title').val(info.event.title);
      $('#start').val(fech);
      $('#hora').val(info.event.extendedProps.hora);
      $('#descripcion').val(info.event.extendedProps.descripcion);
      $('#exampleModal').modal();
      },
      events:"{{url('/reunion')}}",
      eventTextColor: 'white'
  });
  calendar.setOption('locale','es');
  calendar.render();
  //metodo agregar datos
  $('#btnAgregar').click(function(){
  ObjEvento=recolectarDatos("POST");
  EnviarInformacion('',ObjEvento);
  });
  //metodo eliminar datos
  $('#btnEliminar').click(function(){
  ObjEvento=recolectarDatos("DELETE");
  EnviarInformacion('/'+$('#id').val(),ObjEvento);
  });
  function recolectarDatos(method){
  nuevoEvento={
  id:$('#id').val(),
  title:$('#title').val(),
  start:$('#start').val(),
  hora:$('#hora').val(),
  descripcion:$('#descripcion').val(),
  '_token':$("meta[name='csrf-token']").attr("content"),
  '_method':method
  }
  return (nuevoEvento);
  } 
  function EnviarInformacion(accion,objEvento){
  $.ajax(
  {
  type:"POST",
  url:"{{url('/reunion')}}"+accion,
  data:objEvento,
  success:function(msg){
  $('#exampleModal').modal('toggle');
  calendar.refetchEvents();
  if(msg == "Error"){
    alert("No es posible eliminar, hay solicitudes registradas para esta fecha");
    location.reload();
  }
  },
  error:function(){location.reload();}
  }
  );
  }
  });    
</script>
@endsection