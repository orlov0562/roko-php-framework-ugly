<?php
    namespace Roko\Core;

    class Session {

        public function __get($var) {
            $this->start_session();
            return array_key_exists($var, $_SESSION)
                   ? $_SESSION[$var]
                   : null
            ;
        }

        public function __set($var, $val) {
            $this->start_session();
            $_SESSION[$var] = $val;
        }

        public function __unset($var) {
            $this->start_session();
            if (array_key_exists($var, $_SESSION)) {
                unset($_SESSION[$var]);
            }
        }

        public function __isset($var) {
            $this->start_session();
            return isset($_SESSION[$var]);
        }

        public function start_session(){
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }

    }