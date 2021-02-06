@extends('layouts.formato.membreto')
@section('title')Solicitud {{$usuario->solicitante()}} @endsection
@section('departamento') División de Estudios Profesionales @endsection

@section('contenido')

<p id="titulo" style="margin-bottom:0px;">"Solicitud {{$usuario->delSolicitante()}} para el análisis del Comité Académico"</p> 
<p id="titulodos">INSTITUTO TECNOLÓGICO DE OAXACA</p>
<br>
<p id="fecha">Oaxaca de Juárez Oax, a {{fecha($solicitud->fecha)}}</p>
<br>
<p id="destinatario">
{{jefeDivision()->nombre_completo()}}<br>
{{jefeDivision()->puesto()}}<br>
P R E S E N TE
</p>

<p id="asunto"><b>Asunto:</b>Solicitud al Comité Académico<br></p>
  
@if($usuario->esEstudiante())
<p class="cuerpo" style="line-height: 9pt;">El que suscribe <span class="mayuscula-negrita">C. {{$usuario->nombre_completo()}}</span>
estudiante del <b>{{$solicitud->semestre}}</b> semestre, de la carrera de <span class="minuscula-negrita">{{ $solicitud->carrera()}}</span> con número de control <b>{{$usuario->identificador }}</b>, 
@elseif($usuario->esDocente())
<p class="cuerpo" style="line-height: 9pt;">El que suscribe <span class="mayuscula-negrita">C. {{$usuario->nombre_completo()}}</span>
{{$usuario->solicitante()}} de la carrera de <span class="minuscula-negrita">{{$solicitud->carrera()}}</span>, 
@else
<p class="cuerpo" style="line-height: 9pt;">El que suscribe <span class="mayuscula-negrita">{{$usuario->nombre_adscripcion()}}</span>,
@endif
solicito de la manera más atenta <span class="mayuscula-negrita"><?=nl2br($solicitud->asunto)?></span>.
</p>

<p class="cuerpo">
Por los siguientes motivos:<br><br>
<b>Motivos académicos:</b> <span class="minuscula">{{$solicitud->motivos_academicos()}}</span></p>
<p class="cuerpo"><b>Motivos personales:</b> <span class="minuscula">{{$solicitud->motivos_personales()}}</span></p>
<table>
<tr>
<td>
<p class="cuerpo"><b>Otros:</b> <span class="minuscula">{{$solicitud->otros_motivos()}}</span></p>
<p id="firma">
Atentamente<br><br><br>
<span class="mayuscula">@if($usuario->esDepto()) {{$usuario->carrera_adscripcion()}} @else {{$usuario->nombre_completo()}} @endif</span><br>
Nombre y firma {{$usuario->delSolicitante()}}
</p><br>

<p id="ccp">
<b>Telefono:{{$usuario->telefono}} &nbsp;&nbsp; Celular:{{$usuario->celular}}</b><br><br>
@if($usuario->esEstudiante())
C.c.p. Coordinador de la carrera.<br>
@endif
C.c.p. Jefe de Departamento Académico<br>
C.c.p. {{subdirector_academico_presidente()}}<br>
C.c.p. Servicios Escolares<br>
C.c.p. Interesado
</p>
</td>
</tr>
</table>
@endsection