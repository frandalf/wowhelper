<?php
    include_once ("../includes_wowassistant/gestionVariables.php");
    include_once ("config.php");
    logOut();
 ?>

 <!DOCTYPE html>
 <html lang="es" dir="ltr">
   <head>
     <meta charset="utf-8">
     <?php
       //Establecemos nombre de la web
       echo("<title>".NOMBREAPP."</title>");
      ?>
      <link rel="shortcut icon" href="img/favicon.ico" />
      <link rel="stylesheet" href="styles/styles.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
      <script language="JavaScript">
        function redireccionar() {
          setTimeout("location.href='index.php'", 5000);
        }
        redireccionar();
      </script>
   </head>
   <body onLoad="redireccionar()">
     <div class="desconectado container">
       <div class="col-xs-0 col-md-1">

       </div>
       <div class="col-xs-12 col-md-10 caja">
         <h2>Desconectado</h2>
         <h4>Redireccionando en 5 segundos.</h4>
         <p><a href="index.php">Volver al index</a></p>
       </div>
     </div>
   </body>
 </html>
