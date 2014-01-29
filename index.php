<?php
session_start();
$session = (isset($_SESSION['myusername'])) ?   true  :  false;

require_once '_basic.php';

//Has the session been started?
if ($session)
    include 'main.php'; 
else {
    if ($_GET['pg']=="signup") {        
        include 'templates/signup.php';    
    } 
    else 
        if ($_GET['pg']=='signupCheck') {
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
?>