window.addEventListener("load", () => {
    initTours();
    initArtists();
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
