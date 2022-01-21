<?php
/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX *\
  Creación: 05-07-2018        |       Última modificación:  10-08-2018
  Autor: Francisco José Montero Campos - fran.montero.campos@gmail.com
  --------------------------------------------------------------------
  Objetivo:
  Clase que se encarga de la conexión con la API de Blizzard
\* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

  function extraerPersonaje($PlayerName,$RealmName,$LocaleName){
    //APIKey personal de Battlenet:
    ///$APIkey = 'zh6vc85g9taz532hybbm2f4whv5dexnr'; //2c2ktmsuwpz99v8dhmb6r82rrjer4bft
    $APIkey = 'zh6vc85g9taz532hybbm2f4whv5dexnr';
    $GameName = 'wow';
    $nombre;
    $nivel;
    $faccion;
    $clase;
    $profPrimaria;
    $profSecundaria;
    $profPrimariaValor;
    $profSecundariaValor;
    $thumbnail;
    $ilvl="0";
    $json_wow_api_url;

    //Comprobamos si son servidores europeos. Si no lo son, se consideran americanos
    if($LocaleName=="es-es" || $LocaleName=="de-de" || $LocaleName=="en-gb" || $LocaleName=="fr-fr" || $LocaleName=="it-it" || $LocaleName=="ru-ru"){
      $RegionName = 'eu';
    }else{
      $RegionName = 'us';
    }
    //Adecuamos el nombre del reino, eliminando espacios y '
    $RealmName = str_replace(' ', '%20', "$RealmName");
    $RealmName = str_replace('', '%27', "$RealmName");
    $RealmName = str_replace('', "'", "$RealmName");

    set_error_handler(
        create_function(
            '$severity, $message, $file, $line',
            'throw new ErrorException($message, $severity, $severity, $file, $line);'
        )
    );
    try{
      $url='https://'.$RegionName.'.api.battle.net/'.$GameName.'/character/'.$RealmName.'/'.$PlayerName.'?fields=reputation&fields=items&fields=guild&fields=professions&locale='.$LocaleName.'&apikey='.$APIkey.'';
      //  Initiate curl. Biblio: https://stackoverflow.com/questions/16700960/how-to-use-curl-to-get-json-data-and-decode-the-data
      $ch = curl_init();
      // Disable SSL verification
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      // Will return the response, if false it print the response
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // Set the url
      curl_setopt($ch, CURLOPT_URL,$url);
      // Execute
      $result=curl_exec($ch);
      // Closing
      curl_close($ch);
      $result = file_get_contents($url);
      return $result;
    }catch (Exception $e){
      return false;
    }
    restore_error_handler();
  }//extraerPersonaje();


  /*
   *  Extrae los datos básicos del personaje desde la API de Blizzard
   */
  function datosBasicos($json,$nombre,$RealmName,$LocaleName){
    if($json == false){
      return false;
    }else{
      foreach (json_decode($json) as $item => $value) {
        switch ($item) {
          case 'name':
            $nombre=$value;
            break;
          case 'level':
            $nivel=$value;
            break;
          case 'faction':
            $faccion=$value;
            break;
          case 'class':
            $clase=$value;
            break;
          case 'professions':
            foreach ($value as $key => $value) {
              switch ($key) {
                case 'primary':
                  foreach ($value as $value) {
                    foreach ($value as $key => $value) {
                      switch ($key) {
                        case 'name':
                          if(empty($profPrimaria)){
                            $profPrimaria=$value;
                          }else{
                            if(empty($profSecundaria)){
                              $profSecundaria=$value;
                            }
                          }
                          break;
                        case 'rank':
                          if(empty($profPrimariaValor)){
                            $profPrimariaValor=$value;
                          }else{
                            $profSecundariaValor=$value;
                          }
                          break;
                      }
                    }
                  }
                  break;
              }

            }
            break;
            case 'thumbnail':
              $thumbnail= str_replace("-avatar.jpg","",$value);
              break;
        }//FIN SWITCH ITEM->json
      }//FIN JSON
    }
    $resultado = array($nombre,$nivel,$faccion,$clase,$profPrimaria,$profPrimariaValor,$profSecundaria,$profSecundariaValor,$thumbnail,$RealmName,$LocaleName);
    return $resultado;
  }//FIN datosBasicos();


