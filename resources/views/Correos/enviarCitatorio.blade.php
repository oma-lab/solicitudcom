@extends('Correos.correo')
@section('contenido')
<h2>Citatorio de Reunión</h2>
<p>
  Día: {{Carbon\Carbon::parse($citatorio->fecha)->format('d/m/Y')}}<br>
  Hora: {{Carbon\Carbon::parse($citatorio->calendario->hora)->format('H:i')}} horas.<br>
  Asunto: {{$citatorio->calendario->title}}
</p>
<a class="boton" href="{{ url('storage/'.$citatorio->archivo)}}" target="_blank">Ver Citatorio</a>
@endsection