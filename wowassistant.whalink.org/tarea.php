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
  $pagina="tarea";
  $idUser = $_SESSION["id_user"];
  $db = new db_connect();
  $mysqli = $db->getSqli();
  $cualquiera = false;
  $tareaRepetida = "false";

  $idTarea; //Id de la tarea
  $fuente; //Indica desde dónde se ha llamado

  //Comprobamos si viene de una llamada correcta a tarea.php
  if(!isset($_POST['idTarea']) || !isset($_POST['fuente'])){
    header("Location: tareas.php");
    exit();
  }else{
    $idTarea = $_POST['idTarea'];
    $fuente = $_POST['fuente'];
  }


  //Recuperamos todos los datos de los personajes de la BBDD
  $datosPj = getListaPersonajes($idUser,$mysqli);
  //Ordenamos Array recibida:
  function compareByName($datosPj, $b) {
    return strcmp($datosPj["nombre"], $b["nombre"]);
  }
  usort($datosPj, 'compareByName');

  //Recuperamos datos de la tareas
  $datosTarea=recuperarTarea($idUser,$idTarea,$mysqli);
  //Recuperamos Personajes de la tarea
  $datosPjBD[] = array();
  //Extramos información del personaje
  ///$pjTareas = getArrayPersonajes($datosTarea['personajes']);
  $pjTareas = getPersonajesTarea($idUser,$idTarea,$mysqli);
///  echo "IdUser: $idUser, idTarea: $idTarea";
  ///print_r($pjTareas);
  //Extraemos el ID del primero de ellos
  $nPersonajes = count($pjTareas);


?>
<!-- xxxxxxxxxxxxxxx CABECERA xxxxxxxxxxxxxx -->
<?php
  //Insertamos plantilla de cabecera
  include "../".INCLUDESROOT."/Templates/cabecera.php";
?>
<!-- xxxxxxxxxxxxx FIN CABECERA xxxxxxxxxx -->

<!-- xxxxxxxxxxxxxx CONTENIDO xxxxxxxxxxxx -->

<div id="mostrarLoading"></div>
<?php
  //Si sólo hay un personaje y no hay nota, mostramos el container más pequeño
  if ($nPersonajes==1 && $datosTarea['notas']=="") {
    echo '<div class="container caja_tareas">';
  }else{
    echo '<div class="container-flow caja_tareas">';
  }
