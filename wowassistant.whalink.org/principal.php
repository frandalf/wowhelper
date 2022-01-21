<?php
  header("Content-Type: text/html;charset=utf-8");
  session_start();
  include_once ("config.php");
  include_once ("../".INCLUDESROOT."/gestionVariables.php");
  include_once ("../".INCLUDESROOT."/seguridad.php");
  comprobarSesion();

  //Migas de pan:
  $pagina="inicio";
?>

<!-- xxxxxxxxxxxxxxx CABECERA xxxxxxxxxxxxxx -->
<?php
  //Insertamos plantilla de cabecera
  include "../".INCLUDESROOT."/Templates/cabecera.php";
 ?>
<!-- xxxxxxxxxxxxx FIN CABECERA xxxxxxxxxx -->

<!-- xxxxxxxxxxxxxx CONTENIDO xxxxxxxxxxxx -->

<?php
  $nombre = $_COOKIE["user"];
  $email = $_SESSION["email"];
  //echo("Bienvenido ".$nombre.".<br>");
//  echo("Mail: ".$email);
  $previous_name = session_name();
//  echo "<br>Nombre de la sesión: $previous_name";
//  echo "<br>SKey: ".$_SESSION["SKey"];
//  echo "<br>IP:".getRealIP();
//  echo "<br>ID_User:".$_SESSION["id_user"];
 ?>



  <div class="container cards centrado">
    <div class="row">
      <div class="col-xs-12 col-sm-6 col-md-3">
        <a href="tareas.php" class="enlaceMenu">
          <div class="card centrado">
             <img src="img/thumb/thumb-tareas.jpg" alt="Tareas" class="imagenThumbnail" style="width:100%">
             <div>
               <h4 class="centrado"><b>Tareas</b></h4>
               <p class="textoCard">Crea tareas a realizar en el juego y asígna a tus personajes a las mismas.</p>
               <a href="tareas.php" class="caja btn-xs centrado bottom-align-text enlaceMenu" role="button">Acceder</a>
             </div>
          </div>
        </a>
      </div>

      <div class="col-xs-12 col-sm-6 col-md-3">
        <a href="personajes.php" class="enlaceMenu">
          <div class="card centrado">
             <img src="img/thumb/thumb-personajes.jpg" alt="Personajes" class="imagenThumbnail" style="width:100%">
             <div>
               <h4 class="centrado"><b>Personajes</b></h4>
               <p class="textoCard">Añade tus personajes directamente desde la Armería de World of Wacraft.</p>
               <a href="personajes.php" class="caja btn-xs centrado bottom-align-text enlaceMenu" role="button">Acceder</a>
             </div>
          </div>
        </a>
      </div>

      <div class="col-xs-12 col-sm-6 col-md-3">
        <a href="guias.php" class="enlaceMenu">
          <div class="card centrado">
             <img src="img/thumb/thumb-guias.jpg" alt="Guías" class="imagenThumbnail" style="width:100%">
             <div>
               <h4 class="centrado"><b>Guías</b></h4>
               <p class="textoCard">Accede a las guías de los mejores fansites españoles e ingleses.</p>
               <a href="guias.php" class="caja btn-xs centrado bottom-align-text enlaceMenu" role="button">Acceder</a>
             </div>
          </div>
        </a>
      </div>

      <div class="col-xs-12 col-sm-6 col-md-3">
        <a href="perfil.php" class="enlaceMenu">
          <div class="card centrado">
             <img src="img/thumb/thumb-perfil.jpg" alt="Perfil" class="imagenThumbnail" style="width:100%">
             <div>
               <h4 class="centrado"><b>Perfil</b></h4>
               <p class="textoCard">Modifica o elimina tu perfil.</p>
               <a href="perfil.php" class="caja btn-xs centrado bottom-align-text enlaceMenu" role="button">Acceder</a>
             </div>
          </div>
        </a>
      </div>
  </div><!--/row-->

  <div class="row text-left">
    <div class="col-xs-12 col-novedades">
      <h1 class="cabeceraNoticias"><i>Novedades</i></h1>
    </div>
    <!--Cuerpo noticia-->
    <div class="cuerpoNoticia">
      <div class="col-xs-3 skewed-imagen">
        <img src="img/thumb/thumb-noticias-wh.jpg" class=""/>
      </div>
      <div class="col-xs-9 skewed-noticia">
        <p class="fuenteNoticias"><b>¡Comienza la beta de WoWHelper!<b></p>
        <span><div class="textoNoticia">
        Bienvenido a <b>WoWHelper</b>. Aquí encontrarás diversas herramientas para facilitar tus viajes por Azeroth, así como acceso directo a contenido y guías de otros fansites con la idea de no tener que buscar una información que, a veces, no sabemos ni cómo buscar. Disfruta de tu estancia y no dudes en ponerte en contacto conmigo para sugerencias o para reportar errores desde este formulario.</div></span>
      </div>
      <div class="col-xs-9 text-right skewed-leer">
            <span class="fechaNoticias">6 - Agosto - 2018</span>
          <!-- <span class="leerMas fuenteNoticias sourceNoticias">Fuente: </span> -->
          <!--   <span class="leerMas fuenteNoticias">Acceder</span> -->
      </div>
    </div><!-- Noticia -->
    <!-- Fin cuerpo noticia -->

    <!--Plantilla
    <div class="col-xs-12 separadorNoticia"></div>
    <div class="cuerpoNoticia">
      <div class="col-xs-3 skewed-imagen">
        <img src="img/thumb/thumb-noticias-wh.jpg" class=""/>
      </div>
      <div class="col-xs-9 skewed-noticia">
        <p class="fuenteNoticias"><b>¡Comienza la beta de WoWHelper!<b></p>
        <span><div class="textoNoticia">
        Bienvenido a <b>WoWHelper</b>. Aquí encontrarás diversas herramientas para facilitar tus viajes por Azeroth, así como acceso directo a contenido y guías de otros fansites con la idea de no tener que buscar una información que, a veces, no sabemos ni cómo buscar. Disfruta de tu estancia y no dudes en ponerte en contacto conmigo para sugerencias o para reportar errores desde este formulario.</div></span>
      </div>
      <div class="col-xs-9 text-right skewed-leer">
            <span class="fechaNoticias">6 - Agosto - 2018</span>
            <span class="leerMas fuenteNoticias sourceNoticias">Fuente: </span>
            <span class="leerMas fuenteNoticias">Acceder</span>
      </div>
    </div> /Noticia -->
    <!-- Fin Plantilla -->



  </div><!-- /row -->
</div><!--/container -->

<!-- xxxxxxxxxxxxxxxx FOOTER xxxxxxxxxxxxx -->
<?php
//Insertamos plantilla de pie
include "../".INCLUDESROOT."/Templates/footer.php";
?>
