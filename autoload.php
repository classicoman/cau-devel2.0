<?php

function autoload($class)
{
    //Obtenim un array amb els directoris on podem anar a cercar les classes
    $paths = explode( PATH_SEPARATOR, get_include_path() );
    //BUG: això no s'empra!
    $flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE;
    //MOLT IMPORTANT: El nom de la classe
    $file = strtolower(str_replace("\\", DIRECTORY_SEPARATOR, trim($class, "\\"))).".php";
    foreach ($paths as $path)
    {
        $combined = $path.DIRECTORY_SEPARATOR.$file;
        if (file_exists($combined))
        {
//            echo "<$combined>";
            include($combined);
            return;
        }
    }
    throw new Exception("No he trobat la classe: {$class}: autoload(\$class)");
}
/*
class Autoloader
{
    public static function autoload($class)
    {
        autoload($class);
    }
}
 */
?>