?>

  <div class="col-xs-0 col-md-1"></div><!-- Separador -->
  <div class="container col-xs-12 col-md-10">
    <div class="row">
      <div class="col-12 offset-md-2 mostrar_tarea_actual caja barra_scroll">
        <div class="col-xs-12 lista_tarea_actual">
          <h1 class="centrado">Datos de la tarea</h1>
          <hr>
          <!-- Columna de datos -->
          <div class="col-xs-12 col-md-5">
            <table>
              <?php
                echo "<tr><td><p><b>Nombre: </b><i></td><td class='izquierda cursiva'><span class='columna'>".$datosTarea['nombre']."</span></i></p></td></tr>";
                echo "<tr><td><p><b>Tipo: </b><i></td>
                  <td class='izquierda cursiva'><span class='icon_columna'><img src='".getIconoTarea($datosTarea['tipo'],$datosTarea['subtipo'])."' class='icono_mini'></span><span> ".
                  getNombreTarea($datosTarea['tipo'],$datosTarea['subtipo'])."</span></i></p></td></tr>";
                //Dependiendo del valor de "repetir", mostramos un texto u otro
                $tiempoRepetir="";
                switch ($datosTarea['repetir']) {
                  case '0':
                    $tiempoRepetir = "No se repite <b>nunca</b>";
                    break;
                  case '1':
                    $tiempoRepetir = "Se repite <b>diariamente</b>";
                    $tareaRepetida = "true";
                    break;
                  case '2':
                    $tiempoRepetir = "Se repite <b>mensualmente</b>";
                    $tareaRepetida = "true";
                    break;
                }
                echo "<tr><td><p><b>Repetible: </b><i></td><td class='izquierda cursiva'><span class='columna'> ".$tiempoRepetir."</span></i></p></td></tr>";
                $prior="";
                switch ($datosTarea['prioridad']) {
                  case '1':
                    $prior = "<span class='oculto'>1</span>
                              <span class='fas fa-shield-alt checked prioridad1'></span>";
                    break;
                  case '2':
                    $prior = "<span class='oculto'>2</span>
                              <span class='fas fa-shield-alt checked prioridad2'></span>
                              <span class='fas fa-shield-alt checked prioridad2'></span>";
                    break;
                  case '3':
                    $prior = "<span class='oculto'>3</span>
                              <span class='fas fa-shield-alt checked prioridad3'></span>
                              <span class='fas fa-shield-alt checked prioridad3'></span>
                              <span class='fas fa-shield-alt checked prioridad3'></span>";
                    break;
                }
                echo "<tr><td><p><b>Prioridad: </b><i></td><td class='izquierda cursiva'><span class='columna'> ".$prior."</span></i></p></td></tr>";
                echo "<tr><td><p><b>Link: </b><i></td><td class='izquierda cursiva'><span class='columna'> <a href='".$datosTarea['link']."'>".$datosTarea['link']."</a></span></i></p></td></tr>";
                echo "<tr><td><p><b>Notas: </b><i></td><td class='izquierda cursiva'><span class='columna'>".$datosTarea['notas']."</span></i></p></td></tr>";
              ?>
            </table>
            <?php
              //Si es una tarea repetible, mostramos el botón de eliminar tarea de la BD
              if($datosTarea['repetir'] !=0){
                echo '<div class="col-xs-12 centrado">';
              }else{
                echo '<div class="col-xs-12 centrado oculto">';
              }
            ?>
              <br>
              <br>
              <button type="button" class="caja addTarea center-inline" data-toggle="modal" data-target="#modalTerminarTarea">
                Borrar esta tarea repetida
              </button>
            </div>
          </div>
          <!-- Fin columna de datos -->

          <!-- Columna de personajes -->
          <div class="col-xs-12 col-md-7 col_personajes_tarea barra_scroll">
            <p class="centrado"><b>Personajes en la tarea<b></p>
              <?php
                if($nPersonajes==1){
                  echo '<h5 class="centrado">Pulsa en <i>"Completar"</i> para terminar esta tarea</h5>';
                }else{
                  echo '<h5 class="centrado">Marca aquellos que ya la hayan terminado y pulsa en <i>"Guardar cambios"</i></h5>';
                }
                echo "<div class='col-xs-12 centrado'>";
                //Si no hay personajes no mostramos el boton de todos ni el de Ninguno
                if($nPersonajes>1){//Si los tiene se muestran
                  echo '<button type="button" class="caja botonMarcarPjs" onclick="marcarTodo();">';
                  echo 'Todos';
                  echo '</button>';
                  echo '<button type="button" class="caja botonMarcarPjs" onclick="desmarcarTodo(false,false);">';
                    echo 'Ninguno';
                  echo '</button>';
                }
                echo "</div>";


                $valorIdCheck=1;
                $idPj;
                $nombrePj="";
                $regionPj="";
                $reinoPj="";
                $nivelPj="";
                $imagenPj="";
                $clasePj="";
                foreach ($datosPj as $key => $value) {
                  foreach ($value as $item => $valor) {
                    //Extramos la información del personaje
                    switch ($item) {
                      case 'id':
                        $idPj = $valor;
                        break;
                      case 'nombre':
                        $nombrePj = $valor;
                        break;
                      case 'region':
                        $regionPj = $valor;
                        break;
                      case 'reino':
                        $reinoPj = getNombreReino($valor);
                        break;
                      case 'nivel':
                        $nivelPj = $valor;
                        break;
                      case 'imagen':
                        $imagenPj = $valor;
                        break;
                      case 'clase':
                        $clasePj = getColorClase($valor);
                        break;
                    }
                  }
                  //Mostramos el select con cada personaje siempre que esté en la lista de tareas

                  if(in_array($idPj,$pjTareas)){
                      if($nPersonajes==1){
                        //Añadimos un div delante para centrar el único personaje
                        echo "<div class='col-xs-0 col-sm-3'></div>";
                        echo "<div class='col-xs-12 col-sm-6'>";
                        echo "<input type='checkbox' class='lista_personajes_tareas check-with-label checkbox' id='personaje".$valorIdCheck."' name='lista_personajes' value='".$idPj."' checked />";
                      }else{
                        echo "<div class='col-xs-12 col-sm-3'>";
                        echo "<input type='checkbox' class='lista_personajes_tareas check-with-label checkbox' id='personaje".$valorIdCheck."' name='lista_personajes' value='".$idPj."' />";
                      }

                      if(in_array(0,$pjTareas)){ //Comprobamos si la tarea tiene al personaje 0 (cualquiera, que no existe en "personajes")
                        echo "<input type='checkbox' class='lista_personajes_tareas check-with-label checkbox' id='personaje".$valorIdCheck."' name='lista_personajes' value='0' checked />";
                        echo "<label class='label-for-check' for='personaje".$valorIdCheck."' onclick='desmarcarCualquiera()'>";
                          echo "<div class='col-xs-3 col-sm-3'>";
                          echo "<img class='icono_mini' src='img/avatar-lowlevel.png' alt=''>";
                          echo "</div>";
                          echo "<div class='col-xs-8'>Cualquiera<br></div>";
                        echo "</label>";
                      echo "</div>";
                      $valorIdCheck++;
                      }else{
                        echo "<label class='label-for-check' for='personaje".$valorIdCheck."'>";
                          echo "<div class='col-xs-3 col-sm-3'>";
                            if(!isset($imagenPj)){
                              echo "<img class='icono_mini' src='img/avatar-lowlevel.png' alt=''>";
                            }else{
                              echo "<img class='icono_mini' src='http://render-".getNombreRegion($regionPj).".worldofwarcraft.com/character/".$imagenPj."-avatar.jpg' alt=''>";
                            }
                          echo "</div>";
                          echo "<div class='col-xs-8 noseleccion'><span class='".$clasePj."'>".$nombrePj."</span><br>Nv. ".$nivelPj." <br>".getNombreReino($reinoPj)."</div>";
                        echo "</label>";
                      echo "</div>";
                      $valorIdCheck++;
                      }
                  }
                }


              ?>

          </div>
        </div>
        <!-- Fin columna de personajes -->

        <!-- Inicio botonera -->
        <div class="col-xs-12 centrado botones_tarea">
          <hr class="hr_tarea">
          <button type="button" class="caja addTarea center-inline" onclick="actualizarTarea(<?php echo $idTarea.",'".$fuente."',".$tareaRepetida; ?>,false)">
            <?php
              if($nPersonajes==1){
                echo "Completar tarea";
              }else{
                echo "Guardar cambios ";
              }
             ?>

          </button>
          <button type="button" class="caja addTarea center-inline" onclick="enviarTareaAtras('tareas')">
            Cancelar y volver
          </button>
        </div>

      </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalTerminarTarea" tabindex="-1" role="dialog" aria-labelledby="modalTerminarTarea" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content caja">
          <div class="modal-header">
            <h2 class="modal-title text-center" id="modalTerminarTarea">¿Estás seguro?</h2>
          </div>
          <div class="modal-body centrado">
            <h4>Al borrar esta tarea repetida no volverá a mostrarse
              <?php
                switch ($datosTarea['repetir']) {
                  case '1':
                    echo " <b>diariamente</b>.";
                    break;
                  case '2':
                    echo " <b>semanalmente</b>.";
                    break;
                }
               ?>
           <br><br>Esto provocará que la tarea se complete automáticamente.</h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn caja boton" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn caja" onclick="actualizarTarea(<?php echo $idTarea.",'".$fuente."',".$tareaRepetida; ?>,true);" role="button">Eliminar</button>
          </div>
        </div>
      </div>
    </div> <!-- Fin modal-->

</div>
<!-- xxxxxxxxxxxx FIN CONTENIDO xxxxxxxxxx -->

<!-- xxxxxxxxxxxxxxxx FOOTER xxxxxxxxxxxxx -->
<?php
  //Insertamos plantilla de pie
  include "../".INCLUDESROOT."/Templates/footer.php";
?>
