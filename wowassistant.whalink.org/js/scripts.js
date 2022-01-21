/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX *\
  Creación: 05-07-2018         |      Última modificación:  05-11-2018
  Autor: Francisco José Montero Campos - fran.montero.campos@gmail.com
  --------------------------------------------------------------------
  Objetivo:
  Colección de scripts para el manejo de personajes, tareas, etc.
\* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */


var columnaMostrada=4;
var panelVisible = false;
var personajeCualquiera=false;


function borrarInput1(){
  document.getElementById("input1").value="";
}

function borrarInput2(){
  document.getElementById("input2").value="";
  document.getElementById("input3").value="";
  document.getElementById("input4").innerHTML="<option disabled selected value='3'></option><option value='0' class='text-center'>Alianza</option><option value='1'>Horda</option>";
}

function enviarFormPjs(){

  //Mostramos pantalla de cargando
  document.getElementById("mostrarLoading").innerHTML="<div class='cargando'><div class='cajon'><div class='ball'></div></div></div>";
  //Recuperamos datos
  var linkWow = document.getElementById("input1").value;
  var nombre = document.getElementById("input2").value;
  var reino = document.getElementById("input3").value;
  var faccion = document.getElementById("input4").value;
  //Comprobamos que está escrito el campo del link o bien los tres campos de personajes de nivel bajo:
  if(linkWow !="" || (nombre!="") && reino!=("") && faccion>0){
    if(linkWow !=""){
      //Extramos los datos del link:
      var cadena=linkWow.substr(28,linkWow.length); //Extraemos: https://worldofwarcraft.com/
      var zona=cadena.substr(0,5);
      var subCadena=cadena.substr(16,cadena.length); //Extraemos todo lo anterior y dejamos "reino/personaje"
      var num = subCadena.indexOf("/"); //Localizamos el "/" de "reino/personaje"
      var reinoPj = subCadena.substr(0,num);
      var personaje= subCadena.substr(num+1,subCadena.length);

      //Enviamos info a creadorPersonaje.php. Como es un personaje normal, ponemos "nivel=normal"
      location.href = "crearPersonaje.php?nivel=normal&zona="+zona+"&reino="+reinoPj+"&nombre="+personaje;
    }else{
      //Enviamos info a creadorPersonaje.php. Como es un personaje de nivel bajo, ponemos "nivel=normal"
      location.href = "crearPersonaje.php?nivel=bajo&nombre="+nombre+"&reino="+reino+"&faccion="+faccion;
    }
  }else{
    document.getElementById("formError").innerHTML="Por favor, rellena los campos de forma correcta";
  }
}//fIN enviarForm()

function mostrarError(){
  alert("hola");
}

/*
  Función que oculta las primeras columnas de personajes para mostrar las siguientes
*/
function mostrarColumnaDerecha(){
  switch (columnaMostrada) {
    case 4:
      document.getElementById("columna1").style.display="none";
      document.getElementById("columna5").style.display="block";
      columnaMostrada++;
      break;
    case 5:
      document.getElementById("columna2").style.display="none";
      document.getElementById("columna6").style.display="block";
      columnaMostrada++;
      break;
    case 6:
      document.getElementById("columna3").style.display="none";
      document.getElementById("columna7").style.display="block";
      columnaMostrada++;
      break;
  }
}//Fin MostrarColumnaDerecha()

/*
  Función que oculta las últimas columnas de personajes para mostrar las anteriores
*/
function mostrarColumnaIzquierda(){
  switch (columnaMostrada) {
    case 5:
      document.getElementById("columna5").style.display="none";
      document.getElementById("columna1").style.display="block";
      columnaMostrada--;
      break;
    case 6:
      document.getElementById("columna6").style.display="none";
      document.getElementById("columna2").style.display="block";
      columnaMostrada--;
      break;
    case 7:
      document.getElementById("columna7").style.display="none";
      document.getElementById("columna3").style.display="block";
      columnaMostrada--;
      break;
  }
}//Fin mostrarColumnaIzquierda()


