<?php
/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX *\
  Creación: 15-6-2018         |       Última modificación:  24-10-2018
  Autor: Francisco José Montero Campos - fran.montero.campos@gmail.com
  --------------------------------------------------------------------
  Objetivo:
  Clase que se encarga del CRUD en relación a los usuarios, al igual que
  del método que comprueba el login.
\* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */


  include_once ("wa-config.php");
  include_once ("db_connect.php");
  include_once ("cleanCode.php");

  /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
                          // LOGIN //
  /* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

  /*
    Función que se encarga del Login.
  */
  function login($email, $password, $mysqli) {
    $stmt = select_email($email, $mysqli);

    // Obtiene las variables del resultado.
    $stmt->bind_result($user_id, $username, $db_password);
    $stmt->fetch();

    if ($stmt->num_rows == 1) {
        // Revisa que la contraseña en la base de datos coincida
        // con la contraseña que el usuario envió.
        if ($db_password == $password) {
            // ¡La contraseña es correcta!
            return true;
        } else {
            return false;
        }
    } else {
        // El usuario no existe.
        header("Location: index.php?error=user");
        exit();
    }
}//FIN login()

/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
                        // CREATE //
/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

/*
  Función para realizar el registro de usuarios
*/
function registro($user, $email, $pass, $mysqli){
  $user=limpiar($user);
  $email=limpiar($email);
  $pass=limpiar($pass);
  // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
  if ($stmt = $mysqli->prepare("INSERT INTO usuarios (username,email,password) VALUES (?,?,?)")) {
    $stmt->bind_param('sss', $user, $email, $pass);  // Une "$user" al parámetro
    $stmt->execute();

    //Nos preparamos para crear las tablas de este usuario. Estas tablas son 'usuario-parteLocalCorreo-pj','usuario-parteLocalCorreo-tar' y 'usuario-parteLocalCorreo-tarRep'
    $correo = strstr($email,'@',true);
    $tablename = $user."-".$correo;
    if($stmt){
        return true;
    }else{
        return false;
    };
  }
}//FIN REGISTRO


/*
  Función que guarda el ID del usuario apartir del passwordKey para recuperar contraseña
*/
function setPassKey($email, $passwordKey, $mysqli){
  // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
  $user=limpiar($passwordKey);
  // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
  if ($stmt = $mysqli->prepare("INSERT INTO recuperar_password (email,passwordKey) VALUES (?,?)")) {
    $stmt->bind_param('ss', $email, $passwordKey);
    $stmt->execute();
    if($stmt){
        return true;
    }else{
        return false;
    };
  }
}//Fin setPassKey()


/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
                        // READ //
/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

