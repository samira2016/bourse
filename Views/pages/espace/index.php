<?php

use Bourse\Controllers\UserController;
use Bourse\Outils\App;
use Bourse\Models\Entitys\Utilisateur;
require_once '../../../index_header.php';

 $controller = new UserController();
 //donne le droit d'access a l'espace utilisateur 
 $controller->allow("user");

        if (isset($_GET['p'])) {
            $page = $_GET['p'];
        } else {

            $page = "home";
            //$titre="Page d'accueil";
        }
        if ($page === "home") {
            $titre = "Page";
            var_dump($titre);
            $controller->index("espace");
            //require ROOT.'/views/pages/home.php';
        } else if ($page === "deconnexion") {//affichage de la page de connexion
            //$titre="Connexion";
            $controller->deconnexion();
        }

?>