/*
  FUNCIÓNES PARA MOSTRAR Y OCULTAR PANEL DE AÑADIR PERSONAJE
*/
function mostrarListaPj() {
  if(!panelVisible){
    document.getElementById("panel_personajes").style.display="block";
    document.getElementById("mostrar").innerHTML="ACEPTAR";
    panelVisible = true;
  }else{
    document.getElementById("panel_personajes").style.display="none";
    document.getElementById("mostrar").innerHTML="+ AÑADIR";
    panelVisible = false;
  }
}

function ocultarListaPj() {
  document.getElementById("panel_personajes").style.display="none";
  document.getElementById("ocultar").style.display="none";
}

/*
  Función para marcar todos los campos de la lista de personajes
*/
function marcarTodo() {
  var string="";
  for (var i = 1; i <= 50; i++) {
    string = "personaje"+String(i)
    document.getElementById(string).checked=true;
  }
}

/*
  Función para desmarcar todos los campos de la lista de personajes
*/
function desmarcarTodo(cualquiera,existeCualquiera) {
  //Si cualquiera = true, coloreamos el botón
  if(existeCualquiera){ //Hay que comprobar que el botón "cualquiera" existe, ya que en 'tarea.php' no existe y daría error
    if(cualquiera){
      document.getElementById("boton_cualquiera").classList.add("cajaNaranja");
      document.getElementById("boton_cualquiera").classList.remove("caja");
      personajeCualquiera=true;
    }else{
      document.getElementById("boton_cualquiera").classList.remove("cajaNaranja");
      document.getElementById("boton_cualquiera").classList.add("caja");
      personajeCualquiera=false;
    }
  }
  var string="";
  for (var i = 1; i <= 50; i++) {
    string = "personaje"+String(i)
    document.getElementById(string).checked=false;
  }



}

/*
  Función para desmarcar el botón Cualquiera cuando se pulse en algún personaje
*/
function desmarcarCualquiera(){
  document.getElementById("boton_cualquiera").classList.remove("cajaNaranja");
  document.getElementById("boton_cualquiera").classList.add("caja");
  personajeCualquiera=false;
}


/*
  Función para cargar el segundo select en la creación de tareas
*/
function cargarTareas(select){
  var subtipos = {
    coleccionables: ["Juguetes","Mascotas","Monturas","Otros"],
    profesion: ["Alquimia","Arqueología","Cocina","Desuello","Encantamiento","Herboristería","Herrería","Ingeniería","Inscripción","Joyería","Minería","Peletería","Pesca","Sastrería"],
    reputacion: ["Antiguas",
      "Alianza: Almirantazgo de la Casa Valiente","Alianza: Orden de Ascuas","Alianza: Despertar de la Tormenta","Alianza: Séptima Legión",
      "Ambos: Buscadores Tortolianos", "Ambos: Campeones de Azeroth",
      "Horda: Defensores del Honor","Horda: Expedición de Talanji","Horda: Imperio Zandalari","Horda: Voldunai"]
  }

  var tipo = select.options[select.selectedIndex].getAttribute("value");
  var selector = document.getElementById('subtipo');
  switch(tipo) {
    case "1": //Coleccionables
      //Cambiamos etiqueta y limpiamos select de subtipo en crear tarea
      limpiarSubTipo();
        //Rellenamos con las opciones correspondientes:
        var i;
        for(i = 0;i<=subtipos["coleccionables"].length;i++){
          if(i==0){
            var opcion = document.createElement('option');
            opcion.value = 0;
            opcion.text = "-- Elige una opción --";
            selector.add(opcion);
          }else{
            var opcion = document.createElement('option');
            opcion.value = i;
            opcion.text = subtipos["coleccionables"][i-1];
            selector.add(opcion);
          }
        }
        break;
    case "7": //Profesiones
      //Cambiamos etiqueta y limpiamos select de subtipo en crear tarea
      limpiarSubTipo();
      //Rellenamos con las opciones correspondientes:
      var i;
      for(i = 0;i<subtipos["profesion"].length;i++){
        var opcion = document.createElement('option');

        opcion.value = i+1;
        opcion.text = subtipos["profesion"][i];
        selector.add(opcion);
      }
      break;
    case "8": //reputaciones
      //Cambiamos etiqueta y limpiamos select de subtipo en crear tarea
      limpiarSubTipo();
      //Rellenamos con las opciones correspondientes:
      var i;
      for(i = 0;i<subtipos["reputacion"].length;i++){
        var opcion = document.createElement('option');
        opcion.value = i+1;
        opcion.text = subtipos["reputacion"][i];
        selector.add(opcion);
      }
      break;
    default:
      desactivarSubTipo();

  }
}//Fin cargarTareas

