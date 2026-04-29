<?php

/**
 * @file logout.php
 * @package Syspulse\View
 *
 * @brief Déconnexion de l'utilisateur courant.
 *
 * Ce script détruit intégralement la session active (variables de session
 * et cookie de session), puis redirige l'utilisateur vers la page de connexion.
 *
 * Il ne produit aucun affichage HTML ; il effectue uniquement les opérations
 * de nettoyage de session et la redirection.
 *
 * @author Syspulse
 * @version 1.0
 */

session_start();

/** @brief Suppression de toutes les variables de session. */
session_unset();

/** @brief Destruction de la session côté serveur. */
session_destroy();

header('Location: ../view/login.php');
exit;
