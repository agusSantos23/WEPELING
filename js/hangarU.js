// Función para mostrar los dirigibles en el hangar
function mostrarDirigibles(dirigibles, dirigiblesUsuario) {
    const hangar = document.getElementById('hangar');
    hangar.innerHTML = ''; // Limpiamos el contenido del hangar

    // Verificamos si el usuario no tiene dirigibles
    if (dirigiblesUsuario.length === 0) {
        // Creamos un mensaje indicando que el usuario no tiene dirigibles
        const divV = document.createElement('div');
        divV.id = "vacio";

        const imgU = document.createElement('img');
        imgU.src = "../svg/gear.svg";
        imgU.alt = "Engranaje Giratorio";

        const imgD = document.createElement('img');
        imgD.src = "../svg/gear.svg";
        imgD.alt = "Engranaje Giratorio";

        const h3 = document.createElement('h3');
        const p = document.createElement('p');
        h3.textContent = "¡No tienes Dirigibles agregados!";
        p.textContent = "Si aún no tienes dirigibles en tu hangar, estás perdiendo la oportunidad de vivir una aventura única en el cielo. No pierdas ni un segundo más, corre al Escaparate y descubre si han incorporado un nuevo dirigible que te hará sentir la emoción de surcar los cielos como nunca antes, No te lo puedes perder.";

        divV.appendChild(imgU);
        divV.appendChild(h3);
        divV.appendChild(p);
        divV.appendChild(imgD);
        hangar.appendChild(divV);
    } else {
        // Iteramos sobre los dirigibles del usuario
        dirigiblesUsuario.forEach(dirigibleUsuario => {
            // Buscamos el dirigible correspondiente en la lista de dirigibles disponibles
            dirigibles.forEach(dirigible => {
                if (dirigibleUsuario.ID_dirigible == dirigible.ID_dirigible) {
                    // Creamos una tarjeta para mostrar el dirigible y un botón para eliminarlo
                    const divC = document.createElement('div');
                    divC.classList.add('cards');

                    const div = document.createElement('div');
                    const img = document.createElement('img');
                    const h3 = document.createElement('h3');
                    const btn = document.createElement('button');

                    img.src = dirigible.Imagen;
                    img.alt = dirigible.Modelo;
                    h3.textContent = dirigible.Modelo;

                    btn.setAttribute('data-id', dirigible.ID_dirigible);
                    btn.textContent = 'Eliminar';

                    // Agregamos los elementos creados al DOM
                    div.appendChild(img);
                    div.appendChild(h3);
                    divC.appendChild(div);
                    divC.appendChild(btn);
                    hangar.appendChild(divC);
                }
            });
        });

        // Agregamos un evento de clic a cada botón de eliminar
        const btnsEliminar = document.querySelectorAll('button');
        btnsEliminar.forEach(btnEliminar => {
            btnEliminar.addEventListener('click', () => {
                const dirigibleId = btnEliminar.getAttribute('data-id');
                const liked = true;
                eliminarDirigible(dirigibleId, liked);
            });
        });
    }
}

// Función para eliminar un dirigible del hangar
function eliminarDirigible(dirigibleId, liked) {
    const idUsuario = document.getElementById('hangar').getAttribute('data-id');

    const xhtEliminar = new XMLHttpRequest();
    xhtEliminar.open('POST', '../php/diriHangar.php');
    xhtEliminar.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhtEliminar.onload = () => {
        if (xhtEliminar.status === 200) {
            // Refrescamos la página después de eliminar el dirigible
            refrescar();
        } else {
            console.error('Error en la solicitud. Estado: ' + xhtEliminar.status);
        }
    };

    // Enviamos la solicitud para eliminar el dirigible
    xhtEliminar.send('idDirigible=' + dirigibleId + '&idUsuario=' + idUsuario + '&liked=' + liked);
}

// Función para cargar y mostrar los dirigibles disponibles
function refrescar() {
    const xhrDirigibles = new XMLHttpRequest();
    xhrDirigibles.open('GET', '../php/diri.php');

    xhrDirigibles.onload = () => {
        if (xhrDirigibles.status === 200) {
            // Parseamos la respuesta como JSON
            const dirigibles = JSON.parse(xhrDirigibles.responseText);
            // Cargamos los dirigibles del usuario
            cargarDirigiblesUsuario(dirigibles);
        } else {
            console.error('Error en la solicitud de dirigibles. Estado: ' + xhrDirigibles.status);
        }
    };

    // Enviamos la solicitud para obtener los dirigibles
    xhrDirigibles.send();
}

// Función para cargar los dirigibles del usuario
function cargarDirigiblesUsuario(dirigibles) {
    const idUsuario = document.getElementById('hangar').getAttribute('data-id');

    const xhrHangares = new XMLHttpRequest();
    xhrHangares.open('GET', '../php/diriHangar.php?idUsuario=' + idUsuario);

    xhrHangares.onload = () => {
        if (xhrHangares.status === 200) {
            // Parseamos la respuesta como JSON
            const dirigiblesUsuario = JSON.parse(xhrHangares.responseText);
            // Mostramos los dirigibles del usuario
            mostrarDirigibles(dirigibles, dirigiblesUsuario);
        } else {
            console.error('Error en la solicitud de hangares de usuario. Estado: ' + xhrHangares.status);
        }
    };

    // Enviamos la solicitud para obtener los dirigibles del usuario
    xhrHangares.send();
}

// Iniciamos mostrando los dirigibles disponibles al cargar la página
refrescar();
