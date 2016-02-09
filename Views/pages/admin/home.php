 <?php
use Bourse\Controllers\Controller;

 
 require_once '../../../index_header.php';

  $controller = new Controller();
 //donne ledroit d'access a l'espace admin
 $controller->allow("admin");

?>
<hr>
<h1>Bienvenu sur l'espace administrateur </h1>
<?php


?>
