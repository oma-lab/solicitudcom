@extends('Correos.correo')
@section('contenido')
<h2>Tu solicitud ha sido cancelada</h2>
<p>Tu solicitud no pudo continuar, revisa las observaciones hechas por las cuales no procede, 
  si se necesitan cambios hazlos y envia nuevamente.
</p>
<p>
 <b>Observaciones a tu solicitud:<br>
 {{$observacion}}</b>
</p>
<p>
 Nombre: {{$solicitud->user->nombre_completo()}}<br>
 Asunto: {{$solicitud->asunto}}<br>
 {{$solicitud->user->tipo_carrera_adscripcion()}}: {{$solicitud->user->carrera_adscripcion()}}<br>
 {{$solicitud->user->tipo_id()}}: {{$solicitud->user->identificador}}<br>
</p>
<a class="boton" href="{{url('home')}}" target="_blank">Ver</a>
@endsection 