<?php
    use Roko\Helper\Url;
    use Roko\Helper\Html;

    $items = [
        [['','Home',['icon'=>'home']], Url::match('index/index')],
        [['about','About',['icon'=>'info-circle']], Url::match('index/about')],
        [['admin','Admin panel',['icon'=>'sign-in']]],
        [['http://github.com/orlov0562','Repository',['target'=>'_blank', 'icon'=>'github']]],
    ];

    echo Html::menu($items, ['class'=>'nav nav-pills nav-stacked']);
?>