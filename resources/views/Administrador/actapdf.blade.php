<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>ACTA</title>
<style>
html{
  margin: 52px 40px 70px 40px;
}
table {
  border-collapse:collapse;
  width:100%;
  table-layout: fixed;
}
td {
  padding:10px;
  text-align: center;
  width: 100px;
}
#titulo{
  text-align: center;
  font-size: 10;
}
.contenido{
  text-align: justify;
  font-size: 10;
  line-height: 2.5;
  text-transform: uppercase;
}
.asistente{
  font-size: 10;
  text-transform: uppercase;
}
</style>
</head>

<body>
<p id="titulo" >{{$acta->titulo}}</p>
<p class="contenido"> <?=str_replace('<br>', '<br>', $contenido)?></p>
<br><br><br>

<table>
 <tbody>
  @foreach($asistentes->chunk(2) as $integrantes)
  <tr>
   @foreach($integrantes as $integrante)
    <td>
     <br><br>
     <span class="asistente">{{$integrante->nombre_completo()}}<br>
     {{$integrante->puesto()}}</span>
    </td>
   @endforeach
  </tr>        
  @endforeach
 </tbody>
</table>
</body>
        

</html>