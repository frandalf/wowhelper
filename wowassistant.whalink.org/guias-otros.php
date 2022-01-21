<?php
  header("Content-Type: text/html;charset=utf-8");
  session_start();
  include_once ("config.php");
  include_once ("../".INCLUDESROOT."/gestionVariables.php");
  include_once ("../".INCLUDESROOT."/seguridad.php");
  comprobarSesion();
  //Migas de pan:
  $pagina="otros";
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
        <h1 class="cabeceraNoticias"><i>Varios</i></h1>
      </div>
      <!--Cuerpo noticia-->
      <div class="col-xs-12 separadorNoticia"></div>
      <div class="cuerpoNoticia">
        <div class="col-xs-3 skewed-imagen">
          <img src="img/thumb/noticias/thumb-news-varios-dungeons.jpg" class=""/>
        </div>
        <div class="col-xs-9 skewed-noticia">
          <p class="fuenteNoticias"><b>Guías de mazmorras<b></p>
          <span>
            <div class="textoNoticia">
              Guía de Wowhead sobre estrategias a seguir para completar satisfactoriamente las mazmorras de Battle for Azeroth. Sólo en inglés.
            </div>
          </span>
        </div>
        <div class="col-xs-9 text-right skewed-leer">
              <span class="fechaNoticias">9 - Agosto - 2018</span>
              <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="http://es.wowhead.com/" target="_blank">Wowhead</a> </span>
              <span class="leerMas fuenteNoticias">
                <a href="https://es.wowhead.com/news=286313/strategy-guides-for-all-battle-for-azeroth-dungeons-by-fatbosstv-now-live" target="_blank">Acceder</a>
              </span>
        </div>
      </div><!-- Noticia -->
      <!-- Fin cuerpo noticia -->

      <!--Cuerpo noticia-->
      <div class="col-xs-12 separadorNoticia"></div>
      <div class="cuerpoNoticia">
        <div class="col-xs-3 skewed-imagen">
          <img src="img/thumb/noticias/thumb-news-dazaralor.jpg" class=""/>
        </div>
        <div class="col-xs-9 skewed-noticia">
          <p class="fuenteNoticias"><b>Guía de turismo en Dazar'alor <img src="img/icon-horde.png" class="icono_titulo" alt="Horda"><b></p>
          <span>
            <div class="textoNoticia">
              Guía de Wowhead con lugares de interés en Dazar'alor (zonas, emisarios, instructores de profesiones, etc.). Sólo en inglés.
            </div>
          </span>
        </div>
        <div class="col-xs-9 text-right skewed-leer">
              <span class="fechaNoticias">9 - Agosto - 2018</span>
              <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="http://es.wowhead.com/" target="_blank">Wowhead</a> </span>
              <span class="leerMas fuenteNoticias">
                <a href="http://www.wowhead.com/guides/dazaralor-horde-city-important-locations" target="_blank">Acceder</a>
              </span>
        </div>
      </div><!-- Noticia -->
      <!-- Fin cuerpo noticia -->

      <!--Cuerpo noticia-->
      <div class="col-xs-12 separadorNoticia"></div>
      <div class="cuerpoNoticia">
        <div class="col-xs-3 skewed-imagen">
          <img src="img/thumb/noticias/thumb-news-boralus.jpg" class=""/>
        </div>
        <div class="col-xs-9 skewed-noticia">
          <p class="fuenteNoticias"><b>Guía de turismo en Boralus <img src="img/icon-alliance.png" class="icono_titulo" alt="Alianza"><b></p>
          <span>
            <div class="textoNoticia">
              Guía de Wowhead con lugares de interés en Boralus (zonas, emisarios, instructores de profesiones, etc.). Sólo en inglés.
            </div>
          </span>
        </div>
        <div class="col-xs-9 text-right skewed-leer">
              <span class="fechaNoticias">9 - Agosto - 2018</span>
              <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="http://es.wowhead.com/" target="_blank">Wowhead</a> </span>
              <span class="leerMas fuenteNoticias">
                <a href="http://www.wowhead.com/guides/boralus-city-important-locations" target="_blank">Acceder</a>
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
