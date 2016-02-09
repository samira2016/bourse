<?php

namespace Bourse\Models\Data;

use \PDO;
use Bourse\Models\Data\Config;
use Bourse\Models\Data\DataBase;

//use PDO;

/**
 * classe  de la connexion a la base mysql 
 * @author ATTAL
 */
class MysqlDataBase extends DataBase {

    private $db_name;
    private $db_user;
    private $db_password;
    private $db_host;
    public $pdo;

    public function __construct() {
//recuperer les config dans Config.php
        $config = Config::getInstance();
        $this->db_name = $config->get('db_name');
        $this->db_user = $config->get('db_user');
        $this->db_password = $config->get('db_password');
        $this->db_host = $config->get('db_host');
        $this->pdo = $this->getPdo();

        ;
    }

//methode de creation de pdo
    public function getPdo() {

        if (!$this->pdo) {
            try {

                $dsn = "mysql:dbname=$this->db_name;host=$this->db_host";
                $user = $this->db_user;
                $password = $this->db_password;
                $db = new PDO($dsn, $user, $password);
                $err = $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo = $db;
            } catch (\PDOException $e) {
                echo'-->erreur de connexion-->' . $e->getMessage();
               
                die($e->getMessage());
            }
        }
        return $this->pdo;
    }

    /*
     * methode qui execute  les requetes non préparée 
     * @param $statement la requete de type update delete insert 
     * @param $class pour le setFetchMode
     * @$one =false par defaut => recupere un seu resultat true =>recupere plusieur resultats
     * @return $req=$this->pdo($statement)pour lesrequetes de type update selete et insert
     * @return $data pour le reste 
     * 
     */

    public function query($statement, $class = null, $one = false) {
        var_dump($statement);
       

        $req = $this->pdo->query($statement);
        
        if (strpos($statement,"UPDATE") === 0 ||
                strpos($statement,"DELETE") === 0 ||
                strpos($statement,"INSERT") === 0) {
            return $req;
           
        }

        if ($class === null) {

            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {//recuperer le resutat sous forme de $class
            
            $req->setFetchMode(PDO::FETCH_CLASS, $class);
            
           
        }
        if ($one) {
            // var_dump("apre le if one-------");
            $datas = $req->fetch(); //recupere un seul enregistrement
        } else {
            
            $datas = $req->fetchAll();
         
        }
        return $datas;
    }

    /*
     * methode qui execute  les requetes  préparée 
     * @param $statement la requete de type update delete insert 
     * @param attributes le tableau 
     * @param $class pour le setFetchMode
     * @$one =false par defaut => recupere un seu resultat true =>recupere plusieur resultats
     * @return $req=$this->pdo($statement)pour lesrequetes de type update selete et insert
     * @return $data pour le reste 
     * 
     */

    public function prepare($statement, $attributes, $class = null, $one = false) {
       
        $req = $this->pdo->prepare($statement);
        $res = $req->execute($attributes);
       
        if (strpos($statement, "UPDATE") === 0 ||
                strpos($statement, "DELETE") === 0 ||
                strpos($statement, "INSERT") === 0) {
            return $res;
        }

        if ($class === null) {
            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {//recuperer le resutat sous forme de $class
            $req->setFetchMode(PDO::FETCH_CLASS, $class);
        }
        if ($one) {

            $datas = $req->fetch(); //recupere un seul enregistrement
        } else {
            $datas = $req->fetchAll();
        }
        return $datas;
    }

}

?>
