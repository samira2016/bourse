<?php
use Bourse\Controllers\Controller;

 
 require_once '../../../index_header.php';
 
  $controller = new Controller();
 //donne le droit d'access a l'espace admin

 //$level=$controller->allow("intermediaire");
echo 'home page intermediaire';
?>
    <hr>
<h1>Bienvenu sur l'espace personnel</h1>
<?php
   
   
  $user=  unserialize($_SESSION['user']);
  
    






/*
$user=new Utilisateur();
//$user= unserialize($_SESSION['user']);
var_dump($user);
*/
?>
