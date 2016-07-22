<?php
    namespace Roko\Core;

    class Cookie {

        public function __get($var) {
            return array_key_exists($var, $_COOKIE)
                   ? $_COOKIE[$var]
                   : null
            ;
        }

        public function __set($var, $val) {
            $this->set($var, $val);
        }

        public function __unset($var) {
            $this->del($var);
        }

        public function set($var, $val, $expiration=31536000, $path='/') { // 365 days = 365 * 24 * 60 * 60 = 31536000
            $date_of_expiry = time() + $expiration;
            setcookie($var, $val, $date_of_expiry, $path);
            $_COOKIE[$var] = $val;
        }

        public function del($var, $path='/') {
            if (array_key_exists($var, $_COOKIE)) {
                setcookie($var, null, time() - 60, $path);
                unset($_COOKIE[$var]);
            }
        }

        public function __isset($var) {
            return isset($_COOKIE[$var]);
        }

    }