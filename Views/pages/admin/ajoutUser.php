<?php

use Bourse\Controllers\Controller;
use Bourse\Views\Forms\FormBootstrap;

require_once '../../../index_header.php';
/*recuperer les  valeurs niveaux d'access*/
$levels=require '../../../Config/ConfigLevel.php';

$controller = new Controller();
//donne le droit d'access a l'espace admin
$controller->allow("admin");
$post = null;

if (isset($_SESSION['post'])) {
    $post = $_SESSION['post'];
}


if (isset($data['post'])) {
    
    $post = $data['post'];
}
$form = new FormBootstrap($post);

if (isset($_SESSION['success'])) {
    echo'<p class="bg-success">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}
if (isset($_SESSION['errors']['Errorinscription'])) {
    echo'<p class="bg-danger">' . $_SESSION['errors']['Errorinscription'] . '</p>';
    unset($_SESSION['errors']['Errorinscription']);
}
?>


<h3>Ajouter   un nouveau utilisateur</h3>

<div class="col-md-11">


    <form class="form-horizontal" method="post" action="index.php?p=ajouterUser">
        <?= $form->hidden('adminAddUser') ?>

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
            <?= $form->label('niveau access') ?>
            <div class="col-sm-8">
                <?= $form->select("level",$levels) ?>
                <?php
                if (isset($_SESSION['errors']['level'])) {
                    echo'<span class="bg-danger">' . $_SESSION['errors']['level'] . '</span>';
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
//detruire les messages flash

if(isset($_SESSION['errors'])){
    unset($_SESSION['errors']);
} 


?>