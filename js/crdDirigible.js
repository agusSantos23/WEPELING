// Seleccionamos los elementos del DOM
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

// Variables de estado para validar los campos del formulario
let modeloB = false;
let fileB = false;
let textAreaB = false;
let autonomiaB = false;
let velocidadB = false;
let compartimentoB = false;

// Mostrar el formulario al hacer clic en "Crear"
crear.addEventListener("click", () => {
    div.style.display = "flex";
    document.body.style.overflow = "hidden";

    // Guardar la posición de desplazamiento actual
    let scrollPosition = window.scrollY;
    div.style.top = scrollPosition + "px";
});

// Ocultar el formulario al hacer clic en "Cerrar"
cerrar.addEventListener("click", () =>{
    div.style.display = "none";
    document.body.style.overflow = "auto";
});

// Event listener para validar el campo del modelo
modeloInput.addEventListener("input", () =>{
    if(modeloInput.value.length >= 25){
        // Mostrar mensaje de error si el modelo es demasiado largo
        tituloM.textContent = "No válido"; 
        contenidoM.textContent = "El nombre del modelo no puede superar los 25 caracteres";
        modeloB = false;
    } else {
        modeloB = true;
        contenidoM.textContent = "";
    }
    actualizarEstadoBoton();
});

// Event listener para validar el campo del archivo
fileInput.addEventListener('change', ()=>{
    if (fileInput.files.length > 0) {
        if (fileInput.files[0].size > 500 * 1024) {
            // Mostrar mensaje de error si el archivo es demasiado grande
            tituloM.textContent = "No válido"; 
            contenidoM.textContent = "El archivo debe ser menor a 500 kB";
            fileB = false;
        } else {
            fileB = true;
            contenidoM.textContent = "";
        }
    }
    actualizarEstadoBoton();

    // Obtener el nombre del archivo seleccionado y actualizar el texto del botón
    const fileName = fileInput.value.split('\\').pop(); 
    let label = document.querySelector("#Subir button");
    label.textContent = fileName || "Seleccionar archivo";
});

// Event listener para validar el campo de la descripción
textArea.addEventListener('input', () => {
    if(textArea.value.length <= 50){
        // Mostrar mensaje de error si la descripción es demasiado corta
        tituloM.textContent = "No válido"; 
        contenidoM.textContent = "La descripción debe superar los 50 caracteres";
        textAreaB = false;
    } else {
        textAreaB = true;
        contenidoM.textContent = "";
    }
    actualizarEstadoBoton();
});

// Event listener para validar el campo de la autonomía
autonomiaInput.addEventListener("blur", () => {
    let valor = autonomiaInput.value;
    if (!isNaN(parseFloat(valor)) && !valor.endsWith("h")) {
        autonomiaInput.value = valor + " h"; 
        autonomiaB = true;
    } else if(valor.trim() === ""){
        autonomiaB = false;
    }
    actualizarEstadoBoton();
});

// Event listener para validar el campo de la velocidad
velocidadInput.addEventListener("blur", () => {
    let valor = velocidadInput.value;
    if (!isNaN(parseFloat(valor)) && !valor.endsWith("km/h")) {
        velocidadInput.value = valor + " km/h"; 
        velocidadB = true;
    } else if(valor.trim() === ""){
        velocidadB = false;
    }
    actualizarEstadoBoton();
});

// Event listener para validar el campo del compartimento
compartimentoInput.addEventListener("blur", () => {
    let valor = compartimentoInput.value;
    if (!isNaN(parseFloat(valor)) && !valor.endsWith("t")) {
        compartimentoInput.value = valor + " t"; 
        compartimentoB = true;
    } else if(valor.trim() === ""){
        compartimentoB = false;
    }
    actualizarEstadoBoton();
});

// Función para actualizar el estado del botón de envío
function actualizarEstadoBoton() {
    if (modeloB && fileB && textAreaB && autonomiaB && velocidadB && compartimentoB) {
        submitButton.style.display = "block";
    } else {
        submitButton.style.display = "none";
    }

    // Ocultar el mensaje de error si no hay contenido
    if(contenidoM.textContent == ""){
        tituloM.textContent = "";
    }
}

// Iterar sobre los botones de eliminar y agregar un event listener
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
