<?php

namespace Bourse\Models\Tables;

use Bourse\Models\Tables\Table;
use Bourse\Models\Entitys\Utilisateur;

class TableUtilisateur extends Table {

    public $table = "utilisateur";

    /**
     * 
     * @param type $id
     * @return boolean   si $id n'est pas integer sinon  return resultat de la requete
     */
    public function findId($id) {

        if (is_int($id)) {
            $req = 'SELECT * FROM utilisateur where id=?';
            $res = $this->query($req, array($id), "Bourse\Models\Entitys\Utilisateur", true);
            return $res;
        } else {
            return false;
        }
    }

    /*
     * @param login user
     * @param password user 
     * @return user if exesting in table utilisateur or null
     */

    public function login($login, $password) {

        $res = $this->findLogin($login);
        if ($res) {
//test si le mot de pass est bon


            $passRecup = $res->password();
            if (password_verify($password, $passRecup)) {
                return $res;
            }

            /* if ($password===$passRecup) {
              return $res;
              } */
        }
        return false;
    }

    /* recherche un utilisateur avec son login et un statut actif niveau access=1 ou 9 pour l'administrateur 
     * 
     * */

    public function findLogin($login) {
//recuperer les utilisateur avec le meme login et niveauAccess>0
        $req = "SELECT * FROM utilisateur WHERE login=? AND niveauAccess>0";


        $res = $this->query($req, array($login), "Bourse\Models\Entitys\Utilisateur", true);

        return $res;
    }

    public function inscrire(Utilisateur $user) {
        var_dump($user);

//test si le login existe deja dans la base de données

        $login = $user->login();
        $email = $user->email();

        //l'utilisateur existe deja 
        if ($this->findLogin($login)) {

            return array('login' => 'login existe deja!');
        } else if ($this->find('email', $email)) {

            return array('email' => 'email existe deja!');
        } else {

            //requete d'insertion avec un niveauAccess=0 
            // var_dump(get_object_vars($user));
            //$attributes=  get_object_vars($user);
            //var_dump($attributes);
            if ($user->niveauAccess() == null) {

                //premiere inscription par le formulaire inscription 
                $req = "INSERT INTO utilisateur 
                (nom,prenom,login,password,email,niveauAccess,dateInscription,confirmation_token) 
                VALUES(?,?,?,?,?,'0',NOW(),?)";
                $attributes = array(
                    $user->nom(), $user->prenom(), $user->login(), $user->password(), $user->email(),
                    $user->confirmationToken());
            } else {

                //if($user->niveauAccess()=='0'||$user->niveauAccess()=='1'){
                if (preg_match("[0|1|2|9|-1]", $user->niveauAccess())) {

                    $req = "INSERT INTO utilisateur 
                (nom,prenom,login,password,email,niveauAccess,dateInscription,confirmation_token) 
                VALUES(?,?,?,?,?,?,NOW(),?)";
                    $attributes = array(
                        $user->nom(), $user->prenom(), $user->login(), $user->password(), $user->email(),
                        $user->niveauAccess(), $user->confirmationToken());
                } else {

                    return array('niveau' => 'niveau invalide');
                }
            }

            $res = $this->query($req, $attributes);

            return $res;
        }
    }

    /**
     * renvoi la liste des utilisateurs
     * 
     */
    public function listeUsers() {

        //requete pour selectionner tous les utilisateurs
        $statement = "SELECT *FROM utilisateur";
        $res = $this->query($statement, null, 'Bourse\Models\Entitys\Utilisateur');

        return $res;
    }

    /**
     * mis a jour la table utilisateur 
     * @param type $statement la requete de mis ajour 
     * @param type $attributes
     */
    public function updateTableUser($statement, array $attributes = null) {

        $res = $this->query($statement, $attributes);
        return $res;
    }

    public function verifTokenPassword($id, $token) {


        $res = $this->findId(intval($id));
        if ($res) {

            return $res->token() === $token;
        }else{
            return false;
        }
    }

}

?>