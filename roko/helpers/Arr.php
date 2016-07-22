<?php
    namespace Roko\Helper;

    class Arr {
        public static function getArrValByVarPath(array $arr, $varPath=null, $default=null) {
            $ret = $default;
            if (!$varPath) {
                $ret = $arr;
            } elseif(strpos($varPath,'.')===FALSE) {
                return array_key_exists($varPath,$arr) ? $arr[$varPath] : $default;
            } else {
                $path = explode('.', $varPath);
                foreach($path as $var) {
                    if ( is_array($arr) && array_key_exists($var,$arr)) {
                        $ret = $arr = $arr[$var];
                    } else {
                        $ret = $default;
                        break;
                    }
                }
            }
            return $ret;
        }

        public static function getArrValByVarPathStrict(array $arr, $varPath=null) {
            if (!$varPath) {
                $ret = $arr;
            } elseif(strpos($varPath,'.')===FALSE) {
                if (array_key_exists($varPath,$arr)) {
                    $ret = $arr[$varPath];
                } else {
                    throw new \Exception('Value for ['.$varPath.'] not found');
                }
            } else {
                $path = explode('.', $varPath);
                foreach($path as $var) {
                    if ( is_array($arr) && array_key_exists($var,$arr)) {
                        $ret = $arr = $arr[$var];
                    } else {
                        throw new \Exception('Value for ['.$varPath.'] not found');
                    }
                }
            }
            return $ret;
        }

        public static function setArrValByVarPath(array $arr, $varPath, $val) {
            $path = explode('.',$varPath);
            if (count($path)==1) {
                $arr[$path[0]] = $val;
            } else {
                $tmp = $val;
                for($i=count($path)-1; $i>=1; $i--) {
                    $tmp = [ $path[$i] => $tmp ];
                }
                $arr[$path[0]] = $tmp;
            }
            return $arr;
        }
    }