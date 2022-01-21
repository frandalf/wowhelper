/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX *\
  Creación: 03-08-2018         |      Última modificación:  11-08-2018
  Autor: Francisco José Montero Campos - fran.montero.campos@gmail.com
  --------------------------------------------------------------------
  Objetivo:
  Funciones relacionadas con la gestión de talentos
\* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */

/*
  Función que colorea el botón seleccionado de la rama de talentos y muestra la info de la misma
*/
function selecTalento(botonTalento,maxTalentos,clase){
  //Sea cual sea el valor de botonTalento, mostramos el panel de talentos (talentos[0]) y el de pvp y azerita (talentos[5])
  document.getElementById("talentos0").classList.remove("oculto");
  document.getElementById("talentos5").classList.remove("oculto");
  //Limpiamos los botones de las ramas de talentos
  document.getElementById("botonTalento1").classList.remove("cajaNaranja");
  document.getElementById("botonTalento1").classList.add("caja");
  document.getElementById("botonTalento2").classList.remove("cajaNaranja");
  document.getElementById("botonTalento2").classList.add("caja");
  //ocultamos las botoneras de talentos
  document.getElementById("talentos1").classList.add("oculto");
  document.getElementById("talentos2").classList.add("oculto");
  if(maxTalentos>2){
    document.getElementById("botonTalento3").classList.remove("cajaNaranja");
    document.getElementById("botonTalento3").classList.add("caja");
    document.getElementById("talentos3").classList.add("oculto");
  }
  if(maxTalentos>3){
    document.getElementById("botonTalento4").classList.remove("cajaNaranja");
    document.getElementById("botonTalento4").classList.add("caja");
    document.getElementById("talentos4").classList.add("oculto");
  }
  //Limpiamos todos los botones de talento
  var elements = document.getElementsByClassName("cajaBotonTalento");
  for (var i = 0; i < elements.length; i++) {
    elements[i].classList.remove('cajaNaranja');
    elements[i].classList.add("caja");
  }
  //Limpiamos las cajoneras de botones de tipo
  var elements = document.getElementsByClassName("tipoTalento");
  for (var i = 0; i < elements.length; i++) {
    elements[i].classList.remove('cajaNaranja');
    elements[i].classList.add("caja");
  }

  //Coloreamos de naranja el botón de la rama de talentos pulsada
  switch(botonTalento) {
    case 1:
        document.getElementById("botonTalento1").classList.add("cajaNaranja");
        document.getElementById("botonTalento1").classList.remove("caja");
        document.getElementById("talentos1").classList.remove("oculto");
        break;
    case 2:
        document.getElementById("botonTalento2").classList.add("cajaNaranja");
        document.getElementById("botonTalento2").classList.remove("caja");
        document.getElementById("talentos2").classList.remove("oculto");
        break;
    case 3:
        document.getElementById("botonTalento3").classList.add("cajaNaranja");
        document.getElementById("botonTalento3").classList.remove("caja");
        document.getElementById("talentos3").classList.remove("oculto");
        break;
    case 4:
        document.getElementById("botonTalento4").classList.add("cajaNaranja");
        document.getElementById("botonTalento4").classList.remove("caja");
        document.getElementById("talentos4").classList.remove("oculto");
        break;
  }

  //Recuperamos los talentos de la clase y rama en particular
  var talentos = getTalClases(botonTalento,1,clase);
  //Mostramos las estadísticas
  document.getElementById("estadisticas").innerHTML = talentos[7];
  //Mostramos talentos pvp
  document.getElementById("talentoPvp2").innerHTML = "<i><a href='#' data-wh-icon-size='small' data-wowhead='spell="+talentos[8]+" domain=es'>"+talentos[11]+"</a></i>";
  document.getElementById("talentoPvp3").innerHTML = "<i><a href='#' data-wh-icon-size='small' data-wowhead='spell="+talentos[9]+" domain=es'>"+talentos[12]+"</a></i>";
  document.getElementById("talentoPvp4").innerHTML = "<i><a href='#' data-wh-icon-size='small' data-wowhead='spell="+talentos[10]+" domain=es'>"+talentos[13]+"</a></i>";
}//Fin selecTalento()

/*
  Función para seleccionar el tipo de talento (normal, míticas, raid, pvp)
*/
function selecTipoTalento(ramaTalentos,botonPulsado,clase){
  //el id de tipoTalento puede ser tipoTalento11,tipoTalento12,tipoTalento13,tipoTalento14,tipoTalento21,etc., por lo que lo metemos en variable para ahorra código
  var idTalento ="tipoTalento"+ramaTalentos;
  //Limpiamos todas los botones de talentos
  document.getElementById(idTalento+"1").classList.remove("cajaNaranja");
  document.getElementById(idTalento+"2").classList.remove("cajaNaranja");
  document.getElementById(idTalento+"3").classList.remove("cajaNaranja");
  document.getElementById(idTalento+"4").classList.remove("cajaNaranja");
  document.getElementById(idTalento+"1").classList.add("caja");
  document.getElementById(idTalento+"2").classList.add("caja");
  document.getElementById(idTalento+"3").classList.add("caja");
  document.getElementById(idTalento+"4").classList.add("caja");
  //Coloreamos el botón de talento pulsado
  switch(botonPulsado){
    case 1:
      document.getElementById(idTalento+"1").classList.add("cajaNaranja");
      document.getElementById(idTalento+"1").classList.remove("caja");
      break;
    case 2:
      document.getElementById(idTalento+"2").classList.add("cajaNaranja");
      document.getElementById(idTalento+"2").classList.remove("caja");
      break;
    case 3:
      document.getElementById(idTalento+"3").classList.add("cajaNaranja");
      document.getElementById(idTalento+"3").classList.remove("caja");
      break;
    case 4:
      document.getElementById(idTalento+"4").classList.add("cajaNaranja");
      document.getElementById(idTalento+"4").classList.remove("caja");
      break;
  }
  //Recuperamos los talentos de la clase y rama en particular
  var talentos = getTalClases(ramaTalentos,botonPulsado,clase);
  //Mostramos las estadísticas
  //document.getElementById("estadisticas").innerHTML = talentos[7];
  //Rellenamos los talentos
  pintarRamaTalentos11(talentos[0],talentos[1],talentos[2],talentos[3],talentos[4],talentos[5],talentos[6],ramaTalentos);
}//Fin selecTipoTalento()


