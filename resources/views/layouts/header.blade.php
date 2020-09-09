<link href="{{ asset('css/navba.css') }}" rel="stylesheet">
<script>
   var url_global='{{url("/")}}';
   $(function(){
      $( document ).on( 'click', '#check', function(){
         let val = $(this).val();
         if( $( this ).is( ':checked' ) ){
            //$("body").addClass("no_scroll");
            $("body").css("overflow","hidden");
            //alert( 'Guardando información de '+ val +'...' );
         }else{
            //$("body").removeClass("no_scroll");
            $("body").css("overflow","auto");//
            //alert( 'Desguardando información de ' + val + '...' );
         }
      });
   });
</script>

<header>
 <div class="container-fluid text-center" >
   <div class="row">
      <div class="col-3 col-sm-3  col-md-3  col-lg-2 col-xl-2 borde">
         <img class="img-fluid mx-auto d-block" src="{{ asset('imagenes/logo-tecnmm.png') }}" > 
      </div>
      <div class="col-6 col-sm-6  col-md-6  col-lg-8 col-xl-8 borde">
         <img class="img-fluid mx-auto d-block" src="{{ asset('imagenes/logo-letra.png') }}" >
      </div>
      <div class="col-3 col-sm-3  col-md-3  col-lg-2 col-xl-2 borde">
         <img class="img-fluid mx-auto d-block" src="{{ asset('imagenes/logo-ito.png') }}" >
      </div>
   </div>
 </div>
</header>