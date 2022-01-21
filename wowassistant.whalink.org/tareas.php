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
  $pagina="tareas";
  $msjError="";
  $idUser = $_SESSION["id_user"];
  $db = new db_connect();
  $mysqli = $db->getSqli();

  //Comprobamos si se han renovado las misiones diarias:
  ///reactivarDiarias($idUser,$mysqli); //Se ha activado un nuevo sistema desde eventos Cron para eligerar las cargas. Activar para local o pruebas

  //Comprobamos si venimos de crear una tarea. De ser así, la guardamos en la BD
  if(isset($_POST["nombre"])){
    $fecha=date("Y-m-d H:i:s");
    $guardado = guardarTarea($_SESSION["id_user"],$_POST["nombre"],$_POST["tipo"],$_POST["subtipo"],$_POST["repetible"],$_POST["prioridad"],$_POST["link"],$_POST["notas"],$_POST["personajes"],$fecha,$mysqli,true);
    if(!$guardado){
      $msjError= "<script type='text/javascript'>alert('[Error.01] Error guardando la tarea en la base de datos. Inténtelo más tarde o contacte con frandalf.software@gmail.com');</script>";
    }
  }

  //Comprobamos si venimos de actualizar una tareas
  if(isset($_POST["accion"])){
    switch ($_POST["accion"]) {
      case 'actualizar':
        $listaPersonajes = $_POST["personajes"];
        $idTarea = $_POST["idTarea"];
        if($_POST["personajes"]!=""){//Comprobamos que hay algún personaje añadido
          $actualizado=actualizarTarea($idUser,$idTarea,$listaPersonajes,$mysqli);
          if(!$actualizado){
            $msjError= "<script type='text/javascript'>alert('[Error.02] Error actualizando la tarea en la base de datos. Inténtelo más tarde o contacte con frandalf.software@gmail.com');</script>";
          }
        }
        break;
      case 'eliminar':
        $idTarea = $_POST["idTarea"];
        $actualizado=eliminarTarea($idUser,$idTarea,$mysqli);
        if(!$actualizado){
          $msjError= "<script type='text/javascript'>alert('[Error.03] Error eliminando la tarea en la base de datos. Inténtelo más tarde o contacte con frandalf.software@gmail.com');</script>";
        }
        break;
      case 'elimina_repe':
        $idTarea = $_POST["idTarea"];
        $actualizado=eliminarTareaRepetida($idUser,$idTarea,$mysqli);
        if(!$actualizado){
          $msjError= "<script type='text/javascript'>alert('[Error.04] Error eliminando la tarea en la base de datos. Inténtelo más tarde o contacte con frandalf.software@gmail.com');</script>";
        }
        break;
      case 'actualizarTareaRepetible':
        $idTarea = $_POST["idTarea"];
        $actualizado=actualizarTareaRepetible($idUser,$idTarea,$mysqli,1);
        if(!$actualizado){
          $msjError= "<script type='text/javascript'>alert('[Error.05] Error eliminando la tarea en la base de datos. Inténtelo más tarde o contacte con frandalf.software@gmail.com');</script>";
        }
        break;

      default:
        // code...
        break;
    }

  }
?>

<!-- xxxxxxxxxxxxxxx CABECERA xxxxxxxxxxxxxx -->
<?php
  //Insertamos plantilla de cabecera
  include "../".INCLUDESROOT."/Templates/cabecera.php";

  //Comprobamos si hay error:
  if($msjError!=""){
    echo $msjError;
  }

  //Recuperamos lista de tareas
  $tareas=getTareas($idUser,$mysqli);

  //Recuperamos todos los datos de los personajes de la BBDD
  $datosPj = getListaPersonajes($idUser,$mysqli);
  //Ordenamos Array recibida:
  function compareByName($datosPj, $b) {
    return strcmp($datosPj["nombre"], $b["nombre"]);
  }
  usort($datosPj, 'compareByName');
?>

<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript">
  //Cuando se pulsa en una tarea, se abre "tarea.php" donde se muestra los datos de la pulsada usando un post
  var lineaPulsada=0;
  $(document).ready(function() {
    $(".filaTarea").click(function() {
      enviarFormMostrarTarea(lineaPulsada,"tareas");
      //$('#mostrarLoading2').show();
      document.getElementById("mostrarLoading2").innerHTML="<div class='cargando'><div class='cajon'><div class='ball'></div></div></div>";
    });
  });



  window.onload = function() {
    document.getElementById("mostrarLoading2").innerHTML="";
  };
</script>


<!-- xxxxxxxxxxxxx FIN CABECERA xxxxxxxxxx -->

