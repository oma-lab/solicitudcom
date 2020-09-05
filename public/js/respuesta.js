//funcion para marcar/desmarcar el boton con respuesta SI/NO
$(document).ready(function(){
$('.containerc').on('click', '.radioBtn a', function(){
    var sel = $(this).data('title');
	  var tog = $(this).data('toggle');
	  $(this).parent().next('.' + tog).prop('value', sel);
	  $(this).parent().find('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass('noActivo');
	  $(this).parent().find('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('noActivo').addClass('active');
     });
});