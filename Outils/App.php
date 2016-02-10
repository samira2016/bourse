<?php

namespace Bourse\Outils;

use Bourse\Outils\Autoloader;
use Bourse\Controllers\AppController;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of App
 *
 * @author ATTAL
 */
class App {

    public static function load() {
        session_start();
        

        //generer un token pour chaque session contreles failles CSRF
        if (!isset($_SESSION['tokenSession'])) {
            $_SESSION['tokenSession'] = md5(time() * rand(100, 450));
        }
        //--faille XSS 
        if (isset($_POST)) {

            foreach ($_POST as $key => $value) {
                
                $_POST[$key] = htmlspecialchars(trim($value));
                // $_POST[$key]= strip_tags($value);
                // addslashes($value);
                //strip_tags($value);
                // stripcslashes($value);
            }
            //*
            //----------------suppression des variables de session post et errors si success
            if (isset($_SESSION['success'])) {

                //unset($_SESSION['post'], $_SESSION['errors']);
            }

            //*/
        }
        //session.cookie_lifetime=0;
        
        require ROOT . '/Outils/Autoloader.php';
        Autoloader::register();

        $controller = new AppController();
        //$controller->testCookieAuth();
    }

}


?>
