<?php
  session_start();
  include_once ("config.php");
  include_once ("../".INCLUDESROOT."/gestionVariables.php");
  include_once ("../".INCLUDESROOT."/seguridad.php");
  comprobarSesion();
  //Migas de pan:
  $pagina="#NAME#";
?>
<!-- xxxxxxxxxxxxxxx CABECERA xxxxxxxxxxxxxx -->
<?php
  //Insertamos plantilla de cabecera
  include "../".INCLUDESROOT."/Templates/cabecera.php";
?>
<!-- xxxxxxxxxxxxx FIN CABECERA xxxxxxxxxx -->

<!-- xxxxxxxxxxxxxx CONTENIDO xxxxxxxxxxxx -->

<!-- xxxxxxxxxxxx FIN CONTENIDO xxxxxxxxxx -->

<!-- xxxxxxxxxxxxxxxx FOOTER xxxxxxxxxxxxx -->
<?php
  //Insertamos plantilla de pie
  include "../".INCLUDESROOT."/Templates/footer.php";
?>
