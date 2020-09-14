<nav class="navbar navbar-expand-lg navbar-light bg-light">
 @if(!usuario()->esCoor())
 <select class="filtro form-control mr-sm-2" id="role" name="role_id" style="width:225px">
   <option value="">ESTUDIANTE/DOCENTE</option>
   <option value="3" {{request('role_id') == 3 ? 'selected' : ''}}>ESTUDIANTES</option>
   <option value="4" {{request('role_id') == 4 ? 'selected' : ''}}>DOCENTES</option>
 </select>
 @endif
 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
   <span class="navbar-toggler-icon"></span>
 </button>
 <div class="collapse navbar-collapse" id="menu">
  <select id="filtro" class="filtro form-control mr-sm-2" name="visto" style="width:225px;display:none;">
    <option value="">SOLICITUDES NO VISTAS</option>
    <option value="true" {{request('visto') == 'true' ? 'selected' : ''}}>SOLICITUDES VISTAS</option>
  </select>

  <ul class="navbar-nav mr-auto"></ul>
   @if(request('role_id') != 4)
    <select class="filtro form-control mr-sm-2" id="carreraid" name="carrera_id" style="width:225px">
      <option value="">TODAS LAS CARRERAS</option>
      @foreach($carreras as $carrera)
      <option value="{{$carrera->id}}" {{request('carrera_id') == $carrera['id'] ? 'selected' : ''}}>{{$carrera->nombre}}</option>
      @endforeach
    </select> 
   @endif
   <input class="form-control mr-sm-2" type="search" name="numc" placeholder="Num.Control/RFC" aria-label="Search" value="{{request('numc')}}" style="width:160px">
   <input class="form-control mr-sm-2" type="search" name="nombre" placeholder="nombre/apellido" aria-label="Search" value="{{request('nombre')}}" style="width:160px">
   <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
 </div> 
</nav>