<?php
  header("Content-Type: text/html;charset=utf-8");
  include_once ("config.php");
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
        <?php
            $textoAccion = "<h2>Registro completado</h2>";
            if(isset($_GET["accion"])){
              if($_GET["accion"]=="cambioPass"){
                $textoAccion = "<h2>Los cambios se han realizado de forma correcta.</h2> <h3>Serás redirigido a la pantalla de login.</h3><br>";
              }
            }
         ?>

      </div>
      <div class="col-xs-12 col-md-10 caja">
        <?php echo $textoAccion; ?>
        <h4 id='tiempo'>Redireccionando en 5 segundos.</h4>
        <p><a href="index.php">Volver al index</a></p>
      </div>
    </div>
  </body>
</html>
