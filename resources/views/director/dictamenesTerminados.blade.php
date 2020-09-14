@extends(Auth::user()->esAdmin() ? 'layouts.encabezadoAdmin' : 'layouts.encabezadoDirector')
@section('contenido')
<section>
 <div class="container-fluid">
  
  <div class="row">
   <div class="col-md-12 text-center">            
    <nav class="nav-justified ">
     <div class="nav nav-tabs">
       <a class="nav-item nav-link" href="{{route('director.dictamenes','pendientes')}}">DICTAMENES PENDIENTES</a>
       <a class="nav-item nav-link" href="{{route('dictamenes.entregados')}}">NO ENTREGADOS</a>
       <a class="nav-item nav-link active">ENTREGADOS-FINALIZADOS</a>
     </div>
    </nav>
   </div>
  </div>

  <div class="row justify-content-center">
   <div class="col-md-12">
    <div class="card">

    @include('layouts.filtrado.mensaje')

     <form id="form" method="GET" action="{{ route('director.dictamenes','terminados') }}">
       @include('layouts.filtrado.filtro')
     </form>
    
     <div class="card-body">                    
      <div class="table-responsive">
       <table class="table table-hover">
        <thead class="thead-dark">
         <tr>
          <th scope="col">N°Dic/Asunto</th>
          <th scope="col">Solicitud</th>
          <th scope="col">Recomendación</th>
          <th scope="col">Dictamen</th>
         </tr>
        </thead>  
        <tbody>
          @foreach($dictamenes as $dic)
          <tr>
            <td width="50%">
             <b>{{$dic->num_dictamen}}</b><br>
             <b>{{$dic->usuario()->nombre_completo()}}</b><br>
             <b>{{$dic->usuario()->carrera_adscripcion()}}</b><br>
             <p style="text-align:justify;text-transform: lowercase;">{{$dic->asunto()}}</p>
            </td>
            <td class="centrado">
             <a class="navbar-brand" href="{{ url('versolicitudEvidencia/'.$dic->solicitud()->id)}}" target= "_blank">
             <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;"></a>
            </td>
            <td class="centrado">
             <a class="navbar-brand" href="{{ url('storage/'.$dic->recomendacion->archivo)}}" target= "_blank">
             <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;"></a>                    
            </td>
            <td class="centrado">
             <a class="navbar-brand" href="{{ url('storage/'.$dic->dictamen_firmado)}}" target= "_blank">
             <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;"></a>                    
            </td>                                        
          </tr>
          @endforeach  
        </tbody>
       </table>
       {{$dictamenes->appends(Request::only(['role_id','carrera_id','numc','nombre']))->links()}}
      </div>
     </div>
    
    </div>
   </div>
  </div>


 </div>
</section>
@endsection