@extends('layouts.formato.membreto')
@section('title')Solicitud {{$usuario->solicitante()}} @endsection
@section('departamento') División de Estudios Profesionales @endsection

@section('contenido')

<p id="titulo">"Solicitud {{$usuario->delSolicitante()}} para el análisis del Comité Académico"<br> 
INSTITUTO TECNOLÓGICO DE OAXACA
</p>
<br>

<p id="fecha">Oaxaca de Juárez Oax, a {{fecha($solicitud->fecha)}}</p><br>
<p id="destinatario">
{{jefeDivision()->nombre_completo()}}<br>
{{jefeDivision()->puesto()}}<br>
P R E S E N TE
</p>

<p id="asunto"><b>Asunto:</b>Solicitud al Comité Académico<br></p>
  
<p class="cuerpo">El que suscribe <b><span class="mayuscula">C. {{$usuario->nombre_completo()}}</span></b>
@if($usuario->esEstudiante())
estudiante del <b>{{$solicitud->semestre}}</b> semestre, de la carrera de <b><span class="minuscula">{{ $solicitud->carrera()}}</span></b> con número de control <b>{{$usuario->identificador }}</b>, 
@else
{{$usuario->solicitante()}} de la carrera de <b><span class="minuscula">{{$solicitud->carrera()}}</span></b>, 
@endif
solicito de la manera más atenta <b><span class="mayuscula">{{$solicitud->asunto}}</span></b>.
</p>

<p class="cuerpo">
Por los siguientes motivos:<br>
<b>Motivos académicos:</b> <span class="minuscula">{{$solicitud->motivos_academicos()}}</span><br>
<b>Motivos personales:</b> <span class="minuscula">{{$solicitud->motivos_personales()}}</span><br> 
<b>Otros:</b> <span class="minuscula">{{$solicitud->otros_motivos()}}</span>
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