<?php
session_start();

require_once '../model/Tables.php';
$tables = new Tables();

/* username and password sent from form are cleaned to avoid MySQL injection - 
 * stripslashes substitutes the deprecated mysql_real_escape_string */
$myusername = stripslashes($_POST['myusername']);
$mypassword = stripslashes($_POST['mypassword']);

$cancela = false;

//Get the User - using PREPARED STATEMENT!
$sql = "SELECT blocked, password FROM members WHERE username= :username";
$row = $tables->getFirstRow( $sql, array('username'), array($myusername) );

/** Control the number of ATTEMPTS the user has to start the session
 * http://www.dreamincode.net/forums/topic/286198-simple-login-page-with-only-3-password-attempts/ */
if ($row['blocked']==1) {
    echo "THIS USER IS BLOCKED AND CAN'T START SESSION. CONTACT THE ADMIN.";
    $cancela = true;
} 
 else {
    if (isset($_SESSION['attempts'])) {
        if ($_SESSION['attempts'] == 5) 
        {
            /** BLOCK THE USER  **/
            $sql = "UPDATE members SET blocked='1' WHERE username= :username";
            $res = $tables->executaQuery( $sql, array('username'), array($username) );
            echo "THE USER HAS COMPLETED 3 ATTEMPTS AND HAS BEEN BLOCKED. CONTACT THE ADMIN.";
            $cancela = true;
        } 
        else {
            //Increment number of attempts.
            $_SESSION['attempts'] = $_SESSION['attempts'] + 1;            
        }
    } else {
        //Set number of attempts to 1
        $_SESSION['attempts'] = 1;
    }    
}

$encriptada = $row['password'];

// Si la contrasenya és correcta...
if (  (crypt($mypassword, $encriptada) == $encriptada) && !$cancela ) {
    //L'usuari ha passat el filtre CAP A LA SEGÜENT PAGINA
    // http://stackoverflow.com/questions/1340001/deny-direct-access-to-all-php-files-except-index-php
    //Set Session Username.
    $_SESSION['myusername'] = $myusername;
    //Creo una cookie amb el nom d'usuari. Aquesta cookie s'enviarà al browser amb la primera pàgina de contingut. Després, cada vegada que l'usuari
    //demani la  pagina main.php durà la cookie establerta.
    setcookie("usuari", "OK", time() + 3600);  /* expire in 1 hour */
    /* El codi és incomplet, he de controlar que aquest usuari té una sessió oberta..
     *  no se com fer-ho mirar més codi...!! */
    
}
?>
<?php   if (!$cancela)   
    header('location:../index.php');
?>