<!-- xxxxxxxxxxxxxx CONTENIDO xxxxxxxxxxxx -->
  <!--CAJA DE LISTA DE PERSONAJES -->
  <div id="mostrarLoading2">
    <div class='cargando'><div class='cajon'><div class='ball'></div></div></div>
  </div>
  <div class="container-flow caja_tareas">
    <!-- Columna izquierda -->
    <div class="col-xs-0 col-md-2">

    </div>

    <!-- Columna Central (lista personajes) -->
    <div class="container col-xs-12 col-md-8">
      <div class="row">
        <button type="button" class="caja addTarea pull-right" data-toggle="modal" data-target="#modalCrearTarea">
          + AÑADIR
        </button>
        <!--<a href="crearTarea.php">
          <button type="button" class="caja addTarea pull-right">
            + AÑADIR
          </button>
        </a>-->
      </div>
      <div class="row">
        <div class="col-12 offset-md-2 lista_tareas caja barra_scroll">

          <script type="text/javascript" src="js/ordenar.js">

          </script>
          <table id="tabla_tareas" class="table table-responsive">
            <thead>
              <tr id="cabecera_tabla">
               <th onclick="sort_fecha();" class="th_cabecera" id="th_fecha">Fecha <i class="fa fa-sort icon-ordenable" ></i></th>
               <th onclick="sort_tipo();" class="th_cabecera" id="th_tipo">Tipo <i class="fa fa-sort icon-ordenable" ></i></th>
               <th onclick="sort_nombre();" class="th_cabecera" id="th_nombre">Nombre <i class="fa fa-sort icon-ordenable" ></i></th>
               <th onclick="sort_repetir();" class="th_cabecera centrado" id="th_repetir">Repetir <i class="fa fa-sort icon-ordenable" ></i></th>
               <th onclick="sort_personajes();" class="th_cabecera" id="th_personajes">Personajes <i class="fa fa-sort icon-ordenable" ></i></th>
               <th onclick="sort_urgencia();" class="th_cabecera centrado" id="th_prioridad">Prioridad <i class="fa fa-sort icon-ordenable" ></i></th>
              </tr>
            </thead>
             <tbody id="table1"  class="linea_tarea">
               <tr>

               </tr>
               <?php
                //Mostramos todas las tareas del usuario
                  foreach ($tareas as $item) {
                    echo "<tr onclick='lineaPulsada=".$item['id']."' class='filaTarea' id='linkTarea' data-toggle='modal' data-id='".$item['id']."' data-target='#modalMostrarTareaX'>";
                        //Ponemos la fecha en el formato dd-mm-yyyy: FRAN
                        $fechaEuropea = date_format(date_create_from_format('Y-m-d', $item['fecha']), 'd-m-Y');
                      echo "<td>".$fechaEuropea."</td>";
                      echo "<td><div class='col-xs-2'><img src='".getIconoTarea($item['tipo'],$item['subtipo'])."' class='icono_mini'></div>
                            <div class='col-xs-10'>".getNombreTarea($item['tipo'],$item['subtipo'])."</div>
                            </td>";
                      echo "<td>".$item['nombre']."</td>";
                        //Dependiendo del valor de "repetir", mostramos un texto u otro
                        $tiempoRepetir="";
                        switch ($item['repetir']) {
                          case '0':
                            $tiempoRepetir = "Nunca";
                            break;
                          case '1':
                            $tiempoRepetir = "Diariamente";
                            break;
                          case '2':
                            $tiempoRepetir = "Semanalmente";
                            break;
                        }
                      echo "<td class='centrado'>".$tiempoRepetir."</td>";
                        //Extramos información del personaje
                        ///$pjTareas = getArrayPersonajes($item['personajes']);
                        $pjTareas = getPersonajesTarea($idUser,$item['id'],$mysqli);
                        ///print_r($pjTareas);
                        //Extraemos el ID del primero de ellos
                        if(isset($pjTareas[0])){
                          $idPrimero = $pjTareas[0];
                        }else{
                          $idPrimero = 0;
                        }
                        $nPersonajes = count($pjTareas);
                        $datosPjBD = getPersonaje($idUser,$idPrimero,$mysqli);
                        //Si hay más de uno, mostramos el primero seguido de "y n+". Sino, sólo el primero
                        if ($nPersonajes > 1) {
                          $nombreFinal = "<span class='".getColorClase($datosPjBD['clase'])."'>".$datosPjBD['nombre']."</span> - ".getNombreReino($datosPjBD['reino'])." y ".($nPersonajes-1)."+";
                        }else{
                          if(isset($datosPjBD['nombre'])){//Comprobamos si existe nombre. Si no, se seleccionó a "Cualquiera", que no existe en la BD
                            $nombreFinal = "<span class='".getColorClase($datosPjBD['clase'])."'>".$datosPjBD['nombre']."</span> - ".getNombreReino($datosPjBD['reino']);
                          }else{
                            $nombreFinal = "Cualquiera";
                          }
                        }
                        //También comprobamos qué imagen poner
                        $avatar="";
                        if(!isset($datosPjBD['imagen'])){
                          $avatar='img/avatar-lowlevel.png';
                        }else{
                          $avatar="http://render-".getNombreRegion($datosPjBD['region']).".worldofwarcraft.com/character/".$datosPjBD['imagen']."-avatar.jpg";
                        }
                      echo "<td><div class='col-xs-2'><img src='".$avatar."' class='icono_mini caja'></div><div class='col-xs-10'> " .$nombreFinal."</td></div>";
                        //Comprobamos la prioridad para mostrar el texto adecuado:
                        $prior="";
                        switch ($item['prioridad']) {
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
                      echo "<td class='centrado'>".$prior."</td>";
                    echo "</tr>";
                  }
               ?>
             </tbody>
          </table>

          <input type="hidden" id="name_order" value="asc">
          <input type="hidden" id="age_order" value="asc">

        </div>
      </div>
    </div>

    <!-- Columna derecha -->
    <div class="col-xs-0 col-md-2">

    </div>
  </div>
  <!-- VENTANA DE BUSCAR PERSONAJE -->


  <!-- Modal Creacion-->
  <div class="modal fade" id="modalCrearTarea" tabindex="-1" role="dialog" aria-labelledby="modalCrearTarea" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content caja">
        <div class="modal-header">
          <h2 class="modal-title text-center" id="modalCrearTarea">Añadir tarea</h2>
        </div>
        <div class="modal-body">
          <script type="text/javascript" src="js/cleanCode.js"></script>
          <div class="row">
            <div id="mostrarLoading"></div>
            <div class="col-xs-12">
              <form class="formCrearPj text-center" action="crearTarea.php" method="post" id="formulario_crearTarea" name="formulario_crearTarea">
                <table class="tabla_creacion_tarea">
                  <tr>
                    <td id="label_nombre">*Nombre:</td>
                    <td><input class="input_wow input_wow_short" id="nombreTarea" type="text" name="nombre" value=""
                      onfocus="this.placeholder='';"
                      onblur="this.placeholder='Ejemplo: Conseguir espada crómatica'"
                      placeholder="Ejemplo: Conseguir espada crómatica"
                      minlength="3" maxlength="50"
                      onkeyup="this.value=limpiarCodigo(this.value)"
                      ></td>
                  </tr>
                  <tr>
                    <td id="label_tipo">*Tipo:</td>
                    <td>
                      <select class="class input_wow input_wow_short" onchange="cargarTareas(this)" name="tipo" id="tipo" >
                        <option disabled selected value="0">-- Elige una opción --</option>
                        <option value="1">Coleccionables (monturas, mascotas, etc.)</option>
                        <option value="2">Logros</option>
                        <option value="3">Monedas</option>
                        <option value="4">Objetos</option>
                        <option value="5">PvP</option>
                        <option value="6">Pieza de equipo</option>
                        <option value="7">Profesión</option>
                        <option value="8">Reputación</option>
                        <option value="9">Subastar, comprar y/o vender</option>
                        <option value="10">* Personalizado *</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td><span id="label_subtipo">Sub-Tipo:</span></td>
                    <td>
                      <select class="class input_wow input_wow_short" name="tipo" id="subtipo">
                        <option value="0">-- No necesario con el tipo elegido --</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>*Repetible:</td>
                    <td>
                      <select class="class input_wow input_wow_short" name="repetible" id="repetible">
                        <option value="0">Nunca</option>
                        <option value="1">Diariamente</option>
                        <option value="2">Semanalmente (los miércoles)</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>*Prioridad:</td>
                    <td>
                      <select class="class input_wow input_wow_short" name="prioridad" id="prioridad">
                        <option value="1">1 - baja</option>
                        <option value="2" selected>2 - media</option>
                        <option value="3">3 - alta</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      Link (opcional):
                    </td>
                    <td><input class="input_wow input_wow_short" id="link" type="text" name="nombre" value=""
                      onfocus="this.placeholder='';"
                      onblur="this.placeholder='Ejemplo: http://es.wowhead.com/item=1604/espada-cromática'"
                      placeholder="Ejemplo: http://es.wowhead.com/item=1604/espada-cromática'"
                      minlength="10" maxlength="150"
                      onkeyup="this.value=limpiarCodigo(this.value)"
                      ></td>
                  </tr>
                  <tr>
                    <td>
                      Notas (opcional):
                    </td>
                    <td>
                      <textarea name="notas" rows="7" cols="80" maxlength="280" id="notas" class="input_wow input_wow_short"
                      onfocus="this.placeholder='';"
                      onblur="this.placeholder='Ejemplo: La suelta Panzaescama, en El Cabo de Tuercespina. Desactivar el Modo Guerra para no morir :('"
                      placeholder="Ejemplo: La suelta Panzaescama, en El Cabo de Tuercespina. Desactivar el Modo Guerra para no morir :("
                      onkeyup="this.value=limpiarCodigo(this.value)"
                      ></textarea>
                    </td>
                  </tr>

                </table>
                <h5>* Campos obligatorios</h5>
                <hr>

            </div> <!--Div del primer panel del creador de tareas -->
            <div class="col-xs-12  text-center">
              <p class="centrado ">Personajes que la llevarán a cabo:</p>
              <button type="button" class="caja botonMarcarPjs" onclick="desmarcarTodo(true,true);" id="boton_cualquiera">
                Cualquiera
              </button>
              <?php
                //Si no hay personajes no mostramos el boton de todos ni el de Ninguno
                if(count($datosPj)>0){//Si los tiene se muestran
                  echo '<button type="button" class="caja botonMarcarPjs" onclick="marcarTodo();">';
                  echo 'Todos';
                  echo '</button>';
                  echo '<button type="button" class="caja botonMarcarPjs" onclick="desmarcarTodo(false,true);">';
                    echo 'Ninguno';
                  echo '</button>';
                }else{//Si no los tiene, se le sugiere que los cree
                  echo "<h3 class='error'>Atención:</h3>";
                  echo "<h4>En estos momentos no tienes ningún personaje agregado.</h4><h4>Ve a <a href='personajes.php'>Personajes</a> para añadirlos y empezar a asignarles tareas.</h4>";
                }
               ?>

            </div>
            <div class="row no-gutter">
              <?php
                //Cargamos todos los personajes del usuario
                $valorIdCheck=1;
                foreach($datosPj as $item){
                  echo "<div class='col-xs-6 col-md-3'>";
                    echo "<input type='checkbox' class='lista_personajes_tareas check-with-label checkbox' id='personaje".$valorIdCheck."' name='lista_personajes' value='".$item['id']."' />";
                    echo "<label class='label-for-check' for='personaje".$valorIdCheck."' onclick='desmarcarCualquiera()'>";
                      echo "<div class='col-xs-3 col-md-3'>";
                        if(!isset($item['imagen'])){
                          echo "<img class='icono_mini' src='img/avatar-lowlevel.png' alt=''>";
                        }else{
                          echo "<img class='icono_mini' src='http://render-".getNombreRegion($item['region']).".worldofwarcraft.com/character/".$item['imagen']."-avatar.jpg' alt=''>";
                        }
                      echo "</div>";
                      echo "<div class='col-xs-8 noseleccion'>".$item['nombre']."<br>".$item['nivel']." ".getNombreReino($item['reino'])."</div>";
                    echo "</label>";
                  echo "</div>";
                  $valorIdCheck++;
                }
              ?>

            </div> <!--Panel de personajes -->
            <div class="centrado error tarea_error" id="tarea_error"></div>
          </div>
      </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn caja boton" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn caja" onclick="enviarFormTareas();" role="button">Añadir</button>
        </div>
      </div>
    </div>
  </div>
  <!-- FIN MODAL CREACION -->

  <!-- Modal Mostrar-->
  <div class="modal fade" id="modalMostrarTarea" tabindex="-1" role="dialog" aria-labelledby="modalMostrarTarea" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content caja">
        <div class="modal-header">
          <h2 class="modal-title text-center" id="modalMostrarTarea">Tarea</h2>
        </div>
        <div class="modal-body">
          <script type="text/javascript" src="js/cleanCode.js"></script>

      </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn caja boton" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn caja" onclick="enviarFormTareas();" role="button">Añadir</button>
        </div>
      </div>
    </div>
  </div>
  <!-- FIN MODAL MOSTRAR -->




<!-- xxxxxxxxxxxx FIN CONTENIDO xxxxxxxxxx -->

<!-- xxxxxxxxxxxxxxxx FOOTER xxxxxxxxxxxxx -->
<?php
  //Insertamos plantilla de pie
  include "../".INCLUDESROOT."/Templates/footer.php";
?>
