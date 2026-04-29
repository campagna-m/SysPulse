<?php
/**
 * @file header.php
 * @package Syspulse\View
 *
 * @brief En-tête HTML commun à toutes les pages de l'application.
 *
 * Ce fichier est inclus en début de chaque vue pour générer la section `<head>`
 * du document HTML ainsi que l'ouverture de la balise `<body>`. Il charge :
 * - La feuille de style personnalisée de l'application.
 * - La feuille de style Bootstrap (depuis node_modules).
 * - Le bundle JavaScript Bootstrap (chargement différé avec `defer`).
 *
 * @author Syspulse
 * @version 1.0
 */
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Feuille de style personnalisée de l'application -->
    <link href="/syspulse/public/css/style.css" rel="stylesheet">
    <!-- Framework CSS Bootstrap -->
    <link href="/syspulse/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bundle JavaScript Bootstrap (inclut Popper.js) -->
    <script src="/syspulse/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" defer></script>
    <title>Syspulse</title>
</head>
