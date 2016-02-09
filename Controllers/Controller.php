<?php

namespace Bourse\Controllers;

//use Outils\Autoloader;
use Bourse\Controllers\App;
use Bourse\Models\Entitys\Societe;
use Bourse\Models\Entitys\Utilisateur;
use Bourse\Models\Tables\TableUtilisateur;
use Bourse\Outils\Validator;
use Bourse\Models\Data\MysqlDataBase;

/*
  require '../Outils/Autoloader.php';
  Autoloader::register();
 */

class Controller extends AppController {

    //affichage de la page index
    public function index($espace = null) {
        //$titre="Page d'accueil";

        $this->render("home", $espace);
    }

//--------------------------------------------inscription----------------------------//
//--------------------------------------------------------------------------//
    //affichage da la page d'inscription
    public function inscription() {

        $this->render("inscription");
    }

    //traitement du formulaire d'inscription
    public function sinscrire() {
        // $validate = false;

        $errors = [];

        if (isset($_POST['formInscription'])) {
            $data = array();
            $returns = $this->validateFormInscription($_POST);
            $errors = $returns['errors'];
            extract($returns['forms']);
            $data['errors'] = $errors;
            $data['post'] = $_POST;

            if (sizeof($errors) !== 0) {

                $this->redirect("index.php?p=inscription", $data);
            } else {
                //tous les champs sont validés insertion base de donnée
                //
                $password = password_hash($password, PASSWORD_BCRYPT);
                //niveau access=0 l'inscription doit etre valider par l'adminstrareur et change le niveauAccess vers statut 1
                $user = new Utilisateur($nom, $prenom, $login, $password, $email, '0');
                //generer le token de confirmation 
                $token = $this->generateToken();
                $user->setConfirmationToken($token);


                $res = $this->TableUtilisateur->inscrire($user);

                if (is_array($res)) {//login ou email existe deja ou niveau invalide
                    foreach ($res as $key => $value) {

                        // $data['errors'][$key]=$value;
                        $errors[$key] = $value;
                    }
                } else if ($res === true) {//si retour d'insertion est true
                    //detruire les variables de session erreur et formulaire s'il existe
                    unset($_SESSION["errors"]);
                    unset($_SESSION["post"]);
                    unset($data);
                    //--------toodo envoi de message 
                    $id = $this->pdo->lastInsertId();
                    $message = "Bonjour \n\n
                        Afin de confirmer votre inscription sur notre site veuillez cliquer sur ce lien:\n\n
                        http://localhost/Bourse/index.php?p=confirmInsciption&id=" . $id . "&token=" . $token;

                    $rest = $this->sendEmail($email, "Confirmation d'inscription sur notre site", $message);
                    if ($res) {
                        $data['success'] = "inscription effectué vous allez recevoir un mail de confirmation ";
                    } else {
                        $data['errors']['Errorinscription'] = "Erreur d'envoi de message de confirmation 
                            veuillez réesseyer une autre fois";
                    }
                    //test un petit test pour la confirmation en local
                    //*
                    header("location:index.php?p=confirmInsciption&id=" . $id . "&token=" . $token);
                    //*/
                } else {//$res==false
                    $errors['Errorinscription'] = "Probleme d'nscription veuillez reesayer une autre fois ";
                }


                $data['errors'] = $errors;

                //envoi des messages 
                $this->redirect("index.php?p=inscription", $data);
            }
        } else {
            $this->redirect();
        }
    }

    /*
      public function connexion() {

      $this->redirect('connexion');
      }
     * 
     */

