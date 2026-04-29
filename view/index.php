<?php

/**
 * @file index.php
 * @package Syspulse\View
 *
 * @brief Page d'accueil de l'application Syspulse.
 *
 * Affiche le tableau de bord principal après connexion. Présente les liens
 * de navigation vers les pages matériel et logiciel, ainsi que les options
 * d'administration (création et modification de comptes) réservées aux
 * utilisateurs ayant le rôle `admin`.
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
require '../view/header.php';
?>

<div class="container mt-5 text-center col-md-4">
    <!-- Affichage du nom complet de l'utilisateur connecté -->
    <h2 class="mb-4">Bonjour <?php echo $_SESSION['prenom'] . " " . $_SESSION['nom']; ?></h2>

    <!-- Navigation principale : accès aux inventaires -->
    <a href="../view/hardware.php" class="btn btn-primary w-100 mb-3">Matériel informatique</a>
    <a href="../view/software.php" class="btn btn-primary w-100 mb-4">Logiciel informatique</a>

    <?php
    /**
     * @brief Affichage conditionnel des options d'administration.
     *
     * Les boutons "Créer un compte" et "Modifier un compte" ne sont
     * visibles que pour les utilisateurs avec le rôle `admin`.
     */
    if ($_SESSION['role'] === 'admin') { ?>
        <a href="../view/register.php" class="btn btn-primary w-100 mb-4">Créer un compte</a>
        <a href="../view/edit.php" class="btn btn-primary w-100 mb-4">Modifier un compte</a>
    <?php } ?>

    <hr>

    <!-- Bouton de déconnexion -->
    <a href="../view/logout.php" class="btn btn-danger w-100 mt-2">Déconnexion</a>
</div>

<?php require '../view/footer.php'; ?>
