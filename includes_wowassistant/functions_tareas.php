<?php
/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX *\
  Creación: 15-6-2018         |       Última modificación:  05-11-2018
  Autor: Francisco José Montero Campos - fran.montero.campos@gmail.com
  --------------------------------------------------------------------
  Objetivo:
  Clase que se encarga del CRUD en relación a las tareas, al igual que
  de otros métodos relacionados con las mismas.
\* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

  include_once ("wa-config.php");
  include_once ("db_connect.php");
  include_once ("cleanCode.php");
  include_once ("gestionVariables.php");

  /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
                          // CREATE //
  /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

  /*
    Función para guardar tareas
  */
  function guardarTarea($idUser,$nombre,$tipo,$subtipo,$repetible,$prioridad,$link,$notas,$personajes,$fecha,$mysqli,$guardarRepetible){
    $idUser=limpiar($idUser);
    $nombre=limpiar($nombre);
    $tipo=limpiar($tipo);
    $subtipo=limpiar($subtipo);
    $repetible=limpiar($repetible);
    $prioridad=limpiar($prioridad);
    $personajes=limpiar($personajes);

    // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
    if ($stmt = $mysqli->prepare(
        "INSERT INTO tareas (id_usuario,nombre,tipo,subtipo,prioridad,repetir,link,notas,fecha)
        VALUES (?,?,?,?,?,?,?,?,?)")) {
        $stmt->bind_param('issssssss', $idUser, $nombre, $tipo, $subtipo, $prioridad,$repetible, $link, $notas,$fecha);
        $stmt->execute();

        //Rellenamos la tabla que empareja personajes y tareas
        $stmt2 = setPersonajesTarea($idUser, $personajes, $mysqli);

        //Comprobamos si también tenemos que rellenar las repetibles.
        $stmt3 = true;
        if($repetible!=0 && $guardarRepetible){
          $stmt3 = setPersonajesTareaRep($idUser, $personajes, $mysqli);
        }

        if($stmt && $stmt2 && $stmt3){
            return true;
        }else{
            return false;
        }
        $stmt -> close();
    }
  }//Fin guardarTarea()

    /*
    Función para guardar a los personajes asociados a la tarea seleccionada
  */
  function setPersonajesTarea($idUser, $personajes, $mysqli){
      //Extraemos los ID de los personajes seleccionados por separado
      $personajesId = getArrayPersonajes($personajes);
      foreach ($personajesId as $id) {
        if ($stmt = $mysqli->prepare(
            "INSERT INTO tareasPersonajes (id_usuario,id_pj,id_tarea)
            VALUES (?,?,(SELECT max(id) FROM tareas WHERE id_usuario=?))")) {
            $stmt->bind_param('iii', $idUser, $id, $idUser);
            $stmt->execute();
        }
      }

      if($stmt){
          return true;
      }else{
          return false;
      }

      $stmt -> close();
  }//Fin setPersonajesTarea()

  /*
    Función para guardar a los personajes asociados a la tarea repetible seleccionada
  */
  function setPersonajesTareaRep($idUser, $personajes, $mysqli){
      //Extraemos los ID de los personajes seleccionados por separado
      $personajesId = getArrayPersonajes($personajes);
      foreach ($personajesId as $id) {
        if ($stmt = $mysqli->prepare(
            "INSERT INTO tareasRepPersonajes (id_usuario,id_pj,id_tarea)
            VALUES (?,?,(SELECT max(id) FROM tareas WHERE id_usuario=?))")) {
            $stmt->bind_param('iii', $idUser, $id, $idUser);
            $stmt->execute();
        }
      }

      if($stmt){
          return true;
      }else{
          return false;
      }

      $stmt -> close();
  }//Fin setPersonajesTareaRep()


  /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
                          // READ //
  /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

  /*
      Función para recuperar todas las tareas
    */
    function getTareas($idUser,$mysqli){
      if ($stmt = $mysqli->prepare(
          "SELECT id,nombre,tipo,subtipo,prioridad,repetir,link,notas,fecha
          FROM tareas
          WHERE id_usuario = ? AND mostrado = 0
          ORDER BY id DESC")) {
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
    }//Fin getTareas

    /*
      Función que devuelve una tarea
    */
    function recuperarTarea($idUser,$idTarea,$mysqli){
      if ($stmt = $mysqli->prepare(
          "SELECT nombre,tipo,subtipo,prioridad,repetir,link,notas,fecha
          FROM tareas
          WHERE id_usuario = ? and id = ? LIMIT 1")) {
          $stmt->bind_param('ii',$idUser,$idTarea);
          $stmt->execute();    // Ejecuta la consulta preparada.
          $stmt->store_result();

          $stmt->bind_result($nombre,$tipo,$subtipo,$prioridad,$repetir,$link,$notas,$fecha);
          $stmt->fetch();
          if ($stmt->num_rows > 0) {
              $datosTarea =[
                "nombre"=>$nombre,
                "tipo"=>$tipo,
                "subtipo"=>$subtipo,
                "prioridad"=>$prioridad,
                "repetir"=>$repetir,
                "link"=>$link,
                "notas"=>$notas,
                "fecha"=>$fecha
              ];
              return $datosTarea;
          }else{
            return "error";
          }
          $stmt -> close();
      }
    }//FIN recuperarTarea()


    /*
      Función para extraer los personajes de una tarea
    */
    function getPersonajesTarea($idUser,$idTarea,$mysqli){
      if ($stmt = $mysqli->prepare(
          "SELECT id_pj
          FROM tareasPersonajes
          WHERE id_usuario = ? and id_tarea = ?")) {
            $stmt->bind_param('ii', $idUser, $idTarea);
            $stmt->execute();    // Ejecuta la consulta preparada.

            $idsPersonajes = array();
            $stmt->bind_result($id);
            /* obtener los valores */
            while ($stmt->fetch()) {
                $idsPersonajes[]=$id;
            }

             return $idsPersonajes;
             $stmt -> close();
      }else{
        return "error";
      }
    }//Fin getPersonajesTarea()

    /*
      Función para extraer los personajes de una tarea
    */
    function getPersonajesRepTarea($idUser,$idTarea,$mysqli){
      if ($stmt = $mysqli->prepare(
          "SELECT id_pj
          FROM tareasRepPersonajes
          WHERE id_usuario = ? and id_tarea = ?")) {
            $stmt->bind_param('ii', $idUser, $idTarea);
            $stmt->execute();    // Ejecuta la consulta preparada.

            $idsPersonajes = array();
            $stmt->bind_result($id);
            /* obtener los valores */
            while ($stmt->fetch()) {
                $idsPersonajes[]=$id;
            }

             return $idsPersonajes;
             $stmt -> close();
      }else{
        return "error";
      }
    }//Fin getPersonajesRepTarea()

    /*
      Función para recuperar los ids de todas las tareas repetibles
    */
    function getTareasRepetibles($mostrado,$mysqli,$tipo){
      //Extraemos todas las tareas repetibles que ya se hayan mostrado (mostrado=1) del tipo indicado (1=diario, 2=semanal) para reiniciarlas
      if ($stmt = $mysqli->prepare(
          "SELECT id,id_usuario
          FROM tareas
          WHERE mostrado = ? and repetir = ?")) {
            $stmt->bind_param('ii', $mostrado,$tipo);
            $stmt->execute();    // Ejecuta la consulta preparada.

            $idsTareas = array();

            $stmt->bind_result($id,$idUsuario);
            /* obtener los valores */
            while ($stmt->fetch()) {
                $datos = ["id" => $id,"idUsuario" => $idUsuario];
                array_push($idsTareas,$datos);
            }
             return $idsTareas;
             $stmt -> close();
      }else{
        return "error";
      }
    }//Fin getTareasRepetibles()

    /*
      Función que devuelve si una tarea es repetible y de qué tipo
    */
    function getRepetible($idUser,$idTarea,$mysqli){
      if ($stmt = $mysqli->prepare(
          "SELECT repetir
          FROM tareas
          WHERE id_usuario = ? and id_tarea = ?")) {
            $stmt->bind_param('ii',$idUser,$idTarea);
            $stmt->execute();    // Ejecuta la consulta preparada.

            $repetir;
            $stmt->bind_result($valor);
            /* obtener los valores */
            while ($stmt->fetch()) {
                $repetir=$valor;
            }

             return $repetir;
             $stmt -> close();
      }else{
        return 0;
      }
    }//getRepetible

  /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
                          // UPDATE //
  /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

  /*
    Función para actualizar tareas
  */
  function actualizarTarea($idUser,$idTarea,$personajes,$mysqli){
    $personajesId = getArrayPersonajes($personajes);
    if ($stmt = $mysqli->prepare(
        "DELETE FROM tareasPersonajes
        WHERE id_usuario = ? and id_tarea = ? and id_pj NOT IN ('" . implode( "', '" , $personajesId ) . "')")) {
        $stmt->bind_param('ii',$idUser,$idTarea);
        $stmt->execute();    // Ejecuta la consulta preparada.
        if($stmt){
            return true;
        }else{
            return false;
        };

        $stmt -> close();
    }


  }//Fin ActualizarTarea()

  /*
    Función que marca la tarea repetida como mostrada pero no la borra
  */
  function actualizarTareaRepetible($idUser,$idTarea,$mysqli,$valorMostrado){
    if ($stmt = $mysqli->prepare(
        "UPDATE tareas
        SET mostrado = ?
        WHERE id_usuario = ? and id = ?")) {
        $stmt->bind_param('iii',$valorMostrado,$idUser,$idTarea);
        $stmt->execute();    // Ejecuta la consulta preparada.

        $stmt2;
        if ($stmt2 = $mysqli->prepare(
            "DELETE
            FROM tareasPersonajes
            WHERE id_usuario = ? and id_tarea = ?")) {
            $stmt2->bind_param('ii',$idUser,$idTarea);
            $stmt2->execute();
          }

        if($stmt && $stmt2){
            return true;
        }else{
            return false;
        };

        $stmt -> close();
        $stmt2 -> close();
    }
  }//actualizarTareaRepetible

  /*
    Función que marca todas las tareas repetidas como no mostradas
  */
  function actualizarTodasTareasRepetibles($idUser,$idTarea,$mysqli){
    if ($stmt = $mysqli->prepare(
        "UPDATE tareas
        SET mostrado = 0
        WHERE id_usuario = ? and id = ?")) {
        $stmt->bind_param('ii',$idUser,$idTarea);
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        };

        $stmt -> close();

    }
  }//actualizarTareaRepetible



  /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
                          // DELETE //
  /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

  /*
    Función para eliminar tareas
  */
  function eliminarTarea($idUser,$idTarea,$mysqli){
    //Comprobamos si es una tarea repetible.
    $repetir = getRepetible($idUser,$idTarea,$mysqli);

    if($repetir==0){
      //Si es 0, no es repetible, por lo tanto borramos
      if ($stmt = $mysqli->prepare(
          "DELETE
          FROM tareas
          WHERE id_usuario = ? and id = ?")) {
          $stmt->bind_param('ii',$idUser,$idTarea);
          $stmt->execute();

          $stmt2;
          if ($stmt2 = $mysqli->prepare(
              "DELETE
              FROM tareasPersonajes
              WHERE id_usuario = ? and id_tarea = ?")) {
              $stmt2->bind_param('ii',$idUser,$idTarea);
              $stmt2->execute();
            }

          if($stmt && $stmt2){
              return true;
          }else{
              return false;
          };
          $stmt -> close();
      }
    }else{
      //Si no es 0, es repetible, por lo que no borramos la tarea, sólo la "desactivamos" poniendo su "mostrado" en 1.
      if ($stmt = $mysqli->prepare(
          "UPDATE tareas
          SET mostrado = 1
          WHERE id_usuario = ? and id = ?")) {
          $stmt->bind_param('ii',$idUser,$idTarea);
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

  /*
    Función para eliminar tareas repetidas
  */
  function eliminarTareaRepetida($idUser,$idTarea,$mysqli){
    if ($stmt = $mysqli->prepare(
        "DELETE
        FROM tareasPersonajes
        WHERE id_usuario = ? and id_tarea = ?")) {
        $stmt->bind_param('ii',$idUser,$idTarea);
        $stmt->execute();    // Ejecuta la consulta preparada.
    }

    if ($stmt2 = $mysqli->prepare(
        "DELETE
        FROM tareasRepPersonajes
        WHERE id_usuario = ? and id_tarea = ?")) {
        $stmt2->bind_param('ii',$idUser,$idTarea);
        $stmt2->execute();    // Ejecuta la consulta preparada.
    }

    if ($stmt3 = $mysqli->prepare(
        "DELETE
        FROM tareas
        WHERE id_usuario = ? and id = ?")) {
        $stmt3->bind_param('ii',$idUser,$idTarea);
        $stmt3->execute();    // Ejecuta la consulta preparada.
    }

        if($stmt && $stmt2 && $stmt3){
            return true;
        }else{
            return false;
        };
        $stmt -> close();
        $stmt2 -> close();

  }//Fin eliminarTareaRepetida()

  /*
    Función que elimina todas las tareas de un usuario
  */
  function eliminarTodasTareas($idUser,$mysqli){
    if ($stmt = $mysqli->prepare(
        "DELETE
        FROM tareas
        WHERE id_usuario = ?")) {
        $stmt->bind_param('i',$idUser);
        $stmt->execute();    // Ejecuta la consulta preparada.
    }

    if ($stmt2 = $mysqli->prepare(
        "DELETE
        FROM tareasPersonajes
        WHERE id_usuario = ?")) {
        $stmt2->bind_param('i',$idUser);
        $stmt2->execute();    // Ejecuta la consulta preparada.
    }

    if ($stmt3 = $mysqli->prepare(
        "DELETE
        FROM tareasRepPersonajes
        WHERE id_usuario = ?")) {
        $stmt3->bind_param('i',$idUser);
        $stmt3->execute();    // Ejecuta la consulta preparada.
    }

        if($stmt && $stmt2 && $stmt3){
            return true;
        }else{
            return false;
        };
        $stmt -> close();
        $stmt2 -> close();

  }//Fin eliminarTodasTareas()

  function borrarTareaPj($idUser,$idPj,$mysqli){
    //Borramos todas las tareas del personaje, tanto en tareaPersonajes como en tareasRepPersonajes
    if ($stmt = $mysqli->prepare(
        "DELETE
        FROM tareasPersonajes
        WHERE id_pj = ?")) {
        $stmt->bind_param('i',$idPj);
        $stmt->execute();    // Ejecuta la consulta preparada.
    }

    if ($stmt2 = $mysqli->prepare(
        "DELETE
        FROM tareasRepPersonajes
        WHERE id_pj = ?")) {
        $stmt2->bind_param('i',$idPj);
        $stmt2->execute();    // Ejecuta la consulta preparada.
    }
    //Ahora borramos las tareas no repetidas que no estén presentes en tareasPersonajes:
    if ($stmt3 = $mysqli->prepare(
        "DELETE
        FROM tareas
        WHERE id_usuario=?
        AND repetir = 0
        AND tareas.id NOT IN (
          SELECT tareasPersonajes.id_tarea
          FROM tareasPersonajes)")) {
        $stmt3->bind_param('i',$idUser);
        $stmt3->execute();    // Ejecuta la consulta preparada.
    }
    //Ahora borramos las tareas repetidas que no estén presentes en tareasRepPersonajes:
    if ($stmt4 = $mysqli->prepare(
        "DELETE
        FROM tareas
        WHERE id_usuario=?
        AND repetir != 0
        AND tareas.id NOT IN (
          SELECT tareasRepPersonajes.id_tarea
          FROM tareasRepPersonajes)")) {
        $stmt4->bind_param('i',$idUser);
        $stmt4->execute();    // Ejecuta la consulta preparada.
    }
    if($stmt &&$stmt2 && $stmt3 && $stmt4){
      return true;
    }else{
      return false;
    }

  }

  /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
                          // OTROS //
  /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */


  /*
    Función que devuelve la imagen del icono de la tarea
  */
  function getIconoTarea($tipo,$subtipo){
    switch ($tipo) {
      case '1':
        switch ($subtipo) {
          case '1':
            return "img/tareas/icon-colec-juguetes.png";
            break;
          case '2':
            return "img/tareas/icon-colec-mascotas.png";
            break;
          case '3':
            return "img/tareas/icon-colec-montura.png";
            break;
          case '4':
            return "img/tareas/icon-colec-otros.png";
            break;
        }
        break;
      case '2':
        return "img/tareas/icon-logros.png";
        break;
      case '3':
        return "img/tareas/icon-moneda.png";
        break;
      case '4':
        return "img/tareas/icon-objetos.png";
        break;
      case '5':
        return "img/tareas/icon-pvp.png";
        break;
      case '6':
        return "img/tareas/icon-equipo.png";
        break;
      case '7':
        switch ($subtipo) {
          case '1':
            return "img/tareas/icon-prof-alquimia.png";
            break;
          case '2':
            return "img/tareas/icon-prof-arqueologia.png";
            break;
          case '3':
            return "img/tareas/icon-prof-cocina.png";
            break;
          case '4':
            return "img/tareas/icon-prof-desuello.png";
            break;
          case '5':
            return "img/tareas/icon-prof-encantamiento.png";
            break;
          case '6':
            return "img/tareas/icon-prof-herboristeria.png";
            break;
          case '7':
            return "img/tareas/icon-prof-herreria.png";
            break;
          case '8':
            return "img/tareas/icon-prof-ingenieria.png";
            break;
          case '9':
            return "img/tareas/icon-prof-inscripcion.png";
            break;
          case '10':
            return "img/tareas/icon-prof-joyeria.png";
            break;
          case '11':
            return "img/tareas/icon-prof-mineria.png";
            break;
          case '12':
            return "img/tareas/icon-prof-peleteria.png";
            break;
          case '13':
            return "img/tareas/icon-prof-pesca.png";
            break;
          case '14':
            return "img/tareas/icon-prof-sastreria.png";
            break;
        }
        break;
      case '8':
        switch ($subtipo) {
          case '1':
            return "img/tareas/icon-repu-antiguas.png";
            break;
          case '2':
            return "img/tareas/icon-repu-ali-almirantazgo.png";
            break;
          case '3':
            return "img/tareas/icon-repu-ali-ordenascuas.png";
            break;
          case '4':
            return "img/tareas/icon-repu-ali-desptormenta.png";
            break;
          case '5':
            return "img/tareas/icon-repu-ali-7legion.png";
            break;
          case '6':
            return "img/tareas/icon-repu-ambos-buscTortoliano.png";
            break;
          case '7':
            return "img/tareas/icon-repu-ambos-campAzeroth.png";
            break;
          case '8':
            return "img/tareas/icon-repu-horda-defenhonor.png";
            break;
          case '9':
            return "img/tareas/icon-repu-horda-expTalanji.png";
            break;
          case '10':
            return "img/tareas/icon-repu-horda-imperZandalari.png";
            break;
          case '11':
            return "img/tareas/icon-repu-horda-voldunai.png";
            break;
        }
        break;
      case '9':
        return "img/tareas/icon-subasta.png";
        break;
      case '10':
        return "img/tareas/icon-personalizado.png";
        break;
      default:
        return "img/tareas/icon-personalizado.png";
        break;
    }
  }//Fin getIconoTarea

  /*
    Función que devuelve el nombre del tipo de tarea
  */
  function getNombreTarea($tipo,$subtipo){
    switch ($tipo) {
      case '1':
        switch ($subtipo) {
          case '1':
            return "Coleccionables: Juguetes";
            break;
          case '2':
            return "Coleccionables: Mascotas";
            break;
          case '3':
            return "Coleccionables: Monturas";
            break;
          case '4':
            return "Coleccionables: Otros";
            break;
        }
        break;
      case '2':
        return "Logros";
        break;
      case '3':
        return "Monedas";
        break;
      case '4':
        return "Objetos";
        break;
      case '5':
        return "PvP";
        break;
      case '6':
        return "Pieza de equipo";
        break;
      case '7':
        switch ($subtipo) {
          case '1':
            return "Profesión: Arqueología";
            break;
          case '2':
            return "Profesión: Alquimia";
            break;
          case '3':
            return "Profesión: Cocina";
            break;
          case '4':
            return "Profesión: Desuello";
            break;
          case '5':
            return "Profesión: Encantamiento";
            break;
          case '6':
            return "Profesión: Herboristería";
            break;
          case '7':
            return "Profesión: Herrería";
            break;
          case '8':
            return "Profesión: Ingeniería";
            break;
          case '9':
            return "Profesión: Inscripción";
            break;
          case '10':
            return "Profesión: Joyería";
            break;
          case '11':
            return "Profesión: Pesca";
            break;
          case '12':
            return "Profesión: Minería";
            break;
          case '13':
            return "Profesión: Peletería";
            break;
          case '14':
            return "Profesión: Sastrería";
            break;
        }
        break;
      case '8':
        switch ($subtipo) {
          case '1':
            return "Reputación-Antiguas";
            break;
          case '2':
            return "Reputación-Alianza:<br>Almirantazgo de la Casa Valiente";
            break;
          case '3':
            return "Reputación-Alianza:<br>Orden de Ascuas";
            break;
          case '4':
            return "Reputación-Alianza:<br>Despertar de la Tormenta";
            break;
          case '5':
            return "Reputación-Alianza:<br>Séptima Legión";
            break;
          case '6':
            return "Reputación-Ambos:<br>Buscadores Tortolianos";
            break;
          case '7':
            return "Reputación-Ambos:<br>Campeones de Azeroth";
            break;
          case '8':
            return "Reputación-Horda:<br>Defensores del Honor";
            break;
          case '9':
            return "Reputación-Horda:<br>Expedición de Talanji";
            break;
          case '10':
            return "Reputación-Horda:<br>Imperio Zandalari";
            break;
          case '11':
            return "Reputación-Horda:<br>Voldunai";
            break;
        }
        break;
      case '9':
        return "Compra - Venta";
        break;
      case '10':
        return "Personalizado";
        break;
      default:
        return "Personalizado";
        break;
    }
  }//Fin getNombreTarea

  /*
    Función que devuelve un array con las ID separadas de los personajes guardados concatenados en un string en la BD
  */
  function getArrayPersonajes($string){
    //Comprobamos el número de |. Este valor es el nº de personajes guardados, ya que el formato es id|id|id|...
    $nBarras = mb_substr_count($string, "|");
    //Creamos array que almacenará los personajes
    $personajes =array();
    for($i=0;$i<$nBarras;$i++){
      $posFinal=strpos($string, "|");
      //Añadimos a $personajes la subcadena del primer id de la linea.
      array_push($personajes, substr($string,0,$posFinal));
      //Elminamos de la cadena la id inicial + su |, dejándolo listo para el siguiente ciclo del for
      $string=substr($string,$posFinal+1,strlen($string));
    }

    return $personajes;
  }


  /*
    Función que reinicia las misiones diarias. La llamada viene desde un evento Cron del servidor
  */
  function reinicioTareas($mysqli,$clave,$tipo){
    //Antes de nada comprobamos la clave de control
    if($clave == "412619921124"){
      echo "Clave correcta.<br>";
      /*Recuperamos todas las tareas ya mostradas (primer valor=0) y las que siguen mostrándose (valor=1).
      El motivo es que pueden estar mostrándose pero no tener todos los personajes iniciales en la tarea (se ha completado con algunos)*/
      $tareasRepetibles = array_merge(getTareasRepetibles(1,$mysqli,$tipo),getTareasRepetibles(0,$mysqli,$tipo));

      //Para cada tarea repetible, actualizamos a "0" su campo "mostrado" y añadimos los personajes a la tabla tareasPersonajes para que sean visibles.
      foreach ($tareasRepetibles as $tarea) {
        $idUser = $tarea["idUsuario"];
        $idTarea = $tarea["id"];

        /* Debug */
        echo "<br>User: ".$idUser."<br>";
        echo "Tarea: ".$idTarea."<br>";
        var_dump($tarea);
        echo "<br><br> XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX <br>";
        /* !Debug */

        $actualizarTareas = actualizarTodasTareasRepetibles($idUser,$tarea['id'],$mysqli);
        if($actualizarTareas){
          //Recuperamos los personajes de la tarea en cuestión
          $personajesEnTarea = getPersonajesRepTarea($idUser,$idTarea,$mysqli);
          $listaPersonajes="";
          foreach ($personajesEnTarea as $idPj) {
            if ($stmt = $mysqli->prepare(
                "REPLACE INTO tareasPersonajes (id_usuario,id_pj,id_tarea)
                VALUES (?,?,?)")) {
                $stmt->bind_param('iii', $idUser, $idPj, $idTarea);
                $stmt->execute();
                $stmt->close();

                //Borramos posibles registros repetidos
                if ($stmt2 = $mysqli->prepare(
                    "DELETE t1 FROM tareasPersonajes t1
                    INNER JOIN tareasPersonajes t2
                    WHERE t1.id > t2.id AND t1.id_usuario = t2.id_usuario AND t1.id_pj = t2.id_pj AND t1.id_tarea = t2.id_tarea; ")) {
                    $stmt2->execute();
                    $stmt2->close();
                }
            }
          }
        }else{
          echo "Error actualizando tareas";
          return false;
        }
        return true;
      }
    }else{
      return false;
    }// Fin comprobacion clave.
  }//Fin reinicioDiario()

  /*
    Función que reinicia las misiones semanales. La llamada viene desde un evento Cron del servidor
  */
  function reinicioSemanal($mysqli,$clave){
    //Antes de nada comprobamos la clave de control
    if($clave == "412619921124"){

      //Conseguimos el ID de cada usuario
      $idAllUsers = getAllIdUser($mysqli);
      //Para cada id, comprobamos sus diarias y las añadimos a tareas si no lo están ya
      foreach ($idAllUsers as $key) {
        $idUser = $key['id'];

        //Recuperamos todas las tareas
        $tareasRepetibles = getTareasRepetibles($idUser,$mysqli,2);
        $personajesId = array();
        $tareasConRepeticionID = array();

        //Extraemos sólo las ID
        foreach ($tareasRepetibles as $tarea) {
          //Actualizamos a 0 el campo "mostrado" de la tarea de la id actual
          actualizarTareaRepetible($idUser,$tarea['id'],$mysqli,0);
          //Recuperamos los personajes en esta tarea
          $personajesId = getPersonajesRepTarea($idUser,$tarea['id'],$mysqli);
          //Añadimos dichos personajes a la tabla PersonajesTarea
          foreach ($personajesId as $pj) {
            setPersonajesTarea($idUser, $pj, $mysqli);
          }
        }
      }
    }
  }//Fin reinicioSemanal()


/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */


 ?>
