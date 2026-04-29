/**
 * @file filter.js
 * @package Syspulse\JS
 *
 * @brief Gestion du filtrage dynamique des tableaux d'inventaire.
 *
 * Ce script fournit deux mécanismes de filtrage pour les tableaux HTML
 * identifiés par l'id `table` :
 *
 * 1. **Recherche textuelle** : filtre les lignes en temps réel selon la saisie
 *    dans le champ `#searchInput`.
 *
 * 2. **Filtrage par cases à cocher** : affiche uniquement les lignes dont le
 *    contenu correspond à au moins une case cochée. Si aucune case n'est
 *    cochée, toutes les lignes sont affichées.
 *
 * Les deux mécanismes opèrent sur le contenu textuel de chaque ligne (`textContent`)
 * converti en minuscules pour une comparaison insensible à la casse.
 *
 * @author Syspulse
 * @version 1.0
 */

/**
 * @brief Filtrage des lignes du tableau par recherche textuelle.
 *
 * Écoute l'événement `input` sur le champ de recherche `#searchInput`.
 * Pour chaque frappe, compare la valeur saisie (en minuscules) au contenu
 * textuel de chaque ligne du `<tbody>` du tableau.
 *
 * - Si le texte de la ligne contient la recherche → la ligne est affichée.
 * - Sinon → la ligne est masquée (`display: none`).
 *
 * @listens input sur #searchInput
 */
document.getElementById('searchInput').oninput = function () {

    /** @type {string} Terme de recherche en minuscules. */
    let recherche = this.value.toLowerCase();

    /** @type {NodeList} Toutes les lignes du corps du tableau. */
    let lignes = document.querySelectorAll('#table tbody tr');

    lignes.forEach(function (ligne) {
        /** @type {string} Contenu textuel de la ligne en minuscules. */
        let texteLigne = ligne.textContent.toLowerCase();
        if (texteLigne.includes(recherche)) {
            ligne.style.display = "";
        } else {
            ligne.style.display = "none";
        }
    });
};

/**
 * @type {NodeList} Collection de toutes les cases à cocher du formulaire de filtrage.
 */
let toutesLesCases = document.querySelectorAll('input[type="checkbox"]');

/**
 * @brief Filtrage des lignes du tableau par cases à cocher.
 *
 * Attache un gestionnaire `onchange` à chaque case à cocher.
 * À chaque changement d'état d'une case, réévalue la visibilité de chaque
 * ligne selon les règles suivantes :
 *
 * - Si aucune case n'est cochée → toutes les lignes sont affichées.
 * - Si au moins une case est cochée → seules les lignes dont le contenu
 *   correspond à au moins une des valeurs cochées sont affichées.
 *
 * La correspondance est effectuée en comparant la valeur (`value`) de chaque
 * case cochée au contenu textuel de la ligne, en minuscules.
 *
 * @listens change sur chaque input[type="checkbox"]
 */
toutesLesCases.forEach(function (uneCase) {
    uneCase.onchange = function () {

        /** @type {NodeList} Toutes les lignes du corps du tableau. */
        let lesLignes = document.querySelectorAll('#table tbody tr');

        lesLignes.forEach(function (ligne) {
            /** @type {string} Contenu textuel de la ligne en minuscules. */
            let texteDeLaLigne = ligne.textContent.toLowerCase();

            /** @type {boolean} Indique si aucune case n'est cochée. */
            let toutEstDecoche = true;

            /** @type {boolean} Indique si la ligne correspond à au moins une case cochée. */
            let motTrouve = false;

            toutesLesCases.forEach(function (c) {

                if (c.checked === true) {
                    toutEstDecoche = false;

                    /** @type {string} Valeur de la case cochée en minuscules. */
                    let motDeLaCase = c.value.toLowerCase();

                    if (texteDeLaLigne.includes(motDeLaCase)) {
                        motTrouve = true;
                    }
                }
            });

            if (toutEstDecoche === true) {
                /* Aucune case cochée : toutes les lignes sont visibles */
                ligne.style.display = "";
            }
            else if (motTrouve === true) {
                /* La ligne correspond à une case cochée */
                ligne.style.display = "";
            }
            else {
                /* La ligne ne correspond à aucune case cochée */
                ligne.style.display = "none";
            }
        });
    };
});
