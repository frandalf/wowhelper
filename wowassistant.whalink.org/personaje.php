<?php
  header("Content-Type: text/html;charset=utf-8");
  session_start();
  include_once ("config.php");
  include_once ("../".INCLUDESROOT."/gestionVariables.php");
  include_once ("../".INCLUDESROOT."/seguridad.php");
  include_once ("../".INCLUDESROOT."/functions_wow.php");
  include_once ("../".INCLUDESROOT."/functions_tareas.php");
  include_once ("../".INCLUDESROOT."/db_connect.php");
  include_once ("../".INCLUDESROOT."/wowapi.php");
  comprobarSesion();//seguridad.php
  //Migas de pan:
  $pagina="personaje";

  //Variables de personaje
  $personaje="";
  $reino="";
  $idPj="";
  $region="";
  $nivel="";
  $clase="";
  $faccion="";
  $primaria="";
  $primValor="";
  $secundaria="";
  $pescaValor="";
  $cocinaValor="";
  $arqueoValor="";
  $secValor="";
  $imagen="";
  $actualizado="";
  //COMPROBACIONES PREVIAS
  //Recuperación datos get
  if (!isset($_GET["nombre"]) || !isset($_GET["reino"])) {
    //No existen, de vuelta a Principal
    header("Location: principal.php?error");
    die();
  }else{
    $personaje = $_GET["nombre"];
    $reino = $_GET["reino"];

    //Recuperamos todos los datos del personaje de la BBDD
    $idUser = $_SESSION["id_user"];
    $db = new db_connect();
    $mysqli = $db->getSqli();
    $datosPj = recuperarPj($idUser,$personaje,$reino,$mysqli);
    if(isset($datosPj["idPj"])){ //Comprobamos que no es un personaje de nivel bajo (estos no tienen id).
      $idPj=$datosPj["idPj"];
      $region=$datosPj["region"];
      $nivel=$datosPj["nivel"];
      $clase=$datosPj["clase"];
      $faccion=$datosPj["faccion"];
      $primaria=$datosPj["primaria"];
      $primValor=$datosPj["primaria_valor"];
      $secundaria=$datosPj["secundaria"];
      $secValor=$datosPj["secundaria_valor"];
      $pescaValor=$datosPj["pesca_valor"];
      $cocinaValor=$datosPj["cocina_valor"];
      $arqueoValor=$datosPj["arqueología_valor"];
      $imagen=$datosPj["imagen"];
      $actualizado=$datosPj["actualizado"];
    }else{
      $imagen = false; //indicamos que ponga el avatar estandar
    }


    //Devolvemos el nombre correcto del reino (añadiendo apóstrofes de ser necesario):
    //Capitalizamos:
    $personaje = ucfirst($personaje);
    $reino = ucfirst($reino);



  }

?>
<!-- xxxxxxxxxxxxxxx CABECERA xxxxxxxxxxxxxx -->
<?php
  //Insertamos plantilla de cabecera
  include "../".INCLUDESROOT."/Templates/cabecera.php";
  $json=extraerPersonaje($personaje,$reino,$region);

  //Comprobamos si se ha actualizado el personaje el día de hoy:
  $datosBasicos = datosBasicos($json,$personaje,$reino,$region);
  $nivelPj = $datosBasicos[1];
  comprobarPersonaje($actualizado,$idUser,$idPj,$nivelPj,$mysqli);
?>
<script>var whTooltips = {colorLinks: true, iconizeLinks: false, renameLinks: false};</script>
<script src="//wow.zamimg.com/widgets/power.js"></script>
<!-- xxxxxxxxxxxxx FIN CABECERA xxxxxxxxxx -->

<!-- xxxxxxxxxxxxxx CONTENIDO xxxxxxxxxxxx -->
<div id="mostrarLoading"></div>
<!-- CSS para poner imagen personalizada de fondo -->
<style media="screen">
  .infoEquipo:after, .tareaPersonaje {
      content:'';
      background: url('http://render-<?php echo getNombreRegion($region)?>.worldofwarcraft.com/character/<?php echo $imagen;?>-main.jpg') no-repeat center center;
      position: absolute;
      top:0px;
      left: 0px;
      width:100%;
      height:100%;
      z-index:-1;
      opacity: 1;
      background-size:cover;
  }

  .tareaPersonaje:after {

  }