/*
Método para cambiar etiqueta y limpiar select de subtipo en crear tarea
*/
function limpiarSubTipo(){
  var selector = document.getElementById('subtipo');
  //Borramos el contenido del select antes de nada.
  var length = selector.options.length;


  var i;
      for(i = selector.options.length - 1 ; i >= 0 ; i--)
      {
          selector.remove(i);
      }
  //Coloreamos el label de blanco y añadimos *
  document.getElementById("label_subtipo").style.color = "white";
  document.getElementById("label_subtipo").innerHTML="*Sub-tipo";
}

/*
Método para "desactiva" etiqueta y limpiar select de subtipo en crear tarea
*/
function desactivarSubTipo(){
  limpiarSubTipo();
  //Coloreamos el label de blanco y añadimos *
  document.getElementById("label_subtipo").style.color = "grey";
  document.getElementById("label_subtipo").innerHTML="Sub-tipo";
  var selector = document.getElementById('subtipo');
  var opcion = document.createElement('option');
  opcion.value = 0;
  opcion.text = "-- No necesario con el tipo elegido --";
  selector.add(opcion);
}


/*
  Método para enviar el formulario de creación de TAREAS
*/
function enviarFormTareas(){
  //Mostramos pantalla de cargando
  //document.getElementById("mostrarLoading").innerHTML="<div class='cargando'><div class='cajon'><div class='ball'></div></div></div>";
  //Recuperamos datos
  var nombreTarea = document.getElementById("nombreTarea").value;
  var tipo = document.getElementById("tipo").value;
  var subtipo = document.getElementById("subtipo").value;
  var repetible = document.getElementById("repetible").value;
  var prioridad = document.getElementById("prioridad").value;
  var link = document.getElementById("link").value;
  var notas = document.getElementById("notas").value;
  //Reiniciamos comprobaciones
  var correcto=true;
    document.getElementById("label_nombre").style.color = "white";
    document.getElementById("label_tipo").style.color = "white";
    document.getElementById("label_subtipo").style.color = "white";
    divError = document.getElementById("tarea_error");
    divError.innerHTML="";
  //Comprobamos que los campos obligatorios no están vacíos
  //Nombre
    if(nombreTarea == ""){
      document.getElementById("label_nombre").style.color = "red";
      correcto=false;
      tareaError("nombre");
    }
  //Tipo
    if(tipo == "0"){
      document.getElementById("label_tipo").style.color = "red";
      correcto=false;
      tareaError("tipo");
    }
  //Subtipo
    if(tipo=="1" || tipo=="7" || tipo=="8"){//Comprobamos que sea de un tipo que tenga subtipo
      if(subtipo == "0"){
        document.getElementById("label_subtipo").style.color = "red";
        correcto=false;
        tareaError("subtipo");
      }
    }

  //Comprobamos que hay, al menos un personaje (o "cualquiera") marcado:
  var inputElems = document.getElementsByTagName("input");
  var count = 0;

  for (var i=0; i<inputElems.length; i++) {
     if (inputElems[i].type == "checkbox" && inputElems[i].checked == true){
        count++;
     }
  }
  if(count==0 && !personajeCualquiera){
    tareaError("personaje");
    correcto=false;
  }

  //Si todo está correcto, hacemos submit
  if(correcto){
    //Mostramos pantalla de cargando
    document.getElementById("mostrarLoading").innerHTML="<div class='cargando'><div class='cajon'><div class='ball'></div></div></div>";
    var form = document.createElement("form");
    var element1 = document.createElement("input");
    var element2 = document.createElement("input");
    var element3 = document.createElement("input");
    var element4 = document.createElement("input");
    var element5 = document.createElement("input");
    var element6 = document.createElement("input");
    var element7 = document.createElement("input");
    var element8 = document.createElement("input");

    form.method = "POST";
    form.action = "tareas.php";

    element1.value=nombreTarea;
    element1.name="nombre";
    element1.type="hidden";
    form.appendChild(element1);

    element2.value=tipo;
    element2.name="tipo";
    element2.type="hidden";
    form.appendChild(element2);

    element3.value=subtipo;
    element3.name="subtipo";
    element3.type="hidden";
    form.appendChild(element3);

    element4.value=repetible;
    element4.name="repetible";
    element4.type="hidden";
    form.appendChild(element4);

    element5.value=prioridad;
    element5.name="prioridad";
    element5.type="hidden";
    form.appendChild(element5);

    element6.value=link;
    element6.name="link";
    element6.type="hidden";
    form.appendChild(element6);

    element7.value=notas;
    element7.name="notas";
    element7.type="hidden";
    form.appendChild(element7);

    //Crearemos un string con todos los personajes con la estructura: id|id|id|...
    var elegidos="";
    if(personajeCualquiera){
      elegidos=0+"|";
    }else{
      for (var i=0; i<inputElems.length; i++) {
        if (inputElems[i].type == "checkbox" && inputElems[i].checked == true){
          elegidos += inputElems[i].value+"|";
        }
      }
    }
    element8.value=elegidos;
    element8.name="personajes";
    element8.type="hidden";
    form.appendChild(element8);

    document.body.appendChild(form);

    form.submit();

  }else{
    tareaError("");
  }
}//Fin enviarFormTareas()

