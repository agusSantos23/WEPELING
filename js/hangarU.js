
const idUsuario = hangar.getAttribute('data-id');


function mostrarDirigibles(dirigibles, dirigiblesUsuario) {
    const hangar = document.getElementById('hangar');
    hangar.innerHTML = ''; 

    if(dirigiblesUsuario.length === 0){
        
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

    }else{


        dirigiblesUsuario.forEach(dirigibleUsuario => {

            dirigibles.forEach(dirigible => {

                if (dirigibleUsuario.ID_dirigible == dirigible.ID_dirigible) {

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

                    div.appendChild(img);
                    div.appendChild(h3);
                    divC.appendChild(div);
                    divC.appendChild(btn);
                    hangar.appendChild(divC);
                }
            });
        });

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


function eliminarDirigible(dirigibleId, liked) {
    const idUsuario = document.getElementById('hangar').getAttribute('data-id');

    const xhtEliminar = new XMLHttpRequest();
    xhtEliminar.open('POST', '../php/diriHangar.php');
    xhtEliminar.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhtEliminar.onload = () => {
        if (xhtEliminar.status === 200) {

            refrescar();
        } else {
            console.error('Error en la solicitud. Estado: ' + xhtEliminar.status);
        }
    };

    xhtEliminar.send('idDirigible=' + dirigibleId + '&idUsuario=' + idUsuario + '&liked=' + liked);
}



// Función para cargar y mostrar los dirigibles disponibles
function refrescar() {

    const xhrDirigibles = new XMLHttpRequest();
    xhrDirigibles.open('GET', '../php/diri.php');

    xhrDirigibles.onload = () => {
        if (xhrDirigibles.status === 200) {

            const dirigibles = JSON.parse(xhrDirigibles.responseText);

            cargarDirigiblesUsuario(dirigibles);

        } else {

            console.error('Error en la solicitud de dirigibles. Estado: ' + xhrDirigibles.status);
        }
    };
    xhrDirigibles.send();
}

function cargarDirigiblesUsuario(dirigibles) {

    const xhrHangares = new XMLHttpRequest();

    xhrHangares.open('GET', '../php/diriHangar.php?idUsuario=' + idUsuario);

    xhrHangares.onload = () => {

        if (xhrHangares.status === 200) {

            const dirigiblesUsuario = JSON.parse(xhrHangares.responseText);

            mostrarDirigibles(dirigibles, dirigiblesUsuario);

        } else {
            console.error('Error en la solicitud de hangares de usuario. Estado: ' + xhrHangares.status);
        }
    };
    xhrHangares.send();
}

// Iniciar mostrando los dirigibles disponibles al cargar la página
refrescar();
