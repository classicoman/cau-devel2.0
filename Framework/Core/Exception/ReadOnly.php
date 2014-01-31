<?php
namespace Framework {

    // Extendre Excepcions
    // http://www.php.net/manual/en/language.exceptions.extending.php

    class Readonly extends Exception {

        // Redefine the exception so message isn't optional
        public function __construct($message, $code = 0, Exception $previous = null) {
            // some code

            // make sure everything is assigned properly
            parent::__construct($message, $code, $previous);
        }
    }
}
?>