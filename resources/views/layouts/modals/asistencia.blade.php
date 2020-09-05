<!-- Modal Generar Lista-->
<div class="modal fade" id="nuevalista" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5>NUEVA LISTA</h5><br>        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{url('/listaasistencia')}}" enctype="multipart/form-data">
      {{ csrf_field()}}
      <div class="modal-body">
      <div class="form-inline">
        <label class="mb-3"><b>Fecha de Reunión:</b></label>
        <select class="custom-select ml-2 mb-3" name="calendario_id" required>
          <option value="">Elija fecha de reunión</option>
          @foreach($reuniones as $r)
          <option value="{{$r->id}}" {{$r['start'] == hoy() ? 'selected' : ''}}>{{fecha($r->start)}}</option>
          @endforeach
        </select>
      </div>     
      <table class="table table-condensed" id="tabla">
        <thead class="thead-light">
            <tr>
             <th scope="col">Nombre</th>
             <th scope="col">Departamento</th>
             <th scope="col">Asistencia</th>
           </tr>
        </thead>
        <tbody>   
            @foreach($integrantes as $integrante)
            <tr>
            <td>
              {{$integrante->nombre_completo()}}
             <input type="hidden" name="identificador[]" value="{{$integrante->identificador}}">      
           </td>
           <td>{{$integrante->nombre_adscripcion()}}</td>
           <td>
           <select class="custom-select" name="asistencia[]">
              <option value="ASISTENCIA" selected>ASISTENCIA</option>
                 <option value="FALTA">FALTA</option>
                 <option value="RETARDO">RETARDO</option>
                 <option value="JUSTIFICACION">JUSTIFICACIÓN</option>
            </select>
            </td>
           </tr>
           @endforeach
        </tbody>
      </table>        
      </div>
      <div class="modal-footer">        
        <input type="button" onclick="addInvitado()" class="btn btn-warning" id="btn_agregar" value="+Invitado">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">GUARDAR</button>      
      </div>
      </form>
    </div>
  </div>
 </div>
 <!-- Fin Modal Generar Lista-->