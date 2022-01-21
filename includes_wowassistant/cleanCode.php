<?php
/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX *\
  Creación: 15-6-2018         |        Última modificación:  19-6-2018
  Autor: Francisco José Montero Campos - fran.montero.campos@gmail.com
  --------------------------------------------------------------------
  Objetivo:
  Clase que se encarga de limpiar el texto introducido por el usuario
  para evitar inyecciones SQL y otros ataques del estilo.
\* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */


  //Creamos un par de funciones para limpiar el texto introducido por el usuario para evitar inyeccionesSQL y otros ataques por el estilo.
  //Biblio: https://blog.reaccionestudio.com/evitar-inyeccion-sql-limpiando-las-variables-con-php/
  function cleanInput($input) {
     $search = array(
      '@<script[^>]*?>.*?</script>@si',   // Elimina javascript
      '@<[\/\!]*?[^<>]*?>@si',            // Elimina las etiquetas HTML
      '@<style[^>]*?>.*?</style>@siU',    // Elimina las etiquetas de estilo
      '@<![\s\S]*?--[ \t\n\r]*>@'         // Elimina los comentarios multi-línea
    );
      $output = preg_replace($search, '', $input);
      $output = str_replace(';', '.', $output); //Cambiamos los ";" por "."
      return $output;
    }

  function limpiar($input) {
      if (is_array($input)) {
          foreach($input as $var=>$val) {
              $output[$var] = limpiar($val);
          }
      }
      else {
          if (get_magic_quotes_gpc()) {
              $input = stripslashes($input);
          }

          $output = cleanInput($input);
      }
      return $output;
  }
 ?>
