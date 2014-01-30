<?php
namespace Framework {
    class StringMethods {
        private static $_delimiter = "#";
        private function __construct() {
            //nofares
        }
        private function __clone() {
            //nofares
        }
        private static function _normalize($pattern) {
            //Fa que el pattern quedi net i tengui davant i darrere un sol delimitador "#"
            return self::$_delimiter . trim($pattern, self::$_delimiter) . self::$_delimiter;
        }
        //Getter
        public static function getDelimiter() {
            return self::$_delimiter;
        }
        //Setter
        public static function setDelimiter($delimiter) {
            self::$_delimiter = $delimiter;
        }
        
        public static function match($string, $pattern)
        {     
            //Calcula si hi ha match del $string amb el patró (regex) $pattern i
            //torna els resultats a $matches[0]. $matches[1] conté els resultats
            //de la primera expressió entre parèntesi que $pattern conté
            preg_match_all(self::_normalize($pattern), $string, $matches, PREG_PATTERN_ORDER);
            if (!empty($matches[1])) {
                return $matches[1];
            }
            if (!empty($matches[0])) {
                return $matches[0];
            }
            return null;
        }
        
        public static function split($string, $pattern, $limit = null)
        {
            $flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE;
            return preg_split(self::_normalize($pattern), $string, $limit, $flags);
        }
    }
} 

?>