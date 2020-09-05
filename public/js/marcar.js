//funcion para seleccionar todas las carreras o todas las adscripciones
function seleccionar(check,selec){
  $(selec).prop("checked", check.checked); 
}


  
  
function verPermisos(usuario_id){
  $('#iduser').val(usuario_id);
  $.get(url_global+"/carreras",{usuario_id: usuario_id}, function(carreras){
    $('.cars').prop("checked", false);
    $('.adsc').prop("checked", false);
    $.each(carreras.carreras,function(){
      $("#checkcar"+this.carrera_id).prop("checked", true);
    });
    $.each(carreras.adscripciones,function(){
      $("#checkads"+this.adscripcion_id).prop("checked", true);
    });
    $('#nombre_usuario').text(carreras.usuario.nombre);
    document.getElementById("roleid").value = carreras.usuario.role_id;
  });
  $("#modalpermiso").modal("show");
}


//funcion para seleccionar todos los checkbox por cada carrera
function todo(sel,car){
  $(".case"+car).prop("checked", sel.checked);
}

//funcion para marcar/desmarcar la casilla todos por si se marca o desmarca uno
function marcar(car){
  if ($(".case"+car).length == $(".case"+car+":checked").length) {  
   $("#todo"+car).prop("checked", true);  
  }else {  
   $("#todo"+car).prop("checked", false);  
  }  
}