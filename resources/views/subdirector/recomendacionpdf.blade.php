@extends('layouts.formato.membreto')
@section('title')RECOMENDACIÓN @endsection
@section('departamento') COMITÉ ACADÉMICO @endsection

@section('contenido')

<p id="titulotres">RECOMENDACIÓN DEL COMITÉ ACADÉMICO PARA {{$datoss->usuario()->solicitantes()}}<br> 
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

@if($datoss->usuario()->esDocente())
<p class="cuerpo">
Por este conducto le informo, que en reunión del Comité Académico, celebrada el {{$fechare}},
y en virtud de haber sido analizada la situación {{$datoss->usuario()->delSolicitante()}} <b><span class="mayuscula">{{$datoss->usuario()->nombre_completo()}}</span></b>,
{{$datoss->usuario()->adscrito()}} al <b><span class="mayuscula">{{$datoss->usuario()->carrera_adscripcion()}}</span></b>, y quien solicita
<span class="mayuscula">{{$datoss->asunto()}}, <b>{{$datoss->respuesta}} se recomienda</b>@if($datoss->observaciones), {{$datoss->observaciones}}@endif @if($datoss->condicion), {{$datoss->condicion}}@endif.</span>
</p> 
@else 
<p class="cuerpo">
Por este conducto le informo, que en reunión del Comité Académico, celebrada el {{$fechare}},
y en virtud de haber sido analizada la situación {{$datoss->usuario()->del()}} <b><span class="mayuscula">C. {{$datoss->usuario()->nombre_completo()}}</span></b>,
que cursa la carrera de <b><span class="mayuscula">{{$datoss->usuario()->carrera_adscripcion()}}</span></b>, con número de control <b>{{$datoss->usuario()->identificador}}</b> y quien solicita
<span class="mayuscula">{{$datoss->asunto()}}, <b>{{$datoss->respuesta}} se recomienda</b>@if($datoss->observaciones), {{$datoss->observaciones}}@endif @if($datoss->condicion), {{$datoss->condicion}}@endif.</span>
</p> 
@endif

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

@endsection