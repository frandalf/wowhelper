<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>

     <?php
     echo("<title>".NOMBREAPP."</title>"); ?>
     <link rel="shortcut icon" href="img/favicon.ico" />
     <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
     <script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="styles/loading.css">
     <link rel="stylesheet" href="styles/styles.css">
     <link href="https://fonts.googleapis.com/css?family=Do+Hyeon" rel="stylesheet">
     <script type="text/javascript" src="js/scripts.js"></script>
     <script type="text/javascript" src="js/cookie.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>
  <body>
    <div class="principal">
      <header>
      <div class="container-fluid barraNevagacion"  id="menuPrincipal">
        <div class="row primerMenu">
            <div class="col-xs-12 col-md-2 centrado">
              <a class="" href="principal.php">
                <span><img src="img/logo_wowhelper_white.png" class="logo-nav" alt="Logotipo WowHelper"></span>
              </a>
            </div>
            <div class="col-xs-12 col-md-8 centrado">
              <a href="principal.php" class="enlaceMenu">
                <div class="col-xs-12 col-md-3 opcionMenu primeroOpcionMenu">
                  Inicio
                </div>
              </a>
              <a href="tareas.php" class="enlaceMenu">
                <div class="col-xs-12 col-md-3 opcionMenu">
                  Tareas
                </div>
              </a>
              <a href="personajes.php" class="enlaceMenu">
                <div class="col-xs-12 col-md-3 opcionMenu">
                  Personajes
                </div>
              </a>
              <a href="guias.php" class="enlaceMenu">
                <div class="col-xs-12 col-md-3 opcionMenu ultimoOpcionMenu">
                  Guías
                </div>
              </a>
            </div>
        </div> <!--row-->

        <div class="row segundoMenu">
          <div class="col-xs-0 col-md-2"></div>
          <div class="col-xs-12 col-md-8">
            <div class="col-xs-7 col-md-7 text-left migasPan">
            <?php
              if (isset($pagina)) {
                //Preparamos las migas de pan:
                switch ($pagina) {
                  case 'tareas':
                    echo "<a href='principal.php'>Inicio</a> <i class='fas fa-angle-right'></i> <a href='tareas.php'>Tareas</a>";
                    break;
                  case 'tarea':
                    echo "<a href='principal.php'>Inicio</a> <i class='fas fa-angle-right'></i> <a href='tareas.php'>Tareas</a> <i class='fas fa-angle-right'></i> <a href='personaje.php'>Tarea</a>";
                    break;
                  case 'personajes':
                    echo "<a href='principal.php'>Inicio</a> <i class='fas fa-angle-right'></i> <a href='personajes.php'>Personajes</a>";
                    break;
                  case 'personaje':
                    echo "<a href='principal.php'>Inicio</a> <i class='fas fa-angle-right'></i> <a href='personajes.php'>Personajes</a> <i class='fas fa-angle-right'></i> <a href='personaje.php'>Personaje</a>";
                    break;
                  case 'inicio':
                    echo "<a href='principal.php'>Inicio</a>";
                    break;
                  case 'guias':
                    echo "<a href='principal.php'>Inicio</a> <i class='fas fa-angle-right'></i> <a href='guias.php'>Guías</a>";
                    break;
                  case 'secretos':
                      echo "<a href='principal.php'>Inicio</a> <i class='fas fa-angle-right'></i> <a href='guias.php'>Guías</a> <i class='fas fa-angle-right'></i> <a href='guias-secretos.php'>Secretos</a>";
                    break;
                  case 'otros':
                      echo "<a href='principal.php'>Inicio</a> <i class='fas fa-angle-right'></i> <a href='guias.php'>Guías</a> <i class='fas fa-angle-right'></i> <a href='guias-otros.php'>Otros</a>";
                    break;
                  case 'reputaciones':
                      echo "<a href='principal.php'>Inicio</a> <i class='fas fa-angle-right'></i> <a href='guias.php'>Guías</a> <i class='fas fa-angle-right'></i> <a href='guias-reputaciones.php'>Reputaciones</a>";
                    break;
                  case 'coleccionables':
                      echo "<a href='principal.php'>Inicio</a> <i class='fas fa-angle-right'></i> <a href='guias.php'>Guías</a> <i class='fas fa-angle-right'></i> <a href='guias-coleccionables.php'>Coleccionables</a>";
                    break;
                  case 'monturas':
                    echo "<a href='principal.php'>Inicio</a> <i class='fas fa-angle-right'></i> <a href='guias.php'>Guías</a> <i class='fas fa-angle-right'></i> <a href='guias-coleccionables.php'>Coleccionables</a> <i class='fas fa-angle-right'></i> <a href='guias-coleccionables-monturas.php'>Monturas</a>";
                    break;
                  case 'profesiones':
                    echo "<a href='principal.php'>Inicio</a> <i class='fas fa-angle-right'></i> <a href='guias.php'>Guías</a> <i class='fas fa-angle-right'></i> <a href='guias-profesiones.php'>Profesiones</a>";
                    break;

                }
              }
            ?>
          </div>
          <div class="col-xs-12 col-md-5 bienvenida">
            <?php
              $nombre = $_COOKIE["user"];
              echo("<span>Bienvenido, ".$nombre.".  <a href='desconectar.php'>[Desconectar]</a></span>");
            ?>
          </div>
          </div>
        </div> <!-- Segundo menú-->
      </div>


      <!-- XXXXXXXXXXXXXXXX -->
      <div class="container-fluid barraNevagacion" style="display:none" id="navMenu">
        <nav class="navbar navbar-inverse navbar-static-top nav-justified" role="navigation" >
          <a class="navbar-brand" href="principal.php">
            <span><img src="img/logo_wowhelper_white.png" class="logo-nav" alt="Logotipo WowHelper"></span>
          </a>
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav nav-justified">
                <li class="nav-item primer_link"><a href="principal.php">Inicio</a></li>
                <li class="nav-item"><a href="tareas.php">Tareas</a></li>
                <li class="nav-item"><a href="personajes.php">Personajes</a></li>
                <li class="nav-item"><a href="guias.php">Guías</a></li>
                <li class="nav-item visible-xs"><a href="desconectar.php">[Desconectar]</a></li>
              </ul>
            </div>
            <div class="col-xs-12 derecha">
              <?php
                $nombre = $_COOKIE["user"];
                echo("<span>Bienvenido, ".$nombre.".  <a href='desconectar.php'>[Desconectar]</a></span>");
               ?>

            </div>
          </div>
        </nav>
      </div>
      <!-- XXXXXXXXXXXXXXXX -->
      <script language="JavaScript">
        if (screen.width<1024) {
          //Dispositivos pequeños
          document.getElementById("menuPrincipal").style.display="none";
          document.getElementById("navMenu").style.display="block";
        }else if (screen.width<1280) {
          //Dispositivos Medianos

        }else{
          //Dispositivos Grandes
        }
      </script>

      <!--FIN MENU -->
