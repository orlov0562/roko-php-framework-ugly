<?php
    namespace Roko\Helper;
    use Flight;

    class Url {

        public static function base(){
            return Flight::request()->base;
        }

        public static function home(){
            return Flight::request()->base;
        }

        public static function current(){
            return Flight::request()->url;
        }

        public static function url($url=null){

            if (preg_match('~^(https?|\#)~i', $url)) {
                $ret = $url;
            } elseif ($url) {
                $ret = Flight::request()->base.'/'.ltrim($url,'/');
            } else {
                $ret = Flight::request()->base;
            }

            return $ret;
        }

        public static function assets($url=null){
            return self::url('media/assets/'.ltrim($url,'/'));
        }

        public static function dist($url=null){
            return self::url('media/dist/'.ltrim($url,'/'));
        }

        public static function bower($url=null){
            return self::dist('bower_components/'.ltrim($url,'/'));
        }

        public static function match($path, $controllerPrefix='') {
            $currentPath = Flight::get('controller').'/'.Flight::get('action');

            if ($controllerPrefix) {
                $currentPath = Flight::get('controller_prefix').'_'.$currentPath;
                $path = rtrim($controllerPrefix,'_').'_'.$path;
            }

            return $path == $currentPath;
        }

    }

