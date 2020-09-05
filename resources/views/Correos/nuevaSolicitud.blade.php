@extends('Correos.correo')
@section('contenido')
<h2>Tienes Solicitudes pendientes de revisar</h2>
<p>Tienes solicitudes que revisar antes de la reunión de Comité Académico</p>
<a class="boton" href="{{url('home')}}" target="_blank">Ver Solicitudes</a>
@endsection 