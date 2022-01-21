<?php
/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX *\
  Creación: 15-6-2018         |       Última modificación:  28-10-2018
  Autor: Francisco José Montero Campos - fran.montero.campos@gmail.com
  --------------------------------------------------------------------
  Objetivo:
  Clase que se encarga del CRUD en relación al juego,  al igual que
  de otros métodos relacionados con el mismo
\* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

  include_once ("wa-config.php");
  include_once ("db_connect.php");
  include_once ("cleanCode.php");
  include_once ("gestionVariables.php");


  /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
                          // CREATE //
  /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

    /*
      Función para realizar el registro de personajes de nivel >10
    */
    function guardarPj($idUser,$nombre,$reino,$region,$nivel,$clase,$faccion,$primaria,$primValor,$secundaria,$secValor,$pescaValor,$cocinaValor,$arqueoValor,$imagen, $mysqli){
      $idUser=limpiar($idUser);
      $nombre=limpiar($nombre);
      $reino=limpiar($reino);
      $region=limpiar($region);
      $nivel=limpiar($nivel);
      $clase=limpiar($clase);
      $faccion=limpiar($faccion);
      $primaria=limpiar($primaria);
      $primValor=limpiar($primValor);
      $secundaria=limpiar($secundaria);
      $secValor=limpiar($secValor);
      $pescaValor=limpiar($pescaValor);
      $cocinaValor=limpiar($cocinaValor);
      $arqueoValor=limpiar($arqueoValor);
      $imagen=limpiar($imagen);
      if($region == "eu"){
        $region = "es-es";
      }

      // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
      if ($stmt = $mysqli->prepare(
          "INSERT INTO personajes (id_usuario,nombre,reino,region,nivel,clase,faccion,primaria,primaria_valor,secundaria,secundaria_valor,pesca_valor,cocina_valor,arqueología_valor,imagen)
          VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")) {
        $stmt->bind_param('isssiiisisiiiis', $idUser, $nombre, $reino, $region, $nivel, $clase, $faccion, $primaria, $primValor, $secundaria, $secValor, $pescaValor, $cocinaValor, $arqueoValor, $imagen);
        $stmt->execute();

        if($stmt){
            return true;
        }else{
            return false;
        };
        //$stmt -> close();
      }
    }//FIN guardarPj()



    /*
      Función para realizar el registro de personajes de nivel <10
    */
    function guardarPjBajo($idUser,$nombre,$reino,$faccion,$mysqli){
      $idUser=limpiar($idUser);
      $nombre=limpiar($nombre);
      $reino=limpiar($reino);
      $faccion=limpiar($faccion);
      $nivel=1;
      // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
      if ($stmt = $mysqli->prepare(
          "INSERT INTO personajes (id_usuario,nombre,reino,nivel,faccion)
          VALUES (?,?,?,?,?)")) {
        $stmt->bind_param('issii', $idUser, $nombre, $reino, $nivel, $faccion);
        $stmt->execute();

        if($stmt){
            return true;
        }else{
            return false;
        };
        //$stmt -> close();
      }
    }//FIN guardarPjBajo()


    /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
                            // READ //
    /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

    /*
    Función para recuperar el ID de un personaje
  */
    function recuperarID($nombre,$reino,$id_user,$mysqli){
      $nombre=limpiar($nombre);
      $reino=limpiar($reino);

      if ($stmt = $mysqli->prepare("SELECT id FROM personajes WHERE id_usuario = ? and nombre = ? and reino = ? LIMIT 1")) {
          $stmt->bind_param('iss', $id_user,$nombre,$reino);  // Une “$email” al parámetro.
          $stmt->execute();    // Ejecuta la consulta preparada.
          $stmt->store_result();

          // Obtiene las variables del resultado.
          $stmt->bind_result($id);
          $stmt->fetch();

          if ($stmt->num_rows == 1) {
              return $id;
          }
          //$stmt -> close();
      }
    }//Fin recuperarID()

    /*
      Función para realizar el registro de personajes de nivel >10
    */
    function recuperarPj($idUser,$nombre,$reino,$mysqli){
      // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
      if ($stmt = $mysqli->prepare(
          "SELECT id,region,nivel,clase,faccion,primaria,primaria_valor,secundaria,secundaria_valor,pesca_valor,cocina_valor,arqueología_valor,imagen,actualizado
          FROM personajes
          WHERE id_usuario = ? and nombre = ? and reino = ? LIMIT 1")) {
          $stmt->bind_param('iss', $idUser,$nombre,$reino);  // Une “$email” al parámetro.
          $stmt->execute();    // Ejecuta la consulta preparada.
          $stmt->store_result();

          $stmt->bind_result($idPj,$region,$nivel,$clase,$faccion,$primaria,$primValor,$secundaria,$secValor,$pescaValor,$cocinaValor,$arqueoValor,$imagen,$actualizado);
          $stmt->fetch();
          if ($stmt->num_rows > 0) {
              $datosPj =[
                "idPj"=>$idPj,
                "region"=>$region,
                "nivel"=>$nivel,
                "clase"=>$clase,
                "faccion"=>$faccion,
                "primaria"=>$primaria,
                "primaria_valor"=>$primValor,
                "secundaria"=>$secundaria,
                "secundaria_valor"=>$secValor,
                "pesca_valor"=>$pescaValor,
                "cocina_valor"=>$cocinaValor,
                "arqueología_valor"=>$arqueoValor,
                "imagen"=>$imagen,
                "actualizado"=>$actualizado
              ];
              return $datosPj;
          }else{
            return "error";
          }
          //$stmt -> close();
      }
    }//FIN recuperarPj()

    /*
      Función para realizar el registro de personajes de nivel >10
    */
    function getPersonaje($idUser,$id,$mysqli){
      if($id==0){ //Si es 0 se ha seleccionado "cualquiera"
        $datosPj =[
          "id"=>0,
          "nombre"=>"Cualquiera",
          "reino"=>"",
          "region"=>"",
          "nivel"=>"",
          "clase"=>"",
          "faccion"=>"",
          "primaria"=>"",
          "primaria_valor"=>"",
          "secundaria"=>"",
          "secundaria_valor"=>"",
          "pesca_valor"=>"",
          "cocina_valor"=>"",
          "arqueología_valor"=>"",
          "imagen"=>""
          ];
      }else{
        // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
        if ($stmt = $mysqli->prepare(
            "SELECT id,nombre,reino,region,nivel,clase,faccion,primaria,primaria_valor,secundaria,secundaria_valor,pesca_valor,cocina_valor,arqueología_valor,imagen
            FROM personajes
            WHERE id_usuario = ? and id = ?  LIMIT 1")) {
            $stmt->bind_param('ii', $idUser,$id);
            $stmt->execute();    // Ejecuta la consulta preparada.
            $stmt->store_result();

            $stmt->bind_result($id,$nombre,$reino,$region,$nivel,$clase,$faccion,$primaria,$primValor,$secundaria,$secValor,$pescaValor,$cocinaValor,$arqueoValor,$imagen);
            $stmt->fetch();
            if ($stmt->num_rows > 0) {
                $datosPj =[
                  "id"=>$id,
                  "nombre"=>$nombre,
                  "reino"=>$reino,
                  "region"=>$region,
                  "nivel"=>$nivel,
                  "clase"=>$clase,
                  "faccion"=>$faccion,
                  "primaria"=>$primaria,
                  "primaria_valor"=>$primValor,
                  "secundaria"=>$secundaria,
                  "secundaria_valor"=>$secValor,
                  "pesca_valor"=>$pescaValor,
                  "cocina_valor"=>$cocinaValor,
                  "arqueología_valor"=>$arqueoValor,
                  "imagen"=>$imagen
                ];
                return $datosPj;
            }else{
              return "error";
            }
        }
      }


    }//FIN recuperarPj()

    /*
      Recuperar todos los personajes
    */
    function getListaPersonajes($idUser,$mysqli){
      // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
      if ($stmt = $mysqli->prepare(
          "SELECT id,nombre,reino,region,nivel,clase,faccion,imagen
          FROM personajes
          WHERE id_usuario = ?")) {
          $stmt->bind_param('i', $idUser);
          $stmt->execute();    // Ejecuta la consulta preparada.

          $meta = $stmt->result_metadata();
          $parameters = array();
          $arr_results = array();
          while ( $rows = $meta->fetch_field() ) {
             $parameters[] = &$row[$rows->name];
          }
          call_user_func_array(array($stmt, 'bind_result'), $parameters);

           while ( $stmt->fetch() ) {
              $x = array();
              foreach( $row as $key => $val ) {
                 $x[$key] = $val;
              }
              $arr_results[] = $x;
           }


           return $arr_results;
           $stmt -> close();
        }
    }//Fin getListaPersonajes()


    /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
                            // UPDATE //
    /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */



    /*Función que comprueba si hoy ya se ha actualizado el personaje*/
    function actualizarDatosBasicosPersonaje($idUser,$idPj,$nivelPj,$fecha,$mysqli){
      if($nivelPj>0){//Si no funciona la API da 0, actualizando con datos erróneos
        if ($stmt = $mysqli->prepare(
            "UPDATE personajes
            SET nivel = ?, actualizado = ?
            WHERE id_usuario = ? and id = ?")) {
            $stmt->bind_param('isii',$nivelPj,$fecha,$idUser,$idPj);
            $stmt->execute();    // Ejecuta la consulta preparada.

            if($stmt){
                return true;
            }else{
                return false;
            };

            $stmt -> close();
        }
      }
    }


    /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
                            // DELETE //
    /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */


    /*
      Función para borrar personajes
    */
    function eliminarPersonaje($idUser,$idPj,$mysqli){
      if ($stmt = $mysqli->prepare(
          "DELETE
          FROM personajes
          WHERE id_usuario = ? and id = ?")) {
          $stmt->bind_param('ii',$idUser,$idPj);
          $stmt->execute();    // Ejecuta la consulta preparada.

          if($stmt){
              return true;
          }else{
              return false;
          };
          $stmt -> close();
      }
    }//Fin eliminarPersonaje

    /*
      Función para borrar todos los personajes
    */
    function eliminarTodosPersonajes($idUser,$mysqli){
      if ($stmt = $mysqli->prepare(
          "DELETE
          FROM personajes
          WHERE id_usuario = ?")) {
          $stmt->bind_param('i',$idUser);
          $stmt->execute();    // Ejecuta la consulta preparada.

          if($stmt){
              return true;
          }else{
              return false;
          };
          $stmt -> close();
      }
    }//Fin eliminarPersonaje

    /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
                            // OTROS //
    /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */



  /*Función que comprueba si hoy ya se ha actualizado el personaje*/
  function comprobarPersonaje($actualizado,$idUser,$idPj,$nivelPj,$mysqli){
    $fecha= fechaActual()["fecha"];
    //Si la fecha actual y la actualizada no coinciden, actualizamos
    if($fecha != $actualizado){
      actualizarDatosBasicosPersonaje($idUser,$idPj,$nivelPj,$fecha,$mysqli);
    }
  }



  /*
    Devuelve el nombre correcto del reino (con apóstrofes, si los llevan)
  */
  function getNombreReino($reino){
    switch (strtolower($reino)) {
      case 'zuljin':
        return "Zul'jin";
        break;
      case 'shendralar':
        return "Shen'dralar";
        break;
      case 'cthun':
        return "C'thun";
        break;
      case 'dun-modr':
        return "Dun Modr";
        break;
      default:
        return ucwords($reino);
        break;
    }
  }//Fin getNombreReino()

  /*
    Devuelve el nombre de la clase asociada a su ID
  */
  function getnombreClase($claseID){
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

    switch ($claseID) {
      case 1:
        return array( "Guerrero","Armas", "Furia", "Protección");
        break;
      case 2:
        return array( "Paladín","Sagrado", "Protección", "Retribución");
        break;
      case 3:
        return array( "Cazador","Maestro de bestias", "Puntería", "Supervivencia");
        break;
      case 4:
        return array( "Pícaro","Asesinato", "Forajido", "Sutileza");
        break;
      case 5:
        return array( "Sacerdote","Disciplina", "Sagrado", "Sombras");
        break;
      case 6:
        return array( "C. de la Muerte","Sangre", "Hielo", "Profano");
        break;
      case 7:
        return array( "Chamán","Elemental", "Mejora", "Restauración");
        break;
      case 8:
        return array( "Mago","Arcano", "Fuego", "Hielo");
        break;
      case 9:
        return array( "Brujo","Aflicción", "Demonología", "Destrucción");
        break;
      case 10:
        return array( "Monje","Maestro cervecero", "Tejedor de niebla", "Viajero del viento");
        break;
      case 11:
        return array( "Druída","Equilibrio", "Feral", "Guardian", "Restauración");
        break;
      case 12:
        return array( "C. de Demonios","Devastación", "Venganza");
        break;
    }
  }//Fin getNombreClase()

  /*
    Devuelve el nombre de la clase CSS que contiene el color de la clase del personaje
  */
  function getColorClase($clase){
    //Coloreamos el nombre dependiendo de la clase
    switch ($clase) {
      case 1:
        return "guerrero";
        break;
      case 2:
        return "paladin";
        break;
      case 3:
        return "cazador";
        break;
      case 4:
        return "picaro";
        break;
      case 5:
        return "sacerdote";
        break;
      case 6:
        return "caballeromuerte";
        break;
      case 7:
        return "chaman";
        break;
      case 8:
        return "mago";
        break;
      case 9:
        return "brujo";
        break;
      case 10:
        return "monje";
        break;
      case 11:
        return "druida";
        break;
      case 12:
        return "dh";
        break;
    }
  }//fin getColorClase()

  /*
    Devuelve el nombre de la clase CSS que contiene el color de la clase del personaje
  */
  function getNombreFaccion($faccion){
    //Coloreamos el nombre dependiendo de la clase
    switch ($faccion) {
      case 0:
        return "Alianza";
        break;
      case 1:
        return "Horda";
        break;
    }
  }//fin getNombreFaccion()


  /*
    Devuelve la región dependiendo de la zona
  */
  function getNombreRegion($region){
    switch ($region) {
      //Europeos
      case 'es-es':
        return "eu";
        break;
      case 'de-de':
        return "eu";
        break;
      case 'en-gb':
        return "eu";
        break;
      case 'fr-fr':
        return "eu";
        break;
      case 'it-it':
        return "eu";
        break;
      case 'pt-pt':
        return "eu";
        break;
      case 'ru-ru':
        return "eu";
        break;
      //Americanos
      case 'en-us':
        return "us";
        break;
      case 'en-sg':
        return "us";
        break;
      case 'es-mx':
        return "us";
        break;
      case 'pt-br':
        return "us";
        break;
      //Corea
      case 'ko-kr':
        return "kr";
        break;
      //Taiwan
      case 'zh-tw':
        return "tw";
        break;
      //China
    case 'cn-cn':
      return "cn";
      break;

      default:
        return "eu";
        break;
    }
  }//Fin getNombreRegion()

  /*
    Función que devuelve los links de cada talento de clase de Ici-veins
  */
  function getLinkTalentosClase($clase){
    switch ($clase) {
      case 1:
        return array("https://www.icy-veins.com/wow/arms-warrior-pve-dps-guide", "https://www.icy-veins.com/wow/fury-warrior-pve-dps-guide", "https://www.icy-veins.com/wow/protection-warrior-pve-tank-guide","","","");
        break;
      case 2:
        return array("Sagrado", "Protección", "Retribución","","","");
        break;
      case 3:
        return array("Maestro de bestias", "Puntería", "Supervivencia","","","");
        break;
      case 4:
        return array("Asesinato", "Forajido", "Sutileza","","","");
        break;
      case 5:
        return array("Disciplina", "Sagrado", "Sombras","","","");
        break;
      case 6:
        return array("Sangre", "Hielo", "Profano","","","");
        break;
      case 7:
        return array("Elemental", "Mejora", "Restauración","","","");
        break;
      case 8:
        return array("Arcano", "Fuego", "Hielo","","","");
        break;
      case 9:
        return array("Aflicción", "Demonología", "Destrucción","","","");
        break;
      case 10:
        return array("https://www.icy-veins.com/wow/brewmaster-monk-pve-tank-guide", "https://www.icy-veins.com/wow/mistweaver-monk-pve-healing-guide", "https://www.icy-veins.com/wow/windwalker-monk-pve-dps-guide","","https://www.icy-veins.com/wow/mistweaver-monk-pvp-guide","https://www.icy-veins.com/wow/windwalker-monk-pvp-guide");
        break;
      case 11:
        return array("Equilibrio", "Feral", "Guardian", "Restauración","","","","");
        break;
      case 12:
        return array("Devastación", "Venganza","","","");
        break;
    }
  } //Fin getLinkTalentosClase()

  /*
    Función para devolver el icono de profesion
  */
  function getIconProfesion ($profesion){
    switch ($profesion) {
      case 'Alquimia':
        return "img/tareas/icon-prof-alquimia.png";
        break;
      case 'Desuello':
        return "img/tareas/icon-prof-desuello.png";
        break;
      case 'Encantamiento':
        return "img/tareas/icon-prof-encantamiento.png";
        break;
      case 'Herboristería':
        return "img/tareas/icon-prof-herboristeria.png";
        break;
      case 'Herrería':
        return "img/tareas/icon-prof-herreria.png";
        break;
      case 'Ingeniería':
        return "img/tareas/icon-prof-ingenieria.png";
        break;
      case 'Inscripción':
        return "img/tareas/icon-prof-inscripcion.png";
        break;
      case 'Joyería':
        return "img/tareas/icon-prof-joyeria.png";
        break;
      case 'Minería':
        return "img/tareas/icon-prof-mineria.png";
        break;
      case 'Peletería':
        return "img/tareas/icon-prof-peleteria.png";
        break;
      case 'Sastrería':
        return "img/tareas/icon-prof-sastreria.png";
        break;
      default:
        return false;
        break;
    }
  }//Fin getIconProfesion

  /*
    Función que devuelve 0 si no hay nada subido en una profesión
  */
  function getNumeroProfesion ($profesion){
    if($profesion==""){
      return 0;
    }else{
      return $profesion;
    }
  }

  /*
    Función que devuelve un array con las ID separadas de las profesiones concatenadas con |
  */
  function getArrayBarras($string){
    //Comprobamos el número de |. Este valor es el nº de personajes guardados, ya que el formato es id|id|id|...
    $nBarras = mb_substr_count($string, "|");
    //Creamos array que almacenará los personajes
    $resultado =array();
    for($i=0;$i<$nBarras;$i++){
      $posFinal=strpos($string, "|");
      //Añadimos a $personajes la subcadena del primer id de la linea.
      array_push($resultado, substr($string,0,$posFinal));
      //Elminamos de la cadena la id inicial + su |, dejándolo listo para el siguiente ciclo del for
      $string=substr($string,$posFinal+1,strlen($string));
    }

    return $resultado;
  }

  /*
    Función que devuelve el porcentaje de reputación llevado a cabo
  */

  function getPorcentajeRepu($reputacion){
    //Como al llegar a exaltado el valor es 0 y no es divisible, el porcentaje da error
    $porcentaje = 0;
    if($reputacion[2]=="Exaltado"){
      $porcentaje=100;
    }else if($reputacion[1]>0){
      $porcentaje=($reputacion[1]*100)/$reputacion[3];
    }
      return $porcentaje;
  }


  /*
    Función que devuelve los materiales por profesión para los Frentes de Guerra
  */
  function getProfesionFrentes($profesion){
    $materiales = array();
    switch ($profesion) {
      case 'Alquimia':
        $materiales = [
          "item1" => "Poción de piel de acero",
          "item1id" => "152557",
          "item1num" => "2",
          "item2" => "Poción de maná costera",
          "item2id" => "152495",
          "item2num" => "20"
        ];
        return $materiales;
        break;
      case 'Herrería':
        $materiales = [
          "item1" => "Placas para pezuñas endurecidas con monelita",
          "item1id" => "152812",
          "item1num" => "2",
          "item2" => "Estribos endurecidos con monelita",
          "item2id" => "152813",
          "item2num" => "2"
        ];
        return $materiales;
        break;
      case 'Encantamiento':
        $materiales = [
          "item1" => "Encantar anillo: Sello de golpe crítico",
          "item1id" => "153438",
          "item1num" => "3",
          "item2" => "Encantar anillo: Sello de versatilidad",
          "item2id" => "153441",
          "item2num" => "3"
        ];
        return $materiales;
        break;
      case 'Ingeniería':
        $materiales = [
          "item1" => "Mira de la cofa",
          "item1id" => "158212",
          "item1num" => "6",
          "item2" => "Munición cubierta de escarcha",
          "item2id" => "158377",
          "item2num" => "3"
        ];
        return $materiales;
        break;
      case 'Herboristería':
        $materiales = [
          "item1" => "Distinto cada vez",
          "item1id" => "",
          "item1num" => ""
        ];
        return $materiales;
        break;
      case 'Inscripción':
        $materiales = [
          "item1" => "Pergamino de guerra de Grito de batalla",
          "item1id" => "158202",
          "item1num" => "3",
          "item2" => "Pergamino de guerra de entereza",
          "item2id" => "158204",
          "item2num" => "3"
        ];
        return $materiales;
        break;
      case 'Joyería':
        $materiales = [
          "item1" => "Piedrasol letal",
          "item1id" => "153710",
          "item1num" => "15",
          "item2" => "Kyanita versátil",
          "item2id" => "153712",
          "item2num" => "15"
        ];
        return $materiales;
        break;
      case 'Peletería':
        $materiales = [
          "item1" => "Tambores de La Vorágine",
          "item1id" => "154167",
          "item1num" => "2",
          "item2" => "Barda de cuero burdo",
          "item2id" => "154166",
          "item2num" => "2"
        ];
        return $materiales;
        break;
      case 'Minería':
        $materiales = [
          "item1" => "Mena de monelita",
          "item1id" => "152512",
          "item1num" => "60"
        ];
        return $materiales;
        break;
      case 'Desuello':
        $materiales = [
          "item1" => "Cuero burdo",
          "item1id" => "152541",
          "item1num" => "60"
        ];
        return $materiales;
        break;
      case 'Sastrería':
        $materiales = [
          "item1" => "Bandera de batalla: Formación veloz",
          "item1id" => "154705",
          "item1num" => "1"
        ];
        return $materiales;
        break;
      default://Cocina
        $materiales = [
          "item1" => "Anca carnosa",
          "item1id" => "154898",
          "item1num" => "60"
        ];
        return $materiales;
        break;
    }
}




 ?>
