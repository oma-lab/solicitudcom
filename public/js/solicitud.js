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


function editarfile(input,num){
  if (input.files && input.files[0] ){
    var uploadFile = input.files[0];
    if (!(/\.(jpg|png|jpeg)$/i).test(uploadFile.name)) {
      alert('El archivo debe ser una imagen en formato jpg,png o jpeg');
      input.value = "";
      $('#labelfileo'+num).text("Elegir imagen");
      $('#img'+num).remove();
    }else{
     $('#info'+num).text('');
     var reader = new Image();
     reader.onload = function () {
        if(this.width < this.height){
          $('#labelfileo'+num).text(input.files[0].name);
          $('#img'+num).remove();
          $('#imagen'+num).after('<img src="'+reader.src+'" class="img-thumbnail" id="img'+num+'" width="180"/>');
          numn = localStorage.getItem("numero");
          if(num == numn){
            numn++;
            localStorage.setItem("numero", numn);
            var cl = document.getElementById("files");
            campo = '<div id="div'+numn+'"><b id="info'+numn+'" style="color:red"></b><div id="imagen'+numn+'" class="input-group"><div class="input-group-prepend"><button class="btn btn-outline-danger" type="button" onclick="borrarimg('+numn+')"><i class="fa fa-trash"></i></button></div><div class="custom-file mr-sm-2"><input type="file" class="file custom-file-input" name='+cl.getAttribute("name")+' accept=".jpg, .jpeg, .png" onchange="editarfile(this,'+numn+')"/><label id="labelfileo'+numn+'" class="custom-file-label">Elegir imagen</label><div class="invalid-feedback">Archivo invalido</div></div></div></div>';
            $("#camposo").append(campo);
          }
        }else{
          $('#info'+num).text("Error, la imagen debe ser en orientación vertical");
          input.value = "";
          $('#labelfileo'+num).text("Elegir imagen");
          $('#img'+num).remove();
        }
     }
     reader.src = URL.createObjectURL(input.files[0]);
    }
  }
}

function borrarimg(num){
  $('#labelinfo').text('');
  if(num == 1){
    $('#labelinfo').text('Este campo es obligatorio,no puedes eliminar, remplaza la imagen por otra imagen en el mismo campo');
  }else{
    $('#div'+num).remove();
  }
}