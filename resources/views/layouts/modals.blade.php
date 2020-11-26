<!-- Modal Ver Observaciones-->
<div class="modal fade" id="modalverobservacion" tabindex="-1" role="dialog" aria-labelledby="verobservacionModalCenterTitle" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="verobservacionModalLongTitle">RECIBIDO/VOTADO POR:</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
    </button>
   </div>
   <div class="modal-body">
   Votos SI:<b id="si"></b> ---------   Votos NO:<b id="no"></b>
    <table class="table table-condensed" id="tablaobservaciones">
     <thead class="thead-light">
      <tr>
       <th scope="col">Nombre</th>
       <th scope="col">Observacion</th>
       <th scope="col">Voto</th>
      </tr>
     </thead>
     <tbody>   
     </tbody>
    </table>  
     <h5 id="sinregistro" style="text-align:center"></h5> 
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
   </div>
  </div>
 </div>
</div>
<!-- Fin Modal Observaciones-->

<!-- Modal Historial-->
<div class="modal fade" id="modalhistorial" tabindex="-1" role="dialog" aria-labelledby="historialModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="historialModalCenterTitle">HISTORIAL USUARIO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <h5 id="sinre" style="text-align:center"></h5>
      <table class="table table-condensed" id="tablahistorial">
        <thead class="thead-light">
            <tr>
             <th scope="col">Asunto</th>
             <th scope="col">Ver Dictamen</th>
           </tr>
        </thead>
        <tbody>   
        </tbody>
      </table>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Fin Modal Historial-->