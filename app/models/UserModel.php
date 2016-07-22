<?php

namespace App\Model;

use Flight;
use App\Helper\Auth;

class UserModel {

    public static function getUser(string $username, string $password) {
        $ret = false;
        $users = Flight::cfg('users');
        foreach($users as $user) {
            if ($user['username'] == $username && $user['password'] == $password) {
                $ret = (object) $user;
                break;
            }
        }
        return $ret;
    }

    public static function getUserByRememberToken($token) {
        $ret = false;
        $users = Flight::cfg('users');
        foreach($users as $user) {
            $userToken = Auth::generateRememberToken([$user['username'], $user['password']]);
            if ($userToken==$token) {
                $ret = (object) $user;
                break;
            }
        }
        return $ret;
    }
}
