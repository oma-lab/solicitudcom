<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link type="text/css" href="{{ asset('css/app.css')}}" rel="stylesheet">
    <!-- CSS-->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
      
    <title>INICIO</title>
  </head>

  @include('layouts.header')

  <div class="container">
    <div class="card card-container">
      <img id="profile-img" class="profile-img-card" src="{{ asset('imagenes/login2.png') }}" />
      <h4 class="centrar">Iniciar sesión</h4>

      <form class="form-signin" method="POST" action="{{ route('login') }}">
      @csrf
      <span id="reauth-email" class="reauth-email"></span>

      <input id="identificador" type="text" class="form-control @error('identificador') is-invalid @enderror" name="identificador" value="{{ old('identificador') }}" placeholder="Num.Control/RFC" required autofocus>
      @error('identificador')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror

      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Contraseña" required autocomplete="current-password">
      @error('password')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror 

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label" for="remember">
        {{ __('Recordarme') }}
        </label>
      </div>
      <br>     
      <div>                            
        <button type="submit" class="btn btn-lg btn-primary btn-block btn-signin">
        {{ __('Iniciar sesión') }}
        </button>
        <a href="{{ route('password.request') }}">
        {{ __('¿Olvidaste tu Contraseña?') }}
        </a> 
        <br>
        <a href="{{ route('register','estudiante') }}">
        {{ __('Registrarme') }}
        </a>                          
      </div>
      </form>

    <div>                        
  </div>
  
</html>