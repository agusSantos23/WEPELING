const escaparate = document.getElementById("Escaparate");

const idUsuario = escaparate.getAttribute('data-id');


const xhr = new XMLHttpRequest();
xhr.open('GET', '../php/diri.php');
xhr.onload = () => {
    
    if (xhr.status === 200) {
        const dirigibles = JSON.parse(xhr.responseText);

        const xhrHangares = new XMLHttpRequest();
        xhrHangares.open('GET', '../php/diriHangar.php?idUsuario=' + idUsuario);

        xhrHangares.onload = () => {

            if (xhrHangares.status === 200) {

                const dirigiblesUsuario = JSON.parse(xhrHangares.responseText);

                dirigibles.forEach(dirigible => {

                    const div = document.createElement('div');
                    div.id = dirigible.ID_dirigible;
                    div.classList.add('elementoCarrusel');


                    const article = document.createElement('article');
                    const section = document.createElement('section');
                    const h2 = document.createElement('h2');
                    const p = document.createElement('p');

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


                const corazones = document.querySelectorAll('.corazon');

                corazones.forEach( corazon => {

                    corazon.addEventListener('click',() => {
                        
                        const dirigibleId = corazon.getAttribute('data-id');
                        const liked = corazon.classList.contains('like');

                        const xhrActualizarLike = new XMLHttpRequest();

                        xhrActualizarLike.open('POST', '../php/diriHangar.php');

                        xhrActualizarLike.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                        xhrActualizarLike.onload = () => {

                            if (xhrActualizarLike.status === 200) {
                                

                                corazon.classList.toggle('like');
                                corazon.src = corazon.src.endsWith('corazonR.svg') ? '../svg/corazonW.svg' : '../svg/corazonR.svg';

                            } else {
                                console.error('Error en la solicitud. Estado: ' + xhrActualizarLike.status);
                            }
                        };
                        
                        xhrActualizarLike.send('idDirigible=' + dirigibleId + '&idUsuario=' + idUsuario + '&liked=' + liked);
                    });
                });

            } else {

                console.error('Error en la solicitud de hangares de usuario. Estado: ' + xhrHangares.status);
            }
        };
        xhrHangares.send();

    } else {

        console.error('Error en la solicitud de dirigibles. Estado: ' + xhr.status);
    }
};
xhr.send();



document.addEventListener('keydown', event => {

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
    escaparate.scrollTop -= escaparate.clientHeight;

}

function bajar() {
    escaparate.scrollTop += escaparate.clientHeight;

}

