<?php
    use App\Helper\Auth;
    use Roko\Helper\Html;
    use Roko\Helper\Url;

    $items = [];

    if (Auth::isLoggedUser()) {
        $items[] = [['admin','Home',['icon'=>'home']], Url::match('index/index')];
        $items[] = [['admin/index/autherr','Auth errors',['icon'=>'file-o']], Url::match('index/autherr')];
    }

    $items[] = [['','Back to site',['icon'=>'sign-in']]];

    if (Auth::isLoggedUser()) {
        $items[] = [['admin/auth/logout','Exit',['icon'=>'lock', 'class'=>'red']]];
    }

    echo Html::menu($items, ['class'=>'nav nav-pills nav-stacked']);
