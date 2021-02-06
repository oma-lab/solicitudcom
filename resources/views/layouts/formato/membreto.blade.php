<!DOCTYPE html>
<html lang="es">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title')</title>
  <style>
  @page{
    margin: 0cm 0cm;
  }
  p {
    margin-top: 0;
    margin-bottom: 10px;
  }
  #fondo{
    position: fixed;
    top:   0cm;
    left:     0cm;
    z-index:  -1000;
  }
  body{
    margin-top: 3.8cm;
    margin-left: 70px;
    margin-right: 70px;
    margin-bottom: 3cm;
    background-color: white;
    font-family: "Nunito", sans-serif;
  }
  header{
    position: fixed;
    top: 25px;
    left: 70px;
    right:70px;
    height: 3cm;
  }
  footer {
    position: fixed; 
    bottom: 0px; 
    left: 70px; 
    right: 70px;
    height: 2cm;
  }
  #dep{
    text-align: right;
    font-size: 8;
    color: #7D7C7C;
    font-weight: bold;
    margin-top: -10px;
  }
  #encabezado{
    text-align: center;
    font-size: 8;
    color: #9C9A9A;
    line-height: 9pt;
  }
  #titulo{
    text-align: center;
    font-size: 10;
    font-weight: bold;
    /*text-transform: uppercase;*/
  }
  #titulodos{
    text-align: center;
    font-size: 11;
    text-transform: uppercase;
    font-weight: bold;
  }
  #titulotres{
    text-align: center;
    font-size: 10;
    text-transform: uppercase;
    font-weight: bold;
  }
  #tituloorden{
    text-align: center;
    font-size: 12;
    line-height: 10pt;
  }
  #fecha{
    text-align: right;
    font-size: 9;
    line-height: 7pt;
  }
  #destinatario{
    text-align: left;
    font-size: 10;
    text-transform: uppercase;
    font-weight: bold;
    line-height: 13pt;
  }
  #asunto{
    text-align: right;
    font-size: 10;
    /*font-weight: bold;*/
  }
  .cuerpo{
    text-align: justify;
    font-size: 10;
    line-height: 8pt;
  }
  #firma{
    text-align: center;
    font-size: 10;
    font-weight: bold;
  }
  #notas{
    font-size: 10;
    line-height: 10pt;
  }
  #notasdic{
    text-align: center;
    font-size: 10;
    line-height: 10pt;
  }
  #firmarec{
    font-size: 10;
    line-height: 13pt;
    text-transform: uppercase;
    font-weight: bold;
  }
  #firmadic{
    text-align: center;
    font-size: 10;
    line-height: 12pt;
    text-transform: uppercase;
    font-weight: bold;
  }
  span.nota{
    font-size: 8;
    font-style: italic;
    line-height: 9pt;
  }
  span.mayuscula{
    text-transform: uppercase;
  }
  span.minuscula{
    text-transform: lowercase;
  }
  span.mayuscula-negrita{
    text-transform: uppercase;
    font-weight: bold;
  }
  span.minuscula-negrita{
    text-transform: lowercase;
    font-weight: bold;
  }
  #cel{
    text-align: left;
    font-size: 8;
    font-weight: bold;
  }
  #ccp{
    text-align: left;
    font-size: 8;
    line-height: 7pt;
    margin-bottom: 0px;
  }
  #dir{
    text-align: center;
    font-size: 8;
    line-height: 9pt;
  }
  table{
    width: 100%;
    table-layout: fixed;
    padding-left: -3px;
    margin-top: -3px;
  }
</style>

  
 </head>
 <body>
   <div id="fondo">
     <img src="{{public_path('storage/'.$datospdf->body)}}">
   </div>
   <header>
     <img style="float:left; height:63px;" src="{{public_path('storage/'.$datospdf->head1)}}">
	   <img style="float:right; height:58px;" src="{{public_path('storage/'.$datospdf->head2)}}">
     <p id="dep" style='clear: both'>Instituto Tecnológico de Oaxaca<br>@yield('departamento')</p>
     <p id="encabezado">{{$datospdf->headtext}}</p>
   </header>
   <footer>
     @if( ($datospdf->pie1 || $datospdf->pie6) && ($datospdf->pie2 || $datospdf->pie5) && ($datospdf->pie3 || $datospdf->pie4) )
        @if($datospdf->pie1)<img style="float:left; height:35px;" src="{{public_path('storage/'.$datospdf->pie1)}}">@else<img style="float:left; height:35px;" src="{{public_path('storage/formato/white.png')}}">@endif
        @if($datospdf->pie2)<img style="float:left; height:35px;" src="{{public_path('storage/'.$datospdf->pie2)}}">@else<img style="float:left; height:35px;" src="{{public_path('storage/formato/white.png')}}">@endif
        @if($datospdf->pie3)<img style="float:left; height:35px;" src="{{public_path('storage/'.$datospdf->pie3)}}">@else<img style="float:left; height:35px;" src="{{public_path('storage/formato/white.png')}}">@endif
        @if($datospdf->pie6)<img style="float:right; height:35px;" src="{{public_path('storage/'.$datospdf->pie6)}}">@else<img style="float:left; height:35px;" src="{{public_path('storage/formato/white.png')}}">@endif
        @if($datospdf->pie5)<img style="float:right; height:35px;" src="{{public_path('storage/'.$datospdf->pie5)}}">@else<img style="float:left; height:35px;" src="{{public_path('storage/formato/white.png')}}">@endif
        @if($datospdf->pie4)<img style="float:right; height:35px;" src="{{public_path('storage/'.$datospdf->pie4)}}">@else<img style="float:left; height:35px;" src="{{public_path('storage/formato/white.png')}}">@endif
     @elseif( ($datospdf->pie1 || $datospdf->pie6) && ($datospdf->pie2 || $datospdf->pie5) )
        @if($datospdf->pie1)<img style="float:left; height:50px;" src="{{public_path('storage/'.$datospdf->pie1)}}">@else<img style="float:left; height:50px;" src="{{public_path('storage/formato/white.png')}}">@endif
        @if($datospdf->pie2)<img style="float:left; height:50px;" src="{{public_path('storage/'.$datospdf->pie2)}}">@else<img style="float:left; height:50px;" src="{{public_path('storage/formato/white.png')}}">@endif
        @if($datospdf->pie6)<img style="float:right; height:50px;" src="{{public_path('storage/'.$datospdf->pie6)}}">@else<img style="float:left; height:50px;" src="{{public_path('storage/formato/white.png')}}">@endif
        @if($datospdf->pie5)<img style="float:right; height:50px;" src="{{public_path('storage/'.$datospdf->pie5)}}">@else<img style="float:left; height:50px;" src="{{public_path('storage/formato/white.png')}}">@endif
     @else
        @if($datospdf->pie1)<img style="float:left; height:60px;" src="{{public_path('storage/'.$datospdf->pie1)}}">@else<img style="float:left; height:60px;" src="{{public_path('storage/formato/white.png')}}">@endif
        @if($datospdf->pie6)<img style="float:right; height:60px;" src="{{public_path('storage/'.$datospdf->pie6)}}">@else<img style="float:left; height:60px;" src="{{public_path('storage/formato/white.png')}}">@endif
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