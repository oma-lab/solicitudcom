@extends($encabezado)
@section('title')ACTUALIZAR USUARIO @endsection
@section('contenido')


<div class="container">
@include('layouts.filtrado.mensaje')
 
<div class="card mt-1 pt-1">
 <form method="POST" action="{{('/usuarios/'.$usuario->id)}}" enctype="multipart/form-data">
 {{ csrf_field()}}
 {{method_field('PATCH')}}
 <h5 style="text-align:center"><b><i class="fa fa-user solid"></i> ACTUALIZAR DATOS</b></h5>

 <div class="form-row">
  <div class="form-group col-12 col-sm-5 col-md-5  col-lg-5 col-xl-5">
   <div class="input-group">
    <div class="input-group-prepend">
     <span class="input-group-text"><i class="fa fa-id-card-o prefix grey-text"></i></span>
    </div>
    <input id="identificador" name="identificador" type="text" class="form-control @error('identificador') is-invalid @enderror" value="@if(old('identificador')){{old('identificador')}}@else{{$usuario->identificador}}@endif" required placeholder="*{{usuario()->tipo_id()}}">
    @error('identificador')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
    @enderror
   </div>
  </div>
 </div>
      
 @if($usuario->role_id != 9)
 <div class="form-row">
  <div class="form-group col-12 col-sm-4  col-md-4  col-lg-4 col-xl-4">
   <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text"><i class="fa fa-user-circle-o prefix grey-text"></i></span>
    </div>
    <input id="nombre" name="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" value="{{$usuario->nombre}}" required autocomplete="nombre" placeholder="*nombre">       
    @error('nombre')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
    @enderror
   </div>
  </div>
 
  <div class="form-group col-12 col-sm-4  col-md-4  col-lg-4 col-xl-4">
   <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text"><i class="fa fa-user-circle-o prefix grey-text"></i></span>
    </div>
    <input id="apellido_paterno" name="apellido_paterno" type="text" class="form-control @error('apellido_paterno') is-invalid @enderror" value="{{$usuario->apellido_paterno}}" required autocomplete="apellido_paterno" placeholder="*apellido_paterno">       
    @error('apellido_paterno')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror 
   </div>
  </div>

  <div class="form-group col-12 col-sm-4  col-md-4  col-lg-4 col-xl-4">
   <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text"><i class="fa fa-user-circle-o prefix grey-text"></i></span>
    </div>
    <input id="apellido_materno" name="apellido_materno" type="text" class="form-control @error('apellido_materno') is-invalid @enderror" value="{{$usuario->apellido_materno}}" autocomplete="apellido_materno" placeholder="*apellido_materno">
    @error('apellido_materno')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
   </div>
  </div>
 </div>

 <div class="form-row">
  <div class="form-group col-12 col-sm-6  col-md-6  col-lg-6 col-xl-6">
   <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text"><i class="fa fa-mobile-phone prefix grey-text"></i></span>
    </div>
    <input id="celular" name="celular" type="text" class="form-control @error('celular') is-invalid @enderror" value="{{$usuario->celular}}" placeholder="celular / este campo no es obligatorio">
   </div>
  </div>

  <div class="form-group col-12 col-sm-6  col-md-6  col-lg-6 col-xl-6">
   <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text"><i class="fa fa-phone-square prefix grey-text"></i></span>
    </div>
    <input id="telefono" name="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" value="{{$usuario->telefono}}"  placeholder="telefono/ este campo no es obligatorio">
   </div>
  </div>
 </div>

 <div class="form-row">
  <div class="form-group col-12 col-sm-6  col-md-6  col-lg-6 col-xl-6">
   <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text"><i class="fa fa-male prefix grey-text"></i></span>
    </div>
    <select id="sexo" class="form-control" name="sexo">
      <option value="H" {{$usuario['sexo'] == 'H' ? 'selected' : '' }}>HOMBRE</option>
      <option value="M" {{$usuario['sexo'] == 'M' ? 'selected' : '' }}>MUJER</option>
    </select>
   </div>
  </div>

  <div class="form-group col-12 col-sm-6  col-md-6  col-lg-6 col-xl-6">
   <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text"><i class="fa fa-university prefix grey-text"></i></span>
    </div>
    @if($usuario->esEstudiante())
    <select id="carrera_id" class="form-control @error('carrera_id') is-invalid @enderror" name="carrera_id" required>
      <option value="">SELECCIONA CARRERA</option>
      @foreach($ads_carreras as $carrera)
      <option value="{{$carrera->id}}" {{$usuario['carrera_id'] == $carrera['id'] ? 'selected' : ''}}>{{$carrera->nombre}}</option>
      @endforeach
    </select>
    @else
    <select id="adscripcion_id" class="form-control @error('adscripcion_id') is-invalid @enderror" name="adscripcion_id" required>
      <option value="">SELECCIONA ADSCRIPCIÓN</option>
      @foreach($ads_carreras as $adscripcion)
      <option value="{{$adscripcion->id}}" {{$usuario['adscripcion_id'] == $adscripcion['id'] ? 'selected' : ''}}>{{$adscripcion->nombre_adscripcion}}</option>
      @endforeach
    </select>
    @endif
   </div>
  </div>
 </div>

 <div class="form-row">
  <div class="form-group col-12 col-sm-12  col-md-12  col-lg-12 col-xl-12">
   <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text"><i class="fa fa-envelope prefix grey-text"></i></span>
    </div>
    <input id="email" name="email" title="Correo electronico" type="email" class="form-control @error('email') is-invalid @enderror" value="@if(old('email')){{old('email')}}@else{{$usuario->email}}@endif" required placeholder="*correo electronico">
    @error('email')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
   </div>
  </div>
 </div>
 @endif

 <div class="form-row">
  <div class="form-group col-12 col-sm-12  col-md-12  col-lg-12 col-xl-12">
   <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text"><i class="fa fa-lock prefix grey-text"></i></span>
    </div>
    <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" placeholder="nueva contraseña/la contraseña debe contener al menos 6 caracteres">         
    @error('password')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
    @enderror
   </div>
  </div>
 </div>

 
 <div class="row">
   <div class="col centrado">
      <button type="submit" class="btn btn-primary">Guardar</button>
   </div> 
   <div class="col centrado">
      @if(Auth::user()->esAdmin())
      <a href="{{route('usuarios','estudiante')}}"><button class="btn btn-danger" type="button"> Cancelar </button></a>
      @else
      <a href="{{route('home')}}"><button class="btn btn-danger" type="button"> Cancelar </button></a>
      @endif   
   </div>
 </div>




 </form>
</div>
</div>
</div>
@endsection