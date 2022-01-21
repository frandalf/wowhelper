<?php
  header("Content-Type: text/html;charset=utf-8");
  session_start();
  include_once ("config.php");
  include_once ("../".INCLUDESROOT."/gestionVariables.php");
  include_once ("../".INCLUDESROOT."/seguridad.php");
  comprobarSesion();
  //Migas de pan:
  $pagina="coleccionables";
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
    <!-- Primera linea de cards -->
    <div class="row">
      <div class="col-xs-12 col-sm-6 col-md-3">
        <a href="guias-coleccionables-monturas.php" class="enlaceMenu">
          <div class="card centrado">
             <img src="img/thumb/thumb-monturas.jpg" alt="monturas" class="imagenThumbnail" style="width:100%">
             <div>
               <h4 class="centrado"><b>Monturas</b></h4>
               <p class="textoCard">Descubre todas las monturas de Battle for Azeroth.</p>
               <a href="#" class="caja btn-xs centrado bottom-align-text enlaceMenu" role="button">Acceder</a>
             </div>
          </div>
        </a>
      </div>

      <div class="col-xs-12 col-sm-6 col-md-3">
        <a href="guias-coleccionables-mascotas.php" class="enlaceMenu">
          <div class="card centrado">
             <img src="img/thumb/thumb-mascotas.jpg" alt="mascotas" class="imagenThumbnail" style="width:100%">
             <div>
               <h4 class="centrado"><b>Mascotas</b></h4>
               <p class="textoCard">Doma a tus pequeños luchadores y derrota a tus adversarios.</p>
               <!--
               <a href="#" class="caja btn-xs centrado bottom-align-text enlaceMenu" role="button">Acceder</a> -->
               Próximamente
             </div>
          </div>
        </a>
      </div>

      <div class="col-xs-12 col-sm-6 col-md-3">
        <a href="guias-coleccionables-juguetes.php" class="enlaceMenu">
          <div class="card centrado">
             <img src="img/thumb/thumb-juguetes.jpg" alt="juguetes" class="imagenThumbnail" style="width:100%">
             <div>
               <h4 class="centrado"><b>Juguetes</b></h4>
               <p class="textoCard">Quién, dónde, cómo y, sobre todo, qué.</p>
               <!--
               <a href="#" class="caja btn-xs centrado bottom-align-text enlaceMenu" role="button">Acceder</a> -->
               Próximamente
             </div>
          </div>
        </a>
      </div>

      <div class="col-xs-12 col-sm-6 col-md-3">
        <a href="guias-coleccionables-transfiguraciones.php" class="enlaceMenu">
          <div class="card centrado">
             <img src="img/thumb/thumb-transfiguraciones.jpg" alt="transfiguraciones" class="imagenThumbnail" style="width:100%">
             <div>
               <h4 class="centrado"><b>Transfiguraciones</b></h4>
               <p class="textoCard">¿Tier de paladín con armas de guerrero siendo un DK? ¿Y por qué no?</p>
               <!--
               <a href="#" class="caja btn-xs centrado bottom-align-text enlaceMenu" role="button">Acceder</a> -->
               Próximamente
             </div>
          </div>
        </a>
      </div>
  </div><!--/row-->


<!-- NOTICIAS -->

  <div class="row text-left">
    <div class="col-xs-12 col-novedades">
      <h1 class="cabeceraNoticias"><i>Destacadas</i></h1>
    </div>
    <!-- NOTICIAS A PARTIR DE AQUÍ -->

    <!--Cuerpo noticia-->
    <div class="col-xs-12 separadorNoticia"></div>
    <div class="cuerpoNoticia">
      <div class="col-xs-3 skewed-imagen">
        <img src="img/thumb/noticias/thumb-news-col-scavenger.jpg" class=""/>
      </div>
      <div class="col-xs-9 skewed-noticia">
        <p class="fuenteNoticias"><b>Carroñero de las dunascapturado<b></p>
        <span>
          <div class="textoNoticia">
            Guía de WoWChakra que explica cómo conseguir esta montura en Battle for Azeroth. ¡Se puede vender en subasta!
          </div>
        </span>
      </div>
      <div class="col-xs-9 text-right skewed-leer">
        <span class="fechaNoticias">9 - Agosto - 2018</span>
        <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="https://www.wowchakra.com" target="_blank">Wowchakra</a> </span>
        <span class="leerMas fuenteNoticias">
          <a href="https://www.wowchakra.com/battle-for-azeroth/guias-battle-for-azeroth/7637-guia-carronero-de-las-dunas-monturas-battle-for-azeroth" target="_blank">Acceder</a>
        </span>
      </div>
    </div><!-- Noticia -->
    <!-- Fin cuerpo noticia -->

    <!--Cuerpo noticia-->
    <div class="col-xs-12 separadorNoticia"></div>
    <div class="cuerpoNoticia">
      <div class="col-xs-3 skewed-imagen">
        <img src="img/thumb/noticias/thumb-news-col-sanguinario.jpg" class=""/>
      </div>
      <div class="col-xs-9 skewed-noticia">
        <p class="fuenteNoticias"><b>Sanguinario domesticado<b></p>
        <span>
          <div class="textoNoticia">
            Guía de WoWChakra que explica cómo conseguir esta montura en Battle for Azeroth. ¡Se puede vender en subasta!
          </div>
        </span>
      </div>
      <div class="col-xs-9 text-right skewed-leer">
        <span class="fechaNoticias">9 - Agosto - 2018</span>
        <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="https://www.wowchakra.com" target="_blank">Wowchakra</a> </span>
        <span class="leerMas fuenteNoticias">
          <a href="https://www.wowchakra.com/battle-for-azeroth/guias-battle-for-azeroth/7641-guia-buscavenas-saltador-monturas-battle-for-azeroth" target="_blank">Acceder</a>
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
