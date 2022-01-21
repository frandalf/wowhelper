<?php
  header("Content-Type: text/html;charset=utf-8");
  session_start();
  include_once ("config.php");
  include_once ("../".INCLUDESROOT."/gestionVariables.php");
  include_once ("../".INCLUDESROOT."/seguridad.php");
  comprobarSesion();
  //Migas de pan:
  $pagina="reputaciones";
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
        <h1 class="cabeceraNoticias"><i>Reputaciones</i></h1>
      </div>
      <!-- NOTICIAS A PARTIR DE AQUÍ -->

      <!--Cuerpo noticia-->
      <div class="col-xs-12 separadorNoticia"></div>
      <div class="cuerpoNoticia">
        <div class="col-xs-3 skewed-imagen">
          <img src="img/thumb/noticias/thumb-news-fac-zandalari.jpg" class=""/>
        </div>
        <div class="col-xs-9 skewed-noticia">
          <p class="fuenteNoticias"><b>Facción <span class="horda">Horda</span>: Impero Zandalari <img src="img/icon-horde.png" class="icono_titulo" alt="Alianza"><b></p>
          <span>
            <div class="textoNoticia">
              Guía de WoWChakra sobre el antiguo Impero Zandalari.
            </div>
          </span>
        </div>
        <div class="col-xs-9 text-right skewed-leer">
              <span class="fechaNoticias">9 - Agosto - 2018</span>
              <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="https://www.wowchakra.com/" target="_blank">Wowchakra</a> </span>
              <span class="leerMas fuenteNoticias">
                <a href="https://www.wowchakra.com/battle-for-azeroth/guias-facciones/7457-imperio-zandalari-guia-facciones-recompensas-y-subir-reputacion" target="_blank">Acceder</a>
              </span>
        </div>
      </div><!-- Noticia -->
      <!-- Fin cuerpo noticia -->

      <!--Cuerpo noticia-->
      <div class="col-xs-12 separadorNoticia"></div>
      <div class="cuerpoNoticia">
        <div class="col-xs-3 skewed-imagen">
          <img src="img/thumb/noticias/thumb-news-fac-talanji.jpg" class=""/>
        </div>
        <div class="col-xs-9 skewed-noticia">
          <p class="fuenteNoticias"><b>Facción <span class="horda">Horda</span>: Expedición Talanji <img src="img/icon-horde.png" class="icono_titulo" alt="Alianza"><b></p>
          <span>
            <div class="textoNoticia">
              Guía de WoWChakra sobre la Expedición Talanji.
            </div>
          </span>
        </div>
        <div class="col-xs-9 text-right skewed-leer">
              <span class="fechaNoticias">9 - Agosto - 2018</span>
              <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="https://www.wowchakra.com/" target="_blank">Wowchakra</a> </span>
              <span class="leerMas fuenteNoticias">
                <a href="https://www.wowchakra.com/battle-for-azeroth/guias-facciones/7494-la-expedicion-de-talanji-guia-facciones-recompensas-y-subir-reputacion" target="_blank">Acceder</a>
              </span>
        </div>
      </div><!-- Noticia -->
      <!-- Fin cuerpo noticia -->

      <!--Cuerpo noticia-->
      <div class="col-xs-12 separadorNoticia"></div>
      <div class="cuerpoNoticia">
        <div class="col-xs-3 skewed-imagen">
          <img src="img/thumb/noticias/thumb-news-fac-voldunai.jpg" class=""/>
        </div>
        <div class="col-xs-9 skewed-noticia">
          <p class="fuenteNoticias"><b>Facción <span class="horda">Horda</span>: Voldunai <img src="img/icon-horde.png" class="icono_titulo" alt="Alianza"><b></p>
          <span>
            <div class="textoNoticia">
              Guía de WoWChakra sobre los Voldunai
            </div>
          </span>
        </div>
        <div class="col-xs-9 text-right skewed-leer">
              <span class="fechaNoticias">9 - Agosto - 2018</span>
              <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="https://www.wowchakra.com/" target="_blank">Wowchakra</a> </span>
              <span class="leerMas fuenteNoticias">
                <a href="https://www.wowchakra.com/battle-for-azeroth/guias-facciones/7504-voldunai-guia-facciones-recompensas-y-subir-reputacion" target="_blank">Acceder</a>
              </span>
        </div>
      </div><!-- Noticia -->
      <!-- Fin cuerpo noticia -->

      <!--Cuerpo noticia-->
      <div class="col-xs-12 separadorNoticia"></div>
      <div class="cuerpoNoticia">
        <div class="col-xs-3 skewed-imagen">
          <img src="img/thumb/noticias/thumb-news-fac-defensores.jpg" class=""/>
        </div>
        <div class="col-xs-9 skewed-noticia">
          <p class="fuenteNoticias"><b>Facción <span class="horda">Horda</span>: Defensores del Honor <img src="img/icon-horde.png" class="icono_titulo" alt="Alianza"><b></p>
          <span>
            <div class="textoNoticia">
              Guía de WoWChakra sobre la facción Almirantazgo de la Casa Valiente.
            </div>
          </span>
        </div>
        <div class="col-xs-9 text-right skewed-leer">
              <span class="fechaNoticias">9 - Agosto - 2018</span>
              <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="https://www.wowchakra.com/" target="_blank">Wowchakra</a> </span>
              <span class="leerMas fuenteNoticias">
                <a href="https://www.wowchakra.com/battle-for-azeroth/guias-facciones/7572-defensores-del-honor-guia-facciones-recompensas-y-subir-reputacion" target="_blank">Acceder</a>
              </span>
        </div>
      </div><!-- Noticia -->
      <!-- Fin cuerpo noticia -->

      <!--Cuerpo noticia-->
      <div class="col-xs-12 separadorNoticia"></div>
      <div class="cuerpoNoticia">
        <div class="col-xs-3 skewed-imagen">
          <img src="img/thumb/noticias/thumb-news-fac-almirantazgo.jpg" class=""/>
        </div>
        <div class="col-xs-9 skewed-noticia">
          <p class="fuenteNoticias"><b>Facción <span class="alianza">Alianza</span>: Almirantazgo de la Casa Valiente <img src="img/icon-alliance.png" class="icono_titulo" alt="Alianza"><b></p>
          <span>
            <div class="textoNoticia">
              Guía de WoWChakra sobre la facción Almirantazgo de la Casa Valiente.
            </div>
          </span>
        </div>
        <div class="col-xs-9 text-right skewed-leer">
              <span class="fechaNoticias">9 - Agosto - 2018</span>
              <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="https://www.wowchakra.com/" target="_blank">Wowchakra</a> </span>
              <span class="leerMas fuenteNoticias">
                <a href="https://www.wowchakra.com/battle-for-azeroth/guias-facciones/7482-orden-de-ascuas-guia-facciones-recompensas-y-subir-reputacion" target="_blank">Acceder</a>
              </span>
        </div>
      </div><!-- Noticia -->
      <!-- Fin cuerpo noticia -->

      <!--Cuerpo noticia-->
      <div class="col-xs-12 separadorNoticia"></div>
      <div class="cuerpoNoticia">
        <div class="col-xs-3 skewed-imagen">
          <img src="img/thumb/noticias/thumb-news-fac-7legion.jpg" class=""/>
        </div>
        <div class="col-xs-9 skewed-noticia">
          <p class="fuenteNoticias"><b>Facción <span class="alianza">Alianza</span>: Séptima Legión <img src="img/icon-alliance.png" class="icono_titulo" alt="Alianza"><b></p>
          <span>
            <div class="textoNoticia">
              Guía de Wowhead sobre la Séptima Legión.
            </div>
          </span>
        </div>
        <div class="col-xs-9 text-right skewed-leer">
              <span class="fechaNoticias">9 - Agosto - 2018</span>
              <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="http://es.wowhead.com/" target="_blank">Wowhead</a> </span>
              <span class="leerMas fuenteNoticias">
                <a href="http://es.wowhead.com/faction=2159/s%C3%A9ptima-legi%C3%B3n#items" target="_blank">Acceder</a>
              </span>
        </div>
      </div><!-- Noticia -->
      <!-- Fin cuerpo noticia -->

      <!--Cuerpo noticia-->
      <div class="col-xs-12 separadorNoticia"></div>
      <div class="cuerpoNoticia">
        <div class="col-xs-3 skewed-imagen">
          <img src="img/thumb/noticias/thumb-news-fac-ascuas.jpg" class=""/>
        </div>
        <div class="col-xs-9 skewed-noticia">
          <p class="fuenteNoticias"><b>Facción <span class="alianza">Alianza</span>: Orden de Ascuas <img src="img/icon-alliance.png" class="icono_titulo" alt="Alianza"><b></p>
          <span>
            <div class="textoNoticia">
              Guía de WoWChakra sobre la Orden de Ascuas.
            </div>
          </span>
        </div>
        <div class="col-xs-9 text-right skewed-leer">
              <span class="fechaNoticias">9 - Agosto - 2018</span>
              <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="https://www.wowchakra.com/" target="_blank">Wowchakra</a> </span>
              <span class="leerMas fuenteNoticias">
                <a href="https://www.wowchakra.com/battle-for-azeroth/guias-facciones/7482-orden-de-ascuas-guia-facciones-recompensas-y-subir-reputacion" target="_blank">Acceder</a>
              </span>
        </div>
      </div><!-- Noticia -->
      <!-- Fin cuerpo noticia -->

      <!--Cuerpo noticia-->
      <div class="col-xs-12 separadorNoticia"></div>
      <div class="cuerpoNoticia">
        <div class="col-xs-3 skewed-imagen">
          <img src="img/thumb/noticias/thumb-news-fac-despertar.jpg" class=""/>
        </div>
        <div class="col-xs-9 skewed-noticia">
          <p class="fuenteNoticias"><b>Facción <span class="alianza">Alianza</span>: Despertar de la Tormenta <img src="img/icon-alliance.png" class="icono_titulo" alt="Alianza"><b></p>
          <span>
            <div class="textoNoticia">
              Guía de WoWChakra sobre los Campeones de Azeroth
            </div>
          </span>
        </div>
        <div class="col-xs-9 text-right skewed-leer">
              <span class="fechaNoticias">9 - Agosto - 2018</span>
              <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="https://www.wowchakra.com/" target="_blank">Wowchakra</a> </span>
              <span class="leerMas fuenteNoticias">
                <a href="https://www.wowchakra.com/battle-for-azeroth/guias-facciones/7528-despertar-de-la-tormenta-guia-facciones-recompensas-y-subir-reputacion" target="_blank">Acceder</a>
              </span>
        </div>
      </div><!-- Noticia -->
      <!-- Fin cuerpo noticia -->

      <!--Cuerpo noticia-->
      <div class="col-xs-12 separadorNoticia"></div>
      <div class="cuerpoNoticia">
        <div class="col-xs-3 skewed-imagen">
          <img src="img/thumb/noticias/thumb-news-fac-campeones.jpg" class=""/>
        </div>
        <div class="col-xs-9 skewed-noticia">
          <p class="fuenteNoticias"><b>Facción neutral: Campeones de Azeroth <img src="img/icon-alliance.png" class="icono_titulo" alt="Alianza"> <img src="img/icon-horde.png" class="icono_titulo" alt="Horda"><b></p>
          <span>
            <div class="textoNoticia">
              Guía de WoWChakra sobre los Campeones de Azeroth
            </div>
          </span>
        </div>
        <div class="col-xs-9 text-right skewed-leer">
              <span class="fechaNoticias">9 - Agosto - 2018</span>
              <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="https://www.wowchakra.com/" target="_blank">Wowchakra</a> </span>
              <span class="leerMas fuenteNoticias">
                <a href="https://www.wowchakra.com/battle-for-azeroth/guias-facciones/7623-campeones-de-azeroth-guia-facciones-recompensas-y-subir-reputacion" target="_blank">Acceder</a>
              </span>
        </div>
      </div><!-- Noticia -->
      <!-- Fin cuerpo noticia -->

      <!--Cuerpo noticia-->
      <div class="col-xs-12 separadorNoticia"></div>
      <div class="cuerpoNoticia">
        <div class="col-xs-3 skewed-imagen">
          <img src="img/thumb/noticias/thumb-news-fac-tortolianos.jpg" class=""/>
        </div>
        <div class="col-xs-9 skewed-noticia">
          <p class="fuenteNoticias"><b>Facción neutral: Buscadores Tortolianos <img src="img/icon-alliance.png" class="icono_titulo" alt="Alianza"> <img src="img/icon-horde.png" class="icono_titulo" alt="Horda"><b></p>
          <span>
            <div class="textoNoticia">
              Guía de WoWChakra sobre los Buscadores Tortolianos.
            </div>
          </span>
        </div>
        <div class="col-xs-9 text-right skewed-leer">
              <span class="fechaNoticias">9 - Agosto - 2018</span>
              <span class="leerMas fuenteNoticias sourceNoticias">Fuente: <a href="https://www.wowchakra.com/" target="_blank">Wowchakra</a> </span>
              <span class="leerMas fuenteNoticias">
                <a href="https://www.wowchakra.com/battle-for-azeroth/guias-facciones/7796-buscadores-tortolianos-guia-facciones-recompensas-y-subir-reputacion" target="_blank">Acceder</a>
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
