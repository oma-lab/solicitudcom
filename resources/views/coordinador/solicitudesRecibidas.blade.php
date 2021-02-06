@extends('layouts.encabezadocoor')
@section('contenido')
<section>
<div class="container-fluid">
 <div class="row">
  <div class="col-md-12 text-center ">
   
   <nav class="nav-justified ">
    <div class="nav nav-tabs " id="nav-tab" role="tablist">
      <a class="nav-item nav-link active" aria-selected="true">SOLICITUDES PRÓXIMA REUNIÓN</a>
      <a class="nav-item nav-link" href="{{route('coordinador.solicitudes','finalizadas')}}" aria-selected="false">SOLICITUDES VISTAS EN REUNIÓN</a>                     
    </div>
   </nav>

   <div class="container-fluid">
    <div class="row justify-content-center">
     <div class="col-md-12">
      <div class="card">

       <form id="form" method="GET" action="{{ route('coordinador.solicitudes','pendientes') }}">
         @include('layouts.filtrado.filtro')
       </form>

       <div class="card-body">                    
        <div class="table-responsive">
         @include('layouts.filtrado.mensaje')
         <table class="table">
           <thead class="thead-dark">
            <tr>
             <th scope="col">Solicitud</th>
             <th scope="col">Ver Solicitud</th>
             <th scope="col">Observaciones</th>
             <th scope="col">Enviar</th>
             <th scope="col">Cancelar</th>
            </tr>
           </thead>  
           <tbody>
            @foreach($solicitudes as $sol)
            <form method="POST" action="{{route('envio.solicitud',$sol->id)}}" enctype="multipart/form-data">
            {{ csrf_field()}}
            <tr>
             <td scope="row" width="40%" style="text-align:left">
             {{$sol->user->identificador}} - {{$sol->user->nombre_completo()}}<br>
               {{$sol->user->carrera->nombre}}<br>
               <p style="text-align:justify"><b>{{limitar($sol->asunto)}}</b></p>
             </td>             
             <td class="centrado">
               <a class="navbar-brand" href="{{url('storage/'.$sol->solicitud_firmada)}}" target= "_blank">
                 <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;">
               </a>
             </td>               
             <td>
               <textarea class="form-control rounded-0" name="descripcion" rows="4" placeholder="Observaciones para comité académico" >{{$sol->descripcion}}</textarea>
             </td>
             @if(!request('visto'))
             <td>
               <button type="submit" class="btn btn-primary d-block mx-auto btn-sm">Enviar Solicitud</button>
             </td>             
             <td>
               <button type="button" class="btn btn-danger btn-sm" title="clic para regresar la solicitud al estudiante" onclick="cancel({{$sol->id}})">
                <i class="fa fa-window-close"></i> Cancelar
               </button><br>
               <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalayuda">
                      <span class="fa fa-question-circle"  aria-hidden="true">ayuda</span>
               </button>
             </td>
             @endif
            </tr>
           </form>
           @endforeach             
          </tbody>
        </table>
        {{$solicitudes->appends(Request::only(['visto','carrera_id','numc','nombre']))->links()}}
       </div>
      </div>

     </div>
    </div>
   </div>
  </div>

   <!-- Modal -->
   <form method="POST" action="{{route('solicitud.cancelar')}}" enctype="multipart/form-data">
   {{ csrf_field()}} 
   <div class="modal fade" id="modalcancelar" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
      <div class="modal-header">
       <h5>Observaciones para el estudiante</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
       </button>
      </div>
      <div class="modal-body"> 
       <input type="hidden" id="id_sol" name="id_sol" value="">
       <div class="form-row">
        <div class="form-group col-md-12">
         <label for="obs_est">Observación:</label>
         <textarea class="form-control" id="obs_est" rows="2" name="obs_est" placeholder="Observaciones que serán enviadas al solicitante" required></textarea>
        </div>
       </div>
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
       <button type="submit" class="btn btn-primary">Enviar</button>        
      </div>
    </div>
   </div>
   </div>
   </form>
   <!-- Fin Modal -->

   <!-- Modal -->
   <div class="modal fade" id="modalayuda">
    <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
      <div class="modal-body">
      <h5>Información sobre las acciones de los botones</h5>
       <p>.-Presione el boton <button class="btn btn-primary btn-sm">Enviar Solicitud</button> cuando este seguro de que la solicitud es correcta y asi enviarla a los jefes de departamento.</p><br>
       .-Presione el boton <button class="btn btn-danger btn-sm"><i class="fa fa-window-close"></i> Cancelar</button> cuando la solicitud tenga datos erroneos y asi poder mandarla de regreso al estudiante para que pueda corregir si es necesario.
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>     
      </div>
    </div>
   </div>
   </div>
   <!-- Fin Modal -->
  </div>
 </div>
</div>
</section>
@endsection


@section('script')
<script>
window.addEventListener("load", function(){
    document.getElementById('filtro').style.display = "block";
});

function cancel(solid){
  $("#id_sol").val(solid);
  $("#modalcancelar").modal("show"); 
}
</script>
@endsection