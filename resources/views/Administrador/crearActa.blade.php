@extends('layouts.encabezadoAdmin')
@section('contenido')
<div class="container">
<form method="POST" action="{{route('acta.store')}}" enctype="multipart/form-data">
{{ csrf_field()}}
<div class="row justify-content-center">
  <div class="form-group col-md-9">
    <input id="titulo" type="text" class="form-control form-control-sm centrado" name="titulo" value="ACTA DE REUNIÓN ORDINARIA DE COMITÉ ACADÉMICO">
    <input type="hidden" name="calendario_id" value="{{$reunion->id}}">
  </div>
</div>  
<div class="row justify-content-center">
<div class="form-group col-md-9">
<textarea class="form-control" id="contenido" rows="40" cols="5" name="contenido" style="text-transform: uppercase;">  
EN LA CIUDAD DE OAXACA DE JUÁREZ OAXACA, SIENDO LAS {{hora($reunion->hora)}} HORAS DEL DÍA {{fechaLetraAnio($reunion->start)}}, REUNIDOS EN LA SALA DE JUNTAS DE LA DIRECCIÓN DEL INSTITUTO TECNOLÓGICO, UBICADO EN VICTOR BRAVO AHUJA No.125, ESQUINA CALZADA TECNOLÓGICO, COLONIA CENTRO, OAXACA DE JUÁREZ, OAXACA, LOS CIUDADANOS:
{{grado_nombre_puesto_presidente()}}; @foreach($asistentes as $asistente) {{$asistente->user->grado_nombre_puesto()}}; @endforeach TODOS INTEGRANTES DEL COMITÉ ACADÉMICO @if($invitados->count())E INVITADOS: @foreach($invitados as $invitado) {{$invitado->nombre_puesto()}} @endforeach @endif; SE REÚNEN PARA ATENDER CADA UNO DE LOS PUNTOS DEL SIGUIENTE ORDEN DEL DÍA
1. PASE DE LISTA.
2. LECTURA DEL ACTA ANTERIOR.
3. REVISIÓN DE CASOS.
4. ASUNTOS GENERALES.
{{nombre_puesto_presidente()}} , DIÓ LA BIENVENIDA Y AGRADECIÓ LA ASISTENCIA DE LOS PARTICIPANTES; Y UNA VEZ INICIADA LA REUNIÓN Y EL PASE DE LISTA SE PROCEDIÓ AL ANÁLISIS DE LAS SOLICITUDES RECIBIDAS EN EL PERÍODO COMPRENDIDO DEL {{$fechauno}} AL {{$fechados}} DEL {{anio()}}, SIENDO LOS SIGUIENTES CASOS:
@foreach($recomendaciones as $recomendacion)
RECOMENDACIÓN NO. {{$recomendacion->num_recomendacion}}
LA SOLICITUD PRESENTADA POR {{$recomendacion->usuario()->el_interesado()}} {{$recomendacion->usuario()->nombre_completo()}},
@if($recomendacion->usuario()->esDocente())
EN LA CUAL SOLICITA {{$recomendacion->asunto()}}, {{$recomendacion->respuesta}} SE RECOMIENDA, {{$recomendacion->asunto()}}.
@else
CON NÚMERO DE CONTROL {{$recomendacion->usuario()->identificador}}, DE LA CARRERA DE {{$recomendacion->usuario()->carrera_nombre}}, EN LA CUAL SOLICITA {{$recomendacion->asunto()}}, {{$recomendacion->respuesta}} SE RECOMIENDA, {{$recomendacion->asunto()}}, {{$recomendacion->condicionado()}} CONSIDERANDO LAS EVIDENCIAS PRESENTADAS POR EL ESTUDIANTE.
@endif
@endforeach
SE SOLICITA A LAS PERSONAS QUE INTERVIENEN, MANIFIESTEN SI DESEAN AGREGAR ALGUNA OTRA ACTIVIDAD Y EMITAN SU OPINIÓN SOBRE CADA UNO DE LOS PUNTOS EXPUESTOS;AGOTADO EL ORDEN DEL DÍA Y NO HABIENDO OTRO ASUNTO MÁS QUE TRATAR, SE DA POR TERMINADA LA PRESENTE REUNIÓN, SIENDO LAS {{hora()}} HORAS DEL DÍA {{fechaLetraAnio(hoy())}}, FIRMANDO PARA CONSTANCIA AL MARGEN Y CALCE LOS QUE EN ELLA INTERVINIERON.
</textarea>
</div>  
</div>

<div class="row">
 <div class="col centrado">
    <button type="submit" class="btn btn-primary">Registrar</button>
 </div> 
 <div class="col centrado"> 
    <a href="{{route('acta.index')}}"><button class="btn btn-danger" type="button"> Cancelar </button></a>
 </div>
</div>

</form>   
</div>
@endsection