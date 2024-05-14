const crear = document.getElementById("Crear");
const cerrar = document.getElementById("Cerrar");
const div = document.getElementById("formularioC");

const modeloInput = document.getElementById("model");
const fileInput = document.getElementById('fileInput');
const textArea = document.getElementById('descripcion');
const autonomiaInput = document.getElementById("autonomia");
const velocidadInput = document.getElementById("velocidad");
const compartimentoInput = document.getElementById("compartimento");

const submitButton = document.getElementById("submitBtn");


const tituloM = document.getElementById("tituloM");
const contenidoM = document.getElementById("contenidoM");


const btnEliminar = document.querySelectorAll(".btnEliminar");


let modeloB = false;
let fileB = false;
let textAreaB = false;
let autonomiaB = false;
let velocidadB = false;
let compartimentoB = false;

crear.addEventListener("click", () => {

    div.style.display = "flex";
    document.body.style.overflow = "hidden";

    let scrollPosition = window.scrollY;
    div.style.top = scrollPosition + "px";
    
})

cerrar.addEventListener("click", () =>{

    div.style.display = "none";
    document.body.style.overflow = "auto";
})

modeloInput.addEventListener("input", () =>{
    
    if(modeloInput.value.length >= 25){

        tituloM.textContent = "No valido"; 
        contenidoM.textContent = "El nombre del modelo no puede superar los 25 caracteres";
        modeloB = false;
    }else if(modeloInput.value.length <= 25){
        modeloB = true;
        contenidoM.textContent = "";
    }
    actualizarEstadoBoton();
})

fileInput.addEventListener('change', ()=>{
    
    if (fileInput.files.length > 0) {

        if (fileInput.files[0].size > 500 * 1024) {

            tituloM.textContent = "No valido"; 
            contenidoM.textContent = "El archivo debe de ser menor a 500 kB";
            fileB = false;
        }else{
            fileB = true;
            contenidoM.textContent = "";
        }
    }
    actualizarEstadoBoton();
    
    // Obtener el nombre del archivo seleccionado
    const fileName = fileInput.value.split('\\').pop(); 
    
    // Obtener el elemento del botón personalizado
    let label = document.querySelector("#Subir button");
    
    // Actualizar el texto del botón personalizado con el nombre del archivo seleccionado
    label.textContent = fileName || "Seleccionar archivo";

    
});

textArea.addEventListener('input', () => {

    if(textArea.value.length <= 50){

        tituloM.textContent = "No valido"; 
        contenidoM.textContent = "La descripcion tiene que superar los 50 caracteres";
        textAreaB = false;
    }else if(textArea.value.length >= 50){
        textAreaB = true;
        contenidoM.textContent = "";
    }
    actualizarEstadoBoton();
})


autonomiaInput.addEventListener("blur", () => {
    let valor = autonomiaInput.value;
    if (!isNaN(parseFloat(valor)) && !valor.endsWith("h")) {
        autonomiaInput.value = valor + " h"; 
        autonomiaB = true;
    }else if(valor.trim() === ""){
        autonomiaB = false;
    }
    actualizarEstadoBoton();
});

velocidadInput.addEventListener("blur", () => {
    let valor = velocidadInput.value;
    if (!isNaN(parseFloat(valor)) && !valor.endsWith("km/h")) {
        velocidadInput.value = valor + " km/h"; 
        velocidadB = true;
    }else if(valor.trim() === ""){
        velocidadB = false;
    }
    actualizarEstadoBoton();
});

compartimentoInput.addEventListener("blur", () => {
    let valor = compartimentoInput.value;
    if (!isNaN(parseFloat(valor)) && !valor.endsWith("t")) {
        compartimentoInput.value = valor + " t"; 
        compartimentoB = true;
    }else if(valor.trim() === ""){
        compartimentoB = false;
    }
    actualizarEstadoBoton();
});

function actualizarEstadoBoton() {
    if (modeloB && fileB && textAreaB && autonomiaB && velocidadB && compartimentoB) {
        submitButton.style.display = "block";
    } else {
        submitButton.style.display = "none";
    }

    if(contenidoM.textContent == ""){

        tituloM.textContent = "";
    }
}





btnEliminar.forEach(btnEliminar => {

    btnEliminar.addEventListener("click", event => {

        const cardId = event.target.parentNode.getAttribute("data-id");

        const xhr = new XMLHttpRequest();

        xhr.open("POST", "../php/eliminarCard.php", true);

        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Eliminación exitosa, actualizar la interfaz de usuario
                    const cardAEliminar = document.querySelector(".cards[data-id='" + cardId + "']");
                    cardAEliminar.parentNode.removeChild(cardAEliminar);
                } else {
                    // Manejar errores de solicitud
                    console.error("Error al eliminar el registro:", xhr.responseText);
                }
            }
        };
        xhr.send("id=" + cardId);
    });

});

