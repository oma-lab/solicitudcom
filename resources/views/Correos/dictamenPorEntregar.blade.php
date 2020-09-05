@extends('Correos.correo')
@section('contenido')
<h2>Tienes dictamenes por entregar</h2>
<p>Tienes dictamenes pendientes que debes entregar en los departamentos de carrera.</p>
<a class="boton" href="{{url('home')}}" target="_blank">Ingresar</a>
@endsection 