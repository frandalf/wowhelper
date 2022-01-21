<?php
  header("Content-Type: text/html;charset=utf-8");
  //Realizamos conexión con la base de datos:
  include_once ("config.php");
  include_once ("../".INCLUDESROOT."/db_connect.php");
  $db = new db_connect();
  $email="";
  $tipoError="";
  $focusPass=false;
  //Comprobamos si hay conexión. Si no, enviamos a página de error
  if(!$db->hayConexion()){
    header("Location: error.php");
    exit();
  }
 ?>

 <!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?php
      //Establecemos nombre de la web
      echo("<title>".NOMBREAPP."</title>");
      //Incluímos JS
      echo "<script type='text/javascript' src='../".INCLUDESROOT."/js/validaciones.js'></script>";
     ?>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
       integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
       crossorigin="anonymous">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="styles/acceso.css">
    <script src="styles/scripts.js" charset="utf-8"></script>
    <link rel="shortcut icon" href="img/favicon.ico" />
  </head>
  <body>

    <div class="container">
    <div class="row formularioReg">
      <img src="img/logo_bfa.png" class="col-md-12 logo image-fluid" alt="">

        <div class="col-md-12">
            <div class="pr-wrap">
                <div class="pass-reset">
                    <label>
                        Registro</label>
                    <input type="email" placeholder="Email" />
                    <input type="submit" value="Submit" class="pass-reset-submit btn btn-success btn-sm" />
                </div>
            </div>
            <div class="wrap">
                <p class="form-title">
                    Registro</p>
                <form class="login" name='formRegistro' action='acceso.php?accion=registro' method='post' onsubmit='return comprobarRegistro()'>
                  <?php
                    //BLOQUE DE ERRORES
                    //Comprobamos si venimos de algún error de acceso y mostramos el texto en consecuencia
                    if(isset($_GET["error"])){
                      switch ($_GET["error"]) {
                        case 'existe':
                          echo "<p class='texto_error'>Ya existe un registro con ese correo electrónico.</p>";
                          break;
                        case 'user':
                          echo "<p class='texto_error'>El usuario está vacío. Revísalo, por favor.</p>";
                          break;
                        case 'email':
                          echo "<p class='texto_error'>El correo introducido no es correcto. Revísalo, por favor.</p>";
                          break;
                        case 'emailerror':
                          echo "<p class='texto_error'>Los correos introducidos no son iguales.</p>";
                          break;
                        case 'passerror':
                          //Como sólo la contraseña es errónea, ponemos como valor del input de correo el que se introdujo antes:
                          echo "<p class='texto_error'>Las contraseñas no coinciden</p>";
                          //Guardamos el correo del get en la variable email para rellenar luego el value del input
                          $email=$_GET["correo"];
                          break;
                        case 'registro':
                          //Error en el registro
                          echo "<p class='texto_error'>Error desconocido al intentar registrar usuario. Inténtelo más tarde o contacte con ".ADMINISTRADOR."</p>";
                          break;

                        default:
                          // code...
                          break;
                      }

                    }
                  ?>
                <label class="etiqueta" for="user">Usuario:</label>
                <input id="user" name="user" type="text" placeholder="" required/>

                <label class="etiqueta" for="email1">E-mail:</label>
                <input id="email1" name="email1" type="text" placeholder="" required/>
                  <span id="emailIncorrecto" class="texto_error"></span>

                <label class="etiqueta" for="email2">Confirmar e-mail:</label>
                <input id="email2" name="email2" type="text" placeholder="" required/>
                  <span id="emailError" class="texto_error"></span>

                <label class="etiqueta" for="email2">Contraseña:</label>
                <input id="pass1" name="pass1" type="password" placeholder=""required />

                <label class="etiqueta" for="email2">Confirmar contraseña:</label>
                <input id="pass2" name="pass2" type="password" placeholder="" required/>


                <div class="remember-forgot">
                    <div class="row text-center">
                      <span class="col-12 d-block ">*Todos los campos son obligatorios</span>
                        <div class="col-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" required/>
                                    Estoy de acuerdo con los <a class="enlace" href="terminos.php" target="_blank"><u>términos y condiciones</u></a>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="submit" value="Registrarse" class="btn boton-login btn-sm" required/>

                </form>
                <br>
                <div class="row text-center">
                  <label class="col-12 d-block "><a href="index.php">Volver</a></label>
                </div>
            </div>
        </div>

    </div><!--row-->

    <footer class="container hidden visible-md">
      <div class="row">
        <div class="posted-by navbar navbar-fixed-bottom text-center">Creado por: <a href="#">Frandalf Software</a>. Imágenes y nombres copyright de <a href="https://www.blizzard.com/es-es/">Blizzard Entertainment.</a></div>
      </div>
    </footer>

    <!--<div class="posted-by">Creado por: <a href="#">Frandalf Software</a></div>-->
</div>

  </body>
</html>
