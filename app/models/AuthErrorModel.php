<?php

namespace App\Model;

use ORM;

class AuthErrorModel {
    private static $_table = 'roko_auth_errors';

    public static function getCountByIp(string $ip):int {
        $ret = 0;
        $item = ORM::for_table(self::$_table)->where(['ip'=>$ip])->find_one();
        if ($item) {
            $ret = $item->errors;
        }
        return $ret;
    }

    public static function incCountByIp(string $ip) {
        $item = ORM::for_table(self::$_table)->where(['ip'=>$ip])->find_one();
        if (!$item) {
            $item = ORM::for_table(self::$_table)->create();
            $item->ip = $ip;
        }
        $item->errors = $item->errors + 1;
        $item->save();
    }

    public static function resetCountByIp(string $ip) {
        $item = ORM::for_table(self::$_table)->where(['ip'=>$ip])->find_one();
        if ($item) {
            $item->delete();
        }
    }

    public static function get_orm(){
        return ORM::for_table(self::$_table);
    }
}

