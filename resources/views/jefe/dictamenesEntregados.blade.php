@extends('layouts.encabezadojefe')
@section('contenido')

<section>
 <div class="container-fluid">
  <div class="row">
   <div class="col-md-12 text-center ">
    <nav class="nav-justified ">
     <div class="nav nav-tabs " id="nav-tab" role="tablist">
      <a class="nav-item nav-link" href="{{route('jefe.dictamenes','no_entregado')}}" aria-selected="false">NUEVOS DICTAMENES</a>
      <a class="nav-item nav-link active" aria-selected="true">DICTAMENES RECIBIDOS</a>
     </div>
    </nav>

    <div class="container-fluid">
     <div class="row justify-content-center">
      <div class="col-md-12">
       <div class="card">
       
        <form id="form" method="GET" action="{{ route('jefe.dictamenes','entregado') }}">
          @include('layouts.filtrado.filtro')
        </form>
       
        <div class="card-body">                    
         <div class="table-responsive">        
          <table class="table">
           <thead class="thead-dark">
            <tr>
             <th scope="col">Asunto</th>
             <th scope="col">Ver Solicitud</th>
             <th scope="col">Ver Dictamen</th>
            </tr>
           </thead>  
           <tbody>
             @foreach($dictamenes as $dic)
             <tr>
              <td scope="row" width="60%" style="text-align:left">
                <b>{{$dic->usuario()->nombre_completo()}}</b><br>
                <b>{{$dic->usuario()->carrera_adscripcion()}}</b><br>
                <p style="text-align:justify">{{$dic->asunto()}}</p>
              </td>                 
              <td class="centrado">
                <a class="navbar-brand" href="{{ route('solicitudEvidencia',$dic->solicitud()->id)}}" target= "_blank">
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

   </div>
  </div>
 </div>
</section>
@endsection

@section('script')
<script>
  window.addEventListener("load", function(){
    document.getElementById('filtroreunion').style.display = "block";
  });
</script>
@endsection