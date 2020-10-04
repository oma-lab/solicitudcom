@extends('layouts.encabezadoAdmin')
@section('contenido')

<div class="container-fluid">
@include('layouts.filtrado.mensaje')

 <div class="row justify-content-center">

  
  <div class="col-md-10">
  <form class="form-inline" method="POST" action="{{route('posponer')}}" enctype="multipart/form-data">
  {{csrf_field()}}    
   <div class="card">
   <b>POSPONER SOLICITUDES</b>
    <div class="card-header">
       <label>Se muestran solicitudes de la reunión:<label>
       <select class="filtro form-control mr-sm-2" name="reunion" required>
         @foreach($proximas as $prox)
         <option value="{{$prox->id}}" {{($prox['id'] == $reunion) ? 'selected' : '' }}>{{fecha($prox->start)}}</option>
         @endforeach
         @foreach($pasadas as $pas)
         <option value="{{$pas->id}}"  {{($pas['id'] == $reunion) ? 'selected' : '' }}>{{fecha($pas->start)}}</option>
         @endforeach
       </select>
       <label>Posponer a la reunión:</label>
       <select class="form-control mr-sm-2" name="nueva_reunion" required>
         <option value="">Seleccione</option>
         @foreach($proximas as $prox)
         <option value="{{$prox->id}}">{{fecha($prox->start)}}</option>
         @endforeach
         @foreach($pasadas as $pas)
         <option value="{{$pas->id}}">{{fecha($pas->start)}}</option>
         @endforeach
       </select>
       <button class="btn btn-outline-success my-2 my-sm-0" type="input">Realizar</button>   
    </div>          
    <div class="card-body">
      <table class="table table-sm">
        <thead>
         <tr>
          <th scope="col">Solicitud</th>
          <th width="120px" scope="col"><label><input type="checkbox" onclick="seleccionar(this);">Marcar todos</label></th>
         </tr>
        </thead>
        <tbody>
        @foreach($solicitudes as $solicitud)
         <tr>
          <td>{{$solicitud->asunto}}</td>
          <td><input class="solicitudes" type="checkbox" name="solicitudes[]" value="{{$solicitud->id}}"></td>
         </tr>
        @endforeach
        </tbody>
      </table>
    </div>
   </div>
   </form>
  </div>

 </div>
</div>
<form id="form" method="GET" action="{{route('vista.posponer')}}">
  <input id="reunion" name="reunion" type="hidden" value="">
</form>
@endsection

@section('script')
<script>
//seleccionar todas las solicitudes
 function seleccionar(check){
   $(".solicitudes").prop("checked", check.checked); 
 }
//llama a form que filtrara las solicitudes por reunion
 $('.filtro').change(function(){
    $('#reunion').val($(this).val());
    $('#form').submit();
});
</script>
@endsection