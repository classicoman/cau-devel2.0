<?php
require_once '_basic.php';
require_once 'model/Tables.php';
$tables = new Tables();

function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));;
}

$error = 0;
/* VALIDAR CAPTCHA */    
/* Necessari per a que funcioni el codi de la Captcha, seguint indicacions
 * de http://www.phpcaptcha.org/documentation/quickstart-guide/ */

//Captcha.
include_once 'securimage/securimage.php';
//Object Securimage
$securimage = new Securimage();
//Comprova si l'usuari ha escrit el codi Captcha
if ($securimage->check($_POST['captcha_code']) == false) {  $error = 1;  }

/*Validar Formulari*/

//Si el Password és massa curt...
if (strlen($_POST["password"]) < 5)
    $error = 2;      

// Define variables and set to empty values
$email   = test_input($_POST["email"]);
$surname = test_input($_POST["surname"]);
$name    = test_input($_POST["name"]);

if ($email=="")     $error = 3;
if ($surname=="")   $error = 4;
if ($name=="")      $error = 5;

if (!$error)
{
    // Check if the username is already in use
    $sql = "SELECT id FROM members WHERE username= :email";
    if ( !dbIsQueryResultNull( $tables->executaQuery($sql, array('email'), array($email)) ) )
       $error = 6;
    else {
        //Open emails file
        $handle = fopen("files/emails.txt", "r");
        if ($handle) {
            //Look for user in the table
            $trobat=false;
             while (($line = fgets($handle)) !== false) {
                /* Test_input elimina la porquerieta d'inici i final de linia */
                if (test_input($line) == $email."@escoladisseny.com") {
                    $trobat=true;
                    break;
                }
            }
            if ($trobat) {  
                // // Email introduit és correcte -> donar d'alta user
                // Donar d'alta usuari en BDD
                $encPswd = crypt($_POST["password"]);
                $sql  = "INSERT INTO members(username,password,blocked,type) ";
                $sql .= "VALUES ('$email','$encPswd',0,'Vo')";
                $result = $tables->executaQuery($sql);
                
                // Fill the email fields.
                $direccio = "$email@escoladisseny.com";
                $subject = "Les teves dades accés a web d'enviament d'incidències";
                $message = "<html><body>"
                       ."<h1>Acc&eacute;s a l'aplicaci&oacute; d'enviament d'incid&egrave;ncies <a href='http://cau.easdib.com'>http://cau.easdib.com</a></h1>"
                    ."<h2>Dades d'acc&eacute;s</h2>"   
                    ."<ul><li>Usuari: <b>".$email."</b></li><li> Contrasenya: <b>".$_POST['password']."</b></li></ul>"
                    ."<h2>Com funciona?</h2>"
                    ."<p style:'font-family: Helvetica; font-size:13px;'>"
                    ."Aquesta web ha estat dissenyada per a que els professors de l'EASDIB hi pogueu accedir des del vostre "
                    ."tel&egrave;fon m&ograve;bil i pogueu enviar incid&egrave;ncies inform&agrave;tiques a Suport Inform&agrave;tic (Toni Amengual)</p>"
                    ."<p>A m&eacute;s de crear una nova <strong>Incid&egrave;ncia</strong> i consultar les que tingueu pendent de resoluci&oacute;, l'aplicaci&oacute; "
                    ."tamb&eacute; vos permet escriure <strong>Comentaris</strong> sobre una incid&egrave;ncia <strong>oberta</strong>. Tamb&eacute; podeu <strong>tancar</strong> "
                    ."una incid&egrave;ncia si trobau que el problema ha estat resolt.</p>"
                    ."<p>Els comentaris que l'administrador vos envi&iuml; sobre les incid&egrave;ncies les rebreu "
                    ."puntualment a la vostra adre&#231;a de correu electr&ograve;nic.</p>"
                    ."<p>Per a qualsevol suggeriment o cr&iacute;tica (constructiva ;), enviau-me un correu a informatic@escoladisseny.com. Gr&agrave;cies</p>"
                    ."<br><p>Toni Amengual</p>"
                    . "</body></html>";
                $headers =  "From:norespongueu@easdib.com\r\n" 
                        . "MIME-Version: 1.0\r\n"
                        ."Content-Type: text/html; charset=ISO-8859-1\r\n";
                //Send the email
                mail($direccio, $subject, $message,$headers);
                
                //Set Session Username.
                session_start();
                $_SESSION['myusername'] = $email;
                
                //Creo una cookie amb el nom d'usuari. Aquesta cookie s'enviarà al browser amb la primera pàgina de contingut. Després, cada vegada que l'usuari
                //demani la  pagina main.php durà la cookie establerta.
                $value = 'OK';
                setcookie("usuari", $value, time() + 3600);  /* expire in 1 hour   xxxtoni*/
            } else  {
                $error = 7;
            }
        } else {
            echo "Error Opening the File";  //xxx toni Errors que he de tabular.
        }
    }
}
?>