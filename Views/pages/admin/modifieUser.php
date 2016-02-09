<?php

use Bourse\Controllers\Controller;
use Bourse\Views\Forms\FormBootstrap;

require_once '../../../index_header.php';
$levels = require '../../../Config/ConfigLevel.php';
$controller = new Controller();
//donne le droit d'access a l'espace admin
$controller->allow("admin");
$post = null;

/*
  if (isset($_SESSION['post'])) {
  $post = $_SESSION['post'];
  $id = isset($post['id'])?$post['id']:'';
  }
 */

if (isset($data['post'])) {

    $post = $data['post'];
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}


$form = new FormBootstrap($post);

if (isset($_SESSION['success'])) {
    echo'<p class="bg-success">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo'<p class="bg-danger">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}
?>


<h3>Modifer   un  utilisateur</h3>



<div class="col-md-11">


    <form class="form-horizontal" method="post" action="index.php?p=modifierUser">
        <?= $form->hidden('adminModifUser') ?>



        <div class="form-group">
            <?= $form->label('id') ?>
            <div class="col-sm-8">
                <?= $form->input('id', null, 'readonly') ?>


            </div>
        </div>

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
                <?= $form->input('login', null, 'readonly') ?>

                <?php
                if (isset($_SESSION['errors']['login'])) {
                    echo'<span class="bg-danger">' . $_SESSION['errors']['login'] . '</span>';
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
                <?= $form->select("niveauAccess", $levels, "niveauAccess") ?>
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
if (isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}
?>