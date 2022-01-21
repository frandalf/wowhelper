<?php
/*
  Este archivo recibe una llamada cada día a las 9 de la mañana con el tipo
  "diarias" y otra semanalmente con el tipo "semanal" desde un evento Cron del servidor
  La llamada desde el servidor será: wget https://wowhelper.es/reactivaciones.php?tipo=tipo&clave=clave
  Ej: https://wowhelper.es/reactivaciones.php?tipo=diario&clave=
  Programación de Cron's: https://cron-job.org
*/
  include_once ("config.php");
  include_once ("../".INCLUDESROOT."/functions_tareas.php");
  include_once ("../".INCLUDESROOT."/db_connect.php");
  $db = new db_connect();
  $mysqli = $db->getSqli();
  //Se encarga de reactivar diaria o Semanalmente
  if(isset($_GET['tipo'])){
    $tipo = $_GET['tipo'];
    if(isset($_GET['clave'])){
      $reinicio=false;
      $clave = $_GET['clave'];
      switch ($tipo) {
        case 'diario':
          $reinicio = reinicioTareas($mysqli,$clave,1); //Diario=1
          break;
        case 'semanal':
          $reinicio = reinicioTareas($mysqli,$clave,2); //Diario=2
      }
      if($reinicio){
        echo "<br><p style='color:green'><b>Reinicio realizado.</b></p>";
      }else{
        echo "<br><p style='color:red'><b>Reinicio fallido.</b></p>";
      }
      return $reinicio;
    }
  }

 ?>
