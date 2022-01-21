/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX *\
  Creación: 23-7-2018         |       Última modificación:  30-07-2018
  Autor: Francisco José Montero Campos - fran.montero.campos@gmail.com
  --------------------------------------------------------------------
  Objetivo:
  Métodos para ordenar tablas
\* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */


//Por fecha
function sort_fecha() {
 var table=$('#tabla_tareas');
 var tbody =$('#table1');
 tbody.find('tr').sort(function(a, b) {
  if($('#name_order').val()=='asc')  {
   return $('td:first', a).text().localeCompare($('td:first', b).text());
  }
  else {
   return $('td:first', b).text().localeCompare($('td:first', a).text());
  }
 }).appendTo(tbody);

 var sort_order=$('#name_order').val();
 if(sort_order=="asc") {
  document.getElementById("name_order").value="desc";
 }
 if(sort_order=="desc") {
  document.getElementById("name_order").value="asc";
 }
}//fin sort_fecha()

//Por tipo
function sort_tipo() {
 var table=$('#tabla_tareas');
 var tbody =$('#table1');
 tbody.find('tr').sort(function(a, b) {
  if($('#name_order').val()=='asc')  {
   return $('td:nth-child(2)', a).text().localeCompare($('td:nth-child(2)', b).text());
  }
  else {
   return $('td:nth-child(2)', b).text().localeCompare($('td:nth-child(2)', a).text());
  }
 }).appendTo(tbody);

 var sort_order=$('#name_order').val();
 if(sort_order=="asc") {
  document.getElementById("name_order").value="desc";
 }
 if(sort_order=="desc") {
  document.getElementById("name_order").value="asc";
 }
}//fin sort_tipo()

//Por nombre
function sort_nombre() {
 var table=$('#tabla_tareas');
 var tbody =$('#table1');
 tbody.find('tr').sort(function(a, b) {
  if($('#name_order').val()=='asc')  {
   return $('td:nth-child(3)', a).text().localeCompare($('td:nth-child(3)', b).text());
  }
  else {
   return $('td:nth-child(3)', b).text().localeCompare($('td:nth-child(3)', a).text());
  }
 }).appendTo(tbody);

 var sort_order=$('#name_order').val();
 if(sort_order=="asc") {
  document.getElementById("name_order").value="desc";
 }
 if(sort_order=="desc") {
  document.getElementById("name_order").value="asc";
 }
}//fin sort_nombre

//Por repetir
function sort_repetir() {
 var table=$('#tabla_tareas');
 var tbody =$('#table1');
 tbody.find('tr').sort(function(a, b) {
  if($('#name_order').val()=='asc')  {
   return $('td:nth-child(4)', a).text().localeCompare($('td:nth-child(4)', b).text());
  }
  else {
   return $('td:nth-child(4)', b).text().localeCompare($('td:nth-child(4)', a).text());
  }
 }).appendTo(tbody);

 var sort_order=$('#name_order').val();
 if(sort_order=="asc") {
  document.getElementById("name_order").value="desc";
 }
 if(sort_order=="desc") {
  document.getElementById("name_order").value="asc";
 }
}//fin sort_repetir

//Por personajes
function sort_personajes() {
 var table=$('#tabla_tareas');
 var tbody =$('#table1');
 tbody.find('tr').sort(function(a, b) {
  if($('#name_order').val()=='asc')  {
   return $('td:nth-child(5)', a).text().localeCompare($('td:nth-child(5)', b).text());
  }
  else {
   return $('td:nth-child(5)', b).text().localeCompare($('td:nth-child(5)', a).text());
  }
 }).appendTo(tbody);

 var sort_order=$('#name_order').val();
 if(sort_order=="asc") {
  document.getElementById("name_order").value="desc";
 }
 if(sort_order=="desc") {
  document.getElementById("name_order").value="asc";
 }
}//fin sort_personajes

//Por urgencia
function sort_urgencia() {
 var table=$('#tabla_tareas');
 var tbody =$('#table1');
 tbody.find('tr').sort(function(a, b) {
  if($('#name_order').val()=='asc')  {
   return $('td:nth-child(6)', a).text().localeCompare($('td:nth-child(6)', b).text());
  }
  else {
   return $('td:nth-child(6)', b).text().localeCompare($('td:nth-child(6)', a).text());
  }
 }).appendTo(tbody);

 var sort_order=$('#name_order').val();
 if(sort_order=="asc") {
  document.getElementById("name_order").value="desc";
 }
 if(sort_order=="desc") {
  document.getElementById("name_order").value="asc";
 }
}//fin sort_urgencia
