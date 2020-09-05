<!DOCTYPE html>
<html lang="es">
 <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link type="text/css" href="{{ asset('css/app.css')}}" rel="stylesheet">
  <link type="text/css" href="{{ asset('css/formato.css')}}" rel="stylesheet">
  <title>@yield('title')</title>

  <h6 id="dep">Instituto Tecnológico de Oaxaca<br>
  @yield('departamento')</h6>
  <p id="encabezado">{{$datospdf->headtext}}</p>
  
 </head>
 <body>
   <div id="fondo">
     <img src="{{asset('storage/'.$datospdf->body)}}" height="100%" width="100%" />
   </div>
   <header>
     <img style="float:left; height:80px;" src="{{asset('storage/'.$datospdf->head1)}}">
	   <img style="float:right; height:80px;" src="{{asset('storage/'.$datospdf->head2)}}">
   </header>
   <footer>
    @if( ($datospdf->pie1 || $datospdf->pie6) && ($datospdf->pie2 || $datospdf->pie5) && ($datospdf->pie3 || $datospdf->pie4) )
        <img style="float:left; height:35px;" src="{{asset('storage/'.$datospdf->pie1)}}">
        <img style="float:left; height:35px;" src="{{asset('storage/'.$datospdf->pie2)}}">
        <img style="float:left; height:35px;" src="{{asset('storage/'.$datospdf->pie3)}}">
        <img style="float:right; height:35px;" src="{{asset('storage/'.$datospdf->pie6)}}">
        <img style="float:right; height:35px;" src="{{asset('storage/'.$datospdf->pie5)}}">
        <img style="float:right; height:35px;" src="{{asset('storage/'.$datospdf->pie4)}}">
     @elseif( ($datospdf->pie1 || $datospdf->pie6) && ($datospdf->pie2 || $datospdf->pie5) )
        <img style="float:left; height:50px;" src="{{asset('storage/'.$datospdf->pie1)}}">
        <img style="float:left; height:50px;" src="{{asset('storage/'.$datospdf->pie2)}}">
        <img style="float:right; height:50px;" src="{{asset('storage/'.$datospdf->pie6)}}">
        <img style="float:right; height:50px;" src="{{asset('storage/'.$datospdf->pie5)}}">
     @else
        <img style="float:left; height:60px;" src="{{asset('storage/'.$datospdf->pie1)}}">
        <img style="float:right; height:60px;" src="{{asset('storage/'.$datospdf->pie6)}}">
     @endif 
     <p id="dir">
	   Av. Ing. Víctor Bravo Ahuja # 125 esq. Clz. Tecnológico. C.P. 68030. Oaxaca, Oax.<br>
	   Tels. (951) 5015016, Conmt. Ext. 218, e-mail: comite.academico@itoaxaca.edu.mx <br>
	   www.oaxaca.tecnm.mx
	   </p>
   </footer>
		
   @yield('contenido')
  
 </body>
</html>	 
