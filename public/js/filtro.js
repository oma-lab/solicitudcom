//permite que al seleccionar un elemento de un <select> se haga el filtrado
$('.filtro').change(function(){
    $('#form').submit();
    //document.getElementById('form').submit();
});

//muestra el nombre del archivo subido en el <input> file
//documentos-formato.blade.php
$('.custom-file-input').on('change', function(event) {
    var inputFile = event.currentTarget;
    $(inputFile).parent()
        .find('.custom-file-label')
        .html(inputFile.files[0].name);
});




$(function() {
  localStorage.setItem("numero", 1);
  $.get(url_global+"/notificaciones",{solicitud_id: 1}, function(notificaciones){
  if(!$.isEmptyObject(notificaciones)){
    $('#numnoti').text(notificaciones.length);
    $.each(notificaciones,function(){
      if(this.tipo == 'cancelado' || this.tipo == 'respuesta_solicitud' || this.tipo == 'dictamen_enviado' || this.tipo == 'dictamen_nuevo')
      var notifi = '<li><a href="/notificacion/'+this.id+'"><i class="fa fa-envelope-square" style="color:#1B396A;"></i><b>'+this.mensaje+'</b><br><p class="puntos">'+this.descripcion+'</p></a></li>';
      //coor
      if(this.tipo == 'solicitud')
      var notifi = '<li><a href="/home/"><i class="fa fa-envelope-square" style="color:#1B396A;"></i><b>'+" "+this.num+" "+this.mensaje+'</b><br><p class="puntos">'+this.descripcion+'</p></a></li>';
      if(this.tipo == 'recomendacion')
      var notifi = '<li><a href="/recomendaciones/"><i class="fa fa-envelope-square" style="color:#1B396A;"></i><b>'+""+this.mensaje+'</b><br><p class="puntos">'+this.descripcion+'</p></a></li>';
      if(this.tipo == 'dictamen_pendiente')
      var notifi = '<li><a href="/dictamenes/pendientes"><i class="fa fa-envelope-square" style="color:#1B396A;"></i><b>'+" "+this.mensaje+'</b><br><p class="puntos">'+this.descripcion+'</p></a></li>';
      if(this.tipo == 'dictamen_entregar')
      var notifi = '<li><a href="/dictamenes/noentregado"><i class="fa fa-envelope-square" style="color:#1B396A;"></i><b>'+" "+this.mensaje+'</b><br><p class="puntos">'+this.descripcion+'</p></a></li>';
      if(this.tipo == 'citatorio')
      var notifi = '<li><a href="/mostrar/citatorio/'+this.citatorio_id+'"><i class="fa fa-envelope-square" style="color:#1B396A;"></i><b>'+this.mensaje+'</b><br><p class="puntos">'+this.descripcion+'</p></a></li>';
      $('#notifica').append(notifi);
  });
  }else{
    var notifi = '<li><a href=""><i class="fa fa-exclamation-circle" style="color:#1B396A;"></i>No hay notificaciones que mostrar por el momento</a></li>';
    $('#notifica').append(notifi);
  }
}); 
});