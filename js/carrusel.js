const carrusel = document.getElementById("Escaparate");


function enviarSolicitud(idDirigible, url) {
    const idUsuario = document.querySelector('main').getAttribute('data-id');

    const xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                location.reload();
            } else {
                console.error("Error al enviar la solicitud:", xhr.statusText);
            }
        }
    };

    xhr.send("idDirigible=" + idDirigible + "&idUsuario=" + idUsuario);
}

const corazon = document.querySelectorAll(".corazon");
const corazonLiked = document.querySelectorAll(".corazon.like");

corazon.forEach(corazon => {
    corazon.addEventListener("click", event => {
        const idDirigible = event.target.getAttribute("data-id");
        enviarSolicitud(idDirigible, "../php/diriHangarA.php");
    });
});

corazonLiked.forEach(corazonLiked => {
    corazonLiked.addEventListener("click", event => {
        const idDirigible = event.target.getAttribute("data-id");
        enviarSolicitud(idDirigible, "../php/diriHangarE.php");
    });
});





document.addEventListener('keydown', event =>{

    //El arriba y abajode de las flechas no se puede utilizar poque activa el scroll de la pagina
    if (event.key === 'w' || event.key === 'W') {

        subir();

    } else if (event.key === 's' || event.key === 'S' || event.key === 'ArrowDown') {

        bajar();

    } else if (event.key === 'a' || event.key === 'A') {

        bajar();
        
    } else if (event.key === 'd' || event.key === 'D' || event.key === 'ArrowRight') {

        subir();
    }
})


function subir() {
    carrusel.scrollTop -= carrusel.clientHeight;
    
}
  
function bajar() {
    carrusel.scrollTop += carrusel.clientHeight;
    
}

