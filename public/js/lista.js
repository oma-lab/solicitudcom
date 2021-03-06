function rol(rol,ide){
  document.getElementById('ident').innerHTML = ide;
  document.getElementById('estudiante').style.display = 'none';
  document.getElementById('profesorcarrera').style.display = 'none';
  document.getElementById('docente').style.display = 'none';
  if(rol == 'estudiante'){
    document.getElementById('estudiante').style.display = 'block'; 
  }else if(rol == 'docente'){
    document.getElementById('profesorcarrera').style.display = 'block'; 
    document.getElementById('docente').style.display = 'block';
  }else{
    document.getElementById('docente').style.display = 'block';
  } 
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
      avanzar = false;
      $('#notasolicitud').text('Faltan datos por completar, verifique carrera y semestre');
    }
  }
  if($('#check2').prop('checked')){
    if(($('#adscripcion_id').val() != "") && ($('#carrera_profesor').val() != "")){
      avanzar = true;
    }else{
      avanzar = false;
      $('#notasolicitud').text('Faltan datos por completar, verifique adscripcion y carrera de profesor');
    }
  }
  if($('#check6').prop('checked')){
    if($('#adscripcion_id').val() != ""){
      avanzar = true;
    }else{
      avanzar = false;
      $('#notasolicitud').text('Faltan datos por completar, verifique adscripcion');
    }
  }
  if(avanzar){
    if($('#check4').prop('checked')){
      if($('#respuesta_rec').val() != ""){
        avanzar = true;
      }else{
        avanzar = false;
        $('#notasolicitud').text('Por favor ingrese la respuesta(SI|NO)');
      }
    }
    if($('#check5').prop('checked')){
      if($('#respuesta_dic').val() != ""){
        avanzar = true;
      }else{
        avanzar = false;
        $('#notasolicitud').text('Por favor ingrese la respuesta(SI|NO)');
      }
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