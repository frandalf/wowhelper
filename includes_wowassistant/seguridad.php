<?php
/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX *\
  Creación: 27-6-2018         |       Última modificación:  22-10-2018
  Autor: Francisco José Montero Campos - fran.montero.campos@gmail.com
  --------------------------------------------------------------------
  Objetivo:
  Clase que se encarga de la seguridad, comprobando el acceso y el
  estado de la sesión.
\* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

  include_once ("cleanCode.php");
  include_once ("functions_acceso.php");
  include_once ("gestionVariables.php");

  /*
   * Método para comprobar si se accede directamente
   */
  function comprobarAcceso(){
    if(isset($_COOKIE['SKeyC']) && isset($_COOKIE["email"])) {
      $db = new db_connect();
      $mysqli = $db->getSqli();
      $email=limpiar($_COOKIE["email"]);
      $ultimaip;
      $Skey;
      $stmt = getDatosSesion($email, $mysqli);
      $stmt->bind_result($ultimaipS,$SkeyS);
      $stmt->fetch();

      if ($stmt->num_rows > 0) {
        $ultimaip = $ultimaipS;
        $Skey = $SkeyS;
      }

      //Comprobamos si se cumplen todas estas condiciones. De ser así, loga automáticamente
      if($Skey == $_COOKIE["SKeyC"] && $_COOKIE["remember"]=="true"){
          //Coinciden, por lo que enviamos a principal.
          setDatosSesion(getRealIP(),$_COOKIE["SKeyC"],$email,$mysqli);
          $user = select_user($email, $mysqli);
          sec_session_start($email,$user,"",true);

          header("Location: principal.php?user=$user&email=$email");
          ///header("Location: www.a.es".$SKey."XXX".$_SESSION['SKey']);
          exit();
      }else{
        reenvioIndex();
        ///header("Location: principalDD.php");
      }
    }
  }//FIN comprobarAcceso()

  /*
   * Método para comprobar si la sesión está activa o si las keys de servidor y cliente coinciden. Si no, a index?error
   */
  function comprobarSesion(){
    //Comprobamos que esté autenticado.
    if(!isset($_SESSION["Autenticado"])){
      //No lo está, enviamos a index.php
      reenvioIndex();
      ///header("Location: www.a.es");
      die();
    }else{
      if (empty($_COOKIE['SKeyC'])) {
        // error
        reenvioIndex();
        ///header("Location: www.b.es");
      }else{
        //Si lo está. Comprobamos que usa la misma SKey que la cookie
        if($_SESSION["SKey"] != $_COOKIE["SKeyC"]){
          reenvioIndex();
          ///header("Location: www.c.es".$_SESSION["SKey"]."|||".$_COOKIE["SKeyC"]);
        }
      }
    }
  } //Fin comprobarSesion()

  /*
   * Método para reenviar a index.php
   */
  function reenvioIndex(){
    deleteCookies();
    header("Location: index.php?error");
    die();
  }





 ?>
