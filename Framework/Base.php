<?php

namespace Framework
{
    use Framework\Inspector as Inspector;
    use Framework\ArrayMethods as ArrayMethods;
    use Framework\StringMethods as StringMethods;
    use Framework\Core\Exception as Exception;
    
    class Base
    {
        private $_inspector;
        public function __construct($options = array())
        {
            $this->_inspector = new Inspector($this);
            if (is_array($options) || is_object($options))
            {
                foreach ($options as $key => $value)
                {
                    $key = ucfirst($key);
                    $method = "set{$key}";
                    $this->$method($value);
                }
            }
        }
    }
}


?>