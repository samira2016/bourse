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

class Form {
    
    protected  $data;
   // protected  $surround="p"; 
    public function __construct($data=array()){
        $this->data=$data;
        
    }
    
   
    /**
	@param $html string code html a entourer par $surround
	return string
	**/

	protected function surround($html){
		return "<{$this->surround}>$html<{$this->surround}>";
	}
        /*
        @param $index  string index de la valeur a recupere
	**/
	protected function getValue($index){
		if(is_object($this->data)){
			return $this->data->$index;
		}

		return isset($this->data[$index]) ? $this->data[$index] : null;
	}
        /*
         * 
         * champs de type text 
         */
        public function input($nom ,$contenu=null){
		if($contenu!== null){
				$value=$contenu;
			}
			else {
				$value=$this->getValue($nom);
				}
		
			$value=$this->getValue($nom);
			return $this->surround(
	 		'<label for='.$nom .'>'.strtoupper($nom) .':</label>
			<input type="text" name="'.$nom. '"  id="'.$nom.'" value="'.$value.'"  />');
		
	}
/*
 * champs de type password 
 */
    
    public function password($nom){
		return $this->surround(
			'<label for='.$nom .'>'.strtoupper($nom) .':</label>
			<input type="password"   id="'.$nom.'"  name="'.$nom. '" value="'.$this->getValue($nom).'" />');
	}
    
    /*
     * button de type submit 
     */
    public function submit($nom){

		return $this->surround('<button type="submit"  id="'.$nom.'" >'.$nom. '</button>');
	}
    /*
     * champs de type hidden
     */
    public function hidden($nom){

		return '<input type="hidden" name="'.$nom.'"> ';
	}
    
    
    
    
    
    
    
    
    
    
    
}

?>
