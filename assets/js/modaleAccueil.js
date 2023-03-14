const backgroundModales = document.getElementById("backgroundModales");
const boutonModale1 = document.getElementById("boutonModale1");
const modale1 = document.getElementById("modale1");
const boutonsFermer = document.querySelectorAll(".fermer");
if (location.href.endsWith('/')) {

    function ouvrirModale1() {
        modale1.classList.add("active");
        backgroundModales.classList.add("active");
    }

    function fermerModales1() {
        modale1.classList.remove("active");
        backgroundModales.classList.remove("active");
    }


// Ajout des événements au clic des boutons
    boutonModale1.addEventListener("click", ouvrirModale1);
    backgroundModales.addEventListener("click", fermerModales1);

// Ajout des événements au clic des boutons de fermeture
    boutonsFermer.forEach((bouton) => {
        bouton.addEventListener("click", fermerModales1);
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            fermerModales1();
        }
    });
}


