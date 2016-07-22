<?php

namespace App\Controller;

use App\Helper\Auth;

class Base_Backend_AuthTemplateController extends Base_Backend_TemplateController
{
    public function before() {
        if (!Auth::isLoggedUser()) {
            if (!Auth::loginByRememberToken()) {
                Auth::redirectToLoginPage();
            }
        }
    }
}
