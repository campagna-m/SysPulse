<?php

/**
 * @file model.php
 * @package Syspulse\Model
 *
 * @brief Modèle de données principal de l'application Syspulse.
 *
 * Ce fichier regroupe toutes les fonctions d'accès à la base de données
 * pour la gestion des utilisateurs : authentification, création, lecture
 * et mise à jour des comptes.
 *
 * @author Syspulse
 * @version 1.0
 */

require '../config/database.php';

/**
 * @brief Authentifie un utilisateur à partir des données du formulaire de connexion.
 *
 * Vérifie les champs POST `login` et `password` contre la table `utilisateurs`.
 * En cas de succès, initialise les variables de session et redirige vers la page d'accueil.
 * En cas d'échec, affiche un message d'erreur Bootstrap.
 *
 * @global PDO $pdo Instance de connexion PDO.
 *
 * @return void
 *
 * @uses $_POST['login']    Identifiant saisi dans le formulaire.
 * @uses $_POST['password'] Mot de passe saisi dans le formulaire.
 * @uses $_SESSION          Variables de session initialisées : user_id, login, role, prenom, nom.
 */
function getLogin()
{
    global $pdo;

    if (isset($_POST['login']) && isset($_POST['password'])) {

        $requete = $pdo->prepare("SELECT * FROM utilisateurs WHERE login = ? AND password = ?");
        $requete->execute([$_POST['login'], $_POST['password']]);
        $user = $requete->fetch();

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['login']   = $user['login'];
            $_SESSION['role']    = $user['role'];
            $_SESSION['prenom']  = $user['prenom'];
            $_SESSION['nom']     = $user['nom'];

            header("Location: ../view/index.php");
            exit;
        } else {
            echo "<div class='alert alert-danger'>Identifiants incorrects.</div>";
        }
    }
}

/**
 * @brief Enregistre un nouvel utilisateur dans la base de données.
 *
 * Vérifie d'abord qu'aucun utilisateur n'existe déjà avec le même login.
 * Si le login est disponible, insère le nouveau compte avec le rôle `utilisateur`.
 *
 * @global PDO $pdo Instance de connexion PDO.
 *
 * @param string $id_genere Identifiant unique généré automatiquement pour l'utilisateur.
 * @param string $prenom    Prénom du nouvel utilisateur.
 * @param string $nom       Nom de famille du nouvel utilisateur.
 * @param string $login     Identifiant de connexion souhaité.
 * @param string $password  Mot de passe du compte.
 *
 * @return bool `true` si l'insertion a réussi, `false` si le login est déjà pris
 *              ou si l'insertion a échoué.
 */
function getRegister($id_genere, $prenom, $nom, $login, $password)
{
    global $pdo;

    $requete = $pdo->prepare("SELECT * FROM utilisateurs WHERE login = ?");
    $requete->execute([$login]);

    if ($requete->fetch()) {
        return false;
    }

    $insertion = $pdo->prepare("INSERT INTO utilisateurs (id, login, password, nom, prenom, role) VALUES (?, ?, ?, ?, ?, 'utilisateur')");
    return $insertion->execute([$id_genere, $login, $password, $nom, $prenom]);
}

/**
 * @brief Récupère la liste de tous les utilisateurs triés par nom.
 *
 * @global PDO $pdo Instance de connexion PDO.
 *
 * @return array Tableau associatif contenant tous les enregistrements
 *               de la table `utilisateurs`, triés par ordre alphabétique de nom.
 */
function getUsers()
{
    global $pdo;

    $requete = $pdo->query("SELECT * FROM utilisateurs ORDER BY nom ASC");

    return $requete->fetchAll();
}

/**
 * @brief Récupère un utilisateur par son identifiant unique.
 *
 * @global PDO $pdo Instance de connexion PDO.
 *
 * @param string $id Identifiant unique de l'utilisateur à rechercher.
 *
 * @return array|false Tableau associatif des données de l'utilisateur,
 *                     ou `false` si aucun utilisateur n'est trouvé.
 */
function getUserById($id)
{
    global $pdo;

    $requete = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $requete->execute([$id]);

    return $requete->fetch();
}

/**
 * @brief Met à jour les informations d'un utilisateur existant.
 *
 * Modifie le prénom, le nom, le login, le mot de passe et le rôle
 * de l'utilisateur identifié par son `$id`.
 *
 * @global PDO $pdo Instance de connexion PDO.
 *
 * @param string $id       Identifiant unique de l'utilisateur à modifier.
 * @param string $prenom   Nouveau prénom de l'utilisateur.
 * @param string $nom      Nouveau nom de famille de l'utilisateur.
 * @param string $login    Nouvel identifiant de connexion.
 * @param string $password Nouveau mot de passe.
 * @param string $role     Nouveau rôle (`utilisateur` ou `admin`).
 *
 * @return bool `true` si la mise à jour a réussi, `false` sinon.
 */
function updateUser($id, $prenom, $nom, $login, $password, $role)
{
    global $pdo;

    $requete = $pdo->prepare("UPDATE utilisateurs SET prenom = ?, nom = ?, login = ?, password = ?, role = ? WHERE id = ?");

    return $requete->execute([$prenom, $nom, $login, $password, $role, $id]);
}
