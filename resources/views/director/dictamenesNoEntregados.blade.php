@extends(Auth::user()->esAdmin() ? 'layouts.encabezadoAdmin' : 'layouts.encabezadoDirector')

@section('contenido')
<section class=" ">
 <div class="container-fluid">
  
  <div class="row">
   <div class="col-md-12 text-center">            
    <nav class="nav-justified ">
     <div class="nav nav-tabs">
       <a class="nav-item nav-link" href="{{route('director.dictamenes','pendientes')}}">DICTAMENES PENDIENTES</a>
       <a class="nav-item nav-link active">NO ENTREGADOS</a>
       <a class="nav-item nav-link" href="{{route('director.dictamenes','terminados')}}">ENTREGADOS-FINALIZADOS</a>
     </div>
    </nav>
   </div>
  </div>

  <div class="row justify-content-center">
   <div class="col-md-12">
    <div class="card">

    @include('layouts.filtrado.mensaje')

    
     <div class="card-body">                    
      <h5 style="text-align:center"><b>SELLECCIONE LOS DICTAMENES QUE YA FUERÓN ENTREGADOS A LOS DEPARTAMENTOS DE CARRERA</b></h5>             
      @foreach($carreras as $carrera)
      </br></br>
      <div class="row">
       <div class="col-6">
        <h6 style="text-transform: uppercase;"><b>{{$carrera->nombre}}</b></h6>
       </div>
       <div class="col-6">
       TODOS <input type="checkbox" id="todo{{$carrera->id}}" onclick="todo(this,{{$carrera->id}});">
       </div>
      </div>
      <form method="POST" action="{{route('entregar.dictamen')}}" enctype="multipart/form-data">
      {{csrf_field()}}
      @foreach($dictamenes as $dn)
      @if($dn->usuario()->carrera_id == $carrera->id)
      <div class="row">
       <div class="col-6">
         <p style="text-align:justify">{{$dn->usuario()->nombre_completo()}}.</p>
       </div>
       <div class="col-6">
         <input class="case{{$carrera->id}}" type="checkbox" value="{{$dn->id}}" name="dictams[]" onclick="marcar({{$carrera->id}});">
       </div>
      </div>
      @endif
      @endforeach
      <hr style="height: 8px;"/>
      @endforeach
      <div class="row">
       <div class="col-6">
         <h6 style="text-transform: uppercase;"><b>DOCENTES</b></h6>
       </div>
       <div class="col-6">
       TODOS <input type="checkbox" id="todo30" onclick="todo(this,30);">
       </div>
      </div>
      @foreach($dictamenes as $dn)
      @if($dn->usuario()->esDocente())
      <div class="row">
       <div class="col-6">
         <p style="text-align:justify">{{$dn->usuario()->nombre_completo()}}.</p>
       </div>
       <div class="col-6">
         <input class="case30" type="checkbox" value="{{$dn->id}}" name="dictams[]" onclick="marcar(30);">
       </div>
      </div>
      @endif
      @endforeach
      <hr style="height: 8px;"/>
      <button type="submit" class="btn btn-primary">Guardar</button>
      </form>        
     </div>
    </div>
   </div>
  </div>

 </div>
</section>
@endsection

@section('script')
<script src="{{ asset('js/marcar.js') }}"></script>
@endsection  