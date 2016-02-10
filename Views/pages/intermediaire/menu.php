<?php

use Bourse\Controllers\Controller;

require_once '../../../index_header.php';

$controller = new Controller();
//donne ledroit d'access a l'espace admin

$controller->allow("intermediaire");
?>
    <header class="div_header">
    
    <nav role="navigation" class="nav_header">

        <ul>
            
            <li class="left" ><a title ="home Bourse" href="index.php?p=homeSite">BOURSE @NET</a></li>
             <li  class="center"><a href="index.php?p=homeSite">Accueil  </a></li>
                <li> <a href="index.php?p=listeUser">La liste des inscrits </a></li>
                   <li><a href="index.php?p=addUser">Ajouter un utilisateur </a></li>
                <li> <a href="index.php?p=addSociete">Ajouter une societe </a></li>
               
                <li class="right"> <a href="index.php?p=deconnexion" >
                        Se deconnecter <span class="glyphicon glyphicon-log-out""></span></a></li>
            </ul>
       
    </nav>

</header>