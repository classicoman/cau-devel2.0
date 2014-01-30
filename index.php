<?php
use Framework\Inspector as Inspector;
use Framework\Doghouse as Doghouse;

include 'autoload.php';

/*
 * session_start();
$session = (isset($_SESSION['myusername'])) ?   true  :  false;
*/

//require_once '_basic.php';


/*
 * @params  
 *      $class  Direcció completa de la classe
 *              exemple: Framework\Database\Tables
 * @desc    Funció per a carregar les classes de forma dinàmica
 *          If we need to load the Framework\Database\Driver\Mysqlclass, we 
 *          will look for the file framework/database/driver/mysql.php(assuming 
 *          our frameworkfolder is in the PHP includepath)
 */


// Tells PHP to use the autoload()method to load a class file by name
spl_autoload_register('autoload');
// Tells PHP to use the Autoloader::autoload()method to load a class file by name
// //La comento perquè si no me declara les classes dues vegades!
//spl_autoload_register(array('autoloader', 'autoload'));            
            
//Dóna error si no tenc la taula definida.
//$table = new Tables();

/*
class Dog
{
    public $doghouse;
    public function goSleep()
    {
        $location = $this->doghouse->location;
        $smell = $this->doghouse->smell;
        echo "The doghouse is at {$location} and smells {$smell}.";
    }
}
 */
/*
class Doghouse
{
    public $location;
    public $smell;
}
 */
/*
$doghouse = new Doghouse();
$doghouse->location = "back yard";
$doghouse->smell = "bad";
 */
/*$dog = new Dog();
$dog->doghouse = $doghouse;
$dog->goSleep();*/

    
//Obtenir el comentari d'una classe;
$inspector = new Inspector("Doghouse");


class Car extends Framework\Base
{
    /**
    * @readwrite
    */
    protected $_color;
    /**
    * $write
    */
    protected $_model;
    
    public function __construct($color, $model) {
        $this->_model = $model;
        $this->_color = $color;
    }
    
    public function imprimir() {
        return "El meu cotxe es un ".$this->_model." de color ".$this->_color;
    }
}

$car = new Car('fiat panda','vermell');
echo $car->imprimir();






//$pg = isset($_GET['pg'])  ?  $_GET['pg']  :  "";

//Has the session been started?
/*
if ($session)
    include 'main.php';
else {
  
    if ($pg=="signup") {        
        include 'templates/signup.php';    
    } 
    else 
        if ($pg=='signupCheck') {
           include 'controllers/signupCheck.php';
           //$error ve del fitxer anterior
            if ($error!=0)  //El Sign Up s'ha fet el Sign Up
            { 
                include 'templates/signup.php';
            }
            else            //El Sign Up s'ha fet correctament
            {
                include 'main.php';
            }
        }
        else
        {
            include 'templates/login.php';        
        }
}
 */
?>