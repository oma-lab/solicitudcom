@extends('layouts.encabezadojefe')
@section('contenido')

<section>
 <div class="container-fluid">
  <div class="row">
   <div class="col-md-12 text-center ">
    <nav class="nav-justified ">
     <div class="nav nav-tabs " id="nav-tab" role="tablist">
      <a class="nav-item nav-link active" aria-selected="true">NUEVOS DICTAMENES</a>
      <a class="nav-item nav-link" href="{{route('jefe.dictamenes','entregado')}}" aria-selected="false">DICTAMENES RECIBIDOS</a>                       
     </div>
    </nav>

    <div class="container-fluid">
     <div class="row justify-content-center">
      <div class="col-md-12">
       <div class="card">

        <form id="form" method="GET" action="{{ route('jefe.dictamenes','no_entregado') }}">
          @include('layouts.filtrado.filtro')
        </form>

        <div class="card-body">                    
         <div class="table-responsive">
         @include('layouts.filtrado.mensaje')
          <table class="table">
           <thead class="thead-dark">
            <tr>
             <th scope="col">Solicitud</th>
             <th scope="col">Ver Solicitud</th>
             <th scope="col">Ver Dictamen</th>
             <th scope="col">Recibido</th>
            </tr>
           </thead>  
           <tbody>
            @foreach($dictamenes as $dic)
            <tr>
             <td scope="row" width="50%" style="text-align:left">
               <b>{{$dic->usuario()->identificador}} -- {{$dic->usuario()->nombre_completo()}}</b><br>
               <b>{{$dic->usuario()->carrera_adscripcion()}}</b><br>
               <p style="text-align:justify">{{limitar($dic->asunto())}}</p>
             </td>              
             <td class="centrado">
               <a class="navbar-brand" href="{{url('storage/'.$dic->solicitud()->solicitud_firmada)}}" target= "_blank">
                <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;"></a>
             </td>               
             <td class="centrado">
               <a class="navbar-brand" href="{{ url('storage/'.$dic->dictamen_firmado)}}" target= "_blank" onclick="marcar_recibido({{$dic->id}},'{{usuario()->identificador}}')">
               <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;"></a>
             </td>
             <td>
               <button id="{{$dic->id}}" type="button" class="btn btn-primary btn-sm" onclick="marcar_recibido({{$dic->id}},'{{usuario()->identificador}}')">
                Marcar recibido
               </button>
             </td>  
            </tr>
            @endforeach            
           </tbody>
          </table>
          {{$dictamenes->appends(Request::only(['fechareunion','role_id','carrera_id','numc','nombre']))->links()}}
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
  function marcar_recibido(dic,user){
    $('#'+dic).prop('disabled',true);
    var token = $("meta[name='csrf-token']").attr("content");
    $.post(url_global+"/marcar_dictamen",{'dic': dic, 'user': user, _token : token}, function(respuesta){
      $('#'+dic).html("Recibido");
    });
  }
</script>
@endsection