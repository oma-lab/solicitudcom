<!doctype html>
<html lang="es">
 <head>
 <!-- Required meta tags -->
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <style>
  @page {
    margin: 0cm 0cm;
  }
  body {
    margin: 3cm 4cm 2cm 4cm;
  }
  header {
    position: absolute;
    top: 0cm; left: 0cm; right: 0cm; height: 2cm;
    font-weight: bold;
    background-color: #1B396A;
    color: white;
    text-align: center;
    line-height: 1.5cm;
  }
  footer {
    bottom: 0cm; left: 0cm; right: 0cm; height: 2cm;
    font-weight: bold;
    background-color: #1B396A;
    color: white;
    text-align: center;
    line-height: 1.5cm;
  }

  .boton {
    box-sizing: border-box;
    border-radius: 3px; 
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
    color: #fff;
    display: inline-block;
    text-decoration: none; 
    -webkit-text-size-adjust: none;
    background-color: #3490dc;
    border-top: 10px solid #3490dc;
    border-right: 18px solid #3490dc;
    border-bottom: 10px solid #3490dc;
    border-left: 18px solid #3490dc;
  }
  </style>
  </head>
  <body>
  <header>
    <h2>COMITÉ ACADÉMICO.</h2>
  </header>
  <main class="py-0">
   @yield('contenido')
   <br><br><br><br>
  </main>
  <footer>
    2020 Comité Académico.           
  </footer>
  </body>
</html>