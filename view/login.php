<?php

/**
 * @file login.php
 * @package Syspulse\View
 *
 * @brief Page de connexion de l'application Syspulse.
 *
 * Affiche le formulaire d'authentification permettant à un utilisateur
 * de saisir son login et son mot de passe. Appelle {@see getLogin()}
 * pour traiter la soumission du formulaire avant d'afficher la page.
 *
 * En cas d'identifiants incorrects, un message d'erreur Bootstrap est
 * affiché directement par la fonction {@see getLogin()}.
 *
 * @author Syspulse
 * @version 1.0
 */

session_start();
require '../config/database.php';
require '../model/model.php';

/**
 * @brief Traitement du formulaire de connexion.
 *
 * Appel préalable à l'affichage de la vue pour traiter les données POST
 * et éventuellement rediriger l'utilisateur s'il est authentifié.
 */
getLogin();
require '../view/header.php';
?>

<div class="container mt-5 text-center col-md-4">
    <!-- Logo de l'application -->
    <img src="../pictures/logoSyspulse.png" alt="Logo" class="img-fluid w-75 mb-4">

    <h2 class="mb-4">Connexion</h2>

    <!--
        Formulaire de connexion.
        Méthode POST vers login.php pour que getLogin() puisse traiter les champs.
    -->
    <form method="POST" action="../view/login.php">
        <input type="text" name="login" class="form-control mb-3" placeholder="Login" required>
        <input type="password" name="password" class="form-control mb-4" placeholder="Mot de passe" required>

        <button type="submit" class="btn btn-success w-100">Se connecter</button>
    </form>
</div>

<?php require '../view/footer.php'; ?>
