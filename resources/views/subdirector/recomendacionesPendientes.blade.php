@extends(Auth::user()->esAdmin() ? 'layouts.encabezadoAdmin' : 'layouts.encabezadosub')
@section('contenido')

<section>
 <div class="container-fluid">
  <div class="row">
   <div class="col-md-12">

    <nav class="nav-justified ">
     <div class="nav nav-tabs " id="nav-tab" role="tablist">
      <a class="nav-item nav-link active" href="{{route('recomendaciones')}}">RECOMENDACIONES PENDIENTES</a>
      <a class="nav-item nav-link" href="{{route('recomendaciones.finalizadas')}}">FINALIZADAS/ENVIADAS</a>
     </div>
    </nav>
   
    <div class="container-fluid">
     <div class="row justify-content-center">
      <div class="col-md-12">
       <div class="card">
       @include('layouts.filtrado.mensaje')

         <form id="form" method="GET" action="{{ route('recomendaciones') }}">
           @include('layouts.filtrado.filtro')
         </form>

         <div class="card-body">
          <div class="table-responsive">
           <table class="table table-hover">
            <thead class="thead-dark">
             <tr>
              <th scope="col">Asunto</th>
              <th scope="col">Solicitud</th>
              <th scope="col">Eliminar</th>                  
              <th scope="col">Modificar</th>
              <th scope="col">Descargar</th>
              <th scope="col">Subir</th>
              <th scope="col">Subido</th>
              <th scope="col">Enviar</th>
             </tr>
            </thead>  
            <tbody>
             @foreach($recomendaciones as $reco)
             <tr>
               <td width="40%">
                <b>{{$reco->usuario()->identificador}} -- {{$reco->usuario()->nombre_completo()}}</b><br>
                <b>{{$reco->usuario()->carrera_adscripcion()}}</b><br>
                <p style="text-align:justify;text-transform: lowercase;">{{$reco->asunto()}}</p>
               </td>
               <td class="centrado">
                <a class="navbar-brand" href="{{ url('versolicitudEvidencia/'.$reco->solicitud->id)}}" target= "_blank">
                <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;"></a>
               </td>
               <td class="centrado">
                <form method="post" action="{{route('eliminar.recomendacion',$reco->id)}}">
                {{csrf_field()}}
                {{method_field('DELETE')}}            
                <input type="image" name="boton" src="{{ asset('imagenes/eliminar.png')}}" style="width:35px;" onClick='return confirm("¿Borrar?")'>          
                </form>
               </td>             
               <td class="centrado">
                <a class="navbar-brand" href="{{route('editar.recomendacion',$reco->id)}}">
                <img src="{{ asset('imagenes/editar.png') }}" style="width:35px;">
                </a>
               </td>


               <td class="centrado">
                <a class="navbar-brand" href="{{route('generar.recomendacion',$reco->id)}}" target= "_blank">
                <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;"></a>                
               </td>

               <td class="centrado">
                <input type="image" data-toggle="modal" data-target="#modalsubir" src="{{ asset('imagenes/subir.png')}}" style="width:35px;" onclick="document.getElementById('formsubir').action = '/recomendacion/{{$reco->id}}'; document.getElementById('subirfile').value = '';document.getElementById('labelpdf').innerHTML = 'Elegir Archivo PDF';"><br>
                <a style="color:{{($reco->archivo) ? 'green' : 'red'}};"><b>{{($reco->archivo) ? 'Cargado' : 'No cargado'}}</b></a>
               </td>

               <td class="centrado">
               @if($reco->archivo)
                <a class="navbar-brand" href="{{ url('storage/'.$reco->archivo)}}" target= "_blank">
                  <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;">
                </a><br>
                <b style="color:green;">Subido</b>
               @else
                <b style="color:red;">No disponible</b>
               @endif
               </td>

               
               <td class="centrado">
                @if($reco->archivo && $reco->num_oficio && $reco->num_recomendacion)
                <a href="{{route('enviar.recomendacion',$reco->id)}}">
                 <button class="btn btn-success">Enviar</button>
                </a>
                @else
                <a href="{{route('enviar.recomendacion',$reco->id)}}">
                 <button class="btn btn-success" disabled>Enviar</button><br>
                 <a style="color:red;"><b>Faltan campos por completar</b></a>
                </a>
                @endif  
               </td>
             </tr> 
             @endforeach
            </tbody>
           </table>
           {{$recomendaciones->appends(Request::only(['role_id','carrera_id','numc','nombre']))->links()}}
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


@include('layouts.modals.file')
@endsection