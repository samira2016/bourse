<?php
use Bourse\Views\Forms\FormBootstrap;
$post=isset($_SESSION['post'])?$_SESSION['post']:null;
$form=new FormBootstrap($post);

if (isset($_SESSION['success'])) {
    echo'<p class="bg-success">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
    unset($_SESSION['post']);
}
if (isset($_SESSION['errors']['envoi'])) {
    echo'<p class="bg-danger">' . $_SESSION['errors']['envoi'] . '</p>';
    unset($_SESSION['errors']['envoi']);
}
?>
<div class="col-md-11">
    <p>Pour nous contacter veuillez remplir tous les champs obligatoires marqués par (*)</p>

    <form class="form-horizontal" method="post" action="index.php?p=contacter">
            <?= $form->hidden('formContact') ?>
        <div class="form-group">
                <?= $form->label('sujet') ?>
            <div class="col-sm-8">
                <?= $form->input('sujet') ?>
                <?php
                if (isset($_SESSION['errors']['sujet'])) {
                    echo'<span class="bg-danger">' . $_SESSION['errors']['sujet'] . '</span>';
                }
                ?>

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
                <?= $form->label('email') ?>
            <div class="col-sm-8">
<?= $form->input('email') ?>

            <?php
            if (isset($_SESSION['errors']['email'])) {
                echo'<span class="bg-danger">' . $_SESSION['errors']['email'] . '</span>';
            }
            ?>
            </div>           
        </div>
       
        <div class="form-group">
                <?= $form->label('message') ?>
            <div class="col-sm-8">
<?= $form->textarea('message') ?>
<?php
if (isset($_SESSION['errors']['message'])) {
    echo'<span class="bg-danger">' . $_SESSION['errors']['message'] . '</span>';
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