<?php
  header("Content-Type: text/html;charset=utf-8");
  session_start();
  include_once ("config.php");
  include_once ("../".INCLUDESROOT."/gestionVariables.php");
  include_once ("../".INCLUDESROOT."/seguridad.php");
  comprobarSesion();
  //Migas de pan:
  $pagina="perfil";
?>
<!-- xxxxxxxxxxxxxxx CABECERA xxxxxxxxxxxxxx -->
<?php
  //Insertamos plantilla de cabecera
  include "../".INCLUDESROOT."/Templates/cabecera.php";
  $nombre = $_COOKIE["user"];
  $email = $_SESSION["email"];

?>
<!-- xxxxxxxxxxxxx FIN CABECERA xxxxxxxxxx -->

<!-- xxxxxxxxxxxxxx CONTENIDO xxxxxxxxxxxx -->
<?php
  $nombre = $_COOKIE["user"];
  $email = $_SESSION["email"];
 ?>
<div class="container">
  <div class="row">
    <div class="col-xs-0 col-md-2">
    </div>
    <div class="col-xs-0 col-md-8 panelPerfil caja">
      <img src="img/logo_wowhelper_white.png" class="logo" alt="Logotipo WowHelper">
      <hr>
      <div class="col-xs-0 col-md-1"></div>
      <div class="col-xs-12 col-md-8 formularioPerfil">
        <form class="" action="acceso.php?accion=cambioDatos" method="post">
          <label for="nombre">Usuario:</label>
          <?php
            //Comprobamos los errores y añadimos marcas en consecuencia
            $emailE="";
            $oldPassword="";
            $user="";
            $passerror="";
            $existe="";
            if(isset($_GET["error"])){
              switch ($_GET["error"]) {
                case 'email':
                  $emailE="*";
                  break;
                case 'oldPassword':
                  $oldPassword="*";
                  break;
                case 'user':
                  $user="*";
                  break;
                case 'passerror':
                  $passerror="*";
                  break;
                case 'existe':
                  $existe="*";
                  break;
              }
            }
            echo "<input type='text' class= 'input_wow input_wow_little' name='nombre' value='".$nombre."' required> <span style='color:red'>".$user."</span><br>";
            echo "<label for='email'>Email:</label>";
            echo "<input type='text' class= 'input_wow input_wow_little' name='email' value='".$email."' required> <span style='color:red'>".$emailE."</span><br>";
          ?>
          <label for="oldPassword">Contraseña actual: <span style="color:red;"><?php echo $oldPassword; ?></span></label>
          <input type="password" class= "input_wow input_wow_little" name="oldPassword" value=""><br>
          <label for="Password">Nueva contraseña: <span style="color:red;"><?php echo $passerror; ?></span></label>
          <input type="password" class= "input_wow input_wow_little" name="newPassword" value=""><br>
          <label for="newPassword">Repetir contraseña: <span style="color:red;"><?php echo $passerror; ?></span></label>
          <input type="password" class= "input_wow input_wow_little" name="repeatPassword" value=""><br>
          <br>
          <button type="submit" class="btn caja boton" data-dismiss="modal">Guardar cambios</button>
          <br>
        </form>
    </div>  <!-- Panel perfil-->
  </div> <!-- /Row -->
  <div class="row">
    <br>
    <div class="col-xs-12 centrado">
      <div class="col-xs-0 col-md-2"></div>
      <div class="col-xs-12 col-md-8 borrarCuenta caja">
          <button type="button" class="btn caja boton" data-toggle="modal" data-target="#borrarUsuario">Borrar cuenta</button>
      </div>


    </div>

  </div>
</div>


<!-- xxxxxxxxxxxxx MODAL xxxxxxxxxxxxx -->
<!-- Modal -->
<div class="modal fade" id="borrarUsuario" tabindex="-1" role="dialog" aria-labelledby="borrarUsuario" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content caja">
      <div class="modal-header">
        <h2 class="modal-title text-center" id="borrarUsuario">Borrar usuario</h2>
      </div>
      <div class="modal-body">
        <div id="mostrarLoading"></div>
        <form class="formCrearPj text-center" action="personaje.html" method="post">
          <p><h3>¿Estás seguro?</h1></p><br>
          <p>Si borras tu cuenta tendrás que volver a añadir todos tus personajes, tareas y configuraciones si decides volver a registrarte.</p>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn caja boton" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn caja" onclick="window.open('acceso.php?accion=borrarUsuario');" role="button">Borrar</button>
      </div>
    </div>
  </div>
</div> <!-- Fin modal-->


<!-- xxxxxxxxxxxx FIN CONTENIDO xxxxxxxxxx -->

<!-- xxxxxxxxxxxxxxxx FOOTER xxxxxxxxxxxxx -->
<?php
  //Insertamos plantilla de pie
  include "../".INCLUDESROOT."/Templates/footer.php";
?>
