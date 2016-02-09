<?php
namespace Bourse\Models\Entitys;
use \Exception;
class Societe {

    private $nom;
    private $cp; //constant capital propre
    private $cb; //capital boursier
    private $nbta; //constant nombre total d'ation
    private $nbad; //nombre d'action disponible
    private $va; //valeur de l'action
    private $ac; //prix de l'action a l'achat
    private $email;

    function __construct($nom, $cp, $cb, $nbta, $nbad) {
        $this->setNom($nom);


        try {

            $this->setCp($cp);
            $this->setCb($cb);
            $this->setNbta($nbta);
            $this->setNbad($nbad);
        } catch (Exception $e) {
            echo"une exception  a ete lancee message : ".$e->getMessage();
        }


        $this->va = $this->calculVa();
        $this->ac = $this->calculAc();
        //$this->_cb=$this->calculCb();
    }

    //les getters

    public function nom() {

        return $this->nom;
    }

    public function cp() {

        return $this->cp;
    }

    public function cb() {

        return $this->cb;
    }

    public function nbta() {

        return $this->nbta;
    }

    public function nbad() {

        return $this->nbad;
    }

    public function va() {

        return $this->va;
    }

    public function ac() {

        return $this->ac;
    }

    public function email() {

        return $this->email;
    }

    //les setters

    public function setNom($nom) {

        $this->nom = $nom;
    }

    public function setCp($cp) {

        if (is_float($cp)) {

            $this->cp = $cp;
        } else {
            throw new Exception("nombre cp doit entre un float");
        }
    }

    public function setCb($cb) {
        if (is_float($cb)) {

            $this->cb = $cb;
        } else {
            throw new Exception("nombre cb doit entre un float");
        }
    }

    public function setNbta($nbta) {
        if (is_int($nbta)) {

            $this->nbta = $nbta;
        } else {
            throw new Exception("nombre nbta doit entre un entier");
        }
    }

    public function setNbad($nbad) {


        if (is_int($nbad)) {

            $this->nbad = $nbad;
        } else {
            throw new Exception("nombre nbad doit entre un entier");
        }
    }

    public function setVa($va) {
        if (is_float($va)) {
            $this->va = $va;
        } else {
            throw new Exception("va doit entre un de type  float");
        }
    }

    public function setAc($ac) {

        $this->ac = $ac;
    }

    public function setEmail($email) {
        //todoo
        /*
          1-validation de la variable email avec une methode validateMail dans mes outils
          2- une exeption si le champs mail n'est pas valide
         */

        $this->email = $email;
    }

    //--------------Calcul de va ac et cb
    //calcul de valeur de l'action
    public function calculVa() {

        return ($this->cp + $this->cb) / $this->nbta;
    }

    //calcul de prix de l'action a l'achat
    public function calculAc() {

        return $this->va * (1 + ($this->nbta - $this->nbad) / $this->nbta);
    }

    //calcul du capital boursier
    public function calculCb() {

        return $this->cp;
    }

}

?>