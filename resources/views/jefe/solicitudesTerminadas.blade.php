@extends(Auth::user()->esjefe() ? 'layouts.encabezadojefe' : 'layouts.encabezadosub')
@section('contenido')

<section>
 <div class="container-fluid">
 
  <div class="row">
   <div class="col-md-12 text-center ">
    <nav class="nav-justified ">
     <div class="nav nav-tabs " id="nav-tab" role="tablist">
      <a class="nav-item nav-link" href="{{route('jefe.solicitudes','pendientes')}}">SOLICITUDES PRÓXIMA REUNIÓN</a>
      <a class="nav-item nav-link active">SOLICITUDES VISTAS EN REUNIÓN</a>                     
     </div>
    </nav>
   </div>
  </div>

  <div class="container-fluid">
   <div class="row justify-content-center">
    <div class="col-md-12">
     <div class="card">

     <form id="form" method="GET" action="{{ route('jefe.solicitudes','finalizadas') }}">
       @include('layouts.filtrado.filtro')
     </form>         


     <div class="card-body">                    
      <div class="table-responsive">
       <table class="table">
        <thead class="thead-dark">
         <tr>
           <th scope="col">Solicitud</th>
           <th scope="col">Ver Solicitud</th>
           <th scope="col">Voto</th>
           <th scope="col">Observaciones</th>
         </tr>
        </thead>  
        <tbody>
           @foreach($solicitudes as $solt)
            <tr>
             <td scope="row" width="40%" style="text-align:left">
                <b>{{$solt->user->identificador}} ,</b>
                {{$solt->user->nombre_completo()}}<br>
                {{$solt->user->carrera_adscripcion()}}<br>
                <p style="text-align:justify"><b>{{limitar($solt->asunto)}}</b></p>
             </td>           
             <td class="centrado">
               <a class="navbar-brand" href="{{url('storage/'.$solt->solicitud_firmada)}}" target= "_blank">
               <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;"></a>
             </td>  
             <td>
               {{$solt['voto'] ? $solt->voto : 'NO VOTADO'}}
             </td>             
             <td>
               <textarea class="form-control rounded-0" name="descripcion" rows="4" disabled placeholder="Sin observaciones">{{$solt->descripcion}}</textarea>
             </td>
            </tr>
           @endforeach
        </tbody>
       </table>
       {{$solicitudes->appends(Request::only(['role_id','visto','carrera_id','numc','nombre']))->links()}}
      </div>
     </div>

     </div>
    </div>
   </div>
  </div>

 </div>
</section>
@endsection