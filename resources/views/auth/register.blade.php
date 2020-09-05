@extends('layouts.encabezado')
@section('title') REGISTRO @endsection
@section('contenido')
<div class="container ">
 <div class="card mt-2 mb-0 p-0">
  <div class="card-header">
   <nav>
    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
     <a class="nav-item nav-link {{$rol == 3 ? 'active' : ''}}" href="{{route('register','estudiante')}}">ESTUDIANTE</a>
	   <a class="nav-item nav-link {{$rol == 4 ? 'active' : ''}}" href="{{route('register','docente')}}">DOCENTE</a>
    </div>
   </nav>
  </div>
 </div>
 <div class="card mt-0 pt-1">
  <form method="POST" action="{{ route('registrar') }}">
  @csrf
  <div class="form-row">
   <div class="form-group col-12 col-sm-5 col-md-5  col-lg-5 col-xl-5">
    <div class="input-group">
     <div class="input-group-prepend">
     <span class="input-group-text"><i class="fa fa-id-card-o prefix grey-text"></i></span>
     </div>
     <input id="identificador" name="identificador" type="text" class="form-control @error('identificador') is-invalid @enderror" 
     value="{{ old('identificador') }}" required onkeyup="this.value=this.value.toUpperCase()" autofocus placeholder="{{$rol == 3 ? '*Número de control' : '*RFC'}}">
     @error('identificador')
     <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
     </span>
     @enderror
    </div>
   </div>
   <div class="form-group col-12 col-sm-7  col-md-7  col-lg-7 col-xl-7">
    <b id="mensaje" style="color:red"></b>
   </div>
  </div>
  <div class="form-row">
   <div class="form-group col-12 col-sm-4  col-md-4  col-lg-4 col-xl-4">
    <div class="input-group">
     <div class="input-group-prepend">
      <span class="input-group-text"><i class="fa fa-user-circle-o prefix grey-text"></i></span>
     </div>
     <input id="nombre" name="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus placeholder="*nombre">
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
     <input id="apellido_paterno" name="apellido_paterno" type="text" class="form-control @error('apellido_paterno') is-invalid @enderror" value="{{ old('apellido_paterno') }}" required autocomplete="apellido_paterno"  autofocus placeholder="*apellido_paterno">
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
    <input id="apellido_materno" name="apellido_materno" type="text" class="form-control @error('apellido_materno') is-invalid @enderror" value="{{ old('apellido_materno') }}" autocomplete="apellido_materno"  autofocus placeholder="*apellido_materno">
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
    <input id="celular" name="celular" type="text" class="form-control @error('celular') is-invalid @enderror" value="{{ old('celular') }}" autocomplete="celular" autofocus placeholder="celular / este campo no es obligatorio">
    @error('celular')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>
  </div>

  <div class="form-group col-12 col-sm-6  col-md-6  col-lg-6 col-xl-6">
  <div class="input-group">
    <div class="input-group-prepend">
     <span class="input-group-text"><i class="fa fa-phone-square prefix grey-text"></i></span>
    </div>
    <input id="telefono" name="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}"  autocomplete="telefono" autofocus placeholder="telefono/ este campo no es obligatorio">
     @error('telefono')
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
      <span class="input-group-text"><i class="fa fa-male prefix grey-text"></i></span>
     </div>
     <select id="sexo" class="form-control @error('sexo') is-invalid @enderror" name="sexo" required>
     <option value="">SELECCIONA SEXO</option>
     <option value="H" {{old('sexo') == 'H' ? 'selected' : ''}}>HOMBRE</option>
     <option value="M" {{old('sexo') == 'M' ? 'selected' : ''}}>MUJER</option>
     </select>
     @error('sexo')
     <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
     </span>
     @enderror
   </div>
   </div>

   <div class="form-group col-12 col-sm-6  col-md-6  col-lg-6 col-xl-6">
   <div class="input-group">
     <div class="input-group-prepend">
      <span class="input-group-text"><i class="fa fa-university prefix grey-text"></i></span>
     </div>
     @if($rol == 4)
     <select id="adscripcion_id" class="form-control @error('adscripcion_id') is-invalid @enderror" name="adscripcion_id" required>
       <option value="">ADSCRIPCION</option>
       @foreach($adscripciones as $adscripcion)
       <option value="{{$adscripcion->id}}" {{old('adscripcion_id') == $adscripcion['id'] ? 'selected' : ''}}>{{$adscripcion->nombre_adscripcion}}</option> 
       @endforeach
     </select>
     <input type="hidden" name="carrera_id" value="">
     @error('adscripcion_id')
     <span class="invalid-feedback" role="alert">
       <strong>{{ $message }}</strong>
     </span>
     @enderror
     @else
     <select id="carrera_id" class="form-control @error('carrera_id') is-invalid @enderror" name="carrera_id" required>
       <option value="">SELECCIONA TU CARRERA</option>
       @foreach($carreras as $carrera)
       <option value="{{$carrera->id}}" {{old('carrera_id') == $carrera['id'] ? 'selected' : ''}}>{{$carrera->nombre}}</option> 
       @endforeach
     </select>
     <input type="hidden" name="adscripcion_id" value="">
     @error('carrera_id')
     <span class="invalid-feedback" role="alert">
       <strong>{{ $message }}</strong>
     </span>
     @enderror     
     @endif
   </div>
   </div>
   <input type="hidden" name="role_id" value="{{$rol}}">
   <input type="hidden" name="grado" value="">
   </div>

   <div class="form-row">
   <div class="form-group col-12 col-sm-12  col-md-12  col-lg-12 col-xl-12">
   <div class="input-group">
    <div class="input-group-prepend">
     <span class="input-group-text"><i class="fa fa-envelope prefix grey-text"></i></span>
    </div>
    <input id="email" name="email" title="Correo electronico" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="*correo electronico">
    @error('email')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>
  </div>
  </div>

  <div class="form-row">
  <div class="form-group col-12 col-sm-12  col-md-12  col-lg-12 col-xl-12">
  <div class="input-group">
    <div class="input-group-prepend">
     <span class="input-group-text"><i class="fa fa-lock prefix grey-text"></i></span>
    </div>
    <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password" placeholder="*contraseña /la contraseña debe contener al menos 6 caracteres">
    @error('password')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>
  </div>
  </div>

  <div class="form-row">
  <div class="form-group col-12 col-sm-12  col-md-12  col-lg-12 col-xl-12">
  <div class="input-group">
   <div class="input-group-prepend">
    <span class="input-group-text"><i class="fa fa-lock prefix grey-text"></i></span>
   </div>
   <input id="password-confirm" name="password_confirmation" type="password" class="form-control" required autocomplete="new-password" placeholder="*confirmar contraseña">
  </div>
  </div>
  </div>
  
 
  <div class="row">
     <div class="col centrado">
       <button type="submit" class="btn btn-primary">Registrar</button>
     </div> 
     <div class="col centrado"> 
       <a href="{{route('login')}}"><button class="btn btn-danger" type="button"> Cancelar </button></a>
     </div>
  </div>


 </form>
 </div> 
</div>
@endsection