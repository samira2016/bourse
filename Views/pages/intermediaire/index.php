<?php

use Bourse\Controllers\UserController;
use Bourse\Outils\App;
use Bourse\Models\Entitys\Utilisateur;

require_once '../../../index_header.php';

$controller = new UserController();
//donne le droit d'access a l'espace utilisateur 
$controller->allow("intermediaire");

if (isset($_GET['p'])) {
    $page = $_GET['p'];
} else {

    $page = "home";
    //$titre="Page d'accueil";
}
if ($page === "home") {
    $titre = "Page";

    $controller->index("intermediaire");
    //require ROOT.'/views/pages/home.php';
} else if ($page === "deconnexion") {//affichage de la page de connexion
    //$titre="Connexion";
    $controller->deconnexion();
} else if ($page === "myspace") {

    $controller->accessMyspace();
} else if ($page === "homeSite") {

    $controller->homeSite();
}
?>