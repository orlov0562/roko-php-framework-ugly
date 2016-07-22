<?php
    // define global constants
    define('ROOT_DIR', dirname(dirname(__FILE__)));
    define('APP_DIR', ROOT_DIR.'/app');
    define('WEB_DIR', ROOT_DIR.'/web');
    define('ROKO_DIR', dirname(__FILE__));
    define('APP_NAMESPACE', 'App');

    // Include roko autoload
    require_once ROKO_DIR.'/autoload.php';

    // Include composer autoload
    require_once ROOT_DIR.'/vendor/autoload.php';

    // Include Flight framework configuration
    require_once ROKO_DIR.'/flight.php';

