<?php

namespace Bourse\Models\Tables;

use Bourse\Models\Data\DataBase;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Table
 *
 * @author ATTAL
 */
class Table {

    //put your code here
    //ajouter un element

    protected $table;
    public $db;

    //injection de dependance la $db de type DAtaBase dans notre cas MysqlDataBase
    public function __construct(DataBase $db) {
        $this->db = $db;
        //recuperation dinamique du nom de la table a partir du nomde la classe
        if (is_null($this->table)) {
            // var_dump(get_class($this));
            $name = get_class($this);
            $segms = explode("\\", $name);
            //  var_dump($segms);
            $end = end($segms);
            // var_dump($end);
            $table = str_replace('Table', '', $end);
            // var_dump($table);
            $this->table = strtolower($table);
            // var_dump($this->table);
        }
    }

    //les requetes 
    /*
     * @param $statement la requete 
     * attributs 
     * $one si true  recupere un seul  enregistrement sinon un tableau de resultat 
     */
    public function query($statement, $attributes = null, $class = null, $one = false) {

        if ($attributes) {

            return $this->db->prepare($statement, $attributes, $class, $one);
        } else {

            return $this->db->query($statement, $class, $one);
        }
    }

    //------------------------les actions d'un utilisateur 



    public function add() {
        
    }

    // supprimer un element
    public function delete($id) {
        
    }

    //mettre a jour 
    public function update($object) {
        
    }

    //selectionner un element ou plusieur
    public function select($statement) {
        
    }

    //selectionner tous les elements d'une table
    public function selectAll($table) {
        
    }
    
    
    
       /**
     * recherche une valeur d'un champ dans une table
     * @param string $element le champ a recherché
     * @param string $value sa valeur
      *@param booleen $one si true recupere un seul enregistrement false recupere tous
     */
    public function find($element, $value,$one=true) {
       
        $req = "SELECT * FROM $this->table WHERE $element=?";
        $class="Bourse\Models\Entitys\\".ucfirst($this->table);  
        return $res=$this->query($req, [$value], $class,true);
        
    }
}

?>
