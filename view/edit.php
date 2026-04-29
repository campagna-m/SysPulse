<?php

/**
 * @file edit.php
 * @package Syspulse\View
 *
 * @brief Page de modification d'un compte utilisateur (réservée aux administrateurs).
 *
 * Permet à un administrateur de sélectionner un utilisateur existant via une liste
 * déroulante, puis de modifier ses informations (prénom, nom, login, mot de passe,
 * rôle). La sélection de l'utilisateur se fait via un paramètre GET `id_utilisateur`,
 * qui déclenche le chargement du formulaire pré-rempli.
 *
 * Des messages de retour sont affichés selon le résultat de la modification :
 * - `?success=1` : la mise à jour a été effectuée avec succès.
 * - `?error=1`   : la mise à jour a échoué.
 *
 * La soumission du formulaire de modification est traitée par {@see EditController.php}.
 *
 * @author Syspulse
 * @version 1.0
 */

session_start();

/**
 * @brief Contrôle d'accès : administrateurs uniquement.
 *
 * Redirige vers index.php si l'utilisateur n'a pas le rôle `admin`.
 */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../view/index.php');
    exit;
}

require '../view/header.php';
require '../config/database.php';
require '../model/model.php';

/**
 * @var array $utilisateurs Liste de tous les utilisateurs récupérés via {@see getUsers()}.
 */
$utilisateurs = getUsers();

/**
 * @var array|null $userAmodifier Données de l'utilisateur sélectionné, ou null si aucun n'est sélectionné.
 */
$userAmodifier = null;

/**
 * @brief Chargement de l'utilisateur sélectionné.
 *
 * Si un `id_utilisateur` non vide est passé en GET, appelle {@see getUserById()}
 * pour récupérer ses données et pré-remplir le formulaire de modification.
 */
if (isset($_GET['id_utilisateur']) && $_GET['id_utilisateur'] != "") {
    $userAmodifier = getUserById($_GET['id_utilisateur']);
}
?>

<div class="container mt-5 text-center col-md-4">
    <h2 class="mb-4">Modifier un compte</h2>

    <?php
    /** @brief Message de succès affiché après une modification réussie. */
    if (isset($_GET['success'])) { ?>
        <div class="alert alert-success">Compte modifié</div>
    <?php } ?>

    <?php
    /** @brief Message d'erreur affiché en cas d'échec de la modification. */
    if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger">Compte non modifié</div>
    <?php } ?>

    <!--
        Formulaire de sélection de l'utilisateur à modifier.
        La soumission se fait en GET via `onchange` sur le select,
        ce qui recharge la page avec l'id sélectionné.
    -->
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
        <!--
            Formulaire de modification des informations de l'utilisateur sélectionné.
            Pré-rempli avec les valeurs actuelles de $userAmodifier.
            Soumis en POST vers EditController.php.
        -->
        <form method="POST" action="../controller/EditController.php">

            <!-- Champ caché transmettant l'identifiant de l'utilisateur à modifier -->
            <input type="hidden" name="id" value="<?php echo $userAmodifier['id']; ?>">

            <input type="text" name="firstname" class="form-control mb-2" placeholder="Prénom" value="<?php echo $userAmodifier['prenom']; ?>" required>
            <input type="text" name="lastname" class="form-control mb-2" placeholder="Nom" value="<?php echo $userAmodifier['nom']; ?>" required>
            <input type="text" name="login" class="form-control mb-2" placeholder="Login" value="<?php echo $userAmodifier['login']; ?>" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Mot de passe" value="<?php echo $userAmodifier['password']; ?>" required>

            <!--
                Sélection du rôle de l'utilisateur.
                L'option correspondant au rôle actuel est présélectionnée.
            -->
            <select name="role" class="form-select mb-4">
                <option value="utilisateur" <?php if ($userAmodifier['role'] == 'utilisateur') echo 'selected'; ?>>Utilisateur</option>
                <option value="admin" <?php if ($userAmodifier['role'] == 'admin') echo 'selected'; ?>>Administrateur</option>
            </select>

            <button type="submit" class="btn btn-primary w-100 mb-2">Modifier</button>
            <a href="../view/index.php" class="btn btn-secondary w-100">Retour</a>
        </form>
    <?php } else { ?>
        <!-- Aucun utilisateur sélectionné : affichage du bouton retour uniquement -->
        <a href="../view/index.php" class="btn btn-secondary w-100">Retour</a>
    <?php } ?>
</div>

<?php require '../view/footer.php'; ?>
