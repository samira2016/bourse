<?php

namespace Bourse\Controllers;

use Bourse\Models\Data\MysqlDataBase;
use Bourse\Models\Tables\TableUtilisateur;
use Bourse\Outils\Validator;

class AppController {

    protected $TableUtilisateur;
    protected $db;
    protected $pdo;

    public function __construct() {

        $this->db = new MysqlDataBase();

        $this->pdo = $this->db->getPdo();
        $this->TableUtilisateur = new TableUtilisateur($this->db);
    }

    public function homeSite() {
        $this->redirect();
    }

    /**
     * require le menu selon l'espace
     * 
     */
    protected function renderMenu($espace = null) {//require menu
        ob_start();
        if ($espace) {

            require ROOT . '/views/pages/' . $espace . '/menu.php';
        } else {
            require ROOT . '/views/pages/menu.php';
        }
        $menu = ob_get_clean();
        return $menu;
    }

    /*     * Require les pages 
     * 
     * @param type $view=page
     * @param type $espace=''|admin|espace
     */

    public function render($view, $espace = null, $data = []) {

        /* 1----menu-->>renderMenu() menu-espace--admin | espace personnel | site 
         * 2----centre de la page 
         *  3---default 
         */
        //------1
        $menu = $this->renderMenu($espace);

        extract($data);
        //ob_start();
        //------------2
        if ($espace) {

            require ROOT . '/views/pages/' . $espace . '/' . $view . '.php';
        } else {
            require ROOT . '/views/pages/' . $view . '.php';
        }

        //require ROOT/views/pages/espace/home.php
        //------------3    
        //------------require default.php
        $content = ob_get_clean();
        if ($espace) {
            require ROOT . '/views/pages/' . $espace . '/default.php';
        } else {
            require ROOT . '/views/pages/default.php';
        }
    }

    //redirection des pages
    /**
     * 
     * @param type $view la vue 
     * @param array $data les données a passer a al vue
     * 
     * @param type $espace admin|user|null par defaut
     */
    public function redirect($view = null, array $data = null, $espace = null) {

        if ($data) {
            foreach ($data as $key => $value) {
                $_SESSION[$key] = $value;
            }
        }
        if ($view) {
            //si $view contient index.php?p=
            if (strstr($view, '.php?')) {
                //$red = $_SERVER['DOCUMENT_ROOT'] . $view;

                if ($espace) {

                    header("location:" . ROOT . "/views/pages/" . $espace . "/" . $view);
                } else {
                    header("location:/Bourse/" . $view);
                }
            } else if (!strstr($view, '.php')) {

                header("location:views/pages/" . $view . ".php");
                //exp header("location:".ROOT."/views/pages/" index. ".php");$view =index
                //header("location:".ROOT."/views/pages/" . $view . ".php");
            }
        } else {
            header("location:/Bourse/index.php");
        }
    }

    /**
     * @param $niveau administrateur=admin ou utilisateur=user
     * @return true if $_SESSION['auth'] exist
     * */
    public function islogged($level) {

        if (isset($_SESSION['user']) && isset($_SESSION['level'])) {


            /*
             * todoo 
             * test si login et password existe dans database
             */

            return $_SESSION['level'] === $level;
        }
        return false;
    }

    /**
     * Donne le droit d'acces a l'espace admin si level=admin et espace utilisateur si level=user
     * @param type $level niveau d'acces admin ou user 
     * si isLogged()=true retourne true sinon forbidden()
     * 
     */
    public function allow($level) {

        if ($this->islogged($level)) {

            return true;
        } else {
            $this->forbidden();
        }
    }

    public function deconnexion() {

        //session_regenerate_id();

        $_SESSION[] = array();
        session_destroy();
        unset($_SESSION);

        if (isset($_COOKIE['auth'])) {

            setcookie("auth", "", time() - 60 * 60 * 24 * 2, "/", "localhost", false, true);
        }

        $this->redirect();
    }

    /*
     * erreur 403 si cces refusé
     */

    public function forbidden() {

        header('HTTP/1.1 403 Forbidden');
        die('Acces interdit');
    }

