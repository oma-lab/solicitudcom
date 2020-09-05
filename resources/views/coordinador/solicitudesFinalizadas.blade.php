@extends('layouts.encabezadocoor')
@section('contenido')
<section>
<div class="container-fluid">
 <div class="row">
  <div class="col-md-12 text-center ">
   
   <nav class="nav-justified ">
    <div class="nav nav-tabs " id="nav-tab" role="tablist">
      <a class="nav-item nav-link" href="{{route('coordinador.solicitudes','pendientes')}}" aria-selected="false">SOLICITUDES PRÓXIMA REUNIÓN</a>
      <a class="nav-item nav-link active" aria-selected="true">SOLICITUDES VISTAS EN REUNIÓN</a>                     
    </div>
   </nav>

   <div class="container-fluid">
    <div class="row justify-content-center">
     <div class="col-md-12">
      <div class="card">

      <form id="form" method="GET" action="{{ route('coordinador.solicitudes','finalizadas') }}">
        @include('layouts.filtrado.filtro')
      </form>
       
       <div class="card-body">                    
        <div class="table-responsive">
         <table class="table">
          <thead class="thead-dark">
           <tr>
            <th scope="col">Solicitud</th>
            <th scope="col">Ver Solicitud</th>
            <th scope="col">Observaciones</th>
           </tr>
          </thead>  
          <tbody>
           @foreach($solicitudes as $sol)
           <tr>
            <td scope="row" width="40%" style="text-align:left">
             {{$sol->user->nombre_completo()}}<br>
             {{$sol->user->carrera->nombre}}<br>
             <p style="text-align:justify"><b>{{$sol->asunto}}</b></p>
            </td>               
            <td class="centrado">
             <a class="navbar-brand" href="{{ url('versolicitudEvidencia/'.$sol->id)}}" target= "_blank">
               <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;">
             </a>
            </td>               
            <td>
             <textarea class="form-control rounded-0" id="exampleFormControlTextarea2" name="descripcion" rows="4" disabled>{{$sol->descripcion}}</textarea>
            </td>
           </tr>
           @endforeach
          </tbody>
         </table>
         {{$solicitudes->links()}}
        </div>
       </div>
       
      </div>
     </div>
    </div>
   </div>
     
  </div>
 </div>
</div>
</section>
@endsection