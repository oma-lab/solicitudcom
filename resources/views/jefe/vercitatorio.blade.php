@extends(Auth::user()->esSub() ? 'layouts.encabezadosub' : 'layouts.encabezadojefe')
@section('contenido')


<div class="container">
   <div class="card">
     <br><br>
     <div class="embed-responsive embed-responsive-16by9">
       <iframe class="embed-responsive-item" src="{{asset('storage/'.$citatorio->archivo)}}" allowfullscreen></iframe>
     </div>
   </div>
</div>



@endsection