    /*
     * erreur 404 si cces refusé
     */

    public function notFound() {

        header('HTTP/1.1 404 not found');
        die('Page introuvable');
    }

    public function invalide() {

        $this->render("invalide");
    }

    /**
     * test l'existance dun cookie de connexion pour le bouton rememberme s'il existe redirect vers l'epace personnel
     */
    public function testCookieAuth() {


        //die("ici");
        if (!isset($_COOKIE['auth'])) {
            // $this->render('connexion');
            //test si SESSION['auth']
            if (isset($_SESSION['user']) && isset($_SESSION['level'])) {


                $redirect = $_SESSION['level'] . "/index";

                $this->redirect($redirect);
            } else {
                $this->render('connexion');
            }
        } else {


            $auth = $_COOKIE['auth'];
            $auth = explode("debut", $auth);

            $id = $auth[0];

            $crypt = $auth[1]; //login+nom+$_server[remote+addr]
            //requete pour treouve l'utilisateur qui correspend a id


            $id = intval($id);

            $res = $this->TableUtilisateur->findId($id);

            if ($res) {

                $cle = $res->login() . $res->nom() . $_SERVER['REMOTE_ADDR'];

                if (sha1($cle) === $crypt) {

                    $_SESSION["user"] = serialize($res);
                    if ($res->niveauAccess() === '1') {//espace personnel intermediaire
                        $_SESSION["level"] = 'intermediaire';
                        $this->redirect("intermediaire/index");
                    } else if ($res->niveauAccess() === '9') {//redirection vers l'espace administrateur
                        $_SESSION["level"] = 'admin';
                        $this->redirect("admin/index");
                    } else if ($res->niveauAccess() === '2') {//redirection vers l'espace representant
                        $_SESSION["level"] = 'representant';
                        $this->redirect("representant/index");
                    }
                } else {
                    $this->render("connexion");
                    setcookie("auth", "", time() - 60 * 60 * 24 * 2, "/", "localhost", false, true);
                }
            } else {//si cookie pas valide 
                setcookie("auth", "", time() - 60 * 60 * 24 * 2, "/", "localhost", false, true);
                $this->render("connexion");
            }
        }
    }

    //-----acces vers l'espace personel par le lien home-------------------------------------------------

    public function accessMyspace() {

        $this->testCookieAuth();
    }

    public function configAccessLevel() {
        $config = require '../Config/ConfigLevel.php';
        return $config;
    }

    public function sendEmail($to, $subject, $message, $additional_headers = null, $additional_parameters = null) {

        return mail($to, $subject, $message, $additional_headers, $additional_parameters);
    }

    /**
     * Verifie les champs de formualire d'inscription et renvoi les message d'erreur
     * @param type $post le formulaire
     * @return array un tableau d'erreur ou null
     */
    public function validateFormInscription($post) {
        $errors = null;
        $forms = array();
        if (isset($post)) {
            if (!empty($_POST['nom'])) {
                $forms['nom'] = $_POST['nom'];


                if (!Validator::validName($_POST['nom'])) {
                    $errors['nom'] = "nom invalide";
                }
            } else {

                $errors['nom'] = 'Le nom est obligatoire';
            }

            //------------ prenom 
            //
           if (!empty($_POST['prenom'])) {
                $forms['prenom'] = $_POST['prenom'];
                if (!Validator::validName($_POST['prenom'])) {
                    $errors['prenom'] = "prenom invalide";
                }
            } else {

                $errors['prenom'] = 'Le prenom est obligatoire';
            }
            //------------login
            if (!empty($_POST['login'])) {
                $forms['login'] = $_POST['login'];
                if (!Validator::validLogin($_POST['login'])) {
                    $errors['login'] = "Login invalide";
                }
            } else {

                $errors['login'] = 'Le login est obligatoire';
            }
            //------------password
            if (!empty($_POST['password'])) {
                $forms['password'] = $_POST['password'];
                if (!Validator::validPassword($_POST['password'])) {
                    $errors['password'] = "mot de passe  invalide";
                }
            } else {

                $errors['password'] = 'Le mot de pass est obligatoire';
            }
            //------------email
            if (!empty($_POST['email'])) {
                $forms['email'] = $_POST['email'];
                if (!Validator::validEmail($_POST['email'])) {
                    $errors['email'] = "email  invalide";
                }
            } else {

                $errors['email'] = 'L\'adresse email est obligatoire';
            }
        }
        return array('errors' => $errors, 'forms' => $forms);
    }

