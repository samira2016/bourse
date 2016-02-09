<?php
namespace Bourse\Models\Data;


/**
 * un singleton qui recupere les configurations de la base de donnée dans le fichier config.php
 *
 * @author ATTAL
 */
class Config {
    
    private static $_instance;
    private $settings=array();
    
    //a l'instanciation de la classe on recupere le tableau de configurations dans le fichier config.php
    public function __construct(){
        
        $this->settings=  require ROOT.'/Config/configDb.php';
      //
      //    var_dump($this->settings);
    }
    //methode getinstance pour le singleton
    public static  function getInstance(){
        
        if(!self::$_instance){
            self::$_instance=new Config();
            
        }
        return self::$_instance;
        
    }

    //recupere la une valeur du tableau settings
    public function get($key){
         
            if(isset($this->settings[$key])){
            
                return $this->settings[$key];
            }else{
                return null;
            }
    }
    
    
    
}

?>