/*
  Función que muestra mensaje de error al crear tareas
*/
function tareaError(error){
  var divError = document.getElementById("tarea_error");
  switch (error) {
    case "nombre":
      divError.innerHTML = divError.innerHTML + "Falta nombre. "
      break;
    case "tipo":
      divError.innerHTML = divError.innerHTML + "Falta tipo. "
      break;
    case "subtipo":
      divError.innerHTML = divError.innerHTML + "Falta subtipo. "
      break;
    case "personaje":
      divError.innerHTML = divError.innerHTML + "No se ha seleccionado ningún personaje."
      break;
    default:
      divError.innerHTML = "Error. Revise que todas las opciones obligatorias han sido seleccionadas";
  }
}//Fin tareaError

/*
  Método para enviar el formulario de mostrar TAREAS
*/
function enviarFormMostrarTarea(idTarea,fuente){
  var form = document.createElement("form");
  var element1 = document.createElement("input");
  var element2 = document.createElement("input");

  form.method = "POST";
  form.action = "tarea.php";

  element1.value=idTarea;
  element1.name="idTarea";
  element1.type="hidden";
  form.appendChild(element1);

  element2.value=fuente;
  element2.name="fuente";
  element2.type="hidden";
  form.appendChild(element2);

  document.body.appendChild(form);

  form.submit();
}//fin enviarFormMostrarTarea


