@extends('layouts.encabezadoSolicitante')
@section('estilos')
<style>
.error {
  margin: 0 auto;
  text-align: center;
}
.error-code {
  bottom: 60%;
  color: #2d353c;
  font-size: 40px;
  line-height: 80px;
}
.error-desc {
  font-size: 12px;
  color: #647788;
}
.m-b-10 {
  margin-bottom: 10px!important;
}
.m-t-20 {
  margin-top: 20px!important;
}
</style>
@endsection
@section('contenido')
<div class="container-fluid">
@include('layouts.filtrado.mensaje')
 <div class="row">

  @forelse($ds as $dictamen)
  <div class="col-md-4">
   <div class="card" style="width: 18rem;">  
    <div class="card-body">
      <h5 class="card-title">{{$dictamen->asunto()}}</h5>
      @if($dictamen->entregado)
      <p class="card-text">Ya has recogido tu dictamen.</p>
      <a  href="{{ url('storage/'.$dictamen->dictamen_firmado)}}" class="btn btn-primary" target= "_blank">Ver dictamen</a>
      @elseif($dictamen->entregadodepto)
      <p class="card-text">Tu dictamen se ha realizado, puedes recogerlo en el departamento de tu carrera.</p>
      @else
      <p class="card-text">Tu dictamen se ha realizado, mantente al pendiente en esta página para saber cuando puedes recogerlo en el departamento de tu carrera.</p>
      @endif
    </div>
   </div>
  </div>
  @empty
  <div class="card">
   <div class="error">
    <div class="error-code m-b-10 m-t-20">Sin registros<i class="fa fa-warning"></i></div>
    <h3 class="font-bold">No tienes dictamenes registrados</h3>
     <div class="error-desc">
      Realiza una solicitud si aún no lo has hecho o espera respuesta de tu solicitud ya hecha
     <div>
       <a href="{{route('home')}}"><button type="button" class="btn btn-danger btn-sm">Regresar</button></a>
       <a href="{{ route('crear.solicitud') }}"><button type="button" class="btn btn-primary btn-sm">Realizar solicitud</button></a>
     </div>
    </div>
   </div>
  </div>
  @endforelse
  
 </div>
</div>


@endsection

