<?php
namespace Roko\Helper\Validator;

class Recaptcha
{
    public static function validate(string $secretKey, string $recaptchaResponse):bool {
        $ret = false;

        if ($recaptchaResponse) {
            $captchaUrl = 'https://www.google.com/recaptcha/api/siteverify'
                            .'?'.http_build_query([
                                    'secret'   => $secretKey,
                                    'response' => $recaptchaResponse,
                                    'remoteip' => $_SERVER['REMOTE_ADDR'],
                            ])
            ;
            $data = json_decode(file_get_contents($captchaUrl));

            $ret = (isset($data->success) && $data->success != true);
        }

        return $ret;
    }
}
