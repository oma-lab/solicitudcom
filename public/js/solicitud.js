function mot(seleccionado,asuntos){
  var valor='';
  var nota='';
  asuntos.forEach(function(asunto){
    if(asunto.asunto == seleccionado.value){
      valor=asunto.asunto;
      nota='  *'+asunto.descripcion;
    }
  });
  if(seleccionado.value == 'Otro'){
    nota= "Describe brevemente tu solicitud si consideras que no se encuentra en ninguna de las anteriores";
  }
  document.getElementById('asunto').value = valor;
  document.getElementById('texto').innerHTML =nota;
  document.getElementById('asunto').focus();
  }

function formdisable(){
document.getElementById('btnsg').disabled=true;
}