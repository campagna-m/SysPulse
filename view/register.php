<?php

/**
 * @file register.php
 * @package Syspulse\View
 *
 * @brief Page de création d'un nouveau compte utilisateur (réservée aux administrateurs).
 *
 * Affiche le formulaire de création de compte. L'accès est protégé par un contrôle
 * de rôle : seuls les utilisateurs avec le rôle `admin` peuvent accéder à cette page.
 *
 * Des messages de retour sont affichés selon le résultat de la création :
 * - `?success=1` : le compte a été créé avec succès.
 * - `?error=1`   : la création a échoué (login déjà existant, etc.).
 *
 * La soumission du formulaire est traitée par {@see RegisterController.php}.
 *
 * @author Syspulse
 * @version 1.0
 */

session_start();

/**
 * @brief Contrôle d'accès : administrateurs uniquement.
 *
 * Redirige vers index.php si l'utilisateur n'a pas le rôle `admin`.
 */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../view/index.php');
    exit;
}
require '../view/header.php';
?>

<div class="container mt-5 text-center col-md-4">
    <h2 class="mb-4">Nouveau compte</h2>

    <?php
    /** @brief Message de succès affiché après une création réussie. */
    if (isset($_GET['success'])) { ?>
        <div class="alert alert-success">Compte créé</div>
    <?php } ?>

    <?php
    /** @brief Message d'erreur affiché en cas d'échec de la création. */
    if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger">Compte non créé</div>
    <?php } ?>

    <!--
        Formulaire de création de compte.
        Les champs firstname, lastname, login et password sont obligatoires.
        Soumis en POST vers RegisterController.php.
    -->
    <form method="POST" action="../controller/RegisterController.php">
        <input type="text" name="firstname" class="form-control mb-2" placeholder="Prénom" required>
        <input type="text" name="lastname" class="form-control mb-2" placeholder="Nom" required>
        <input type="text" name="login" class="form-control mb-2" placeholder="Login" required>
        <input type="password" name="password" class="form-control mb-4" placeholder="Mot de passe" required>

        <button type="submit" class="btn btn-primary w-100 mb-2">Créer</button>
        <a href="../view/index.php" class="btn btn-secondary w-100">Retour</a>
    </form>
</div>

<?php require '../view/footer.php'; ?>
