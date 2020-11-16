@extends(Auth::user()->esAdmin() ? 'layouts.encabezadoAdmin' : 'layouts.encabezadoDirector')
@section('contenido')
<section>
 <div class="container-fluid">
  
  <div class="row">
   <div class="col-md-12 text-center">            
    <nav class="nav-justified ">
     <div class="nav nav-tabs">
       <a class="nav-item nav-link" href="{{route('director.dictamenes','pendientes')}}">DICTAMENES PENDIENTES</a>
       <a class="nav-item nav-link active">DICTAMENES FINALIZADOS</a>
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
          <th scope="col">Rehacer</th>
          <th scope="col">Acuse de recibido</th>
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
            <td>
             <a href="{{route('rehacer',$dic->id)}}">
               <button type="button" class="btn btn-outline-success btn-sm">
                 <i class="fa fa-undo"></i> Rehacer
               </button>
             </a>
            </td>
            <td>
             <button type="button" class="btn btn-primary" onclick="veracuse({{$dic->id}})">
              <span class="fa fa-eye"  aria-hidden="true">ver</span>
             </button>
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

  <div class="modal fade" id="modalacuse" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5>Dictamen recibido por:</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">                
          <div id="acuse" class="col-12"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>       
        </div>
      </div>
    </div>
  </div>


 </div>
</section>
@endsection


@section('script')
<script>
 function veracuse(id){
  $("#acuse").empty();
  var campo = '';
  $.get(url_global+"/acuse",{id: id}, function(vistos){
    $.each(vistos,function(index,value){
      let status = (value.status) ? 'checked' : '';
      campo += '<label><input type="checkbox" '+status+'>'+value.usuario+'</label><br>';
    });
    campo += '<label><input type="checkbox" checked>Comité Académico</label><br>';
    campo += '<label><input type="checkbox" checked>Archivo</label><br>';
    $("#acuse").append(campo);
  });
  $("#modalacuse").modal("show");
 }
</script>
@endsection