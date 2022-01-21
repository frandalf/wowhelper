<?php
  session_start();
  include_once ("config.php");
  include_once ("../".INCLUDESROOT."/gestionVariables.php");
  include_once ("../".INCLUDESROOT."/seguridad.php");
  comprobarSesion();

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
    <link rel="stylesheet" href="styles/loading.css">
    <link rel="stylesheet" href="styles/styles.css">
    <script src="//wow.zamimg.com/widgets/power.js"></script>
  </head>
  <body>
    <div class="cajon">
      <div class="cargando">
        <div class="ball"></div>
        <div class="ball1"></div>
      </div>
    </div>

  </body>
</html>
