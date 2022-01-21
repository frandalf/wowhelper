/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX *\
  Creación: 5-7-2018         |        Última modificación:  27-07-2018
  Autor: Francisco José Montero Campos - fran.montero.campos@gmail.com
  --------------------------------------------------------------------
  Objetivo:
  Función que impide escribir algo que no sea letra, número o algunos símbolos de puntuación.
\* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
function limpiarCodigo(string){
  var out = '';
   //Se añaden las letras validas
   var filtro = " abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890,.-_:/=áéíóúäïöüâêîôûçÇÁÉÍÓÚÄËÏÖÜÂÊÎÔÛ!¡´'#&¿?";//Caracteres validos
   for (var i=0; i<string.length; i++)
      if (filtro.indexOf(string.charAt(i)) != -1){
        out += string.charAt(i);
      }

   return out;
}
