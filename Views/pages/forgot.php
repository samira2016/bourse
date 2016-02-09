<?php
var_dump($_SESSION);

use Bourse\Views\Forms\FormBootstrap;

$post = null;
if (isset($_SESSION['post'])) {

    $post = $_SESSION['post'];
}
$form = new FormBootstrap($post);
?>
<div>


    <h3> J’ai oublié mon mot de passe</h3>

    <p>Saisissez l'adresse email de votre compte web puis cliquez sur valider.
        Vous recevrez ensuite par e-mail un lien. Une fois ce lien cliqué, vous pourrez 
        facilement créer votre nouveau mot de passe.</p>
    <?php
    if (isset($_SESSION['success'])) {
        echo'<p class="bg-success">' . $_SESSION['success'] . '</p>';
        unset($_SESSION['success']);
    }

    if (isset($_SESSION['error'])) {
        echo'<p class="bg-danger">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    ?>
    <form action="index.php?p=traitementForgot" method="post" class="form-horizontal">
        <div class="form-group">
            <?= $form->hidden("forgot") ?>
            <?= $form->label('email') ?>
            <div class="col-sm-8">
                <?= $form->input('email') ?>
                <?= $form->submit("Valider") ?>

            </div>
        </div>
    </form>


</div>
