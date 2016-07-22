 <?php

    define('ENV', 'DEV'); // DEV or PROD

    require_once dirname(dirname(__FILE__)).'/roko/bootstrap.php';

    Flight::start();
