<?php

    define('ENV', 'DEV'); // DEV or PROD

    require_once dirname(__FILE__).'/roko/bootstrap-cli.php';

    Flight::start();