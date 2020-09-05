<html>
<head>
<link type="text/css" href="{{ asset('css/app.css')}}" rel="stylesheet">
<style>
@page {
  margin: 0cm 0cm;
}
body {
  margin-top: 3.7cm;
  margin-left: 1.5cm;
  margin-right: 1.5cm;
  margin-bottom: 0.5cm;
  background-color: white;
}
header {
  position: fixed;
  top: 0.5cm;
  left: 1.5cm;
  right: 1.5cm;
  height: 3cm;
  background-color: white;
  color: black;
  text-align: center;
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
table, td {
  border:1px solid black;
}
table, th {
  border:1px solid black;
}
table {
  border-collapse:collapse;
  width:100%;
}
td {
  padding:10px;
}
th {
  padding:10px;
}
span.izquierda {
  float: left;
}
span.derecha {
  float: right;
}
span.texto {
  text-transform: uppercase;
  font-size: 8;
}
</style>
</head>
<body>
  <header>
    <img style="float:left; height:80px;" src="{{asset('storage/'.$datospdf->head1)}}">
    <img style="float:right; height:80px;" src="{{asset('storage/'.$datospdf->head2)}}">
    <br><br><br><br>
    <div id="paginacion">
      <span class="izquierda">REUNIÓN DE COMITÉ ACADÉMICO</span>
      <span class="derecha">{{$fecha}}</span>
    </div>
  </header>
  <footer>
  </footer>
  <main>
   <table>
    <thead>
     <tr>
      <th><span class="texto">NOMBRE</span></th>
      <th><span class="texto">DEPARTAMENTO</span></th>
      <th><span class="texto">OBSERVACIÓN</span></th>
      <th><span class="texto">FIRMA</span></th>
     </tr>
    </thead>
    <tbody>
    @foreach($listaUsuarios as $usuario)
     <tr>
      <th><span class="texto">{{$usuario->nombre_completo()}}</span></th>
      <td><span class="texto">{{$usuario->adscripcion()}}</span></td>
      <td><span class="texto">{{$usuario->observacion}}</span></td>
      <td></td>
     </tr>
     @endforeach
     @foreach($invitados as $invitado)
     <tr>
      <th>*<span class="texto">{{$invitado->nombre}}</span></th>
      <td><span class="texto">{{$invitado->puesto}}</span></td>
      <td><span class="texto">ASISTENCIA</span></td>
      <td></td>
     </tr>
     @endforeach
    </tbody>
   </table>
   *<label style="font-size: 8;">Invitados</label>
  </main>
 </body>
</html>