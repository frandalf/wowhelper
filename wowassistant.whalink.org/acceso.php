<?php
  //include_once ("../includes_wowassistant/wa-config.php");
  include_once ("../includes_wowassistant/db_connect.php");
  include_once ("../includes_wowassistant/functions_acceso.php");
  include_once ("../includes_wowassistant/functions_wow.php");
  include_once ("../includes_wowassistant/functions_tareas.php");
  include_once ("../includes_wowassistant/cleanCode.php");
  include_once ("../includes_wowassistant/gestionVariables.php");
  include_once ("config.php");

  $db = new db_connect();
  $mysqli = $db->getSqli();
  if(!isset($_SESSION)){
    //Iniciamos sesión y almacenamos el email y el usuario
     session_start();
   }


  switch ($_GET["accion"]) {
    case "login":
      //Recibimos email y pass de formulario_login y los "limpiamos" (cleanCode->limpiar()) para evitar inyecciones de código
      $email = limpiar($_POST["email"]);
      $pass= limpiar($_POST["pass"]);
      $passSha512=hash('sha512',$pass);
      $remember=false;
      //recogemos si el usuario ha decidio guardar los datos de login:
      if(isset($_POST['remember']) && $_POST['remember']!=""){
        $remember=true;
      }

      //Comprobamos que el email esté bien formado:
      if(comprobarEmail($email)){
        //Está bien formado. Pasamos a comprobar con BBDD el email y el pass
        if(login($email, $passSha512, $mysqli)){
          //Login correcto
          //Creamos sesion en servidor
          $user = select_user($email,$mysqli);
          setcookie("user",$user,0,"/");
          //Llamamos al método gestionVariables->sec_session_start() para arrancar los parámetros de seguridad
          sec_session_start($email,$user,$pass,$remember);
          //Enviamos a la pantalla principal.
          header("Location: principal.php");
          exit();
        }else{
          //La contraseña es errónea
          header("Location: index.php?error=pass&correo=".$email);
          exit();
        }
      }else{
        //No está bien formado, volvemos a index mostrando el error.
        header("Location: index.php?error=email");
        exit();
      }
      break;
    case "registro":
      //Recogemos los datos del formulario y los "limpiamos" para evitar inyecciones de código
      $user = limpiar($_POST["user"]);
      $email1 = limpiar($_POST["email1"]);
      $email2 = limpiar($_POST["email2"]);
      $pass1 = limpiar($_POST["pass1"]);
      $pass2 = limpiar($_POST["pass2"]);
      $correcto=true;

      //Comprobamos que existe usuario
      if(is_null($user) || empty($user)){
        //No está bien formado, volvemos a registro mostrando el error.
        $correcto = false;
        header("Location: registro.php?error=user");
        exit();
      }
      //Comprobamos email bien formado:
      if(!comprobarEmail($email1)){
        //No está bien formado, volvemos a registro mostrando el error.
        $correcto = false;
        header("Location: registro.php?error=email");
        exit();
      }

      //Comprobamos si los emails sin iguales
      if($email1 != $email2){
        //No son iguales, volvemos a registro mostrando el error.
        $correcto = false;
        header("Location: registro.php?error=emailerror");
        exit();
      }

      //Comprobamos si las contraseñas son iguales
      if($pass1 != $pass2){
        //No son iguales, volvemos a registro mostrando el error.
        $correcto = false;
        header("Location: registro.php?error=passerror");
        exit();
      }

      //Si todo es correcto, procedemos al registro:
      if($correcto){
        $passSha512=hash('sha512',$pass1);
        //Está bien formado. Pasamos a comprobar con BBDD que el correo no exista:
        $stmt = select_email($email1, $mysqli);
        if ($stmt->num_rows == 1) {
          //Existe, no registramos
          header("Location: registro.php?error=existe");
          exit();
        }else{
          //No xiste, así que registramos.
          if(registro($user, $email1, $passSha512, $mysqli)){
            //Login correcto, reenviamos a principal.php
            header("Location: registrado.php");
          }else{
            //Error en el registro
            header("Location: registro.php?error=registro");
            exit();
          }
        }
      }else{ //intento erróneo, volvemos a registro
        header("Location: registro.php");
        exit();
      }
      break;
    case "cambioDatos":
      //Recogemos los datos del formulario y los "limpiamos" para evitar inyecciones de código
      $user = limpiar($_POST["nombre"]);
      $email = limpiar($_POST["email"]);
      $passOld = limpiar($_POST["oldPassword"]);
      $passNew = limpiar($_POST["newPassword"]);
      $passRepeat = limpiar($_POST["repeatPassword"]);
      $oldEmail = $_COOKIE['email'];      //Obtenemos el correo actual por si lo ha cambiado en formulario
      $passOldSha512=hash('sha512',$passOld);
      $passSha512=hash('sha512',$passNew);
      $correcto=true;

      //Comprobamos que existe usuario
      if(is_null($user) || empty($user)){
        //No está bien formado, volvemos a registro mostrando el error.
        $correcto = false;
        header("Location: perfil.php?error=user");
        exit();
      }
      //Comprobamos email bien formado:
      if(!comprobarEmail($email)){
        //No está bien formado, volvemos a registro mostrando el error.
        $correcto = false;
        header("Location: perfil.php?error=email");
        exit();
      }else{
        //Si está bien formado, comprobamos que el password anterior (de haber sido relleno) sea correcto:
        if(!login($oldEmail, $passOldSha512, $mysqli) &&  !empty($passNew)){
          $correcto = false;
          header("Location: perfil.php?error=oldPassword");
          exit();
        }
      }

      //Comprobamos si los password son iguales
      if($passNew != $passRepeat){
        //No son iguales, volvemos a registro mostrando el error.
        $correcto = false;
        header("Location: perfil.php?error=passerror");
        exit();
      }

      //Pasamos a comprobar con BBDD que el nuevo correo, de haberlo, no exista:
      if($email != $oldEmail){
        $stmt = select_email($email, $mysqli);
        if ($stmt->num_rows == 1) {
          //Existe, no registramos
          $correcto = false;
          header("Location: perfil.php?error=existe");
          exit();
        }
      }


      //Si todo es correcto, procedemos al cambio de datos:
      if($correcto){
        $id=getIdUser($oldEmail, $mysqli);
        $stmt = select_email($email, $mysqli);
        //Comprobamos si se ha añadido cambio de contraseña.
        if(is_null($passNew) || empty($passNew) || $passNew!=""){
          //No hay cambio, por tanto se cambia solo user y mail
          if(updateUser($mysqli,$user,$email,$id)){
              //Cambiamos la cookie que guarda el usuarios
              session_start();
              $_SESSION['user'] = $user;
              setcookie('user',$user);
              //Cambio correcto, reenviamos a principal.php
              header("Location: principal.php?");
              exit();
          }else{
              //Error en el registro
              header("Location: perfil.php?error=registro");
              exit();
          }
        }else{
          //Hay cambio, por tanto se cambia todo
          if(updateUserPass($mysqli,$user,$email,$passSha512,$id)){
              //Cambiamos la cookie que guarda el usuarios
              session_start();
              $_SESSION['user'] = $user;
              setcookie('user',$user);
              header("Location: registrado.php?accion=cambioPass");
              exit();
          }else{
              //Error en el registro
              header("Location: perfil.php?error=registro");
              exit();
          }
        }

      }else{ //intento erróneo, volvemos a registro
        header("Location: perfil.php");
        exit();
      }
      break;
    case "borrarUsuario":
      session_start();
      $id = $_SESSION["id_user"];
      //Eliminamos sus pj
      $personajes=eliminarTodosPersonajes($id,$mysqli);
      //Eliminamos sus tareas
      $tareas=eliminarTodasTareas($idUser,$mysqli);
      //Eliminamos usuario de la BD
      $usuario=borrarUsuario($mysqli,$id);
      //Desconectamos la cuenta
      logout();

      if($personajes && $tareas && $usuario){
        header("Location: index.php?accion=personajeBorrado");
        exit();
      }else{
        header("Location: index.php?accion=errorPersonajeBorrado");
        exit();
      }
      break;
    case "recuperarPassword":
      $email = limpiar($_POST["email"]);
      $passwordKey = uniqid(mt_rand(), true);
      $url=$email.$passwordKey;
      $guardado=false;
      //Comprobamos que el email esté bien formado:
      if(comprobarEmail($email)){
        //Guardamos el correo y la key generada
        $guardado=setPassKey($email, $url, $mysqli);
      }

      if ($guardado) {
        //Si se ha guardado correctamente, enviamos un mail con el enlace para recuperar contraseña
        $url=$email.$passwordKey;
        $mail = "  <!DOCTYPE html>
          <html lang='es' dir='ltr'>
            <head>
              <meta charset='utf-8'>
              <title>Recuperción de contraseña</title>
            </head>
            <body style='border: 2px solid #00aeff;background-color: #161b45;text-align:center;width:700px;'>
              <img src='https://wowhelper.es/img/logo_wowhelper_white.png' style='width:350px;'><br>
              <h2 style='color: #ffffff;'><b>Para generar su nueva contraseña, dirígase a <a href='www.wowhelper.es/nuevoPassword.php?url=".$url."'>este enlace</a></b> </h2>
              <br>
              <br>
            </body>
          </html>";
        //Titulo
        $titulo = "Recuperación de contraseñas";
        //cabecera
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        //dirección del remitente
        $headers .= "From: WoWHelper < admin@wowhelper.es >\r\n";
        //Enviamos el mensaje a tu_dirección_email
        $bool = mail("deyrsent@gmail.com",$titulo,$mail,$headers);
        if($bool){
          header("Location: index.php?accion=sendMail");
          exit();
        }else{
          header("Location: index.php?error=sendMail");
          exit();
        }
      }


      break;
    case "nuevoPassword":
      //Forzamos la nueva contraseña tras pedir una recuperación de la misma
        if(isset($_POST["passwordNew"]) && isset($_POST["passwordRepeat"]) && isset($_POST["passwordKey"])){
          $passwordNew = $_POST["passwordNew"];
          $passwordRepeat = $_POST["passwordRepeat"];
          $passwordKey = $_POST["passwordKey"];
          $emailUser="";
          $actualizado=false;
          $borrado="falso";

          if($passwordNew == $passwordRepeat){
            $emailUser = getPassKey($passwordKey, $mysqli);
            $passSha512=hash('sha512',$passwordNew);
            $actualizado= updatePass($mysqli,$passSha512,$emailUser);
          }else{
            header("Location: nuevoPassword.php?error=pass");
            exit(); 
          }

          if($actualizado){
            //Como ya se ha actualizado, borramos de la BD la petición:
            $borrado = deletetPassKey($passwordKey, $mysqli);
            header("Location: index.php?accion=pass");
            exit();
          }else{
            header("Location: nuevoPassword.php?error");
            exit();
          }
        }

      break;

    default:
      // code...
      break;
  }




  /* **************************************
                  FUNCIONES
  ************************************** */

  //Función para comprobar si el email introducido tiene una formación correcta
  function comprobarEmail($email){
    if(false !== filter_var($email, FILTER_VALIDATE_EMAIL)){
      return true;
    }else{
      return false;
    }
  }
 ?>
