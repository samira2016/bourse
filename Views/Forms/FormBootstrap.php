<?php

namespace Bourse\Views\Forms;

/**
 * 01/01/2016
 * Description of Form
 * class Form génére les champs d'un formualire
 *
 * @author ATTAL
 * 
 */
class FormBootstrap extends Form {

    protected $data;

    public function __construct($data = array()) {
        $this->data = $data;
    }

    /*
      @param $index  string index de la valeur a recupere
     * */

    protected function getValue($index) {

        if (is_object($this->data)) {
            return ($this->data->$index() !== null) ? $this->data->$index() : null;
        } else {
            return isset($this->data[$index]) ? $this->data[$index] : null;
        }
    }

    public function label($nom) {

        return '<label for=' . $nom . '  class="col-sm-2 control-label"  >' . strtoupper($nom) . ':</label>';
    }

    /*
     * 
     * champs de type text email 
     * @param $nom le nom du champs 
     * @param $contenu contenu du champs
     * @param $type le type du champ text email tel ....
     */

    public function input($nom, $type = null, $class = null) {

        $value = $this->getValue($nom);

        if ($type === null) {
            $type = 'text';
        }

        $value = $this->getValue($nom);
        return '<input type="text" name="' . $nom . '"   id="' . $nom . '" value="' . $value . '"  class="form-control  " ' . $class . '/>';
    }

    /*
     * champs de type password 
     */

    public function password($nom) {
        return '<input type="password" name="' . $nom . '" value="' . $this->getValue($nom) . '"  id="' . $nom . '"  class="form-control"/>';
    }

    /*
     * button de type submit 
     */

    public function submit($nom) {

        return '<button type="submit"  id="' . $nom . '" class="btn btn-default">' . $nom . '</button>';
    }

    /*
     * champs de type hidden
     */

    public function hidden($nom, $value = null) {

        return '<input type="hidden" name="' . $nom . '" value="' . $value . '"> ';
    }

    /**
     * 
     * @param type $nom
     * @param type $value
     * @param type $selected
     * @return string
     */
    public function select($nom, $value = array(), $selected = null) {
       
        $select = '<select  class="form-control" name="' . $nom . '">';

        foreach ($value as $key => $value) {
           
            if (isset($selected)) {
                if ($key == $this->getValue($selected)) {  
                    $select.='<option value="' . $key . '" selected>' . $value . ' : ' . $key . '</option>';
                }else{
                    $select.='<option value="' . $key . '">' . $value . ' : ' . $key . '</option>';
                }
            }else{
                $select.='<option value="' . $key . '">' . $value . ' : ' . $key . '</option>';
            }    
        }  
        $select.=' </select>';
        return $select;
    }

    
    //**********************************text area
    
    public function textarea($nom,$value=null){
        return "<textarea class='form-control' rows='4' name='".$nom."' >".$this->getValue($nom)."</textarea>";
        
    }
   
}

?>
