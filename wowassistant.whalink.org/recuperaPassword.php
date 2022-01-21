<?php
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
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="styles/acceso.css">
    <script src="styles/scripts.js" charset="utf-8"></script>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row formularioIndex">
        <div class="col-xs-0 col-lg-4"><!--Separador--></div>
        <div class="col-xs-12 col-lg-4">
          <div class="col-xs-0 col-lg-2"><!--Separador--></div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8"><!-- Panel de login -->
            <div class="centrado">
              <img src="img/logo_wowhelper_white.png" class="col-lg-12 logoIndex" alt="">
            </div><br>

              <div class="wrap">
                  <p class="form-title">
                      Recupera tu contraseña</p>
                  <form class="login" action='acceso.php?accion=recuperarPassword' name='formLogin' method='post'>
                    <input id='email' class='inputLogin' name='email' type='text' placeholder='E-mail' required /><br>
                    <p>Recibirás un correo en ésta dirección con los pasos a seguir para recuperar tu contraseña</p>
                    <input type="submit" value="Recuperar" class="boton-login caja" />
                  </form>
              </div>
          </div><!-- FIn Panel de login-->
          <div class="col-xs-0 col-lg-2"><!--Separador--></div>
        </div>
        <div class="col-xs-0 col-lg-4"><!--Separador--></div>

      </div><!--row-->

      <footer class="container">
        <div class="row">
          <div class="posted-by navbar navbar-fixed-bottom text-center">Creado por: <a href="frandalf.php"><u>Frandalf Software</u></a>. Imágenes y nombres copyright de <a href="https://www.blizzard.com/es-es/"><u>Blizzard Entertainment.</u></a><a href="https://www.iubenda.com/privacy-policy/45723148" class="avisos" target="_blank" title="Privacy Policy"> <u>Política de privacidad.</u></a>
            <script type="text/javascript">
              (function (w,d) {
                var loader = function () {
                  var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0];
                  s.src="https://cdn.iubenda.com/iubenda.js";
                  tag.parentNode.insertBefore(s,tag);
                };
                if(w.addEventListener){
                  w.addEventListener("load", loader, false);
                }else if(w.attachEvent){
                  w.attachEvent("onload", loader);
                }else{w.onload = loader;
                }
              })(window, document);
            </script>
          <a href="terminos.php" class="avisos" target="_blank" title="Privacy Policy"><u>Términos y condiciones.</u></a></div>
        </div>
      </footer>
    </div> <!--container -->
  </body>
</html>
