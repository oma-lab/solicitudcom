@extends('layouts.encabezadoAdmin')
@section('contenido')

<div class="container-fluid">
 <div class="row">

  <div class="col-md-6">
   <div class="card">        
    <div class="card-header">GENERAR CITATORIO</div>
    <form method="POST" action="{{url('citatorio')}}"enctype="multipart/form-data">
    {{ csrf_field()}}
    <div class="card-body">
      <div class="form-group row">
        <label for="fecha" class="col-sm-4 col-form-label">Fecha elaboración:</label>
        <div class="col-sm-8">
          <input type="date" class="form-control" name="fecha" id="fecha" value="{{hoy()}}" placeholder="dia/mes/año" required>
        </div>
      </div>
      <div class="form-group row">
        <label for="calendario_id" class="col-sm-4 col-form-label">Fecha de reunión :</label>
        <div class="col-sm-8">
          <select class="form-control" name="calendario_id" required>
            @if($proxima)
            <option value="{{$proxima->id}}">{{fecha($proxima->start)}}</option>
            @endif
            @foreach($pasadas as $pasada)
            <option value="{{$pasada->id}}">{{fecha($pasada->start)}}</option>
            @endforeach
          </select>
        </div>                   
      </div>
      <div class="form-group row">
        <label  for="hora" class="col-sm-4 col-form-label">Hora de reunión:</label>
	      <div class="col-sm-8">
          <input type="time" class="form-control" name="hora" id="hora" max="24:00:00" required>
        </div>
		  </div>
      <div class="form-group row">
        <label for="lugar" class="col-sm-4 col-form-label">Lugar:</label>
        <div class="col-sm-8">
          <textarea class="form-control" name="lugar" id="lugar" rows="2" required>en la sala de juntas anexa a la dirección de este instituto</textarea>
        </div>
      </div>
      <div class="form-group row">
        <label for="oficio" class="col-sm-4 col-form-label">Número de oficio:</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="oficio" id="oficio" value="" required>
        </div>
      </div>
      <b>ORDEN DEL DIA:</b>
      <div class="input-group mb-3">
        <input type="text" class="form-control" name="ordens[]" placeholder="Ingrese primer punto, para agregar otro punto presione el boton +">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button" onclick="addOrden();"><b>+</b></button>
        </div>
      </div>
      <div id="orden">
      </div>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-success">Generar</button>
    </div>
    </form>
   </div>
  </div>


  <div class="col-md-6">
   <div class="card">
    @include('layouts.filtrado.mensaje')
    <div class="card-header">CITATORIOS</div>
    <div class="card-body">
     <div class="table-responsive">
      <table class="table table-sm">
        <thead>
          <tr>
            <th scope="col">Reunión</th>
            <th scope="col">Descargar Citatorio</th>
            <th scope="col">Descargar Orden</th>
            <th scope="col">Borrar</th>
            <th scope="col">Subir Citatorio</th>
            <th scope="col">Subir Orden</th>
            <th scope="col">Ver Citatorio</th>
            <th scope="col">Ver Orden</th>
            <th scope="col">Enviar Citatorio</th>
            <th scope="col">Enviar Orden</th>
            <th scope="col">Info</th>
          </tr>
        </thead>
        <tbody>
          @foreach($citatorios as $citatorio)
          <tr>
            <td>{{fecha($citatorio->fecha())}}</td>
            <td>
              <a href="{{url('/citatorio_pdf/'.$citatorio->id)}}" target= "_blank">
              <img src="{{asset('imagenes/eye.png')}}" style="width:25px;">
              </a>
            </td>
            <td>
              <a href="{{url('storage/subidas/orden'.$citatorio->id.'.pdf')}}" target= "_blank">
                <img src="{{asset('imagenes/eye.png')}}" style="width:25px;">
              </a>
            </td>
            <td>
              <form method="POST" action="{{url('/citatorio/'.$citatorio->id)}}">
              {{csrf_field()}}
              {{method_field('DELETE')}}
              <input type="image" src="{{ asset('imagenes/eliminar.png')}}" style="width:23px;">
              </form>
            </td>
            <td>
              <input type="image" data-toggle="modal" data-target="#modalsubir" src="{{ asset('imagenes/subir.png')}}" style="width:25px;" onclick="document.getElementById('formsubir').action = '/citatorio/{{$citatorio->id}}'; document.getElementById('subirfile').value = ''; document.getElementById('labelpdf').innerHTML = 'Elegir Archivo PDF';">
            </td>
            <td>
              <input type="image" data-toggle="modal" data-target="#modalsubir" src="{{ asset('imagenes/subir.png')}}" style="width:25px;" onclick="document.getElementById('formsubir').action = '/updateorden/{{$citatorio->calendario_id}}'; document.getElementById('subirfile').value = ''; document.getElementById('labelpdf').innerHTML = 'Elegir Archivo PDF';">
            </td>
            <td>
              <a href="{{url('storage/'.$citatorio->archivo)}}" target= "_blank">
                <img src="{{asset('imagenes/eye.png')}}" style="width:25px;">
              </a>
            </td>
            <td>
              <a href="{{url('storage/'.$citatorio->acta_file)}}" target= "_blank">
                <img src="{{asset('imagenes/eye.png')}}" style="width:25px;">
              </a>
            </td>
            <td>
              <a href="{{url('/citatorio/enviar/'.$citatorio->id)}}">
                <button type="button" class="btn btn-outline-success sm">{{$citatorio->enviado ? 'Enviado' : 'Enviar' }}</button>
              </a>  
            </td>
            <td>
              <a href="{{url('/ordendia/enviar/'.$citatorio->calendario_id)}}">
                <button type="button" class="btn btn-outline-success sm">Enviar</button>
              </a>  
            </td>
            <td>
              <button type="button" class="btn btn-default" onclick="vercita({{$citatorio->id}})">
              <span class="fa fa-question-circle"  aria-hidden="true"></span>
              </button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
     </div>
      {{$citatorios->links()}}
    </div>
   </div>
  </div>
  
 </div>  
</div>


<div class="modal fade" id="modalvisto" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Citatorio visto por:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">                
        <div class="col-12">
        @foreach($usuarios as $usuario)
        <label><input class="case" type="checkbox" id="check{{$usuario->identificador}}" name="multipled[]"> {{$usuario->nombre_completo()}}</label><br>
        @endforeach
        </div>            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>       
      </div>
    </div>
  </div>
</div>
@include('layouts.modals.file')

@endsection





@section('script')
<script src="{{ asset('js/citatorio.js') }}"></script>
@endsection