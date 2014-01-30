<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
    <head>
        <title>CAU - EASDIB 1.0</title>
        <!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>-->
        <!-- Fit the screen for mobile devices -->
        <meta id="meta" name="viewport" content="width=device-width; initial-scale=1.0" /> 
        <link rel="stylesheet" type="text/css" href="../css/signup.css"/>	
        <script src="js/ajax.js"></script>
    </head>
    <body>
        <div id="login-header">CAU - EASDIB</div>
        <div id="signup-fields">
            <form id="signup-form" name="signupForm" method="post" action="index.php?pg=signupCheck">
                <div class="row">
                    <input name="name" type="text" autofocus="autofocus"
                           placeholder="Nom" value="<?php echo $name ?>"/> 
                </div>
                <div class="row">
                    <input name="surname" type="text"
                           placeholder="Llinatges" value="<?php echo $surname ?>"/> 
                </div>
                <div class="row">
                    <input id="email" name="email" type="text"
                           placeholder="Nom usuari" value="<?php echo $email ?>"/>
                    <span id="domainname">@escoladisseny.com</span>
                </div>
                <div class="row">
                    <input placeholder="Contrasenya" id="password" name="password"/>
                </div>
                <div class="row">
                    <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
                </div>
                <div class="row" id="captcha_code">
                    <span style='font-size: 1.3em;'>Escriu el text CAPTCHA:</span>
                    <input type="text" name="captcha_code" size="10" maxlength="6" />
                </div>
                <div class="row">
                    <a href="#" 
                       onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
                </div>    
                <div class="row" id="login_button">
                    <button type="submit">Acceptar</button>
                </div>
                <span style='color:red; font-size:1.4em; padding-left: 10px'>
<?php               echo getSignUpError($error);   ?>
                </span>
            </form>	
        </div>
    </body>
</html>