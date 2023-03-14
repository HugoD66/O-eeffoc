if (location.href.endsWith('/O-eeffoc/Actu')) {
    const backgroundModales = document.getElementById("backgroundModales");
    const boutonModale2 = document.getElementById("boutonModale2");
    const modale2 = document.getElementById("modale2");

    ouvrirModale2();
    boutonModale2.addEventListener("click", ouvrirModale2);
    backgroundModales.addEventListener("click", fermerModales2);
    function ouvrirModale2() {
        modale2.classList.add("active");
        backgroundModales.classList.add("active");
    }
    function fermerModales2() {
        if (modale2.hasAttribute("data-login-success")) {
            modale2.classList.remove("active");
            backgroundModales.classList.remove("active");
        }
    }
    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            fermerModales2();
        }
    });
}



