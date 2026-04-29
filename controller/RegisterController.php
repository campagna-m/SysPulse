<?php

/**
 * @file RegisterController.php
 * @package Syspulse\Controller
 *
 * @brief Contrôleur d'inscription d'un nouvel utilisateur.
 *
 * Ce contrôleur traite la soumission du formulaire de création de compte.
 * Il vérifie les droits d'accès (rôle administrateur requis), génère automatiquement
 * un identifiant unique pour le nouvel utilisateur, puis appelle la fonction
 * d'enregistrement du modèle.
 *
 * Flux d'exécution :
 * - Si l'utilisateur n'est pas administrateur → redirection vers index.php
 * - Si les données POST sont valides et la création réussit → redirection avec `?success=1`
 * - Si la création échoue (login déjà existant, etc.) → redirection avec `?error=1`
 *
 * @author Syspulse
 * @version 1.0
 */

session_start();
require '../config/database.php';
require '../model/model.php';

/**
 * @brief Contrôle d'accès : seuls les administrateurs peuvent créer un compte.
 *
 * Redirige vers la page d'accueil si la session ne contient pas le rôle `admin`.
 */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../view/index.php');
    exit;
}

/**
 * @brief Traitement de la requête POST de création d'un nouvel utilisateur.
 *
 * Vérifie la présence du champ `firstname` dans les données POST.
 * Génère un identifiant unique sous la forme : première lettre du nom (minuscule)
 * suivie d'un nombre aléatoire entre 0 et 999 (ex. : `d42`).
 * Appelle ensuite {@see getRegister()} pour procéder à l'insertion en base.
 *
 * @uses $_POST['firstname'] Prénom du nouvel utilisateur.
 * @uses $_POST['lastname']  Nom de famille du nouvel utilisateur.
 * @uses $_POST['login']     Identifiant de connexion souhaité.
 * @uses $_POST['password']  Mot de passe du compte.
 */
if (isset($_POST['firstname'])) {
    $prenom = $_POST['firstname'];
    $nom = $_POST['lastname'];
    $login = $_POST['login'];
    $password = $_POST['password'];

    /**
     * @var string $id_genere Identifiant unique généré automatiquement.
     * Format : première lettre du nom en minuscule + nombre aléatoire (0–999).
     * Exemple : pour le nom "Dupont", l'id pourrait être "d317".
     */
    $id_genere = strtolower(substr($nom, 0, 1)) . rand(0, 999);

    if (getRegister($id_genere, $prenom, $nom, $login, $password)) {
        header("Location: ../view/register.php?success=1");
        exit;
    } else {
        header("Location: ../view/register.php?error=1");
        exit;
    }
}
