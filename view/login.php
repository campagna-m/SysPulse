<?php
session_start();
require '../config/database.php';
require '../model/model.php';
getLogin();
require '../view/header.php';
?>

<div class="container mt-5 text-center col-md-4">
    <img src="../pictures/logoSyspulse.png" alt="Logo" class="img-fluid w-75 mb-4">

    <h2 class="mb-4">Connexion</h2>

    <form method="POST" action="../view/login.php">
        <input type="text" name="login" class="form-control mb-3" placeholder="Login" required>
        <input type="password" name="password" class="form-control mb-4" placeholder="Mot de passe" required>

        <button type="submit" class="btn btn-success w-100">Se connecter</button>
    </form>
</div>

<?php require '../view/footer.php'; ?>