/*
Función para hacer un select del email
*/
function select_email($email, $mysqli) {
  // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
  if ($stmt = $mysqli->prepare("SELECT id, username, password
      FROM usuarios
     WHERE email = ?
      LIMIT 1")) {
      $stmt->bind_param('s', $email);  // Une “$email” al parámetro.
      $stmt->execute();    // Ejecuta la consulta preparada.
      $stmt->store_result();

      return $stmt;
  }
}//FIN select_email()

/*
Función para hacer un select del user
*/
function select_user($email, $mysqli) {
  // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
  if ($stmt = $mysqli->prepare("SELECT username FROM usuarios WHERE email = ? LIMIT 1")) {
      $stmt->bind_param('s', $email);  // Une “$email” al parámetro.
      $stmt->execute();    // Ejecuta la consulta preparada.
      $stmt->store_result();

      // Obtiene las variables del resultado.
      $stmt->bind_result($username);
      $stmt->fetch();

      if ($stmt->num_rows == 1) {
          return $username;
      }
  }
}//FIN select_email()

/*
  Función que recupera los datos de la sesión de la base de datos
*/
function getDatosSesion($email, $mysqli){
  // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
  if ($stmt = $mysqli->prepare("SELECT ultimaip, SKey FROM usuarios WHERE email = ? LIMIT 1")) {
      $stmt->bind_param('s', $email);  // Une “$email” al parámetro.
      $stmt->execute();    // Ejecuta la consulta preparada.
      $stmt->store_result();
      return $stmt;
  }
}//Fin getDatosSesion()

/*
  Función que recupera los datos de la sesión de la base de datos
*/
function getSkey($email, $mysqli){
  // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
  if ($stmt = $mysqli->prepare("SELECT SKey FROM usuarios WHERE email = ? LIMIT 1")) {
      $stmt->bind_param('s', $email);  // Une “$email” al parámetro.
      $stmt->execute();    // Ejecuta la consulta preparada.
      $stmt->store_result();

      // Obtiene las variables del resultado.
      $stmt->bind_result($SKey);
      $stmt->fetch();

      if ($stmt->num_rows == 1) {
          return $SKey;
      }
  }
}//Fin getSkey()


/*
  Función que recupera el ID del usuario
*/
function getIdUser($email, $mysqli){
  // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
  if ($stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE email = ? LIMIT 1")) {
      $stmt->bind_param('s', $email);  // Une “$email” al parámetro.
      $stmt->execute();    // Ejecuta la consulta preparada.
      $stmt->store_result();

      // Obtiene las variables del resultado.
      $stmt->bind_result($id);
      $stmt->fetch();

      if ($stmt->num_rows == 1) {
          return $id;
      }
  }
} //Fin getIdUser()

/*
  Función que recupera el ID de todos los usuarios
*/
function getAllIdUser($mysqli){
  // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
  if ($stmt = $mysqli->prepare("SELECT id FROM usuarios")) {
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
} //Fin getAllIdUser()


/*
  Función que recupera el ID del usuario apartir del passwordKey para recuperar contraseña
*/
function getPassKey($passwordKey, $mysqli){
  // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
  if ($stmt = $mysqli->prepare("SELECT email FROM recuperar_password WHERE passwordKey = ?")) {
      $stmt->bind_param('s', $passwordKey);  // Une “$email” al parámetro.
      $stmt->execute();    // Ejecuta la consulta preparada.
      $stmt->store_result();

      // Obtiene las variables del resultado.
      $stmt->bind_result($email);
      $stmt->fetch();

      if ($stmt->num_rows == 1) {
        return $email;
      }
  }
} //Fin getPassKey()



/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
                        // UPDATE //
/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

/*
Función para insertar en la BBDD la ultima ip del usuario y su última SKey
*/
function setDatosSesion($ip,$SKey,$email,$mysqli){
  if ($stmt = $mysqli->prepare("UPDATE usuarios SET ultimaip=?, SKey=? WHERE email=?")) {
    $stmt->bind_param('sss', $ip, $SKey, $email);  // Une "$user" al parámetro
    $stmt->execute();
    if($stmt){
        return true;
    }else{
        return false;
    };
  }
}//Fin setDatosSesion()


/*
  Función que actualiza los datos del usuario desde el perfil
*/
function updateUser($mysqli,$user,$email,$id){
  if ($stmt = $mysqli->prepare("UPDATE usuarios SET username=?, email=? WHERE id=?")) {
    $stmt->bind_param('ssi', $user, $email, $id);
    $stmt->execute();
    if($stmt){
        return true;
    }else{
        return false;
    };
  }
}//end updateUser()


/*
  Función que actualiza los datos del usuario (incluída contraseña) desde el perfil
*/
function updateUserPass($mysqli,$user,$email,$password,$id){
  if ($stmt = $mysqli->prepare("UPDATE usuarios SET username=?, email=?, password=? WHERE id=?")) {
    $stmt->bind_param('sssi', $user, $email, $password, $id);
    $stmt->execute();
    if($stmt){
        return true;
    }else{
        return false;
    };
  }
}//end updateUserPass()

/*
  Función que actualiza la contraseña del usuario al recuperarla
*/
function updatePass($mysqli,$password,$email){
  if ($stmt = $mysqli->prepare("UPDATE usuarios SET password=? WHERE email=?")) {
    $stmt->bind_param('ss', $password, $email);
    $stmt->execute();
    if($stmt){
        return true;
    }else{
        return false;
    };
  }
}//end updatePass()


/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
                        // DELETE //
/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

/*
  Función que borra el passKey del usuario actual una vez modificada la pass
*/
function deletetPassKey($passwordKey, $mysqli){
  // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
  if ($stmt = $mysqli->prepare("DELETE FROM recuperar_password WHERE passwordKey = ?")) {
      $stmt->bind_param('s', $passwordKey);  // Une “$email” al parámetro.
      $stmt->execute();    // Ejecuta la consulta preparada.

      if($stmt){
          return "true";
      }else{
          return "false";
      };
  }
} //Fin deletetPassKey()



/*
  Función que borra los datos del usuario desde el perfil
*/
function borrarUsuario($mysqli,$id){
  if ($stmt = $mysqli->prepare("DELETE FROM usuarios WHERE id=?")) {
    $stmt->bind_param('i', $id);
    $stmt->execute();
    if($stmt){
        return "true";
    }else{
        return "false";
    };
  }
}//end borrarUsuario()

?>
