<?php

use Bourse\Controllers\AdminController;
use Bourse\Outils\App;
use Bourse\Models\Entitys\Utilisateur;

require_once '../../../index_header.php';

$controller = new AdminController();
//donne ledroit d'access a l'espace admin
$controller->allow("admin");
if (isset($_GET['p'])) {
    $page = $_GET['p'];
} else {

    $page = "home";
    //$titre="Page d'accueil";
}
if ($page === "home") {
    $titre = "Page";
 
    $controller->index("admin");
} 
else if ($page === "homeSite") {
   
    $controller->homeSite();
} else if ($page === "listeUser") {//affichage de la liste des utilisateur
   
    $controller->afficheListeUsers();
} else if ($page === "addUser") {//affichage du formulaire ajout user
    
    $controller->ajoutUser();
} else if ($page === "ajouterUser") {//traitement ajout user
    $controller->ajouterUser();
} else if ($page === "user.activer") {//activer ou decactiver un compte
   
    
    $controller->activerUser($_GET['id'],$_GET['level']);
} else if ($page === "user.supprimer") {//supprimer un compte mettre son level a -1
   
    $controller->supprimerUser($_GET['id']);
} else if ($page === "user.modifier") {//affichage de la page pour modifier user 
   
    $controller->modifieUser($_GET['id']);
}  else if ($page === "modifierUser") {//traitement de modifiation user
    $controller->modifierUser();
}
else if ($page === "addSociete") {//affichage du formulaire ajout societe
   
    $controller->ajoutSociete();
}else if ($page === "ajouterSociete") {//traitement ajout societe
   
    $controller->ajouterSociete();
}  
else if ($page === "deconnexion") {//deconnexion
   
    $controller->deconnexion();
}else if ($page === "myspace") {
  //  var_dump("access");
    $controller->accessMyspace();
}

?>