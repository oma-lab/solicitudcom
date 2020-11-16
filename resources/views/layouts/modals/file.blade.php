<!-- Modal -->
<div class="modal fade" id="modalsubir" data-backdrop="static">
 <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
  <form id="formsubir" method="POST" action="#" enctype="multipart/form-data">
  {{csrf_field()}}
  {{method_field('PATCH')}}
  <div class="modal-header">
   <h5>Elige tu archivo</h5>
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
   </button>
  </div>
  <div class="modal-body">                                     
   <div class="form-row">               
    <div class="form-group col-md-12">
     <label for="archivo"><b>Formato Firmado(Solo se admiten archivos PDF)</b></label>
     <div class="custom-file">
      <input type="file" class="custom-file-input" id="subirfile" name="doc_firmado" accept="application/pdf" required>
      <label id="labelpdf" class="custom-file-label" for="subirfile">Elegir Archivo PDF</label>
      <div class="invalid-feedback">Archivo invalido</div>
     </div>
    </div>
   </div>
  </div>
  <div class="modal-footer">
   <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
   <button type="submit" class="btn btn-primary">Guardar</button>
  </div>
  </form>
  </div>
 </div>
</div>
<!--Fin Modal -->