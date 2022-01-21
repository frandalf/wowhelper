<?php
  session_start();
  include_once ("config.php");
  include_once ("../".INCLUDESROOT."/gestionVariables.php");
  include_once ("../".INCLUDESROOT."/seguridad.php");
  include_once ("../".INCLUDESROOT."/db_connect.php");
  include_once ("../".INCLUDESROOT."/functions_wow.php");
  include_once ("../".INCLUDESROOT."/functions_acceso.php");
  include_once ("../".INCLUDESROOT."/wowapi.php");
  $db = new db_connect();
  comprobarSesion();

  $arrayDatos;
  $personajeBajo=false;
  $error=false;
  //variables de personaje
  $nombre;
  $nivel;
  $faccion;
  $clase;
  $profPrimaria;
  $profSecundaria;
  $profPrimariaValor;
  $profSecundariaValor;
  $thumbnail;
  $ilvl;
  $RealmName;
  $RegionName;

  if(isset($_GET["nivel"])){
    if($_GET["nivel"]=="bajo" && isset($_GET["nombre"]) && isset($_GET["reino"]) && isset($_GET["faccion"])){
      //Es un personaje nivel bajo, enviamos a personaje.php directamente
      $personajeBajo=true;
      ///ToDo
    }else if($_GET["nivel"]=="normal" && isset($_GET["nombre"]) && isset($_GET["reino"]) && isset($_GET["zona"])){
      //Es un personaje de nivel normal o alto

    }else{
      $error = true;
      enviarApersonajes("a");
    }
  }else{
    //Renviamos a Personajes.php
    enviarApersonajes("b");
  }

      //Preparamos el guardado en la BD:
      $mysqli = $db->getSqli();
      $email = $_SESSION["email"];
      $idUser = getIdUser($email,$mysqli);
      $id = recuperarID($_GET["nombre"],$_GET["reino"],$idUser,$mysqli);
      //Comprobamos si el personaje es de nivel <10. De ser así, guardamos los datos básicos en la BD. Si no, extraemos los datos de la API de Blizzard y los guardamos en BBDD
      if ($personajeBajo){
        //Comprobamos si el personaje existe:
        if(empty($id)){
          //Guardamos en la BD
          if(guardarPjBajo($idUser,$_GET["nombre"],$_GET["reino"],$_GET["faccion"],$mysqli)){
            enviarAvistaPersonaje($idUser,$id,$_GET["nombre"],$_GET["reino"]);
          }else{
            enviarApersonajes("c");
          }

        }else{
          enviarAvistaPersonaje($idUser,$id,$_GET["nombre"],$_GET["reino"]);
        }
      }else{
        $json=extraerPersonaje($_GET["nombre"],$_GET["reino"],$_GET["zona"]);
        echo "Error: ".$_GET["nombre"].$_GET["reino"].$_GET["zona"];
        $arrayDatos=datosBasicos($json,$_GET["nombre"],$_GET["reino"],$_GET["zona"]);
        if($arrayDatos != false && !$error){
          //$nombre,$nivel,$faccion,$clase,$profPrimaria,$profPrimariaValor,$profSecundaria,$profSecundariaValor,$thumbnail,$clase
          $nombre = $arrayDatos[0];
          $nivel = $arrayDatos[1];
          $faccion = $arrayDatos[2];
          $clase = $arrayDatos[3];
          $profPrimaria = $arrayDatos[4];
          $profPrimariaValor = $arrayDatos[5];
          $profSecundaria = $arrayDatos[6];
          $profSecundariaValor = $arrayDatos[7];
          $thumbnail = $arrayDatos[8];
          $RealmName = $arrayDatos[9];
          $RegionName = $arrayDatos[10];

          //Comprobamos si el personaje existe:
          $id=recuperarID($nombre,$RealmName,$idUser,$mysqli);
          if(empty($id)){
            //Guardamos en la BD
            if(guardarPj($idUser,$nombre,$RealmName,$RegionName,$nivel,$clase,$faccion,$profPrimaria,$profPrimariaValor,$profSecundaria,$profSecundariaValor,0,0,0,$thumbnail,$mysqli)){
              enviarAvistaPersonaje($idUser,$id,$nombre,$RealmName);
            }else{
              enviarApersonajes("f");
            }
          }else{
            //El personaje ya existe, así que enviamos directamente a personaje.php
            enviarAvistaPersonaje($idUser,$id,$nombre,$RealmName);
///            echo $nombre."-".$RealmName." existe";
          }
        }else{
          enviarApersonajes("e");
        }
      }//Fin if

      function enviarApersonajes($error){
        header("Location: personajes.php?error=$error");
        exit();
      }

      function enviarAvistaPersonaje($idUser,$id,$nombre,$reino){
        //header("Location: personaje.php?user=$idUser&id=$id&nombre=$nombre&reino=$reino");
        header("Location: personajes.php");
        exit();
      }


    ?>
