<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../view/index.php');
    exit;
}
require '../view/header.php';
?>

<div class="container mt-5 text-center col-md-4">
    <h2 class="mb-4">Nouveau compte</h2>

    <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-success">Compte créé</div>
    <?php } ?>

    <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger">Compte non créé</div>
    <?php } ?>

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