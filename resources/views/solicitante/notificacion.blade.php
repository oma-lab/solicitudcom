@extends('layouts.encabezadoSolicitante')
@section('contenido')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">                             
        <div class="card-header">Notificación</div>
        <div class="card-body">
          <div class="alert alert-primary alert-dismissible fade show" role="alert">
           <strong><i class="fa fa-file"></i>{{$noti->descripcion}}</strong><br>
           @if($noti->tipo == "cancelado")
           <strong>OBSERVACIONES:<br>
           {{$noti->observacion}}
           </strong>
           @endif
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection