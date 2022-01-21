<?php
/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX *\
  Creación: 19-6-2018         |       Última modificación:  28-10-2018
  Autor: Francisco José Montero Campos - fran.montero.campos@gmail.com
  --------------------------------------------------------------------
  Objetivo:
  Clase que se encarga del manejo de las cookies del navegador y de
  sesión, así como de la desconexión y otros métodos
\* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

  include_once ("functions_acceso.php");
  include_once ("../includes_wowassistant/db_connect.php");
  include_once ("seguridad.php");

  //Iniciamos sesión
  function sec_session_start($email,$user,$pass,$remember){
    //Asignamos seguridad al inicio de sesión
    //Biblio: https://www.tarlogic.com/blog/como-generar-sesiones-en-php-de-forma-segura/, https://www.imaginanet.com/blog/seguridad-en-php-basica-escribiendo-aplicaciones-web-seguras.html
    session_start();
    //Creamos variable de sesión donde almacenar una KEY temporal y única:
    $SKey = uniqid(mt_rand(), true);
    //Generamos distintas cookies de sesión relativas a la seguridad:
    $_SESSION['Autenticado']=1;
    $_SESSION['IpClientActual']=getRealIP();
    $_SESSION['SKey'] = $SKey;
    $_SESSION['email'] = $email;
    $_SESSION['user'] = $user;
    //Rellenamos la BD con estos datos:
    $db = new db_connect();
    $mysqli = $db->getSqli();
    setDatosSesion(getRealIP(),$SKey,$email,$mysqli);
    //Guardamos dicha KEY en una cookie temporal (se borrará al cerrar el navegador):
    setcookie("SKeyC", $SKey, time()+2592000,"/"); //Caduca en un mes
    setcookie("email", $email, time()+2592000,"/");  //Caduca en un mes
    //Si el usuario ha decidido guardar datos, creamos una cookie con el pass
    if($remember){
      setcookie("remember", "true", time()+2592000,"/");  //Caduca en un mes
    }else{
      setcookie("remember", "false", time()+2592000,"/");  //Caduca en un mes
    }
    //Almacenamos en la sesión el id del usuario:
    $id_user=getIdUser($email, $mysqli);
    $_SESSION['id_user'] = $id_user;

  } //FIN sec_session_start()

  //Función de deslogueo
  function logOut() {
    session_start();
    session_regenerate_id(true);
    session_unset();
    session_destroy();
    unset ($_COOKIE["SKeyC"]);
  }

  //Función que borra todas las cookies almacenadas y desloguea
  function deleteCookies() {
    logOut();
    if (isset($_SERVER['HTTP_COOKIE'])) {
      $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
      foreach($cookies as $cookie) {
          $parts = explode('=', $cookie);
          $name = trim($parts[0]);
          setcookie($name, '', time()-1000);
          setcookie($name, '', time()-1000, '/');
      }
    }
  }

  //Función que devuelve la IP actual del usuario
  function getRealIP(){
    if (isset($_SERVER["HTTP_CLIENT_IP"])){
        return $_SERVER["HTTP_CLIENT_IP"];
    }elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }elseif (isset($_SERVER["HTTP_X_FORWARDED"])){
        return $_SERVER["HTTP_X_FORWARDED"];
    }elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){
        return $_SERVER["HTTP_FORWARDED_FOR"];
    }elseif (isset($_SERVER["HTTP_FORWARDED"])){
        return $_SERVER["HTTP_FORWARDED"];
    }else{
        return $_SERVER["REMOTE_ADDR"];
    }
  }

  //Función para devolver la Fecha
  function fechaActual(){
    $hoy = getdate();
    $d = $hoy['mday'];
    $m = $hoy['mon'];
    $y = $hoy['year'];
    $h = $hoy['hours'];
    $s =  $hoy['seconds'];
    $min = $hoy['minutes'];
    $dia = $hoy['wday'];
    $fecha = [
      "fecha" => "$y-$m-$d",
      "dia" => $d,
      "mes" => $m,
      "year" => $y,
      "diaSemana" => $dia,
      "horaActual" => "$h:$min:$s",
      "hora" => $h,
      "min" => $min,
      "seg" => $s
    ];

    return $fecha;
  }//Fin fechaActual()

  //Método que devuelve el tiempo hasta las 9:00 del día siguiente o del miércoles siguiente
  function getReinicioTareas($dia){
    date_default_timezone_set('GMT');
    if($dia=="1"){//Si es uno implica que se rienicia a diario, por lo que calculamos las 9:00 de mañana (hora de reinicio de servers del WoW)
      $tomorrow = strtotime("tomorrow 08:59:00");
      $now = strtotime("now");
      $dif=$tomorrow-$now;
      return $dif;
    }else{//Si no es uno es 2, lo que implica reincio semanal (miércoles a las 9:00). No puede ser 0 porque se comprueba antes de llamar a este método
      $tomorrow = strtotime("Wednesday 08:59:00");
      $now = strtotime("now");
      $dif=$tomorrow-$now;
      return $dif;
    }

  }



 ?>
