const campo = document.getElementById("texto");
const mensaje = document.getElementById("errorCaracteres");
const parrafoRespuesta = document.getElementById("respuesta");

// @ts-ignore
campo.addEventListener("keyup", validarEntrada);

/**
 * Valida los datos de entrada, solo se permiten letras o numeros.
 *
 * Si no se cumple esta regla se le notifica mediante un mensaje al usuario.
 * Si se cumple la regla, se llama a la funcion:
 * @see consultaBD
 */
function validarEntrada() {
  let patron = /^\w*[\s\w]*$/;
  // @ts-ignore
  let entrada = campo.value;

  if (patron.test(entrada)) {
    // @ts-ignore
    mensaje.style.display = "none";
    consultaBD(entrada);
  } else {
    // @ts-ignore
    mensaje.style.display = "block";
  }
}

/**
 * Establece una comunicacion asincrona con el servidor para buscar en una
 * base de datos los libros cuyo titulo coincidan con el parametro enviado.
 *
 * Se actualiza automaticamente el parrafo con ID "parrafoRespuesta" para que
 * muestre las coincidencias encontradas.
 *
 * @param {string} texto Es el texto que introduce el cliente en el formulario.
 */
function consultaBD(texto) {
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "miPHP.php?texto=" + texto, true);
  xhr.onreadystatechange = gestionarRespuesta;
  // @ts-ignore
  xhr.send();

  function gestionarRespuesta() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let resultado = xhr.responseText;
      // @ts-ignore
      parrafoRespuesta.innerHTML = resultado;
    }
  }
}
