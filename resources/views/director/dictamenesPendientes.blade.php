@extends(Auth::user()->esAdmin() ? 'layouts.encabezadoAdmin' : 'layouts.encabezadoDirector')
@section('contenido')
<section class=" ">
 <div class="container-fluid">  
  <div class="row">
   <div class="col-md-12 text-center">            
    <nav class="nav-justified ">
     <div class="nav nav-tabs">
       <a class="nav-item nav-link active">DICTAMENES PENDIENTES</a>
       <a class="nav-item nav-link" href="{{route('director.dictamenes','terminados')}}">DICTAMENES FINALIZADOS</a>
     </div>
    </nav>
   </div>
  </div>

  <div class="row justify-content-center">
   <div class="col-md-12">
    <div class="card">

     @include('layouts.filtrado.mensaje')

     <form id="form" method="GET" action="{{ route('director.dictamenes','pendientes') }}">
       @include('layouts.filtrado.filtro')
     </form>
     
     <div class="card-body">                    
      <div class="table-responsive">
       <table class="table table-hover">
        <thead class="thead-dark">
         <tr>
          <th scope="col">Dictamen</th>
          <th scope="col">Solicitud</th>
          <th scope="col">Recomendacion</th>
          <th scope="col">Eliminar</th>
          <th scope="col">Modificar</th>
          <th scope="col">Descargar</th>
          <th scope="col">Subir</th>
          <th scope="col">Enviar</th>     
         </tr>
        </thead>  
        <tbody>
        @foreach($dictamenes as $dic)               
         <tr>
          <td width="40%">
            <b>{{$dic->usuario()->nombre_completo()}}</b><br>
            <b>{{$dic->usuario()->carrera_adscripcion()}}</b><br>
            <p style="text-align:justify; text-transform: lowercase;">{{$dic->asunto()}}</p> 
          </td>
          <td class="centrado">
            <a class="navbar-brand" href="{{ route('solicitudEvidencia',$dic->solicitud()->id)}}" target= "_blank">
            <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;"></a>
          </td>
          <td class="centrado">
            <a class="navbar-brand" href="{{ url('storage/'.$dic->recomendacion->archivo)}}" target= "_blank">
            <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;"></a>                  
          </td class="centrado">
          <td class="centrado">
            <form method="post" action="{{route('eliminar.dictamen',$dic->id)}}">
              {{csrf_field()}}
              {{method_field('DELETE')}}            
              <input class="navbar-brand" type="image" name="boton" src="{{ asset('imagenes/eliminar.png')}}" style="width:35px;" onClick='return confirm("¿Borrar?")'>          
            </form>
          </td>
          <td class="centrado">
             <a class="navbar-brand" href="{{route('editar.dictamen',$dic->id)}}">
             <img src="{{ asset('imagenes/editar.png') }}" style="width:35px;">
             </a>
          </td>
          <td class="centrado">
            <a class="navbar-brand" href="{{route('dictamen.pdf',$dic->id)}}" target= "_blank">
            <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;"></a>               
          </td>
          <td class="centrado">
            <input type="image" src="{{ asset('imagenes/subir.png')}}" style="width:35px;" onclick="subirfile('/dictamen/{{$dic->id}}');"><br>
             @if(!$dic->dictamen_firmado)
             <a style="color:black;"><b>Archivo no cargado</b></a>
             @else
             <a style="color:green;"><b>Archivo cargado</b></a>
             @endif
          </td>
          <td class="centrado">
             @if($dic->num_oficio && $dic->num_dictamen && $dic->respuesta && $dic->fecha && $dic->dictamen_firmado)
             <form action="{{route('enviar.dictamen',$dic->id)}}" enctype="multipart/form-data">
             {{ csrf_field()}}
             <button type="submit" class="btn btn-primary">Enviar</button>
             </form>
             @else
             <button type="submit" class="btn btn-primary" disabled>Enviar</button><br>
             <a style="color:red;"><b>Faltan campos por completar</b></a>
             @endif
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

@include('layouts.modals.file')
@endsection


@section('script')
<script src="{{ asset('js/file.js') }}"></script>
@endsection