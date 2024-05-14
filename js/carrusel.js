const carrusel = document.getElementById("Escaparate");

function subir() {
    carrusel.scrollTop -= carrusel.clientHeight;
    console.log("subir")
}
  
function bajar() {
    carrusel.scrollTop += carrusel.clientHeight;
    console.log("bajar")
}

