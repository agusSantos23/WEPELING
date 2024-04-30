const crear = document.getElementById("Crear");
const cerrar = document.getElementById("Cerrar");
const div = document.getElementById("formularioC")

crear.addEventListener("click", () => {

    div.style.display = "flex";
    document.body.style.overflow = "hidden";
})

cerrar.addEventListener("click", () =>{

    div.style.display = "none";
    document.body.style.overflow = "auto";
})

document.getElementById('fileInput').addEventListener('change', function() {
    // Cuando cambia el contenido del input de tipo file, se ejecuta esta función
    
    // Obtener el nombre del archivo seleccionado
    var fileName = this.value.split('\\').pop();
    
    // Obtener el elemento del botón personalizado
    var label = document.querySelector('#Subir button');
    
    // Actualizar el texto del botón personalizado con el nombre del archivo seleccionado
    label.textContent = fileName || 'Seleccionar archivo';
});