/*
  Función que reenvía a la página anterior desde una tarea
*/
function enviarTareaAtras(fuente){
  if(fuente=="tareas"){
    document.getElementById("mostrarLoading").innerHTML="<div class='cargando'><div class='cajon'><div class='ball'></div></div></div>";
    window.location='tareas.php';
  }else{
    document.getElementById("mostrarLoading").innerHTML="<div class='cargando'><div class='cajon'><div class='ball'></div></div></div>";
    window.location='fuente';
  }
}

/*
  Función para actualizar o eliminar tareas
*/
function actualizarTarea(idTarea,fuente,repetible,borrarRepe){
  document.getElementById("mostrarLoading").innerHTML="<div class='cargando'><div class='cajon'><div class='ball'></div></div></div>";
  var form = document.createElement("form");
  var element1 = document.createElement("input");
  var element2 = document.createElement("input");
  var element3 = document.createElement("input");

  //Crearemos un string con todos los personajes no seleccionados con la estructura: id|id|id|...
  var noElegidos="";
  var count=0;
  var inputElems = document.getElementsByTagName("input");
  for (var i=0; i<inputElems.length; i++) {
    if (inputElems[i].type == "checkbox" && inputElems[i].checked == false){
      noElegidos += inputElems[i].value+"|";
    }else{
      count++; //Guarda los pulsados.
    }
  }

  //Creamos un formulario POST
  form.method = "POST";
  if(fuente=="tareas"){
    form.action = "tareas.php";
  }else{
    form.action = fuente;
  }

  //Si no hay personajes sin elegir, hay que borrar la tarea. Si no, sólo actualizarla con los que quedan sin marcar
  if(borrarRepe){    //Se ha pedido eliminar tarea repetida
    element1.value="elimina_repe";
  }else if(noElegidos=="" && !repetible){
    element1.value="eliminar";
  }else if(noElegidos=="" && repetible){
    element1.value="actualizarTareaRepetible";
  }else if(count>0){                        //Si se ha marcado alguno hay que actualizar la lista sin el/los marcados
    element1.value="actualizar";
  }else{                                    //Si se ha pulsado el botón sin marcar ninguno simplemente vuelve a tareas
    element1.value="nada";
  }
  element1.name="accion";
  element1.type="hidden";
  form.appendChild(element1);

  element2.value=noElegidos;
  element2.name="personajes";
  element2.type="hidden";
  form.appendChild(element2);

  element3.value=idTarea;
  element3.name="idTarea";
  element3.type="hidden";
  form.appendChild(element3);

  document.body.appendChild(form);

  form.submit();
}

/* FUNCIONES JUGADOR*/
/*
  Función para borrar personaje
*/
function borrarPersonaje(idPj){
  //Mostramos pantalla de cargando
  document.getElementById("mostrarLoading").innerHTML="<div class='cargando'><div class='cajon'><div class='ball'></div></div></div>";
  var form = document.createElement("form");
  var element1 = document.createElement("input");
  var element2 = document.createElement("input");

  form.method = "POST";
  form.action = "personajes.php";

  element1.value=idPj;
  element1.name="idPj";
  element1.type="hidden";
  form.appendChild(element1);

  element2.value="borrarPj";
  element2.name="accion";
  element2.type="hidden";
  form.appendChild(element2);

  document.body.appendChild(form);

  form.submit();
}

/*
  Función que esconde el footer con scroll
*/
$(window).scroll(function(event) {
	function footer()
    {
        var scroll = $(window).scrollTop();
        if(scroll > 50)
        {
            $(".posted-by").fadeIn("slow").addClass("hidden");
        }
        else
        {
            $(".posted-by").fadeOut("slow").removeClass("hidden");
        }

        clearTimeout($.data(this, 'scrollTimer'));
        $.data(this, 'scrollTimer', setTimeout(function() {
            if ($('.footer-nav').is(':hover')) {
	        	footer();
    		}
            else
            {
            	$(".posted-by").fadeOut("slow");
            }
		}, 2000));
    }
    footer();
});





/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
function pruebas(){
  alert("prueba");
}
