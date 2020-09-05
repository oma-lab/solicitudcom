@extends('Correos.correo')
@section('contenido')
<h2>Tu Dictamen ya tiene una respuesta </h2>
<p>Puedes recoger tu dictamen con el jefe de departamento de tu carrera.</p>
<p>
 Nombre: {{$solicitud->user->nombre_completo()}}<br>
 Asunto: {{$solicitud->asunto}}<br>
 {{$solicitud->user->tipo_carrera_adscripcion()}}: {{$solicitud->user->carrera_adscripcion()}}<br>
 {{$solicitud->user->tipo_id()}}: {{$solicitud->user->identificador}}<br>
</p>
<a class="boton" href="{{url('home')}}" target="_blank">Ver</a>
@endsection 