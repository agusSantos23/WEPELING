
// Obtenemos el elemento del escaparate
const escaparate = document.getElementById("Escaparate");

// Obtenemos el ID del usuario del atributo 'data-id'
const idUsuario = escaparate.getAttribute('data-id');

// Creamos una instancia de XMLHttpRequest para obtener los dirigibles
const xhr = new XMLHttpRequest();
xhr.open('GET', '../php/diri.php');
xhr.onload = () => {
    // Verificamos si la solicitud fue exitosa
    if (xhr.status === 200) {
        // Parseamos la respuesta como JSON
        const dirigibles = JSON.parse(xhr.responseText);

        // Creamos una nueva solicitud para obtener los hangares del usuario
        const xhrHangares = new XMLHttpRequest();
        xhrHangares.open('GET', '../php/diriHangar.php?idUsuario=' + idUsuario);
        xhrHangares.onload = () => {
            // Verificamos si la solicitud fue exitosa
            if (xhrHangares.status === 200) {
                // Parseamos la respuesta como JSON
                const dirigiblesUsuario = JSON.parse(xhrHangares.responseText);

                // Iteramos sobre cada dirigible
                dirigibles.forEach(dirigible => {
                    // Creamos elementos HTML dinámicamente
                    const div = document.createElement('div');
                    div.id = dirigible.ID_dirigible;
                    div.classList.add('elementoCarrusel');
                    const article = document.createElement('article');
                    const section = document.createElement('section');
                    const h2 = document.createElement('h2');
                    const p = document.createElement('p');

                    // Establecemos el contenido de los elementos
                    h2.textContent = dirigible.Modelo;
                    p.textContent = dirigible.Descripcion;
                    section.appendChild(h2);
                    section.appendChild(p);
                    const ul = document.createElement('ul');
                    const autonomiaLi = document.createElement('li');
                    autonomiaLi.textContent = 'Autonomia: ' + dirigible.Autonomia;
                    const velocidadLi = document.createElement('li');
                    velocidadLi.textContent = 'Velocidad: ' + dirigible.Velocidad;
                    const compartimentoLi = document.createElement('li');
                    compartimentoLi.textContent = 'Compartimento: ' + dirigible.Compartimento;
                    ul.appendChild(autonomiaLi);
                    ul.appendChild(velocidadLi);
                    ul.appendChild(compartimentoLi);

                    // Creamos y configuramos elementos de imagen
                    const imgC = document.createElement('img');
                    imgC.src = dirigiblesUsuario.some(hangar => hangar.ID_dirigible === dirigible.ID_dirigible) ? '../svg/corazonR.svg' : '../svg/corazonW.svg';
                    imgC.alt = 'liked';
                    imgC.classList.add('corazon');
                    dirigiblesUsuario.some(hangar => hangar.ID_dirigible === dirigible.ID_dirigible) && imgC.classList.add('like');
                    imgC.setAttribute('data-id', dirigible.ID_dirigible);

                    const aside = document.createElement('aside');
                    aside.classList.add('carrusel');
                    const imgArriba = document.createElement('img');
                    imgArriba.src = '../svg/arrow.svg';
                    imgArriba.alt = 'flecha Arriba';
                    imgArriba.classList.add('normal', 'svg');
                    imgArriba.addEventListener('click', subir);
                    const imgAbajo = document.createElement('img');
                    imgAbajo.src = '../svg/arrow.svg';
                    imgAbajo.alt = 'flecha Abajo';
                    imgAbajo.classList.add('invertido', 'svg');
                    imgAbajo.addEventListener('click', bajar);
                    const imgD = document.createElement('img');
                    imgD.src = dirigible.Imagen;
                    imgD.alt = dirigible.Modelo;
                    imgD.classList.add('dirigible');

                    // Agregamos los elementos creados al DOM
                    article.appendChild(section);
                    article.appendChild(ul);
                    article.appendChild(imgC);
                    aside.appendChild(imgArriba);
                    aside.appendChild(imgD);
                    aside.appendChild(imgAbajo);
                    div.appendChild(article);
                    div.appendChild(aside);
                    escaparate.appendChild(div);
                });

                // Seleccionamos todos los corazones
                const corazones = document.querySelectorAll('.corazon');

                // Añadimos un evento click a cada corazón
                corazones.forEach( corazon => {
                    corazon.addEventListener('click',() => {
                        // Obtenemos el ID del dirigible y si está marcado como 'like'
                        const dirigibleId = corazon.getAttribute('data-id');
                        const liked = corazon.classList.contains('like');

                        // Creamos una solicitud para actualizar el 'like' en la base de datos
                        const xhrActualizarLike = new XMLHttpRequest();
                        xhrActualizarLike.open('POST', '../php/diriHangar.php');
                        xhrActualizarLike.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhrActualizarLike.onload = () => {
                            // Verificamos si la solicitud fue exitosa
                            if (xhrActualizarLike.status === 200) {
                                // Cambiamos el estado del corazón y su imagen correspondiente
                                corazon.classList.toggle('like');
                                corazon.src = corazon.src.endsWith('corazonR.svg') ? '../svg/corazonW.svg' : '../svg/corazonR.svg';
                            } else {
                                console.error('Error en la solicitud. Estado: ' + xhrActualizarLike.status);
                            }
                        };
                        // Enviamos los datos al servidor
                        xhrActualizarLike.send('idDirigible=' + dirigibleId + '&idUsuario=' + idUsuario + '&liked=' + liked);
                    });
                });

            } else {
                console.error('Error en la solicitud de hangares de usuario. Estado: ' + xhrHangares.status);
            }
        };
        // Enviamos la solicitud para obtener los hangares del usuario
        xhrHangares.send();

    } else {
        console.error('Error en la solicitud de dirigibles. Estado: ' + xhr.status);
    }
};
// Enviamos la solicitud para obtener los dirigibles
xhr.send();

// Añadimos un evento de teclado para controlar el desplazamiento del escaparate
document.addEventListener('keydown', event => {
    if (event.key === 'w' || event.key === 'W') {
        subir();
    } else if (event.key === 's' || event.key === 'S' || event.key === 'ArrowDown') {
        bajar();
    } else if (event.key === 'a' || event.key === 'A') {
        bajar();
    } else if (event.key === 'd' || event.key === 'D' || event.key === 'ArrowRight') {
        subir();
    }
});

// Función para desplazar hacia arriba el escaparate
function subir() {
    escaparate.scrollTop -= escaparate.clientHeight;
}

// Función para desplazar hacia abajo el escaparate
function bajar() {
    escaparate.scrollTop += escaparate.clientHeight;
}
