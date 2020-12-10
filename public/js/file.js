$('#subirfile').on("change", function(){
  $('#infpdf').text("")
  var ext = $(this).val().split('.').pop();
  if ($(this).val() != ''){
    if(ext == "pdf"){
      if($(this)[0].files[0].size > 1048576){
        $(this).val('');
        $('#infpdf').text("Se solicita un archivo no mayor a 1MB. Por favor verifique.");
      }
    }else{
      $(this).val('');
      $('#infpdf').text("Extensión no permitida, solo se permite PDF");
    }
  }
});

function subirfile(url){
  document.getElementById('formsubir').action = url;
  document.getElementById('subirfile').value = '';
  document.getElementById('labelpdf').innerHTML = 'Elegir Archivo PDF';
  document.getElementById('infpdf').innerHTML=''
  $("#modalsubir").modal("show");
}