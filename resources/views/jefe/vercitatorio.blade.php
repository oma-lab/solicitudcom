@extends('layouts.encabezadojefe')
@section('contenido')


<div class="container">
   <div class="card">
     <form method="POST" action="#" enctype="multipart/form-data">
     {{ csrf_field()}}
     <label>Recibido por:</label><br>
     @foreach($citrec as $crec)
     <div class="form-check form-check-inline">
       <input class="form-check-input" type="checkbox" id="check_box" value="option1" {{$crec['num'] == 2 ? 'checked' : '' }}>
       <label class="form-check-label" for="check_box">{{$crec->user->nombre}}</label>
     </div> 
     @endforeach          
     </form>
     <br><br>
     <div class="embed-responsive embed-responsive-16by9">
       <iframe class="embed-responsive-item" src="{{asset('storage/'.$citatorio->archivo)}}" allowfullscreen></iframe>
     </div>
   </div>
</div>



@endsection