/*
  Función para extraer las profesiones
*/
function getProfesiones($json){
    if($json == false){
      return false;
    }else{
      $profPrimaria="";
      $profSecundaria="";
      $profPrimariaValor="";
      $profSecundariaValor="";
      $profPrimTerrallende="";
      $profPrimRasganorte="";
      $profPrimCataclysm="";
      $profPrimPandaria="";
      $profPrimDraenor="";
      $profPrimLegion="";
      $profPrimBfA="";
      $profSecTerrallende="";
      $profSecRasganorte="";
      $profSecCataclysm="";
      $profSecPandaria="";
      $profSecDraenor="";
      $profSecLegion="";
      $profSecBfA="";

      $bolClassic=false;
      $bolTerrallende=false;
      $bolRasganorte=false;
      $bolCataclysm=false;
      $bolPandaria=false;
      $bolDraenor=false;
      $bolLegion=false;
      $bolBfA=false;
      $bolPrimaria=false;
      $bolSecundaria=false;

      foreach (json_decode($json) as $item => $value) {
        switch ($item) {
          case 'professions':
          foreach ($value as $key => $value) {
            switch ($key) {
              case 'primary':
                foreach ($value as $valor) {
                  //1º vuelta para extraer los nombres de profesiones
                  foreach ($valor as $key => $valor2) {
                    switch ($key) {
                      case 'name':
                        //Comprobamos que ya tenemos la primera profesión. Si no, la añadimos.
                        if($profPrimaria == ""){
                          $profPrimaria = strtok($valor2, " ");
                        }else{//Si es la misma, entonces el valor es la segunda profesión
                          $temporal = strtok($valor2, " ");
                          //Controlamos que no devuelva el mismo nombre
                          if($temporal != $profPrimaria){
                            $profSecundaria = strtok($valor2, " ");
                          }
                        }
                    }
                  }//Fin foreach
                  //2º vuelta para extraer el valor de cada rango de profesión
                }
                foreach ($value as $value) {
                  //2º vuelta para extraer el valor de cada rango de profesión
                  foreach ($value as $key => $value) {
                    switch ($key) {
                      case 'name':
                        //Comprobamos si la primera palabra de la profesión es la primaria
                        if($profPrimaria == strtok($value, " ")){
                          $bolPrimaria =true;
                          $bolSecundaria = false;
                        }else{
                          $bolPrimaria =false;
                          $bolSecundaria = true;
                        }
                        //Comprobamos cuál es la última y activamos el booleano correspondiente
                        switch (strrchr($value, " ")) {
                          case '': //Si el valor es el de value, es el de la classic
                            $bolClassic=true;
                            $bolTerrallende=false;
                            $bolRasganorte=false;
                            $bolCataclysm=false;
                            $bolPandaria=false;
                            $bolDraenor=false;
                            $bolLegion=false;
                            $bolBfA=false;
                            break;
                          case ' Terrallende':
                            $bolClassic=false;
                            $bolTerrallende=true;
                            $bolRasganorte=false;
                            $bolCataclysm=false;
                            $bolPandaria=false;
                            $bolDraenor=false;
                            $bolLegion=false;
                            $bolBfA=false;
                            break;
                          case ' Rasganorte':
                            $bolClassic=false;
                            $bolTerrallende=false;
                            $bolRasganorte=true;
                            $bolCataclysm=false;
                            $bolPandaria=false;
                            $bolDraenor=false;
                            $bolLegion=false;
                            $bolBfA=false;
                            break;
                          case ' Cataclysm':
                            $bolClassic=false;
                            $bolTerrallende=false;
                            $bolRasganorte=false;
                            $bolCataclysm=true;
                            $bolPandaria=false;
                            $bolDraenor=false;
                            $bolLegion=false;
                            $bolBfA=false;
                            break;
                            case ' Cataclsym'://En la API tienen mal Cataclysm, así que añadimos los dos
                              $bolClassic=false;
                              $bolTerrallende=false;
                              $bolRasganorte=false;
                              $bolCataclysm=true;
                              $bolPandaria=false;
                              $bolDraenor=false;
                              $bolLegion=false;
                              $bolBfA=false;
                              break;
                          case ' Pandaria':
                            $bolClassic=false;
                            $bolTerrallende=false;
                            $bolRasganorte=false;
                            $bolCataclysm=false;
                            $bolPandaria=true;
                            $bolDraenor=false;
                            $bolLegion=false;
                            $bolBfA=false;
                            break;
                          case ' Draenor':
                            $bolClassic=false;
                            $bolTerrallende=false;
                            $bolRasganorte=false;
                            $bolCataclysm=false;
                            $bolPandaria=false;
                            $bolDraenor=true;
                            $bolLegion=false;
                            $bolBfA=false;
                            break;
                          case ' Legion':
                            $bolClassic=false;
                            $bolTerrallende=false;
                            $bolRasganorte=false;
                            $bolCataclysm=false;
                            $bolPandaria=false;
                            $bolDraenor=false;
                            $bolLegion=true;
                            $bolBfA=false;
                            break;
                          case ' Zandalari': //BfA Horda
                            $bolClassic=false;
                            $bolTerrallende=false;
                            $bolRasganorte=false;
                            $bolCataclysm=false;
                            $bolPandaria=false;
                            $bolDraenor=false;
                            $bolLegion=false;
                            $bolBfA=true;
                            break;
                          case ' Tiras':  //BfA Alianza
                            $bolClassic=false;
                            $bolTerrallende=false;
                            $bolRasganorte=false;
                            $bolCataclysm=false;
                            $bolPandaria=false;
                            $bolDraenor=false;
                            $bolLegion=false;
                            $bolBfA=true;
                            break;
                          default:

                        }

                        break;
                      case 'rank':
                        //Primarias
                        if($bolPrimaria){
                          if($bolClassic){
                            $profPrimariaValor = $value;
                          }else if($bolTerrallende){
                            $profPrimTerrallende = $value;
                          }else if($bolRasganorte){
                            $profPrimRasganorte = $value;
                          }else if($bolCataclysm){
                            $profPrimCataclysm = $value;
                          }else if($bolPandaria){
                            $profPrimPandaria = $value;
                          }else if($bolDraenor){
                            $profPrimDraenor = $value;
                          }else if($bolLegion){
                            $profPrimLegion = $value;
                          }else if($bolBfA){
                            $profPrimBfA = $value;
                          }
                        }else{
                          //Secundarias
                          if($bolClassic){
                            $profSecundariaValor = $value;
                          }else if($bolTerrallende){
                            $profSecTerrallende = $value;
                          }else if($bolRasganorte){
                            $profSecRasganorte = $value;
                          }else if($bolCataclysm){
                            $profSecCataclysm = $value;
                          }else if($bolPandaria){
                            $profSecPandaria = $value;
                          }else if($bolDraenor){
                            $profSecDraenor = $value;
                          }else if($bolLegion){
                            $profSecLegion = $value;
                          }else if($bolBfA){
                            $profSecBfA = $value;
                          }
                        }
                        break;
                    }
                  }//Fin foreach
                }
                break;
            }
          }
            break;
        }//FIN SWITCH ITEM->json
      }//FIN JSON
    }

    $resultado = $profPrimaria."|".
      $profPrimariaValor."|".
      $profPrimTerrallende."|".
      $profPrimRasganorte."|".
      $profPrimCataclysm."|".
      $profPrimPandaria."|".
      $profPrimDraenor."|".
      $profPrimLegion."|".
      $profSecBfA."|".
      $profSecundaria."|".
      $profSecundariaValor."|".
      $profSecTerrallende."|".
      $profSecRasganorte."|".
      $profSecCataclysm."|".
      $profSecPandaria."|".
      $profSecDraenor."|".
      $profSecLegion."|".
      $profSecBfA."|";
      return $resultado;

  }//FIN getProfesiones();

  /*
   *  Extrae los datos del equipo del personaje desde la API de Blizzard
   */
  function getEquipo($json){
    if($json == false){
      return false;
    }else{
      $ilvlTotal = 0;
      $yelmo = array();
      $cuello = array();
      $hombros = array();
      $espalda = array();
      $pecho = array();
      $tabardo = array();
      $brazos = array();
      $manos = array();
      $cinturon = array();
      $piernas = array();
      $pies = array();
      $anillo1 = array();
      $anillo2 = array();
      $trinket1 = array();
      $trinket2 = array();
      $manoDerecha = array();
      $manoIzquierda = array();

      foreach (json_decode($json) as $item => $value) {
        $id=0;
        $nombre="";
        $ilvl="";
        $icono="";
        $calidad="";
        switch ($item) {
            case 'items':
              foreach ($value as $key => $value) {
                switch ($key) {
                  case 'averageItemLevelEquipped':
                  //ILVL
                    $ilvlTotal = $value;
                    break;
                  //YELMO
                  case 'head':
                    foreach ($value as $key => $value){
                      switch ($key) {
                        case 'id':
                          $id= $value;
                          break;
                        case 'name':
                          $nombre=$value;
                          break;
                        case 'itemLevel':
                          $ilvl=$value;
                          break;
                        case 'quality':
                          $calidad=$value;
                          break;
                        case 'icon':
                          $icono=$value;
                          break;
                        //Faltan los poderes de azerita
                        default:
                          // code...
                          break;
                      }
                    }
                    $yelmo = [
                      'id' => $id,
                      'nombre' => $nombre,
                      'ilvl' => $ilvl,
                      'calidad' => $calidad,
                      'icono' => $icono
                    ];
                    break;//FIN YELMO
                  //CUELLO
                  case 'neck':
                    foreach ($value as $key => $value){
                      switch ($key) {
                        case 'id':
                          $id= $value;
                          break;
                        case 'name':
                          $nombre=$value;
                          break;
                        case 'itemLevel':
                          $ilvl=$value;
                          break;
                        case 'quality':
                          $calidad=$value;
                          break;
                        case 'icon':
                          $icono=$value;
                          break;
                        //Faltan los poderes de azerita
                        default:
                          // code...
                          break;
                      }
                    }
                    $cuello  = [
                      'id' => $id,
                      'nombre' => $nombre,
                      'ilvl' => $ilvl,
                      'calidad' => $calidad,
                      'icono' => $icono
                    ];
                    break;//FIN CUELLO
                    //HOMBROS
                    case 'shoulder':
                      foreach ($value as $key => $value){
                        switch ($key) {
                          case 'id':
                            $id= $value;
                            break;
                          case 'name':
                            $nombre=$value;
                            break;
                          case 'itemLevel':
                            $ilvl=$value;
                            break;
                          case 'quality':
                            $calidad=$value;
                            break;
                          case 'icon':
                            $icono=$value;
                            break;
                          //Faltan los poderes de azerita
                          default:
                            // code...
                            break;
                        }
                      }
                      $hombros   = [
                        'id' => $id,
                        'nombre' => $nombre,
                        'ilvl' => $ilvl,
                        'calidad' => $calidad,
                        'icono' => $icono
                      ];
                      break;//FIN HOMBROS
                    //ESPALDA
                    case 'back':
                      foreach ($value as $key => $value){
                        switch ($key) {
                          case 'id':
                            $id= $value;
                            break;
                          case 'name':
                            $nombre=$value;
                            break;
                          case 'itemLevel':
                            $ilvl=$value;
                            break;
                          case 'quality':
                            $calidad=$value;
                            break;
                          case 'icon':
                            $icono=$value;
                            break;
                          ///Faltan los poderes de azerita
                          default:
                            // code...
                            break;
                        }
                      }
                      $espalda = [
                        'id' => $id,
                        'nombre' => $nombre,
                        'ilvl' => $ilvl,
                        'calidad' => $calidad,
                        'icono' => $icono
                      ];
                      break;//FIN ESPALDA
                    //PECHO
                    case 'chest':
                      foreach ($value as $key => $value){
                        switch ($key) {
                          case 'id':
                            $id= $value;
                            break;
                          case 'name':
                            $nombre=$value;
                            break;
                          case 'itemLevel':
                            $ilvl=$value;
                            break;
                          case 'quality':
                            $calidad=$value;
                            break;
                          case 'icon':
                            $icono=$value;
                            break;
                          ///Faltan los poderes de azerita
                          default:
                            // code...
                            break;
                        }
                      }
                      $pecho = [
                        'id' => $id,
                        'nombre' => $nombre,
                        'ilvl' => $ilvl,
                        'calidad' => $calidad,
                        'icono' => $icono
                      ];
                      break;//FIN PECHO
                    //TABARDO
                    case 'tabard':
                      foreach ($value as $key => $value){
                        switch ($key) {
                          case 'id':
                            $id= $value;
                            break;
                          case 'name':
                            $nombre=$value;
                            break;
                          case 'itemLevel':
                            $ilvl=$value;
                            break;
                          case 'quality':
                            $calidad=$value;
                            break;
                          case 'icon':
                            $icono=$value;
                            break;
                          ///Faltan los poderes de azerita
                          default:
                            // code...
                            break;
                        }
                      }
                      $tabardo = [
                        'id' => $id,
                        'nombre' => $nombre,
                        'ilvl' => $ilvl,
                        'calidad' => $calidad,
                        'icono' => $icono
                      ];
                      break;//FIN TABARDO
                    //BRAZOS
                    case 'wrist':
                      foreach ($value as $key => $value){
                        switch ($key) {
                          case 'id':
                            $id= $value;
                            break;
                          case 'name':
                            $nombre=$value;
                            break;
                          case 'itemLevel':
                            $ilvl=$value;
                            break;
                          case 'quality':
                            $calidad=$value;
                            break;
                          case 'icon':
                            $icono=$value;
                            break;
                          ///Faltan los poderes de azerita
                          default:
                            // code...
                            break;
                        }
                      }
                      $brazos  = [
                        'id' => $id,
                        'nombre' => $nombre,
                        'ilvl' => $ilvl,
                        'calidad' => $calidad,
                        'icono' => $icono
                      ];
                      break;//FIN BRAZOS
                    //MANOS
                    case 'hands':
                      foreach ($value as $key => $value){
                        switch ($key) {
                          case 'id':
                            $id= $value;
                            break;
                          case 'name':
                            $nombre=$value;
                            break;
                          case 'itemLevel':
                            $ilvl=$value;
                            break;
                          case 'quality':
                            $calidad=$value;
                            break;
                          case 'icon':
                            $icono=$value;
                            break;
                          ///Faltan los poderes de azerita
                          default:
                            // code...
                            break;
                        }
                      }
                        $manos = [
                        'id' => $id,
                        'nombre' => $nombre,
                        'ilvl' => $ilvl,
                        'calidad' => $calidad,
                        'icono' => $icono
                      ];
                      break;//FIN MANOS
                    //CINTURON
                    case 'waist':
                      foreach ($value as $key => $value){
                        switch ($key) {
                          case 'id':
                            $id= $value;
                            break;
                          case 'name':
                            $nombre=$value;
                            break;
                          case 'itemLevel':
                            $ilvl=$value;
                            break;
                          case 'quality':
                            $calidad=$value;
                            break;
                          case 'icon':
                            $icono=$value;
                            break;
                          ///Faltan los poderes de azerita
                          default:
                            // code...
                            break;
                        }
                      }
                        $cinturon = [
                        'id' => $id,
                        'nombre' => $nombre,
                        'ilvl' => $ilvl,
                        'calidad' => $calidad,
                        'icono' => $icono
                      ];
                      break;//FIN CINTURON
                    //PIERNAS
                    case 'legs':
                      foreach ($value as $key => $value){
                        switch ($key) {
                          case 'id':
                            $id= $value;
                            break;
                          case 'name':
                            $nombre=$value;
                            break;
                          case 'itemLevel':
                            $ilvl=$value;
                            break;
                          case 'quality':
                            $calidad=$value;
                            break;
                          case 'icon':
                            $icono=$value;
                            break;
                          ///Faltan los poderes de azerita
                          default:
                            // code...
                            break;
                        }
                      }
                        $piernas  = [
                        'id' => $id,
                        'nombre' => $nombre,
                        'ilvl' => $ilvl,
                        'calidad' => $calidad,
                        'icono' => $icono
                      ];
                      break;//FIN PIERNAS
                    //PIES
                    case 'feet':
                      foreach ($value as $key => $value){
                        switch ($key) {
                          case 'id':
                            $id= $value;
                            break;
                          case 'name':
                            $nombre=$value;
                            break;
                          case 'itemLevel':
                            $ilvl=$value;
                            break;
                          case 'quality':
                            $calidad=$value;
                            break;
                          case 'icon':
                            $icono=$value;
                            break;
                          ///Faltan los poderes de azerita
                          default:
                            // code...
                            break;
                        }
                      }
                        $pies = [
                        'id' => $id,
                        'nombre' => $nombre,
                        'ilvl' => $ilvl,
                        'calidad' => $calidad,
                        'icono' => $icono
                      ];
                      break;//FIN PIES
                    //ANILLO1
                    case 'finger1':
                      foreach ($value as $key => $value){
                        switch ($key) {
                          case 'id':
                            $id= $value;
                            break;
                          case 'name':
                            $nombre=$value;
                            break;
                          case 'itemLevel':
                            $ilvl=$value;
                            break;
                          case 'quality':
                            $calidad=$value;
                            break;
                          case 'icon':
                            $icono=$value;
                            break;
                          ///Faltan los poderes de azerita
                          default:
                            // code...
                            break;
                        }
                      }
                        $anillo1  = [
                        'id' => $id,
                        'nombre' => $nombre,
                        'ilvl' => $ilvl,
                        'calidad' => $calidad,
                        'icono' => $icono
                      ];
                      break;//FIN ANILLO1
                    //ANILLO2
                    case 'finger2':
                      foreach ($value as $key => $value){
                        switch ($key) {
                          case 'id':
                            $id= $value;
                            break;
                          case 'name':
                            $nombre=$value;
                            break;
                          case 'itemLevel':
                            $ilvl=$value;
                            break;
                          case 'quality':
                            $calidad=$value;
                            break;
                          case 'icon':
                            $icono=$value;
                            break;
                          ///Faltan los poderes de azerita
                          default:
                            // code...
                            break;
                        }
                      }
                        $anillo2  = [
                        'id' => $id,
                        'nombre' => $nombre,
                        'ilvl' => $ilvl,
                        'calidad' => $calidad,
                        'icono' => $icono
                      ];
                      break;//FIN ANILLO2
                    //TRINKET1
                    case 'trinket1':
                      foreach ($value as $key => $value){
                        switch ($key) {
                          case 'id':
                            $id= $value;
                            break;
                          case 'name':
                            $nombre=$value;
                            break;
                          case 'itemLevel':
                            $ilvl=$value;
                            break;
                          case 'quality':
                            $calidad=$value;
                            break;
                          case 'icon':
                            $icono=$value;
                            break;
                          ///Faltan los poderes de azerita
                          default:
                            // code...
                            break;
                        }
                      }
                        $trinket1 = [
                        'id' => $id,
                        'nombre' => $nombre,
                        'ilvl' => $ilvl,
                        'calidad' => $calidad,
                        'icono' => $icono
                      ];
                      break;//FIN TRINKET1
                    //TRINKET2
                    case 'trinket2':
                      foreach ($value as $key => $value){
                        switch ($key) {
                          case 'id':
                            $id= $value;
                            break;
                          case 'name':
                            $nombre=$value;
                            break;
                          case 'itemLevel':
                            $ilvl=$value;
                            break;
                          case 'quality':
                            $calidad=$value;
                            break;
                          case 'icon':
                            $icono=$value;
                            break;
                          ///Faltan los poderes de azerita
                          default:
                            // code...
                            break;
                        }
                      }
                        $trinket2 = [
                        'id' => $id,
                        'nombre' => $nombre,
                        'ilvl' => $ilvl,
                        'calidad' => $calidad,
                        'icono' => $icono
                      ];
                      break;//FIN TRINKET2
                    //MANODERECHA
                    case 'mainHand':
                      foreach ($value as $key => $value){
                        switch ($key) {
                          case 'id':
                            $id= $value;
                            break;
                          case 'name':
                            $nombre=$value;
                            break;
                          case 'itemLevel':
                            $ilvl=$value;
                            break;
                          case 'quality':
                            $calidad=$value;
                            break;
                          case 'icon':
                            $icono=$value;
                            break;
                          ///Faltan los poderes de azerita
                          default:
                            // code...
                            break;
                        }
                      }
                        $manoDerecha  = [
                        'id' => $id,
                        'nombre' => $nombre,
                        'ilvl' => $ilvl,
                        'calidad' => $calidad,
                        'icono' => $icono
                      ];
                      break;//FIN MANODERECHA
                    //MANOIZQUIERDA
                    case 'offHand':
                      foreach ($value as $key => $value){
                        switch ($key) {
                          case 'id':
                            $id= $value;
                            break;
                          case 'name':
                            $nombre=$value;
                            break;
                          case 'itemLevel':
                            $ilvl=$value;
                            break;
                          case 'quality':
                            $calidad=$value;
                            break;
                          case 'icon':
                            $icono=$value;
                            break;
                          ///Faltan los poderes de azerita
                          default:
                            // code...
                            break;
                        }
                      }
                        $manoIzquierda = [
                        'id' => $id,
                        'nombre' => $nombre,
                        'ilvl' => $ilvl,
                        'calidad' => $calidad,
                        'icono' => $icono
                      ];
                      break;//FIN MANOIZQUIERDA
                }//FIN SWITCH
              }//FIN FOREACH ITEMS
              break;
        }//FIN SWITCH ITEM->json
      }//FIN JSON
    }
    $equipo = array();
    $equipo = [
      'ilvlTotal' => $ilvlTotal,
      'yelmo' => $yelmo,
      'cuello' => $cuello,
      'hombros' => $hombros,
      'espalda' => $espalda,
      'pecho' => $pecho,
      'tabardo' => $tabardo,
      'brazos' => $brazos,
      'manos' => $manos,
      'cinturon' => $cinturon,
      'piernas' => $piernas,
      'pies' => $pies,
      'anillo1' => $anillo1,
      'anillo2' => $anillo2,
      'trinket1' => $trinket1,
      'trinket2' => $trinket2,
      'manoDerecha' => $manoDerecha,
      'manoIzquierda' => $manoIzquierda
    ];
    return $equipo;
  }//FIN getEquipo();

  /*
   *  Extrae los datos básicos del personaje desde la API de Blizzard
   */
  function getHermandad($json){
    $hermandad="";
    if($json == false){
      return false;
    }else{
      foreach (json_decode($json) as $item => $value) {
        switch ($item) {
          case 'guild':
            foreach ($value as $key => $value) {
              switch ($key) {
                case 'name':
                  $hermandad=$value;
                  break;
              }
            }
            break;
        }//FIN SWITCH ITEM->json
      }//FIN JSON
    }
    return $hermandad;
  }//FIN getHermandad();

  function getReputacion($json,$faccion){
    $datosFaccion = array();

    if($json == false){
      return false;
    }else{
      foreach (json_decode($json) as $item => $value) {
        $nombre = "";
        $valor = "";
        $standing = "";
        $reputacion ="";
        $max = "";
        switch ($item) {
          case 'reputation':
            //Caidos de la noche:
            $llave = array_search($faccion, array_column($value, 'id'));
            foreach ($value[$llave] as $key => $value) {
              switch ($key) {
                case 'name':
                  $nombre = $value;
                  break;
                case 'value':
                  $valor = $value;
                  break;
                case 'standing':
                  $standing = $value;
                  break;
                case 'max':
                  $max = $value;
                  break;
              }
            }
            //Comprobamos el valor de $standing y lo asociamos a su grado de reputación
            switch ($standing) {
              case '0':
                $reputacion = "Odiado";
                break;
              case '2':
                $reputacion = "Adverso";
                break;
              case '3':
                $reputacion = "Neutral";
                break;
              case '4':
                $reputacion = "Amistoso";
                break;
              case '5':
                $reputacion = "Honorable";
                break;
              case '6':
                $reputacion = "Venerado";
                break;
              case '7':
                $reputacion = "Exaltado";
                break;
            }
            $datosFaccion=[$nombre,$valor,$reputacion,$max];
            break;
        }//FIN SWITCH ITEM->json
      }//FIN JSON
    }

    return $datosFaccion;

  }





?>
