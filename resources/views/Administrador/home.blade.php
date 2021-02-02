@extends('layouts.encabezadoAdmin')
@section('estilos')
<style>
.radioBtn .noActivo{
  color: #3276b1;
  background-color: #fff;
}
</style>
@endsection
@section('contenido')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        @include('layouts.filtrado.mensaje')
        <div class="card-header">
        SOLICITUDES PENDIENTES
             <a class="btn btn-outline-success" href="{{route('registrar.documento')}}" role="button" title="Generar Solicitud">+Recomendación/Dictamen</a>
             <a class="btn btn-outline-primary" href="{{route('vista.posponer')}}" role="button" title="Posponer solicitudes">Posponer</a>
             <div class="form-inline float-right">
             CARRERA:
             <form method="GET" action="{{ route('solicitudes') }}" class="form-inline my-2 my-lg-0" id="form">  
              <select class="form-control mr-sm-2 filtro" name="carrera_id" style="width:225px">
               <option value="">TODAS LAS CARRERAS</option>
               @foreach($carreras as $carrera)
               <option value="{{$carrera->id}}" {{(request('carrera_id') == $carrera['id']) ? 'selected' : '' }}>{{$carrera->nombre}}</option>
               @endforeach
              </select> 
              FECHA REUNIÓN:
              <select class="form-control filtro" name="filtrofecha" style="width:150px">
              @foreach($proximas as $prox)
              <option value="{{$prox->id}}" {{$filtro == $prox['id'] ? 'selected' : '' }}>{{fecha($prox->start)}}</option>
              @endforeach
              @foreach($pasadas as $pas)
              <option value="{{$pas->id}}" {{$filtro == $pas['id'] ? 'selected' : '' }}>{{fecha($pas->start)}}</option>
              @endforeach              
              </select>
             </form>
             
             </div>
        </div>
          <div class="card-body">                    
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Solicitud</th>
                    <th scope="col">Ver solicitud</th>
                    <th scope="col">Recibido</th>
                    <th scope="col">Observaciones</th>
                    <th scope="col">Respuesta</th>
                    <th scope="col">Guardar</th>
                  </tr>
                </thead>  
                <tbody>
                @foreach($solicitudes as $sol)                               
                  <tr>
                    <th width="40%">                    
                      {{$sol->user->identificador}}
                      <a href="{{route('actualizar.solicitud',$sol->id)}}">
                        <button type="button" class="btn btn-default">
                        <span class="fa fa-cog"  aria-hidden="true"></span>
                        </button>
                      </a>
                      <button type="button" class="btn btn-default" onclick="historial('{{$sol->identificador}}',{{$sol->id}})">
                        <span class="fa fa-question-circle"  aria-hidden="true"></span>historial
                      </button>
                      <form method="post" action="{{route('eliminar.solicitud',$sol->id)}}" style="display:inline;">
                      {{csrf_field()}}
                      {{method_field('DELETE')}}
                        <button type="submit" class="btn btn-default" onClick='return confirm("¿Está seguro que desea eliminar?")'>
                        <span class="fa fa-trash"  aria-hidden="true"></span>
                        </button>
                      </form><br>
                      {{$sol->user->nombre_completo()}}<br>
                      {{$sol->user->carrera_adscripcion()}}<br>
                      <p style="text-align:justify;text-transform: lowercase;">{{$sol->asunto}}</p>                    
                    </th>
                    <td class="centrado">
                       @if($sol->solicitud_firmada)
                       <a class="navbar-brand" href="{{url('storage/'.$sol->solicitud_firmada)}}" target= "_blank">
                       <img src="{{ asset('imagenes/ver.png') }}" style="width:35px;"></a>
                       @else
                       <a href="{{route('subir.solicitud',$sol->id)}}">Subir solicitud</a>
                       @endif
                    </td>                 
                    <td width="10%">
                      <button type="button" class="btn btn-default" onclick="verobs({{$sol->id}})">
                      <span class="fa fa-question-circle"  aria-hidden="true"></span>votos/ observaciones
                      </button>                                  
                    </td>
                    <form method="POST" action="{{route('respuesta.solicitud',$sol->id)}}" enctype="multipart/form-data">
                    {{ csrf_field()}}
                    {{method_field('PATCH')}} 
                    <td>
                       <textarea class="form-control" rows="3" name="observaciones" placeholder="Observaciones">{{$sol->observaciones}}</textarea>                                              
                    </td>
                    <td>
                      <div class="form-group">
    		          	  <div class="input-group containerc">
    		        		  <div class="radioBtn btn-group">
                      <a class="btn btn-primary  noActivo" data-toggle="respuesta" data-title="SI">SI</a>
    			      		  <a class="btn btn-primary  noActivo" data-toggle="respuesta" data-title="NO">NO</a>
                      </div> 
                      <input type="hidden" name="respuesta" value="" class="respuesta">			          	
    		            	</div>
                    	</div>
                    </td>
                    <td>
                       <button type="submit" class="btn btn-primary d-block mx-auto">Guardar</button>                         
                    </td>
                    </form>  
                  </tr>                
                @endforeach
                </tbody>
              </table>
              {{$solicitudes->appends(Request::only(['carrera_id','filtrofecha']))->links()}}
            </div>
          </div>
      </div>
    </div>
  </div>  
</div>
@include('layouts.modals')
@endsection



@section('script')
<script src="{{ asset('js/respuesta.js') }}"></script>
@endsection