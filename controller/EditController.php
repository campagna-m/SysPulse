<?php
session_start();
require '../config/database.php';
require '../model/model.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../view/index.php');
    exit;
}

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