    //----------------------------------------------------------------------------------------------
    //affichage de la page de connexion
    //-------------------------------------------------------------------------------------------
    public function connexion() {
        $this->testCookieAuth();
    }

//----------------------------------------------------------------------------------------------------
    //traitement du formulaire de connexion et access a l'espace personnel utilisateur ou admin
//-----------------------------------------------------------------------------------------------------
    public function seconnecter() {
        //recuperer les informations du formulaire
        if (isset($_POST["connexion"])) {
            $data = array();
            $errors = array();
            $data['post'] = $_POST;
            if (!empty($_POST["loginCon"]) && !empty($_POST["passwordCon"])) {
                $login = $_POST["loginCon"];

                $password = $_POST["passwordCon"];
                $res = $this->TableUtilisateur->login($login, $password);
                if ($res) {

                    //si niveau acces =1 redirection vers l'espace utilisateur
                    ///si niveau acces =2 redirection vers l'espace repesentant
                    //si niveauAccess= 9 redirection vers l'espace administrateur 
                    //si niveauAccess= -1 ou 0 affichage de la page login compte pas validé ou supprimé

                    if ($res->niveauAccess() === '1' || $res->niveauAccess() === '9' || $res->niveauAccess() === '2') {
                        //creation de variable de session et redirection vers page personnel
                        //mis a jour de  l'ancien token de securité

                        $_SESSION['token'] = md5(time() * rand(100, 450));
                        unset($_SESSION['errors']);
                        unset($_SESSION['post']);
                        unset($data);
                        $_SESSION["user"] = serialize($res);
                        if ($res->niveauAccess() === '1') {//espace personnel utilisateur
                            $_SESSION["level"] = 'user';
                            $this->redirect("espace/index");
                        } else if ($res->niveauAccess() === '9') {//redirection vers l'espace administrateur
                            $_SESSION["level"] = 'admin';
                            $this->redirect("admin/index");
                        } else if ($res->niveauAccess() === '2') {//redirection vers l'espace representant
                            $_SESSION["level"] = 'repres';
                            $this->redirect("repres/index");
                        }

                        //-------------traitement pour le bouton remember me------->>>>>>>>>>>><
                        if (isset($_POST['remember'])) {

                            //$crypt login+nom
                            $crypt = sha1($res->login() . $res->nom() . $_SERVER['REMOTE_ADDR']);
                            setcookie("auth", $res->id() . 'debut' . $crypt, time() + 60 * 60 * 24 * 2, "/", "localhost", false, true);
                        }
                    } else {
                        $errors['connexion'] = 'access refusé!!';
                        $data['errors'] = $errors;
                        $this->redirect("index.php?p=connexion", $data);
                    }
                } else {
                    $errors['connexion'] = 'Login ou mot de passe invalide!';
                    $data['errors'] = $errors;
                    $this->redirect("index.php?p=connexion", $data);
                }
            } else {
                $errors['connexion'] = 'Login et  mot de pass sont obligatoires!';
                $data['errors'] = $errors;
                $this->redirect("index.php?p=connexion", $data);
            }
        } else {
            $this->redirect("index.php?p=connexion");
        }
    }

    //----------------------------------formulaire nous contacter

    public function contact() {

        $this->render("contact");
    }

