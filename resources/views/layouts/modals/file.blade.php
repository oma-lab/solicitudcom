<!-- Modal -->
<div class="modal fade" id="modalsubir" data-backdrop="static">
 <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
  <form id="formsubir" method="POST" action="#" enctype="multipart/form-data" onsubmit="formFileDisabled()">
  {{csrf_field()}}
  {{method_field('PATCH')}}
  <div class="modal-header">
   <h5>Elige tu archivo</h5>
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
   </button>
  </div>
  <div class="modal-body">   
   @if(usuario()->esSolicitante())    
   <b style="color:blue">Asegúrate que tu solicitud y evidencias sean claras, que no tengan un fondo muy obscuro y tu hoja debe estar de manera vertical, cualquier omisión de estas indicaciones anulará tu solicitud.</b><br> 
   <b style="color:green">*No olvides tus evidencias, recuerda que son las que sustentan tu solicitud.</b>                     
   @endif
   <div class="form-row">               
    <div class="form-group col-md-12">
     <label for="archivo"><b>{{(usuario()->esSolicitante()) ? 'Formato firmado y evidencias' : 'Formato firmado'}} (Solo se admiten archivos PDF)</b></label>
     <div class="custom-file">
      <input type="file" class="custom-file-input" id="subirfile" name="doc_firmado" accept="application/pdf" required>
      <label id="labelpdf" class="custom-file-label" for="subirfile">Elegir Archivo PDF</label>
      <div class="invalid-feedback">Archivo invalido</div>
      <b id="infpdf" style="color:red"></b>
     </div>
    </div>
   </div>
  </div>
  <div class="modal-footer">
   <div class="loader"></div>
   <button id="btnclose" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
   <button id="btnfd" type="submit" class="btn btn-primary">Guardar</button>
  </div>
  </form>
  </div>
 </div>
</div>
<!--Fin Modal -->