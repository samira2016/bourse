<?php

namespace Bourse\Controllers;

use Bourse\Models\Data\MysqlDataBase;
use Bourse\Models\Entitys\Utilisateur;
use Bourse\Models\Tables\TableUtilisateur;
use Bourse\Outils\Validator;

/*
 * @author ATTAL
 */

class AdminController extends Controller {

    //-------------------------------------------------------------------------------//
    //---------------------------------------Utilisateur------------------------//
    //-----------------------------------------------------------------------------//
    //affichage de la liste des utilisateurs 
    public function afficheListeUsers() {


        //recuperer la liste des utilisateurs 

        $liste = $this->TableUtilisateur->listeUsers();

        $data = array();

        $data['liste'] = $liste;

        $this->render("listeUsers", "admin", $data);
    }

    /**
     * affichage formulaire ajout utuilisateur aev un droit d'access
     */
    public function ajoutUser() {

        $this->render("ajoutUser", "admin");
    }

    //traitement ajout user
    public function ajouterUser() {

        $errors = [];
        if (isset($_POST['adminAddUser'])) {
            //recuperer le niveau d'access
            if (!empty($_POST['level'])) {
                $level = $_POST['level'];
            } else {
                $level = '0';
                // $errors['level'] = 'Veillez selectionner un level';
            }
            //------------ nom 
            //
           if (!empty($_POST['nom'])) {
                $nom = $_POST['nom'];
                if (!Validator::validName($nom)) {
                    $errors['nom'] = "nom invalide";
                }
            } else {
                $errors['nom'] = 'Le nom est obligatoire';
            }

            //------------ prenom 
            //
           if (!empty($_POST['prenom'])) {
                $prenom = $_POST['prenom'];
                if (!Validator::validName($prenom)) {
                    $errors['prenom'] = "prenom invalide";
                }
            } else {
                $errors['prenom'] = 'Le prenom est obligatoire';
            }
            //------------login
            if (!empty($_POST['login'])) {
                $login = $_POST['login'];
                if (!Validator::validLogin($login)) {
                    $errors['login'] = "Login invalide";
                }
            } else {
                $errors['login'] = 'Le login est obligatoire';
            }
            //------------password
            if (!empty($_POST['password'])) {
                $password = $_POST['password'];
                if (!Validator::validPassword($password)) {
                    $errors['password'] = "mot de passe  invalide";
                }
            } else {
                $errors['password'] = 'Le mot de pass est obligatoire';
            }
            //------------email
            if (!empty($_POST['email'])) {
                $email = $_POST['email'];
                if (!Validator::validEmail($email)) {
                    $errors['email'] = "email  invalide";
                }
            } else {

                $errors['email'] = 'L\'adresse email est obligatoire';
            }

            $data = array();
            $data['errors'] = $errors;
            $data['post'] = $_POST;


            if (sizeof($errors) !== 0) {

                $this->redirect("index.php?p=addUser", $data, 'admin');
            } else {
                //tous les champs sont validés insertion base de donnée
                //
                 $data['errors'] = null;
                $password = password_hash($password, PASSWORD_BCRYPT);
                //niveau access=0 l'inscription doit etre valider par l'adminstrareur et change leniveauAccess vers statut 1
                $user = new Utilisateur($nom, $prenom, $login, $password, $email, $level);
                $res = $this->TableUtilisateur->inscrire($user);
                if (is_array($res)) {//login existe deja ou niveau invalide
                    foreach ($res as $key => $value) {
                        $errors[$key] = $value;
                    }
                    $data['errors'] = $errors;
                } else if ($res === true) {//si retour d'insertion est true
                    $data = null;
                    //detruire les variables de session erreur et formulaire                     
                    unset($_SESSION["post"]);
                    unset($_SESSION["errors"]);
                    $data['success'] = "inscription effectué";
                } else {//$res==false
                    $errors['Errorinscription'] = "Probleme d'ajout  veuillez reesayer une autre fois ";
                    $data['errors'] = $errors;
                }

                //envoi du message 
                $this->redirect("index.php?p=addUser", $data, 'admin');
            }
        } else {
            $this->redirect();
        }
    }

