@extends('Correos.correo')
@section('contenido')
<h2>Tienes dictamenes pendientes de elaborar</h2>
<p>Ingresa al sistema para elaborar los dictamenes que tienes pendientes.</p>
<a class="boton" href="{{url('home')}}" target="_blank">Ingresar</a>
@endsection 