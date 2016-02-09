<?php

use Bourse\Controllers\Controller;
use Bourse\Views\Forms\FormBootstrap;

require_once '../../../index_header.php';
/* recuperer les  valeurs niveaux d'access */
$levels = require '../../../Config/ConfigLevel.php';

$controller = new Controller();
//donne le droit d'access a l'espace admin
$controller->allow("admin");
$post = null;

if (isset($_SESSION['post'])) {
    $post = $_SESSION['post'];
}


if (isset($data['post'])) {
    var_dump($data['post']);
    $post = $data['post'];
}
$form = new FormBootstrap($post);

if (isset($_COOKIE['success'])) {
    echo'<p class="bg-success">' . $_COOKIE['success'] . '</p>';
}
if (isset($_SESSION['errors']['Errorinscription'])) {
    echo'<p class="bg-danger">' . $_SESSION['errors']['Errorinscription'] . '</p>';
}
?>


<h3>Ajouter   une nouvele societe</h3>


<style>
    #div1{
        border: solid 1px black;
    }
    label{
        color: red;
        background-color: gray;
        width: 50%;
    }
</style>

<div class="col-md-11">


    <form class="form-horizontal" method="post" action="index.php?p=ajouterSociete">
        <?= $form->hidden('adminAddSociete') ?>

        <div class="form-group">
            <?= $form->label('societe') ?>
            <div class="col-sm-8">
                <?= $form->input('societe') ?>
                <?php
                if (isset($_SESSION['errors']['societe'])) {
                    echo'<span class="bg-danger">' . $_SESSION['errors']['societe'] . '</span>';
                }
                ?>

            </div>
        </div>
        <div class="form-group">
            <?= $form->label('capital propre') ?>
            <div class="col-sm-8">
                <?= $form->input('cp') ?>
                <?php
                if (isset($_SESSION['errors']['cp'])) {
                    echo'<span class="bg-danger">' . $_SESSION['errors']['cp'] . '</span>';
                }
                ?>
            </div>
        </div>
        <div class="form-group">
            <?= $form->label('capital boursier') ?>
            <div class="col-sm-8">
                <?= $form->input('cb') ?>

                <?php
                if (isset($_SESSION['errors']['cb'])) {
                    echo'<span class="bg-danger">' . $_SESSION['errors']['cb'] . '</span>';
                }
                ?>
            </div>           
        </div>
        <div class="form-group">
            <?= $form->label('nombre total d \'actions') ?>
            <div class="col-sm-8">       
                <?= $form->input('nbta') ?>
                <?php
                if (isset($_SESSION['errors']['nbta'])) {
                    echo'<span class="bg-danger">' . $_SESSION['errors']['nbta'] . '</span>';
                }
                ?>
            </div>
        </div>
        <div class="form-group" >
            <?= $form->label('nombre d\'action disponible') ?>
            <div class="col-sm-8">
                <?= $form->input('ndab') ?>
                <?php
                if (isset($_SESSION['errors']['ndab'])) {
                    echo'<span class="bg-danger">' . $_SESSION['errors']['ndab'] . '</span>';
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

