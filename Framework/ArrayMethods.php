<?php
namespace Framework
{
    class ArrayMethods
    {
        private function __construct() {
        // do nothing
        }
        private function __clone() {
        // do nothing
        }
        public static function clean($array) {
            // array_filter — Filters elements of an array using a callback function
            // font: php.net
            return array_filter( $array, function($item) {
                                           return !empty($item);
                                         });
        }
        
        public static function trim($array)
        {
            // array_map — Applies the callback to the elements of the given arrays
            // font: php.net
            return array_map( function($item) {
                                return trim($item);
                              }, $array);
        }
    }
}
?>