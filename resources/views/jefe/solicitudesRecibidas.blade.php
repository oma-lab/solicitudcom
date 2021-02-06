@extends(Auth::user()->esjefe() ? 'layouts.encabezadojefe' : 'layouts.encabezadosub')
@section('contenido')

<section>
 <div class="container-fluid">
  
  <div class="row">
   <div class="col-md-12 text-center ">
    <nav class="nav-justified ">
     <div class="nav nav-tabs ">
      <a class="nav-item nav-link active">SOLICITUDES PRÓXIMA REUNIÓN</a>
      <a class="nav-item nav-link" href="{{route('jefe.solicitudes','finalizadas')}}">SOLICITUDES VISTAS EN REUNIÓN</a>
     </div>
    </nav>
   </div> 
  </div>
  
  <div class="container-fluid">
   <div class="row justify-content-center">
    <div class="col-md-12">
     <div class="card">

     <form id="form" method="GET" action="{{ route('jefe.solicitudes','pendientes') }}">
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
          <th scope="col">Voto</th>
          <th scope="col">Observaciones</th>
          <th scope="col">Recibido</th>
        </tr>
       </thead>  
       <tbody>
        @foreach($solicitudes as $sol)
        <form method="POST" action="{{route('guardar.observacion')}}" enctype="multipart/form-data">
        {{ csrf_field()}}
         <tr>
          <td scope="row" width="40%" style="text-align:left">
             <b>{{$sol->identificador}}</b><br>
             {{$sol->user->nombre_completo()}}
             <button type="button" class="btn btn-default" onclick="historial('{{$sol->identificador}}',{{$sol->id}})">
               <span class="fa fa-question-circle"  aria-hidden="true"></span>historial
             </button>
             <button type="button" class="btn btn-default" onclick="verobs({{$sol->id}})">
                 <span class="fa fa-question-circle"  aria-hidden="true"></span>observaciones
             </button>
             <br>
             {{$sol->user->carrera_adscripcion()}}<br>
             <p style="text-align:justify"><b>{{limitar($sol->asunto)}}</b></p>
             <input type="hidden" name="solicitud_id" value="{{$sol->id}}">
          </td>            
          <td class="centrado">
            <a class="navbar-brand" href="{{url('storage/'.$sol->solicitud_firmada)}}" target= "_blank">
            <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;"></a>
          </td>      
          <td>
           <select class="form-control form-control-sm" name="voto">
             <option value="">SELECCIONE</option>                     
             <option value="SI" {{$sol['voto'] == 'SI' ? 'selected' : ''}}>SI</option>
             <option value="NO" {{$sol['voto'] == 'NO' ? 'selected' : ''}}>NO</option>              
           </select>
          </td>         
          <td>
            <textarea class="form-control rounded-0" name="descripcion" rows="4" placeholder="Observaciones">{{$sol->descripcion}}</textarea>                                 
          </td>
          <td>
            <button type="submit" class="btn btn-primary d-block mx-auto btn-sm">{{request('visto') ? 'Guardar' : 'Marcar Visto'}}</button>
          </td>
         </tr>
        </form>
        @endforeach
       </tbody>
      </table>
      {{$solicitudes->appends(Request::only(['role_id','visto','carrera_id','numc','nombre']))->links()}}
      </div>
     </div>

     </div>
    </div>
   </div>
  </div><!--Fin container fluid-->
             
        
 </div>
</section>


@include('layouts.modals')
@endsection

@section('script')
<script>
window.addEventListener("load", function(){
    document.getElementById('filtro').style.display = "block";
});
</script>
@endsection