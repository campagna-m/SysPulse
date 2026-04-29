<?php

/**
 * @file EditController.php
 * @package Syspulse\Controller
 *
 * @brief Contrôleur de modification d'un compte utilisateur.
 *
 * Ce contrôleur traite la soumission du formulaire de modification d'un utilisateur
 * existant. Il vérifie les droits d'accès (rôle administrateur requis), récupère
 * les données POST, puis appelle la fonction de mise à jour du modèle.
 *
 * Flux d'exécution :
 * - Si l'utilisateur n'est pas administrateur → redirection vers index.php
 * - Si les données POST sont valides et la mise à jour réussit → redirection avec `?success=1`
 * - Si la mise à jour échoue → redirection avec `?error=1`
 * - Si les données POST sont absentes → redirection vers edit.php
 *
 * @author Syspulse
 * @version 1.0
 */

session_start();
require '../config/database.php';
require '../model/model.php';

/**
 * @brief Contrôle d'accès : seuls les administrateurs peuvent accéder à ce contrôleur.
 *
 * Redirige vers la page d'accueil si la session ne contient pas le rôle `admin`.
 */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../view/index.php');
    exit;
}

/**
 * @brief Traitement de la requête POST de modification d'un utilisateur.
 *
 * Vérifie la présence des champs obligatoires `id` et `firstname` dans les données POST.
 * Extrait ensuite tous les champs du formulaire et appelle {@see updateUser()}.
 *
 * @uses $_POST['id']        Identifiant unique de l'utilisateur à modifier.
 * @uses $_POST['firstname'] Nouveau prénom de l'utilisateur.
 * @uses $_POST['lastname']  Nouveau nom de famille de l'utilisateur.
 * @uses $_POST['login']     Nouveau login de connexion.
 * @uses $_POST['password']  Nouveau mot de passe.
 * @uses $_POST['role']      Nouveau rôle (`utilisateur` ou `admin`).
 */
if (isset($_POST['id']) && isset($_POST['firstname'])) {

    $id = $_POST['id'];
    $prenom = $_POST['firstname'];
    $nom = $_POST['lastname'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (updateUser($id, $prenom, $nom, $login, $password, $role)) {
        header("Location: ../view/edit.php?success=1");
        exit;
    } else {
        header("Location: ../view/edit.php?error=1");
        exit;
    }
} else {
    header("Location: ../view/edit.php");
    exit;
}
