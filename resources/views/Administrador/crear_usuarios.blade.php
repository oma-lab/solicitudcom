@extends('layouts.encabezadoAdmin')
@section('contenido')
<br>
<div class="container ">
 <div class="card mt-0 pt-1">
  @include('layouts.filtrado.mensaje')
  <h3 class="text-center default-text py-1"><i class="fa fa-user solid"></i>NUEVO USUARIO</h3>
  <form method="POST" action="{{ route('registrar.usuario') }}">
   @csrf
   <span id="reauth-email" class="reauth-email"></span>

   <div class="form-row">    
    <div class="form-group col-12 col-sm-3 col-md-3  col-lg-3 col-xl-3">
     <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-id-card-o prefix grey-text"></i></span>
      </div>
      <input id="identificador" name="identificador" type="text" class="form-control @error('identificador') is-invalid @enderror" value="{{ old('identificador') }}" required autocomplete="off" autofocus placeholder="*nombreusuario">
      @error('identificador')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
     </div>
    </div>
    
    <div class="form-group col-12 col-sm-3  col-md-3  col-lg-3 col-xl-3">
     <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-university prefix grey-text"></i></span>
      </div>
      <select id="role_id" class="form-control" name="role_id" required>
        <option value="">ELIGE ROL</option>
        @foreach($roles as $rol)
        <option value="{{$rol->id}}" {{old('role_id') == $rol['id'] ? 'selected' : '' }}>{{$rol->nombre_rol}}</option> 
        @endforeach
      </select>
     </div>
    </div>
    
    <div class="form-group col-12 col-sm-6  col-md-6  col-lg-6 col-xl-6">
     <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-university prefix grey-text"></i></span>
      </div>
      <select id="adscripcion_id" class="form-control" name="adscripcion_id" required>
        <option value="">ADSCRIPCION</option>
        @foreach($datosadscripcion as $adscripcion)
        <option value="{{$adscripcion->id}}" {{old('adscripcion_id') == $adscripcion['id'] ? 'selected' : '' }} >{{$adscripcion->nombre_adscripcion}}</option> 
        @endforeach
      </select>
     </div>
    </div>    
    <input type="hidden" name="carrera_id" value="">
   </div>

   <div class="form-row">
    <div class="form-group col-12 col-sm-3  col-md-3  col-lg-3 col-xl-3">
     <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-user-circle-o prefix grey-text"></i></span>
      </div>
      <input id="grado" name="grado" type="text" class="form-control @error('grado') is-invalid @enderror" value="{{ old('grado') }}" required autocomplete="off" placeholder="Dra/Dr/Ing/Lic">
     </div>
    </div>

    <div class="form-group col-12 col-sm-3  col-md-3  col-lg-3 col-xl-3">
     <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-user-circle-o prefix grey-text"></i></span>
      </div>
      <input id="nombre" name="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required autocomplete="off" placeholder="*nombre">
      @error('nombre')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
     </div>
    </div>

    <div class="form-group col-12 col-sm-3  col-md-3  col-lg-3 col-xl-3">
     <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-user-circle-o prefix grey-text"></i></span>
      </div>
      <input id="apellido_paterno" name="apellido_paterno" type="text" class="form-control @error('apellido_paterno') is-invalid @enderror" value="{{ old('apellido_paterno') }}" required autocomplete="off" placeholder="*apellido_paterno">
      @error('apellido_paterno')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
     </div>
    </div>

    <div class="form-group col-12 col-sm-3  col-md-3  col-lg-3 col-xl-3">
     <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-user-circle-o prefix grey-text"></i></span>
      </div>
      <input id="apellido_materno" name="apellido_materno" type="text" class="form-control @error('apellido_materno') is-invalid @enderror" value="{{ old('apellido_materno') }}" autocomplete="off" placeholder="*apellido_materno">
      @error('apellido_materno')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
     </div>
    </div>
   </div>

   <div class="form-row">
    <div class="form-group col-12 col-sm-3  col-md-3  col-lg-3 col-xl-3">
     <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-male prefix grey-text"></i></span>
      </div>
      <select id="sexo" class="form-control" name="sexo" required>
        <option value="">SELECCIONA SEXO</option>
        <option value="H" {{old('sexo') == 'H' ? 'selected' : '' }}>HOMBRE</option>
        <option value="M" {{old('sexo') == 'M' ? 'selected' : '' }}>MUJER</option>
      </select>
     </div>
    </div>
    
    <div class="form-group col-12 col-sm-3  col-md-3  col-lg-3 col-xl-3">
     <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-mobile-phone prefix grey-text"></i></span>
      </div>
      <input id="celular" name="celular" type="text" class="form-control @error('celular') is-invalid @enderror" value="{{ old('celular') }}" autocomplete="off" placeholder="celular / este campo no es obligatorio">
      @error('celular')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
     </div>
    </div>

    <div class="form-group col-12 col-sm-3  col-md-3 col-lg-3 col-xl-3">
     <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-phone-square prefix grey-text"></i></span>
      </div>
      <input id="telefono" name="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}" autocomplete="off" placeholder="telefono/ este campo no es obligatorio">
      @error('telefono')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
     </div>
    </div>
   </div>

       

       
   PERMISOS, SOLICITUDES A RECIBIR:
   <div class="form-row">
    <div class="form-group col-12 col-sm-6  col-md-6  col-lg-6 col-xl-6">
      CARRERAS:<br>
      <input type="checkbox" id="cars" onclick="seleccionar(this,'.cars')">SELECCIONAR TODO<br>
      @foreach($carreras as $carrera)
      <input class="cars" type="checkbox" value="{{$carrera->id}}" name="carrs[]">
      {{$carrera->nombre}}<br>
      @endforeach
    </div>
    
    <div class="form-group col-12 col-sm-6  col-md-6  col-lg-6 col-xl-6">
      DOCENTES:<br>
      <input type="checkbox" id="adsc" onclick="seleccionar(this,'.adsc')">SELECCIONAR TODO<br>
      @foreach($adscripciones as $adscripcion)
      <input class="adsc" type="checkbox" value="{{$adscripcion->id}}" name="adscs[]">
      {{$adscripcion->nombre_adscripcion}}<br>
      @endforeach
    </div>
   </div>



   <div class="form-row">
    <div class="form-group col-12 col-sm-12  col-md-12  col-lg-12 col-xl-12">
     <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fa fa-envelope prefix grey-text"></i></span>
      </div>
      <input id="email" name="email" title="Correo electronico" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" autocomplete="off" placeholder="Correo electronico">
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
       <a href="{{route('usuarios','estudiante')}}"><button class="btn btn-danger" type="button"> Cancelar </button></a>
     </div>
   </div>


               
  </form>
 </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/marcar.js') }}"></script>
@endsection