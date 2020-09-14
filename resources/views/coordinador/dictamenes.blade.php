@extends('layouts.encabezadocoor')
@section('contenido')

<div class="container-fluid">
 <div class="row justify-content-center">
  <div class="col-md-12">

   <div class="card">

    <form id="form" method="GET" action="{{ route('coordinador.dictamenes') }}">
      @include('layouts.filtrado.filtro')
    </form>

    <div class="card-body">                    
     <div class="table-responsive">        
      <table class="table">
       <thead class="thead-dark">
        <tr>
         <th scope="col">Nombre/Carrera</th>
         <th scope="col">Ver Solicitud</th>
         <th scope="col">Ver Dictamen</th>
        </tr>
       </thead>  
       <tbody>
        @foreach($dictamenes as $dic)
        <tr>
         <td scope="row" width="50%" style="text-align:left">
          {{$dic->usuario()->nombre_completo()}}<br>
          {{$dic->usuario()->nombre_carrera()}}<br>
          <p style="text-align:justify"><b>{{$dic->asunto()}}</b></p>
         </td>           
         <td class="centrado">
          <a class="navbar-brand" href="{{ url('versolicitudEvidencia/'.$dic->solicitud()->id)}}" target= "_blank">
            <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;">
          </a>
         </td>               
         <td class="centrado">
          <a class="navbar-brand" href="{{ url('storage/'.$dic->dictamen_firmado)}}" target= "_blank">
            <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;">
          </a>
         </td>  
        </tr>
        @endforeach
       </tbody>
      </table>
      {{$dictamenes->appends(Request::only(['carrera_id','numc','nombre']))->links()}}
     </div>
    </div>
    
   </div>
  </div>
 </div>
</div>
@endsection