<?php

namespace Bourse\Models\Entitys;

class Utilisateur {

    private $id;
    private $nom;
    private $prenom;
    private $login;
    private $password;
    private $email;
    private $niveauAccess;
    private $dateInscription;
    private $confirmation_token;
    private $confirmed_at;
    private $token;//utiliser pour la réinisialisation du mot de passe

    //
    public function __construct() {//surchare d'un constructeur selon les arguments passés par la methode
        $nbArg = func_num_args();
        $args = func_get_args();
        if ($nbArg == 5 || $nbArg == 6) {//ordre nom prenom login password email niveauAccess
            $this->setNom($args[0]);
            $this->setPrenom($args[1]);
            $this->setLogin($args[2]);
            $this->setPassword($args[3]);
            $this->setEmail($args[4]);
            if (isset($args[5])) {
                $this->setNiveauAccess($args[5]);
            }
        } else if ($nbArg == 2) {//ordre  login password 
            $this->setLogin($args[0]);
            $this->setPassword($args[1]);
        }
    }

//    public function __construct($nom=null, $prenom, $login, $password, $email, $niveauAccess) {
//        $this->setNom($nom);
//        $this->setPrenom($prenom);
//        $this->setLogin($login);
//        $this->setPassword($password);
//        $this->setEmail($email);
//        $this->setNiveauAccess($niveauAccess);
//    }

    /* public function __construct() {


      } */

//les getters
    public function id() {

        return $this->id;
    }

    public function nom() {

        return $this->nom;
    }

    public function prenom() {

        return $this->prenom;
    }

    public function login() {

        return $this->login;
    }

    public function password() {

        return $this->password;
    }

    public function email() {

        return $this->email;
    }

    public function niveauAccess() {

        return $this->niveauAccess;
    }

    public function dateInscription() {

        return $this->dateInscription;
    }
    public function confirmationToken() {

        return $this->confirmation_token;
    }
    public function confirmedAt() {

        return $this->confirmed_at;
    }
      public function token() {

        return $this->token;
    }
//-----------------------------------------------------
    //les setters
    //---------------------------------------------------------
    public function setId($id) {

        $this->id = $id;
    }

    public function setNom($nom) {

        $this->nom = $nom;
    }

    public function setPrenom($prenom) {

        $this->prenom = $prenom;
    }

    public function setLogin($login) {

        $this->login = $login;
    }

    public function setPassword($password) {

        $this->password = $password;
    }

    public function setEmail($email) {

        $this->email = $email;
    }

    public function setNiveauAccess($niveau) {

        $this->niveauAccess = $niveau;
    }

    public function setDateInscription($date) {

        $this->dateInscription = $date;
    }

    public function setConfirmationToken($confirm) {

        $this->confirmation_token = $confirm;
    }

    public function setConfirmedAt($date) {

        $this->confirmed_at = $date;
    }
     public function setToken($token) {

        $this->token = $token;
    }


}

?>