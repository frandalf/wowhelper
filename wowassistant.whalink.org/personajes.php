<?php
  header("Content-Type: text/html;charset=utf-8");
  session_start();
  include_once ("config.php");
  include_once ("../".INCLUDESROOT."/gestionVariables.php");
  include_once ("../".INCLUDESROOT."/seguridad.php");
  include_once ("../".INCLUDESROOT."/functions_wow.php");
  include_once ("../".INCLUDESROOT."/functions_tareas.php");
  include_once ("../".INCLUDESROOT."/db_connect.php");
  comprobarSesion();

  //Migas de pan:
  $pagina="personajes";

  //Comprobamos si viene de error al buscar pj. Si lo está, mostramos el modal
  $error=false;
  if(isset($_GET["error"])){
  //  echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>";
  //  echo "<script type='text/javascript'> $(document).ready(function(){ $('#modalCrearPersonaje').modal('show'); }); </script>";
    echo "<script type='text/javascript'>alert('No se encuentra personaje o error temporal. Prueba más tarde.')</script>";
    //Mostramos error en el modal:
    //$error=true;
  }


  $idUser = $_SESSION["id_user"];
  $db = new db_connect();
  $mysqli = $db->getSqli();

  //Comprobamos si no viene de una petición de borrado de personajes
  if(isset($_POST["accion"])){
    switch ($_POST["accion"]) {
      case 'borrarPj':
        $idPj = $_POST["idPj"];
        $borrando = eliminarPersonaje($idUser,$idPj,$mysqli);
        if($borrando){
          //Borramos las tareas donde estuviese el personaje
          borrarTareaPj($idUser,$idPj,$mysqli);
        }
        break;
    }
  }

  //Recuperamos todos los datos del personaje de la BBDD
  $datosPj = getListaPersonajes($idUser,$mysqli);
  //Ordenamos Array recibida:
  function compareByName($datosPj, $b) {
    return strcmp($datosPj["nombre"], $b["nombre"]);
  }
  usort($datosPj, 'compareByName');

  //Como los personajes se muestran a 8 por columna, comprobamos cuántos son y los añadimos al array de cada columna_personajes
    $nPjs = count($datosPj);
    $datosCol1 = array();
    $datosCol2 = array();
    $datosCol3 = array();
    $datosCol4 = array();
    $datosCol5 = array();
    $datosCol6 = array();
    $datosCol7 = array();
    //Columna 1
    for($i=0;$i<$nPjs;$i++){
      //Columna 1
      if($i<8){
        $datosCol1[$i] = $datosPj[$i];
      }
      //Columna 2
      if($i>=8 && $i<16){
        $datosCol2[$i] = $datosPj[$i];
      }
      //Columna 3
      if($i>=16 && $i<24){
        $datosCol3[$i] = $datosPj[$i];
      }
      //Columna 4
      if($i>=24 && $i<32){
        $datosCol4[$i] = $datosPj[$i];
      }
      //Columna 5
      if($i>=32 && $i<40){
        $datosCol5[$i] = $datosPj[$i];
      }
      //Columna 6
      if($i>=40 && $i<48){
        $datosCol6[$i] = $datosPj[$i];
      }
      //Columna 7
      if($i>=48){
        $datosCol7[$i] = $datosPj[$i];
      }
    }

?>

<!-- xxxxxxxxxxxxxx CABECERA xxxxxxxxxxxxx -->
<?php
  //Insertamos plantilla de cabecera
  include "../".INCLUDESROOT."/Templates/cabecera.php";
?>
<!-- xxxxxxxxxxxxx FIN CABECERA xxxxxxxxxx -->

<!-- xxxxxxxxxxxxxx CONTENIDO xxxxxxxxxxxx -->

<!--Botonera -->
  <div class="container">
    <div class="row">
      <div class="col-md-10">

      </div>
      <div class="col-md-2">
        <!-- Button trigger modal -->
        <button type="button" class="caja addPersonaje  pull-right" data-toggle="modal" data-target="#modalCrearPersonaje">
          + AÑADIR
        </button>
      <!--  <div class="caja addPersonaje text-center">
          <a href="#modalCrearPersonaje" data-toggle="modal" data-target="#modalCrearPersonaje">
              <span>+ AÑADIR</span>
          </a>
        </div> -->
      </div>
    </div>
  </div><!-- CONTAINER -->
  <!--CAJA DE LISTA DE PERSONAJES -->
  <div class="container-flow ">
    <!-- Columna izquierda -->
    <div class="col-xs-0 col-md-2">

<?php
        //Si hay más de 32 personajes, mostramos los botones izquierda y derecha.
        if($nPjs>32){
          echo "<div class='columFlechaIzquierda'>";
            echo "<div class='flechaIzquierda' onclick='mostrarColumnaIzquierda()'></div>";
          echo "</div>";
        }
