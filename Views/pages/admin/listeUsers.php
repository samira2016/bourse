<?php

use Bourse\Controllers\Controller;

require_once '../../../index_header.php';

$controller = new Controller();
//donne ledroit d'access a l'espace admin
$controller->allow("admin");

if (isset($_SESSION['success'])) {
    echo'<p class="bg-success">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo'<p class="bg-danger">' . $_SESSION['error'] . '</p>';
     unset($_SESSION['error']);
}
if (isset($liste)) {
    ?>
    <p>filtre sur la liste </p>
    <form method="post" acton="index.php?">
        <select name="critere">
            <option name="cpValide">compte validé</option>
            <option name="cpNotValide">compte  non validé</option>
            <option name="cpSupprime">compte  supprimé</option>
            <option name="cpDesactive"> compte  désactivé</option>
        </select>
        <input type="submit" value="critere"/>

    </form>
    <table class="table table-bordered">

        <thead>
            <tr>

                <th>id</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Login</th>
                <th>Email</th>
                <th>Date inscription</th>
                 <th>Date confirmation</th>
                <th>Niveau access</th>
                <th>Activer/desactivé </th>
                <th>Supprimer</th>
                <th>Modifier</th>

            </tr>
            <?php
            foreach ($liste as $value) {
                ?> 
                <tr>

                    <td><?= $value->id() ?></td>
                    <td><?= $value->nom() ?></td>
                    <td><?= $value->prenom() ?></td>
                    <td><?= $value->login() ?></td>
                    <td><?= $value->email() ?></td>
                    <td><?= $value->dateInscription()?></td>
                    <td><?= $value->confirmedAt()?></td>
                    <td><?= $value->niveauAccess() ?></td>
                    <td ><a href="index.php?p=user.activer&id=<?= $value->id() ?>&&level=<?= $value->niveauAccess() ?>"><?php
        if ($value->niveauAccess() === '0') {
                    ?> <span class="glyphicon glyphicon-ok"></span>
                                <?php
                            } else {
                                ?> <span class="glyphicon glyphicon-remove"></span>
                                <?php
                            }
                            ?></a></td>

 

                    <td><a href="index.php?p=user.supprimer&id=<?= $value->id() ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
                    <td><a href="index.php?p=user.modifier&id=<?= $value->id() ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>



                </tr>
                <?php
            }
            ?>
        </thead> 
    </table>
    <?php
} else {
    echo"<h4>Pas de liste";
}
?>

