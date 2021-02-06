@extends('layouts.encabezadoSolicitante')
@section('estilos')
<link href="{{ asset('css/seguimiento.css') }}" rel="stylesheet">
@endsection
@section('contenido')
<div class="container-fluid">
 <div class="row justify-content-center">
  <div class="col-md-12">
   <div class="card">
    @include('layouts.filtrado.mensaje')
    @if(count($soli) > 0)
    @if(!$soli->first()->enviado)
    <b id="info" style="color:red"></b>
    <div class="alert alert-success" id="pasos">Solicitud pendiente de enviar, para enviar tu solicitud sigue los siguientes pasos:<br>
    1.-Descarga tu solicitud dando click en el icono <img src="{{ asset('imagenes/ver.png') }}" style="width:20px;"> de abajo<br>
    2.-Imprime tu solicitud, firma y escanea junto con tus evidencias en formato PDF<br>
    3.-Sube tu solicitud firmada con tus evidencias dando click en el icono <img src="{{ asset('imagenes/subir.png')}}" style="width:20px;"> de abajo<br>
    4.-Para terminar con el proceso de envío da click en el boton enviar<br>
    5.-Mantente pendiente en esta página para recibir informacion sobre tu solicitud, te notificaremos cuando puedas recoger tu dictamen.                    
    </div>
    @endif
    @endif                      
    <div class="card-header">HISTORIAL 
     <b style="color:blue">Pulse un icono para realizar una acción</b></div>
      <div class="card-body">
       <div class="table-responsive">                   
        <table class="table table-hover">
        <thead class="thead-dark">
          <tr>
           <th scope="col">Asunto</th>
           <th scope="col">Ver/Descargar Formato</th>
           <th scope="col">Modificar Formato</th>      
           <th scope="col">Subir Formato Firmado</th>
           <th scope="col">Ver archivo subido</th>
           <th scope="col">Eliminar</th>
           <th scope="col">Enviar</th>
           <th scope="col">Seguimiento de Solicitud</th>
          </tr>
        </thead>  
        <tbody>
         @foreach($soli as $sol)
        <tr>
         <th width="30%" scope="row"><p style="text-align:justify;text-transform: lowercase;">{{limitar($sol->asunto)}}</p></th>
         <td class="centrado">
           <a class="navbar-brand" href="{{route('ver.solicitud',$sol->id)}}" target= "_blank">
           <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;">
           </a>
         </td>
         <td class="centrado">
           @if(!$sol->enviado)
           <a class="navbar-brand" href="{{route('editar.solicitud',$sol->id)}}">
           <img src="{{ asset('imagenes/editar.png') }}" style="width:35px;">
           </a> 
           @endif         
         </td>
         <td class="centrado">
            @if(!$sol->enviado)
            <input type="image" src="{{ asset('imagenes/subir.png')}}" style="width:35px;" onclick="subirfile('/solicitud/{{$sol->id}}');"><br>
            <a style="color:{{($sol->solicitud_firmada) ? 'green' : 'red'}};"><b>{{($sol->solicitud_firmada) ? '' : 'Sube aqui tu archivo'}}</b></a>
            @endif
         </td>
         <td class="centrado">
            @if($sol->solicitud_firmada)
            <a class="navbar-brand" href="{{ url('storage/'.$sol->solicitud_firmada)}}" target= "_blank">
              <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;">
            </a><br>
            <b style="color:green;">Tienes un archivo cargado, ya puedes enviar</b>
            @else
            <b style="color:red;">No tienes archivos cargados</b>
            @endif
         </td>
         <td class="centrado">     
           @if(!$sol->enviado)       
           <form method="post" action="{{route('eliminar.solicitud',$sol->id)}}">
           {{csrf_field()}}
           {{method_field('DELETE')}}
           <input type="image" name="boton" src="{{ asset('imagenes/eliminar.png')}}" style="width:35px;" onClick='return confirm("¿Está seguro que desea eliminar esta solicitud?")'>
           </form>
           @endif
         </td>
         <td class="centrado">
           @if(!$sol->enviado)
           <a class="navbar-brand" href="{{route('enviar.solicitud',$sol->id)}}">
             <button class="btn btn-success">Enviar</button>
           </a>
           @endif
         </td>
         <td class="centrado">
           @if($sol->enviado)
           <img src="{{ asset('imagenes/seguimiento.png') }}" style="width:35px; cursor:pointer;" data-toggle="modal" data-target="#modalseg{{$sol->id}}">
           <!-- Modal -->
           <div class="modal fade" id="modalseg{{$sol->id}}" tabindex="-1" role="dialog" aria-labelledby="segmodaltitle{{$sol->id}}" aria-hidden="true">
             <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
               <div class="modal-content">
                 <div class="modal-header">
                   <h5 class="modal-title" id="segmodaltitle{{$sol->id}}">SEGUIMIENTO DE SOLICITUD</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                   </button>
                 </div>
                 <div class="modal-body">
                    @include('solicitante.seguimiento')
                 </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                 </div>
               </div>
             </div>
           </div>
           <!--Fin Modal -->
           @endif
         </td>
        </tr>    
        @endforeach
        </tbody>
        </table>
       </div>
      </div>
   </div>
  </div>
 </div>
</div>
                                 
@include('layouts.modals.file')
@endsection
@section('script')
<script src="{{ asset('js/solicitud.js') }}"></script>
<script src="{{ asset('js/seguimiento.js')}}" defer></script>
<script src="{{ asset('js/file.js') }}"></script>
@endsection
