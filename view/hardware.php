<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit;
}
require 'header.php';

$json = file_get_contents('../data.json');
$datas = json_decode($json, true);
?>

<div class="container mt-5 text-center">
    <h2 class="mb-4">Matériel informatique</h2>

    <div class="mb-3 text-start">

        <input type="text" id="searchInput" class="form-control-sm" placeholder="Rechercher...">

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="info1" value="info1">
            <label class="form-check-label" for="info1">Info1</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="info2" value="info2">
            <label class="form-check-label" for="info2">Info2</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="info3" value="info3">
            <label class="form-check-label" for="info3">Info3</label>
        </div>
        
    </div>

    <table class="table table-bordered table-striped" id="table">
        <thead class="table-dark">
            <tr>
                <th>Poste</th>
                <th>Emplacement</th>
                <th>CPU</th>
                <th>RAM</th>
                <th>GPU</th>
                <th>Disques</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datas as $data) { ?>
                <tr>
                    <td><?php echo $data['nomDuPoste']; ?></td>
                    <td><?php echo $data['emplacement']; ?></td>
                    <td><?php echo $data['hardware']['cpu']; ?></td>
                    <td><?php echo $data['hardware']['ram']; ?> MB</td>
                    <td><?php echo $data['hardware']['gpu']; ?></td>
                    <td>
                        <?php foreach ($data['hardware']['lecteurs'] as $lecteur) { ?>
                            <?php echo $lecteur['nom']; ?> :
                            <?php echo $lecteur['espaceLibre']; ?> / <?php echo $lecteur['espaceTotal']; ?> MB
                            <br>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary mt-3">Retour</a>
</div>

<script src="../js/filter.js"></script>

<?php require '../view/footer.php'; ?>