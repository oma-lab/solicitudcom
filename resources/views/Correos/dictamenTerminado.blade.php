@extends('Correos.correo')
@section('contenido')
<h2>Tu Dictamen ya tiene una respuesta </h2>
<p>Tu dictamen se ha realizado, Para obtener una copia lo puedes hacer ingresando al sistema de Comité Académico en la opcion de Dictamen. O si deseas una copia física pasa con tu coordinador de carrera</p>
<p>
 Nombre: {{$solicitud->user->nombre_completo()}}<br>
 Asunto: {{$solicitud->asunto}}<br>
 {{$solicitud->user->tipo_carrera_adscripcion()}}: {{$solicitud->user->carrera_adscripcion()}}<br>
 {{$solicitud->user->tipo_id()}}: {{$solicitud->user->identificador}}<br>
</p>
<a class="boton" href="{{url('mostrar/dictamen')}}" target="_blank">Ver</a>
@endsection 