/*
  Función para pintar los talentos seleccionados
*/
function pintarRamaTalentos11(tal1,tal2,tal3,tal4,tal5,tal6,tal7,ramaTalento){
  //Limpiamos todos los botones de talento
  var elements = document.getElementsByClassName("cajaBotonTalento");
  for (var i = 0; i < elements.length; i++) {
    elements[i].classList.remove('cajaNaranja');
    elements[i].classList.add("caja");
  }
  //seleccionamos la rama de talentos
  var ramaTal ="talento"+ramaTalento;
  //Pintamos de naranja sólo el seleccionado
  switch(tal1){
    case 1:
      document.getElementById("talento11").classList.add("cajaNaranja");
      document.getElementById("talento11").classList.remove("caja");
      break;
    case 2:
      document.getElementById("talento12").classList.add("cajaNaranja");
      document.getElementById("talento12").classList.remove("caja");
      break;
    case 3:
      document.getElementById("talento13").classList.add("cajaNaranja");
      document.getElementById("talento13").classList.remove("caja");
      break;
  }
  switch(tal2){
    case 1:
      document.getElementById("talento21").classList.add("cajaNaranja");
      document.getElementById("talento21").classList.remove("caja");
      break;
    case 2:
      document.getElementById("talento22").classList.add("cajaNaranja");
      document.getElementById("talento22").classList.remove("caja");
      break;
    case 3:
      document.getElementById("talento23").classList.add("cajaNaranja");
      document.getElementById("talento23").classList.remove("caja");
      break;
  }
  switch(tal3){
    case 1:
      document.getElementById("talento31").classList.add("cajaNaranja");
      document.getElementById("talento31").classList.remove("caja");
      break;
    case 2:
      document.getElementById("talento32").classList.add("cajaNaranja");
      document.getElementById("talento32").classList.remove("caja");
      break;
    case 3:
      document.getElementById("talento33").classList.add("cajaNaranja");
      document.getElementById("talento33").classList.remove("caja");
      break;
  }
  switch(tal4){
    case 1:
      document.getElementById("talento41").classList.add("cajaNaranja");
      document.getElementById("talento41").classList.remove("caja");
      break;
    case 2:
      document.getElementById("talento42").classList.add("cajaNaranja");
      document.getElementById("talento42").classList.remove("caja");
      break;
    case 3:
      document.getElementById("talento43").classList.add("cajaNaranja");
      document.getElementById("talento43").classList.remove("caja");
      break;
  }
  switch(tal5){
    case 1:
      document.getElementById("talento51").classList.add("cajaNaranja");
      document.getElementById("talento51").classList.remove("caja");
      break;
    case 2:
      document.getElementById("talento52").classList.add("cajaNaranja");
      document.getElementById("talento52").classList.remove("caja");
      break;
    case 3:
      document.getElementById("talento53").classList.add("cajaNaranja");
      document.getElementById("talento53").classList.remove("caja");
      break;
  }
  switch(tal6){
    case 1:
      document.getElementById("talento61").classList.add("cajaNaranja");
      document.getElementById("talento61").classList.remove("caja");
      break;
    case 2:
      document.getElementById("talento62").classList.add("cajaNaranja");
      document.getElementById("talento62").classList.remove("caja");
      break;
    case 3:
      document.getElementById("talento63").classList.add("cajaNaranja");
      document.getElementById("talento63").classList.remove("caja");
      break;
  }
  switch(tal7){
    case 1:
      document.getElementById("talento71").classList.add("cajaNaranja");
      document.getElementById("talento71").classList.remove("caja");
      break;
    case 2:
      document.getElementById("talento72").classList.add("cajaNaranja");
      document.getElementById("talento72").classList.remove("caja");
      break;
    case 3:
      document.getElementById("talento73").classList.add("cajaNaranja");
      document.getElementById("talento73").classList.remove("caja");
      break;
  }

}

