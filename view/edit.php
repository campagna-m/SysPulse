<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../view/index.php');
    exit;
}
require '../view/header.php';
require '../config/database.php';
require '../model/model.php';

$utilisateurs = getUsers();
$userAmodifier = null;

if (isset($_GET['id_utilisateur']) && $_GET['id_utilisateur'] != "") {
    $userAmodifier = getUserById($_GET['id_utilisateur']);
}
?>

<div class="container mt-5 text-center col-md-4">
    <h2 class="mb-4">Modifier un compte</h2>

    <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-success">Compte modifié</div>
    <?php } ?>

    <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger">Compte non modifié</div>
    <?php } ?>

    <form method="GET" action="edit.php" class="mb-4">
        <select name="id_utilisateur" class="form-select" onchange="this.form.submit()">
            <option value="">-- Choisir un utilisateur --</option>
            <?php foreach ($utilisateurs as $u) { ?>
                <option value="<?php echo $u['id']; ?>">
                    <?php echo $u['prenom'] . ' ' . $u['nom'] . ' (' . $u['login'] . ')'; ?>
                </option>
            <?php } ?>
        </select>
    </form>

    <?php if ($userAmodifier != null) { ?>
        <form method="POST" action="../controller/EditController.php">

            <input type="hidden" name="id" value="<?php echo $userAmodifier['id']; ?>">

            <input type="text" name="firstname" class="form-control mb-2" placeholder="Prénom" value="<?php echo $userAmodifier['prenom']; ?>" required>
            <input type="text" name="lastname" class="form-control mb-2" placeholder="Nom" value="<?php echo $userAmodifier['nom']; ?>" required>
            <input type="text" name="login" class="form-control mb-2" placeholder="Login" value="<?php echo $userAmodifier['login']; ?>" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Mot de passe" value="<?php echo $userAmodifier['password']; ?>" required>

            <select name="role" class="form-select mb-4">
                <option value="utilisateur" <?php if ($userAmodifier['role'] == 'utilisateur') echo 'selected'; ?>>Utilisateur</option>
                <option value="admin" <?php if ($userAmodifier['role'] == 'admin') echo 'selected'; ?>>Administrateur</option>
            </select>

            <button type="submit" class="btn btn-primary w-100 mb-2">Modifier</button>
            <a href="../view/index.php" class="btn btn-secondary w-100">Retour</a>
        </form>
    <?php } else { ?>
        <a href="../view/index.php" class="btn btn-secondary w-100">Retour</a>
    <?php } ?>
</div>

<?php require '../view/footer.php'; ?>