    /**
     * genere un token de confirmation
     * @param int  $size taille du token
     * @return string la token genéré
     */
    public function generateToken() {
        return password_hash(time() * rand(100, 900), PASSWORD_BCRYPT);
    }

    /**
     * affichage de la page de confirmation 
     */
    public function confirmInsciption() {
        $this->render("confirmInscription");
    }

    /**
     * traitement de confirmation d'une inscription 
     */
    public function confirmer() {
        $data = null;
        if (isset($_GET['id']) && isset($_GET['token'])) {

            $id = $_GET['id'];
            $token = $_GET['token'];

            $res = $this->TableUtilisateur->findId(intval($id));

            if ($res) {
                $tokenDb = $res->confirmationToken();

                if ($token === $tokenDb) {
                    $req = "UPDATE utilisateur SET confirmed_at=NOW() ,confirmation_token=null WHERE id=" . $id;

                    $res1 = $this->TableUtilisateur->updateTableUser($req);

                    if ($res1) {
                        $data['success'] = "Inscription confirmé";
                    } else {
                        $data['error'] = "Inscription non confirmé";
                    }
                    $this->redirect("index.php?p=confirmInsciption", $data);
                }
            }
            $this->redirect("index.php?p=confirmInsciption", $data);
        }
    }

    //affichage du formulaire de reinisialisation de mot de passe
    public function changePassword() {
        $this->render("changePassword");
    }

    /**
     * traitement du formulaire de reinisialisation de mot de passe
     */
    public function reinisialiserPass() {
        if (isset($_POST["changePassword"])) {

            $data = array();
            $errors = null;

            $data['post'] = $_POST;
            if (!empty($_POST["newpass"])) {
                $newpass = $_POST["newpass"];
                if (!Validator::validPassword($newpass)) {
                    $errors['newpass'] = "password invalide";
                }

                if (!empty($_POST["confirmPass"])) {
                    $confirmPass = $_POST["confirmPass"];

                    if ($newpass !== $confirmPass) {
                        $errors['confirmPass'] = "Mots de passe différents : Merci de saisir le même mot de passe";
                    }
                } else {
                    $errors['confirmPass'] = 'nouveau password est  obligatoire!';
                }
            } else {
                $errors['newpass'] = 'nouveau password est  obligatoire!';
            }
            $id = $_POST['id'];
            $token = $_POST['token'];

            if (sizeof($errors) !== 0) {
                $data['errors'] = $errors;
                $data['post'] = $_POST;
                $this->redirect("index.php?p=changePassword&id=" . $id . "&token=" . $token, $data);
            } else {
                //verifier s'il existe un utilisateur avec le meme id
                $res = $this->TableUtilisateur->verifTokenPassword($id, $token);

                if ($res) {

                    $req = "UPDATE utilisateur SET password=? ,token=null where id=" . $id;
                    $password = password_hash($newpass, PASSWORD_BCRYPT);
                    $resup = $this->TableUtilisateur->updateTableUser($req, [$password]);


                    $data['success'] = "Mot de passe reinisialise";
                    unset($_SESSION['post']);
                    unset($data['post']);

                    $this->redirect("index.php?p=changePassword&id=" . $id . "&token=" . $token, $data);
                } else {
                    $this->redirect("index.php?p=changePassword");
                }
            }
            $this->redirect("index.php?p=changePassword&id=" . $id . "&token=" . $token, $data);
        } else {
            $this->redirect();
        }
    }

    // */

    /**
     * 
     * @param type $id
     * @param type $token
     * @return boolean l'existence de id et de token de modification
     */
    public function verifTokenPassword($id, $token) {
        return $this->TableUtilisateur->verifTokenPassword($id, $token);
    }

}

?>
