<?php
use Bourse\Controllers\Controller;

 
 require_once '../../../index_header.php';
 
  $controller = new Controller();
 //donne ledroit d'access a l'espace admin
 $level=$controller->allow("user");
echo 'home page espace';
?>
    <hr>
<h1>Bienvenu sur l'espace personnel</h1>
<?php
    var_dump("oooooooooooookkkkkkk");
   // var
    var_dump($_SESSION['user']);
  $user=  unserialize($_SESSION['user']);
  var_dump("iciiiiiiii");
  var_dump($user->niveauAccess());
    






/*
$user=new Utilisateur();
//$user= unserialize($_SESSION['user']);
var_dump($user);
*/
?>
