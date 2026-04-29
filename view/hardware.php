<?php

/**
 * @file hardware.php
 * @package Syspulse\View
 *
 * @brief Page d'inventaire du matériel informatique.
 *
 * Affiche un tableau récapitulatif du matériel de chaque poste informatique
 * (CPU, RAM, GPU, lecteurs de disque avec espace libre et total) à partir
 * des données contenues dans le fichier `data.json`.
 *
 * La page inclut un champ de recherche textuelle et des cases à cocher
 * pour filtrer les lignes du tableau dynamiquement côté client
 * (via {@see filter.js}).
 *
 * Accès protégé : redirige vers la page de connexion si aucune session
 * utilisateur n'est active.
 *
 * @author Syspulse
 * @version 1.0
 */

session_start();

/**
 * @brief Protection de la page par session.
 *
 * Redirige vers login.php si l'utilisateur n'est pas authentifié.
 */
if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit;
}
require 'header.php';

/**
 * @var string $json Contenu brut du fichier de données JSON.
 */
$json = file_get_contents('../data.json');

/**
 * @var array $datas Tableau associatif des postes informatiques décodé depuis le JSON.
 *                   Chaque entrée contient les clés : nomDuPoste, emplacement, hardware, software.
 */
$datas = json_decode($json, true);
?>

<div class="container mt-5 text-center">
    <h2 class="mb-4">Matériel informatique</h2>

    <!--
        Zone de filtrage : champ de recherche textuelle + cases à cocher par emplacement.
        Les interactions sont gérées par filter.js.
    -->
    <div class="mb-3 text-start">

        <!-- Champ de recherche textuelle sur l'ensemble du tableau -->
        <input type="text" id="searchInput" class="form-control-sm" placeholder="Rechercher...">

        <!-- Cases à cocher pour filtrer par salle/emplacement -->
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="info1" value="info1">
            <label class="form-check-label" for="info1">Info1</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="info2" value="info2">
            <label class="form-check-label" for="info2">Info2</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="info3" value="info3">
            <label class="form-check-label" for="info3">Info3</label>
        </div>

    </div>

    <!--
        Tableau d'inventaire matériel.
        Identifiant `table` utilisé par filter.js pour cibler les lignes.
    -->
    <table class="table table-bordered table-striped" id="table">
        <thead class="table-dark">
            <tr>
                <th>Poste</th>
                <th>Emplacement</th>
                <th>CPU</th>
                <th>RAM</th>
                <th>GPU</th>
                <th>Disques</th>
            </tr>
        </thead>
        <tbody>
            <?php
            /**
             * @brief Itération sur les postes pour générer les lignes du tableau.
             *
             * Pour chaque poste, les lecteurs de disque sont également itérés
             * afin d'afficher l'espace libre et l'espace total de chaque partition.
             */
            foreach ($datas as $data) { ?>
                <tr>
                    <td><?php echo $data['nomDuPoste']; ?></td>
                    <td><?php echo $data['emplacement']; ?></td>
                    <td><?php echo $data['hardware']['cpu']; ?></td>
                    <td><?php echo $data['hardware']['ram']; ?> MB</td>
                    <td><?php echo $data['hardware']['gpu']; ?></td>
                    <td>
                        <?php foreach ($data['hardware']['lecteurs'] as $lecteur) { ?>
                            <?php echo $lecteur['nom']; ?> :
                            <?php echo $lecteur['espaceLibre']; ?> / <?php echo $lecteur['espaceTotal']; ?> MB
                            <br>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary mt-3">Retour</a>
</div>

<!-- Script de filtrage dynamique du tableau -->
<script src="../js/filter.js"></script>

<?php require '../view/footer.php'; ?>
