@extends('layouts.formato.membreto')
@section('title')RECOMENDACIÓN @endsection
@section('departamento') COMITÉ ACADÉMICO @endsection

@section('contenido')
@if(!$datoss->usuario()->esDepto())
<p id="titulotres">RECOMENDACIÓN DEL COMITÉ ACADÉMICO PARA {{$datoss->usuario()->solicitantes()}}<br>
@else
<p id="titulotres">RECOMENDACIÓN DEL COMITÉ ACADÉMICO PARA DEPARTAMENTOS DEL<br>
@endif
TECNOLÓGICO NACIONAL DE MÉXICO/INSTITUTO TECNOLÓGICO DE OAXACA
</p>
<br>

<p id="fecha">
Oaxaca de Juarez Oax., <span style="background-color: black; color:white">{{$datoss->fecha}}</span><br>
OFICIO: {{$datoss->num_oficio}}<br>
No. de Recomendación: {{$datoss->num_recomendacion}}<br>
</p>
<br><br>
<p id="destinatario">
{{director()->nombre_completo()}}.<br>
{{director()->puesto()}} DEL INSTITUTO TECNOLÓGICO DE OAXACA<br>
PRESENTE
</p>

@if($datoss->usuario()->esEstudiante())
<p class="cuerpo">
Por este conducto le informo, que en reunión del Comité Académico, celebrada el {{$fechare}},
y en virtud de haber sido analizada la situación {{$datoss->usuario()->del()}} <span class="mayuscula-negrita">C. {{$datoss->usuario()->nombre_completo()}}</span>,
que cursa la carrera de <span class="mayuscula-negrita">{{$datoss->usuario()->carrera_adscripcion()}}</span>, con número de control <b>{{$datoss->usuario()->identificador}}</b> y quien solicita
<span class="mayuscula"><?=nl2br($datoss->asunto())?>, <b>{{$datoss->respuesta}} se recomienda</b>@if($datoss->observaciones), {{$datoss->observaciones}}@endif @if($datoss->condicion), {{$datoss->condicion}}@endif.</span>
</p>
@elseif($datoss->usuario()->esDocente())
<p class="cuerpo">
Por este conducto le informo, que en reunión del Comité Académico, celebrada el {{$fechare}},
y en virtud de haber sido analizada la situación {{$datoss->usuario()->delSolicitante()}} <span class="mayuscula-negrita">{{$datoss->usuario()->nombre_completo()}}</span>,
{{$datoss->usuario()->adscrito()}} al <span class="mayuscula-negrita">{{$datoss->usuario()->carrera_adscripcion()}}</span>, y quien solicita
<span class="mayuscula"><?=nl2br($datoss->asunto())?>, <b>{{$datoss->respuesta}} se recomienda</b>@if($datoss->observaciones), {{$datoss->observaciones}}@endif @if($datoss->condicion), {{$datoss->condicion}}@endif.</span>
</p> 
@else
<p class="cuerpo">
Por este conducto le informo, que en reunión del Comité Académico, celebrada el {{$fechare}},
y en virtud de haber sido analizada la situación del <span class="mayuscula-negrita">{{$datoss->usuario()->carrera_adscripcion()}}</span>, y quien solicita
<span class="mayuscula"><?=nl2br($datoss->asunto())?>, <b>{{$datoss->respuesta}} se recomienda</b>@if($datoss->observaciones), {{$datoss->observaciones}}@endif @if($datoss->condicion), {{$datoss->condicion}}@endif.</span>
</p> 
@endif
<table>
<tr>
<td>
@if($datoss->motivos)
<p class="cuerpo">Por los siguientes motivos: {{$datoss->motivos}}.</p> 
@endif
<br>

<p id="notas">
<b>A T E N T A M E N T E</b><br>
<span class="nota">
Excelencia en Educación Tecnológica®<br>
"Tecnología Propia e Independencia Económica"
</span>
</p>
<br><br><br>
<p id="firmarec">
{{presidente()->nombre_completo()}}<br>
{{presidente()->puesto_presidente()}}
</p>
<br><br>
<p id="ccp">
C.c.p. Dirección<br>
C.c.p. Archivo<br><br>
{{presidente()->iniciales()}}/{{secretario()->iniciales()}}
</p>
</td>
</tr>
</table>
@endsection