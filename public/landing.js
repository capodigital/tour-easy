window.addEventListener("load", () => {
    initTours();
    initArtists();
    initAgencies();
});

function initTours() {
    fetch("api/landing/tours")
        .then((response) => response.json())
        .then((tours) => {
            const container = document.querySelector(".primerCarrusel");
            container.innerHTML = "";
            for (const tour of tours.data) {
                const img = document.createElement("img");
                img.src = tour.tourcartel;
                container.append(img);
            }
        });
}

function initArtists() {
    fetch("api/landing/artists")
        .then((response) => response.json())
        .then((artists) => {
            const container = document.querySelector(".artists-container");
            // container.innerHTML = "";
            for (const artist of artists.data) {
                const img = document.createElement("img");
                img.src = artist.image;
                if (container.firstElementChild.children.length < 3) {
                    container.firstElementChild.append(img);
                } else if (container.children[1].children.length < 4) {
                    container.children[1].append(img);
                } else if (container.lastElementChild.children.length < 3) {
                    container.lastElementChild.append(img);
                }
            }
        });
}

function initAgencies() {
    fetch("api/landing/agencies")
        .then((response) => response.json())
        .then((agencies) => {
            const container = document.querySelector(".segundoCarrusel");
            container.innerHTML = "";
            for (const agency of agencies.data) {
                const div = document.createElement("div");
                div.classList.add("postalContainer");
                div.style.backgroundImage = `url(${agency.image})`;
                div.innerHTML = `
                    <div class="nombrePostal">
                        <div class="nombreNombrePostal">${agency.taxname}</div>
                    </div>
                    <div class="infoContainer">
                        <div class="infoPostal">
                            Información
                        </div>
                        <div class="numeroPostal">
                            <img src="img/whatsapp.png" alt="" width="20" height="20">
                            <div>
                                <p>Número de teléfono</p>
                                <p class="numerNumeroPostal">${agency.phone}</p>
                            </div>
                        </div>
                        <div class="numeroPostal">
                            <img src="img/mail.png" alt="" width="20" height="20">
                            <div>
                                <p>Correo electrónico</p>
                                <p class="numerNumeroPostal">${agency.email}</p>
                            </div>
                        </div>
                    </div>
                `;
                container.append(div);
            }
        });
}
