<?php
/**
 * Description of DB
 *
 * @author toni
 */
class DB {
    var $database_target = "localhost";
/*    
    var $database_name  = "fenix9_inventory";
    var $username       = "root";
    var $password       = "usbw";
*/
    var $database_name  = "ngckybrh_inventory";
    var $username       = "ngckybrh_invento";
    var $password       = "qwert098yhn";
    
    private $dbh;  //DataBase Object
    private $isDBConnected;  // 1 if the Database is connected
    
    function __constructor() {
        $this->dbh = (isset($GLOBALS['dbh']))  ?  $GLOBALS['dbh']  :  0;
        $this->isDBConnected = isset($GLOBALS['database_connected']) ? 1 : 0;
    }
    
    function isDBConnected() {
        if ($this->isDBConnected)
            return true;
        else
            return false;
    }
    
    function connecta() 
    {    
        if (!$this->isDBConnected())
        {
            $dbConnString = "mysql:host=" . $this->database_target . "; dbname=" . $this->database_name;
            try {
                $this->dbh = new PDO($dbConnString, $this->username, $this->password);
                $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } 
            catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
                $error = $this->dbh->errorInfo();
                if($error[0] != "") {
                    print "<p>DATABASE CONNECTION ERROR:</p>".$error;
                }
            }
            //Set the connection Object in $GLOBALS variable
            $GLOBALS['dbh'] = $this->dbh;
            $GLOBALS['database_connected']=1;
        }
    }
    
    
    function close() {
        $this->dbh = NULL;
    }

    
    /* Execute a Query in the database. */
    function executaQuery($queryString, $fields=null, $values=null) {
        //Connect to the DataBase
        $this->connecta();
        try {
            if ($fields!=null) {
                $params = array();
                for ($i=0; $i<count($fields); $i++) {
                    $params[ $fields[$i] ] = $values[$i];
                }
                $rows = $this->dbh->prepare($queryString);
                $rows->execute($params);
            } else {
                $rows = $this->dbh->query($queryString);
            }
        } 
        catch (PDOException $err) {
            //echo "<p>Error en executar Query, DB.php:  <i>".$err."</i></p><p>".$queryString."</p>";
            exit;
        }
        return $rows;
    }
}