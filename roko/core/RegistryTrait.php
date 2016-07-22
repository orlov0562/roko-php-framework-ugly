<?php

namespace Roko\Core;

trait RegistryTrait {
    protected $_data = [];

    public function __get($var){
        return isset($this->_data[$var]) ? $this->_data[$var] : null;
    }

    public function __set($var, $val){
        $this->_data[$var] = $val;
    }

    public function __isset($var){
        return isset($this->_data[$var]);
    }

    public function __unset($var){
        unset($this->_data);
    }

}