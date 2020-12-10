function rol(rol,ide){
  document.getElementById('ident').innerHTML = ide;
  document.getElementById('estudiante').style.display = 'none';
  document.getElementById('docente').style.display = 'none';
  document.getElementById(rol).style.display = 'block';  
}

function documento(tipo){
  var x = document.getElementsByClassName('documento');
  for (var i = 0; i < x.length; i++) {
    x[i].style.display = 'none';
  }
  document.getElementById(tipo).style.display = 'block';
}

function esSolicitud(){
  var avanzar = false;
  if($('#check1').prop('checked')){
    if(($('#carrera_id').val() != "") && ($("#semestre").val().length > 0)){
      avanzar = true;
    }else{
      $('#notasolicitud').text('Faltan datos por completar, verifique carrera y semestre');
    }
  }
  if($('#check2').prop('checked')){
    if(($('#adscripcion_id').val() != "") && ($('#carrera_profesor').val() != "")){
      avanzar = true;
    }else{
      $('#notasolicitud').text('Faltan datos por completar, verifique adscripcion y carrera de profesor');
    }
  }
  if(avanzar){
    $('#botongenerar').prop('disabled',true);
    if($('#check3').prop('checked')){
      $('#botonesaccion').css('visibility', 'hidden');
      $('#botoneshecho').css('visibility', 'visible');
      $('#notasolicitud').text('Espere un momento, la solicitud se descargará automáticamente, una vez descargado puede continuar con el proceso en la sección de solicitudes');
    }
  }else{
    return false;
  }
}


//funcion para agregar invitados a la lista de forma dinamica
function addInvitado(){  
document.getElementById("tabla").insertRow(-1).innerHTML = 
'<td><input type="text" class="form-control" required name="invitados[]">'+
'</input></td><td><input type="text" class="form-control" required name="puestos[]">'+
'</input></td><td> <select class="custom-select">'+
'<option value="ASISTENCIA" selected>ASISTENCIA</option>'+
'</select></td>';
}