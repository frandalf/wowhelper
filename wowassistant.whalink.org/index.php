<?php
  session_start();
  include_once ("config.php");
  include_once ("../".INCLUDESROOT."/db_connect.php");
  include_once ("../".INCLUDESROOT."/gestionVariables.php");
  include_once ("../".INCLUDESROOT."/seguridad.php");
  include_once ("../".INCLUDESROOT."/cleanCode.php");

  $email="";
  $pass="";
  $remember=false;
  $tipoError="";
  $focusPass=false;
  //Realizamos conexión con la base de datos:
  $db = new db_connect();
  //Comprobamos si hay conexión. Si no, enviamos a página de error
  if(!$db->hayConexion()){
    header("Location: error.php");
    exit();
  }

  //comprobamos si puede acceder directamente (sesión activa o datos correctos)
  comprobarAcceso();

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
                      Login</p>
                      <?php
                        //BLOQUE DE ERRORES
                        //Comprobamos si venimos de algún error de acceso y mostramos el texto en consecuencia
                        if(isset($_GET["error"])){
                          switch ($_GET["error"]) {
                            case 'email':
                              echo "<p class='texto_error'>El correo introducido no es correcto. Revísalo, por favor.</p>";
                              break;
                            case 'user':
                              echo "<p class='texto_error'>El correo introducido no existe en la base de datos.</p>";
                              break;
                            case 'pass':
                              //Como sólo la contraseña es errónea, ponemos como valor del input de correo el que se introdujo antes:
                              echo "<p class='texto_error'>La contraseña es errónea</p>";
                              //Guardamos el correo del get en la variable email para rellenar luego el value del input
                              $email=$_GET["correo"];
                              //Indicamos que debe hacerse focus en la contraseña:
                              $focusPass=true;
                              break;
                            case 'errorPersonajeBorrado':
                              //Si ocurre algún error borrando una cuenta de usuario:
                              echo "<p class='texto_error'>Error borrando tu usuario.</p><p> Por favor, informa del error en <a href='https://docs.google.com/forms/d/e/1FAIpQLSd6RWwvS5zfUT7YehSlmbVgmQ6gWnIrYME9Ox1K8D3IRdm-xg/viewform'>este formulario.</a></p>";
                              break;
                            case 'sendMail':
                              echo "<p class='texto_error'>Error enviando el mail. Inténtelo más tarde.</p>";
                              break;

                            default:
                              // code...
                              break;
                          }
                        }
                        if(isset($_GET["accion"])){
                          switch ($_GET["accion"]) {
                            case 'personajeBorrado':
                              echo "<p class='texto_ok'>El usuario se ha dado de baja correctamente.</p>";
                              break;
                            case 'pass':
                              echo "<p class='texto_ok'>La contraseña se ha modificado correctamente.</p>";
                              break;
                            case 'sendMail':
                              echo "<p class='texto_ok'><p>Email de recuperación enviado.</p><p>Puede tardar un poco.</p>";
                              break;
                          }
                        }

                      ?>
                  <form class="login" action='acceso.php?accion=login' name='formLogin' method='post'>
                    <?php
                      //Input de email con autorellenado si viene de error o si hay cookie de "recordar".
                      echo "<input id='email' class='inputLogin' name='email' type='text' placeholder='E-mail' required value='".$email."'/><br>";
                      echo "<div class='col-xs-12 separadorInput'></div>";
                      echo "<input id='inputlg' class='inputLogin' name='pass' type='password'  placeholder='Contraseña' required value=''/>";
                    ?>

                    <?php
                      //Comprobamos si hay que hacer focus en pass (si venimos de pass errónea)
                      if ($focusPass) {
                        echo " <script type='text/javascript'>
                            document.getElementById('pass').focus();
                         </script>";
                      }
                     ?>

                    <input type="submit" value="Acceder" class="boton-login caja" />

                  <div class="remember-forgot">
                      <div class="row">
                          <div class="col-12 col-lg-5">
                              <div class="checkbox">
                                  <label>
                                    <?php
                                      //Comprobamos si checked debe estar marcado:
                                      if($remember){
                                        echo "<input id='remember' name='remember' type='checkbox' checked/>";
                                      }else{
                                        echo "<input id='remember' name='remember' type='checkbox' />";
                                      }
                                    ?>
                                      Recuérdame
                                  </label>
                              </div>
                          </div>
                          <div class="col-12 col-lg-7 forgot-pass-content text-center text-md-right">
                            <a href="registro.php">Crear una cuenta</a>
                          </div>
                      </div>
                  </div>
                  <!-- Acceso a registro -->
                  <div class="col-12 text-center pt-4">
                    <a href="recuperaPassword.php" class="forgot-pass">Recuperar contraseña</a>
                  </div>
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