</style>
<div class="contenido contenidoPj">
  <div class="container-fluid informacionPj">
    <div class="row">
      <div class="col-12 col-lg-3">
        <div class="infoEquipo colInfoPj caja">
          <!-- Avatar y nombre -->
          <div class="avatarCabecera ">
            <div class="row colInterna <?php echo getNombreFaccion($faccion)?>">
              <div class="col-xs-3 col-lg-3">
                <?php
                //Avatar. Si es de nivel bajo, muestra estandar.
                  if(!$imagen){
                    echo "<img class='img-fluid avatar-estandar' src='img/avatar-lowlevel.png' alt=''>";
                  }else{
                    echo "<img class='img-fluid avatar-".getNombreFaccion($faccion)."' src='http://render-".getNombreRegion($region).".worldofwarcraft.com/character/".$imagen."-avatar.jpg' alt=''>";
                  }
                 ?>
              </div>
              <div class="col-xs-9 col-lg-9">
                <span class="<?php echo getColorClase($clase)?> nombre"><?php echo $personaje; ?></span>
                <h4><span>Nivel <?php echo $nivel?></span> <?php echo getnombreClase($clase)[0]; ?></h4>
                <h4><?php echo getNombreReino($reino)?></h4>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="seccion">
                  <?php
                    //Recuperamos el equipo
                    $equipo = getEquipo($json);
                    $hermandad = getHermandad($json);
                    if($hermandad != ""){
                      echo "<h4>Hermandad: ".$hermandad."</H4>";//Falta extraer hermandad
                    }
                    echo "<h4>Nivel de objeto:<b> ".$equipo['ilvlTotal']."</b></h4>";
                    if(!isset($equipo['ilvlTotal'])){//Si está vacío no hay conexión con la API (posiblemente por máximo de conexiones por minuto);
                      //echo "<script type='text/javascript'>alert('Imposible conectar con servidor de Blizzard. No se mostrarán todos los datos. Inténtalo más tarde.')</script>";
                    }
                   ?>

                </div>
              </div>
            </div>
            <div class="equipacion">
              <div class="col-xs-3 col-md-3">
               <?php
                 //yelmo
                  if(isset($equipo['yelmo']['id'])){
                    echo "<a href='http://es.wowhead.com/item=".$equipo['yelmo']['id']."' target='_blank'/'>
                    <img src='https://wow.zamimg.com/images/wow/icons/large/".$equipo['yelmo']['icono'].".jpg'
                    class='iconoEquipo calidad".$equipo['yelmo']['calidad']."' ></a><br>";
                  }else{
                    echo "<img src='img/iconos/icon-eq-yelmo.jpg' class='iconoEquipo calidadNo'><br>";
                  }
                 //cuello
                  if(isset($equipo['cuello']['id'])){
                    echo "<a href='http://es.wowhead.com/item=".$equipo['cuello']['id']."' target='_blank'/'>
                    <img src='https://wow.zamimg.com/images/wow/icons/large/".$equipo['cuello']['icono'].".jpg'
                    class='iconoEquipo calidad".$equipo['cuello']['calidad']."' ></a><br>";
                  }else{
                    echo "<img src='img/iconos/icon-eq-cuello.jpg' class='iconoEquipo calidadNo'><br>";
                  }
                 //hombros
                  if(isset($equipo['hombros']['id'])){
                    echo "<a href='http://es.wowhead.com/item=".$equipo['hombros']['id']."' target='_blank'/'>
                    <img src='https://wow.zamimg.com/images/wow/icons/large/".$equipo['hombros']['icono'].".jpg'
                    class='iconoEquipo calidad".$equipo['hombros']['calidad']."' ></a><br>";
                  }else{
                    echo "<img src='img/iconos/icon-eq-hombros.jpg' class='iconoEquipo calidadNo'><br>";
                  }
                  //espalda
                  if(isset($equipo['espalda']['id'])){
                    echo "<a href='http://es.wowhead.com/item=".$equipo['espalda']['id']."' target='_blank'/'>
                    <img src='https://wow.zamimg.com/images/wow/icons/large/".$equipo['espalda']['icono'].".jpg'
                    class='iconoEquipo calidad".$equipo['espalda']['calidad']."' ></a><br>";
                  }else{
                    echo "<img src='img/iconos/icon-eq-pecho.jpg' class='iconoEquipo calidadNo'><br>";
                  }
                  //pecho
                  if(isset($equipo['pecho']['id'])){
                     echo "<a href='http://es.wowhead.com/item=".$equipo['pecho']['id']."' target='_blank'/'>
                     <img src='https://wow.zamimg.com/images/wow/icons/large/".$equipo['pecho']['icono'].".jpg'
                     class='iconoEquipo calidad".$equipo['pecho']['calidad']."' ></a><br>";
                  }else{
                     echo "<img src='img/iconos/icon-eq-pecho.jpg' class='iconoEquipo calidadNo'><br>";
                  }
                 //Camisa (sin datos en la API)
                  echo "<img src='img/iconos/icon-eq-camisa.jpg' class='iconoEquipo calidadNo'><br>";

                 //tabardo
                 if(isset($equipo['tabardo']['id'])){
                   echo "<a href='http://es.wowhead.com/item=".$equipo['tabardo']['id']."' target='_blank'/'>
                   <img src='https://wow.zamimg.com/images/wow/icons/large/".$equipo['tabardo']['icono'].".jpg'
                   class='iconoEquipo calidad".$equipo['tabardo']['calidad']."' ></a><br>";
                 }else{
                   echo "<img src='img/iconos/icon-eq-tabardo.jpg' class='iconoEquipo calidadNo'><br>";
                 }
                 //brazos
                 if(isset($equipo['brazos']['id'])){
                   echo "<a href='http://es.wowhead.com/item=".$equipo['brazos']['id']."' target='_blank'/'>
                   <img src='https://wow.zamimg.com/images/wow/icons/large/".$equipo['brazos']['icono'].".jpg'
                   class='iconoEquipo calidad".$equipo['brazos']['calidad']."' ></a><br>";
                 }else{
                   echo "<img src='img/iconos/icon-eq-brazos.jpg' class='iconoEquipo calidadNo'><br>";
                 }
               ?>
              </div>

              <!--Separador Armas-->
              <div class="col-xs-6 col-md-6 separadorArmas">
                <div class="centrado">
                  <div class="col-xs-6">
                    <?php
                       //manoDerecha
                          if(isset($equipo['manoDerecha']['id'])){
                            echo "<a href='http://es.wowhead.com/item=".$equipo['manoDerecha']['id']."' target='_blank'/'>
                            <img src='https://wow.zamimg.com/images/wow/icons/large/".$equipo['manoDerecha']['icono'].".jpg'
                            class='iconoEquipo  calidad".$equipo['manoDerecha']['calidad']."' ></a><br>";
                          }else{
                            echo "<img src='img/iconos/icon-eq-manoderecha.jpg' class='pull-left iconoEquipo calidadNo'><br>";
                          }
                    ?>
                  </div>
                  <div class="col-xs-6">
                    <?php
                       //manoIzquierda
                         if(isset($equipo['manoIzquierda']['id'])){
                           echo "<a href='http://es.wowhead.com/item=".$equipo['manoIzquierda']['id']."' target='_blank'/'>
                           <img src='https://wow.zamimg.com/images/wow/icons/large/".$equipo['manoIzquierda']['icono'].".jpg'
                           class='pull-left iconoEquipo calidad".$equipo['manoIzquierda']['calidad']."' ></a><br>";
                         }else{
                           echo "<img src='img/iconos/icon-eq-manoizquierda.jpg' class='iconoEquipo calidadNo'><br>";
                         }
                    ?>
                  </div>
                </div>
              </div><!--Separador Armas-->

              <div class="col-xs-3 col-md-3 derecha">
                <?php
                 //manos
                 if(isset($equipo['manos']['id'])){
                   echo "<a href='http://es.wowhead.com/item=".$equipo['manos']['id']."' target='_blank'/'>
                   <img src='https://wow.zamimg.com/images/wow/icons/large/".$equipo['manos']['icono'].".jpg'
                   class='iconoEquipo calidad".$equipo['manos']['calidad']."' ></a><br>";
                 }else{
                   echo "<img src='img/iconos/icon-eq-manos.jpg' class='iconoEquipo calidadNo'><br>";
                 }
                 //cinturon
                 if(isset($equipo['cinturon']['id'])){
                   echo "<a href='http://es.wowhead.com/item=".$equipo['cinturon']['id']."' target='_blank'/'>
                   <img src='https://wow.zamimg.com/images/wow/icons/large/".$equipo['cinturon']['icono'].".jpg'
                   class='iconoEquipo calidad".$equipo['cinturon']['calidad']."' ></a><br>";
                 }else{
                   echo "<img src='img/iconos/icon-eq-cinturon.jpg' class='iconoEquipo calidadNo'><br>";
                 }
                 //piernas
                 if(isset($equipo['piernas']['id'])){
                   echo "<a href='http://es.wowhead.com/item=".$equipo['piernas']['id']."' target='_blank'/'>
                   <img src='https://wow.zamimg.com/images/wow/icons/large/".$equipo['piernas']['icono'].".jpg'
                   class='iconoEquipo calidad".$equipo['piernas']['calidad']."' ></a><br>";
                 }else{
                   echo "<img src='img/iconos/icon-eq-piernas.jpg' class='iconoEquipo calidadNo'><br>";
                 }
                 //pies
                 if(isset($equipo['pies']['id'])){
                   echo "<a href='http://es.wowhead.com/item=".$equipo['pies']['id']."' target='_blank'/'>
                   <img src='https://wow.zamimg.com/images/wow/icons/large/".$equipo['pies']['icono'].".jpg'
                   class='iconoEquipo calidad".$equipo['pies']['calidad']."' ></a><br>";
                 }else{
                   echo "<img src='img/iconos/icon-eq-pies.jpg' class='iconoEquipo calidadNo'><br>";
                 }
                 //anillo1
                 if(isset($equipo['anillo1']['id'])){
                   echo "<a href='http://es.wowhead.com/item=".$equipo['anillo1']['id']."' target='_blank'/'>
                   <img src='https://wow.zamimg.com/images/wow/icons/large/".$equipo['anillo1']['icono'].".jpg'
                   class='iconoEquipo calidad".$equipo['anillo1']['calidad']."' ></a><br>";
                 }else{
                   echo "<img src='img/iconos/icon-eq-anillo.jpg' class='iconoEquipo calidadNo'><br>";
                 }
                 //anillo2
                 if(isset($equipo['anillo2']['id'])){
                   echo "<a href='http://es.wowhead.com/item=".$equipo['anillo2']['id']."' target='_blank'/'>
                   <img src='https://wow.zamimg.com/images/wow/icons/large/".$equipo['anillo2']['icono'].".jpg'
                   class='iconoEquipo calidad".$equipo['anillo2']['calidad']."' ></a><br>";
                 }else{
                   echo "<img src='img/iconos/icon-eq-anillo.jpg' class='iconoEquipo calidadNo'><br>";
                 }
                 //trinket1
                 if(isset($equipo['trinket1']['id'])){
                   echo "<a href='http://es.wowhead.com/item=".$equipo['trinket1']['id']."' target='_blank'/'>
                   <img src='https://wow.zamimg.com/images/wow/icons/large/".$equipo['trinket1']['icono'].".jpg'
                   class='iconoEquipo calidad".$equipo['trinket1']['calidad']."' ></a><br>";
                 }else{
                   echo "<img src='img/iconos/icon-eq-trinket.jpg' class='iconoEquipo calidadNo'><br>";
                 }
                 //trinket2
                 if(isset($equipo['trinket2']['id'])){
                   echo "<a href='http://es.wowhead.com/item=".$equipo['trinket2']['id']."' target='_blank'/'>
                   <img src='https://wow.zamimg.com/images/wow/icons/large/".$equipo['trinket2']['icono'].".jpg'
                   class='iconoEquipo calidad".$equipo['trinket2']['calidad']."' ></a><br>";
                 }else{
                   echo "<img src='img/iconos/icon-eq-trinket.jpg' class='iconoEquipo calidadNo'><br>";
                 }



                ?>
              </div>
            </div><!-- Fin Equipación-->
            <div class="col-xs-12 centrado">
              <br>
              <button type="button" class="caja addTarea" data-toggle="modal" data-target="#modalCrearTarea" disabled>
                Equipo de Azerita
              </button>
            </div>

          </div><!-- Fin avatar y nombre-->


        </div> <!-- infoPersonaje -->
      </div>
      <div class="col-12 col-lg-3">
        <div class="infoPersonaje colInfoPj caja">
          <!-- XX Secciones XX  -->
          <div class="cabeceraInfo col-xs-12">
            <h2 class='centrado tituloCabecera'>Datos adicionales</h2>
          </div>
            <!-- Profesiones-->
          <div>
            <div class="seccion">
              <?php
                $BfA="";
                //Recuperamos profesiones:
                $profesiones = getProfesiones($json);
                $profesiones = getArrayBarras($profesiones);
                $prof1icon=false;
                $prof2icon=false;
                //Preparamos iconos de profesiones
                if(isset($profesiones[0])){
                  $prof1icon = getIconProfesion($profesiones[0]);
                }
                if(isset($profesiones[9])){
                  $prof2icon = getIconProfesion($profesiones[9]);
                }
                if(!$prof1icon && !$prof2icon){
                  echo "<h3>No tiene profesiones</h3>";
                }else{//Si no hay profesión no añadimos nada
                  echo "<h4>Profesiones</h4>";
                  echo "<table class='tablaDoble'>";
                  echo "<tr><td class='td40'>";
                  echo "<img src='$prof1icon' class='icono_medio'> <span class='txtTituloProf'>$profesiones[0]</span></td>";
                  if($prof2icon != false){//Comprobamos si hay 2 y si la hay la añadimos
                    echo "<td class='td40'><img src='$prof2icon' class='icono_medio'> <span class='txtTituloProf'>$profesiones[9]</span></td>";
                  }
                  echo "<td class='td20'><button type='button' class='caja boton_mini pull-right' data-toggle='modal' data-target='#modalProfesiones'>
                    Ver+
                    </button></td></tr>";
                  echo "<tr><td>";
                  ///ToDo Reactivar cuando Expansión. Ahora falla en el online
                /*  echo "<div class='progress'>";
                    //  $porcentaje=$profesiones[8]/1.5;
                      echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                          echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                      echo "</div>";
                      if($faccion == 0){
                        $BfA = "Kul Tiras";
                      }else{
                        $BfA = "Zandalari";
                      }
                      echo "<span class='progress-type'>".$BfA."</span>";
                      //echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[8])."/150</span>";
                  echo "</div>";
                  echo "</td><td>";
                  if($prof2icon != false){
                    echo "<div class='progress'>";
                  //      $porcentaje=$profesiones[17]/1.5;
                        echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                            echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                        echo "</div>";
                        echo "<span class='progress-type'>".$BfA."</span>";
                        //echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[17])."/150</span>";
                    echo "</div>";
                  }*/
                  echo "</td></tr>";
                  echo "</table>";


                }
               ?>

            </div>
          </div> <!--Fin Profesiones -->
          <!-- Reputaciones -->
          <div>
            <?php
                if($nivel<100){
                  echo '<div class="oculto">';
                }else{
                  echo '<div class="seccion">';
                }
             ?>
              <h4>Reputaciones Legión</h4>
              <?php
              /*  MUESTRA ICONOS PROFE
              $caidosNoche = getReputacion($json,1859);
                echo "<div class='col-xs-10 progressFacciones'>";
                  echo "<div class='progress'>";
                      $porcentaje=getPorcentajeRepu($caidosNoche); //Valor*max/100
                      echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                          echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                      echo "</div>";
                      echo "<span class='progress-type'>".$caidosNoche[0]." (".$caidosNoche[2].")</span>";
                      echo "<span class='progress-completed'>".$caidosNoche[1]."/".$caidosNoche[3]."</span>";
                  echo "</div>";
                echo "</div>";
                echo "<div class='col-xs-2 progressFacciones'>";
                  echo "<img src='img/tareas/icon-prof-alquimia.png' class='icono20' alt=''>";
                  echo "<img src='img/tareas/icon-prof-alquimia.png' class='icono20' alt=''>";
                echo "</div>";*/
                $caidosNoche = getReputacion($json,1859);
                echo "<div class='progress'>";
                    $porcentaje=getPorcentajeRepu($caidosNoche); //Valor*max/100
                    echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                        echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                    echo "</div>";
                    echo "<span class='progress-type'>".$caidosNoche[0]." (".$caidosNoche[2].")</span>";
                    echo "<span class='progress-completed'>".$caidosNoche[1]."/".$caidosNoche[3]."</span>";
                echo "</div>";
                $farondis = getReputacion($json,1900);
                echo "<div class='progress'>";
                    $porcentaje=getPorcentajeRepu($farondis); //Valor*max/100
                    echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                        echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                    echo "</div>";
                    echo "<span class='progress-type'>".$farondis[0]." (".$farondis[2].")</span>";
                    echo "<span class='progress-completed'>".$farondis[1]."/".$farondis[3]."</span>";
                echo "</div>";
                $ejercitoLuz = getReputacion($json,2165);
                echo "<div class='progress'>";
                    $porcentaje=getPorcentajeRepu($ejercitoLuz); //Valor*max/100
                    echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                        echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                    echo "</div>";
                    echo "<span class='progress-type'>".$ejercitoLuz[0]." (".$ejercitoLuz[2].")</span>";
                    echo "<span class='progress-completed'>".$ejercitoLuz[1]."/".$ejercitoLuz[3]."</span>";
                echo "</div>";
                $argus = getReputacion($json,2170);
                echo "<div class='progress'>";
                    $porcentaje=getPorcentajeRepu($argus); //Valor*max/100
                    echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                        echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                    echo "</div>";
                    echo "<span class='progress-type'>".$argus[0]." (".$argus[2].")</span>";
                    echo "<span class='progress-completed'>".$argus[1]."/".$argus[3]."</span>";
                echo "</div>";
                $celadoras = getReputacion($json,1894);
                echo "<div class='progress'>";
                    $porcentaje=getPorcentajeRepu($celadoras); //Valor*max/100
                    echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                        echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                    echo "</div>";
                    echo "<span class='progress-type'>".$celadoras[0]." (".$celadoras[2].")</span>";
                    echo "<span class='progress-completed'>".$celadoras[1]."/".$celadoras[3]."</span>";
                echo "</div>";
                $ocaso = getReputacion($json,2045);
                echo "<div class='progress'>";
                    $porcentaje=getPorcentajeRepu($ocaso); //Valor*max/100
                    echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                        echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                    echo "</div>";
                    echo "<span class='progress-type'>".$ocaso[0]." (".$ocaso[2].")</span>";
                    echo "<span class='progress-completed'>".$ocaso[1]."/".$ocaso[3]."</span>";
                echo "</div>";
                $tejesuenos = getReputacion($json,1883);
                echo "<div class='progress'>";
                    $porcentaje=getPorcentajeRepu($tejesuenos); //Valor*max/100
                    echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                        echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                    echo "</div>";
                    echo "<span class='progress-type'>".$tejesuenos[0]." (".$tejesuenos[2].")</span>";
                    echo "<span class='progress-completed'>".$tejesuenos[1]."/".$tejesuenos[3]."</span>";
                echo "</div>";
                $monteAlto = getReputacion($json,1828);
                echo "<div class='progress'>";
                    $porcentaje=getPorcentajeRepu($monteAlto); //Valor*max/100
                    echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                        echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                    echo "</div>";
                    echo "<span class='progress-type'>".$monteAlto[0]." (".$monteAlto[2].")</span>";
                    echo "<span class='progress-completed'>".$monteAlto[1]."/".$monteAlto[3]."</span>";
                echo "</div>";
                $valarjar = getReputacion($json,1948);
                echo "<div class='progress'>";
                    $porcentaje=getPorcentajeRepu($valarjar); //Valor*max/100
                    echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                        echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                    echo "</div>";
                    echo "<span class='progress-type'>".$valarjar[0]." (".$valarjar[2].")</span>";
                    echo "<span class='progress-completed'>".$valarjar[1]."/".$valarjar[3]."</span>";
                echo "</div>";

              ?>

            </div>
          </div> <!-- /Reputaciones -->

          <!-- Links -->
          <div>
            <div class="seccion">
              <h4>Enlaces de interés</h4>
              <h5>- Armería: <?php echo "<a class='linkInteres' href='https://worldofwarcraft.com/".$region."/character/".$reino."/".$personaje."' target='_blank'>"; ?>LINK</a></h5>
              <h5>- Guías de clase de WoWChakra: <?php
                if($clase==12){//El nombre de los DH es distinto
                  echo "<a class='linkInteres' href='https://www.wowchakra.com/guias/clases/cazador-de-demonios'  target='_blank'>";
                }else{
                  echo "<a class='linkInteres' href='https://www.wowchakra.com/guias/clases/".getColorClase($clase)."clase'  target='_blank'>";
                }
               ?>LINK</a></h5>

               <!-- Tabs:
               <div class="tabs">
                  <div class="tab-button-outer">
                    <ul id="tab-button">
                      <li><a href="#tab01">Legión</a></li>
                      <li><a href="#tab02">Battle for Azeroth</a></li>
                    </ul>
                  </div>
                  <div class="tab-select-outer">
                    <select id="tab-select">
                      <option value="#tab01">Tab 1</option>
                      <option value="#tab02">Tab 2</option>
                      <option value="#tab03">Tab 3</option>
                      <option value="#tab04">Tab 4</option>
                      <option value="#tab05">Tab 5</option>
                    </select>
                  </div>

                  <div id="tab01" class="tab-contents">
                    <h2>Tab 1</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius quos aliquam consequuntur, esse provident impedit minima porro! Laudantium laboriosam culpa quis fugiat ea, architecto velit ab, deserunt rem quibusdam voluptatum.</p>
                  </div>
                  <div id="tab02" class="tab-contents">
                    <h2>Tab 2</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius quos aliquam consequuntur, esse provident impedit minima porro! Laudantium laboriosam culpa quis fugiat ea, architecto velit ab, deserunt rem quibusdam voluptatum.</p>
                  </div>
                  <div id="tab03" class="tab-contents">
                    <h2>Tab 3</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius quos aliquam consequuntur, esse provident impedit minima porro! Laudantium laboriosam culpa quis fugiat ea, architecto velit ab, deserunt rem quibusdam voluptatum.</p>
                  </div>
                  <div id="tab04" class="tab-contents">
                    <h2>Tab 4</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius quos aliquam consequuntur, esse provident impedit minima porro! Laudantium laboriosam culpa quis fugiat ea, architecto velit ab, deserunt rem quibusdam voluptatum.</p>
                  </div>
                  <div id="tab05" class="tab-contents">
                    <h2>Tab 5</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius quos aliquam consequuntur, esse provident impedit minima porro! Laudantium laboriosam culpa quis fugiat ea, architecto velit ab, deserunt rem quibusdam voluptatum.</p>
                  </div>
                  <script type="text/javascript">
                    $(function() {
                      var $tabButtonItem = $('#tab-button li'),
                          $tabSelect = $('#tab-select'),
                          $tabContents = $('.tab-contents'),
                          activeClass = 'is-active';

                      $tabButtonItem.first().addClass(activeClass);
                      $tabContents.not(':first').hide();

                      $tabButtonItem.find('a').on('click', function(e) {
                        var target = $(this).attr('href');

                        $tabButtonItem.removeClass(activeClass);
                        $(this).parent().addClass(activeClass);
                        $tabSelect.val(target);
                        $tabContents.hide();
                        $(target).show();
                        e.preventDefault();
                      });

                      $tabSelect.on('change', function() {
                        var target = $(this).val(),
                            targetSelectNum = $(this).prop('selectedIndex');

                        $tabButtonItem.removeClass(activeClass);
                        $tabButtonItem.eq(targetSelectNum).addClass(activeClass);
                        $tabContents.hide();
                        $(target).show();
                      });
                    });
                  </script>
                </div>-->




                <?php
                /*
                  $talentos = getnombreClase($clase);
                  if($clase==11){ //11 = Druída, que tiene 4 ramas de talentos
                    $rama1 = $talentos[1];
                    echo "<h5 class='tabulado'>· $rama1: <a class='linkInteres' href='".getLinkTalentosClase($clase)[0]."'>PVE</a>";
                    if(getLinkTalentosClase($clase)[4]!=""){
                      echo " - <a class='linkInteres' href=''>PVP</a></h5>";
                    }
                    $rama2 = $talentos[2];
                    echo "<h5 class='tabulado'>· $rama2: <a class='linkInteres' href='href='".getLinkTalentosClase($clase)[1]."'>PVE</a>";
                    if(getLinkTalentosClase($clase)[5]!=""){
                      echo " - <a class='linkInteres' href=''>PVP</a></h5>";
                    }
                    if($clase!=12){ //12 = Cazador de demonios, que sólo tiene dos ramas de talentos
                      $rama3 = $talentos[3];
                      echo "<h5 class='tabulado'>· $rama3: <a class='linkInteres' href='".getLinkTalentosClase($clase)[2]."'>PVE</a>";
                      if(getLinkTalentosClase($clase)[6]!=""){
                        echo " - <a class='linkInteres' href=''>PVP</a></h5>";
                      }
                    }
                    $rama4 = $talentos[4];
                    echo "<h5 class='tabulado'>· $rama4: <a class='linkInteres' href='".getLinkTalentosClase($clase)[3]."'>PVE</a>";
                    if(getLinkTalentosClase($clase)[7]!=""){
                      echo " - <a class='linkInteres' href=''>PVP</a></h5>";
                    }
                  }else{
                    $rama1 = $talentos[1];
                    echo "<h5 class='tabulado'>· $rama1: <a class='linkInteres' href='".getLinkTalentosClase($clase)[0]."'>PVE</a>";
                    if(getLinkTalentosClase($clase)[3]!=""){
                      echo " - <a class='linkInteres' href=''>PVP</a></h5>";
                    }
                    $rama2 = $talentos[2];
                    echo "<h5 class='tabulado'>· $rama2: <a class='linkInteres' href='href='".getLinkTalentosClase($clase)[1]."'>PVE</a>";
                    if(getLinkTalentosClase($clase)[4]!=""){
                      echo " - <a class='linkInteres' href=''>PVP</a></h5>";
                    }
                    if($clase!=12){ //12 = Cazador de demonios, que sólo tiene dos ramas de talentos
                      $rama3 = $talentos[3];
                      echo "<h5 class='tabulado'>· $rama3: <a class='linkInteres' href='".getLinkTalentosClase($clase)[2]."'>PVE</a>";
                      if(getLinkTalentosClase($clase)[5]!=""){
                        echo " - <a class='linkInteres' href=''>PVP</a></h5>";
                      }
                    }
                  }
                    */
                 ?>




            </div>
            <div class="seccion centrado">
              <br>
              <button type="button" class="caja addTarea" onclick="alert('Próximamente')">
                Tareas
              </button>
              <button type="button" class="caja addTarea" data-toggle="modal" data-target="#borrarPersonaje">
                Borrar personaje
              </button>


            </div>

          </div> <!-- fin links -->
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="infoTalentos colInfoPj caja centrado">
              Selecciona la rama de talentos
          <div class="col-xs-12 botonerTalentos">

            <?php
              $ancho1=4;
              $ancho2=4;
              $ancho3=4;
              $ancho4=0;
              $maxTalento=3;
              //Comprobamos cuántos botones se deben mostrar (2 Dh, 4 Druida, 3 resto)
              if($clase==11){//Druida
                $ancho1=3;
                $ancho2=3;
                $ancho3=3;
                $ancho4=3;
                $maxTalento=4;
              }else if($clase==12){//DemonHunter
                $ancho1=6;
                $ancho2=6;
                $ancho3=0;
                $ancho4=0;
                $maxTalento=2;
              }

              //Imprimimos los botones en el html
              /*1	Warrior	WARRIOR
              2	Paladin	PALADIN
              3	Hunter	HUNTER
              4	Rogue	ROGUE
              5	Priest	PRIEST
              6	Death Knight	DEATHKNIGHT
              7	Shaman	SHAMAN
              8	Mage	MAGE
              9	Warlock	WARLOCK
              10	Monk	MONK
              11	Druid	DRUID
              12	Demon Hunter	DEMONHUNTER*/
              echo "<div class='col-xs-$ancho1 caja botonesTalento' id='botonTalento1' onclick='selecTalento(1,".$maxTalento.",".$clase.")'>";
                echo getnombreClase($clase)[1];
              echo "</div>";
              echo "<div class='col-xs-$ancho2 caja botonesTalento' id='botonTalento2' onclick='selecTalento(2,".$maxTalento.",".$clase.")'>";
                echo getnombreClase($clase)[2];
              echo "</div>";
              if($clase!=12){
                echo "<div class='col-xs-$ancho3 caja botonesTalento' id='botonTalento3' onclick='selecTalento(3,".$maxTalento.",".$clase.")'>";
                    echo getnombreClase($clase)[3];
                echo "</div>";
              }
              if($clase==11){
                echo "<div class='col-xs-$ancho4 caja botonesTalento' id='botonTalento4' onclick='selecTalento(4,".$maxTalento.",".$clase.")'>";
                    echo getnombreClase($clase)[4];
                echo "</div>";
              }
             ?>
          </div>
          <div class="col-xs-12">
            <div class="col-xs-12 col-md-8 oculto" id="talentos0">
              Talentos
              <script type="text/javascript" src="js/talentos.js">//Cargamos script de talentos</script>
              <!-- Botonera 1º rama de talentos -->
              <div class="col-xs-12 botoneraTipoTalentos oculto" id="talentos1">
                <div class="col-xs-3 caja tipoTalento" id="tipoTalento11" onclick="selecTipoTalento(1,1,<?php echo $clase; ?>)">
                  <h5>Normal</h5>
                </div>
                <div class="col-xs-3 caja tipoTalento" id="tipoTalento12" onclick="selecTipoTalento(1,2,<?php echo $clase; ?>)">
                  <h5>Míticas</h5>
                </div>
                <div class="col-xs-3 caja tipoTalento" id="tipoTalento13" onclick="selecTipoTalento(1,3,<?php echo $clase; ?>)">
                  <h5>Raid</h5>
                </div>
                <div class="col-xs-3 caja tipoTalento" id="tipoTalento14" onclick="selecTipoTalento(1,4,<?php echo $clase; ?>)">
                  <h5>PVP</h5>
                </div>
              </div>
              <!-- Botonera 2º rama de talentos -->
              <div class="col-xs-12 botoneraTipoTalentos oculto" id="talentos2">
                <div class="col-xs-3 caja tipoTalento" id="tipoTalento21" onclick="selecTipoTalento(2,1,<?php echo $clase; ?>)">
                  <h5>Normal</h5>
                </div>
                <div class="col-xs-3 caja tipoTalento" id="tipoTalento22" onclick="selecTipoTalento(2,2,<?php echo $clase; ?>)">
                  <h5>Míticas</h5>
                </div>
                <div class="col-xs-3 caja tipoTalento" id="tipoTalento23" onclick="selecTipoTalento(2,3,<?php echo $clase; ?>)">
                  <h5>Raid</h5>
                </div>
                <div class="col-xs-3 caja tipoTalento" id="tipoTalento24" onclick="selecTipoTalento(2,4,<?php echo $clase; ?>)">
                  <h5>PVP</h5>
                </div>
              </div>
              <!-- Botonera 3º rama de talentos -->
              <div class="col-xs-12 botoneraTipoTalentos oculto" id="talentos3">
                <div class="col-xs-3 caja" id="tipoTalento31" onclick="selecTipoTalento(3,1,<?php echo $clase; ?>)">
                  <h5>Normal</h5>
                </div>
                <div class="col-xs-3 caja tipoTalento" id="tipoTalento32" onclick="selecTipoTalento(3,2,<?php echo $clase; ?>)">
                  <h5>Míticas</h5>
                </div>
                <div class="col-xs-3 caja tipoTalento" id="tipoTalento33" onclick="selecTipoTalento(3,3,<?php echo $clase; ?>)">
                  <h5>Raid</h5>
                </div>
                <div class="col-xs-3 caja tipoTalento" id="tipoTalento34" onclick="selecTipoTalento(3,4,<?php echo $clase; ?>)">
                  <h5>PVP</h5>
                </div>
              </div>
              <!-- Botonera 4º rama de talentos -->
              <div class="col-xs-12 botoneraTipoTalentos oculto" id="talentos4">
                <div class="col-xs-3 caja tipoTalento" id="tipoTalento41" onclick="selecTipoTalento(4,1,<?php echo $clase; ?>)">
                  <h5>Normal</h5>
                </div>
                <div class="col-xs-3 caja tipoTalento" id="tipoTalento42" onclick="selecTipoTalento(4,2,<?php echo $clase; ?>)">
                  <h5>Míticas</h5>
                </div>
                <div class="col-xs-3 caja tipoTalento" id="tipoTalento43" onclick="selecTipoTalento(4,3,<?php echo $clase; ?>)">
                  <h5>Raid</h5>
                </div>
                <div class="col-xs-3 caja tipoTalento" id="tipoTalento44" onclick="selecTipoTalento(4,4,<?php echo $clase; ?>)">
                  <h5>PVP</h5>
                </div>
              </div>
              <div class="col-xs-12">
                <div class="col-xs-4 caja cajaBotonTalento" id='talento11'>
                  <img class='botonTalento' src='img/iconos/icon-tal1.png'>
                </div>
                <div class="col-xs-4 caja cajaBotonTalento" id='talento12'>
                  <img class='botonTalento' src='img/iconos/icon-tal2.png'>
                </div>
                <div class="col-xs-4 caja cajaBotonTalento" id='talento13'>
                  <img class='botonTalento' src='img/iconos/icon-tal3.png'>
                </div>
              </div>
              <div class="col-xs-12">
                <div class="col-xs-4 caja cajaBotonTalento" id='talento21'>
                  <img class='botonTalento' src='img/iconos/icon-tal1.png'>
                </div>
                <div class="col-xs-4 caja cajaBotonTalento" id='talento22'>
                  <img class='botonTalento' src='img/iconos/icon-tal2.png'>
                </div>
                <div class="col-xs-4 caja cajaBotonTalento" id='talento23'>
                  <img class='botonTalento' src='img/iconos/icon-tal3.png'>
                </div>
              </div>
              <div class="col-xs-12">
                <div class="col-xs-4 caja cajaBotonTalento" id='talento31'>
                  <img class='botonTalento' src='img/iconos/icon-tal1.png'>
                </div>
                <div class="col-xs-4 caja cajaBotonTalento" id='talento32'>
                  <img class='botonTalento' src='img/iconos/icon-tal2.png'>
                </div>
                <div class="col-xs-4 caja cajaBotonTalento" id='talento33'>
                  <img class='botonTalento' src='img/iconos/icon-tal3.png'>
                </div>
              </div>
              <div class="col-xs-12">
                <div class="col-xs-4 caja cajaBotonTalento" id='talento41'>
                  <img class='botonTalento' src='img/iconos/icon-tal1.png'>
                </div>
                <div class="col-xs-4 caja cajaBotonTalento" id='talento42'>
                  <img class='botonTalento' src='img/iconos/icon-tal2.png'>
                </div>
                <div class="col-xs-4 caja cajaBotonTalento" id='talento43'>
                  <img class='botonTalento' src='img/iconos/icon-tal3.png'>
                </div>
              </div>
              <div class="col-xs-12">
                <div class="col-xs-4 caja cajaBotonTalento" id='talento51'>
                  <img class='botonTalento' src='img/iconos/icon-tal1.png'>
                </div>
                <div class="col-xs-4 caja cajaBotonTalento" id='talento52'>
                  <img class='botonTalento' src='img/iconos/icon-tal2.png'>
                </div>
                <div class="col-xs-4 caja cajaBotonTalento" id='talento53'>
                  <img class='botonTalento' src='img/iconos/icon-tal3.png'>
                </div>
              </div>
              <div class="col-xs-12">
                <div class="col-xs-4 caja cajaBotonTalento" id='talento61'>
                  <img class='botonTalento' src='img/iconos/icon-tal1.png'>
                </div>
                <div class="col-xs-4 caja cajaBotonTalento" id='talento62'>
                  <img class='botonTalento' src='img/iconos/icon-tal2.png'>
                </div>
                <div class="col-xs-4 caja cajaBotonTalento" id='talento63'>
                  <img class='botonTalento' src='img/iconos/icon-tal3.png'>
                </div>
              </div>
              <div class="col-xs-12">
                <div class="col-xs-4 caja cajaBotonTalento" id='talento71'>
                  <img class='botonTalento' src='img/iconos/icon-tal1.png'>
                </div>
                <div class="col-xs-4 caja cajaBotonTalento" id='talento72'>
                  <img class='botonTalento' src='img/iconos/icon-tal2.png'>
                </div>
                <div class="col-xs-4 caja cajaBotonTalento" id='talento73'>
                  <img class='botonTalento' src='img/iconos/icon-tal3.png'>
                </div>
              </div>
              <div class="col-xs-12">
                <div class="col-xs-6 caja" onclick='alert("Próximamente");'>
                  Personalizar
                </div>
                <div class="col-xs-6 cajaNaranja">
                  Plantilla
                </div>
              </div>

              <div class="col-xs-12">
                <hr>
                <p>Estadísticas</p>
                <h4 id='estadisticas'></h4>
              </div>
            </div>
            <div class="col-xs-12 col-md-4 oculto" id="talentos5">
              Talentos PVP
              <h4>Talento 1</h4>
                <h5><i>A elegir</i></h5>
              <h4>Talento 2</h4>
                <h5 id="talentoPvp2"><i></i></h5>
              <h4>Talento 3</h4>
                <h5 id="talentoPvp3"><i></i></h5>
              <h4>Talento 4</h4>
                <h5 id="talentoPvp4"><i></i></h5>
              <br>
              <hr>
              Poderes de Azerita
              <h5>Buscador de objetos de Azerita: <a href="http://es.wowhead.com/azerite-finder" target="_blank">LINK</a></h5>
              <h4>A buscar:</h4>
              <h5>Próximamente</h5>

            </div>
          </div>




        </div>
      </div>
      <!--
      <div class="col-12 col-lg-3">
        <div class="infoReputaciones colInfoPj caja">

        </div>
      </div>
    -->
    </div>
  </div>
