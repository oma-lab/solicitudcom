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


//funcion para agregar invitados a la lista de forma dinamica
function addInvitado(){  
document.getElementById("tabla").insertRow(-1).innerHTML = 
'<td><input type="text" class="form-control" required name="invitados[]">'+
'</input></td><td><input type="text" class="form-control" required name="puestos[]">'+
'</input></td><td> <select class="custom-select">'+
'<option value="ASISTENCIA" selected>ASISTENCIA</option>'+
'</select></td>';
}