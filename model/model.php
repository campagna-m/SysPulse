<?php
require '../config/database.php';

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

function getUsers()
{
    global $pdo;

    $requete = $pdo->query("SELECT * FROM utilisateurs ORDER BY nom ASC");

    return $requete->fetchAll();
}

function getUserById($id)
{
    global $pdo;

    $requete = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $requete->execute([$id]);

    return $requete->fetch();
}

function updateUser($id, $prenom, $nom, $login, $password, $role)
{
    global $pdo;

    $requete = $pdo->prepare("UPDATE utilisateurs SET prenom = ?, nom = ?, login = ?, password = ?, role = ? WHERE id = ?");

    return $requete->execute([$prenom, $nom, $login, $password, $role, $id]);
}