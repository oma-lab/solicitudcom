@extends('layouts.encabezado')
@section('title') RESTABLECER CONTRASEÑA @endsection
@section('contenido')
<div class="container">
 <div class="row justify-content-center">
  <div class="col-md-8">
   <div class="card">
    <div class="card-header"><b>{{ __('Restablecer Contraseña') }}</B></div>

    <div class="card-body">
     <div>{{__('Enviaremos un enlace a su correo electrónico para restablecer su contraseña')}}</div><br>
     @if (session('status'))
     <div class="alert alert-success" role="alert">
        {{ session('status') }}
     </div>
     @endif

     <form method="POST" action="{{ route('password.email') }}">
     @csrf

     <div class="form-group row">
       <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo Electrónico') }}</label>

       <div class="col-md-6">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="ingrese correo registrado" required autocomplete="email" autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
       </div>
     </div>

     <div class="form-group row mb-0">
      <div class="col-md-6 offset-md-4">                                
        <a href="{{route('home')}}"><button type="button" class="btn btn-danger">
          {{ __('Cancelar') }}
        </button></a>
        <button type="submit" class="btn btn-primary">
          {{ __('Enviar enlace') }}
        </button>
      </div>
     </div>
     </form>
    </div>
   </div>
  </div>
 </div>
</div>
@endsection
