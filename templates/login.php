<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
    <head>
        <title>CAU - EASDIB 1.0</title>
        <!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>-->
        <!-- Fit the screen for mobile devices -->
        <meta id="meta" name="viewport" content="width=device-width; initial-scale=1.0" /> 
        <link rel="stylesheet" type="text/css" href="css/login.css"/>   <!-- CSS for the Login Screen -->	
        <script src="js/ajax.js"></script>	<!-- Ajax functions -->
    </head>
    <body>
        <div id="login-header">CAU - EASDIB 1.0</div>
        <div id="login-fields">
            <form id="login-form" name="userCheck" method="post" action="controllers/logincheck.php">
                <div class="row">
                    <div class="label"> Usuari: </div>
                </div>
                <div class="row">
                    <div class="input">
                        <input name="myusername" type="text" id="myusername" autofocus="autofocus"/>
                    </div>
                </div>
                <div class="row">
                    <div class="label"> Password:</div>
                </div>
                <div class="row">
                    <div class="input">
                        <input name="mypassword" type="password" id="mypassword"/>
                    </div>
                </div>
                <div class="links"><a href="index.php?pg=signup"> Registra't</a></div>
                <div class="links"><a href="#">Has oblidat la contrasenya?</a></div>
                <div id="login_button">
                    <input type="submit" name="Submit" value="Login"/>
                </div>
            </form>	
        </div>
    </body>
</html>