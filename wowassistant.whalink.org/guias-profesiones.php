<?php
  header("Content-Type: text/html;charset=utf-8");
  session_start();
  include_once ("config.php");
  include_once ("../".INCLUDESROOT."/gestionVariables.php");
  include_once ("../".INCLUDESROOT."/seguridad.php");
  comprobarSesion();
  //Migas de pan:
  $pagina="profesiones";
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
?>



  <div class="container cards centrado">
    <div class="row text-left">
      <div class="col-xs-12 col-novedades">
        <h1 class="cabeceraNoticias"><i>Profesiones</i></h1>
      </div>
      <!--Cuerpo noticia-->
      <div class="col-xs-12 separadorNoticia"></div>
      <div class="cuerpoNoticia">
        <div class="col-xs-3 skewed-imagen">
          <img src="img/thumb/noticias/thumb-news-prof-desuello15.jpg" class=""/>
        </div>
        <div class="col-xs-9 skewed-noticia">
          <p class="fuenteNoticias"><b>Subir desuello en 15 minutos<b></p>
          <span>
            <div class="textoNoticia">
              Guía de AlterTime para subir desuello de Battle for Azeroth. ¡En tan sólo 15 minutos!
            </div>
          </span>
        </div>
        <div class="col-xs-9 text-right skewed-leer">
              <span class="fechaNoticias">11 - Agosto - 2018</span>
              <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="https://altertime.es" target="_blank">AlterTime</a> </span>
              <span class="leerMas fuenteNoticias">
                <a href="https://altertime.es/sube-desuello-en-battle-for-azeroth-en-15-minutos" target="_blank">Acceder</a>
              </span>
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

<!-- xxxxxxxxxxxx FIN CONTENIDO xxxxxxxxxx -->

<!-- xxxxxxxxxxxxxxxx FOOTER xxxxxxxxxxxxx -->
<?php
  //Insertamos plantilla de pie
  include "../".INCLUDESROOT."/Templates/footer.php";
?>
