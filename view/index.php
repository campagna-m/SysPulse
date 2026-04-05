<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit;
}
require '../view/header.php';
?>

<div class="container mt-5 text-center col-md-4">
    <h2 class="mb-4">Bonjour <?php echo $_SESSION['prenom'] . " " . $_SESSION['nom']; ?></h2>

    <a href="../view/hardware.php" class="btn btn-primary w-100 mb-3">Matériel informatique</a>
    <a href="../view/software.php" class="btn btn-primary w-100 mb-4">Logiciel informatique</a>

    <?php if ($_SESSION['role'] === 'admin') { ?>
        <a href="../view/register.php" class="btn btn-primary w-100 mb-4">Créer un compte</a>
        <a href="../view/edit.php" class="btn btn-primary w-100 mb-4">Modifier un compte</a>
    <?php } ?>

    <hr>

    <a href="../view/logout.php" class="btn btn-danger w-100 mt-2">Déconnexion</a>
</div>

<?php require '../view/footer.php'; ?>