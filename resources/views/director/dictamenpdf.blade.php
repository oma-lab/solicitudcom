@extends('layouts.formato.membreto')
@section('title')DICTAMEN @endsection
@section('departamento') DIRECCIÓN @endsection

@section('contenido')

<p id="fecha">
Oaxaca de Juarez Oax., {{$dictamen->fecha}}<br>
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
@if($dictamen->perteneceDocente())
<b><span class="minuscula">{{$dictamen->respuesta}} se autoriza</span></b> la solicitud {{$dictamen->usuario()->del_interesado()}} <b><span class="mayuscula">{{$dictamen->usuario()->nombre_completo()}}</span></b>
con referencia a <b>{{$dictamen->asunto()}}</b>@if($dictamen->anotaciones) ,{{$dictamen->anotaciones}}@endif.                 
</p> 
@else 
con base al análisis realizado a la solicitud presentada por {{$dictamen->usuario()->el_interesado()}} <b><span class="mayuscula">{{$dictamen->usuario()->nombre_completo()}}</span></b>,
con número de control <b>{{$dictamen->usuario()->identificador}}</b> de la carrera de <b>{{$dictamen->usuario()->carrera_adscripcion()}}</b>, en la cual solicita
<b>{{$dictamen->asunto()}}</b>,<b><span class="minuscula"> {{$dictamen->respuesta}} se autoriza</span></b>, <b>{{$dictamen->asunto()}}</b>@if($dictamen->anotaciones) ,{{$dictamen->anotaciones}}@endif.
</p> 
@endif
<p class="cuerpo">Sin otro asunto que tratar reciba un cordial saludo.</p>
<br> 	 

<p id="firmadic">
<b>A T E N T A M E N T E</b><br>
<span class="nota">
Excelencia en Educación Tecnológica®<br>
"Tecnología Propia e Independencia Económica"
</span>
<br><br><br><br><br>
<span class="mayuscula"><b>
{{director()->nombre_completo()}}<br> 
{{director()->puesto()}}</b>
</span>
</p>

<br>
<p id="ccp">
C.c.p. Departamento de servicios escolares<br>
C.c.p. {{$dictamen->usuario()->departamento()}}<br>
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

@endsection