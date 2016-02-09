<?php
use Bourse\Models\Data\MysqlDataBase;
use Bourse\Outils\App;
use Bourse\Views\Forms\Form;
use Bourse\Models\Data\DataBase;
use Bourse\Models\Tables\Table;
use Bourse\Models\Data\Entitys\Utilisateur;
use Bourse\Outils\Validator;
//**
define('ROOT', __DIR__);
//var_dump(ROOT);
require 'Outils/App.php';
App::load();



//----------test array
//


$tab=array();
$tab["un"]="1 chaine";
$tab["chaine"]="chaine";
var_dump($tab);
var_dump(extract($tab));
extract($tab);
var_dump($un);

//test token 

$chaine=time();
        var_dump($chaine);
        $chaine1=rand(100,900);
        var_dump($chaine1);
        $chaine=$chaine*$chaine1;
        var_dump($chaine);
        var_dump(sha1($chaine));
        $chaine=password_hash($chaine,PASSWORD_BCRYPT);
        var_dump($chaine);
        var_dump(strlen($chaine));

//-----------test date-----------

 $date=new \DateTime();
            var_dump($date);
            var_dump(NOW());
//test -------get_object_vars


$user=new Bourse\Models\Entitys\Utilisateur('login','passwoed');
var_dump($user);
var_dump(get_object_vars($user));
//------------test password
$password="salut";
$password1=password_hash($password,PASSWORD_BCRYPT );
var_dump($password1);
var_dump(password_verify($password,$password1));
    

               


//test regex
$result=Validator::validPassword("dddZ44");
//var_dump($result);
$res25=Validator::validEmail(1);
var_dump($res25);
 $rule="#^(?=.*\d)(?=.*[A-Z]).{6,12}$#";
echo"result--->>>><hr>";
if(preg_match($rule, "aZ1sss")){
    echo"yesssssssssss";
}else{
  echo"noooooooooooo";  
}
echo '<hr>';
//test class form
/**********todoo
$form=new Form('post'); 
echo $form;
//----------------------test md5 */

$prefix="salut";
$password="password";
$pass=md5($password.$password);
echo '-------->>'.$pass;
echo '<hr>';






 
/***********///test cryptage methode verman

$format = '(%1$2d = %1$04b) = (%2$2d = %2$04b)'
        . ' %3$s (%4$2d = %4$04b)' . "\n";

$values = array(0, 1, 2, 4, 8);
$test = 1 + 4;

echo "\n Bitwise AND \n";
foreach ($values as $value) {
    $result = $value & $test;
    printf($format, $result, $value, '&', $test);
}

echo "\n Bitwise Inclusive OR \n";
foreach ($values as $value) {
    $result = $value | $test;
    printf($format, $result, $value, '|', $test);
}
echo"<hr>";
echo "\n Bitwise Exclusive OR (XOR) \n";
foreach ($values as $value) {
    $result = $value ^ $test;
    echo"<hr>";
    printf($format, $result, $value, '^', $test);
}


//---------------------------------------------


$mysql=new MysqlDataBase();



$pdo=$mysql->getPdo();
/*
$sth=$pdo->prepare("SELECT * FROM utilisateur WHERE login=? AND password=?");
$sth->execute(array("admin1","admin1"));
$res=$sth->fetchAll(PDO::FETCH_CLASS,"Bourse\Models\Entitys\Utilisateur");
//$res=$pdo->excute(array("admin1","admin1"));
var_dump($res);
 * 
 * 
 */

$table=new Table($mysql);
$table01=new \Bourse\Models\Tables\TableUtilisateur($mysql);
$res=$table01->login("admin1", "admin1");
var_dump($res);
/*
$req="SELECT * FROM utilisateur  where id>?";
$res=$table01->login($req,"Utilisateur",array("admin1","admin1"));
var_dump($res);
//var_dump($table01->db);

/*
$res=$table01->query($req,[5],"Bourse\Models\Entitys\Utilisateur");
if(sizeof($res)==0){
    
    var_dump("pas de resultat");
}else{ var_dump("resultat");}
/*
foreach ($res as $value) {
    var_dump($value->login());
    
}
*/
//var_dump($res);
/*
var_dump(gettype($res[0]) );
echo '<hr><hr>';
foreach ($res as $value) {
    var_dump($res->password);
}
 
 /*
$req=$pdo->query($req);
//$re=$res->fetchAll(PDO::FETCH_CLASS,"Bourse\Models\Entitys\Utilisateur");
$result=$req->setFetchMode(PDO::FETCH_CLASS,"Bourse\Models\Entitys\Utilisateur");
$data=$req->fetchAll();
//var_dump($data);
foreach ($data as $value) {
    var_dump($value->login());
    
}
*/


/*

$req="SELECT * FROM utilisateur";
$res=$mysql->query($req);
var_dump($res);
var_dump(sizeof($res));
//$query="select *from utilisateur";
//$req=$pdo->exec("INSERT INTO utilisateur SET login='lilo',password='lilo'");
//$res=$req->fetchAll();
$req=$mysql->prepare("select *FROM utilisateur where id=?",['1'],'Utilisateur',false);
var_dump($req);

*/

?>
