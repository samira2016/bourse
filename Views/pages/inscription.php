<?php

use Bourse\Views\Forms\FormBootstrap;

$post = null;


 
if (isset($_SESSION['post'])) {

    $post = $_SESSION['post'];
}
$form = new FormBootstrap($post);

if (isset($_SESSION['success'])) {
    echo'<p class="bg-success">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}
if(isset($_SESSION['errors']['Errorinscription'])){
     echo'<p class="bg-danger">' . $_SESSION['errors']['Errorinscription'] . '</p>';
    unset($_SESSION['errors']['Errorinscription']);
}
?>

<div class="col-md-11">
    <p>Pour s'inscrire a notre site veuillez remplir tous les champs obligatoires marqués par (*)</p>

    <form class="form-horizontal" method="post" action="index.php?p=sinscrire">
            <?= $form->hidden('formInscription') ?>

        <div class="form-group">
                <?= $form->label('nom') ?>
            <div class="col-sm-8">
                <?= $form->input('nom') ?>
                <?php
                if (isset($_SESSION['errors']['nom'])) {
                    echo'<span class="bg-danger">' . $_SESSION['errors']['nom'] . '</span>';
                }
                ?>

            </div>
        </div>
        <div class="form-group">
                <?= $form->label('prenom') ?>
            <div class="col-sm-8">
<?= $form->input('prenom') ?>
<?php
if (isset($_SESSION['errors']['prenom'])) {
    echo'<span class="bg-danger">' . $_SESSION['errors']['prenom'] . '</span>';
}
?>
            </div>
        </div>
        <div class="form-group">
                <?= $form->label('login') ?>
            <div class="col-sm-8">
<?= $form->input('login') ?>

            <?php
            if (isset($_SESSION['errors']['login'])) {
                echo'<span class="bg-danger">' . $_SESSION['errors']['login'] . '</span>';
            }
            ?>
            </div>           
        </div>
        <div class="form-group">
            <?= $form->label('mot de passe') ?>
            <div class="col-sm-8">       
                <?= $form->password('password') ?>
                <?php
                if (isset($_SESSION['errors']['password'])) {
                    echo'<span class="bg-danger">' . $_SESSION['errors']['password'] . '</span>';
                }
                ?>
            </div>
        </div>
        <div class="form-group">
                <?= $form->label('email') ?>
            <div class="col-sm-8">
<?= $form->input('email', 'email') ?>
<?php
if (isset($_SESSION['errors']['email'])) {
    echo'<span class="bg-danger">' . $_SESSION['errors']['email'] . '</span>';
}
?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
<?= $form->submit('valider') ?>
            </div>
        </div>
    </form>
</div>



<?php
if(isset($_SESSION['errors'])){
    
    unset($_SESSION['errors']);
}
?>