    //----------------traitement formulaire nous contacter
    public function contacter() {
        if (isset($_POST["formContact"])) {
            $errors = null;
            $data = null;
            //----------------sujet
            if (!empty($_POST['sujet'])) {
                $sujet = $_POST['sujet'];


                if (!Validator::validName($_POST['sujet'])) {
                    $errors['sujet'] = "sujet  invalide";
                }
            } else {

                $errors['sujet'] = 'Le sujet  est obligatoire';
            }
            //--------------------nom
            if (!empty($_POST['nom'])) {
                $nom = $_POST['nom'];


                if (!Validator::validName($_POST['nom'])) {
                    $errors['nom'] = "nom invalide";
                }
            } else {

                $errors['nom'] = 'Le nom est obligatoire';
            }

            //------------ prenom 
            //
           if (!empty($_POST['prenom'])) {
                $prenom = $_POST['prenom'];
                if (!Validator::validName($_POST['prenom'])) {
                    $errors['prenom'] = "prenom invalide";
                }
            } else {

                $errors['prenom'] = 'Le prenom est obligatoire';
            }

            //------------email
            if (!empty($_POST['email'])) {
                $email = $_POST['email'];
                if (!Validator::validEmail($_POST['email'])) {
                    $errors['email'] = "email  invalide";
                }
            } else {

                $errors['email'] = 'L\'adresse email est obligatoire';
            }
            //------------message
            if (!empty($_POST['message'])) {
                //var_dump($_POST['message']);
                // die("message");

                if (!Validator::validMessage($_POST['message'])) {
                    $errors['message'] = "message  invalide";
                }
            } else {

                $errors['message'] = 'le message est obligatoire';
            }


            if (sizeof($errors) !== 0) {
                $data['errors'] = $errors;
                $data['post'] = $_POST;
                $this->redirect("index.php?p=contact", $data);
            } else {
                //tous le champs sont valides envoi du mail pour l'administrateur 
                $data['errors'] = null;
                $mails = require 'Config/ConfigMail.php';
                $mailContact = $mails['mailContact'];
                $message = "Message de la part de" . $nom . " " . $prenom;
                $message.="/n Sujet : " . $sujet;
                $message.="/n mail :" . $email;
                $envoi = $this->sendEmail($mailContact, "contact", $message);
                if ($envoi) {
                    $data['success'] = "Votre message est bien été envoye";
                    //unset($data['post']);
                    unset($_SESSION['post']);
                } else {
                    $data['post'] = $_POST;

                    $data['errors']['envoi'] = "erreur d'envoi du message veuillez reesayer une autre fois";
                }
            }
            $this->redirect("index.php?p=contact", $data);
        } else {

            $this->redirect();
        }
    }

    //------affichage apge login mot de passe oubliée
    public function forgotLoginPass() {
        $this->render("forgot");
    }

    /**
     * traitement du formulaire login mot de pass oublie et envoi du mail pour initialiser lemot de passe
     */
    public function traitementforgot() {
        if (isset($_POST["forgot"])) {

            $data = array();

            $data['post'] = $_POST;
            if (!empty($_POST["email"])) {
                $email = $_POST["email"];
                if (!Validator::validEmail($email)) {
                    $data['error'] = "Email invalide";
                } else {

                    $res = $this->TableUtilisateur->find('email', $email);
                    if ($res) {
                        //si l'email existe envoi message pour renisisaliser le mot de passe

                        $token = $this->generateToken();
                        //enregistrer le token dans la base de donnée 
                        $req = "UPDATE  utilisateur SET token='" . $token . "' WHERE id=" . $res->id();

                        $resUp = $this->TableUtilisateur->updateTableUser($req);
                        if ($resUp) {
                            $message = "Bonjour" . $res->nom() . "/n";
                            $message.="Votre login est :" . $res->login() . "/n";
                            $message.="Afin de reinisialiser votre mot de passe veuillez cliquer sur ce lien:
                        http://localhost/Bourse/index.php?p=changePassword&id=" . $res->id() . "&token=$token";


                            $resSend = $this->sendEmail($res->email(), "Demande de réinisialisation de mot de passe", $message);
                            if (!$resSend) {
                                unset($_SESSION['post']);
                                unset($data['error']);
                                $data['success'] = 'Demande efectuee vous allez recevoir un message pour reinisialiser votre password!';
                            } else {
                                $data['error'] = "Erreur d'envoi de message Veuillez reesseyer une autre fois";
                            }
                            //test de reinisialisation a supprimé------
                            //*
                            $id=$res->id();
                           // header("location:index.php?p=changePassword&id=14785&token=" . $token);
                            header("location:index.php?p=changePassword&id=" . $res->id() . "&token=" . $token);

                            exit();
                            $data['success'] = 'Demande efectuee vous allez recevoir un message pour reinisialiser votre password!';
                            //*/
                        } else {
                            $data['error'] = 'Erreur database!';
                        }
                    } else {
                        $data['error'] = 'compte introuvable!';
                    }
                }
            } else {

                $data['error'] = 'Email est  obligatoire!';
            }
            $this->redirect("index.php?p=forgot", $data);
        } else {
            $this->redirect();
        }
    }
    
}

?>
