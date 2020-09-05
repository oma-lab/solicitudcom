@extends('layouts.formato.membreto')
@section('title')Solicitud {{$usuario->solicitante()}} @endsection
@section('departamento') División de Estudios Profesionales @endsection

@section('contenido')

<h6 id="titulo">"Solicitud {{$usuario->delSolicitante()}} para el análisis del Comité Académico"<br> 
INSTITUTO TECNOLÓGICO DE OAXACA
</h6>
<br>

<p id="fecha">Oaxaca de Juárez Oax, a {{fecha($solicitud->fecha)}}</p><br>
<h6 id="destinatario">
{{jefeDivision()->nombre_completo()}}<br>
{{jefeDivision()->puesto()}}<br>
P R E S E N TE
</h6>
<br>

<h6 id="asunto"><b>Asunto:</b>Solicitud al Comité Académico<br></h6>
  
<p class="cuerpo">El que suscribe C. {{$usuario->nombre_completo()}}
@if($usuario->esEstudiante())
estudiante del {{$solicitud->semestre}} semestre, de la carrera de <span class="minuscula">{{ $solicitud->carrera()}}</span> con número de control {{$usuario->identificador }}, 
@else
{{$usuario->solicitante()}} de la carrera de <span class="minuscula">{{$solicitud->carrera()}}</span>, 
@endif
solicito de la manera más atenta {{$solicitud->asunto}}.
</p>

<p class="cuerpo">
Por los siguientes motivos:<br>
Motivos académicos: {{$solicitud->motivos_academicos()}}<br>
Motivos personales: {{$solicitud->motivos_personales()}}<br> 
Otros: {{$solicitud->otros_motivos()}}
</p>

<p id="firma">
Atentamente<br><br><br>
{{$usuario->nombre_completo()}}<br>
Nombre y firma {{$usuario->delSolicitante()}}
</p>

<p id="cel">
Telefono:{{$usuario->telefono}} &nbsp;&nbsp; Celular:{{$usuario->celular}}
</p>

<p id="ccp">
@if($usuario->esEstudiante())
C.c.p. Coordinador de la carrera.<br>
@endif
C.c.p. Jefe de Departamento Académico<br>
C.c.p. {{subdirector_academico_presidente()}}<br>
C.c.p. Servicios Escolares<br>
C.c.p. Interesado<br>
   </p>
@endsection