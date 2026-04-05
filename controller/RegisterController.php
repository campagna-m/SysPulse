<?php
session_start();
require '../config/database.php';
require '../model/model.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../view/index.php');
    exit;
}

if (isset($_POST['firstname'])) {
    $prenom = $_POST['firstname'];
    $nom = $_POST['lastname'];
    $login = $_POST['login'];
    $password = $_POST['password'];

    $id_genere = strtolower(substr($nom, 0, 1)) . rand(0, 999);

    if (getRegister($id_genere, $prenom, $nom, $login, $password)) {
        header("Location: ../view/register.php?success=1");
        exit;
    } else {
        header("Location: ../view/register.php?error=1");
        exit;
    }
}