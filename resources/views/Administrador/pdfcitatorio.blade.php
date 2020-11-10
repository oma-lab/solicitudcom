@extends('layouts.formato.membreto')
@section('title') CITATORIO @endsection
@section('departamento') Comité Académico @endsection

@section('contenido')

   <p id="fecha">
   Oaxaca de Juárez Oax.,{{fecha($citatorio->fecha)}}<br>
   OFICIO: {{$citatorio->oficio}}<br><br>
   <b>ASUNTO: CITATORIO</b>
   </p>
   <br>
   <p id="destinatario">
   CC. JEFES Y JEFAS DE DEPARTAMENTO Y DIVISIÓN,<br>
   INTEGRANTES DEL COMTÉ ACADÉMICO.<br>
   PRESENTES.
   </p>

   <p class="cuerpo">
   Por este medio me permito citarlos con carácter de obligatorio, a la {{$citatorio->reunion()}}, 
   la cual se llevará a cabo el día {{$fecha}} del año en curso, en 
   {{$citatorio->calendario->lugar}}, en punto de las {{hora($citatorio->calendario->hora)}} horas.
   </p>

   <p class="cuerpo">
   {{presidente()->sabedor()}} del compromiso institucional de cada uno de ustedes y no dudando de su puntual
   asistencia, me despido no sin antes enviarles un cordial saludo.
   </p>
   <br>

   <p id="firmarec">
   <b>A T E N T A M E N T E</b><br>
   <span class="nota">
   Excelencia en Educación Tecnológica®<br>
   "Tecnología Propia e Independencia Económica"
   </span>  
   </p>
   <br><br><br>
   <table>
    <tr>
	 <td>
	  <p id="firma"><span class="mayuscula">{{presidente()->nombre_completo()}}<br> 
		{{presidente()->puesto_presidente()}}</span></p>
     </td>
	 <td>
	  <p id="firma"><span class="mayuscula">{{secretario()->nombre_completo()}}<br> 
	   {{secretario()->puesto()}}</span></p>
	 </td>
	</tr>
   </table><br>



   <p id="ccp">
   @if(jefeServicios())
   C.c.p. {{jefeServicios()->puesto()}}<br>
   @endif
   @if(jefeDivision())
   C.c.p. {{jefeDivision()->puesto()}}<br>
   @endif
   @if(jefeDesarrollo())
   C.c.p. {{jefeDesarrollo()->puesto()}}<br>
   @endif
   C.c.p. jefes de Departamento Académico<br>
   C.c.p. archivo<br>
   <br>
   {{presidente()->iniciales()}}/{{secretario()->iniciales()}}
   </p>

@endsection