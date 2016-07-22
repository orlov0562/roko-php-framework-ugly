<?php
namespace App\Helper;
use Flight;
use App\Model\AuthErrorModel;
use App\Model\UserModel;

class Auth
{
    public static function isLoggedUser(){
        return !empty(Flight::session()->user);
    }

    public static function redirectToLoginPage(){
        Flight::redirect('admin/auth');
        Flight::stop();
    }

    public static function login(\stdClass $user, $remember=false) {
        Flight::session()->user = $user;
        if ($remember) {
            Auth::setRememberToken($user);
        }
        Flight::redirect('admin');
        Flight::stop();
    }

    public static function logout(){
        unset(Flight::session()->user);
        unset(Flight::cookie()->remember_token);
        Flight::redirect('admin/auth');
        Flight::stop();
    }

    public static function needToShowRecaptcha(){
        $ret = false;
        if (Flight::cfg('recaptcha.active')) {
            $ip = Flight::request()->ip;
            $errCount = AuthErrorModel::getCountByIp($ip);
            $errLimit = Flight::cfg('auth.show_captcha_after_errors');
            $ret = ($errCount >= $errLimit);
        }
        return  $ret;
    }

    public static function incErrors(){
        $ip = Flight::request()->ip;
        AuthErrorModel::incCountByIp($ip);
    }

    public static function resetErrors() {
        $ip = Flight::request()->ip;
        AuthErrorModel::resetCountByIp($ip);
    }

    public static function setRememberToken($user) {
        $token = self::generateRememberToken([$user->username, $user->password]);
        Flight::cookie()->remember_token = $token;
    }

    public static function generateRememberToken(array $tokenData):string {
        return md5(serialize($tokenData));
    }

    public static function loginByRememberToken() {
        $ret = false;
        if (Flight::cfg('auth.allow_login_by_remember_token')) {
            $token = Flight::cookie()->remember_token;
            if ($token) {
                $user = UserModel::getUserByRememberToken($token);
                if ($user) {
                    Flight::session()->user = $user;
                    $ret = true;
                }
            }
        }
        return $ret;
    }

}
