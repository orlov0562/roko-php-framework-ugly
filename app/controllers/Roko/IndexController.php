<?php

namespace App\Controller;

class Cron_IndexController {
    public function indexAction($a=0){
        echo 'Cron controller :: Index action('.$a.')'.PHP_EOL;
    }
}