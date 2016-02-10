<?php
namespace Bourse\Controllers;
use Bourse\Models\Entitys\Utilisateur;
/*
 * @author ATTAL
 */

class UserController extends Controller {

    //affichage de la page index
//    public function index() {
//        //$titre="Page d'accueil";
//
//
//        $this->render("home","espace");
//    }
    
/*
    //affichage da lapage d'inscription
    public function inscription() {
        $this->render("inscription");
    }

    //traitement du formulaire d'inscription
    public function sinscrire() {
        //recuperer les information du formulaire
        var_dump("dans si'nscrire");
//         if(!isset($_POST['inscription'])){
//            // var_dump("dans sinscrire");
//             
//         }
        $this->render("home");
    }

    //affichage de la page de connexion
    public function connexion() {
        //recuperer les information du formulaire
        var_dump("dans si'nscrire");

        $this->render("connexion");
    }

    //traitement du formulaire de connexion et acces a l'espace personnel utilisateur ou admin
    
    public function seconnecter() {
        //recuperer les information du formulaire
        if (isset($_POST["connexion"])) {

            if (!empty($_POST["login"]) && !empty($_POST["password"])) {
                $login = $_POST["login"];
                $password = $_POST["password"];

                $res = $this->TableUtilisateur->login($login, $password);

                var_dump("not empty---------->>");
                if ($res) {
                    $user=($res);
                    $_SESSION["user"]=$user;
                    echo"resultat bon";
                   // $this->forbidden();
                    $this->render("espace/index");
                    //cration de variable de session et redirection vers page personnel
                    
                }else{
                   echo"resultat pas bon";  
                   $this->render("connexion");
                }
                //var_dump($res);
            }
        }
        $this->render("connexion");
    }
    
    
    /*
     * @return true if $_SESSION['auth'] exist
     */
  /*
    public function logged(){
        return isset($_SESSION['auth']);
        
    }
*/

    //put your code here
}

?>