?>
  </div>

    <!-- Columna Central (lista personajes) -->
    <div class="container col-xs-12 col-md-8">
      <div class="row">
        <div class="col-12 offset-md-2 lista_personajes caja">
          <!-- Personajes 1 a 8-->
          <div class="col-12 col-md-3 columna_personajes" id="columna1">

            <?php
              foreach($datosCol1 as $item){
                  echo "<a href='personaje.php?nombre=".$item['nombre']."&reino=".$item['reino']."'>";
                    echo "<div class='col-12 personaje'>";
                      echo "<div class='row colInterna-lista ".getNombreFaccion($item['faccion'])."'>";
                        echo "<div class='col-xs-3'>";
                          if(!isset($item['imagen'])){
                            echo "<img class='img-fluid avatar-lista' src='img/avatar-lowlevel.png' alt=''>";
                          }else{
                            echo "<img class='img-fluid avatar-lista' src='http://render-".getNombreRegion($item['region']).".worldofwarcraft.com/character/".$item['imagen']."-avatar.jpg' alt=''>";
                          }
                        echo "</div>";
                        echo "<div class='col-xs-9'>";
                          echo "<h5 class='".getColorClase($item['clase'])." datos-pjs-lista'>".$item['nombre']."</h5>";
                          echo "<h5 class='datos-pjs-lista'><span>".$item['nivel']."</span> ".getnombreClase($item['clase'])[0]."</h5>";
                          echo "<h5 class='datos-pjs-lista hidden-xs'>".getNombreReino($item['reino'])."</h5>";
                        echo "</div>";
                      echo "</div>";
                    echo "</div>";
                  echo "</a>";
              }
            ?>
          </div>
          <!-- Fin personajes 1 a 8-->

          <!-- Personajes 9 a 16-->
          <div class="col-12 col-md-3 columna_personajes" id="columna2">
            <?php
              foreach($datosCol2 as $item){
                  echo "<a href='personaje.php?nombre=".$item['nombre']."&reino=".$item['reino']."'>";
                    echo "<div class='col-12 personaje'>";
                      echo "<div class='row colInterna-lista ".getNombreFaccion($item['faccion'])."'>";
                        echo "<div class='col-xs-3'>";
                          if(!isset($item['imagen'])){
                            echo "<img class='img-fluid avatar-lista' src='img/avatar-lowlevel.png' alt=''>";
                          }else{
                            echo "<img class='img-fluid avatar-lista' src='http://render-".getNombreRegion($item['region']).".worldofwarcraft.com/character/".$item['imagen']."-avatar.jpg' alt=''>";
                          }
                        echo "</div>";
                        echo "<div class='col-xs-9'>";
                          echo "<h5 class='".getColorClase($item['clase'])." datos-pjs-lista'>".$item['nombre']."</h5>";
                          echo "<h5 class='datos-pjs-lista'><span>".$item['nivel']."</span> ".getnombreClase($item['clase'])[0]."</h5>";;
                          echo "<h5 class='datos-pjs-lista hidden-xs'>".getNombreReino($item['reino'])."</h5>";
                        echo "</div>";
                      echo "</div>";
                    echo "</div>";
                  echo "</a>";
              }
            ?>
          </div>
          <!-- Fin Personajes 9 a 16 -->

          <!-- Personajes 17 a 24-->
          <div class="col-12 col-md-3 columna_personajes" id="columna3">
            <?php
              foreach($datosCol3 as $item){
                  echo "<a href='personaje.php?nombre=".$item['nombre']."&reino=".$item['reino']."'>";
                    echo "<div class='col-12 personaje'>";
                      echo "<div class='row colInterna-lista ".getNombreFaccion($item['faccion'])."'>";
                        echo "<div class='col-xs-3'>";
                          if(!isset($item['imagen'])){
                            echo "<img class='img-fluid avatar-lista' src='img/avatar-lowlevel.png' alt=''>";
                          }else{
                            echo "<img class='img-fluid avatar-lista' src='http://render-".getNombreRegion($item['region']).".worldofwarcraft.com/character/".$item['imagen']."-avatar.jpg' alt=''>";
                          }
                        echo "</div>";
                        echo "<div class='col-xs-9'>";
                          echo "<h5 class='".getColorClase($item['clase'])." datos-pjs-lista'>".$item['nombre']."</h5>";
                          echo "<h5 class='datos-pjs-lista'><span>".$item['nivel']."</span> ".getnombreClase($item['clase'])[0]."</h5>";
                          echo "<h5 class='datos-pjs-lista hidden-xs'>".getNombreReino($item['reino'])."</h5>";
                        echo "</div>";
                      echo "</div>";
                    echo "</div>";
                  echo "</a>";
              }
            ?>
          </div>
          <!-- Fin Personajes 17 a 24-->

          <!-- Personajes 24 a 32-->
          <div class="col-12 col-md-3 columna_personajes" id="columna4">
            <?php
              foreach($datosCol4 as $item){
                  echo "<a href='personaje.php?nombre=".$item['nombre']."&reino=".$item['reino']."'>";
                    echo "<div class='col-12 personaje'>";
                      echo "<div class='row colInterna-lista ".getNombreFaccion($item['faccion'])."'>";
                        echo "<div class='col-xs-3'>";
                          if(!isset($item['imagen'])){
                            echo "<img class='img-fluid avatar-lista' src='img/avatar-lowlevel.png' alt=''>";
                          }else{
                            echo "<img class='img-fluid avatar-lista' src='http://render-".getNombreRegion($item['region']).".worldofwarcraft.com/character/".$item['imagen']."-avatar.jpg' alt=''>";
                          }
                        echo "</div>";
                        echo "<div class='col-xs-9'>";
                          echo "<h5 class='".getColorClase($item['clase'])." datos-pjs-lista'>".$item['nombre']."</h5>";
                          echo "<h5 class='datos-pjs-lista'><span>".$item['nivel']."</span> ".getnombreClase($item['clase'])[0]."</h5>";
                          echo "<h5 class='datos-pjs-lista hidden-xs'>".getNombreReino($item['reino'])."</h5>";
                        echo "</div>";
                      echo "</div>";
                    echo "</div>";
                  echo "</a>";
              }
            ?>
          </div>
          <!-- Fin Personajes 32 a 24-->

          <!-- Personajes 23 a 40-->
          <div class="col-12 col-md-3 columna_personajes" id="columna5">
            <?php
              foreach($datosCol5 as $item){
                  echo "<a href='personaje.php?nombre=".$item['nombre']."&reino=".$item['reino']."'>";
                    echo "<div class='col-12 personaje'>";
                      echo "<div class='row colInterna-lista ".getNombreFaccion($item['faccion'])."'>";
                        echo "<div class='col-xs-3'>";
                          if(!isset($item['imagen'])){
                            echo "<img class='img-fluid avatar-lista' src='img/avatar-lowlevel.png' alt=''>";
                          }else{
                            echo "<img class='img-fluid avatar-lista' src='http://render-".getNombreRegion($item['region']).".worldofwarcraft.com/character/".$item['imagen']."-avatar.jpg' alt=''>";
                          }
                        echo "</div>";
                        echo "<div class='col-xs-9'>";
                          echo "<h5 class='".getColorClase($item['clase'])." datos-pjs-lista'>".$item['nombre']."</h5>";
                          echo "<h5 class='datos-pjs-lista'><span>".$item['nivel']."</span> ".getnombreClase($item['clase'])[0]."</h5>";
                          echo "<h5 class='datos-pjs-lista hidden-xs'>".getNombreReino($item['reino'])."</h5>";
                        echo "</div>";
                      echo "</div>";
                    echo "</div>";
                  echo "</a>";
              }
            ?>
          </div>
          <!-- Fin Personajes 33 a 40 -->

          <!-- Personajes 41 a 48-->
          <div class="col-12 col-md-3 columna_personajes" id="columna6">
            <?php
              foreach($datosCol6 as $item){
                  echo "<a href='personaje.php?nombre=".$item['nombre']."&reino=".$item['reino']."'>";
                    echo "<div class='col-12 personaje'>";
                      echo "<div class='row colInterna-lista ".getNombreFaccion($item['faccion'])."'>";
                        echo "<div class='col-xs-3'>";
                          if(!isset($item['imagen'])){
                            echo "<img class='img-fluid avatar-lista' src='img/avatar-lowlevel.png' alt=''>";
                          }else{
                            echo "<img class='img-fluid avatar-lista' src='http://render-".getNombreRegion($item['region']).".worldofwarcraft.com/character/".$item['imagen']."-avatar.jpg' alt=''>";
                          }
                        echo "</div>";
                        echo "<div class='col-xs-9'>";
                          echo "<h5 class='".getColorClase($item['clase'])." datos-pjs-lista'>".$item['nombre']."</h5>";
                          echo "<h5 class='datos-pjs-lista'><span>".$item['nivel']."</span> ".getnombreClase($item['clase'])[0]."</h5>";
                          echo "<h5 class='datos-pjs-lista hidden-xs'>".getNombreReino($item['reino'])."</h5>";
                        echo "</div>";
                      echo "</div>";
                    echo "</div>";
                  echo "</a>";
              }
            ?>
          </div>
          <!-- Fin Personajes 41 a 48 -->

          <!-- Personajes 48 a 50-->
          <div class="col-12 col-md-3 columna_personajes" id="columna7">
            <?php
              foreach($datosCol7 as $item){
                  echo "<a href='personaje.php?nombre=".$item['nombre']."&reino=".$item['reino']."'>";
                    echo "<div class='col-12 personaje'>";
                      echo "<div class='row colInterna-lista ".getNombreFaccion($item['faccion'])."'>";
                        echo "<div class='col-xs-3'>";
                          if(!isset($item['imagen'])){
                            echo "<img class='img-fluid avatar-lista' src='img/avatar-lowlevel.png' alt=''>";
                          }else{
                            echo "<img class='img-fluid avatar-lista' src='http://render-".getNombreRegion($item['region']).".worldofwarcraft.com/character/".$item['imagen']."-avatar.jpg' alt=''>";
                          }
                        echo "</div>";
                        echo "<div class='col-xs-9'>";
                          echo "<h5 class='".getColorClase($item['clase'])." datos-pjs-lista'>".$item['nombre']."</h5>";
                          echo "<h5 class='datos-pjs-lista'><span>".$item['nivel']."</span> ".getnombreClase($item['clase'])[0]."</h5>";
                          echo "<h5 class='datos-pjs-lista hidden-xs'>".getNombreReino($item['reino'])."</h5>";
                        echo "</div>";
                      echo "</div>";
                    echo "</div>";
                  echo "</a>";
              }
            ?>
          </div>
          <!-- Fin Personajes 48 a 50-->

        </div>
      </div>
    </div>

    <!-- Columna derecha -->
    <div class="col-xs-0 col-md-2">
      <?php
        //Si hay más de 32 personajes, mostramos los botones izquierda y derecha.
        if($nPjs>32){
          echo "<div class='columFlechaDerecha'>";
            echo "<div class='flechaDerecha' onclick='mostrarColumnaDerecha()'></div>";
          echo "</div>";
        }
      ?>
    </div>
  </div>
  <!-- VENTANA DE BUSCAR PERSONAJE -->


  <!-- Modal -->
  <div class="modal fade" id="modalCrearPersonaje" tabindex="-1" role="dialog" aria-labelledby="modalCrearPersonaje" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content caja">
        <div class="modal-header">
          <h2 class="modal-title text-center" id="modalCrearPersonaje">Añadir personaje</h2>
        </div>
        <div class="modal-body">
          <div id="mostrarLoading"></div>
          <form class="formCrearPj text-center" action="personaje.html" method="post">
            <?php
              if($error){
                echo "<span class='text-danger'>Personaje no encontrado</span>";
              }
             ?>

            <p style="display:none">Opción 1:</p>
              <label for="linkWow"><h4>Copia el link del perfil del personaje de la <a href="https://worldofwarcraft.com/es-es/search?q=" target="_blank">armería</a></h4></label>
              <input class="input_wow input_wow_long" id="input1" type="text" name="linkWow" value=""
                onfocus="this.placeholder='',borrarInput2();"
                onblur="this.placeholder='Ejemplo: https://worldofwarcraft.com/es-es/character/zuljin/sirsyous'"
                placeholder="Ejemplo: https://worldofwarcraft.com/es-es/character/zuljin/sirsyous">
            <hr>
            <div style="display:none">
              <!-- Oculto de forma temporal hasta próximo contenido -->
              <p>Opción 2:</p>
                <p for="nombre"><h4>Crea un personaje de nivel menor a 10*</h4><h5>(Los personajes de menos de nivel 10 no aparecen en la armería)</h5><br></p>
                <table tabla text-center>
                  <tr>
                    <td><label for="nombre">Nombre:</label></td>
                    <td><input type="text" id="input2" class="input_wow input_wow_short" name="nombre" value=""
                      onfocus="this.placeholder='',borrarInput1();"
                      onblur="this.placeholder='Ejemplo: Sirsyous'"
                      placeholder="Ejemplo: Sirsyous"><br></td>
                  </tr>
                  <tr>
                    <td><label for="nombre">Reino:</label></td>
                    <td><input type="text" id="input3" class="input_wow input_wow_short" name="reino" value=""
                      onfocus="this.placeholder='',borrarInput1();"
                      onblur="this.placeholder='Ejemplo: Zuljin'"
                      placeholder="Ejemplo: Zuljin"></td>
                  </tr>
                  <tr>
                    <td><label for="nombre">Faccion:</label></td>
                    <td>
                      <select class="input_wow input_wow_short text-center" id="input4" name="faccion">
                        <option disabled selected value="3"></option>
                        <option value="0"  data-thumbnail="img/icon-alliance.png">Alianza</option>
                        <option value="1" data-thumbnail="img/icon-horde.png">Horda</option>
                      </select>
                    </td>
                  </tr>
                </table>
                <h5>*Estos personajes no podrán acceder a todas las funciones de WoWHelper</h5>
            </div>


          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn caja boton" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn caja" onclick="enviarFormPjs();" role="button">Añadir</button>
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
