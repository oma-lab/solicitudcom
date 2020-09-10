@extends('layouts.formato.membreto')
@section('title')RECOMENDACIÓN @endsection
@section('departamento') COMITÉ ACADÉMICO @endsection

@section('contenido')

<h6 id="titulo">RECOMENDACIÓN DEL COMITÉ ACADÉMICO PARA {{$datoss->usuario()->solicitantes()}}<br> 
TECNOLÓGICO NACIONAL DE MÉXICO/INSTITUTO TECNOLÓGICO DE OAXACA
</h6>
<br>

<p id="fecha">
Oaxaca de Juarez Oax., {{$datoss->fecha}}<br>
OFICIO: {{$datoss->num_oficio}}<br>
No. de Recomendación: {{$datoss->num_recomendacion}}<br>
</p>
<h6 id="destinatario">
{{director()->nombre_completo()}}.<br>
{{director()->puesto()}} DEL INSTITUTO TECNOLÓGICO DE OAXACA<br>
PRESENTE
</h6>

@if($datoss->usuario()->esDocente())
<p class="cuerpo">
Por este conducto le informo, que en reunión del Comité Académico, celebrada el {{$fechare}},
y en virtud de haber sido analizada la situación {{$datoss->usuario()->delSolicitante()}} {{$datoss->usuario()->nombre_completo()}},
{{$datoss->usuario()->adscrito()}} al <span class="minuscula">{{$datoss->usuario()->carrera_adscripcion()}}</span>, y quien solicita
{{$datoss->asunto()}}, <span class="minuscula">{{$datoss->respuesta}}</span> se recomienda, {{$datoss->asunto()}}@if($datoss->condicion),{{$datoss->condicion}}@endif.
</p> 
@else 
<p class="cuerpo">
Por este conducto le informo, que en reunión del Comité Académico, celebrada el {{$fechare}},
y en virtud de haber sido analizada la situación {{$datoss->usuario()->del()}} C. {{$datoss->usuario()->nombre_completo()}},
que cursa la carrera de <span class="minuscula">{{$datoss->usuario()->carrera_adscripcion()}}</span>, con número de control {{$datoss->usuario()->identificador}} y quien solicita
{{$datoss->asunto()}}, <span class="minuscula">{{$datoss->respuesta}}</span> se recomienda, {{$datoss->asunto()}}@if($datoss->condicion),{{$datoss->condicion}}@endif.
</p> 
@endif

@if($datoss->motivos)
<p class="cuerpo">Por los siguientes motivos: {{$datoss->motivos}}.</p> 
@endif
<br>

<p id="firmarec">
<b>A T E N T A M E N T E</b><br>
<span class="nota">
Excelencia en Educación Tecnológica<br>
"Tecnología Propia e Independencia Económica"
</span>
<br><br><br><br>
<span class="mayuscula"><b>
{{presidente()->nombre_completo()}}<br>
{{presidente()->puesto_presidente()}}</b>
</span>
</p>

<p id="ccp">
C.c.p. Dirección<br>
C.c.p. Archivo<br><br>
{{presidente()->iniciales()}}/{{secretario()->iniciales()}}
</p>

@endsection