    /**
     * active ou desactive un compte utilisateur 
     * pour l'activer   niveauAccess a 1 
     * pour le desactiver met le niveau a 0 
     * @param type $id
     * @param type $level
     */
    public function activerUser($id, $level) {
        $id = intval($id);
        $data = null;
        if ($this->TableUtilisateur->findId($id)) {
            //si level =0 en active le compte mettre niveauAccess=1
            if ($level === '0') {
                $req = "UPDATE utilisateur SET niveauAccess='1' WHERE id=?";
            } else if ($level === '1') {//en desactive le compte remettre a 0
                $req = "UPDATE utilisateur SET niveauAccess='0' WHERE id=?";
            } else {
                $this->redirect("index.php?p=listeUser", null, 'admin');
            }
            $res = $this->TableUtilisateur->updateTableUser($req, array($id));
            if ($res) {
                $data['success'] = "modification  effectué";
            } else {
                $data['error'] = "erreur de modification!";
            }
        } else {
            $data['error'] = "id n'existe pas";
        }

        $this->redirect("index.php?p=listeUser", $data, 'admin');
    }

    public function supprimerUser($id) {
// mettre niveauAccess=-1

        $data = null;
        $id = intval($id);
        if ($this->TableUtilisateur->findId($id)) {
            $req = "UPDATE utilisateur SET niveauAccess='-1' WHERE id=?";
            $res = $this->TableUtilisateur->updateTableUser($req, array($id));
            if ($res) {
                $data['success'] = "Compte supprime!";
            } else {
                $data['error'] = "Compte n'est pas supprime!";
            }
        } else {
            $data['error'] = "id n'existe pas!";
        }
        $this->redirect("index.php?p=listeUser", $data, 'admin');
    }

    //---------------------affichage de la page de modification 
    public function modifieUser($id) {
        $id = intval($id);
        $user = $this->TableUtilisateur->findId($id);
        if ($user) {
            $data['post'] = $user;
            $this->render("modifieUser", "admin", $data);
        } else {
            $data['error'] = "id n'existe pas!";
            $this->redirect("index.php?p=listeUser", $data, 'admin');
        }
    }

//------------------------------------------traitement modif user
    public function modifierUser() {

        $errors = [];
        $data = [];
        if (isset($_POST['adminModifUser'])) {
            $id = intval($_POST['id']);
            $user = $this->TableUtilisateur->findId($id);
            if ($user) {
                $returns = $this->validateFormInscription($_POST);
                $errors = $returns['errors'];
                extract($returns['forms']);

                if (!empty($_POST['niveauAccess'])) {
                    $level = $_POST['niveauAccess'];
                } else {

                    $errors['level'] = "Le niveau d'acces invalide";
                }
                $data['errors'] = $errors;
                $data['post'] = $_POST;
                if (sizeof($errors) !== 0) {
                    $this->redirect("index.php?p=user.modifier", $data, 'admin');
                } else {
                    //tous les champs sont validés insertion base de donnée
                    //mis ajour de user 
                    $data['errors'] = null;

                    $attributes = array($nom, $prenom, $email, $level);
                    $req = "UPDATE utilisateur SET nom=? ,prenom=?,email=?,niveauAccess=? WHERE id=" . $id;
                    $res = $this->TableUtilisateur->updateTableUser($req, $attributes);

                    if ($res) {//
                        unset($data);
                        unset($_SESSION['post']);
                        unset($_SESSION['errors']);
                        $data['success'] = "modification effectue!";
                    } else {//$res==false
                        $data['error'] = "modification non  effectue!";
                    }
                    $this->redirect("index.php?p=user.modifier", $data, 'admin');
                }
            } else {
                $data['error'] = "utilisateur n'existe pas!";
                $this->redirect("index.php?p=user.modifier", $data, 'admin');
            }
        } else {

            $this->redirect();
        }
    }

    //--------------------------------------------------------------------------------
    //******************************************************************/societe
//---------------------------------------------------------------------------------------
    //-----affichage page ajouter societe
    public function ajoutSociete() {


        $this->render("ajoutSociete", "admin");
    }

    //---------traitement formulaire ajout societe 
    public function ajouterSociete() {

        echo __FUNCTION__;
      
        die();
    }

//--------------------------------------------------------------------
    //----------------------lien menu
    //---------------------------------------------------------
    public function accessMyspace() {
        $this->render("home", "admin");
    }

}

?>
