function comprobarRegistro(){
  var realizarSubmit = true;
  //Comprobamos que se ha aceptado la política de privacidad
  if(document.formRegistro.politica.checked==false){
    document.getElementById("politicaError").innerHTML = "Obligatorio";
    realizarSubmit = false;
  }

  //Comprobamos que "email1" tiene formato de correo electrónico
  var email = document.formRegistro.email1.value;
  if (!(/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(email))){
    document.getElementById("emailIncorrecto").innerHTML = "El correo electrónico introducido no es correcto";
    realizarSubmit = false;
  }

  //Comprobamos que los correos coincidan
  if(document.formRegistro.email1.value != document.formRegistro.email2.value){
    document.getElementById("emailError").innerHTML = "Los correos suministrados no coinciden";
    realizarSubmit = false;
  }

  //Comprobamos que las contraseñas coincidan
  if(document.formRegistro.pass1.value != document.formRegistro.pass2.value){
    document.getElementById("passError").innerHTML = "Las contraseñas suministradas no coinciden<br>";
    realizarSubmit = false;
  }
  return realizarSubmit;
}