</div>

<div class="contenido contenidoPj">
  <div class="container-fluid informacionPj">
    <div class="row">
      <div class="col-12 col-md-12 ">
        <div class="infoEquipo colInfoPj caja">

        </div>
      </div>
    </div>
  </div>
</div>

<!-- xxxxxxxxxxxx Modales xxxxxxxxxx -->
<!-- Modal Mostrar-->
<div class="modal fade" id="modalProfesiones" tabindex="-1" role="dialog" aria-labelledby="modalProfesiones" aria-hidden="true">
  <div class="modal-dialog modal" role="document">
    <div class="modal-content caja">
      <div class="modal-header">
        <h2 class="modal-title text-center" id="modalProfesiones">Profesiones</h2>
      </div>
      <div class="modal-body">
        <script type="text/javascript" src="js/cleanCode.js"></script>
        <div class="container-flow">
          <div class="row">
            <?php
              //Profesión 1
              echo "<div class='col-xs-12 col-md-6 centrado'>";
              echo "<img src='$prof1icon' class='icono_medio'> $profesiones[0]";

                //Classic
                echo "<div class='progress'>";
                    $porcentaje=$profesiones[1]/3;
                    echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                        echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                    echo "</div>";
                    echo "<span class='progress-type'>Classic</span>";
                    echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[1])."/300</span>";
                echo "</div>";
                //Terrallende
                echo "<div class='progress'>";
                    $porcentaje=$profesiones[2]/0.75;
                    echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                        echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                    echo "</div>";
                    echo "<span class='progress-type'>Terrallende</span>";
                    echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[2])."/75</span>";
                echo "</div>";
                //Rasganorte
                echo "<div class='progress'>";
                    $porcentaje=$profesiones[3]/0.75;
                    echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                        echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                    echo "</div>";
                    echo "<span class='progress-type'>Rasganorte</span>";
                    echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[3])."/75</span>";
                echo "</div>";
                //Cataclismo
                echo "<div class='progress'>";
                    $porcentaje=$profesiones[4]/0.75;
                    echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                        echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                    echo "</div>";
                    echo "<span class='progress-type'>Cataclismo</span>";
                    echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[4])."/75</span>";
                echo "</div>";
                //Pandaria
                echo "<div class='progress'>";
                    $porcentaje=$profesiones[5]/0.75;
                    echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                        echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                    echo "</div>";
                    echo "<span class='progress-type'>Pandaria</span>";
                    echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[5])."/75</span>";
                echo "</div>";
                //Draenor
                echo "<div class='progress'>";
                    $porcentaje=$profesiones[6];
                    echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                        echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                    echo "</div>";
                    echo "<span class='progress-type'>Draenor</span>";
                    echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[6])."/100</span>";
                echo "</div>";
                //Legion
                echo "<div class='progress'>";
                    $porcentaje=$profesiones[7];
                    echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                        echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                    echo "</div>";
                    echo "<span class='progress-type'>Legión</span>";
                    echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[7])."/100</span>";
                echo "</div>";
                //BfA
                echo "<div class='progress'>";
                    $porcentaje=$profesiones[8]/1.5;
                    echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                        echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                    echo "</div>";
                    echo "<span class='progress-type'>".$BfA."</span>";
                    echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[8])."/150</span>";
                echo "</div>";
                echo "</div>";

                //Profesión 2
                echo "<div class='col-xs-12 col-md-6 centrado'>";
                  if($prof2icon != false){//Comprobamos si hay 2 y si la hay la añadimos
                    echo "<img src='$prof2icon' class='icono_medio'> $profesiones[9]";
                    //Classic
                    echo "<div class='progress'>";
                        $porcentaje=$profesiones[10]/3;
                        echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                            echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                        echo "</div>";
                        echo "<span class='progress-type'>Classic</span>";
                        echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[10])."/300</span>";
                    echo "</div>";
                    echo "";
                    //Terrallende
                    echo "<div class='progress'>";
                        $porcentaje=$profesiones[11]/0.75;
                        echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                            echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                        echo "</div>";
                        echo "<span class='progress-type'>Terrallende</span>";
                        echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[11])."/75</span>";
                    echo "</div>";
                    //Rasganorte
                    echo "<div class='progress'>";
                        $porcentaje=$profesiones[12]/0.75;
                        echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                            echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                        echo "</div>";
                        echo "<span class='progress-type'>Rasganorte</span>";
                        echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[12])."/75</span>";
                    echo "</div>";
                    echo "";
                    //Cataclismo
                    echo "<div class='progress'>";
                        $porcentaje=$profesiones[13]/0.75;
                        echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                            echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                        echo "</div>";
                        echo "<span class='progress-type'>Cataclismo</span>";
                        echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[13])."/75</span>";
                    echo "</div>";
                    echo "";
                    //Pandaria
                    echo "<div class='progress'>";
                        $porcentaje=$profesiones[14]/0.75;
                        echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                            echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                        echo "</div>";
                        echo "<span class='progress-type'>Pandaria</span>";
                        echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[14])."/75</span>";
                    echo "</div>";
                    echo "";
                    //Draenor
                    echo "<div class='progress'>";
                        $porcentaje=$profesiones[15];
                        echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                            echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                        echo "</div>";
                        echo "<span class='progress-type'>Draenor</span>";
                        echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[15])."/100</span>";
                    echo "</div>";
                    echo "";
                    //Legion
                    echo "<div class='progress'>";
                        $porcentaje=$profesiones[16];
                        echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                            echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                        echo "</div>";
                        echo "<span class='progress-type'>Legión</span>";
                        echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[16])."/100</span>";
                    echo "</div>";
                    echo "";
                    //BfA
                    echo "<div class='progress'>";
                        $porcentaje=$profesiones[17]/1.5;
                        echo "<div class='progress-bar' role='progressbar' aria-valuenow='0' style='width: ".$porcentaje."%;'>";
                            echo "<span class='sr-only'>".$porcentaje."% Complete</span>";
                        echo "</div>";
                        echo "<span class='progress-type'>".$BfA."</span>";
                        echo "<span class='progress-completed'>".getNumeroProfesion($profesiones[17])."/150</span>";
                    echo "</div>";

                  }

                echo "</div>";
                //Comenzamos tabla de contribuciones a Frentes de Guerra:
                echo "<hr>";
                echo "<div class='col-xs-12 centrado'><h4>Contribuciones a Frentes de Guerra</h4></div>";
                echo "<div class='col-xs-12 col-md-6'>";
                  $matsProfesion1 = getProfesionFrentes($profesiones[0]);
                  if($matsProfesion1["item1id"] == ""){//Herboristería no tiene objeto
                    echo "<span class='class='matProf'><i>".$matsProfesion1["item1"]."</i></span>";
                  }else{
                    echo "<a href='http://es.wowhead.com/item=".$matsProfesion1["item1id"]."' class='matProf' target='_blank' data-wh-icon-size='small' data-wowhead='item=".$matsProfesion1["item1id"]." domain=es'>".$matsProfesion1["item1"]."</a><span class='matProf' target='_blank'> x".$matsProfesion1["item1num"]."</span><br>";
                    if(isset($matsProfesion1["item2id"])){
                      echo "<a href='http://es.wowhead.com/item=".$matsProfesion1["item2id"]."' class='matProf' target='_blank' data-wh-icon-size='small' data-wowhead='item=".$matsProfesion1["item2id"]." domain=es'>".$matsProfesion1["item2"]."</a><span class='matProf' target='_blank'> x".$matsProfesion1["item2num"]."</span>";
                    }
                  }
                echo "</div>";

                echo "<div class='col-xs-12 col-md-6'>";
                  if($prof2icon != false){//Comprobamos si hay 2 y si la hay la añadimos FRAN
                    $matsProfesion2 = getProfesionFrentes($profesiones[9]);
                    if($matsProfesion2["item1id"] == ""){//Herboristería no tiene objeto
                      echo "<span class='class='matProf'><i>".$matsProfesion2["item1"]."</i></span>";
                    }else{
                      echo "<a href='http://es.wowhead.com/item=".$matsProfesion2["item1id"]."' class='matProf' target='_blank' data-wh-icon-size='small' data-wowhead='item=".$matsProfesion2["item1id"]." domain=es'>".$matsProfesion2["item1"]."</a><span class='matProf' target='_blank'> x".$matsProfesion2["item1num"]."</span><br>";
                      if(isset($matsProfesion2["item2id"])){
                        echo "<a href='http://es.wowhead.com/item=".$matsProfesion2["item2id"]."' class='matProf' target='_blank' data-wh-icon-size='small' data-wowhead='item=".$matsProfesion2["item2id"]." domain=es'>".$matsProfesion2["item2"]."</a><span class='matProf' target='_blank'> x".$matsProfesion2["item2num"]."</span>";
                      }
                    }
                  }
                echo "</div>";
               ?>

          </div>
        </div>
      </div> <!-- Modal Body -->
      <div class="modal-footer">
        <button type="button" class="btn caja boton" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn caja" onclick="enviarFormTareas();" role="button">Añadir</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL MOSTRAR -->

<!-- Modal Mostrar-->
<div class="modal fade" id="borrarPersonaje" tabindex="-1" role="dialog" aria-labelledby="borrarPersonaje" aria-hidden="true">
  <div class="modal-dialog modal" role="document">
    <div class="modal-content caja">
      <br>
      <div class="modal-header">
        <h2 class="modal-title text-center" id="borrarPersonaje">¿Estás seguro? </h2>
      </div>
      <div class="modal-body centrado">
        <script type="text/javascript" src="js/cleanCode.js"></script>
        <p>Esta acción provocará que se eliminen todas las configuraciones del personaje, incluídas las tareas donde era el único incluído.</p>
        <p>Será eliminado de las tareas con más personajes, pero no se borrarán dichas tareas.</p>

      </div> <!-- Modal Body -->
      <div class="modal-footer">
        <button type="button" class="btn caja boton" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn caja" onclick="borrarPersonaje(<?php echo $idPj; ?>);" role="button">Borrar</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL MOSTRAR -->


<!-- xxxxxxxxxxxxxxxx FOOTER xxxxxxxxxxxxx -->
<?php
  //Insertamos plantilla de pie
  include "../".INCLUDESROOT."/Templates/footer.php";
?>
