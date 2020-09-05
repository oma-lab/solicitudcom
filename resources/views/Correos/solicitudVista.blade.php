@extends('Correos.correo')
@section('contenido')
<h2>Tu solicitud ha sido revisada en la reunión de Comité Académico</h2>
<p>
Mantente al pendiente en la página web de Comité Académico, para conocer el proceso de tu solicitud
y cuando tu dictamen tenga una respuesta.
</p>  
<p>
 Nombre: {{$solicitud->user->nombre_completo()}}<br>
 Asunto: {{$solicitud->asunto}}<br>
 {{$solicitud->user->tipo_carrera_adscripcion()}}: {{$solicitud->user->carrera_adscripcion()}}<br>
 {{$solicitud->user->tipo_id()}}: {{$solicitud->user->identificador}}<br>
</p>
<a class="boton" href="{{url('home')}}" target="_blank">Ir a la página</a>
@endsection 