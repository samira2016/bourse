<?php

use Bourse\Views\Forms\FormBootstrap;

if (isset($_SESSION['success'])) {
    echo'<p class="bg-success">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo'<p class="bg-danger">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}



    $id =isset($_GET['id'])?$_GET['id']:null;
    $token=isset($_GET['token'])?$_GET['token']:null;

    $post = null;
    if (isset($_SESSION['post'])) {

        $post = $_SESSION['post'];
    }
    $form = new FormBootstrap($post);
    ?>
    <div style="border:1px solid black;">


        <h2>Votre nouveau mot de passe</h2>
        <p>Pour réinitialiser votre mot de passe, veuillez compléter les champs ci-dessous.</p>


        <form class="form-horizontal" method="post" action="index.php?p=reinisialiserPass">
            <?= $form->hidden('changePassword') ?>
            <?= $form->hidden('id', $id) ?>
                <?= $form->hidden('token', $token) ?>
            <div class="form-group">
                    <?= $form->label('Nouveau mot de passe') ?>
                <div class="col-sm-6">
                    <?= $form->password('newpass') ?>
                    <?php
                    if (isset($_SESSION['errors']['newpass'])) {
                        echo'<span class="bg-danger">' . $_SESSION['errors']['newpass'] . '</span>';
                    }
                    ?>

                </div>
            </div>
            <div class="form-group">
                    <?= $form->label('Veuillez confirmer votre mot de passe ') ?>
                <div class="col-sm-6">
                    <?= $form->password('confirmPass') ?>
                    <?php
                    if (isset($_SESSION['errors']['confirmPass'])) {
                        echo'<span class="bg-danger">' . $_SESSION['errors']['confirmPass'] . '</span>';
                    }
                    ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
    <?= $form->submit('Valider') ?>
                </div>
            </div>
        </form>


    </div>


    <?php
//} else {
   // echo"Ce lien n'est plus valide";
//}
if (isset($_SESSION['errors'])) {

    unset($_SESSION['errors']);
}