/* FUNCIONES DE CLASE*/
function getTalClases(rama,tipo,clase){
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
  switch(clase){
    case 1:
    switch(rama){
      case 1://Armas
        switch(tipo){
          case 1://Normal
            var talentos = [2,1,2,1,3,1,2,"Crítico > Celeridad > Fuerza > Versatilidad > Maestría", 198807,236308,198817,"Sombra del Coloso","Tormenta de destrucción","Hoja afilada"];
            return talentos;
            break;
          case 2://Míticas
            var talentos = [1,1,2,2,1,3,2,"Crítico > Celeridad > Fuerza > Versatilidad > Maestría", 198807,236308,198817,"Sombra del Coloso","Tormenta de destrucción","Hoja afilada"];
            return talentos;
            break;
          case 3://Raid
            var talentos = [2,1,2,2,1,2,2,"Crítico > Celeridad > Fuerza > Versatilidad > Maestría", 198807,236308,198817,"Sombra del Coloso","Tormenta de destrucción","Hoja afilada"];
            return talentos;
            break;
          case 4://PVP
            var talentos = [2,3,3,3,1,1,2,"Crítico > Celeridad > Fuerza > Versatilidad > Maestría", 198807,236308,198817,"Sombra del Coloso","Tormenta de destrucción","Hoja afilada"];
            return talentos;
            break;
        }
        break;
      case 2://Furia
        switch(tipo){
          case 1://Normal
            var talentos = [3,1,2,2,1,2,1,"Crítico > Celeridad > Fuerza > Versatilidad > Maestría",280745,198877,280747,"Bárbaro","Ira duradera","Matadero"];
            return talentos;
            break;
          case 2://Míticas
            var talentos = [1,1,2,3,1,3,2,"Crítico > Celeridad > Fuerza > Versatilidad > Maestría",280745,198877,280747,"Bárbaro","Ira duradera","Matadero"];
            return talentos;
            break;
          case 3://Raid
            var talentos = [2,1,3,3,1,2,2,"Crítico > Celeridad > Fuerza > Versatilidad > Maestría",280745,198877,280747,"Bárbaro","Ira duradera","Matadero"];
            return talentos;
            break;
          case 4://PVP
            var talentos = [3,1,2,2,1,2,1,"Crítico > Celeridad > Fuerza > Versatilidad > Maestría",280745,198877,280747,"Bárbaro","Ira duradera","Matadero"];
            return talentos;
            break;
        }
        break;
      case 3://Protección
        switch(tipo){
          case 1://Normal
            var talentos = [1,2,2,3,2,1,1,"Celeridad > Maestría > Versatilidad > Crítico",198912,199023,199127,"Azote de escudo","Moralicida","Escudo y espada"];
            return talentos;
            break;
          case 2://Míticas
            var talentos = [1,2,2,3,2,1,1,"Celeridad > Maestría > Versatilidad > Crítico",198912,199023,199127,"Azote de escudo","Moralicida","Escudo y espada"];
            return talentos;
            break;
          case 3://Raid
            var talentos = [1,2,2,3,2,1,1,"Celeridad > Maestría > Versatilidad > Crítico",198912,199023,199127,"Azote de escudo","Moralicida","Escudo y espada"];
            return talentos;
            break;
          case 4://PVP
            var talentos = [1,2,2,3,2,1,1,"Celeridad > Maestría > Versatilidad > Crítico",198912,199023,199127,"Azote de escudo","Moralicida","Escudo y espada"];
            return talentos;
            break;
        }
        break;
      }
      break;

    case 2: //Paladin
      switch(rama){
        case 1://Sagrado
          switch(tipo){
            case 1://Normal
              var talentos = [1,2,2,1,3,2,3,"Intelecto > Crítico > Maestría = Versatilidad > Celeridad", 216327,199441,210294,"Gracia de la luz","Luz vengadora","Favor divino"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [1,2,2,1,3,2,3,"Intelecto > Crítico > Maestría = Versatilidad > Celeridad", 216327,199441,210294,"Gracia de la luz","Luz vengadora","Favor divino"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [2,3,3,1,1,2,2,"Intelecto > Crítico > Maestría = Versatilidad > Celeridad", 216327,199441,210294,"Gracia de la luz","Luz vengadora","Favor divino"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [1,3,1,1,3,1,3,"Intelecto > Crítico > Maestría = Versatilidad > Celeridad", 216327,199441,210294,"Gracia de la luz","Luz vengadora","Favor divino"];
              return talentos;
              break;
          }
          break;
        case 2://Protección
          switch(tipo){
            case 1://Normal
              var talentos = [1,2,1,2,3,1,2,"Celeridad > Maestría > Versatilidad > Crítico",210341,199542,199325,"Guerrero de la luz","Corcel de gloria","Libertad sin límites"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [1,2,1,2,3,1,2,"Celeridad > Maestría > Versatilidad > Crítico",210341,199542,199325,"Guerrero de la luz","Corcel de gloria","Libertad sin límites"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [1,2,1,2,3,1,2,"Celeridad > Maestría > Versatilidad > Crítico",210341,199542,199325,"Guerrero de la luz","Corcel de gloria","Libertad sin límites"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [1,2,1,2,3,1,2,"Celeridad > Maestría > Versatilidad > Crítico",210341,199542,199325,"Guerrero de la luz","Corcel de gloria","Libertad sin límites"];
              return talentos;
              break;
          }
          break;
        case 3://Reprensión
          switch(tipo){
            case 1://Normal
              var talentos = [2,3,3,3,2,2,2,"Fuerza > Celeridad > Crítico = Versatilidad = Maestría",247675,204914,246806,"Martillo del juicio", "Castigador divino", "Justiciero"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [2,3,3,3,2,2,2,"Fuerza > Celeridad > Crítico = Versatilidad = Maestría",247675,204914,246806,"Martillo del juicio", "Castigador divino", "Justiciero"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [2,3,3,3,2,2,2,"Fuerza > Celeridad > Crítico = Versatilidad = Maestría",247675,204914,246806,"Martillo del juicio", "Castigador divino", "Justiciero"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [2,3,3,3,2,2,2,"Fuerza > Celeridad > Crítico = Versatilidad = Maestría",247675,204914,246806,"Martillo del juicio", "Castigador divino", "Justiciero"];
              return talentos;
              break;
          }
          break;
      }
      break;
    case 3: //cazador
      switch(rama){
        case 1://Bestias
          switch(tipo){
            case 1://Normal
              var talentos = [1,3,3,3,2,2,1,"Agilidad > Celeridad > Crítico > Maestría > Versatilidad", 204190,208652,212668,"Protector salvaje","Bestia temible: halcón","Bestia interna"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [1,3,2,3,2,1,1,"Agilidad > Celeridad > Crítico > Maestría > Versatilidad", 204190,208652,212668,"Protector salvaje","Bestia temible: halcón","Bestia interna"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [1,3,2,3,2,1,1,"Agilidad > Celeridad > Crítico > Maestría > Versatilidad", 204190,208652,212668,"Protector salvaje","Bestia temible: halcón","Bestia interna"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [1,3,3,3,2,2,1,"Agilidad > Celeridad > Crítico > Maestría > Versatilidad", 204190,208652,212668,"Protector salvaje","Bestia temible: halcón","Bestia interna"];
              return talentos;
              break;
          }
          break;
        case 2://Puntería
          switch(tipo){
            case 1://Normal
              var talentos = [3,3,1,2,1,2,2,"Agilidad > Maestría > Versatilidad = Celeridad > Crítico", 203155,203129,248443,"Disparo de francotirador","Maestría de Disparo certero","Finura de forestal"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [1,3,2,2,2,3,2,"Agilidad > Maestría > Versatilidad = Celeridad > Crítico", 203155,203129,248443,"Disparo de francotirador","Maestría de Disparo certero","Finura de forestal"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [3,1,2,3,2,1,2,"Agilidad > Maestría > Versatilidad = Celeridad > Crítico", 203155,203129,248443,"Disparo de francotirador","Maestría de Disparo certero","Finura de forestal"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [3,3,1,2,1,2,2,"Agilidad > Maestría > Versatilidad = Celeridad > Crítico", 203155,203129,248443,"Disparo de francotirador","Maestría de Disparo certero","Finura de forestal"];
              return talentos;
              break;
        }
          break;
        case 3://Supervivencia
          switch(tipo){
            case 1://Normal
              var talentos = [1,1,2,1,2,1,1,"Agilidad > Celeridad > Versatilidad > Crítico > Maestría", 203264,202589,202746,"Alquitrán pegajoso","Armadura de dragontina","Tácticas de supervivencial"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [1,1,2,1,2,1,1,"Agilidad > Celeridad > Versatilidad > Crítico > Maestría", 203264,202589,202746,"Alquitrán pegajoso","Armadura de dragontina","Tácticas de supervivencial"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [1,1,2,1,2,1,1,"Agilidad > Celeridad > Versatilidad > Crítico > Maestría", 203264,202589,202746,"Alquitrán pegajoso","Armadura de dragontina","Tácticas de supervivencial"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [1,1,2,1,2,1,1,"Agilidad > Celeridad > Versatilidad > Crítico > Maestría", 203264,202589,202746,"Alquitrán pegajoso","Armadura de dragontina","Tácticas de supervivencial"];
              return talentos;
              break;
            }
      }
      break;
    case 4: //Rogue
      switch(rama){
        case 1://Asesinato
          switch(tipo){
            case 1://Normal
              var talentos = [2,2,1,2,1,2,1,"Agilidad > Celeridad > Crítico > Maestría > Versatilidad", 198145,198092,198128,"Reacción del sistema","Veneno acechante","Dagas voladoras"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [2,2,1,2,1,2,1,"Agilidad > Celeridad > Crítico > Maestría > Versatilidad", 198145,198092,198128,"Reacción del sistema","Veneno acechante","Dagas voladoras"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [2,2,1,2,1,2,1,"Agilidad > Celeridad > Crítico > Maestría > Versatilidad", 198145,198092,198128,"Reacción del sistema","Veneno acechante","Dagas voladoras"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [2,2,1,2,1,2,1,"Agilidad > Celeridad > Crítico > Maestría > Versatilidad", 198145,198092,198128,"Reacción del sistema","Veneno acechante","Dagas voladoras"];
              return talentos;
              break;
          }
          break;
        case 2://Forajido
          switch(tipo){
            case 1://Normal
              var talentos = [2,1,1,2,3,2,2,"Agilidad > Versatilidad = Celeridad > Crítico >> Maestría", 198265,198529,209752,"Sacar tajada","Armadura de saqueo","Grupo de abordaje"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [2,1,1,2,3,2,2,"Agilidad > Versatilidad = Celeridad > Crítico >> Maestría", 198265,198529,209752,"Sacar tajada","Armadura de saqueo","Grupo de abordaje"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [2,1,1,2,3,2,2,"Agilidad > Versatilidad = Celeridad > Crítico >> Maestría", 198265,198529,209752,"Sacar tajada","Armadura de saqueo","Grupo de abordaje"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [2,1,1,2,3,2,2,"Agilidad > Versatilidad = Celeridad > Crítico >> Maestría", 198265,198529,209752,"Sacar tajada","Armadura de saqueo","Grupo de abordaje"];
              return talentos;
              break;
        }
          break;
        case 3://Sutileza
          switch(tipo){
            case 1://Normal
              var talentos = [2,2,3,1,1,3,1,"Agilidad > Crítico > Maestría > Celeridad > Versatilidad", 216883,213981,198032,"Asesino fantasma","Sangre fría","Honor entre ladrones"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [2,3,2,2,3,1,2,"Agilidad > Crítico > Maestría > Celeridad > Versatilidad", 216883,213981,198032,"Asesino fantasma","Sangre fría","Honor entre ladrones"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [2,3,3,2,3,3,1,"Agilidad > Crítico > Maestría > Celeridad > Versatilidad", 216883,213981,198032,"Asesino fantasma","Sangre fría","Honor entre ladrones"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [2,3,3,2,3,3,1,"Agilidad > Crítico > Maestría > Celeridad > Versatilidad", 216883,213981,198032,"Asesino fantasma","Sangre fría","Honor entre ladrones"];
              return talentos;
              break;
            }
      }
      break;
    case 5: //Priest
      switch(rama){
        case 1://Disciplina
          switch(tipo){
            case 1://Normal
              var talentos = [3,3,3,1,1,2,3,"Intelecto > Celeridad > Crítico > Maestría > Versatilidad", 214205,215768,197871,"Trinidad","Luz abrasadora","Arcángel oscuro"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [2,3,3,2,3,2,3,"Intelecto > Celeridad > Crítico > Maestría > Versatilidad", 214205,215768,197871,"Trinidad","Luz abrasadora","Arcángel oscuro"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [2,3,3,3,1,3,1,"Intelecto > Celeridad > Crítico > Maestría > Versatilidad", 214205,215768,197871,"Trinidad","Luz abrasadora","Arcángel oscuro"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [3,3,3,1,1,2,3,"Intelecto > Celeridad > Crítico > Maestría > Versatilidad", 214205,215768,197871,"Trinidad","Luz abrasadora","Arcángel oscuro"];
              return talentos;
              break;
          }
          break;
        case 2://Sagrado
          switch(tipo){
            case 1://Normal
              var talentos = [2,3,1,2,1,1,2,"Intelecto > Maestría > Crítico > Celeridad >> Versatilidad", 196985,265202,34861,"Luz de los naaru","Palabra sagrada: salvación","Palabra sagrada: santificar"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [2,3,1,2,1,1,2,"Intelecto > Maestría > Crítico > Celeridad >> Versatilidad", 196985,265202,34861,"Luz de los naaru","Palabra sagrada: salvación","Palabra sagrada: santificar"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [1,3,1,1,2,1,3,"Intelecto > Maestría > Crítico > Celeridad >> Versatilidad", 196985,265202,34861,"Luz de los naaru","Palabra sagrada: salvación","Palabra sagrada: santificar"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [2,3,1,2,1,1,2,"Intelecto > Maestría > Crítico > Celeridad >> Versatilidad", 196985,265202,34861,"Luz de los naaru","Palabra sagrada: salvación","Palabra sagrada: santificar"];
              return talentos;
              break;
        }
          break;
        case 3://Sombras
          switch(tipo){
            case 1://Normal
              var talentos = [3,1,2,3,3,2,1,"Intelecto > Crítico > Celeridad > Maestría >= Versatilidad", 211522,199484,228630,"Maligno psíquico","Vínculo psíquico","Orígenes del Vacío"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [3,1,3,1,3,2,1,"Intelecto > Crítico > Celeridad > Maestría >= Versatilidad", 211522,199484,228630,"Maligno psíquico","Vínculo psíquico","Orígenes del Vacío"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [3,1,2,1,3,2,1,"Intelecto > Crítico > Celeridad > Maestría >= Versatilidad", 211522,199484,228630,"Maligno psíquico","Vínculo psíquico","Orígenes del Vacío"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [3,1,2,3,3,2,1,"Intelecto > Crítico > Celeridad > Maestría >= Versatilidad", 211522,199484,228630,"Maligno psíquico","Vínculo psíquico","Orígenes del Vacío"];
              return talentos;
              break;
            }
      }
      break;
    case 6: //DK
      switch(rama){
        case 1://Sangre
          switch(tipo){
            case 1://Normal
              var talentos = [2,2,2,1,1,2,2,"Agilidad > Celeridad > Crítico > Maestría > Versatilidad", 233411,233412,202727,"Sangre por sangre","Último baile","Orden profana"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [2,2,2,1,1,2,2,"Agilidad > Celeridad > Crítico > Maestría > Versatilidad", 233411,233412,202727,"Sangre por sangre","Último baile","Orden profana"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [2,2,2,1,1,2,2,"Agilidad > Celeridad > Crítico > Maestría > Versatilidad", 233411,233412,202727,"Sangre por sangre","Último baile","Orden profana"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [2,2,2,1,1,2,2,"Agilidad > Celeridad > Crítico > Maestría > Versatilidad", 233411,233412,202727,"Sangre por sangre","Último baile","Orden profana"];
              return talentos;
              break;
          }
          break;
        case 2://Hielo
          switch(tipo){
            case 1://Normal
              var talentos = [3,1,1,2,2,1,3,"Fuerza > Maestría = Crítico = Celeridad = Versatilidad", 199720,199642,233394,"Aura de descomposición","Aura necrótica","Arma de runas abrumadora"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [3,1,1,3,3,3,3,"Fuerza > Maestría = Crítico = Celeridad = Versatilidad", 199720,199642,233394,"Aura de descomposición","Aura necrótica","Arma de runas abrumadora"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [2,1,2,2,3,1,3,"Fuerza > Maestría = Crítico = Celeridad = Versatilidad", 199720,199642,233394,"Aura de descomposición","Aura necrótica","Arma de runas abrumadora"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [3,1,1,2,2,1,3,"Fuerza > Maestría = Crítico = Celeridad = Versatilidad", 199720,199642,233394,"Aura de descomposición","Aura necrótica","Arma de runas abrumadora"];
              return talentos;
              break;
        }
          break;
        case 3://Profano
          switch(tipo){
            case 1://Normal
              var talentos = [1,2,1,1,1,1,2,"Fuerza > Crítico = Versatilidad > Maestría > Celeridad", 199725,199724,199722,"Peste vagante","Pandemia","Fiebre de la cripta"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [2,3,2,2,3,1,2,"Fuerza > Crítico = Versatilidad > Maestría > Celeridad", 199725,199724,199722,"Peste vagante","Pandemia","Fiebre de la cripta"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [2,3,3,2,3,3,1,"Fuerza > Crítico = Versatilidad > Maestría > Celeridad", 199725,199724,199722,"Peste vagante","Pandemia","Fiebre de la cripta"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [2,3,3,2,3,3,1,"Fuerza > Crítico = Versatilidad > Maestría > Celeridad", 199725,199724,199722,"Peste vagante","Pandemia","Fiebre de la cripta"];
              return talentos;
              break;
            }
      }
      break;
    case 7: //Chaman
      switch(rama){
        case 1://Elemental
          switch(tipo){
            case 1://Normal
              var talentos = [2,1,1,1,1,1,1,"Intelecto > Crítico > Celeridad = Versatilidad = Maestría", 204330,204264,204385,"Tótem Furia del cielo","Olas henchidas","Armonización elemental"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [3,3,1,1,1,2,2,"Intelecto > Celeridad = Crítico > Versatilidad = Maestría", 204330,204264,204385,"Tótem Furia del cielo","Olas henchidas","Armonización elemental"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [1,3,1,1,1,2,1,"Intelecto > Celeridad = Crítico > Versatilidad = Maestría", 204330,204264,204385,"Tótem Furia del cielo","Olas henchidas","Armonización elemental"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [2,1,1,1,1,1,1,"Intelecto > Crítico > Celeridad = Versatilidad = Maestría", 204330,204264,204385,"Tótem Furia del cielo","Olas henchidas","Armonización elemental"];
              return talentos;
              break;
          }
          break;
        case 2://Mejora
          switch(tipo){
            case 1://Normal
              var talentos = [3,2,3,1,2,3,1,"Agilidad > Celeridad > Crítico = Versatilidad >> Maestría", 204357,204349,193876,"A lomos del relámpago","Relámpago bifurcado","Chamanismo"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [3,2,3,1,2,3,1,"Agilidad > Celeridad > Crítico = Versatilidad >> Maestría", 204357,204349,193876,"A lomos del relámpago","Relámpago bifurcado","Chamanismo"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [3,1,3,1,2,3,2,"Agilidad > Celeridad > Crítico = Versatilidad >> Maestría", 204357,204349,193876,"A lomos del relámpago","Relámpago bifurcado","Chamanismo"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [3,2,3,1,2,3,1,"Agilidad > Celeridad > Crítico = Versatilidad >> Maestría", 204357,204349,193876,"A lomos del relámpago","Relámpago bifurcado","Chamanismo"];
              return talentos;
              break;
        }
          break;
        case 3://Restauración
          switch(tipo){
            case 1://Normal
              var talentos = [2,3,1,1,1,1,3,"Intelecto > Crítico > Versatilidad > Celeridad = Maestría", 204330,204269,204331,"Tótem Furia del cielo","Aguas ondulantes","Tótem de Golpe de contraataque"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [2,3,1,1,1,1,3,"Intelecto > Crítico > Versatilidad > Celeridad = Maestría", 204330,204269,204331,"Tótem Furia del cielo","Aguas ondulantes","Tótem de Golpe de contraataque"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [1,1,1,1,1,2,1,"Intelecto > Crítico > Versatilidad > Celeridad = Maestría", 204330,204269,204331,"Tótem Furia del cielo","Aguas ondulantes","Tótem de Golpe de contraataque"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [2,3,1,1,1,1,3,"Intelecto > Crítico > Versatilidad > Celeridad = Maestría", 204330,204269,204331,"Tótem Furia del cielo","Aguas ondulantes","Tótem de Golpe de contraataque"];
              return talentos;
              break;
            }
      }
      break;
    case 8: //Mago
      switch(rama){
        case 1://Arcano
          switch(tipo){
            case 1://Normal
              var talentos = [2,1,2,1,2,1,3,"Intelecto > Versatilidad = Crítico = Celeridad > Maestría", 276741,198151,198111,"Potenciación Arcana","Tormento a los débiles","Escudo temporal"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [2,2,1,2,1,2,2,"Intelecto > Versatilidad = Crítico = Celeridad > Maestría", 276741,198151,198111,"Potenciación Arcana","Tormento a los débiles","Escudo temporal"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [2,2,1,2,1,2,1,"Intelecto > Versatilidad = Crítico = Celeridad > Maestría", 276741,198151,198111,"Potenciación Arcana","Tormento a los débiles","Escudo temporal"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [2,2,1,2,1,2,1,"Intelecto > Versatilidad = Crítico = Celeridad > Maestría", 276741,198151,198111,"Potenciación Arcana","Tormento a los débiles","Escudo temporal"];
              return talentos;
              break;
          }
          break;
        case 2://Fuego
          switch(tipo){
            case 1://Normal
              var talentos = [1,2,1,1,2,2,3,"Intelecto > Crítico > Maestría > Versatilidad = Celeridad", 203283,203275,198111,"Acelerador de ignición","Yesca","Escudo temporal"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [3,2,3,2,1,3,2,"Intelecto > Crítico > Maestría > Versatilidad = Celeridad", 203283,203275,198111,"Acelerador de ignición","Yesca","Escudo temporal"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [1,2,3,1,1,2,2,"Intelecto > Crítico > Maestría > Versatilidad = Celeridad", 203283,203275,198111,"Acelerador de ignición","Yesca","Escudo temporal"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [1,2,1,1,2,2,3,"Intelecto > Crítico > Maestría > Versatilidad = Celeridad", 203283,203275,198111,"Acelerador de ignición","Yesca","Escudo temporal"];
              return talentos;
              break;
        }
          break;
        case 3://Hielo
          switch(tipo){
            case 1://Normal
              var talentos = [3,2,1,3,2,2,3,"Int. > Crít(33%) > Vers. > Cel. > Maestría > Crit(>33%)", 206431,198120,198064,"Ráfaga de frío","Congelamiento","Capa centelleante"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [1,2,1,3,1,2,2,"Int. > Crít(33%) > Vers. > Cel. > Maestría > Crit(>33%)", 206431,198120,198064,"Ráfaga de frío","Congelamiento","Capa centelleante"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [1,2,1,3,1,2,2,"Int. > Crít(33%) > Vers. > Cel. > Maestría > Crit(>33%)", 206431,198120,198064,"Ráfaga de frío","Congelamiento","Capa centelleante"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [3,2,1,3,2,2,3,"Int. > Crít(33%) > Vers. > Cel. > Maestría > Crit(>33%)", 206431,198120,198064,"Ráfaga de frío","Congelamiento","Capa centelleante"];
              return talentos;
              break;
            }
      }
      break;
    case 9: //Brujo
      switch(rama){
        case 1://Afflicción
          switch(tipo){
            case 1://Normal
              var talentos = [3,2,2,1,2,2,2,"Int. > Poder de hechizo > Cel. = Maest. > Crit. > Vers.", 213400,212371,221711,"Aflicción infinita","Putrefacción y descomposición","Drenaje de esencia"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [3,2,3,2,1,2,2,"Int. > Poder de hechizo > Cel. = Maest. > Crit. > Vers.", 213400,212371,221711,"Aflicción infinita","Putrefacción y descomposición","Drenaje de esencia"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [3,3,3,2,3,2,2,"Int. > Poder de hechizo > Cel. = Maest. > Crit. > Vers.", 213400,212371,221711,"Aflicción infinita","Putrefacción y descomposición","Drenaje de esencia"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [3,2,2,1,2,2,2,"Int. > Poder de hechizo > Cel. = Maest. > Crit. > Vers.", 213400,212371,221711,"Aflicción infinita","Putrefacción y descomposición","Drenaje de esencia"];
              return talentos;
              break;
          }
          break;
        case 2://Demonología
          switch(tipo){
            case 1://Normal
              var talentos = [2,2,2,2,1,3,1,"Intelecto > Celeridad > Maestría > Crítico = Versatilidad", 212295,212619,212628,"Resguardo abisal","Llamar a manáfago","Maestro invocador"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [2,1,3,2,1,1,1,"Intelecto > Celeridad > Maestría > Crítico = Versatilidad", 212295,212619,212628,"Resguardo abisal","Llamar a manáfago","Maestro invocador"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [2,1,1,3,3,2,1,"Intelecto > Celeridad > Maestría > Crítico = Versatilidad", 212295,212619,212628,"Resguardo abisal","Llamar a manáfago","Maestro invocador"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [2,2,2,2,1,3,1,"Intelecto > Celeridad > Maestría > Crítico = Versatilidad", 212295,212619,212628,"Resguardo abisal","Llamar a manáfago","Maestro invocador"];
              return talentos;
              break;
        }
          break;
        case 3://Destrucción
          switch(tipo){
            case 1://Normal
              var talentos = [1,1,2,3,2,1,2,"Celeridad = Crítico > Versatilidad > Maestría > Intelecto", 233577,212282,200586,"Caos enfocado","Cremación","Fisura vil"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [1,1,2,3,1,3,2,"Celeridad = Crítico > Versatilidad > Maestría > Intelecto", 233577,212282,200586,"Caos enfocado","Cremación","Fisura vil"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [2,2,3,3,3,2,3,"Celeridad = Crítico > Versatilidad > Maestría > Intelecto", 233577,212282,200586,"Caos enfocado","Cremación","Fisura vil"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [1,1,2,3,2,1,2,"Celeridad = Crítico > Versatilidad > Maestría > Intelecto", 233577,212282,200586,"Caos enfocado","Cremación","Fisura vil"];
              return talentos;
              break;
            }
      }
      break;
    case 10: //Monje
      switch(rama){
        case 1://Maestro cervecero
          switch(tipo){
            case 1://Normal
              var talentos = [3,3,3,2,2,2,3,"Agilidad = Crítico > Versatilidad > Maestría >> Celeridad", 202335,202272,232876,"Barril doble","Aliento incendiario","Esencia de Niuzao"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [3,3,3,1,2,2,1,"Agilidad = Crítico > Versatilidad > Maestría >> Celeridad", 202335,202272,232876,"Barril doble","Aliento incendiario","Esencia de Niuzao"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [1,3,3,1,3,2,1,"Agilidad = Crítico > Versatilidad > Maestría >> Celeridad", 202335,202272,232876,"Barril doble","Aliento incendiario","Esencia de Niuzao"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [3,3,3,2,2,2,3,"Agilidad = Crítico > Versatilidad > Maestría >> Celeridad", 202335,202272,232876,"Barril doble","Aliento incendiario","Esencia de Niuzao"];
              return talentos;
              break;
          }
          break;
        case 2://Camina nieblas
          switch(tipo){
            case 1://Normal
              var talentos = [1,3,1,3,3,3,1,"Intelecto > Celeridad > Maestría > Versatilidad = Crítico", 202424,202428,202577,"Crisálida","Magia contrarrestante","Cúpula de niebla"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [1,3,2,3,3,3,2,"Intelecto > Celeridad > Maestría > Versatilidad = Crítico", 202424,202428,202577,"Crisálida","Magia contrarrestante","Cúpula de niebla"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [3,3,2,3,3,3,3,"Intelecto > Crítico > Versatilidad > Celeridad > Maestría", 202424,202428,202577,"Crisálida","Magia contrarrestante","Cúpula de niebla"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [1,3,1,3,3,3,1,"Intelecto > Celeridad > Maestría > Versatilidad = Crítico", 202424,202428,202577,"Crisálida","Magia contrarrestante","Cúpula de niebla"];
              return talentos;
              break;
            }
          break;
        case 3://Viajero del viento
          switch(tipo){
            case 1://Normal
              var talentos = [3,3,2,2,3,2,2,"Agilidad > Crítico > Maestría > Celeridad > Versatilidad", 247483,206743,232054,"Brebaje de ojo de tigre","Estilo del tigre","Golpes de mano pesados"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [3,3,2,2,3,2,2,"Agilidad > Crítico > Maestría > Celeridad > Versatilidad", 247483,206743,232054,"Brebaje de ojo de tigre","Estilo del tigre","Golpes de mano pesados"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [3,3,2,2,3,3,2,"Agilidad > Crítico > Maestría > Celeridad > Versatilidad", 247483,206743,232054,"Brebaje de ojo de tigre","Estilo del tigre","Golpes de mano pesados"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [3,3,2,2,3,2,2,"Agilidad > Crítico > Maestría > Celeridad > Versatilidad", 247483,206743,232054,"Brebaje de ojo de tigre","Estilo del tigre","Golpes de mano pesados"];
              return talentos;
              break;
            }
      }
      break;
    case 11: //Druida
      switch(rama){
        case 1://Equilibrio
          switch(tipo){
            case 1://Normal
              var talentos = [3,1,3,3,3,2,2,"Intelecto > Celeridad > Crítico = Versatilidad >> Maestría", 200567,200726,233752,"Quemadura de la media luna","Chaparrón celestial","Armadura Plumahierro"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [3,3,2,3,1,2,2,"Intelecto > Celeridad > Crítico = Versatilidad >> Maestría", 200567,200726,233752,"Quemadura de la media luna","Chaparrón celestial","Armadura Plumahierro"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [3,3,2,3,2,3,1,"Intelecto > Celeridad > Crítico = Versatilidad >> Maestría", 200567,200726,233752,"Quemadura de la media luna","Chaparrón celestial","Armadura Plumahierro"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [3,1,3,3,3,2,2,"Intelecto > Celeridad > Crítico = Versatilidad >> Maestría", 200567,200726,233752,"Quemadura de la media luna","Chaparrón celestial","Armadura Plumahierro"];
              return talentos;
              break;
          }
          break;
        case 2://Feral
          switch(tipo){
            case 1://Normal
              var talentos = [2,3,1,1,2,2,2,"Celeridad > Agilidad > Crítico > Maestría = Versatilidad", 203242,205673,203224,"Destripar y desgarrar","Ímpetu salvaje","Herida fresca"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [2,3,1,1,2,2,2,"Celeridad > Agilidad > Crítico > Maestría = Versatilidad", 203242,205673,203224,"Destripar y desgarrar","Ímpetu salvaje","Herida fresca"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [2,3,1,1,2,2,2,"Celeridad > Agilidad > Crítico > Maestría = Versatilidad", 203242,205673,203224,"Destripar y desgarrar","Ímpetu salvaje","Herida fresca"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [2,3,1,1,2,2,2,"Celeridad > Agilidad > Crítico > Maestría = Versatilidad", 203242,205673,203224,"Destripar y desgarrar","Ímpetu salvaje","Herida fresca"];
              return talentos;
              break;
        }
          break;
        case 3://Guardian
          switch(tipo){
            case 1://Normal
              var talentos = [1,3,1,1,2,3,1,"Agilidad > Versatilidad = Maestría > Crítico > Celeridad", 202110,236147,207017,"Garras afiladas","Presteza de Malorne","Desafío alfa"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [3,3,1,3,2,3,1,"Agilidad > Versatilidad = Maestría > Crítico > Celeridad", 202110,236147,207017,"Garras afiladas","Presteza de Malorne","Desafío alfa"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [3,3,3,1,1,3,3,"Agilidad > Versatilidad = Maestría > Crítico > Celeridad", 202110,236147,207017,"Garras afiladas","Presteza de Malorne","Desafío alfa"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [1,3,1,1,2,3,1,"Agilidad > Versatilidad = Maestría > Crítico > Celeridad", 202110,236147,207017,"Garras afiladas","Presteza de Malorne","Desafío alfa"];
              return talentos;
              break;
            }
        case 4://Restauracion
          switch(tipo){
            case 1://Normal
              var talentos = [1,3,3,2,2,3,2,"Intelecto > Maestría > Celeridad > Crítico > Versatilidad", 236696,209690,233673,"Espinas","Druida de la Zarpa","Desenredo"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [1,3,3,2,2,3,2,"Intelecto > Maestría > Celeridad > Crítico > Versatilidad", 236696,209690,233673,"Espinas","Druida de la Zarpa","Desenredo"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [1,3,3,2,2,1,3,"Intelecto > Maestría > Celeridad > Crítico > Versatilidad", 236696,209690,233673,"Espinas","Druida de la Zarpa","Desenredo"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [1,3,3,2,2,3,2,"Intelecto > Maestría > Celeridad > Crítico > Versatilidad", 236696,209690,233673,"Espinas","Druida de la Zarpa","Desenredo"];
              return talentos;
              break;
            }
      }
      break;
    case 12: //DH
      switch(rama){
        case 1://Devastación
          switch(tipo){
            case 1://Normal
              var talentos = [1,3,1,1,2,3,2,"Agilidad > Celeridad > Versatilidad > Crítico > Maestría", 235893,211509,213480,"Orígenes demoníacos","Soledad","Odio infinito"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [1,3,1,1,2,3,2,"Agilidad > Celeridad > Versatilidad > Crítico > Maestría", 235893,211509,213480,"Orígenes demoníacos","Soledad","Odio infinito"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [3,2,1,3,2,3,3,"Agilidad > Celeridad > Versatilidad > Crítico > Maestría", 235893,211509,213480,"Orígenes demoníacos","Soledad","Odio infinito"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [1,3,1,1,2,3,2,"Agilidad > Celeridad > Versatilidad > Crítico > Maestría", 235893,211509,213480,"Orígenes demoníacos","Soledad","Odio infinito"];
              return talentos;
              break;
          }
          break;
        case 2://Venganza
          switch(tipo){
            case 1://Normal
              var talentos = [1,2,1,3,3,2,1,"Agilidad > Celeridad > Versatilidad > Maestría > Crítico", 205627,211509,205629,"Filos dentados","Soledad","Atropello demoníaco"];
              return talentos;
              break;
            case 2://Míticas
              var talentos = [1,2,1,3,3,2,1,"Agilidad > Celeridad > Versatilidad > Maestría > Crítico", 205627,211509,205629,"Filos dentados","Soledad","Atropello demoníaco"];
              return talentos;
              break;
            case 3://Raid
              var talentos = [1,2,1,2,3,2,1,"Agilidad > Celeridad > Versatilidad > Maestría > Crítico", 205627,211509,205629,"Filos dentados","Soledad","Atropello demoníaco"];
              return talentos;
              break;
            case 4://PVP
              var talentos = [1,2,1,3,3,2,1,"Agilidad > Celeridad > Versatilidad > Maestría > Crítico", 205627,211509,205629,"Filos dentados","Soledad","Atropello demoníaco"];
              return talentos;
              break;
        }
          break;
      }
      break;
  }


} //Fin getTalClases()
