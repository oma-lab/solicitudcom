@extends('layouts.formato.membreto')
@section('title') ORDEN DEL DIA @endsection
@section('departamento') Comité Académico @endsection

@section('contenido')

   <br><br>
   <p id="tituloorden"><u>REUNIÓN DE COMITÉ ACADÉMICO</u><br> 
   Oaxaca de Juárez, Oax., a {{fechaLetraAnio($citatorio->fecha)}}.<br>
   </p>
   <br>
   <p id="destinatario">
   CC. INTEGRANTES DEL COMITÉ ACADÉMICO<br>
   P R E S E N T E S
   </p>

   <p class="cuerpo">
   Por este medio hago de su conocimiento el orden del día de la Reunión de Comité Académico, que 
   se llevará a cabo el día {{$fecha}} del año en curso, a las {{hora($citatorio->calendario->hora)}} 
   horas {{$citatorio->calendario->lugar}}.<br><br>
   ORDEN DEL DÍA<br><br>
   @foreach($ordends as $orden)
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$loop->iteration}}. {{$orden}}<br>
   @endforeach
   </p>

   <p class="cuerpo">
   No dudando de su puntual asistencia, quedamos de ustedes.
   </p>
   <br>

   <p id="notas">
   <b>A T E N T A M E N T E</b><br>
   <span class="nota">
   Excelencia en Educación Tecnológica®<br>
   "Tecnología Propia e Independencia Económica"
   </span>  
   </p>
   <br><br><br><br>
   <table>
    <tr>
	 <td>
	  <p id="firma"><span class="mayuscula">{{presidente()->nombre_completo()}}<br> 
		{{presidente()->puesto_presidente()}}</span></p>
     </td>
	 <td>
	  <p id="firma"><span class="mayuscula">{{secretario()->nombre_completo()}}<br> 
	   {{secretario()->puesto_secretario_comite()}}</span></p>
	 </td>
	</tr>
   </table><br>


@endsection