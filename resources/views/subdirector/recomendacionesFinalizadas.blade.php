@extends(Auth::user()->esAdmin() ? 'layouts.encabezadoAdmin' : 'layouts.encabezadosub')
@section('contenido')

<section>
 <div class="container-fluid">
  <div class="row">
   <div class="col-md-12">

   <nav class="nav-justified ">
    <div class="nav nav-tabs " id="nav-tab" role="tablist">
      <a class="nav-item nav-link" href="{{route('recomendaciones')}}">RECOMENDACIONES PENDIENTES</a>
      <a class="nav-item nav-link active" href="{{route('recomendaciones.finalizadas')}}">FINALIZADAS/ENVIADAS</a>                        
    </div>
   </nav>

   <div class="container-fluid">
    <div class="row justify-content-center">
     <div class="col-md-12">
      <div class="card">

       <form id="form" method="GET" action="{{ route('recomendaciones.finalizadas') }}">
         @include('layouts.filtrado.filtro')
       </form>  

       <div class="card-body">                    
        <div class="table-responsive">
         <table class="table table-hover">
          <thead class="thead-dark">
           <tr>
            <th scope="col">Asunto</th>
            <th scope="col">Solicitud</th>
            <th scope="col">Recomendacion</th>
           </tr>
          </thead>  
          <tbody>
           @foreach($recom as $re)
           <tr>
            <td width="50%">
              <b>{{$re->usuario()->identificador}} -- {{$re->usuario()->nombre_completo()}}</b><br>
              <b>{{$re->usuario()->carrera_adscripcion()}}</b><br>
              <p style="text-align:justify;text-transform: lowercase;">{{$re->asunto()}}</p>
            </td>
            <td class="centrado">
              <a class="navbar-brand" href="{{ url('versolicitudEvidencia/'.$re->solicitud->id)}}" target= "_blank">
               <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;"></a>
            </td>
            <td class="centrado">
              <a class="navbar-brand" href="{{ url('storage/'.$re->archivo)}}"target= "_blank">
               <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;"></a>
            </td>
           </tr>
           @endforeach                
          </tbody>
         </table>
         {{$recom->links()}}
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