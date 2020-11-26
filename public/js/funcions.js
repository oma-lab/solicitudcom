function verobs(solicitud_id){
    $(".filahistorial").remove();
    if($.trim(solicitud_id) != ''){
    $.get(url_global+"/observaciones",{solicitud_id: solicitud_id}, function(observaciones){
      if(!$.isEmptyObject(observaciones)){
        $('#sinregistro').text("");
        $('#si').text(observaciones.si);
        $('#no').text(observaciones.no);
      $.each(observaciones.observaciones,function(){
        var descripcion = "Sin observaciones";
        var voto = "No votado";
        var ap_mat = "";
        if(this.descripcion != null){
          descripcion = this.descripcion;
        }
        if(this.voto != null){
          voto = this.voto;
        }
        if(this.apellido_materno != null){
          ap_mat = this.apellido_materno;
        }
        var htmlTags = '<tr class="filahistorial">'+
                         '<td>' + this.nombre +' '+this.apellido_paterno+' '+ap_mat+'</td>'+
                         '<td>' + descripcion + '</td>'+
                         '<td>' + voto + '</td>'+
                       '</tr>';
        $('#tablaobservaciones tbody').append(htmlTags);        
      });
      
      }else{
        $('#sinregistro').text("SIN REGISTRO");
      }
    }); 
    }
    $("#modalverobservacion").modal("show"); 
  }

  
  function historial(identificador,sol){
    $(".filahistorial").remove();
    var img= "/imagenes/ver.png";
    if($.trim(identificador) != ''){
     $.get(url_global+"/historial",{identificador: identificador,sol: sol}, function(solicitudes){
     if(!$.isEmptyObject(solicitudes)){
       $('#sin').text("");
       $.each(solicitudes,function(index,value){
         var url= url_global+"/storage/"+value.dictamen_firmado;
         var htmlTags = '<tr class="filahistorial">'+
         '<td width="70%"><p style="text-align:justify">' + value.asunto + '</p></td>'+
         '<td><center><a class="navbar-brand" href='+url+' target= "_blank"><img src='+img+' style="width:35px;"></a></center></td>'+
         '</tr>';      
        $('#tablahistorial tbody').append(htmlTags);
     });
     }else{
       $('#sinre').text("SIN REGISTRO");
     }
     
   }); 
    }
    $("#modalhistorial").modal("show"); 
       
  }