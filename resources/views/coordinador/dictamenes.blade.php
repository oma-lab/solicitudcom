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
         <th scope="col">Recibido</th>
        </tr>
       </thead>  
       <tbody>
        @foreach($dictamenes as $dic)
        <tr>
         <td scope="row" width="50%" style="text-align:left">
          {{$dic->usuario()->nombre_completo()}}<br>
          {{$dic->usuario()->nombre_carrera()}}<br>
          <p style="text-align:justify"><b>{{limitar($dic->asunto())}}</b></p>
         </td>           
         <td class="centrado">
          <a class="navbar-brand" href="{{url('storage/'.$dic->solicitud()->solicitud_firmada)}}" target= "_blank">
            <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;">
          </a>
         </td>               
         <td class="centrado">
          <a class="navbar-brand" href="{{ url('storage/'.$dic->dictamen_firmado)}}" target= "_blank" onclick="marcar_recibido({{$dic->id}},'{{usuario()->identificador}}')">
            <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;">
          </a>
         </td>
         <td>
          @if($dic->recibido)
          <button id="{{$dic->id}}" type="button" class="btn btn-primary btn-sm" disabled>
          Recibido
          </button>
          @else
          <button id="{{$dic->id}}" type="button" class="btn btn-primary btn-sm" onclick="marcar_recibido({{$dic->id}},'{{usuario()->identificador}}')">
          Marcar recibido
          </button>
          @endif
         </td>  
        </tr>
        @endforeach
       </tbody>
      </table>
      {{$dictamenes->appends(Request::only(['dic_recibido','fechareunion','carrera_id','numc','nombre']))->links()}}
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
      document.getElementById('filtrodictamen').style.display = "block";
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