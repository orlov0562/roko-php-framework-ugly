<?php
    namespace Roko\Core;

    use Roko\Helper\Arr;

    class DataModel {
        use RegistryTrait;

        public function __construct($data=[]){
            $this->setData($data);
        }
        public function setData($data=[]) {
            if (is_array($data)) {
                $this->_data = $data;
            }
        }

        public function get($varPath, $default=null) {
            return Arr::getArrValByVarPath($this->_data, $varPath, $default);
        }

        public function set($varPath, $val) {
            return Arr::setArrValByVarPath($this->_data, $varPath, $val);
        }
    }
