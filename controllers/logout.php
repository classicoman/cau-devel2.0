<?php
   session_start();
   if (isset($_SESSION['myusername']))  {
       unset($_SESSION['myusername']);
   }
   
   session_destroy();

   //Back to index page
   header("location:index.php");
?>