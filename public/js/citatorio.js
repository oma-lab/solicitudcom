//funcion para mostrar al secretario el modal que le servira para ver quien ya recibio el citatorio
function vercita(id){
  $(".case").prop("checked", false);
  if($.trim(id) != ''){
     $.get(url_global+"/cita",{id: id}, function(vistos){
       $.each(vistos,function(index,value){
         if(value.num == 2 || value.visto){
         $("#check"+value.identificador).prop("checked", true);
         }else{
          $("#check"+value.identificador).prop("checked", false);
         }
       });
     });
  }
  $("#modalvisto").modal("show");
}

$('.dis').on('click', function(){
  var chk= !this.checked;
  $(this).prop("checked",chk);
});

function addOrden(){
  campo = '<div class="form-group"><input class="form-control" name="ordens[]" type="text" placeholder=""></div>';
  $("#orden").append(campo);
}

function formdisable(){
  document.getElementById('btncg').disabled=true;
  document.getElementById('btncg').innerText = "Generando...";
}