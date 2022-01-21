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
      $passwordKey="";
      if(isset($_GET["url"])){
        $passwordKey = $_GET['url'];
      }

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
                  <?php
                    if(isset($_GET["error"])){
                      if($_GET["error"]=="pass"){
                        echo "<p class='texto_error'>Las contraseñas no coinciden. Revísalas, por favor.</p>";
                      }
                    }
                   ?>
                  <form class="login" action='acceso.php?accion=nuevoPassword' name='formLogin' method='post'>
                    <input id='passwordNew' class='inputLogin' name='passwordNew' type='password' placeholder='Nueva contraseña' required /><br>
                      <input id='passwordRepeat' class='inputLogin' name='passwordRepeat' type='password' placeholder='Repite contraseña' required /><br>
                      <input type="hidden" id="passwordKey" name="passwordKey" value="<?php echo $passwordKey; ?>">
                    <input type="submit" value="Guardar" class="boton-login caja" />
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
