<html>
 <head>
  <title>{{$titulo}}</title>
  <style>  
  @page {
    margin: 0cm 0cm;
  }
  body {
    margin-top: 0.5cm;
    margin-left: 0.5cm;
    margin-right: 0.5cm;
    margin-bottom: 0.5cm;
    text-align: center;
  }
  header {
    position: fixed;
    top: 0cm;
    left: 0cm;
    right: 0cm;
    height: 0.5cm;
    background-color: white;
    color: white;
    text-align: center;
    line-height: 1.5cm;
  }
  footer {
    position: fixed; 
    bottom: 0cm; 
    left: 0cm; 
    right: 0cm;
    height: 0.5cm;
    background-color: white;
    color: white;
    text-align: center;
    line-height: 1.5cm;
  }
  </style>
 </head>
<body>
<header>
</header>
<footer>
</footer>
<main>
@foreach($nombres as $nombre)
<div style="page-break-after:never;">
<img  style="height:999px;"  src="{{public_path('storage/solicitudes/'.$nombre)}}" >
</div>
@endforeach
</main>
</body>
</html>