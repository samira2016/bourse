<?php

namespace Bourse\Outils;

/*
 * autheur samira
 * 19/12/2015
 * Systeme qui charge automatiquement les classes
 */

class Autoloader {

    static function register() {


        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    static function autoload($classe_name) {
        
        
        if (strpos($classe_name, 'Bourse') === 0) {

            $classe_name = str_replace('Bourse', '', $classe_name);
           // var_dump(ROOT . '/' . $classe_name . '.php');
            require ROOT . '/' . $classe_name . '.php';
            
        }
    }

}

?>
