<?php

require_once 'index_header.php';

use Bourse\Controllers\Controller;

if (isset($_GET['p'])) {
    $page = $_GET['p'];
} else {

    $page = "home";
    //$titre="Page d'accueil";
}

$controller = new Controller();

//s$titre="home";
if ($page === "home") {
    $titre = "Page";
    // var_dump($titre);
    $controller->index();
    //require ROOT.'/views/pages/home.php';
}

//affichage de la page d'inscription
if ($page === "inscription") {

    $titre = "Inscription";
    $controller->inscription();
} else if ($page === "sinscrire") {//traitement inscription
    $controller->sinscrire();
} else if ($page === "connexion") {//affichage de la page de connexion
    $controller->connexion();
} else if ($page === "confirmInsciption") {//affichage de la page de confirmation d'inscription
    $controller->confirmInsciption();
} else if ($page === "confirmer") {//affichage de la page de confirmation d'inscription
    $controller->confirmer();
} else if ($page === "seconnecter") {
    $controller->seconnecter();
} else if ($page === "myspace") {

    $controller->accessMyspace();
} else if ($page === "contact") {

    $controller->contact();
} else if ($page === "contacter") {

    $controller->contacter();
} else if ($page === "forgot") {//login ou mot de passe oublié
    $controller->forgotLoginPass();
} else if ($page === "traitementForgot") {//traitement formulaire forgot login ou passe
    $controller->traitementForgot();
} else if ($page === "changePassword") {//affichage du formualire pour reinisialiser le mot de passe
    if (isset($_GET['id'], $_GET['token'])) {
        if ($controller->verifTokenPassword($_GET['id'],$_GET['token'])) {
            $controller->changePassword();
        } else {
            $controller->invalide();
        }
    } else {
        $controller->invalide();
    }

    // }
} else if ($page === "reinisialiserPass") {//traitement formulaire reinisialisation password
    $controller->reinisialiserPass();
}
?>