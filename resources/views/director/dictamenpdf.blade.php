@extends('layouts.formato.membreto')
@section('title')DICTAMEN @endsection
@section('departamento') DIRECCIÓN @endsection

@section('contenido')
<br>
<p id="fecha">
Oaxaca de Juarez Oax., <span style="background-color: black; color:white">{{$dictamen->fecha}}</span><br>
OFICIO: {{$dictamen->num_oficio}}<br>
DICTAMEN No. {{$dictamen->num_dictamen}}</p>
<br>
<p id="destinatario">
{{presidente()->nombre_completo()}}<br>
{{presidente()->puesto()}}<br>
PRESENTE
</p>
<p class="cuerpo">
Por este conducto y atendiendo la recomendación del Comité Académico comunico a usted, que 
@if($dictamen->perteneceEstudiante())
con base al análisis realizado a la solicitud presentada por {{$dictamen->usuario()->el_interesado()}} <span class="mayuscula-negrita">{{$dictamen->usuario()->nombre_completo()}}</span>,
con número de control <b>{{$dictamen->usuario()->identificador}}</b> de la carrera de <span class="mayuscula-negrita">{{$dictamen->usuario()->carrera_adscripcion()}}</span>, en la cual solicita
<span class="mayuscula"><?=nl2br($dictamen->asunto())?>,<b> {{$dictamen->respuesta}} se autoriza</b>@if($dictamen->recomendacion->observaciones), {{$dictamen->recomendacion->observaciones}}@endif @if($dictamen->anotaciones),{{$dictamen->anotaciones}}@endif</span>.
</p>
@elseif($dictamen->perteneceDocente())
<span class="mayuscula-negrita">{{$dictamen->respuesta}} se autoriza</span> la solicitud {{$dictamen->usuario()->del_interesado()}} <span class="mayuscula-negrita">{{$dictamen->usuario()->nombre_completo()}}</span>
con referencia a <span class="mayuscula"><?=nl2br($dictamen->asunto())?>@if($dictamen->anotaciones) ,{{$dictamen->anotaciones}}@endif</span>.                 
</p> 
@else
<span class="mayuscula-negrita">{{$dictamen->respuesta}} se autoriza</span> la solicitud del <span class="mayuscula-negrita">{{$dictamen->usuario()->carrera_adscripcion()}}</span>
con referencia a <span class="mayuscula"><?=nl2br($dictamen->asunto())?>@if($dictamen->anotaciones) ,{{$dictamen->anotaciones}}@endif</span>.                 
</p>
@endif
<br> 	 
<table>
<tr>
<td>
<p class="cuerpo">Sin otro asunto que tratar reciba un cordial saludo.</p><br>
<p id="notasdic">
<b>A T E N T A M E N T E</b><br>
<span class="nota">
Excelencia en Educación Tecnológica®<br>
"Tecnología Propia e Independencia Económica"
</span>
</p>
<br><br><br>
<p id="firmadic">
{{director()->nombre_completo()}}<br> 
{{director()->puesto()}}
</p>

<br><br>
<p id="ccp">
C.c.p. Departamento de servicios escolares. Psc. Efectos.<br>
@if(!$dictamen->usuario()->esDepto())
C.c.p. {{$dictamen->usuario()->departamento()}}<br>
@endif
C.c.p. Comité académico<br>
C.c.p. División de estudios profesionales<br>
@if($dictamen->usuario()->esEstudiante())
C.c.p. Coordinación de la carrera<br>
@endif
C.c.p. Interesado<br>
C.c.p. Archivo<br>
<br>
{{director()->iniciales()}}/{{presidente()->iniciales()}}/{{secretario()->iniciales()}}
</p>
</td>
</tr>
</table>
@endsection