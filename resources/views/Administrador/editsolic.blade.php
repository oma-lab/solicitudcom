@extends('layouts.encabezadoAdmin')
@section('contenido')
<h3 class="centrado" style="color:#1B396A">MODIFICAR SOLICITUD</h3>
<div class="container-sm">
  <form method="POST" action="{{route('guardar.solicitud',$solicitud->id)}}" enctype="multipart/form-data">
  {{ csrf_field()}}
  {{method_field('PATCH')}}
    <div class="form-row">
      <div class="form-group col-md-4 " >
        <label for="nombre">Nombre</label>
        <input type="text" class="form-control form-control-sm" id="nombre" placeholder="{{$solicitud->user->nombre_completo()}}" disabled>
      </div>
      <div class="form-group col-md-2">
        <label for="identificador">Usuario</label>
        <input type="text" class="form-control form-control-sm" id="identificador" placeholder="{{$solicitud->user->identificador }}" disabled>
      </div>
      <div class="form-group col-md-3">
        <label for="area">{{$solicitud->user->tipo_carrera_adscripcion()}}</label>
        <input type="text" class="form-control form-control-sm" id="area" placeholder="{{$solicitud->user->carrera_adscripcion()}}" disabled>
      </div>
    </div>
    
    <div class="form-row">
      <div class="form-group col-md-2 " >
        <label for="calendario_id">Reunión</label>
        <select class="custom-select custom-select-sm" id="calendario_id" name="calendario_id">
          @foreach($reuniones as $reunion)
          <option value="{{$reunion->id}}" {{$solicitud['calendario_id'] == $reunion['id'] ? 'selected' : ''}}>{{fecha($reunion->start)}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="asunto">Asunto:</label>
        <textarea class="form-control" id="asunto" rows="2" name="asunto" disabled required>{{$solicitud->asunto}}</textarea>
      </div>
    </div>
    Recibido por:<br>
    @foreach($obs as $ob)
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" name="usuarios[]" value="{{$ob->user->identificador}}" {{$ob['visto'] == true ? 'checked' : ''}}>
      <label class="form-check-label">{{$ob->user->nombre_completo()}}</label>
    </div> 
    @endforeach
    <br><br>

    <div class="row">
      <div class="col centrado">
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div> 
      <div class="col centrado"> 
        <a href="{{route('home')}}"><button class="btn btn-danger" type="button"> Cancelar </button></a>
      </div>
    </div>


  </form>
</div>
@endsection

      

   