@extends('layouts.encabezadosub')
@section('contenido')
<div class="container-fluid">
 <div class="row justify-content-center">
  <div class="col-md-12">
   <div class="card">

    <form id="form" method="GET" action="{{ route('sub.dictamenes') }}">
       @include('layouts.filtrado.filtro')
    </form>

    <div class="card-body">                    
     <div class="table-responsive">        
      <table class="table">
       <thead class="thead-dark">
        <tr>
         <th scope="col">Nombre/Carrera</th>
         <th scope="col">Solicitud</th>
         <th scope="col">Ver Solicitud</th>
         <th scope="col">Ver Recomendacion</th>
         <th scope="col">Ver Dictamen</th>
        </tr>
       </thead>  
       <tbody>
        @foreach($dictamenes as $dic)
        <tr>
         <th scope="row">
           {{$dic->usuario()->nombre_completo()}}<br>
           {{$dic->usuario()->carrera_adscripcion()}}
         </th>                  
         <td>
           {{$dic->asunto()}}
         </td>               
         <td class="centrado">
           <a class="navbar-brand" href="{{ route('solicitudEvidencia',$dic->solicitud()->id)}}" target= "_blank">
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
      {{$dictamenes->appends(Request::only(['fechareunion','carrera_id','numc','nombre']))->links()}}
     </div>
    </div>
   </div>
  </div>
 </div>
</div>
@endsection

@section('script')
<script>
  window.addEventListener("load", function(){
      document.getElementById('filtroreunion').style.display = "block";
  });
</script>
@endsection
