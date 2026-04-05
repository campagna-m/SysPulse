document.getElementById('searchInput').oninput = function () {

    let recherche = this.value.toLowerCase();
    let lignes = document.querySelectorAll('#table tbody tr');

    lignes.forEach(function (ligne) {
        let texteLigne = ligne.textContent.toLowerCase();
        if (texteLigne.includes(recherche)) {
            ligne.style.display = "";
        } else {
            ligne.style.display = "none";
        }
    });
};

let toutesLesCases = document.querySelectorAll('input[type="checkbox"]');

toutesLesCases.forEach(function (uneCase) {
    uneCase.onchange = function () {

        let lesLignes = document.querySelectorAll('#table tbody tr');

        lesLignes.forEach(function (ligne) {
            let texteDeLaLigne = ligne.textContent.toLowerCase();

            let toutEstDecoche = true;
            let motTrouve = false;

            toutesLesCases.forEach(function (c) {

                if (c.checked === true) {
                    toutEstDecoche = false;

                    let motDeLaCase = c.value.toLowerCase();

                    if (texteDeLaLigne.includes(motDeLaCase)) {
                        motTrouve = true;
                    }
                }
            });

            if (toutEstDecoche === true) {
                ligne.style.display = "";
            }
            else if (motTrouve === true) {
                ligne.style.display = "";
            }
            else {
                ligne.style.display = "none";
            }
        });
    };
});