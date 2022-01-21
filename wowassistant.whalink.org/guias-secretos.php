<?php
  header("Content-Type: text/html;charset=utf-8");
  session_start();
  include_once ("config.php");
  include_once ("../".INCLUDESROOT."/gestionVariables.php");
  include_once ("../".INCLUDESROOT."/seguridad.php");
  comprobarSesion();
  //Migas de pan:
  $pagina="secretos";
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
        <h1 class="cabeceraNoticias"><i>Secretos</i></h1>
      </div>

      <!--Cuerpo noticia-->
      <div class="col-xs-12 separadorNoticia"></div>
      <div class="cuerpoNoticia">
        <div class="col-xs-3 skewed-imagen">
          <img src="img/thumb/noticias/thumb-news-col-nazjatar.jpg" class=""/>
        </div>
        <div class="col-xs-9 skewed-noticia">
          <p class="fuenteNoticias"><b>Montura secreta: Serpiente sangrienta de Nazjatar<b></p>
          <span>
            <div class="textoNoticia">
              Guía de WoWChakra que explica cómo conseguir esta montura secreta en Battle for Azeroth.
            </div>
          </span>
        </div>
        <div class="col-xs-9 text-right skewed-leer">
          <span class="fechaNoticias">9 - Agosto - 2018</span>
          <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="https://www.wowchakra.com" target="_blank">Wowchakra</a> </span>
          <span class="leerMas fuenteNoticias">
            <a href="https://www.wowchakra.com/battle-for-azeroth/guias-battle-for-azeroth/7597-guia-serpiente-sangrienta-de-nazjatar-secreto-battle-for-azeroth" target="_blank">Acceder</a>
          </span>
        </div>
      </div><!-- Noticia -->
      <!-- Fin cuerpo noticia -->

      <!--Cuerpo noticia-->
      <div class="col-xs-12 separadorNoticia"></div>
      <div class="cuerpoNoticia">
        <div class="col-xs-3 skewed-imagen">
          <img src="img/thumb/thumb-noticias-secretoslegion.jpg" class=""/>
        </div>
        <div class="col-xs-9 skewed-noticia">
          <p class="fuenteNoticias"><b>Todos los secretos de Legion<b></p>
          <span>
            <div class="textoNoticia">
              Guía de Wowhead (en inglés) donde encontrar todos los secretos que la comunidad ha descubierto en el juego en la expansión de Legion.
            </div>
          </span>
        </div>
        <div class="col-xs-9 text-right skewed-leer">
              <span class="fechaNoticias">9 - Agosto - 2018</span>
              <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="http://es.wowhead.com/" target="_blank">Wowhead</a> </span>
              <span class="leerMas fuenteNoticias">
                <a href="http://es.wowhead.com/secrets-of-wow-legion-guide" target="_blank">Acceder</a>
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
