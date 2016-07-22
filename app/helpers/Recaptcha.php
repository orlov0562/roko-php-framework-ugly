<?php

namespace App\Helper;

use Flight;
use Roko\Helper\FormBS;
use Roko\Helper\Validator\Recaptcha as RecaptchaValidator;

class Recaptcha {
    public static function validate() {
        $ret = false;
        $response = Flight::_post('g-recaptcha-response');
        if ($response) {
            if (RecaptchaValidator::validate(Flight::cfg('recaptcha.secretkey'), $response)) {
                $ret = true;
            }
        }
        return $ret;
    }

    public static function render($labelText='Captcha') {
        return FormBS::recaptcha($labelText, Flight::cfg('recaptcha.sitekey'));
    }
}

