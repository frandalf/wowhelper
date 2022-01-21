<?php
/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX *\
  Creación: 15-6-2018         |        Última modificación:  19-6-2018
  Autor: Francisco José Montero Campos - fran.montero.campos@gmail.com
  --------------------------------------------------------------------
  Objetivo:
  Clase que se encarga de la conectividad con la base de datos
  --------------------------------------------------------------------
  Funciones:
    function hayConexion()
    function getSqli()
\* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

  include_once 'wa-config.php';
  class db_connect{
    private $conexion=true;
    private $mysqli;
    function __construct(){
      $this->mysqli = new mysqli(HOST,USER,PASSWORD,DATABASE);
      if($this->mysqli->connect_errno) {
          $conexion=false;
      }
    }
    //Devuelve si hay conexión
    function hayConexion(){
      return $this->conexion;
    }
    //Devuelve el mysqli
    function getSqli(){
      return $this->mysqli;
    }
  }

 ?>
