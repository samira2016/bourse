<?php
use Bourse\Views\Forms\FormBootstrap;
$post=null;
if(isset($_SESSION['post'])){
    
    $post=$_SESSION['post'];
}
$form=new FormBootstrap($post);

?>
<div class="col-md-12">
   <?php if(isset($_SESSION['errors']['connexion'])){
            echo'<p class="bg-danger">'. $_SESSION['errors']['connexion'].'</p>';  
             unset($_SESSION['errors']['connexion']);
            }?>
<p>formulaire connexion</p>
<form class="form-horizontal" method="post" action="index.php?p=seconnecter">
     <?=$form->hidden('connexion')?>
  <div class="form-group">
     <?=$form->label('login')?>
    <div class="col-sm-8">
     <?=$form->input('loginCon')?>
        
    </div>
  </div>
  <div class="form-group">
    <?=$form->label('password')?>
    <div class="col-sm-8">
      <?=$form->password('passwordCon')?>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-8">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="remember"> Remember me
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
       <?=$form->submit('se connecter')?>
    </div>
  </div>
</form>
 
    </div>

<div class="col-md-12">
    <p><a href="index.php?p=forgot">Login ou mot de passe oublié?</a></p>
    <p>Vous n’avez pas encore de compte  ?<a href="index.php?p=inscription"> Créer un compte maintenant</a></p>
</div>

