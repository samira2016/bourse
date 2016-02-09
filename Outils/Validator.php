<?php

namespace Bourse\Outils;
/*
 * @author ATTAL
 */
class Validator {
    /*
     * valider un login utilisateur 
     * regle taille entre  8 et 12 caractere 
     * @return true or  false 
     */

    public static function validLogin($login) {

        return true;
    }

    /*
     * valide un email selon une regex
     * 
     */

    public static function validEmail($email) {

        $rule = "#^[a-zA-Z]+[a-zA-Z0-9\-_]*@[a-zA-Z]+[a-zA-Z0-9]{1,}.[a-zA-Z]{2,}$#";
        if (preg_match($rule, $email) === 1) {
            return true;
        }
            return false; 
        

       
    }

    /*
     * regles de gestion du mot de passe
     * 6=<taille<=12 
     * il contient au moin un chiffre et une majuscule
     */

    public static function validPassword($password) {
        
        if (strlen($password) >= 6 && strlen($password) <= 12) {
            
            $rule = "#^(?=.*\d)(?=.*[A-Z]).{6,12}$#";
            if (preg_match($rule, $password) === 1) {
                return true;
            }
        }
        return false;
    }

    public static function validName($name) {
       if (strlen($name) >= 2) {
            
            $rule = "#^[a-zA-Z]{2,}$#";
            if (preg_match($rule, $name) === 1) {
                return true;
            }
        }
        return false;
    }

    public static function validTel($tel) {
        
    }
    public static function validMessage($message) {
        return true;
        
    }

}

?>
